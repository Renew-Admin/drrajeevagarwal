import { useEffect, useMemo, useRef, useState } from 'react';
import {
  Baby,
  BookOpen,
  CalendarCheck,
  CheckCircle,
  ChevronDown,
  CreditCard,
  ExternalLink,
  HeartPulse,
  Play,
  ShieldCheck,
  Sparkles,
  Star,
  Stethoscope,
  Video,
  X,
} from 'lucide-react';
import { submitWorkshopRegistration } from '../lib/supabaseBlogAdmin';

const ASSET_PATH = '/assets/preconception-workshop/';
const VIDEO_URL = '/assets/2026/02/sir-video-new-com.mp4';
const RAZORPAY_PAYMENT_URL = 'https://rzp.io/rzp/PTsszpU';
const WORKSHOP_START = new Date('2026-08-01T11:00:00+05:30').getTime();

const foundations = [
  { title: 'Couple Planning', image: 'couple-planning-icon.png', alt: 'Couple planning icon' },
  { title: 'Smart Testing', image: 'smart-testing-icon.png', alt: 'Smart fertility testing icon' },
  { title: 'Mental Preparedness', image: 'mental-preparedness-icon.png', alt: 'Mental preparedness icon' },
  { title: 'Nutrition for Conception', image: 'nutrition-for-conception-icon.png', alt: 'Nutrition for conception icon' },
  { title: 'Hormonal Awareness', image: 'hormonal-awareness-icon.png', alt: 'Hormonal awareness icon' },
  { title: 'Know Your Fertility', image: 'fertility-icon.png', alt: 'Know your fertility icon' },
];

const learningItems = [
  {
    title: 'Understanding Your Fertility Baseline',
    text: 'Learn how age, cycles, lifestyle, nutrition, and health patterns influence fertility.',
  },
  {
    title: 'What Matters Now vs. What Can Wait',
    text: 'Understand which tests, changes, or interventions are relevant at your stage.',
  },
  {
    title: 'Prepare Your Body Without Pressure',
    text: 'Through our pre pregnancy classes, you will discover practical ways to support fertility through pre conception nutrition and routine tweaks.',
  },
  {
    title: 'Making Confident And Informed Choices',
    text: 'Learn how to decide when to relax, when to act, and how to plan ahead without fear.',
  },
];

const whyJoin = [
  'Prepare your body, mind, and emotions for natural conception',
  'Understand and support hormonal balance and fertility health',
  'Create a nurturing foundation for pregnancy',
];

const happinessImages = [
  ['happiness-01.jpg', 'Happy family after fertility treatment with Dr. Rajeev Agarwal'],
  ['happiness-02.jpg', 'Couple celebrating a fertility care milestone'],
  ['happiness-03.jpg', 'Parenthood success story from Dr. Rajeev Agarwal'],
  ['happiness-04.jpg', 'Family sharing a fertility care success moment'],
  ['happiness-05.jpg', 'Couple holding their baby after fertility support'],
  ['happiness-06.jpg', 'Fertility success story with a newborn'],
  ['happiness-07.jpg', 'Parents smiling with their baby'],
  ['happiness-08.jpg', 'Happy couple after guided fertility care'],
];

const testimonials = [
  {
    name: 'Mr & Mrs Gupta',
    text: 'What I liked most was the honesty about Dr Rajeev. No unnecessary tests, no pressure, just the right guidance for our situation.',
  },
  {
    name: 'Mr & Mrs Tanuja',
    text: 'I never realised small things like Vitamin D, stress, or sleep could affect fertility so much. Dr. Rajeev’s counselling made it easy to understand and follow.',
  },
  {
    name: 'Mr & Mrs Singhania',
    text: 'We always thought fertility planning is only for women. PCC included both of us, and that made a big difference to our confidence as a couple.',
  },
  {
    name: 'Mr & Mrs Soni',
    text: 'We were married for 1 year and planning for a baby, but we had so many doubts - when to start, what to eat, what tests to do. PCC cleared everything and made us feel ready.',
  },
];

const expertStats = [
  { value: '25+ years', label: 'Experience', image: 'check-con.png', alt: 'Experience icon' },
  { value: '10,000+', label: 'Successful IVF Cases', image: 'multi-user.png', alt: 'Successful patient cases icon' },
  { value: 'MD, MS', label: '(OBGYN)', image: 'address.png', alt: 'Medical qualification icon' },
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
  ['award-09.png', 'Professional recognition award'],
  ['award-10.png', 'Medical conference recognition'],
  ['award-11.png', 'Clinical excellence award'],
  ['award-12.png', 'Healthcare contribution award'],
  ['award-13.png', 'Dr. Rajeev Agarwal professional award'],
];

