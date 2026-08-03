/**
 * Post-build prerenderer.
 *
 * `vite build` ships an empty shell — every page is just <div id="root"></div>,
 * so "View page source" (and any crawler or AI agent that does not run JS) sees
 * no content at all. This script renders each route with react-dom/server and
 * bakes the resulting markup into build/<route>/index.html.
 *
 * Routes come from build/sitemap.xml, so anything we advertise to search
 * engines is guaranteed to be prerendered — the two can never drift.
 *
 * Run after `vite build` and after scripts/inject-seo-tags.mjs:
 *   node scripts/prerender.mjs
 */

import { existsSync, mkdirSync, readFileSync, rmSync, writeFileSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath, pathToFileURL } from 'node:url';

import { build } from 'vite';

import { getMetaForPath, escapeHtml, stripExistingSeoTags, buildSeoTags } from '../src/utils/seoMeta.cjs';
import { buildJsonLd } from '../src/utils/jsonLd.cjs';

const __dirname = dirname(fileURLToPath(import.meta.url));
const ROOT = join(__dirname, '..');
const BUILD_DIR = join(ROOT, 'build');
const SSR_DIR = join(ROOT, '.prerender');
const ROOT_INDEX = join(BUILD_DIR, 'index.html');

// The empty mount point vite emits. Prerendered markup goes inside it.
const ROOT_MARKER = '<div id="root"></div>';

// Doctor profiles are linked from /doctors but intentionally kept out of the
// sitemap. They still need files so they do not 404 (see readRoutes).
//
// They also get noindex. Excluding a URL from the sitemap does not stop Google
// indexing it — it was still crawlable from /doctors and still indexable, so
// the exclusion expressed an intent the markup never enforced. These are
// placeholder personas rather than named practitioners at this clinic, and an
// indexable staff profile that does not correspond to a real doctor is an
// E-E-A-T liability on a medical site. "follow" is kept so the internal links
// on those pages still pass value.
const EXTRA_ROUTES = [
  '/doctors/dr-emily-walker',
  '/doctors/dr-olivia-bennett',
  '/doctors/dr-sussie-wolff',
  '/doctors/dr-ethan-williams',
];

const NOINDEX_ROUTES = new Set(EXTRA_ROUTES);

// Client-only routes that must resolve but must never be prerendered or
// indexed. They get the empty shell plus a noindex tag.
const SHELL_ONLY_ROUTES = ['/admin'];

if (!existsSync(ROOT_INDEX)) {
  console.error('[prerender] build/index.html not found — run vite build first.');
  process.exit(1);
}

// ─── Routes ────────────────────────────────────────────────────────────────

function readRoutes() {
  const sitemapPath = [join(BUILD_DIR, 'sitemap.xml'), join(ROOT, 'public/sitemap.xml')].find(existsSync);

  if (!sitemapPath) {
    console.error('[prerender] sitemap.xml not found — run scripts/gen-seo-assets.mjs first.');
    process.exit(1);
  }

  const xml = readFileSync(sitemapPath, 'utf8');
  const routes = [];
  const seen = new Set();

  for (const match of xml.matchAll(/<loc>([^<]+)<\/loc>/g)) {
    let path;
    try {
      path = new URL(match[1]).pathname;
    } catch {
      continue;
    }
    if (seen.has(path)) continue;
    seen.add(path);
    routes.push(path);
  }

  // Public routes that are deliberately absent from the sitemap but must still
  // exist as files: not_found_handling = "404-page" in wrangler.toml means
  // anything without a file returns a real 404, and these are real pages.
  for (const path of EXTRA_ROUTES) {
    if (seen.has(path)) continue;
    seen.add(path);
    routes.push(path);
  }

  return routes;
}

// ─── SEO head ──────────────────────────────────────────────────────────────

/**
 * Rewrite the head for a route: title, description, canonical, OG/Twitter tags
 * and the JSON-LD graph. The tag block itself is built in seoMeta.cjs so this
 * and src/worker.js cannot drift.
 *
 * This runs for EVERY route, not just pages created from the shell. On
 * Cloudflare static assets are served without invoking the Worker, so anything
 * the Worker would have injected at runtime — JSON-LD in particular — only
 * reaches visitors if it is baked in here at build time.
 */
function withSeoHead(html, route) {
  const meta = getMetaForPath(route);
  const parts = [buildSeoTags(route), buildJsonLd(route)];

  if (NOINDEX_ROUTES.has(route)) {
    parts.unshift('<meta name="robots" content="noindex, follow">');
  }

  return stripExistingSeoTags(html)
    .replace(/<title>[^<]*<\/title>/, `<title>${escapeHtml(meta.title)}</title>`)
    .replace('</title>', `</title>\n    ${parts.join('\n    ')}`);
}

// ─── Build the SSR bundle ──────────────────────────────────────────────────

