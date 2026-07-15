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
  Video,
} from 'lucide-react';
import { WorkshopRegistrationForm } from './PreconceptionWorkshop';

const ASSET_PATH = '/assets/preconception-workshop/';

const heroBullets = [
  'For couples planning pregnancy in the next few months',
  'For partners who want clear tests, timing, nutrition, and lifestyle guidance',
  'For anyone who wants to prepare before fertility worries become urgent',
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
    points: ['Natural conception plan', 'IVF readiness if needed', 'Live QnA with the expert'],
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
    text: 'We had doubts about when to start, what to eat, and what tests to do. The workshop made us feel prepared instead of anxious.',
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
    const title = 'Preconception Counselling Workshop | Dr. Rajeev Agarwal';
    const description =
      'Register for Dr. Rajeev Agarwal’s preconception counselling workshop and prepare for pregnancy with clear fertility, nutrition, and testing guidance.';
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
      <section className="pcw-announcement" aria-label="Preconception workshop announcement">
        <div className="ra-container">
          <Sparkles size={17} />
          <span>Live preconception counselling workshop with Dr. Rajeev Agarwal - registration includes secure Razorpay payment</span>
        </div>
      </section>

      <section className="preconception-hero">
        <div className="ra-container preconception-hero-grid">
          <div className="preconception-hero-copy">
            <span className="ra-label"><Baby size={16} /> Zero Trimester Planning</span>
            <h1>Prepare For Pregnancy With <em>Clarity</em></h1>
            <p>
              A focused online workshop for couples who want to understand fertility, testing,
              nutrition, and timing before pregnancy begins.
            </p>
            <ul className="preconception-check-list">
              {heroBullets.map((item) => (
                <li key={item}><CheckCircle size={18} /> {item}</li>
              ))}
            </ul>
            <div className="preconception-hero-meta" aria-label="Workshop highlights">
              <span><Video size={17} /> Online live class</span>
              <span><CalendarCheck size={17} /> 1.5 hours + QnA</span>
              <span><ShieldCheck size={17} /> Seat at ₹599</span>
            </div>
          </div>

          <div className="preconception-hero-media">
            <img
              alt="Preconception counselling workshop with Dr. Rajeev Agarwal"
              src={`${ASSET_PATH}hero-video-cover.jpg`}
            />
            <div className="preconception-floating-note">
              <strong>Guided by Dr. Rajeev Agarwal</strong>
              <span>25+ years in fertility and reproductive medicine</span>
            </div>
          </div>

          <aside className="preconception-form-panel" id="workshop-registration" aria-label="Workshop registration form">
            <div className="pcw-form-card">
              <div className="pcw-form-card-head">
                <span>Workshop Registration</span>
                <strong>₹599</strong>
              </div>
              <WorkshopRegistrationForm />
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
              The workshop is designed to reduce guesswork before pregnancy planning. These
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
                <span className="ra-label"><BookOpen size={16} /> Class Outline</span>
                <h2>What The Workshop <em>Covers</em></h2>
                <p>Six practical modules, designed to help you make calmer decisions before pregnancy.</p>
              </div>
              <a className="ra-btn ra-btn-soft" href="#workshop-registration">Reserve Seat</a>
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
            <span className="ra-label"><Sparkles size={16} /> Registration</span>
            <h2>Register First. Pay Securely Through Razorpay.</h2>
            <p>
              Submit your name, phone number, and email. Your details are sent to the workshop
              webhook, then the Razorpay payment window opens to confirm your seat.
            </p>
          </div>
          <a className="ra-btn ra-btn-primary" href="#workshop-registration">Join The Workshop @ ₹599</a>
        </div>
      </section>
    </div>
  );
}
