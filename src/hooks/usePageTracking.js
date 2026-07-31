import { useEffect, useRef } from 'react';
import { useLocation } from 'react-router-dom';

export function usePageTracking() {
  const location = useLocation();
  const lastTrackedLocation = useRef('');

  useEffect(() => {
    const pagePath = `${location.pathname}${location.search}${location.hash}`;
    const pageLocation = window.location.href;

    const timeoutId = window.setTimeout(() => {
      if (typeof window.gtag !== 'function') return;
      if (lastTrackedLocation.current === pageLocation) return;

      lastTrackedLocation.current = pageLocation;
      window.gtag('event', 'page_view', {
        page_path: pagePath,
        page_location: pageLocation,
        page_title: document.title,
      });
    }, 0);

    return () => window.clearTimeout(timeoutId);
  }, [location.pathname, location.search, location.hash]);
}