const faqs = [
  {
    title: "Will this preconception planning workshop help us if we haven't been diagnosed with a fertility issue?",
    text: 'Yes. Many people choose to attend the pre-pregnancy class not because something is wrong, but because they want to understand their reproductive health a bit better. This couple fertility planning workshop focuses on education and reassurance to help you make small and meaningful changes in your life.',
  },
  {
    title: 'Does this preconception workshop include guidance for men as well?',
    text: 'Yes. Fertility is a shared journey. This couple preconception workshop places emphasis on Men & Partner Health, as it plays a defining role in conception outcomes. Through this workshop we help couples approach shared pregnancy preparation in a well-informed manner.',
  },
  {
    title: 'Is this an online webinar?',
    text: 'This is a live, online, webinar-style preconception program that will be conducted on Zoom. The session is going to run for approximately 1.5 to 2 hours. Couples often find that the online format allows them to absorb information comfortably, ask questions openly, and reflect together, making it an effective and accessible pre pregnancy workshop experience.',
  },
];

const seoMoreSections = [
  {
    paragraphs: [
      'Preconception care is the medical and lifestyle guidance that is given during this stage. The preconception counseling definition includes evaluating health conditions, reviewing menstrual cycles, understanding fertility timelines, and preparing yourself physically and emotionally for pregnancy.',
      'This workshop brings all of that together in one structured, thoughtful, and interactive session so that you are able to enter pregnancy informed and confident.',
    ],
  },
  {
    heading: 'What Is a Preconception Workshop?',
    paragraphs: [
      'A preconception workshop is a guided session that is focused on preparing for pregnancy before you start trying. It is not a treatment and it has nothing to do with rushing you into decisions. The idea is to help you understand:',
    ],
    list: [
      'Your fertility baseline',
      'Your realistic timeline',
      'Which tests matter and which do not',
      'How lifestyle and hormones influence conception',
      'When to relax and when to act',
    ],
  },
  {
    heading: 'Why Is Preconception Care Important?',
    paragraphs: [
      'The importance of preconception care for a healthy pregnancy lies in identifying risks and preparing effectively. Many concerns develop gradually through unmanaged thyroid issues, undetected hormonal imbalances, poor sleep, high stress, nutritional deficiencies, and delayed investigations. Understanding these early can significantly change outcomes.',
      'Preconception counseling is important for these reasons:',
    ],
    list: [
      'It identifies manageable health concerns early',
      'It improves egg and sperm health through timely changes',
      'It prevents unnecessary panic or over-treatment',
      'It supports healthier natural conception',
      'It improves IVF readiness, if required',
      'It reduces confusion and emotional stress',
    ],
    outro: 'The real benefits of preconception care are clarity, knowledge, and confidence. Couples often realize that they were either worrying unnecessarily or delaying something important without knowing it.',
  },
  {
    heading: 'Who Should Attend This Workshop?',
    paragraphs: ['The preconception workshop for couples in India is suitable for:'],
    list: [
      'Couples planning pregnancy in the next 6-24 months',
      'Couples trying but unsure if they should wait or investigate',
      'Individuals wanting clarity about their reproductive health',
      'Couples with past pregnancy loss',
      'Couples with failed IVF cycles',
      'First-time parents who want structured guidance',
      'People with PCOS, thyroid disorders, diabetes, or lifestyle concerns',
    ],
    outro: 'For anyone wondering whether preconception counseling is necessary, the answer is yes if you want to enter pregnancy prepared rather than reactive.',
  },
  {
    heading: 'What You Will Learn in the Workshop',
    paragraphs: [
      'Our scientific pregnancy planning workshop has been divided into practical and easy-to-understand sections. You will understand your fertility baseline, what matters now, how to prepare your body for conception, and how preconception preparation can support IVF readiness if treatment is needed.',
    ],
  },
  {
    heading: 'About the Expert - Dr. Rajeev Agarwal',
    paragraphs: [
      'Dr. Rajeev Agarwal is a senior IVF specialist with over 25 years of experience in reproductive medicine. In a career spanning excellence and visionary care, Dr. Rajeev has guided 10,000+ patients, conducted 8,000+ IVF cycles, reported a 70% IVF success rate, authored 20+ chapters in fertility textbooks, and assumed leadership roles in FOGSI and ISAR.',
      'What makes his approach different is clarity. He does not rush couples into treatment, but explains timelines, discusses options honestly, and prioritizes informed decision-making. Through years of practice, he has observed that when couples understand their fertility health early, they are able to make calmer and better decisions.',
    ],
  },
  {
    heading: 'Additional Frequently Asked Questions',
    faq: [
      [
        'How can preconception planning improve pregnancy outcomes?',
        'Preconception planning improves pregnancy outcomes by helping individuals and couples address health and hormonal factors before conception happens. Through structured preconception care and personalized preconception counseling, couples can identify issues and take corrective measures early.',
      ],
      [
        'How long before trying to conceive should I start preconception planning?',
        'Ideally, preconception care should begin three to six months before trying to conceive. Many couples also start planning 6 to 24 months in advance, and that is completely appropriate.',
      ],
      [
        'Can preconception planning help with IVF or fertility treatments?',
        'Yes. A preconception workshop for IVF preparation can help optimize your body and mind before beginning treatment. This includes reviewing hormone balance, cycle health, nutrition, weight management, and stress levels, all of which can influence IVF response.',
      ],
      [
        'Are preconception workshops suitable for first-time parents?',
        'Yes. First-time parents often benefit the most. A pre-pregnancy workshop for first-time parents can provide structured, science-backed clarity, explain cycles and timelines, debunk fertility myths, and set realistic expectations.',
      ],
      [
        'How does a preconception workshop differ from regular prenatal care?',
        'Prenatal care begins after pregnancy is confirmed, while preconception care begins before pregnancy. Preconception care focuses on preparing your body and health before conception, whereas prenatal care monitors and supports an ongoing pregnancy.',
      ],
    ],
  },
];

