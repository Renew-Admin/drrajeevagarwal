import { useEffect, useState, useMemo, useRef } from 'react';
import { Link } from 'react-router-dom';
import {
  Baby,
  BookOpen,
  CalendarCheck,
  CheckCircle,
  HeartPulse,
  ShieldCheck,
  Sparkles,
  Stethoscope,
  ChevronDown,
  Play,
} from 'lucide-react';

import { blogsData as initialBlogs } from '../data/blogs_data';
import { liveBlogUpdates } from '../data/live_blog_updates';
import { buildBlogPresentation, getBlogImage, getBlogCategory } from '../utils/blogPresentation';
import { listPublishedBlogs } from '../lib/supabaseBlogAdmin';

const ASSET_PATH = '/assets/preconception-workshop/';
const PRECONCEPTION_VIDEO_URL = '/assets/2026/02/sir-video-new-com.mp4';

const planningHighlights = [
  {
    title: 'Health Snapshot',
    text: 'Review cycles, medical history, thyroid, sugar, weight, and current medicines before trying.',
    icon: Stethoscope,
  },
  {
    title: 'Fertility Timing',
    text: 'Understand ovulation windows, age-related timelines, and when a medical review is useful.',
    icon: CalendarCheck,
  },
  {
    title: 'Nutrition Basics',
    text: 'Clarify folic acid, Vitamin D, iron, sleep, stress, and partner health habits.',
    icon: HeartPulse,
  },
  {
    title: 'Next-Step Notes',
    text: 'Leave with a practical checklist to discuss during your preconception consultation.',
    icon: CheckCircle,
  },
];

const pillars = [
  {
    title: 'Know Your Baseline',
    text: 'Understand cycles, age, hormones, thyroid, weight, and fertility markers before you begin trying.',
    icon: ShieldCheck,
  },
  {
    title: 'Plan Tests Wisely',
    text: 'Learn which investigations matter now and which ones can wait, so you avoid confusion and over-testing.',
    icon: BookOpen,
  },
  {
    title: 'Prepare Together',
    text: 'Include male fertility, stress, sleep, nutrition, and shared decisions in one practical plan.',
    icon: HeartPulse,
  },
  {
    title: 'Act At The Right Time',
    text: 'Know when to relax, when to seek help, and how to get IVF-ready if treatment becomes necessary.',
    icon: CalendarCheck,
  },
];

const suitableFor = [
  'Couples planning pregnancy within 6-24 months',
  'First-time parents who want evidence-based guidance',
  'Couples trying naturally but unsure what to check',
  'People with PCOS, thyroid, diabetes, irregular periods, or previous pregnancy loss',
];

const agenda = [
  {
    title: 'Fertility Baseline',
    text: 'Understand where you are starting from before you begin trying.',
    icon: ShieldCheck,
    points: ['Cycles and ovulation window', 'Age, AMH, thyroid, Vitamin D', 'When a baseline check is useful'],
  },
  {
    title: 'Smart Testing Plan',
    text: 'Know which investigations matter now and which can wait.',
    icon: BookOpen,
    points: ['Female fertility tests', 'Semen analysis basics', 'Avoiding unnecessary panic tests'],
  },
  {
    title: 'Body Preparation',
    text: 'Build a healthier pre-pregnancy routine with realistic changes.',
    icon: HeartPulse,
    points: ['Nutrition and supplements', 'Weight, sleep, and stress', 'Hormonal balance habits'],
  },
  {
    title: 'Partner Health',
    text: 'Make fertility planning a shared couple process.',
    icon: Baby,
    points: ['Male fertility factors', 'Lifestyle risks for sperm health', 'How partners can support the plan'],
  },
  {
    title: 'When To Act',
    text: 'Learn when patience is fine and when medical review is sensible.',
    icon: CalendarCheck,
    points: ['Trying timelines by age', 'Warning signs to not ignore', 'Past loss or failed cycles'],
  },
  {
    title: 'Next-Step Roadmap',
    text: 'Leave with a clear action plan instead of scattered advice.',
    icon: CheckCircle,
    points: ['Natural conception plan', 'IVF readiness if needed', 'Questions to ask your doctor'],
  },
];

const reviews = [
  {
    name: 'Mr & Mrs Gupta',
    text: 'No unnecessary tests, no pressure, just clear guidance for our situation. The session helped us understand what to do next.',
  },
  {
    name: 'Mr & Mrs Tanuja',
    text: 'We did not know small things like Vitamin D, stress, and sleep could affect fertility. The advice was easy to understand and follow.',
  },
  {
    name: 'Mr & Mrs Soni',
    text: 'We had doubts about when to start, what to eat, and what tests to do. The counselling made us feel prepared instead of anxious.',
  },
];

