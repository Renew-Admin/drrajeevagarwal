import { useEffect, useRef } from 'react';

/**
 * React hook that manages document-level SEO tags.
 *
 * Sets <title>, <meta name="description">, <link rel="canonical">,
 * and Open Graph meta tags. Restores the previous title on unmount.
 *
 * @param {{ title: string, description: string, canonicalUrl: string, ogImage?: string }} seo
 */
export default function useSeo({ title, description, canonicalUrl, ogImage }) {
  const prevTitle = useRef(null);

  useEffect(() => {
    if (!title) return;

    prevTitle.current = document.title;
    document.title = title;

    const ensureMeta = (selector, attrs) => {
      let el = document.head.querySelector(selector);
      if (!el) {
        el = document.createElement('meta');
        document.head.appendChild(el);
      }
      Object.entries(attrs).forEach(([k, v]) => el.setAttribute(k, v));
    };

    const ensureLink = (selector, attrs) => {
      let el = document.head.querySelector(selector);
      if (!el) {
        el = document.createElement('link');
        document.head.appendChild(el);
      }
      Object.entries(attrs).forEach(([k, v]) => el.setAttribute(k, v));
    };

    // Standard meta tags
    ensureMeta('meta[name="description"]', { name: 'description', content: description });

    // Canonical
    if (canonicalUrl) {
      ensureLink('link[rel="canonical"]', { rel: 'canonical', href: canonicalUrl });
    }

    // Open Graph
    ensureMeta('meta[property="og:title"]', { property: 'og:title', content: title });
    ensureMeta('meta[property="og:description"]', { property: 'og:description', content: description });
    if (canonicalUrl) {
      ensureMeta('meta[property="og:url"]', { property: 'og:url', content: canonicalUrl });
    }
    ensureMeta('meta[property="og:type"]', { property: 'og:type', content: 'website' });
    ensureMeta('meta[property="og:site_name"]', { property: 'og:site_name', content: 'Dr. Rajeev Agarwal' });
    if (ogImage) {
      ensureMeta('meta[property="og:image"]', { property: 'og:image', content: ogImage });
    }

    return () => {
      if (prevTitle.current !== null) {
        document.title = prevTitle.current;
      }
    };
  }, [title, description, canonicalUrl, ogImage]);
}