const popularSearches = [
  ['Women\'s Health Checkup', '/womens-health-check'],
  ['Fertility & Gynecological Services', '/all-services'],
  ['Fertility Support Services', '/fertility-support-services'],
  ['Infertility Help', '/infertility-help'],
  ['Healthy Aging Programs', '/healthy-aging'],
  ['Sexual Pain Relief Therapy', '/sexual-pain-relief'],
  ['Laparoscopic Surgery', '/laparoscopic-surgery'],
  ['Period Pain Support', '/period-pain-relief'],
  ['Menopause Wellness', '/menopause-wellness'],
  ['PCOS Care', '/pcos-care'],
];

const popularBlogs = [
  ['Understanding The Role Of Genetics In IVF Success', '/understanding-the-role-of-genetics-in-ivf-success'],
  ['Battling Blood Sugar During Pregnancy', '/battling-blood-sugar-during-pregnancy-gestational-diabetes-risks'],
  ['How Sleep Affects Hormonal Balance & Fertility In Women', '/sleep-and-hormonal-balance-in-women'],
  ['Birth Control Pills For PCOS: How Long Should You Stay On Them?', '/birth-control-pills-for-pcos-how-long-should-you-stay-on-them'],
  ['Can Ovarian Stimulation Affect Your Next Period Cycle?', '/can-ovarian-stimulation-affect-your-next-period-cycle'],
];

function useSeo() {
  useEffect(() => {
    const title = 'Preconception Counseling Workshop - Prepare for a Healthy Pregnancy | Dr. Rajeev Agarwal';
    const description = 'Join our preconception care workshop to understand what is preconception, benefits of preconception care, fertility basics & expert preconception counseling.';
    const canonicalUrl = `${window.location.origin}/preconception-workshop`;
    const ogImage = `${window.location.origin}${ASSET_PATH}hero-video-cover.jpg`;
    const previousTitle = document.title;

    const ensureMeta = (selector, attrs) => {
      let element = document.head.querySelector(selector);
      if (!element) {
        element = document.createElement('meta');
        document.head.appendChild(element);
      }
      Object.entries(attrs).forEach(([key, value]) => element.setAttribute(key, value));
      return element;
    };

    document.title = title;
    ensureMeta('meta[name="description"]', { name: 'description', content: description });
    ensureMeta('meta[property="og:title"]', { property: 'og:title', content: title });
    ensureMeta('meta[property="og:description"]', { property: 'og:description', content: description });
    ensureMeta('meta[property="og:image"]', { property: 'og:image', content: ogImage });
    ensureMeta('meta[property="og:type"]', { property: 'og:type', content: 'website' });

    let canonical = document.head.querySelector('link[rel="canonical"]');
    if (!canonical) {
      canonical = document.createElement('link');
      canonical.rel = 'canonical';
      document.head.appendChild(canonical);
    }
    canonical.href = canonicalUrl;

    return () => {
      document.title = previousTitle;
    };
  }, []);
}