const storyImages = [
  ['happiness-01.jpg', 'Family smiling after fertility care'],
  ['happiness-02.jpg', 'Couple sharing a parenthood success moment'],
  ['happiness-03.jpg', 'Happy parents with their baby'],
  ['happiness-04.jpg', 'Fertility success story family photo'],
];

const awardImages = [
  ['award-01.jpg', 'Award recognition for Dr. Rajeev Agarwal'],
  ['award-02.png', 'Healthcare award received by Dr. Rajeev Agarwal'],
  ['award-03.jpg', 'Dr. Rajeev Agarwal award ceremony photograph'],
  ['award-04.png', 'Fertility care award certificate'],
  ['award-05.jpg', 'Dr. Rajeev Agarwal recognition event'],
  ['award-06.png', 'Medical excellence award'],
  ['award-07.png', 'Healthcare recognition plaque'],
  ['award-08.png', 'Fertility specialist award'],
];

const faqs = [
  {
    title: "When should we start preconception planning?",
    text: "Ideally, you should start planning at least 3 months (the 'Zero Trimester') before you begin actively trying to conceive. This gives you enough time to check and correct nutritional gaps, complete vaccinations, adjust medications, and optimize health conditions."
  },
  {
    title: "What happens during a preconception consultation?",
    text: "During the consultation, Dr. Rajeev Agarwal reviews your medical history, menstrual cycle patterns, and lifestyle habits. He advises on essential pre-pregnancy blood tests, checks immunity status, conducts a pelvic scan to evaluate your uterine lining and ovarian reserve, and outlines a personalized care roadmap."
  },
  {
    title: "What are the essential tests recommended before pregnancy?",
    text: "Essential tests include Haemoglobin & Ferritin (iron storage), Vitamin D & B12, Thyroid (TSH), Glucose metabolism (75g Oral Glucose Load & HOMA-IR), Rubella & Varicella immunity, and basic genetic carrier screening like HPLC for Thalassemia."
  },
  {
    title: "Why is the husband's health evaluated during planning?",
    text: "Male fertility accounts for nearly half of all conception delays. A simple semen analysis assesses sperm count, motility, and shape. Evaluating partner habits (sleep, stress, smoking) is also key to ensuring a healthy environment for the developing embryo."
  },
  {
    title: "If I feel completely healthy, do I still need counselling?",
    text: "Yes. Many conditions that affect pregnancy, such as mild thyroid dysfunction, low ferritin, or genetic carrier status, have absolutely no symptoms. Preconception checks ensure your body is fully optimized, reducing risks of early loss or complications."
  }
];

// Accordion helper removed to use standard ra-faq structure

function usePreconceptionSeo() {
  useEffect(() => {
    const title = 'Preconception Counselling | Dr. Rajeev Agarwal';
    const description =
      'Preconception counselling with Dr. Rajeev Agarwal helps couples prepare for pregnancy with clear fertility, nutrition, testing, and timing guidance.';
    const previousTitle = document.title;

    const ensureMeta = (selector, attrs) => {
      let element = document.head.querySelector(selector);
      if (!element) {
        element = document.createElement('meta');
        document.head.appendChild(element);
      }
      Object.entries(attrs).forEach(([key, value]) => element.setAttribute(key, value));
    };

    document.title = title;
    ensureMeta('meta[name="description"]', { name: 'description', content: description });
    ensureMeta('meta[property="og:title"]', { property: 'og:title', content: title });
    ensureMeta('meta[property="og:description"]', { property: 'og:description', content: description });
    ensureMeta('meta[property="og:image"]', {
      property: 'og:image',
      content: `${window.location.origin}${ASSET_PATH}hero-video-cover.jpg`,
    });

    let canonical = document.head.querySelector('link[rel="canonical"]');
    if (!canonical) {
      canonical = document.createElement('link');
      canonical.rel = 'canonical';
      document.head.appendChild(canonical);
    }
    canonical.href = `${window.location.origin}/preconception`;

    return () => {
      document.title = previousTitle;
    };
  }, []);
}

const SERVICE_BLOG_CATEGORIES = {
  'preconception': ['Preconception Care', 'Safe Pregnancy'],
};

function getAllowedCategories(slug) {
  return SERVICE_BLOG_CATEGORIES[slug] || ['Preconception Care', 'Safe Pregnancy'];
}

