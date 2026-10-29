// lazyRoutes — the lazily loaded pages and the helpers that load them ahead
// of time (health report item 8). Kept out of App.jsx so that file only
// exports components (React Fast Refresh).
import { MENOPAUSE_PAGES } from './data/menopauseCare';
import { SERVICE_PAGE_SLUGS } from './data/generated/dataIndex';
import { lazyPage } from './lib/lazyPage';

// Pages that carry the large page/article data (pages_data.js, blogs_data.js)
// or are rarely visited load as separate chunks (health report item 8). See
// src/lib/lazyPage.jsx for how prerendering and hydration avoid suspending.
export const Preconception = lazyPage(() => import('./pages/Preconception'));
export const PreconceptionWorkshop = lazyPage(() => import('./pages/PreconceptionWorkshop'));
export const AdminDashboard = lazyPage(() => import('./pages/AdminDashboard'));
export const BlogList = lazyPage(() => import('./pages/BlogList'));
export const BlogPost = lazyPage(() => import('./pages/BlogPost'));
export const ServicePage = lazyPage(() => import('./pages/ServicePage'));
export const PolicyPage = lazyPage(() => import('./pages/PolicyPage'));
export const ArticlesAndVideos = lazyPage(() => import('./pages/menopause/ArticlesAndVideos'));

export const LAZY_PAGES = [
  Preconception, PreconceptionWorkshop, AdminDashboard, BlogList, BlogPost,
  ServicePage, PolicyPage, ArticlesAndVideos,
];

export const SERVICE_PAGE_SLUG_SET = new Set(SERVICE_PAGE_SLUGS);
const POLICY_PATHS = new Set(['/privacy-policy', '/terms-conditions', '/disclaimer-policy', '/cancellation-refund-policy']);

/**
 * The lazy pages the route at `pathname` renders, so the browser can load
 * them before hydrating the prerendered HTML. Mirrors <Routes> in src/App.jsx: keep the
 * two in sync when a route changes.
 */
function lazyPagesForPath(pathname) {
  const path = (pathname || '/').replace(/\/+$/, '') || '/';
  if (path === '/preconception') return [Preconception];
  if (path === '/preconception-workshop') return [PreconceptionWorkshop];
  if (path === '/admin' || path.startsWith('/admin/')) return [AdminDashboard];
  if (path === '/blog') return [BlogList];
  if (POLICY_PATHS.has(path)) return [PolicyPage];
  const library = MENOPAUSE_PAGES.find((page) => page.key === 'library');
  if (library && path === library.path.replace(/\/+$/, '')) return [ArticlesAndVideos];
  const segments = path.split('/').filter(Boolean);
  if (segments.length === 1 && !MENOPAUSE_PAGES.some((page) => page.path.replace(/\/+$/, '') === path)) {
    const known = ['about-me', 'contact-us', 'book-an-appointment', 'all-services', 'success-stories', 'courses'];
    if (known.includes(segments[0])) return [];
    return [SERVICE_PAGE_SLUG_SET.has(segments[0]) ? ServicePage : BlogPost];
  }
  return [];
}

export function preloadRoute(pathname) {
  return Promise.all(lazyPagesForPath(pathname).map((Page) => Page.preload()));
}

/**
 * Load a lazy page as soon as the visitor shows intent to open it (pointer
 * over, touch or keyboard focus on an internal link), so the chunk is usually
 * ready by the click. Nothing is fetched in the background otherwise: parsing
 * the large data chunks unprompted would block the main thread on phones.
 */
export function preloadOnLinkIntent() {
  if (typeof document === 'undefined') return;
  const seen = new Set();
  const onIntent = (event) => {
    const link = event.target instanceof Element ? event.target.closest('a[href]') : null;
    if (!link) return;
    let url;
    try { url = new URL(link.getAttribute('href'), window.location.href); } catch { return; }
    if (url.origin !== window.location.origin || seen.has(url.pathname)) return;
    seen.add(url.pathname);
    preloadRoute(url.pathname).catch(() => seen.delete(url.pathname));
  };
  for (const type of ['pointerover', 'touchstart', 'focusin']) {
    document.addEventListener(type, onIntent, { passive: true, capture: true });
  }
}