function getTimeLeft() {
  const diff = Math.max(0, WORKSHOP_START - Date.now());
  return {
    days: Math.floor(diff / 86400000),
    hours: Math.floor((diff / 3600000) % 24),
    minutes: Math.floor((diff / 60000) % 60),
    seconds: Math.floor((diff / 1000) % 60),
  };
}

function useCountdown() {
  const [timeLeft, setTimeLeft] = useState(getTimeLeft);

  useEffect(() => {
    const timer = window.setInterval(() => setTimeLeft(getTimeLeft()), 1000);
    return () => window.clearInterval(timer);
  }, []);

  return timeLeft;
}

function paymentPopupFeatures() {
  if (typeof window === 'undefined') return 'width=480,height=720';

  const width = Math.min(520, Math.max(360, Math.round(window.innerWidth * 0.92)));
  const height = Math.min(760, Math.max(620, Math.round(window.innerHeight * 0.88)));
  const left = Math.max(0, Math.round((window.screen.width - width) / 2));
  const top = Math.max(0, Math.round((window.screen.height - height) / 2));

  return `popup=yes,width=${width},height=${height},left=${left},top=${top},resizable=yes,scrollbars=yes`;
}

function prepareRazorpayPopup() {
  if (typeof window === 'undefined') return null;

  try {
    const popup = window.open('', 'pcwRazorpayPayment', paymentPopupFeatures());
    if (!popup) return null;

    popup.document.write(`
      <!doctype html>
      <html>
        <head><title>Opening payment</title></head>
        <body style="margin:0;min-height:100vh;display:grid;place-items:center;font-family:Arial,sans-serif;color:#0f3f3b;background:#f6f8ff;">
          <p style="padding:24px;text-align:center;font-weight:700;">Preparing your secure payment...</p>
        </body>
      </html>
    `);
    popup.document.close();
    popup.focus();
    return popup;
  } catch {
    return null;
  }
}

function openRazorpayPayment(preparedPopup = null) {
  if (typeof window === 'undefined') return false;

  try {
    if (preparedPopup && !preparedPopup.closed) {
      preparedPopup.location.href = RAZORPAY_PAYMENT_URL;
      preparedPopup.focus();
      return true;
    }

    const popup = window.open(RAZORPAY_PAYMENT_URL, 'pcwRazorpayPayment', paymentPopupFeatures());
    if (!popup) return false;

    popup.focus();
    return true;
  } catch {
    return false;
  }
}

function closePreparedPaymentPopup(preparedPopup) {
  try {
    if (preparedPopup && !preparedPopup.closed) {
      preparedPopup.close();
    }
  } catch {
    // The popup may already be cross-origin or closed by the browser.
  }
}

function PaymentPrompt({ isOpen, popupBlocked, onClose, onOpenPayment }) {
  useEffect(() => {
    if (!isOpen) return undefined;

    const handleKeyDown = (event) => {
      if (event.key === 'Escape') {
        onClose();
      }
    };

    window.addEventListener('keydown', handleKeyDown);
    return () => window.removeEventListener('keydown', handleKeyDown);
  }, [isOpen, onClose]);

  if (!isOpen) return null;

  return (
    <div className="pcw-payment-modal-backdrop" role="presentation" onClick={onClose}>
      <div
        aria-labelledby="pcw-payment-title"
        aria-modal="true"
        className="pcw-payment-modal"
        onClick={(event) => event.stopPropagation()}
        role="dialog"
      >
        <button
          aria-label="Close payment popup"
          className="pcw-payment-close"
          onClick={onClose}
          type="button"
        >
          <X size={18} />
        </button>
        <span className="pcw-payment-icon"><CreditCard size={24} /></span>
        <h2 id="pcw-payment-title">Complete Your Workshop Payment</h2>
        <p>
          {popupBlocked
            ? 'Your registration was received. Open the secure Razorpay payment window to confirm your seat.'
            : 'Your registration was received. The secure Razorpay payment window is open; use this button if you need to reopen it.'}
        </p>
        <button className="ra-btn ra-btn-primary pcw-payment-action" onClick={onOpenPayment} type="button">
          Open Razorpay Payment <ExternalLink size={17} />
        </button>
      </div>
    </div>
  );
}

