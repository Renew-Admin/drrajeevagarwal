import { useState, useEffect, useMemo } from 'react';
import { useParams, Link } from 'react-router-dom';
import { pagesData } from '../data/pages_data';
import { ArrowLeft, ArrowRight, Calendar, CheckCircle, ShieldCheck, Sparkles, Star, Users, ChevronDown } from 'lucide-react';
import useSeo from '../utils/useSeo';
import { getMetaForPath, getServicePageMeta } from '../utils/seoMeta';
import WhyMeSection from '../components/WhyMeSection';
import NotFound from './NotFound';

import { blogsData as initialBlogs } from '../data/blogs_data';
import { liveBlogUpdates } from '../data/live_blog_updates';
import { buildBlogPresentation, getBlogImage, getBlogCategory } from '../utils/blogPresentation';
import { listPublishedBlogs } from '../lib/supabaseBlogAdmin';
import BlogImage from '../components/BlogImage';

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

function removeImportedWhyMeSection(html) {
  const markers = [/MY\s+USP/i, /WHY\s+ME\s*\?/i];
  const start = markers
    .map(marker => html.search(marker))
    .filter(index => index !== -1)
    .sort((a, b) => a - b)[0];

  return start === undefined ? html : html.slice(0, start).trim();
}

function replaceImportedCounterStats(html) {
  return html.replace(
    /Patients served\s*0\s*k\+\s*Happy Patients\s*\+\s*0\s*%\s*Year Of Experience\s*0\s*\+\s*IVF Success rate\s*0\s*%/gi,
    'Patients served 10k+ Happy Patients 99.5% Year Of Experience 25+ IVF Success rate 70%'
  );
}

