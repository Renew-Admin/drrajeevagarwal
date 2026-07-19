import React, { useEffect, useMemo, useState, useRef } from 'react';
import { Link } from 'react-router-dom';
import useSeo from '../utils/useSeo';
import { getMetaForPath } from '../utils/seoMeta';
import {
  Baby,
  BookOpen,
  CalendarCheck,
  ArrowLeft,
  ArrowRight,
  ChevronDown,
  HeartPulse,
  Menu,
  MessageCircle,
  Play,
  ShieldCheck,
  Sparkles,
  Star,
  Stethoscope,
  Video,
  X,
} from 'lucide-react';
import { blogsData } from '../data/blogs_data';
import { buildBlogPresentation } from '../utils/blogPresentation';
import Footer from '../components/Footer';
import FloatingLeadForm from '../components/FloatingLeadForm';
import heroImg from '../assets/image.webp';
import aboutImg from '../assets/about_us.webp';
import videoBarImg from '../assets/about_us_video_thumb.webp';

const img = (path) => path;

const concernServices = [
  {
    title: 'Fertility Support',
    href: '/fertility-support-services',
    image: img('/assets/2025/01/fertility-support.webp'),
    text: 'Guided evaluation and treatment planning for couples trying to conceive.',
  },
  {
    title: 'PCOS Care',
    href: '/pcos-care',
    image: img('/assets/2025/01/PCOS.webp'),
    text: 'Hormonal, metabolic and fertility-focused PCOS care with clear next steps.',
  },
  {
    title: 'Period Pain Relief',
    href: '/period-pain-relief',
    image: img('/assets/2025/01/Period-Pain.webp'),
    text: 'Diagnosis-led care for painful periods, endometriosis and pelvic pain.',
  },
  {
    title: 'Infertility Help',
    href: '/infertility-help',
    image: img('/assets/2025/01/Infertility-support.webp'),
    text: 'Evidence-based infertility support for female, male and combined factors.',
  },
  {
    title: 'Menopause Wellness',
    href: '/menopause-wellness',
    image: img('/assets/2025/01/Menopausal-Wellness.webp'),
    text: 'Warm, practical support for symptoms, hormones and long-term wellness.',
  },
  {
    title: 'Fibroid Solutions',
    href: '/fibroids-solutions',
    image: img('/assets/2025/01/Fibroid.webp'),
    text: 'Personalised fibroid treatment with fertility-preserving options where possible.',
  },
];

const procedureServices = [
  {
    title: 'Preconception Care',
    href: '/preconception',
    image: img('/assets/2026/05/Husband-and-wife-at-preconception-consultation-with-fertility-specialist-in-Kolkata-515x400.webp'),
    text: 'Prepare the body and mind before pregnancy with the right clinical checks.',
  },
  {
    title: 'Fertility Treatments',
    href: '/advanced-fertility-treatments',
    image: img('/assets/2025/04/couple-consulting-with-young-doctor_23-2147648728-515x400.jpg'),
    text: 'IVF, IUI and advanced fertility treatment planning under one specialist.',
  },
  {
    title: 'Vaginismus Therapy',
    href: '/vaginismus-therapy',
    image: img('/assets/2025/03/Vaginismus-Therapy-1-515x400.webp'),
    text: 'Sensitive, structured treatment for painful intercourse and vaginismus.',
  },
  {
    title: 'Urinary Laser Therapy',
    href: '/urinary-laser-therapy',
    image: img('/assets/2025/04/urinary-incontinence-cystitis-involuntary-urination-woman-vector-illustration-bladder-problems-menopause-woman-health-genital-infection-hygiene-female-problems_176448-35-515x357.jpg.webp'),
    text: 'Modern non-surgical support for urinary and intimate wellness concerns.',
  },
  {
    title: 'Laparoscopic Surgery',
    href: '/laparoscopic-surgery',
    image: img('/assets/2025/03/Laparoscopic-Surgery-1-515x400.webp'),
    text: 'Minimally invasive gynaecological surgery with fertility-conscious planning.',
  },
  {
    title: 'Hysteroscopic Procedure',
    href: '/hysteroscopic-procedure',
    image: img('/assets/2025/03/Hysteroscopic-Procedure-515x400.webp'),
    text: 'Precise uterine evaluation and treatment for fertility and bleeding concerns.',
  },
];

const dropdownConcerns = [
  { title: 'All Services', href: '/all-services' },
  ...concernServices,
  { title: 'Urinary Health', href: '/urinary-incontinence' },
  { title: 'Healthy Aging', href: '/healthy-aging' },
  { title: 'Sexual Pain Relief', href: '/sexual-pain-relief' },
];

const dropdownProcedures = [
  ...procedureServices,
  { title: 'Virtual Consults', href: '/virtual-consults' },
  { title: 'Women\'s Health Check', href: '/womens-health-check' },
];

const awards = [
  ['1st Anniversary of Renew', '/assets/2025/04/1ST-ANNIVERSARY-OF-RENEW-2022.webp'],
  ['Pregnancy Book Launch', '/assets/2025/04/LAUNCH-OF-PREGNANCY-BOOK-AND-RENEWING-HOPE-FOUNDATION.webp'],
  ['ASPIRE Malaysia', '/assets/2025/04/ASPIRE-MALAYSIA-2017.webp'],
  ['ISAR National Conference', '/assets/2025/04/ISAR-NATIONAL-CONFERENCE.webp'],
  ['Awareness Camp', '/assets/2025/04/AWARENESS-CAMP-AT-LA-MARTINIERE-SCHOOL.webp'],
  ['ACE Pune', '/assets/2025/04/ACE-PUNE-2024.webp'],
];

const stories = [
  ['A Patient Journey of Hope', '/assets/2025/04/Laying-the-Foundation-of-a-Medical-Dream-515x400.webp'],
  ['Parenthood After Treatment', '/assets/2025/04/ZIOyJuCiap8-HD-515x400.webp'],
  ['Gratitude From Families', '/assets/2025/04/12LCASXxv30-HD-515x400.webp'],
];

