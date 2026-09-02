/**
 * Canonical article URLs.
 *
 * Articles live at the site root with a trailing slash: /<slug>/. This is the
 * one place that pattern is written on the browser side — every <Link>, every
 * absolute URL handed to agents and the header's active-tab check build the
 * path from the slug here, so a stored "/blog/<slug>" value can never leak
 * back into the markup. The build/server side mirrors the same rule in
 * src/utils/seoMeta.cjs (articleUrl), src/utils/jsonLd.cjs,
 * scripts/gen-seo-assets.mjs and src/worker.js.
 */

import { blogsData } from '../data/blogs_data';
import { liveBlogUpdates } from '../data/live_blog_updates';

function cleanSlug(slug) {
  return String(slug || '').trim().replace(/^\/+|\/+$/g, '');
}

/** "/<slug>/" — the site-relative canonical path for an article. */
export function articlePath(slug) {
  return `/${cleanSlug(slug)}/`;
}

// Slugs bundled with the site. Posts published later through the admin panel
// are not in this set; BlogPost resolves those against Supabase at runtime.
const STATIC_ARTICLE_SLUGS = new Set(
  [...liveBlogUpdates, ...blogsData].map((post) => post && post.slug).filter(Boolean),
);

export function isStaticArticleSlug(slug) {
  return STATIC_ARTICLE_SLUGS.has(cleanSlug(slug));
}

/** True for "/<slug>" or "/<slug>/" when <slug> is a bundled article. */
export function isArticlePath(pathname) {
  const segments = String(pathname || '').split('/').filter(Boolean);
  return segments.length === 1 && STATIC_ARTICLE_SLUGS.has(segments[0]);
}