export function WorkshopRegistrationForm() {
  const [formData, setFormData] = useState({ name: '', phone: '', email: '' });
  const [errors, setErrors] = useState({});
  const [submitted, setSubmitted] = useState(false);
  const [submitting, setSubmitting] = useState(false);
  const [submitError, setSubmitError] = useState('');
  const [paymentPromptOpen, setPaymentPromptOpen] = useState(false);
  const [paymentPopupBlocked, setPaymentPopupBlocked] = useState(false);
  const paymentPopupRef = useRef(null);

  const handleChange = (event) => {
    const { name, value } = event.target;
    setFormData((current) => ({ ...current, [name]: value }));
    setErrors((current) => ({ ...current, [name]: '' }));
  };

  const validate = () => {
    const nextErrors = {};
    const name = formData.name.trim();
    const phone = formData.phone.trim();
    const email = formData.email.trim();
    const digitCount = phone.replace(/\D/g, '').length;

    if (name.length < 2) {
      nextErrors.name = 'Please enter your name.';
    }

    if (!/^\+?[0-9\s()-]{7,20}$/.test(phone) || digitCount < 10 || digitCount > 15) {
      nextErrors.phone = 'Please enter a valid phone or WhatsApp number.';
    }

    if (!email) {
      nextErrors.email = 'Please enter your email.';
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      nextErrors.email = 'Please enter a valid email address.';
    }

    setErrors(nextErrors);
    return Object.keys(nextErrors).length === 0;
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    if (submitting || !validate()) return;

    setSubmitting(true);
    setSubmitError('');

    const preparedPopup = prepareRazorpayPopup();
    paymentPopupRef.current = preparedPopup;

    try {
      await submitWorkshopRegistration({
        ...formData,
        service: 'Preconception Counselling Workshop',
        course: 'Preconception Counselling Workshop',
        concern: 'Workshop registration',
        message: 'Join the Workshop @ ₹599',
      });
      setSubmitted(true);
      const openedPayment = openRazorpayPayment(preparedPopup);
      paymentPopupRef.current = null;
      setPaymentPopupBlocked(!openedPayment);
      setPaymentPromptOpen(!openedPayment);
    } catch (error) {
      closePreparedPaymentPopup(preparedPopup);
      paymentPopupRef.current = null;
      setSubmitError(error.message || 'Could not submit the workshop registration. Please try again.');
    } finally {
      setSubmitting(false);
    }
  };

  const handleOpenPayment = () => {
    const openedPayment = openRazorpayPayment(paymentPopupRef.current);
    paymentPopupRef.current = null;
    setPaymentPopupBlocked(!openedPayment);
    setPaymentPromptOpen(!openedPayment);
  };

  if (submitted) {
    return (
      <>
        <div className="pcw-form-success" role="status">
          <CheckCircle size={42} />
          <p>
            Thanks for taking the first step! Your details are with us. Complete the payment to confirm your workshop seat.
          </p>
          <button className="ra-btn ra-btn-primary pcw-payment-reopen" onClick={handleOpenPayment} type="button">
            Open Razorpay Payment <ExternalLink size={17} />
          </button>
        </div>
        <PaymentPrompt
          isOpen={paymentPromptOpen}
          onClose={() => setPaymentPromptOpen(false)}
          onOpenPayment={handleOpenPayment}
          popupBlocked={paymentPopupBlocked}
        />
      </>
    );
  }

  return (
    <form className="pcw-registration-form" onSubmit={handleSubmit} noValidate>
      <div className="form-group">
        <label className="form-label" htmlFor="pcw-name">Your Name</label>
        <input
          className={`form-control ${errors.name ? 'pcw-input-error' : ''}`}
          id="pcw-name"
          name="name"
          onChange={handleChange}
          placeholder="Enter your name"
          type="text"
          value={formData.name}
        />
        {errors.name && <span className="pcw-field-error">{errors.name}</span>}
      </div>
      <div className="form-group">
        <label className="form-label" htmlFor="pcw-phone">Phone Number / WhatsApp Number</label>
        <input
          className={`form-control ${errors.phone ? 'pcw-input-error' : ''}`}
          id="pcw-phone"
          inputMode="tel"
          name="phone"
          onChange={handleChange}
          placeholder="e.g. +91 98300 12345"
          type="tel"
          value={formData.phone}
        />
        {errors.phone && <span className="pcw-field-error">{errors.phone}</span>}
      </div>
      <div className="form-group">
        <label className="form-label" htmlFor="pcw-email">Email Address</label>
        <input
          className={`form-control ${errors.email ? 'pcw-input-error' : ''}`}
          id="pcw-email"
          name="email"
          onChange={handleChange}
          placeholder="e.g. priyanjana@example.com"
          type="email"
          value={formData.email}
        />
        {errors.email && <span className="pcw-field-error">{errors.email}</span>}
      </div>
      {submitError && <p className="form-submit-error">{submitError}</p>}
      <button className="ra-btn ra-btn-primary pcw-form-submit" type="submit" disabled={submitting}>
        {submitting ? 'Submitting...' : 'Join the Workshop @ ₹599'}
      </button>
      <PaymentPrompt
        isOpen={paymentPromptOpen}
        onClose={() => setPaymentPromptOpen(false)}
        onOpenPayment={handleOpenPayment}
        popupBlocked={paymentPopupBlocked}
      />
    </form>
  );
}