const pressLogos = [
  ['Times of India', '/assets/2025/04/Times-of-India-logo-vector-01-4.svg'],
  ['Hindustan Times', '/assets/2025/04/Hindustan_Times_logo-1.svg'],
  ['Financial Express', '/assets/2025/04/The_Financial_Express_India_Logo-1.svg'],
  ['Mint', '/assets/2025/04/Mint_newspaper_logo-1.svg'],
  ['MSN', '/assets/2025/04/2024_new_msn_logo-1.svg'],
  ['DocTube', '/assets/2025/04/doctube_logo-1.svg'],
  ['Zee News', '/assets/2025/04/Zee_news-1.svg'],
];

const instagramFeed = [
  ['Instagram post from docrajeevagarwal', '/assets/inavii-social-feed/18039042062394748-m.jpg', 'https://www.instagram.com/reel/DH3qMX6v8f8/'],
  ['Instagram post from docrajeevagarwal', '/assets/inavii-social-feed/18320255338207237-m.jpg', 'https://www.instagram.com/reel/DHyShB8vEX-/'],
  ['Instagram post from docrajeevagarwal', '/assets/inavii-social-feed/17950453085810318-m.jpg', 'https://www.instagram.com/reel/DHs9Agisnsb/'],
  ['Instagram post from docrajeevagarwal', '/assets/inavii-social-feed/18063928975801964-m.jpg', 'https://www.instagram.com/reel/DHnKn7CP0Le/'],
  ['Instagram post from docrajeevagarwal', '/assets/inavii-social-feed/17999116445767676-m.jpg', 'https://www.instagram.com/reel/DHlU2N0PUyv/'],
];

const courses = [
  { title: 'Fertility Without Borders', status: 'Coming Soon', desc: 'Practical fertility education you can follow from anywhere, with clear guidance for every stage.', points: ['Global fertility basics', 'Modern conception planning', 'Care without travel stress'] },
  { title: 'Improving Egg Quality Program', status: 'Coming Soon', desc: 'A focused learning program for understanding egg health, age, lifestyle, and preparation.', points: ['Egg quality science', 'Nutrition and lifestyle planning', 'A practical 90 day roadmap'] },
  { title: 'IVF Little Big Things', status: 'Coming Soon', desc: 'A patient friendly class on the small IVF details that can make treatment feel clearer.', points: ['Cycle preparation', 'Transfer readiness', 'Emotional support tools'] },
  { title: 'Preconception Counseling Workshop', status: 'Coming Soon', desc: 'A guided workshop on what matters before pregnancy and how couples can prepare well.', points: ['Useful health checks', 'Nutrition and lifestyle basics', 'Confident next steps'] },
  { title: 'PCOS Conception Workshop', status: 'Coming Soon', desc: 'A complete guide to PCOS, fertility planning, pregnancy preparation, and long term wellness.', points: ['Ovulation and hormones', 'Conception planning', 'Long term PCOS care'] },
  { title: 'IUI Success Planning', status: 'Coming Soon', desc: 'Simple clinical guidance to understand timing, preparation, and realistic IUI expectations.', points: ['Cycle timing', 'Sperm and uterus readiness', 'Supportive lifestyle changes'] },
];

const events = [
  { title: 'Renew First Anniversary', image: '/assets/2025/04/1ST-ANNIVERSARY-OF-RENEW-2022.webp' },
  { title: 'ACE PUNE 2024', image: '/assets/2025/04/ACE-PUNE-2024.webp' },
  { title: 'ASPIRE MALAYSIA 2017', image: '/assets/2025/04/ASPIRE-MALAYSIA-2017.webp' },
  { title: 'La Martiniere Awareness Camp', image: '/assets/2025/04/AWARENESS-CAMP-AT-LA-MARTINIERE-SCHOOL.webp' },
  { title: 'BOGS Conference', image: '/assets/2025/04/BOGS-CONFERENCE-2017.webp' },
  { title: 'Ian Donald Conference', image: '/assets/2025/04/IAN-DONALD-CONFERENCE-.webp' },
  { title: 'Instar Conference', image: '/assets/2025/04/INSTAR-CONFERENCE-.webp' },
  { title: 'ISAR National Conference', image: '/assets/2025/04/ISAR-NATIONAL-CONFERENCE-1.webp' },
  { title: 'Pregnancy Book Launch', image: '/assets/2025/04/LAUNCH-OF-PREGNANCY-BOOK-AND-RENEWING-HOPE-FOUNDATION.webp' },
  { title: 'Yuva ISAR Conference 2017', image: '/assets/2025/04/Yuva-ISAR-Conference-2017.webp' },
];

const faqs = [
  [
    'How can I book an appointment with Dr. Rajeev Agarwal?',
    'You can book an appointment by calling +91 83369 68661, or through the online booking form on this website. Our team will confirm your slot and share consultation details.',
  ],
  [
    'What fertility treatments are available?',
    'Dr. Rajeev Agarwal offers a full range of fertility treatments including IVF, IUI, ICSI, fertility preservation, laparoscopic surgeries, and personalised care for PCOS, fibroids, endometriosis, and male factor infertility.',
  ],
  [
    'When should I consult a fertility specialist?',
    'If you are under 35 and have been trying to conceive for over a year (or six months if over 35), have irregular cycles, recurrent pregnancy loss, or known reproductive health conditions, it is advisable to consult a fertility specialist.',
  ],
  [
    'Do you offer online consultation?',
    'Yes, online consultations are available for patients who cannot visit the clinic in person. You can discuss your medical history, reports, and concerns with Dr. Rajeev Agarwal via a secure video call.',
  ],
  [
    'What should I carry for my first consultation?',
    'Please carry any previous medical reports, prescription history, ultrasound scans, hormone test results, and surgical records if available. If you are a couple, both partners are encouraged to attend.',
  ],
  [
    'Are IVF and fertility treatments personalised?',
    'Yes. Every treatment plan is customised based on your medical history, diagnostic reports, age, and unique fertility needs. Dr. Rajeev Agarwal believes in ethical, transparent, and individualised care.',
  ],
  [
    'What are the working hours?',
    'All centers in Gariahat, Salt Lake, and Jamshedpur are open Monday to Friday from 9:00 AM to 7:00 PM.',
  ],
  [
    'Where is the clinic located?',
    'All centers: Gariahat, Salt Lake, and Jamshedpur. Monday to Friday, 9:00 AM - 7:00 PM.',
  ],
];

