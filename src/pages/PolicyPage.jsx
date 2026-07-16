import React, { useEffect, useState } from 'react';
import { useLocation, Link } from 'react-router-dom';
import { pagesData } from '../data/pages_data';
import { AlertCircle } from 'lucide-react';
import useSeo from '../utils/useSeo';
import { getMetaForPath } from '../utils/seoMeta';

export default function PolicyPage() {
  const location = useLocation();
  const policyMeta = getMetaForPath(location.pathname);
  useSeo(policyMeta);
  const [page, setPage] = useState(null);

  useEffect(() => {
    const path = location.pathname.replace(/^\/|\/$/g, '');
    const pageData = pagesData[path];
    setPage(pageData || null);
  }, [location.pathname]);

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
            <div className="policy-content" dangerouslySetInnerHTML={{ __html: page.content }} />
          </div>
        </div>
      </section>
    </div>
  );
}
