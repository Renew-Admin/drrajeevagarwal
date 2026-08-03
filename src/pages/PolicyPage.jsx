import React from 'react';
import { useLocation, Link } from 'react-router-dom';
import { pagesData } from '../data/pages_data';
import { AlertCircle } from 'lucide-react';
import useSeo from '../utils/useSeo';
import { getMetaForPath } from '../utils/seoMeta';

export default function PolicyPage() {
  const location = useLocation();
  const policyMeta = getMetaForPath(location.pathname);
  useSeo(policyMeta);
  // pagesData is a static import, so resolve during render. Deferring this to
  // an effect meant the first render was always the "not found" branch, which
  // is what prerendering (scripts/prerender.mjs) captured for these pages.
  const page = pagesData[location.pathname.replace(/^\/|\/$/g, '')] || null;

  // The migrated WordPress body for some policy pages opens with its own <h1>
  // (e.g. /disclaimer-policy), which collides with the page-title <h1> in the
  // hero below and ships two <h1> elements. Demote the in-content one to <h2>
  // and tag it so CSS can keep it looking exactly as it did.
  const policyHtml = React.useMemo(() => {
    if (!page?.content) return '';
    return page.content
      .replace(/<h1(\s[^>]*)?>/gi, (_m, attrs = '') => `<h2${attrs || ''} data-was-h1="true">`)
      .replace(/<\/h1>/gi, '</h2>');
  }, [page]);

  if (!page) {
    return (
      <div className="inner-page" style={{ display: 'flex', alignItems: 'center', minHeight: '60vh' }}>
        <div className="ra-container" style={{ textAlign: 'center', maxWidth: 600 }}>
          <AlertCircle size={48} color="#EF4444" style={{ marginBottom: 16 }} />
          <h2 style={{ fontWeight: 800, color: 'var(--deep-teal)' }}>Policy Page Not Found</h2>
          <p style={{ color: 'var(--text-soft)' }}>We apologize, but the policy page you are looking for does not exist or has been moved.</p>
          <Link to="/" className="ra-btn ra-btn-primary" style={{ marginTop: 16 }}>Go Back Home</Link>
        </div>
      </div>
    );
  }

  return (
    <div className="inner-page">
      <section className="inner-hero" style={{ padding: '52px 0' }}>
        <div className="ra-container"><h1 style={{ margin: 0 }}>{page.title}</h1></div>
      </section>
      <section className="inner-section inner-section-blue">
        <div className="ra-container" style={{ maxWidth: 860 }}>
          <div className="inner-card" style={{ padding: '44px 40px' }}>
            <div className="policy-content" dangerouslySetInnerHTML={{ __html: policyHtml }} />
          </div>
        </div>
      </section>
    </div>
  );
}