const blogImages = [
  '/assets/2026/06/thyroid-tsh-before-pregnancy-preconception-india-1.webp',
  '/assets/2026/06/Dr-Rajeev-Agarwal-blog-images-1-1.webp',
  '/assets/2026/05/Fetal-Pole-in-Pregnancy-1.webp',
];

function useCountUp(target, duration = 2000, pause = 4000) {
  const [count, setCount] = useState(0);
  const [visible, setVisible] = useState(false);
  const ref = useRef(null);
  const animRef = useRef(null);

  useEffect(() => {
    const el = ref.current;
    if (!el) return;
    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          setVisible(true);
          observer.disconnect();
        }
      },
      { threshold: 0.3 }
    );
    observer.observe(el);
    return () => observer.disconnect();
  }, []);

  useEffect(() => {
    if (!visible) return;
    const parsed = parseFloat(target);
    if (isNaN(parsed)) { setCount(target); return; }

    let startTime;
    let timeout;

    const animate = (now) => {
      if (!startTime) startTime = now;
      const elapsed = now - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      setCount(parsed * eased);
      if (progress < 1) {
        animRef.current = requestAnimationFrame(animate);
      } else {
        timeout = setTimeout(() => {
          setCount(0);
          startTime = undefined;
          animRef.current = requestAnimationFrame(animate);
        }, pause);
      }
    };

    animRef.current = requestAnimationFrame(animate);
    return () => {
      if (animRef.current) cancelAnimationFrame(animRef.current);
      if (timeout) clearTimeout(timeout);
    };
  }, [visible, target, duration, pause]);

  const suffix = target.replace(/[\d.]/g, '');
  const targetNum = parseFloat(target);
  const isInt = Number.isInteger(targetNum);
  const display = typeof count === 'number'
    ? (isInt ? Math.floor(count).toString() : count.toFixed(1)) + suffix
    : count;

  return { ref, display };
}

function CountUpStat({ target, label }) {
  const { ref, display } = useCountUp(target);
  return (
    <div ref={ref}>
      <strong>{display}</strong>
      <span>{label}</span>
    </div>
  );
}

function AutoAwards() {
  const awards = [
    '01-1-scaled-1.webp',
    '10-1-scaled-1.webp',
    '09-1-scaled-1.webp',
    '08-1-scaled-1.webp',
    '07-1-scaled-1.webp',
    '06-1-scaled-1.webp',
    '05-1-scaled-1.webp',
    '02.webp',
    '04-1-scaled-1.webp',
    '03.webp',
  ];

  return (
    <div className="ra-awards-row" aria-label="Award certificates and recognition gallery">
      <div className="ra-awards-track">
        {awards.map((file, i) => (
          <div className="ra-award-cell" key={`${file}-${i}`}>
            <img src={`/assets/2026/03/${file}`} alt="Dr. Rajeev Agarwal award recognition" />
          </div>
        ))}
      </div>
    </div>
  );
}

function VideoCarousel() {
  const studioVideos = [
    { thumb: '/assets/2025/04/03H2gLBLUHY-HD.webp', embed: 'https://www.youtube.com/embed/03H2gLBLUHY?feature=oembed&autoplay=1&rel=0&controls=0' },
    { thumb: '/assets/2025/04/xrPLlMc4dw-HD.webp', embed: 'https://www.youtube.com/embed/-xrPLlMc4dw?feature=oembed&autoplay=1&rel=0&controls=0' },
    { thumb: '/assets/2025/04/cEoAa5159p4-HD.webp', embed: 'https://www.youtube.com/embed/cEoAa5159p4?feature=oembed&autoplay=1&rel=0&controls=0' },
    { thumb: '/assets/2025/04/ZIOyJuCiap8-HD.webp', embed: 'https://www.youtube.com/embed/ZIOyJuCiap8?feature=oembed&autoplay=1&rel=0&controls=0' },
    { thumb: '/assets/2025/04/XVxy_BmPeeM-HD.webp', embed: 'https://www.youtube.com/embed/XVxy_BmPeeM?feature=oembed&autoplay=1&rel=0&controls=0' },
    { thumb: '/assets/2025/04/12LCASXxv30-HD.webp', embed: 'https://www.youtube.com/embed/12LCASXxv30?feature=oembed&autoplay=1&rel=0&controls=0' },
  ];
  const [current, setCurrent] = useState(0);
  const [playing, setPlaying] = useState(null);
  const viewportRef = useRef(null);
  const [slideWidth, setSlideWidth] = useState(0);

  useEffect(() => {
    const measure = () => {
      if (viewportRef.current) setSlideWidth(viewportRef.current.offsetWidth);
    };
    measure();
    window.addEventListener('resize', measure);
    return () => window.removeEventListener('resize', measure);
  }, []);

  const cardsPerView = window.innerWidth >= 992 ? 2 : 1;
  const gap = cardsPerView === 2 ? 15 : 10;
  const stepWidth = (slideWidth - gap) / cardsPerView + gap;
  const maxIndex = studioVideos.length - cardsPerView;

  useEffect(() => {
    if (maxIndex <= 0 || playing !== null) return;
    const id = setInterval(() => {
      setCurrent(prev => (prev >= maxIndex ? 0 : prev + 1));
    }, 5000);
    return () => clearInterval(id);
  }, [maxIndex, playing]);

  const handlePlay = (i) => {
    if (playing === i) {
      setPlaying(null);
    } else {
      setPlaying(i);
      setCurrent(i);
    }
  };

  const scrollPrev = () => {
    if (viewportRef.current) {
      const vp = viewportRef.current;
      // On mobile the track uses native scroll, so scrollBy works
      if (window.innerWidth <= 820) {
        vp.scrollBy({ left: -170, behavior: 'smooth' });
      } else {
        setCurrent(prev => Math.max(0, prev - 1));
      }
    }
  };

  const scrollNext = () => {
    if (viewportRef.current) {
      const vp = viewportRef.current;
      if (window.innerWidth <= 820) {
        vp.scrollBy({ left: 170, behavior: 'smooth' });
      } else {
        setCurrent(prev => Math.min(maxIndex, prev + 1));
      }
    }
  };

  return (
    <div className="ra-video-carousel">
      <div className="ra-video-carousel-viewport" ref={viewportRef}>
        <div
          className="ra-video-carousel-track"
          style={{ transform: `translateX(-${current * stepWidth}px)` }}
        >
          {studioVideos.map((v, i) => (
            <div
              className="ra-video-carousel-card"
              key={i}
              style={{ width: `calc((100% - ${gap}px) / ${cardsPerView})`, marginRight: i < studioVideos.length - 1 ? `${gap}px` : '0' }}
            >
              {playing === i ? (
                <iframe
                  src={v.embed}
                  allow="autoplay; fullscreen"
                  allowFullScreen
                  title="Video"
                  className="ra-video-carousel-iframe"
                />
              ) : (
                <div className="ra-video-carousel-thumb" onClick={() => handlePlay(i)}>
                  <img src={v.thumb} alt="" loading="lazy" />
                  <span className="ra-video-carousel-play"><Play size={36} fill="currentColor" /></span>
                </div>
              )}
            </div>
          ))}
        </div>
      </div>
      <div className="ra-carousel-arrows">
        <button
          className="ra-carousel-arrow ra-carousel-arrow--left"
          type="button"
          onClick={scrollPrev}
          aria-label="Previous video"
        >
          <ArrowLeft size={20} />
        </button>
        <button
          className="ra-carousel-arrow ra-carousel-arrow--right"
          type="button"
          onClick={scrollNext}
          aria-label="Next video"
        >
          <ArrowRight size={20} />
        </button>
      </div>
    </div>
  );
}