function Accordion({ items, defaultOpen = 0 }) {
  const [openIndex, setOpenIndex] = useState(defaultOpen);

  return (
    <div className="pcw-accordion">
      {items.map((item, index) => {
        const isOpen = openIndex === index;
        return (
          <article className={`pcw-accordion-item ${isOpen ? 'is-open' : ''}`} key={item.title}>
            <button
              aria-expanded={isOpen}
              className="pcw-accordion-trigger"
              onClick={() => setOpenIndex(isOpen ? -1 : index)}
              type="button"
            >
              <span>{item.title}</span>
              <ChevronDown size={20} />
            </button>
            <div className="pcw-accordion-panel">
              <p>{item.text}</p>
            </div>
          </article>
        );
      })}
    </div>
  );
}

function ImageRail({ images, className = '', imageClassName = '' }) {
  const doubled = useMemo(() => [...images, ...images], [images]);

  return (
    <div className={`pcw-media-rail ${className}`} aria-label="Image carousel">
      <div className="pcw-media-track">
        {doubled.map(([image, alt], index) => (
          <figure className={`pcw-media-card ${imageClassName}`} key={`${image}-${index}`} aria-hidden={index >= images.length}>
            <img
              alt={alt}
              loading={index < 3 ? 'eager' : 'lazy'}
              src={`${ASSET_PATH}${image}`}
            />
          </figure>
        ))}
      </div>
    </div>
  );
}

function CountdownSection() {
  const timeLeft = useCountdown();
  const countdownItems = [
    ['Days', timeLeft.days],
    ['Hours', timeLeft.hours],
    ['Minutes', timeLeft.minutes],
    ['Seconds', timeLeft.seconds],
  ];

  return (
    <section className="pcw-section pcw-schedule-section">
      <div className="ra-container pcw-schedule">
        <div className="pcw-schedule-copy">
          <span className="ra-label"><CalendarCheck size={16} /> Live Session</span>
          <h2>Register In Next</h2>
        </div>
        <div className="pcw-countdown" aria-label="Countdown to workshop start">
          {countdownItems.map(([label, value]) => (
            <div className="pcw-countdown-card" key={label}>
              <strong>{String(value).padStart(2, '0')}</strong>
              <span>{label}</span>
            </div>
          ))}
        </div>
        <div className="pcw-schedule-details">
          <span>STARTS ON August 1st 2026</span>
          <span>11:00 AM - 12:30 PM IST</span>
          <span>Language - Basic English</span>
        </div>
      </div>
    </section>
  );
}

