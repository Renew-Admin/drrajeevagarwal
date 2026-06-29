import React, { useEffect } from 'react';
import { pagesData } from '../data/pages_data';
import { Link } from 'react-router-dom';
import { ArrowLeft } from 'lucide-react';

export default function Preconception() {
  const page = pagesData['preconception-workshop'] || pagesData['preconception'];

  useEffect(() => {
    if (page && page.id) {
      const linkId = `elementor-post-style-${page.id}`;
      if (!document.getElementById(linkId)) {
        const link = document.createElement('link');
        link.id = linkId;
        link.rel = 'stylesheet';
        link.href = `/wp-styles/elementor/post-${page.id}.css`;
        document.head.appendChild(link);
      }
      return () => {
        const link = document.getElementById(linkId);
        if (link) link.remove();
      };
    }
  }, [page]);

  if (!page) {
    return (
      <div className="inner-page" style={{ display: 'flex', alignItems: 'center', minHeight: '60vh' }}>
        <div className="ra-container" style={{ textAlign: 'center' }}>
          <h3 style={{ color: 'var(--text-soft)' }}>Loading Zero Trimester Details...</h3>
        </div>
      </div>
    );
  }

  return (
    <div className="inner-page">
      <section className="inner-hero" style={{ padding: '52px 0' }}>
        <div className="ra-container"><h1 style={{ margin: 0 }}>{page.title}</h1></div>
      </section>
      <section className="inner-section">
        <div className="ra-container">
          <Link to="/" className="article-back" style={{ marginBottom: 24 }}><ArrowLeft size={16} /> Back to Home</Link>
          <div className="inner-card" style={{ padding: 40 }}>
            <div className="wordpress-content" style={{ padding: 0 }}>
              <div dangerouslySetInnerHTML={{ __html: page.content }} />
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}