const RELATED_BLOG_KEYWORDS = {
  'preconception': ['preconception', 'zero trimester', 'before pregnancy', 'trying to conceive', 'fertility readiness', 'thyroid', 'tests before pregnancy'],
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

    // Get allowed categories for this page
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
                <img src={post.image || getBlogImage(post, index)} alt={post.title} loading="lazy" />
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

export default function Preconception() {
  usePreconceptionSeo();
  const [openFaq, setOpenFaq] = useState(null);
  const [heroVideoPlaying, setHeroVideoPlaying] = useState(false);
  const heroVideoRef = useRef(null);

  const handleHeroVideoPlay = () => {
    setHeroVideoPlaying(true);
    const video = heroVideoRef.current;
    if (!video) return;

    const playPromise = video.play();
    if (playPromise?.catch) {
      playPromise.catch(() => {
        // Native controls remain visible if the browser blocks programmatic playback.
      });
    }
  };

  useEffect(() => {
    document.body.classList.add('pcw-route');
    return () => document.body.classList.remove('pcw-route');
  }, []);

  return (
    <div className="pcw-page preconception-page">
      <section className="preconception-hero">
        <div className="ra-container preconception-hero-grid">
          <div className="preconception-hero-copy">
            <span className="ra-label"><Baby size={16} /> Zero Trimester Planning</span>
            <h1>Prepare For Pregnancy With <em>Clarity</em></h1>
            <p>
              A focused counselling pathway for couples who want to understand fertility, testing,
              nutrition, and timing before pregnancy begins.
            </p>
            <div className="preconception-hero-actions">
              <Link className="ra-btn ra-btn-primary preconception-hero-cta" to="/preconception-workshop">
                <CalendarCheck size={18} />
                Join Preconception Workshop
              </Link>
            </div>
          </div>

          <div className="preconception-hero-media">
            <div className="preconception-hero-video-wrap">
              <video
                className="preconception-hero-video"
                controls={heroVideoPlaying}
                playsInline
                poster={`${ASSET_PATH}hero-video-cover.jpg`}
                preload="metadata"
                ref={heroVideoRef}
              >
                <source src={PRECONCEPTION_VIDEO_URL} type="video/mp4" />
              </video>
              {!heroVideoPlaying && (
                <button
                  aria-label="Play preconception counselling video"
                  className="preconception-hero-video-trigger"
                  onClick={handleHeroVideoPlay}
                  type="button"
                >
                  <img
                    alt="Preconception counselling with Dr. Rajeev Agarwal"
                    src={`${ASSET_PATH}hero-video-cover.jpg`}
                  />
                  <span className="preconception-hero-play" aria-hidden="true">
                    <Play size={30} fill="currentColor" />
                  </span>
                </button>
              )}
            </div>
            <div className="preconception-floating-note">
              <strong>Guided by Dr. Rajeev Agarwal</strong>
              <span>25+ years in fertility and reproductive medicine</span>
            </div>
          </div>

          <aside className="preconception-plan-panel" id="preconception-planning" aria-label="Preconception planning checklist">
            <div className="preconception-plan-card">
              <div className="preconception-plan-intro">
                <span className="ra-label"><ShieldCheck size={16} /> Planning Checklist</span>
                <h2>Start With The Right Pre-Pregnancy Questions</h2>
                <p>
                  Use this page as a starting point for a more structured preconception conversation,
                  so your consultation can focus on what matters for your health and timeline.
                </p>
              </div>
              <div className="preconception-plan-grid">
                {planningHighlights.map(({ title, text, icon: Icon }) => (
                  <article className="preconception-plan-item" key={title}>
                    <span><Icon size={20} /></span>
                    <h3>{title}</h3>
                    <p>{text}</p>
                  </article>
                ))}
              </div>
            </div>
          </aside>
        </div>
      </section>

      <section className="preconception-section preconception-pillars-section">
        <div className="ra-container">
          <div className="ra-section-head">
            <span className="ra-label"><ShieldCheck size={16} /> What You Will Get</span>
            <h2>Preconception Care That Feels <em>Practical</em></h2>
          </div>
          <div className="preconception-pillar-grid">
            {pillars.map(({ title, text, icon: Icon }) => (
              <article className="preconception-pillar-card" key={title}>
                <span><Icon size={22} /></span>
                <h3>{title}</h3>
                <p>{text}</p>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="preconception-section preconception-proof-section">
        <div className="ra-container preconception-proof-layout">
          <div className="preconception-proof-copy">
            <span className="ra-label"><Baby size={16} /> Real Stories</span>
            <h2>Couples Leave With More <em>Confidence</em></h2>
            <p>
              The counselling approach is designed to reduce guesswork before pregnancy planning. These
              stories and photographs reflect the kind of clarity and reassurance couples look for.
            </p>
            <div className="preconception-story-grid">
              {storyImages.map(([image, alt]) => (
                <img alt={alt} key={image} loading="lazy" src={`${ASSET_PATH}${image}`} />
              ))}
            </div>
          </div>
          <div className="preconception-review-grid">
            {reviews.map((review) => (
              <article className="preconception-review-card" key={review.name}>
                <img alt={`${review.name} review avatar`} loading="lazy" src={`${ASSET_PATH}user-icon.jpg`} />
                <p>"{review.text}"</p>
                <strong>{review.name}</strong>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="preconception-section preconception-fit-section">
        <div className="ra-container preconception-split">
          <div>
            <span className="ra-label"><HeartPulse size={16} /> Who Should Attend</span>
            <h2>Built For Couples Who Want A Calm, Informed <em>Start</em></h2>
            <p>
              This is not a pressure-heavy treatment pitch. It is a structured session that
              helps you decide what matters for your body, your partner, and your timeline.
            </p>
          </div>
          <div className="preconception-list-panel">
            {suitableFor.map((item) => (
              <span key={item}><CheckCircle size={20} /> {item}</span>
            ))}
          </div>
        </div>
      </section>

      <section className="preconception-section preconception-agenda-section">
        <div className="ra-container">
          <div className="preconception-agenda-card">
            <div className="preconception-agenda-head">
              <div>
                <span className="ra-label"><BookOpen size={16} /> Care Outline</span>
                <h2>What The Counselling <em>Covers</em></h2>
                <p>Six practical areas, designed to help you make calmer decisions before pregnancy.</p>
              </div>
              <a className="ra-btn ra-btn-soft" href="/book-an-appointment">Discuss Care Plan</a>
            </div>
            <div className="preconception-agenda-grid">
              {agenda.map(({ title, text, icon: Icon, points }, index) => (
                <article className="preconception-agenda-module" key={title}>
                  <div className="preconception-module-top">
                    <span><Icon size={22} /></span>
                    <strong>{String(index + 1).padStart(2, '0')}</strong>
                  </div>
                  <h3>{title}</h3>
                  <p>{text}</p>
                  <ul>
                    {points.map((point) => (
                      <li key={point}><CheckCircle size={15} /> {point}</li>
                    ))}
                  </ul>
                </article>
              ))}
            </div>
          </div>
        </div>
      </section>

      <section className="preconception-section preconception-expert-section">
        <div className="ra-container">
          <div className="preconception-expert-card">
            <img
              alt="Dr. Rajeev Agarwal, Senior IVF Specialist"
              src={`${ASSET_PATH}expert-dr-rajeev-agarwal.jpg`}
              loading="lazy"
            />
            <div>
              <span className="ra-label"><Stethoscope size={16} /> Expert Led</span>
              <h2>Dr. Rajeev Agarwal</h2>
              <p>Senior IVF Specialist with 25+ years of experience and 10,000+ patient journeys guided.</p>
            </div>
          </div>
        </div>
      </section>

      <section className="preconception-section preconception-awards-section">
        <div className="ra-container">
          <div className="ra-section-head">
            <span className="ra-label"><Sparkles size={16} /> Recognition</span>
            <h2>Awards & <em>Recognition</em></h2>
          </div>
          <div className="preconception-awards-grid" aria-label="Awards and recognitions">
            {awardImages.map(([image, alt]) => (
              <figure key={image}>
                <img alt={alt} loading="lazy" src={`${ASSET_PATH}${image}`} />
              </figure>
            ))}
          </div>
        </div>
      </section>

      <section className="ra-section ra-section-blue">
        <div className="ra-container ra-faq">
          <div className="ra-section-head">
            <span className="ra-label">FAQ</span>
            <h2>Frequently Asked <em>Questions</em></h2>
          </div>
          <div className="ra-faq-accordion">
            {faqs.map((item, i) => {
              const open = openFaq === i;
              return (
                <div key={i} className={`ra-faq-item ${open ? 'ra-faq-item--open' : ''}`}>
                  <button className="ra-faq-q" onClick={() => setOpenFaq(open ? null : i)}>
                    <span>{item.title}</span>
                    <span className={`ra-faq-icon ${open ? 'ra-faq-icon--open' : ''}`}>
                      <ChevronDown size={18} />
                    </span>
                  </button>
                  <div className={`ra-faq-a-wrap ${open ? 'ra-faq-a-wrap--open' : ''}`}>
                    <div className="ra-faq-a">{item.text}</div>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </section>

      <RelatedBlogs serviceSlug="preconception" serviceTitle="Preconception Care" />

      <section className="preconception-final-cta">
        <div className="ra-container preconception-final-panel">
          <div>
            <span className="ra-label"><Sparkles size={16} /> Preconception Visit</span>
            <h2>Plan Your Preconception Consultation With Clear Questions.</h2>
            <p>
              Bring your cycle details, medical history, and current questions. The goal is to
              understand what to check now, what can wait, and how to prepare before pregnancy.
            </p>
          </div>
          <a className="ra-btn ra-btn-primary" href="/book-an-appointment">Book Appointment</a>
        </div>
      </section>
    </div>
  );
}