async function buildSsrBundle() {
  rmSync(SSR_DIR, { force: true, recursive: true });

  await build({
    build: {
      ssr: 'src/entry-server.jsx',
      outDir: '.prerender',
      emptyOutDir: true,
      // Asset file names are content-hashed identically to the client build,
      // so image URLs in the prerendered markup resolve to real files.
      copyPublicDir: false,
    },
    logLevel: 'warn',
  });

  const entry = join(SSR_DIR, 'entry-server.js');
  if (!existsSync(entry)) {
    console.error(`[prerender] SSR bundle missing at ${entry}`);
    process.exit(1);
  }

  return import(pathToFileURL(entry).href);
}

// ─── Output sanity checks ──────────────────────────────────────────────────

/**
 * A component that resolves its content in an effect renders its empty/"not
 * found" branch on the server, so the page prerenders as a polished-looking
 * error. That is worse than no prerendering at all — it is what search engines
 * would index — and it fails silently, so check for it explicitly.
 */
const NOT_FOUND_MARKERS = [
  'Article Not Found',
  'Policy Page Not Found',
  'Doctor Profile Not Found',
  'This page does not exist',
];

// Header + footer chrome alone is roughly 1,400 characters. Anything near that
// rendered no page body.
const MIN_TEXT_LENGTH = 1500;

function visibleTextLength(markup) {
  return markup
    .replace(/<script[\s\S]*?<\/script>/gi, '')
    .replace(/<[^>]+>/g, ' ')
    .replace(/\s+/g, ' ')
    .trim().length;
}

function contentProblem(markup) {
  const marker = NOT_FOUND_MARKERS.find((m) => markup.includes(m));
  if (marker) return `rendered the "${marker}" branch`;

  const length = visibleTextLength(markup);
  if (length < MIN_TEXT_LENGTH) return `only ${length} characters of text — page body likely did not render`;

  return null;
}

// ─── Main ──────────────────────────────────────────────────────────────────

const routes = readRoutes();
console.log(`[prerender] building SSR bundle for ${routes.length} routes…`);

const { render } = await buildSsrBundle();
const shell = readFileSync(ROOT_INDEX, 'utf8');

// Keep a copy of the empty shell. Servers fall back to it for paths that were
// not prerendered (/admin, /doctors/:slug, 404s) so those never serve homepage
// markup under a different URL. See sendSpaPage() in server/render-server.cjs.
writeFileSync(join(BUILD_DIR, 'spa-shell.html'), shell);

let rendered = 0;
let created = 0;
const failures = [];

for (const route of routes) {
  const targetDir = route === '/' ? BUILD_DIR : join(BUILD_DIR, route.replace(/^\/+|\/+$/g, ''));
  const targetFile = join(targetDir, 'index.html');

  let appHtml;
  try {
    appHtml = render(route);
  } catch (error) {
    failures.push({ route, reason: error.message });
    continue;
  }

  if (!appHtml || !appHtml.trim()) {
    failures.push({ route, reason: 'renderer returned empty markup' });
    continue;
  }

  const problem = contentProblem(appHtml);
  if (problem) {
    failures.push({ route, reason: problem });
    continue;
  }

  // Always rewrite the head, whether the file came from inject-seo-tags.mjs or
  // is being created here. Baking the JSON-LD in is the only way it reaches
  // Cloudflare visitors, since assets are served without invoking the Worker.
  if (!existsSync(targetFile)) {
    mkdirSync(targetDir, { recursive: true });
    created++;
  }
  const html = withSeoHead(shell, route);

  if (!html.includes(ROOT_MARKER)) {
    failures.push({ route, reason: 'mount point <div id="root"></div> not found' });
    continue;
  }

  // The data attribute tells src/main.jsx that this markup belongs to this
  // route, so it can hydrate instead of throwing the markup away.
  writeFileSync(
    targetFile,
    html.replace(ROOT_MARKER, `<div id="root" data-prerendered-path="${route}">${appHtml}</div>`),
  );
  rendered++;
}

rmSync(SSR_DIR, { force: true, recursive: true });

// Client-only routes: emit the empty shell so they resolve instead of hitting
// not_found_handling, but never prerender their content and never let them be
// indexed. main.jsx sees no data-prerendered-path and client-renders.
for (const route of SHELL_ONLY_ROUTES) {
  const targetDir = join(BUILD_DIR, route.replace(/^\/+|\/+$/g, ''));
  mkdirSync(targetDir, { recursive: true });
  writeFileSync(
    join(targetDir, 'index.html'),
    shell.replace('</title>', '</title>\n    <meta name="robots" content="noindex, nofollow">'),
  );
}

console.log(
  `[prerender] prerendered ${rendered}/${routes.length} routes ` +
  `(${created} new index.html files, ${SHELL_ONLY_ROUTES.length} shell-only).`,
);

if (failures.length) {
  console.error(`[prerender] ${failures.length} route(s) failed:`);
  for (const { route, reason } of failures) console.error(`  ${route} — ${reason}`);
  process.exit(1);
}
