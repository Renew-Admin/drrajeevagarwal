import { useEffect } from 'react';
import {
  Baby,
  BookOpen,
  CalendarCheck,
  CheckCircle,
  HeartPulse,
  ShieldCheck,
  Sparkles,
  Stethoscope,
} from 'lucide-react';

const ASSET_PATH = '/assets/preconception-workshop/';

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

export default function Preconception() {
  usePreconceptionSeo();

  useEffect(() => {
    document.body.classList.add('pcw-route');
    return () => document.body.classList.remove('pcw-route');
  }, []);

  return (
    <div className="pcw-page preconception-page">
      <section className="pcw-announcement" aria-label="Preconception counselling announcement">
        <div className="ra-container">
          <Sparkles size={17} />
          <span>Preconception counselling guidance with Dr. Rajeev Agarwal for calmer pregnancy planning before you conceive</span>
        </div>
      </section>

      <section className="preconception-hero">
        <div className="ra-container preconception-hero-grid">
          <div className="preconception-hero-copy">
            <span className="ra-label"><Baby size={16} /> Zero Trimester Planning</span>
            <h1>Prepare For Pregnancy With <em>Clarity</em></h1>
            <p>
              A focused counselling pathway for couples who want to understand fertility, testing,
              nutrition, and timing before pregnancy begins.
            </p>
          </div>

          <div className="preconception-hero-media">
            <img
              alt="Preconception counselling with Dr. Rajeev Agarwal"
              src={`${ASSET_PATH}hero-video-cover.jpg`}
            />
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