function SeoReadMore() {
  const [expanded, setExpanded] = useState(false);

  return (
    <section className="pcw-section pcw-seo-section">
      <div className="ra-container">
        <article className="pcw-seo-panel">
          <h2>Preconception Counselling Workshop - Scientific Pregnancy Planning Before You Conceive</h2>
          <p>
            Planning a pregnancy is one of the most meaningful decisions in life, but for so many couples, it also comes with many questions about their health, fertility, and so much more. A preconception counseling workshop has been designed to answer all your questions calmly and scientifically. Before pregnancy begins, there’s a phase called preconception. The simple preconception meaning is that it is the time before you conceive when your body, hormones, lifestyle, and overall health quietly influence your future pregnancy outcomes.
          </p>

          {expanded && (
            <div className="pcw-seo-more">
              {seoMoreSections.map((section, index) => (
                <div className="pcw-seo-block" key={section.heading || index}>
                  {section.heading && <h3>{section.heading}</h3>}
                  {section.paragraphs?.map((paragraph) => <p key={paragraph}>{paragraph}</p>)}
                  {section.list && (
                    <ul>
                      {section.list.map((item) => <li key={item}>{item}</li>)}
                    </ul>
                  )}
                  {section.outro && <p>{section.outro}</p>}
                  {section.faq && (
                    <div className="pcw-seo-faq-list">
                      {section.faq.map(([question, answer]) => (
                        <div key={question}>
                          <h4>{question}</h4>
                          <p>{answer}</p>
                        </div>
                      ))}
                    </div>
                  )}
                </div>
              ))}
              <div className="pcw-seo-link-groups">
                <div>
                  <h3>Popular Searches</h3>
                  <div className="pcw-inline-links">
                    {popularSearches.map(([label, href]) => <a href={href} key={label}>{label}</a>)}
                  </div>
                </div>
                <div>
                  <h3>Popular Blogs</h3>
                  <div className="pcw-inline-links">
                    {popularBlogs.map(([label, href]) => <a href={href} key={label}>{label}</a>)}
                  </div>
                </div>
              </div>
            </div>
          )}

          <button className="pcw-read-more" type="button" onClick={() => setExpanded((value) => !value)}>
            {expanded ? 'Read Less' : 'Read More'} <ChevronDown size={18} />
          </button>
        </article>
      </div>
    </section>
  );
}

