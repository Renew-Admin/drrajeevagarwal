// usePageTracking — the single source of GA4 page_view events (gtag config
// uses send_page_view:false; the stream's history-based page views are off).
//
// One page_view per genuine route change. The title is read once the route
// has written it (useSeo sets document.title in an effect, lazy pages later):
// a MutationObserver on <head> resolves as soon as the title changes, and a
// 1.5 s backstop covers routes whose title equals the previous one.
import { useEffect } from 'react';
import { useLocation } from 'react-router-dom';
import { GA_MEASUREMENT_ID, analyticsAllowed, cleanPageLocation, pageCategory, sanitizeParams } from '../lib/analytics';

let lastTrackedLocation = '';
let lastTrackedTitle = '';

function waitForTitle(previousTitle, onReady) {
  if (document.title && document.title !== previousTitle) {
    onReady();
    return () => {};
  }
  let done = false;
  const observer = new MutationObserver(() => {
    if (document.title && document.title !== previousTitle) finish();
  });
  const backstop = window.setTimeout(() => finish(), 1500);
  function finish() {
    if (done) return;
    done = true;
    observer.disconnect();
    window.clearTimeout(backstop);
    onReady();
  }
  observer.observe(document.head, { subtree: true, childList: true, characterData: true });
  return () => {
    done = true;
    observer.disconnect();
    window.clearTimeout(backstop);
  };
}

export function usePageTracking() {
  const location = useLocation();

  useEffect(() => {
    if (typeof window === 'undefined') return undefined;
    const pageLocation = cleanPageLocation(window.location.href);
    if (!pageLocation || pageLocation === lastTrackedLocation) return undefined;

    return waitForTitle(lastTrackedTitle, () => {
      if (pageLocation === lastTrackedLocation) return;
      if (!analyticsAllowed() || typeof window.gtag !== 'function') return;
      lastTrackedLocation = pageLocation;
      lastTrackedTitle = document.title;
      const params = sanitizeParams('page_view', {
        page_location: pageLocation,
        page_title: document.title,
        page_category: pageCategory(location.pathname),
      });
      window.gtag('event', 'page_view', { ...params, send_to: GA_MEASUREMENT_ID });
    });
  }, [location.pathname, location.search]);
}