function CourseCarousel() {
  const [current, setCurrent] = useState(0);
  const [paused, setPaused] = useState(false);
  const trackRef = useRef(null);
  const [cardWidth, setCardWidth] = useState(0);
  const [cardsPerView, setCardsPerView] = useState(3);
  const gap = 15;

  useEffect(() => {
    const update = () => {
      const w = window.innerWidth;
      let perView = 3;
      if (w < 768) perView = 1;
      else if (w < 992) perView = 2;
      setCardsPerView(perView);
    };
    update();
    window.addEventListener('resize', update);
    return () => window.removeEventListener('resize', update);
  }, []);

  useEffect(() => {
    if (trackRef.current) {
      const parent = trackRef.current.parentElement;
      setCardWidth(parent ? parent.offsetWidth : 0);
    }
  }, [cardsPerView]);

  const totalGapWidth = gap * (cardsPerView - 1);
  const cardBasis = `calc((100% - ${totalGapWidth}px) / ${cardsPerView})`;
  const stepWidth = cardWidth > 0 ? (cardWidth - totalGapWidth) / cardsPerView + gap : 0;
  const maxIndex = Math.max(0, courses.length - cardsPerView);

  useEffect(() => {
    if (maxIndex <= 0 || paused) return;
    const id = setInterval(() => {
      setCurrent(prev => (prev >= maxIndex ? 0 : prev + 1));
    }, 5000);
    return () => clearInterval(id);
  }, [maxIndex, paused]);

  return (
    <div
      className="ra-course-carousel"
      onMouseEnter={() => setPaused(true)}
      onMouseLeave={() => setPaused(false)}
    >
      <div className="ra-course-carousel-viewport">
        <div
          className="ra-course-carousel-track"
          ref={trackRef}
          style={{ transform: `translateX(-${current * stepWidth}px)`, gap: `${gap}px` }}
        >
          {courses.map((c, i) => (
            <article
              className="ra-course-card"
              key={c.title}
              style={{ width: cardBasis, flex: '0 0 auto' }}
            >
              <div className="ra-course-card-head">
                <span className="ra-course-status">{c.status}</span>
              </div>
              <h3>{c.title}</h3>
              <p className="ra-course-desc">{c.desc}</p>
              <div className="ra-course-points" aria-label={`${c.title} highlights`}>
                {c.points.map((point) => (
                  <span key={point}>{point}</span>
                ))}
              </div>
            </article>
          ))}
        </div>
      </div>
      <div className="ra-course-dots">
        {Array.from({ length: maxIndex + 1 }, (_, i) => (
          <button
            key={i}
            className={i === current ? 'active' : ''}
            type="button"
            onClick={() => setCurrent(i)}
            aria-label={`Slide ${i + 1}`}
          />
        ))}
      </div>
    </div>
  );
}

function EventCarousel() {
  const [current, setCurrent] = useState(0);
  const [paused, setPaused] = useState(false);
  const viewportRef = useRef(null);
  const [slideWidth, setSlideWidth] = useState(0);

  useEffect(() => {
    const measure = () => {
      if (viewportRef.current) setSlideWidth(viewportRef.current.offsetWidth);
    };
    measure();
    window.addEventListener('resize', measure);
    return () => window.removeEventListener('resize', measure);
  }, []);

  const cardsPerView = window.innerWidth >= 768 ? 2 : 1;
  const gap = 10;
  const stepWidth = (slideWidth - gap) / cardsPerView + gap;
  const maxIndex = events.length - cardsPerView;

  useEffect(() => {
    if (maxIndex <= 0 || paused) return;
    const id = setInterval(() => {
      setCurrent(prev => (prev >= maxIndex ? 0 : prev + 1));
    }, 3000);
    return () => clearInterval(id);
  }, [maxIndex, paused]);

  return (
    <div
      className="ra-event-carousel"
      onMouseEnter={() => setPaused(true)}
      onMouseLeave={() => setPaused(false)}
    >
      <div className="ra-event-carousel-viewport" ref={viewportRef}>
        <div
          className="ra-event-carousel-track"
          style={{ transform: `translateX(-${current * stepWidth}px)` }}
        >
          {events.map((e, i) => (
            <div
              className="ra-event-card"
              key={e.title}
              style={{ width: `calc((100% - ${gap}px) / ${cardsPerView})`, marginRight: i < events.length - 1 ? `${gap}px` : '0' }}
            >
              <div className="ra-event-img-wrap">
                <img src={e.image} alt={e.title} />
              </div>
              <span className="ra-event-caption">{e.title}</span>
            </div>
          ))}
        </div>
      </div>
      <div className="ra-event-dots">
        {Array.from({ length: maxIndex + 1 }, (_, i) => (
          <button
            key={i}
            className={i === current ? 'active' : ''}
            type="button"
            onClick={() => setCurrent(i)}
            aria-label={`Event ${i + 1}`}
          />
        ))}
      </div>
    </div>
  );
}

