import React, { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import { pagesData } from '../data/pages_data';
import { AlertCircle, ArrowLeft, ArrowRight, Calendar, CheckCircle, Heart, ShieldCheck, Sparkles, Stethoscope, Star, Users } from 'lucide-react';

function extractFirstImg(html) {
  const m = html.match(/<img[^>]+src=["']([^"']+)["']/);
  return m ? m[1] : null;
}

function stripHtml(html) {
  return html.replace(/<[^>]*>/g, '').replace(/&nbsp;/g, ' ').replace(/\s+/g, ' ').trim();
}

function extractIntro(html) {
  const pMatch = html.match(/<p>([\s\S]*?)<\/p>/);
  return pMatch ? stripHtml(pMatch[1]) : '';
}

function extractBullets(html) {
  const items = [];
  const ulRegex = /<ul[^>]*>([\s\S]*?)<\/ul>/g;
  let m;
  while ((m = ulRegex.exec(html)) !== null) {
    const lis = m[1].match(/<li>([\s\S]*?)<\/li>/g);
    if (lis) {
      lis.forEach(li => {
        const text = stripHtml(li);
        if (text.length > 10 && text.length < 200) items.push(text);
      });
    }
  }
  return items.slice(0, 8);
}

function escapeRegExp(value) {
  return value.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

function removeDuplicateHeroImage(html, heroImg) {
  if (!heroImg) return html;
  const heroImgRegex = new RegExp(`<img\\b[^>]*src=["']${escapeRegExp(heroImg)}["'][^>]*>`, 'gi');
  return html.replace(heroImgRegex, '');
}

function cleanContent(html, heroImg) {
  let c = html;
  c = removeDuplicateHeroImage(c, heroImg);
  c = c.replace(/<svg[\s\S]*?<\/svg>/g, '');
  c = c.replace(/<a[^>]*role="button"[^>]*>[\s\S]*?<\/a>/g, '');
  c = c.replace(/<img /g, '<img loading="lazy" ');
  c = c.replace(/\s+srcset="[^"]*"/g, '');
  c = c.replace(/\s+sizes="[^"]*"/g, '');
  c = c.replace(/\s+width="\d+"/g, '');
  c = c.replace(/\s+height="\d+"/g, '');
  c = c.replace(/<p>\s*<\/p>/g, '');
  c = c.replace(/\t+/g, ' ');
  c = c.replace(/\n{3,}/g, '\n\n');
  c = c.replace(/&amp;/g, '&');
  c = c.replace(/&lt;/g, '<');
  c = c.replace(/&gt;/g, '>');
  c = c.replace(/&quot;/g, '"');
  c = c.replace(/&#039;/g, "'");
  c = c.replace(/&#8217;/g, "'");
  c = c.replace(/&#8211;/g, '–');
  c = c.replace(/&#8212;/g, '—');
  c = c.replace(/&rsquo;/g, "'");
  c = c.replace(/&mdash;/g, '—');
  c = c.replace(/&nbsp;/g, ' ');
  return c.trim();
}

const serviceStats = [
  { stat: '25+', label: 'Years of Expertise', icon: Star },
  { stat: '10,000+', label: 'Patients Treated', icon: Users },
  { stat: '4.9', label: 'Google Rating', icon: Star },
  { stat: '35+', label: 'Awards & Recognition', icon: ShieldCheck },
];

const serviceFaqs = [
  { q: 'What conditions do you treat?', a: 'Dr. Rajeev Agarwal provides expert care for a wide range of fertility and gynaecological concerns including PCOS, fibroids, endometriosis, period pain, menopause, infertility, vaginismus, urinary issues and more.' },
  { q: 'What happens during the first consultation?', a: 'During your first visit, Dr. Rajeev Agarwal will review your medical history, discuss your symptoms or fertility goals, and recommend any necessary diagnostic tests to create a personalised treatment plan.' },
  { q: 'How do I prepare for my appointment?', a: 'Please bring any previous medical records, test reports, and a list of current medications. If you are a couple, both partners are encouraged to attend for a comprehensive evaluation.' },
  { q: 'Is the treatment painful?', a: 'Most treatments are minimally invasive and performed under appropriate anesthesia or sedation. Dr. Agarwal ensures your comfort throughout the process with modern pain management techniques.' },
  { q: 'How long does recovery take?', a: 'Recovery varies by procedure. Many treatments allow you to return home the same day, while others may require a short recovery period. Your care team will provide detailed aftercare instructions.' },
  { q: 'Do you offer online consultations?', a: 'Yes, virtual consultations are available for patients who cannot visit the clinic in person. You can discuss your concerns, review reports, and receive expert guidance via a secure video call.' },
];

const excludedSlugs = ['about-me', 'blog', 'all-services', 'home-page', 'book-an-appointment', 'success-stories', 'preconception', 'privacy-policy', 'terms-conditions', 'disclaimer-policy', 'cancellation-refund-policy', 'courses-page-copy', 'learn-with-dr-rajeev-agarwal', 'elementor-10995', 'preconception-workshop'];

export default function ServicePage({ onBookClick }) {
  const { slug } = useParams();
  const [page, setPage] = useState(null);
  const [openFaq, setOpenFaq] = useState(null);

  useEffect(() => {
    const cleanSlug = slug ? slug.trim().replace(/\/$/, '') : '';
    const pageData = pagesData[cleanSlug];
    setPage(pageData || null);
  }, [slug]);

  if (!page) {
    return (
      <div className="inner-page" style={{ display: 'flex', alignItems: 'center', minHeight: '60vh' }}>
        <div className="ra-container" style={{ textAlign: 'center', maxWidth: 600 }}>
          <AlertCircle size={48} color="#EF4444" style={{ marginBottom: 16 }} />
          <h2 style={{ fontWeight: 800, color: 'var(--deep-teal)' }}>Service Page Not Found</h2>
          <p style={{ color: 'var(--text-soft)' }}>We apologize, but the page you are looking for does not exist or has been moved.</p>
          <Link to="/" className="ra-btn ra-btn-primary" style={{ marginTop: 16 }}>Go Back Home</Link>
        </div>
      </div>
    );
  }

  const heroImg = extractFirstImg(page.content);
  const cleaned = cleanContent(page.content, heroImg);
  const intro = extractIntro(page.content);
  const bullets = extractBullets(page.content);

  return (
    <div className="inner-page service-page-detail" style={{ paddingTop: 0 }}>

      {/* HERO — clean gradient with decorative elements */}
      <section className="service-hero-modern">
        <div className="ra-container">
          <div>
            <Link to="/all-services" className="article-back" style={{ color: 'var(--deep-teal)', opacity: 0.6, marginBottom: 12, display: 'inline-flex', alignItems: 'center', gap: 6, fontSize: 14 }}>
              <ArrowLeft size={14} /> All Services
            </Link>
            <span className="service-hero-tag">{page.title}</span>
            <h1>{page.title}</h1>
            {intro && <p style={{ color: 'var(--text-soft)', fontSize: 17, lineHeight: 1.7, maxWidth: 540, marginBottom: 28 }}>{intro}</p>}
            <div className="service-hero-actions">
              <button className="ra-btn ra-btn-primary" onClick={onBookClick} style={{ padding: '0 28px', height: 50 }}>Book Appointment</button>
              <a href="#service-content" className="ra-btn ra-btn-soft" style={{ padding: '0 28px', height: 50 }}>Learn More</a>
            </div>
            <div className="service-badge-row">
              {['Expert Fertility Care', 'Personalised Treatment', 'Compassionate Support', 'Proven Results'].map((badge, i) => (
                <span key={i} className="service-badge"><CheckCircle size={14} />{badge}</span>
              ))}
            </div>
          </div>
          <div className="service-hero-visual">
            <div className="service-hero-image-wrap">
              {heroImg ? (
                <img src={heroImg} alt={page.title} style={{ width: '100%', height: '100%', objectFit: 'cover', borderRadius: 24 }} />
              ) : (
                <div style={{
                  background: 'linear-gradient(135deg, var(--deep-teal), var(--medical-teal))',
                  width: '100%', height: '100%', minHeight: 320,
                  borderRadius: 24,
                  display: 'flex', alignItems: 'center', justifyContent: 'center',
                  color: '#fff', fontSize: 60, fontWeight: 800
                }}>
                  {page.title.charAt(0)}
                </div>
              )}
            </div>
          </div>
        </div>
      </section>

      {/* KEY HIGHLIGHTS — bullet points as styled cards */}
      {bullets.length > 0 && (
        <section className="ra-section service-highlights-section">
          <div className="ra-container">
            <div className="ra-section-head">
              <span className="ra-label"><Sparkles size={15} /> KEY HIGHLIGHTS</span>
              <h2>What You Can <em>Expect</em></h2>
            </div>
            <div className="service-highlights-grid">
              {bullets.map((b, i) => (
                <div key={i} className="inner-card service-highlight-card">
                  <span style={{ color: 'var(--gold)', flexShrink: 0, marginTop: 2 }}>
                    <CheckCircle size={20} />
                  </span>
                  <p style={{ margin: 0, fontSize: 14.5, lineHeight: 1.65, color: 'var(--text-mid)' }}>{b}</p>
                </div>
              ))}
            </div>
          </div>
        </section>
      )}

      {/* MAIN CONTENT — cleaned WordPress body */}
      <section id="service-content" className="ra-section service-content-section">
        <div className="ra-container service-content-container">
          <div className="wordpress-content" style={{ padding: 0, background: 'transparent' }}>
            <div dangerouslySetInnerHTML={{ __html: cleaned }} />
          </div>
        </div>
      </section>

      {/* STATS */}
      <section className="ra-section" style={{ background: 'linear-gradient(135deg, var(--deep-teal), #1a1f4e)', color: '#fff' }}>
        <div className="ra-container">
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(180px, 1fr))', gap: 32, textAlign: 'center' }}>
            {serviceStats.map((s) => {
              const Icon = s.icon;
              return (
                <div key={s.stat}>
                  <Icon size={32} style={{ color: 'var(--gold)', marginBottom: 8 }} />
                  <div style={{ fontSize: 'clamp(1.8rem, 3vw, 2.4rem)', fontWeight: 800, color: '#fff', lineHeight: 1.2 }}>{s.stat}</div>
                  <div style={{ fontSize: 14, color: 'rgba(255,255,255,0.75)', marginTop: 4 }}>{s.label}</div>
                </div>
              );
            })}
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="ra-section">
        <div className="ra-container">
          <div
            style={{
              background: 'linear-gradient(135deg, var(--deep-teal), #1a1f4e)',
              borderRadius: 24,
              padding: '52px 40px',
              textAlign: 'center',
              color: '#fff',
            }}
          >
            <h2 style={{ color: '#fff', fontSize: 'clamp(1.4rem, 3vw, 2rem)', margin: '0 0 12px' }}>
              Ready to Start Your Journey?
            </h2>
            <p style={{ color: 'rgba(255,255,255,0.8)', maxWidth: 560, margin: '0 auto 28px', fontSize: 15, lineHeight: 1.7 }}>
              Book a consultation with Dr. Rajeev Agarwal and receive personalized guidance based on your health condition, age, medical history and goals.
            </p>
            <div style={{ display: 'flex', gap: 14, justifyContent: 'center', flexWrap: 'wrap' }}>
              <button className="ra-btn ra-btn-primary" onClick={onBookClick} style={{ padding: '0 32px', height: 50, fontSize: 15 }}>
                <Calendar size={18} /> Book Appointment
              </button>
              <Link to="/all-services" className="ra-btn ra-btn-soft" style={{ padding: '0 32px', height: 50, fontSize: 15, background: 'rgba(255,255,255,0.15)', color: '#fff', border: '1px solid rgba(255,255,255,0.25)' }}>
                View All Services <ArrowRight size={16} />
              </Link>
            </div>
          </div>
        </div>
      </section>

      {/* FAQ */}
      <section className="ra-section ra-section-blue">
        <div className="ra-container ra-faq">
          <div className="ra-section-head">
            <span className="ra-label">FAQ</span>
            <h2>Questions Patients Often <em>Ask</em></h2>
          </div>
          <div className="ra-faq-accordion">
            {serviceFaqs.map((item, i) => {
              const open = openFaq === i;
              return (
                <div key={i} className={`ra-faq-item ${open ? 'ra-faq-item--open' : ''}`}>
                  <button className="ra-faq-q" onClick={() => setOpenFaq(open ? null : i)}>
                    <span>{item.q}</span>
                    <span className={`ra-faq-icon ${open ? 'ra-faq-icon--open' : ''}`}>
                      <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M9 3v12M3 9h12" stroke="currentColor" strokeWidth="2" strokeLinecap="round"/></svg>
                    </span>
                  </button>
                  <div className={`ra-faq-a-wrap ${open ? 'ra-faq-a-wrap--open' : ''}`}>
                    <div className="ra-faq-a">{item.a}</div>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </section>

    </div>
  );
}
