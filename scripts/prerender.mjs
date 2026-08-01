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

import { getMetaForPath } from '../src/utils/seoMeta.cjs';

const __dirname = dirname(fileURLToPath(import.meta.url));
const ROOT = join(__dirname, '..');
const BUILD_DIR = join(ROOT, 'build');
const SSR_DIR = join(ROOT, '.prerender');
const ROOT_INDEX = join(BUILD_DIR, 'index.html');

// The empty mount point vite emits. Prerendered markup goes inside it.
const ROOT_MARKER = '<div id="root"></div>';

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

  return routes;
}

// ─── SEO head for routes we create from scratch ────────────────────────────

function escapeHtml(str) {
  return str
    .replace(/&/g, '&amp;')
    .replace(/"/g, '&quot;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;');
}

/**
 * Mirrors stripExistingSeoTags() in src/worker.js. Only used for pages we
 * create fresh from the homepage shell (blog posts), which would otherwise
 * inherit the homepage's canonical/description/OG tags.
 */
function stripExistingSeoTags(html) {
  return html
    .replace(/[ \t]*<meta[^>]*\sname=["']description["'][^>]*>\s*/gi, '')
    .replace(/[ \t]*<link[^>]*\srel=["']canonical["'][^>]*>\s*/gi, '')
    .replace(/[ \t]*<meta[^>]*\sproperty=["']og:[^"']*["'][^>]*>\s*/gi, '');
}

function withSeoHead(html, route) {
  const meta = getMetaForPath(route);
  const safeTitle = escapeHtml(meta.title);
  const safeDesc = escapeHtml(meta.description);
  const safeCanonical = escapeHtml(meta.canonicalUrl);

  const seoBlock = [
    `<meta name="description" content="${safeDesc}">`,
    `<link rel="canonical" href="${safeCanonical}">`,
    `<meta property="og:title" content="${safeTitle}">`,
    `<meta property="og:description" content="${safeDesc}">`,
    `<meta property="og:url" content="${safeCanonical}">`,
    `<meta property="og:type" content="website">`,
    `<meta property="og:site_name" content="Dr. Rajeev Agarwal">`,
  ].join('\n    ');

  return stripExistingSeoTags(html)
    .replace(/<title>[^<]*<\/title>/, `<title>${safeTitle}</title>`)
    .replace('</title>', `</title>\n    ${seoBlock}`);
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
const NOT_FOUND_MARKERS = ['Article Not Found', 'Policy Page Not Found', 'This page does not exist'];

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

  // Pages listed in scripts/inject-seo-tags.mjs already have the right head
  // tags. Anything else (blog posts) is created here from the homepage shell,
  // so its head has to be rewritten for this route.
  let html;
  if (existsSync(targetFile)) {
    html = readFileSync(targetFile, 'utf8');
  } else {
    html = withSeoHead(shell, route);
    mkdirSync(targetDir, { recursive: true });
    created++;
  }

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

console.log(`[prerender] prerendered ${rendered}/${routes.length} routes (${created} new index.html files).`);

if (failures.length) {
  console.error(`[prerender] ${failures.length} route(s) failed:`);
  for (const { route, reason } of failures) console.error(`  ${route} — ${reason}`);
  process.exit(1);
}