export default function PreconceptionWorkshop() {
  useSeo();

  useEffect(() => {
    document.body.classList.add('pcw-route');
    return () => document.body.classList.remove('pcw-route');
  }, []);

  return (
    <div className="pcw-page">
      <section className="pcw-announcement" aria-label="Workshop announcement">
        <div className="ra-container">
          <Sparkles size={17} />
          <span>1.5 hour online live workshop with QnA on 1st August Saturday (11:00 AM - 12:30 PM IST)</span>
        </div>
      </section>

      <section className="pcw-hero">
        <div className="ra-container pcw-hero-grid">
          <div className="pcw-video-panel">
            <div className="pcw-video-frame">
              <video
                controls
                poster={`${ASSET_PATH}hero-video-cover.jpg`}
                preload="metadata"
              >
                <source src={VIDEO_URL} type="video/mp4" />
              </video>
              <span className="pcw-video-play" aria-hidden="true"><Play size={24} fill="currentColor" /></span>
            </div>
            <div className="pcw-video-caption">
              <Video size={18} />
              Live, interactive, and designed for clear next steps before pregnancy.
            </div>
          </div>

          <div className="pcw-hero-copy">
            <h1>Preconception Counselling <em>Workshop</em></h1>
            <p className="pcw-hero-italic">Prepare for a Healthy Pregnancy</p>
            <p className="pcw-hero-intro">An interactive workshop for:</p>
            <ul className="pcw-hero-list">
              <li><CheckCircle size={18} /> Couples planning pregnancy in the coming months</li>
              <li><CheckCircle size={18} /> Couples planning later but wanting to prepare wisely</li>
              <li><CheckCircle size={18} /> Individuals who are undecided but want to protect their future fertility</li>
            </ul>
          </div>

          <div className="pcw-hero-form-slot">
            <div className="pcw-form-card" id="workshop-registration">
              <div className="pcw-form-card-head">
                <span>Workshop Registration</span>
                <strong>₹599</strong>
              </div>
              <WorkshopRegistrationForm />
            </div>
          </div>
        </div>
      </section>

      <CountdownSection />

      <section className="pcw-section pcw-foundations-section">
        <div className="ra-container">
          <div className="ra-section-head">
            <span className="ra-label"><ShieldCheck size={16} /> Preparation Pillars</span>
            <h2>Foundations of Preconception <em>Preparation</em></h2>
          </div>
          <div className="pcw-foundation-grid">
            {foundations.map((item) => (
              <article className="pcw-foundation-card" key={item.title}>
                <img src={`${ASSET_PATH}${item.image}`} alt={item.alt} loading="lazy" />
                <h3>{item.title}</h3>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="pcw-cta-band">
        <div className="ra-container">
          <a className="ra-btn ra-btn-primary" href="#workshop-registration">Join The Workshop At Just ₹599/-</a>
        </div>
      </section>

      <section className="pcw-section pcw-learning-section">
        <div className="ra-container pcw-learning-layout">
          <div className="pcw-learning-copy">
            <span className="ra-label"><BookOpen size={16} /> Class Outline</span>
            <h2>What You Will Learn From Our Childbirth <em>Preparation Classes</em></h2>
            <p>Focused guidance on fertility, tests, nutrition, and decision-making before pregnancy starts.</p>
          </div>
          <Accordion items={learningItems} />
        </div>
      </section>

      <section className="pcw-section pcw-why-section">
        <div className="ra-container pcw-why-panel">
          <div>
            <span className="ra-label"><HeartPulse size={16} /> Why Join</span>
            <h2>Why Join This Preconception <em>Counselling Workshop</em></h2>
          </div>
          <div className="pcw-why-list">
            {whyJoin.map((item) => (
              <span key={item}><CheckCircle size={20} /> {item}</span>
            ))}
          </div>
        </div>
      </section>

      <section className="pcw-section pcw-happiness-section">
        <div className="ra-container">
          <div className="ra-section-head">
            <span className="ra-label"><Baby size={16} /> Success Stories</span>
            <h2>Turning Hopes Into <em>Happiness</em></h2>
          </div>
          <ImageRail images={happinessImages} imageClassName="pcw-happiness-card" />
        </div>
      </section>

      <section className="pcw-section pcw-testimonial-section">
        <div className="ra-container">
          <div className="ra-section-head">
            <span className="ra-label"><Star size={16} /> Participant Reviews</span>
            <h2>Participants Review: Real Stories, <em>Real Transformations</em></h2>
          </div>
          <div className="pcw-testimonial-grid">
            {testimonials.map((testimonial) => (
              <article className="pcw-testimonial-card" key={testimonial.name}>
                <img src={`${ASSET_PATH}user-icon.jpg`} alt={`${testimonial.name} testimonial avatar`} loading="lazy" />
                <p>“{testimonial.text}”</p>
                <strong>{testimonial.name}</strong>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="pcw-section pcw-expert-section">
        <div className="ra-container pcw-expert-panel">
          <div className="pcw-expert-media">
            <img src={`${ASSET_PATH}expert-dr-rajeev-agarwal.jpg`} alt="Dr. Rajeev Agarwal, Senior IVF Specialist" loading="lazy" />
          </div>
          <div className="pcw-expert-copy">
            <span className="ra-label"><Stethoscope size={16} /> Meet The Expert</span>
            <h2>Meet The <em>Expert</em></h2>
            <h3>Dr. Rajeev Agarwal</h3>
            <p className="pcw-expert-role">Senior IVF Specialist</p>
            <div className="pcw-expert-stats">
              {expertStats.map((stat) => (
                <div key={stat.label}>
                  <img src={`${ASSET_PATH}${stat.image}`} alt={stat.alt} loading="lazy" />
                  <strong>{stat.value}</strong>
                  <span>{stat.label}</span>
                </div>
              ))}
            </div>
            <h4>About</h4>
            <p>
              Dr. Rajeev Agarwal is a senior IVF specialist and gynecologist with over 25 years of experience in fertility care. He is the Medical Director of Renew Healthcare and former founder of Care IVF Kolkata. Having supported 10,000+ patients and a reported 70% IVF success rate, Dr. Agarwal’s approach combines medicine with patient-first counseling to prioritize clarity over confusion.
            </p>
          </div>
        </div>
      </section>

      <section className="pcw-section pcw-awards-section">
        <div className="ra-container">
          <div className="ra-section-head">
            <span className="ra-label"><Star size={16} /> Recognition</span>
            <h2>Awards & <em>Recognitions</em></h2>
          </div>
          <ImageRail images={awardImages} className="pcw-awards-rail" imageClassName="pcw-award-card" />
        </div>
      </section>

      <section className="pcw-section pcw-faq-section">
        <div className="ra-container">
          <div className="ra-section-head">
            <span className="ra-label"><Sparkles size={16} /> Questions</span>
            <h2>Frequently Asked <em>Questions</em></h2>
          </div>
          <Accordion items={faqs} />
        </div>
      </section>

      <SeoReadMore />
    </div>
  );
}
