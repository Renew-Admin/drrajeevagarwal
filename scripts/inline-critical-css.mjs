// inline-critical-css — runs after prerender (health report item 8).
//
// For every prerendered page, Beasties inlines the CSS rules that match the
// page's own markup into <head> and turns the stylesheet <link>s into
// non-blocking loads (media="print" swapped to "all" on load, with a
// <noscript> fallback). First paint no longer waits for the eight
// /wp-styles/* files (the app's own index-*.css stays blocking, see below); the full files still load
// right after, so client-rendered parts (pop-ups, carousels) keep their styles.
import { readdirSync, readFileSync, statSync, writeFileSync } from 'node:fs';
import { join, relative } from 'node:path';
import { fileURLToPath } from 'node:url';
import Beasties from 'beasties';

const BUILD = join(fileURLToPath(new URL('..', import.meta.url)), 'build');

function* htmlFiles(dir) {
  for (const name of readdirSync(dir)) {
    const p = join(dir, name);
    if (statSync(p).isDirectory()) {
      if (name === 'assets' || name === 'wp-styles') continue;
      yield* htmlFiles(p);
    } else if (name === 'index.html') yield p;
  }
}

const beasties = new Beasties({
  path: BUILD,
  publicPath: '/',
  preload: 'media',     // <link media="print" onload="this.media='all'">
  noscriptFallback: true,
  inlineFonts: false,
  preloadFonts: false,
  pruneSource: false,   // the full files stay intact for later loading
  reduceInlineStyles: false,
  mergeStylesheets: true,
  compress: true,
  logLevel: 'warn',
});

// The app's own stylesheet (/assets/index-*.css) sits after the WordPress
// files and overrides them. If it loaded later than they did, the WordPress
// rules would win for a moment and the page would shift (CLS). So it stays a
// normal render-blocking link (small: ~9 KiB gzipped) and only the
// /wp-styles/* files and Google Fonts load in the background.
function keepAppStylesheetBlocking(html) {
  return html
    .replace(/(<link rel="stylesheet"[^>]*href="\/assets\/index-[^"]+\.css")\s+media="print"\s+onload="this\.media='all'"/g, '$1')
    .replace(/<noscript><link rel="stylesheet"[^>]*href="\/assets\/index-[^"]+\.css"[^>]*><\/noscript>/g, '');
}

let pages = 0;
let inlined = 0;
const started = Date.now();
for (const file of htmlFiles(BUILD)) {
  const html = readFileSync(file, 'utf8');
  if (!html.includes('rel="stylesheet"')) continue;
  // Shell-only routes (e.g. /admin) have no prerendered markup to match.
  if (/<meta name="robots" content="noindex, nofollow">/.test(html) && !html.includes('<div id="root"><')) continue;
  const out = keepAppStylesheetBlocking(await beasties.process(html));
  writeFileSync(file, out);
  pages += 1;
  inlined += Buffer.byteLength(out) - Buffer.byteLength(html);
}
console.log(`[critical-css] ${pages} pages processed in ${((Date.now() - started) / 1000).toFixed(1)}s; +${Math.round(inlined / pages / 1024)} KiB inline CSS per page on average (${relative(process.cwd(), BUILD)})`);