function cleanExcerpt(html) {
  return html
    .replace(/<[^>]*>/g, ' ')
    .replace(/&nbsp;|&#8211;|&#8212;/g, ' ')
    .replace(/&amp;/g, '&')
    .replace(/\s+/g, ' ')
    .trim()
    .slice(0, 150);
}

function ServiceCarousel({ services, categoryLabel }) {
  const [current, setCurrent] = useState(0);
  const [paused, setPaused] = useState(false);
  const trackRef = useRef(null);
  const [cardWidth, setCardWidth] = useState(0);
  const [cardsPerView, setCardsPerView] = useState(3);
  const gap = 20;

  useEffect(() => {
    const update = () => {
      const w = window.innerWidth;
      let perView = 3;
      if (w < 768) perView = 1;
      else if (w < 992) perView = 2;
      setCardsPerView(perView);
    };
    update();
    window.addEventListener('resize', update);
    return () => window.removeEventListener('resize', update);
  }, []);

  useEffect(() => {
    if (trackRef.current) {
      const parent = trackRef.current.parentElement;
      setCardWidth(parent ? parent.offsetWidth : 0);
    }
  }, [cardsPerView]);

  const totalGapWidth = gap * (cardsPerView - 1);
  const cardBasis = `calc((100% - ${totalGapWidth}px) / ${cardsPerView})`;
  const stepWidth = cardWidth > 0 ? (cardWidth - totalGapWidth) / cardsPerView + gap : 0;
  const maxIndex = Math.max(0, services.length - cardsPerView);

  useEffect(() => {
    if (maxIndex <= 0 || paused) return;
    const id = setInterval(() => {
      setCurrent(prev => (prev >= maxIndex ? 0 : prev + 1));
    }, 4000);
    return () => clearInterval(id);
  }, [maxIndex, paused]);

  if (services.length === 0) return null;

  return (
    <div
      className="ra-service-carousel"
      onMouseEnter={() => setPaused(true)}
      onMouseLeave={() => setPaused(false)}
    >
      <div className="ra-service-carousel-viewport">
        <div
          className="ra-service-carousel-track"
          ref={trackRef}
          style={{ transform: `translateX(-${current * stepWidth}px)`, gap: `${gap}px` }}
        >
          {services.map((s) => (
            <Link
              className="ra-service-card"
              key={s.title}
              to={s.href}
              style={{ width: cardBasis, flex: '0 0 auto' }}
            >
              <div className="ra-service-img-wrap">
                <img src={s.image} alt={`${s.title} service`} />
              </div>
              <div className="ra-service-card-body">
                <span className="ra-service-category">{categoryLabel}</span>
                <h3>{s.title}</h3>
                <p>{s.text}</p>
                <span className="ra-service-cta">Explore Treatment</span>
              </div>
            </Link>
          ))}
        </div>
      </div>
      <div className="ra-service-carousel-dots">
        {Array.from({ length: maxIndex + 1 }, (_, i) => (
          <button
            key={i}
            className={i === current ? 'active' : ''}
            type="button"
            onClick={() => setCurrent(i)}
            aria-label={`Slide ${i + 1}`}
          />
        ))}
      </div>
    </div>
  );
}

export default function Home({ onBookClick }) {
  useSeo(getMetaForPath('/'));
  const [activeTab, setActiveTab] = useState('concern');
  const [mobileOpen, setMobileOpen] = useState(false);
  const [mobileServicesOpen, setMobileServicesOpen] = useState(false);
  const [introVideoOpen, setIntroVideoOpen] = useState(false);
  const [instaModal, setInstaModal] = useState(null);
  const [openFaq, setOpenFaq] = useState(0);
  const latestBlogs = useMemo(() => {
    return blogsData.slice(0, 3).map((blog, idx) => buildBlogPresentation(blog, idx));
  }, []);
  const services = activeTab === 'concern' ? concernServices : procedureServices;
  const book = () => {
    setMobileOpen(false);
    setMobileServicesOpen(false);
    if (onBookClick) onBookClick();
  };

  const toggleMobileMenu = () => {
    setMobileServicesOpen(false);
    setMobileOpen((value) => !value);
  };

  const closeMobileMenu = () => {
    setMobileServicesOpen(false);
    setMobileOpen(false);
  };

  const nav = (
    <>
      <Link to="/">Home</Link>
      <Link to="/about-me">About Me</Link>
      <div className="ra-nav-dropdown">
        <button type="button">
          Services <ChevronDown size={14} />
        </button>
        <div className="ra-mega" aria-label="Services menu">
          <div>
            <span>By Concern</span>
            {dropdownConcerns.map((item) => (
              <Link key={item.title} to={item.href}>{item.title}</Link>
            ))}
          </div>
          <div>
            <span>By Procedure</span>
            {dropdownProcedures.map((item) => (
              <Link key={item.title} to={item.href}>{item.title}</Link>
            ))}
          </div>
        </div>
      </div>
      <Link to="/courses">Courses</Link>
      <Link to="/blog">Blog</Link>
      <a href="#success-stories">Success Stories</a>
    </>
  );

  const mobileNav = (
    <>
      <Link to="/" onClick={closeMobileMenu}>Home</Link>
      <Link to="/about-me" onClick={closeMobileMenu}>About Me</Link>
      <div className={`ra-mobile-services ${mobileServicesOpen ? 'is-open' : ''}`}>
        <button
          type="button"
          aria-expanded={mobileServicesOpen}
          onClick={() => setMobileServicesOpen((value) => !value)}
        >
          Services <ChevronDown size={15} />
        </button>
        {mobileServicesOpen && (
          <>
            <button
              className="ra-mobile-services-backdrop"
              type="button"
              aria-label="Close services menu"
              onClick={() => setMobileServicesOpen(false)}
            />
            <div className="ra-mobile-services-panel" role="dialog" aria-label="Services menu">
              <button
                className="ra-mobile-services-close"
                type="button"
                aria-label="Close services menu"
                onClick={() => setMobileServicesOpen(false)}
              >
                <X size={17} />
              </button>
              <div className="ra-mobile-services-panel-body">
                <div>
                  <span>By Concern</span>
                  {dropdownConcerns.map((item) => (
                    <Link key={item.title} to={item.href} onClick={closeMobileMenu}>{item.title}</Link>
                  ))}
                </div>
                <div>
                  <span>By Procedure</span>
                  {dropdownProcedures.map((item) => (
                    <Link key={item.title} to={item.href} onClick={closeMobileMenu}>{item.title}</Link>
                  ))}
                </div>
              </div>
            </div>
          </>
        )}
      </div>
      <Link to="/courses" onClick={closeMobileMenu}>Courses</Link>
      <Link to="/blog" onClick={closeMobileMenu}>Blog</Link>
      <a href="#success-stories" onClick={closeMobileMenu}>Success Stories</a>
    </>
  );

  return (
    <div className="ra-home">
      <header className="ra-header">
        <div className="ra-header-inner">
          <Link className="ra-logo" to="/" aria-label="Dr. Rajeev Agarwal home">
            <img src="/assets/2025/01/Rajeev-Sir-Logo-2.webp" alt="Dr. Rajeev Agarwal logo" />
          </Link>

          <nav className="ra-nav" aria-label="Primary navigation">{nav}</nav>

          <div className="ra-header-actions">
            <button className="ra-btn ra-btn-primary" type="button" onClick={book}>Book Appointment</button>
            <a className="ra-icon-btn" href="https://wa.me/916292269060" aria-label="WhatsApp Dr. Rajeev Agarwal">
              <MessageCircle size={20} />
            </a>
            <button className="ra-menu-btn" type="button" onClick={toggleMobileMenu} aria-label="Toggle menu">
              {mobileOpen ? <X size={22} /> : <Menu size={22} />}
            </button>
          </div>
        </div>
        {mobileOpen && (
          <div className="ra-mobile-menu">
            {mobileNav}
            <button className="ra-btn ra-btn-primary" type="button" onClick={book}>Book Appointment</button>
          </div>
        )}
      </header>

      <main>
        <section className="ra-hero">
          <div className="ra-container ra-hero-grid">
            <div className="ra-hero-copy ra-fade">
              <div className="ra-eyebrow"><Sparkles size={16} /> Kolkata's Leading Fertility Specialist</div>
              <h1>Your Dream of <em>Parenthood</em>, My Commitment</h1>
              <p>
                Dr. Rajeev Agarwal offers world-class IVF, IUI and advanced gynecological care with
                compassion, precision and 25+ years of clinical experience.
              </p>
              <div className="ra-hero-actions">
                <button className="ra-btn ra-btn-primary" type="button" onClick={book}>Request Appointment</button>
                <a className="ra-btn ra-btn-soft" href="#services">Explore Services</a>
              </div>
            </div>

            <div className="ra-hero-visual">
              <div className="ra-doctor-frame">
                <img className="ra-hero-image" src={heroImg} alt="Dr. Rajeev Agarwal fertility specialist in Kolkata" />
                <div className="ra-hero-mobile-copy">
                  <div className="ra-eyebrow"><Sparkles size={15} /> Kolkata's Leading Fertility Specialist</div>
                  <h1>Your Dream of <em>Parenthood</em>, My Commitment</h1>
                  <p>
                    IVF, IUI and advanced gynecological care with compassion, precision and 25+ years of experience.
                  </p>
                </div>
              </div>
              <div className="ra-consult-card"><MessageCircle size={18} /> Online & In-clinic Consultation</div>
            </div>

            <div className="ra-hero-mobile-actions">
              <button className="ra-btn ra-btn-primary" type="button" onClick={book}>Request Appointment</button>
              <a className="ra-btn ra-btn-soft" href="#services">Explore Services</a>
            </div>
          </div>
        </section>

        <section className="ra-marquee-strip" aria-label="Clinical trust points">
          <div className="ra-marquee-track">
            {[...Array(2)].map((_, setIdx) => (
              <div className="ra-marquee-set" key={setIdx} aria-hidden={setIdx > 0}>
                {[
                  ['IVF & IUI Specialist', Baby],
                  ['Laparoscopic Surgeon', Stethoscope],
                  ['Personalized Fertility Care', HeartPulse],
                  ['Ethical & Transparent Treatment', ShieldCheck],
                  ['Renew Healthcare, Kolkata', Star],
                ].map(([label, Icon]) => (
                  <div className="ra-marquee-item" key={`${setIdx}-${label}`}>
                    <Icon size={20} />
                    <span>{label}</span>
                  </div>
                ))}
              </div>
            ))}
          </div>
        </section>

        <section className="ra-section ra-quick-intro">
          <div className="ra-container">
            <div className="ra-intro-panel">
              <div className="ra-intro-copy">
                <span className="ra-intro-kicker"><HeartPulse size={16} /> Personalised fertility care in Kolkata</span>
                <p>
                  As a fertility specialist and gynaecologist in Kolkata, I, Dr. Rajeev Agarwal, have dedicated
                  my life to helping individuals and couples achieve their dream of parenthood through advanced
                  treatments, personalised care, and unwavering compassion.
                </p>
              </div>
              <div className="ra-quick-cards" aria-label="Quick homepage links and trust points">
                <Link className="ra-quick-card" to="/all-services">
                  <span className="ra-quick-icon"><Stethoscope size={22} /></span>
                  <span><strong>My Services</strong><small>Expert fertility and gynecological care, tailored for you.</small></span>
                </Link>
                <Link className="ra-quick-card" to="/courses">
                  <span className="ra-quick-icon"><BookOpen size={22} /></span>
                  <span><strong>Our Courses</strong><small>Expert training in fertility and gynaecology.</small></span>
                </Link>
                <div className="ra-quick-card ra-quick-rating">
                  <span className="ra-quick-icon ra-google-icon">
                    <img src="/assets/2024/08/google.svg" alt="" />
                  </span>
                  <span><strong>4.9 Google Rating</strong><small>Patient feedback across fertility care journeys.</small></span>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section className="ra-section ra-about-section elementor-element elementor-element-08179f2" data-id="08179f2">
          <div className="ra-container ra-about ra-about-premium">
            <div className="ra-section-copy ra-about-copy elementor-element elementor-element-fd2b058" data-id="fd2b058">
              <span className="ra-label ra-about-label"><Sparkles size={15} /> ABOUT DR. RAJEEV AGARWAL</span>
              <h2>Transforming Fertility Care with Science, Skill & <em>Empathy</em></h2>
              <p>
                Dr. Rajeev Agarwal is a leading fertility specialist, gynaecologist and laparoscopic surgeon
                in Kolkata, known for combining advanced reproductive medicine with patient-first counselling
                and transparent clinical decisions.
              </p>
              <div className="ra-about-highlights">
                <div className="ra-about-highlight">
                  <span className="ra-about-highlight-icon"><Baby size={18} /></span>
                  <div><strong>Fertility Treatments</strong><span>IVF, IUI and fertility-preserving surgeries</span></div>
                </div>
                <div className="ra-about-highlight">
                  <span className="ra-about-highlight-icon"><Stethoscope size={18} /></span>
                  <div><strong>Advanced Gynaecological Care</strong><span>Laparoscopic and hysteroscopic procedures</span></div>
                </div>
                <div className="ra-about-highlight">
                  <span className="ra-about-highlight-icon"><ShieldCheck size={18} /></span>
                  <div><strong>Patient-Centred Approach</strong><span>Ethical, transparent and personalised care</span></div>
                </div>
                <div className="ra-about-highlight">
                  <span className="ra-about-highlight-icon"><HeartPulse size={18} /></span>
                  <div><strong>Modern Clinical Standards</strong><span>Technology-led care with dedicated support</span></div>
                </div>
              </div>
              <Link className="ra-about-readmore" to="/about-me">Read More</Link>
            </div>

            <div className="ra-about-media elementor-element elementor-element-dee3299" data-id="dee3299">
              <div className="ra-about-photo">
                <img src={aboutImg} alt="Dr. Rajeev Agarwal professional portrait" />
              </div>
              <a
                className="ra-about-video-card"
                href="#doctor-intro-video"
                aria-label="Watch Doctor's Introduction on this page"
              >
                <span className="ra-about-play"><Play size={18} fill="currentColor" /></span>
                <span className="ra-about-video-label">Watch Doctor's Introduction</span>
              </a>
              <div className="ra-about-award-card" aria-label="35 plus global healthcare awards">
                <img src="/assets/2025/03/Group-1000008319.png.webp" alt="" />
                <div>
                  <strong>35+</strong>
                  <span>Global Healthcare Awards</span>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section className="ra-section ra-doctor-video-section ra-hide-mobile" id="doctor-intro-video">
          <div className="ra-container">
            <div className="ra-doctor-video-embed">
              {introVideoOpen ? (
                <iframe
                  src="https://www.youtube.com/embed/ca-x_8r9_FY?autoplay=1&rel=0&modestbranding=1"
                  title="Dr. Rajeev Agarwal introduction video"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                  allowFullScreen
                />
              ) : (
                <button
                  className="ra-doctor-video-cover"
                  type="button"
                  onClick={() => setIntroVideoOpen(true)}
                  aria-label="Play Doctor's Introduction video"
                >
                  <img src={videoBarImg} alt="" />
                  <span className="ra-doctor-video-control" aria-hidden="true">
                    <span><Play size={26} fill="currentColor" /></span>
                  </span>
                </button>
              )}
            </div>
          </div>
        </section>

        <section className="ra-section ra-section-blue">
          <div className="ra-container">
            <div className="ra-section-head">
              <span className="ra-label">Featured In</span>
              <h2>Trusted medical voice across <em>media</em></h2>
              <p>Coverage and conversations across healthcare, fertility education and public awareness.</p>
            </div>
            <div className="ra-press-strip">
              {pressLogos.map(([name, logo]) => (
                <div className="ra-press-logo" key={name}>
                  <img src={logo} alt={name} />
                </div>
              ))}
            </div>
          </div>
        </section>

        <section className="ra-section ra-section-blue ra-services-section" id="services">
          <div className="ra-container">
            <div className="ra-section-head">
              <span className="ra-label">Services</span>
              <h2>Care designed around your <em>journey</em></h2>
              <p>Choose support by concern or procedure, with clear guidance from consultation to treatment.</p>
            </div>
            <div className="ra-tabs" role="tablist" aria-label="Service categories">
              <button className={activeTab === 'concern' ? 'active' : ''} type="button" onClick={() => setActiveTab('concern')}>By Concern</button>
              <button className={activeTab === 'procedure' ? 'active' : ''} type="button" onClick={() => setActiveTab('procedure')}>By Procedure</button>
            </div>
            <ServiceCarousel services={services} categoryLabel={activeTab === 'concern' ? 'Concern' : 'Procedure'} />
            <div className="ra-center">
              <button className="ra-btn ra-btn-primary" type="button" onClick={book}>Book Appointment</button>
            </div>
          </div>
        </section>

        <section className="ra-section">
          <div className="ra-container ra-impact">
            <CountUpStat target="25+" label="Years of Experience" />
            <CountUpStat target="10k+" label="Happy Patients" />
            <CountUpStat target="4.9" label="Google Rating" />
            <CountUpStat target="35+" label="Awards & Recognitions" />
          </div>
        </section>

        <section className="ra-section ra-awards-section">
          <div className="ra-container ra-awards-layout">
            <div className="ra-section-head ra-awards-copy">
              <span className="ra-label">MY AWARDS AND RECOGNITION</span>
              <h2>Celebrating Excellence in <em>Healthcare</em></h2>
              <p>Recognitions from medical forums, healthcare communities, and public platforms for fertility care, patient education, and clinical leadership.</p>
              <div className="ra-awards-meta" aria-label="Award highlights">
                <span><strong>35+</strong> Awards</span>
                <span><strong>25+</strong> Years</span>
                <span><strong>10k+</strong> IVF Cases</span>
              </div>
            </div>
            <div className="ra-awards-showcase">
              <AutoAwards />
            </div>
          </div>
        </section>

        <section className="ra-section ra-section-blue" id="success-stories">
          <div className="ra-container ra-success-stories-layout">
            <div className="ra-success-stories-text">
              <div className="ra-section-head" style={{ textAlign: 'left', margin: '0 0 0 0' }}>
                <span className="ra-label">MY SUCCESS STORIES</span>
                <h2>Voices of <em>Gratitude</em></h2>
                <p>Every parenthood journey is unique. These stories highlight the hope, resilience, and expert care that turned dreams into reality with Dr. Rajeev Agarwal's guidance.</p>
              </div>
              <a className="ra-btn ra-btn-primary" href="/success-stories/">More Stories</a>
            </div>
            <VideoCarousel />
          </div>
        </section>

        <section className="ra-section ra-section-cream" id="courses">
          <div className="ra-container">
            <div className="ra-section-head">
              <span className="ra-label">MY COURSES</span>
              <h2>Empower Yourself with <em>Knowledge</em></h2>
              <p>Explore Dr. Agarwal's courses for clear, practical learning in fertility, pregnancy planning, and reproductive health.</p>
            </div>
            <CourseCarousel />
          </div>
        </section>

        <section className="ra-section" id="events">
          <div className="ra-container ra-event-layout">
            <div className="ra-event-text">
              <div className="ra-section-head" style={{ textAlign: 'left', margin: '0 0 0 0' }}>
                <span className="ra-label">EVENT HIGHLIGHTS</span>
                <h2>Lectures & <em>events</em></h2>
                <p>Selected conferences, public talks, workshops, and awareness events from Dr. Rajeev Agarwal's medical journey.</p>
              </div>
              <img className="ra-event-deco" src="/assets/2025/01/Group-2.webp" alt="" />
            </div>
            <EventCarousel />
          </div>
        </section>

        <section className="ra-blog-section">
          <div className="ra-container">
            <div className="ra-section-head">
              <span className="ra-label">Blog</span>
              <h2>Latest fertility and wellness <em>articles</em></h2>
            </div>
            <div className="ra-blog-grid">
              {latestBlogs.map((post) => (
                <article className="ra-blog-card" key={post.slug}>
                  <div className="ra-blog-img-wrap">
                    <img src={post.image} alt={post.title} loading="lazy" />
                  </div>
                  <div className="ra-blog-body">
                    <span className="ra-blog-badge">{post.category}</span>
                    <h3>{post.title}</h3>
                    <p>{post.excerpt}</p>
                    <time dateTime={post.date}>{post.displayDate}</time>
                    <Link to={`/blog/${post.slug}`} className="ra-blog-link">Read Article</Link>
                  </div>
                </article>
              ))}
            </div>
            <div className="ra-blog-btn-wrap">
              <Link className="ra-blog-all-btn" to="/blog">Read All Blogs</Link>
            </div>
          </div>
        </section>

        <section className="ra-section ra-section-blue" id="instagram">
          <div className="ra-container">
            <div className="ra-section-head">
              <span className="ra-label">Instagram Feed</span>
              <h2>Follow fertility insights and clinic <em>updates</em></h2>
            </div>
            <div className="ra-instagram-grid">
              {instagramFeed.map(([alt, image, href], index) => {
                const embedUrl = href.replace(/\/?$/, '/embed');
                return (
                  <div
                    className="ra-instagram-card"
                    key={href}
                    onClick={() => setInstaModal(embedUrl)}
                  >
                    <img src={image} alt={`${alt} ${index + 1}`} />
                    <span className="ra-insta-play"><Play size={20} fill="currentColor" /></span>
                  </div>
                );
              })}
            </div>
            <div className="ra-carousel-arrows ra-insta-arrows">
              <button
                className="ra-carousel-arrow ra-carousel-arrow--left"
                type="button"
                onClick={() => {
                  const grid = document.querySelector('.ra-instagram-grid');
                  if (grid) grid.scrollBy({ left: -170, behavior: 'smooth' });
                }}
                aria-label="Scroll Instagram left"
              >
                <ArrowLeft size={20} />
              </button>
              <button
                className="ra-carousel-arrow ra-carousel-arrow--right"
                type="button"
                onClick={() => {
                  const grid = document.querySelector('.ra-instagram-grid');
                  if (grid) grid.scrollBy({ left: 170, behavior: 'smooth' });
                }}
                aria-label="Scroll Instagram right"
              >
                <ArrowRight size={20} />
              </button>
            </div>
          </div>
          {instaModal && (
            <div className="ra-video-lightbox" onClick={() => setInstaModal(null)}>
              <span className="ra-video-lightbox-close"><X size={28} /></span>
              <iframe src={instaModal} allow="fullscreen" allowFullScreen title="Instagram" onClick={e => e.stopPropagation()} />
            </div>
          )}
        </section>

        <section className="ra-section ra-section-blue">
          <div className="ra-container ra-faq">
            <div className="ra-section-head">
              <span className="ra-label">FAQ</span>
              <h2>Frequently Asked <em>Questions</em></h2>
            </div>
            <div className="ra-faq-layout">
              <div className="ra-faq-accordion">
                {faqs.map(([question, answer], i) => {
                  const open = openFaq === i;
                  return (
                    <div key={i} className={`ra-faq-item ${open ? 'ra-faq-item--open' : ''}`}>
                      <button className="ra-faq-q" onClick={() => setOpenFaq(open ? null : i)}>
                        <span>{question}</span>
                        <span className={`ra-faq-icon ${open ? 'ra-faq-icon--open' : ''}`}>
                          <ChevronDown size={18} strokeWidth={2.5} />
                        </span>
                      </button>
                      <div className={`ra-faq-a-wrap ${open ? 'ra-faq-a-wrap--open' : ''}`}>
                        <div className="ra-faq-a">{answer}</div>
                      </div>
                    </div>
                  );
                })}
              </div>
            </div>
          </div>
        </section>
      </main>
      <Footer />
      <FloatingLeadForm formName="Home Floating Bottom Form" />
    </div>
  );
}