function cleanContent(html, heroImg) {
  let c = html;
  c = removeDuplicateHeroImage(c, heroImg);
  c = replaceImportedCounterStats(c);
  c = removeImportedWhyMeSection(c);
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

function renderHeroTitle(title) {
  const words = title.trim().split(/\s+/);
  if (words.length <= 1) return title;

  const highlightCount = words.length <= 2 ? 1 : 2;
  const primary = words.slice(0, -highlightCount).join(' ');
  const highlight = words.slice(-highlightCount).join(' ');

  return (
    <>
      {primary}{' '}
      <em>{highlight}</em>
    </>
  );
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

const SERVICE_BLOG_CATEGORIES = {
  'pcos-care': ['PCOS'],
  'vaginismus-therapy': ["Women's Health", "Women's Wellness"],
  'urinary-laser-therapy': ["Women's Health", "Women's Wellness"],
  'urinary-incontinence': ["Women's Health", "Women's Wellness"],
  'sexual-pain-relief': ["Women's Health", "Women's Wellness"],
  'menopause-wellness': ["Women's Health", "Women's Wellness"],
  'preconception': ['Preconception Care', 'Safe Pregnancy'],
  'preconception-workshop': ['Preconception Care', 'Safe Pregnancy'],
  'period-pain-relief': ['Preconception Care', 'Safe Pregnancy', 'Women\'s Health'],
  'infertility-help': ['Fertility', 'Endometriosis', 'Male Fertility'],
  'fertility-support-services': ['Fertility', 'Endometriosis', 'Male Fertility'],
  'advanced-fertility-treatments': ['Fertility', 'Endometriosis', 'Male Fertility'],
  'laparoscopic-surgery': ['Fertility', 'Endometriosis', 'Laparoscopy'],
  'hysteroscopic-procedure': ['Fertility', 'Endometriosis', 'Laparoscopy'],
  'fibroids-solutions': ['Fertility', 'Endometriosis'],
};

function getAllowedCategories(slug) {
  return SERVICE_BLOG_CATEGORIES[slug] || ['Preconception Care', 'Fertility', 'Safe Pregnancy', 'Women\'s Health', 'PCOS', 'Male Fertility', 'Endometriosis', 'Women\'s Wellness'];
}

const RELATED_BLOG_KEYWORDS = {
  'pcos-care': ['pcos', 'polycystic', 'ovarian', 'insulin', 'weight', 'cyst'],
  'vaginismus-therapy': ['vaginismus', 'painful', 'penetration', 'tightness', 'intercourse', 'sex'],
  'urinary-laser-therapy': ['urinary', 'laser', 'incontinence', 'bladder'],
  'laparoscopic-surgery': ['laparoscopy', 'laparoscopic', 'minimally invasive', 'surgery', 'cyst'],
  'hysteroscopic-procedure': ['hysteroscopy', 'hysteroscopic', 'uterus', 'polyp', 'uterine'],
  'fertility-support-services': ['fertility', 'conceive', 'pregnancy', 'pregnancy-tests', 'egg', 'sperm', 'amh', 'iui', 'ivf'],
  'advanced-fertility-treatments': ['ivf', 'iui', 'icsi', 'embryo', 'egg freezing', 'fertility'],
  'period-pain-relief': ['period pain', 'menstruation', 'endometriosis', 'cramps', 'painful periods'],
  'menopause-wellness': ['menopause', 'hot flashes', 'aging', 'hormone replacement', 'estrogen'],
  'infertility-help': ['infertility', 'fertility', 'conceive', 'iui', 'ivf', 'sperm', 'egg'],
  'fibroids-solutions': ['fibroid', 'fibroids', 'myomectomy', 'uterus', 'bleeding'],
  'urinary-incontinence': ['urinary', 'incontinence', 'bladder', 'leakage', 'laser'],
  'sexual-pain-relief': ['painful intercourse', 'dyspareunia', 'vaginismus', 'pain during sex'],
};

function RelatedBlogs({ serviceSlug, serviceTitle }) {
  const [blogs, setBlogs] = useState([]);
  const [loaded, setLoaded] = useState(false);

  useEffect(() => {
    let active = true;

    async function loadBlogs() {
      try {
        let fallback = [];
        try {
          const saved = localStorage.getItem('blogsList');
          fallback = saved ? JSON.parse(saved) : initialBlogs;
        } catch {
          fallback = initialBlogs;
        }

        const remoteBlogs = await listPublishedBlogs();

        if (active) {
          const seen = new Set();
          const combined = [...remoteBlogs, ...liveBlogUpdates, ...fallback].filter(b => {
            if (seen.has(b.slug)) return false;
            seen.add(b.slug);
            return true;
          });

          const presented = combined.map((item, index) => buildBlogPresentation(item, index));
          setBlogs(presented);
          setLoaded(true);
        }
      } catch (err) {
        console.error('Error loading related blogs:', err);
      }
    }

    loadBlogs();

    return () => {
      active = false;
    };
  }, []);

  const related = useMemo(() => {
    if (!loaded || blogs.length === 0) return [];

    // Sort all blogs by date descending
    const sorted = [...blogs].sort((a, b) => new Date(b.date) - new Date(a.date));

    // Get allowed categories for this service page
    const allowedCats = getAllowedCategories(serviceSlug);

    // Filter blogs to only include those in the allowed categories
    const categoryBlogs = sorted.filter(blog => {
      const cat = getBlogCategory(blog);
      return allowedCats.includes(cat);
    });

    const keywords = RELATED_BLOG_KEYWORDS[serviceSlug] || [];
    const titleWords = serviceTitle
      .toLowerCase()
      .replace(/[^\w\s]/g, '')
      .split(/\s+/)
      .filter(w => w.length > 3);

    const allKeywords = Array.from(new Set([...keywords, ...titleWords]));

    // Find matching blogs within the allowed categories
    const matched = [];
    categoryBlogs.forEach(blog => {
      let isMatch = false;
      const title = (blog.title || '').toLowerCase();
      const excerpt = (blog.excerpt || '').toLowerCase();
      const tags = Array.isArray(blog.tags) ? blog.tags.map(t => t.toLowerCase()) : [];

      for (const kw of allKeywords) {
        const kwLower = kw.toLowerCase();
        if (tags.some(tag => tag.includes(kwLower)) || title.includes(kwLower) || excerpt.includes(kwLower)) {
          isMatch = true;
          break;
        }
      }

      if (isMatch) {
        matched.push(blog);
      }
    });

    // Take top 3 matched blogs
    const result = matched.slice(0, 3);

    // If less than 3 matched, fill the remaining slots with the most recent blogs FROM THE SAME CATEGORY GROUP
    if (result.length < 3) {
      const usedSlugs = new Set(result.map(b => b.slug));
      for (const blog of categoryBlogs) {
        if (!usedSlugs.has(blog.slug)) {
          result.push(blog);
          usedSlugs.add(blog.slug);
        }
        if (result.length === 3) break;
      }
    }

    // In the extremely rare case we still have less than 3, fill from the general list
    if (result.length < 3) {
      const usedSlugs = new Set(result.map(b => b.slug));
      for (const blog of sorted) {
        if (!usedSlugs.has(blog.slug)) {
          result.push(blog);
          usedSlugs.add(blog.slug);
        }
        if (result.length === 3) break;
      }
    }

    return result;
  }, [blogs, loaded, serviceSlug, serviceTitle]);

  if (!loaded || related.length === 0) {
    return null;
  }

  return (
    <section className="ra-blog-section" style={{ background: '#fcfdff', borderTop: '1px solid #eef2f7', padding: '70px 0' }}>
      <div className="ra-container">
        <div className="ra-section-head">
          <span className="ra-label">Related Articles</span>
          <h2>Read Insights About <em>{serviceTitle}</em></h2>
        </div>
        <div className="ra-blog-grid">
          {related.map((post, index) => (
            <article className="ra-blog-card" key={post.slug}>
              <div className="ra-blog-img-wrap">
                <BlogImage src={post.image || getBlogImage(post, index)} alt={post.title} loading="lazy" fitMode="contain" />
              </div>
              <div className="ra-blog-body">
                <span className="ra-blog-badge">{getBlogCategory(post)}</span>
                <h3>{post.title}</h3>
                <p>{post.excerpt}</p>
                <time dateTime={post.date}>{post.displayDate || post.date}</time>
                <Link to={`/blog/${post.slug}`} className="ra-blog-link">Read Article</Link>
              </div>
            </article>
          ))}
        </div>
      </div>
    </section>
  );
}

export default function ServicePage({ onBookClick }) {
  const { slug } = useParams();
  const [openFaq, setOpenFaq] = useState(null);
  const cleanSlug = slug ? slug.trim().replace(/\/$/, '') : '';
  const page = pagesData[cleanSlug] || null;
  const serviceSeo = page ? getServicePageMeta(cleanSlug, page.title) : getMetaForPath('/');
  useSeo(serviceSeo);

  if (!page) {
    return <NotFound />;
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
            <Link to="/all-services" className="article-back service-back-link">
              <ArrowLeft size={14} /> All Services
            </Link>
            <span className="service-hero-tag">{page.title}</span>
            <h1>{renderHeroTitle(page.title)}</h1>
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
                <BlogImage src={heroImg} alt={page.title} fitMode="contain" />
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
                  <span className="service-highlight-icon">
                    <CheckCircle size={20} />
                  </span>
                  <p>{b}</p>
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

      <WhyMeSection />

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
                      <ChevronDown size={18} />
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

      <RelatedBlogs serviceSlug={cleanSlug} serviceTitle={page.title} />

    </div>
  );
}
