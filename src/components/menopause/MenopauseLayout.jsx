import { Link } from 'react-router-dom';
import { ChevronRight, Phone, MessageCircle } from 'lucide-react';

import {
  MENOPAUSE_BASE,
  MENOPAUSE_PAGES,
  MENOPAUSE_PAGE_BY_KEY,
  MENOPAUSE_SECTION_LABEL,
} from '../../data/menopauseCare';
import { SITE_ORIGIN } from '../../utils/seoMeta';
import useSeo from '../../utils/useSeo';

/**
 * Shared chrome for every page under /menopause-care.
 *
 * Owns the things that must not drift between sub-pages: SEO tags, the
 * breadcrumb, the section switcher, the medical disclaimer and the closing CTA.
 * Sub-pages supply only their own body.
 */
export default function MenopauseLayout({
  pageKey,
  lede,
  heroActions,
  heroAside,
  sideNav,
  children,
  onBookClick,
}) {
  const page = MENOPAUSE_PAGE_BY_KEY[pageKey];
  const isHub = page.path === MENOPAUSE_BASE;

  useSeo({
    title: page.title,
    description: page.description,
    canonicalUrl: SITE_ORIGIN + page.path,
  });

  const index = MENOPAUSE_PAGES.findIndex((entry) => entry.key === pageKey);
  const next = MENOPAUSE_PAGES[index + 1] || null;
  const previous = index > 0 ? MENOPAUSE_PAGES[index - 1] : null;

  return (
    <div className="mc-page">
      <nav className="mc-breadcrumb" aria-label="Breadcrumb">
        <div className="ra-container">
          <Link to="/">Home</Link>
          <ChevronRight size={13} aria-hidden="true" />
          {isHub ? (
            <span aria-current="page">{MENOPAUSE_SECTION_LABEL}</span>
          ) : (
            <>
              <Link to={MENOPAUSE_BASE}>{MENOPAUSE_SECTION_LABEL}</Link>
              <ChevronRight size={13} aria-hidden="true" />
              <span aria-current="page">{page.breadcrumb}</span>
            </>
          )}
        </div>
      </nav>

      <section className="mc-hero">
        <div className="ra-container">
          <div className={heroAside ? 'mc-hero-grid' : undefined}>
            <div className="mc-hero-main">
              <span className="mc-eyebrow">{page.eyebrow}</span>
              <h1>{page.heading}</h1>
              {lede && <div className="mc-lede">{lede}</div>}
              {heroActions && <div className="mc-hero-actions">{heroActions}</div>}
            </div>
            {heroAside && <div className="mc-hero-aside">{heroAside}</div>}
          </div>
        </div>
      </section>

      <nav className="mc-sectionnav" aria-label="Menopause care sections">
        <div className="ra-container">
          {MENOPAUSE_PAGES.map((entry) => (
            <Link
              key={entry.path}
              to={entry.path}
              className={entry.key === pageKey ? 'is-active' : ''}
              aria-current={entry.key === pageKey ? 'page' : undefined}
            >
              {entry.label}
            </Link>
          ))}
        </div>
      </nav>

      <div className="ra-container">
        <div className={sideNav ? 'mc-body mc-body-split' : 'mc-body'}>
          {sideNav && (
            <aside className="mc-side">
              <nav className="mc-side-nav" aria-label="On this page">
                <span>On this page</span>
                {sideNav.map((item) => (
                  <a key={item.id} href={`#${item.id}`}>{item.label}</a>
                ))}
              </nav>
            </aside>
          )}
          <div className="mc-content">{children}</div>
        </div>
      </div>

      {(previous || next) && (
        <div className="ra-container">
          <div className="mc-pager">
            {previous ? (
              <Link to={previous.path} className="mc-pager-link">
                <span>Previous</span>
                <strong>{previous.navLabel}</strong>
              </Link>
            ) : <span />}
            {next && (
              <Link to={next.path} className="mc-pager-link mc-pager-next">
                <span>Next</span>
                <strong>{next.navLabel}</strong>
              </Link>
            )}
          </div>
        </div>
      )}

      <section className="mc-cta">
        <div className="ra-container mc-cta-inner">
          <div>
            <h2>Bring your symptoms. Leave with a plan.</h2>
            <p>
              Consultations with Dr. Rajeev Agarwal at Renew Healthcare, Kolkata — in person or virtual.
              If you have taken the{' '}
              <Link to="/menopause-care/perimenopause-symptoms-quiz">symptom quiz</Link>, bring your result:
              it gives the consultation a running start.
            </p>
          </div>
          <div className="mc-cta-actions">
            {onBookClick ? (
              <button type="button" className="mc-btn mc-btn-primary" onClick={onBookClick}>
                Book a consultation
              </button>
            ) : (
              <Link className="mc-btn mc-btn-primary" to="/book-an-appointment">Book a consultation</Link>
            )}
            <a className="mc-btn mc-btn-outline" href="tel:+918336968661">
              <Phone size={16} /> +91 83369 68661
            </a>
            <a className="mc-btn mc-btn-outline" href="https://wa.me/918336968661" target="_blank" rel="noreferrer">
              <MessageCircle size={16} /> WhatsApp
            </a>
          </div>
        </div>
      </section>

      <p className="mc-disclaimer ra-container">
        <strong>A note on this section.</strong> Everything here is general educational information about
        perimenopause and menopause. It is not a diagnosis and does not replace individualised medical advice —
        please discuss your own symptoms, history and options with Dr. Agarwal or your own physician before
        making any treatment decision.
      </p>
    </div>
  );
}
