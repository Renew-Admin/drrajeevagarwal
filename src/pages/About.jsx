import { useState, useEffect, useRef } from 'react';
import { Link } from 'react-router-dom';
import { ArrowRight, Award, Baby, CheckCircle, GraduationCap, HeartPulse, MapPin, Microscope, Play, ShieldCheck, Stethoscope, Users } from 'lucide-react';
import FloatingLeadForm from '../components/FloatingLeadForm';
import WhyMeSection from '../components/WhyMeSection';
import aboutHeroImg from '../assets/about-hero.webp';


const focusCards = [
  { icon: Baby, title: 'Advanced Fertility Care', text: 'IVF, IUI, fertility preservation and complex infertility planning.' },
  { icon: Stethoscope, title: 'Gynaecology & Laparoscopy', text: 'Minimally invasive care for fibroids, endometriosis and pelvic concerns.' },
  { icon: ShieldCheck, title: 'Ethical Clinical Decisions', text: 'Transparent counselling, realistic options and treatment only when needed.' },
  { icon: HeartPulse, title: 'Patient-First Support', text: 'Warm guidance through emotionally demanding fertility decisions.' },
];

const milestones = [
  { icon: GraduationCap, period: 'Foundation', title: 'Medical training and OBG specialisation', text: 'Built a strong foundation through MBBS, MD and rigorous clinical exposure in gynaecology.' },
  { icon: Microscope, period: 'IVF Focus', title: 'Advanced fertility medicine', text: 'Developed deep expertise in IVF, reproductive medicine and fertility-preserving care.' },
  { icon: Users, period: 'Leadership', title: 'Care IVF and training platforms', text: 'Expanded access to fertility care and contributed to training young gynaecologists.' },
  { icon: Award, period: 'Today', title: 'Medical Director, Renew Healthcare', text: 'Leads a modern fertility practice focused on science, ethics and patient confidence.' },
];

const publications = [
  '/assets/2025/04/Hindustan_Times_logo-1.svg',
  '/assets/2025/04/The_Financial_Express_India_Logo-1.svg',
  '/assets/2025/04/jionews-1.svg',
  '/assets/2025/04/Mint_newspaper_logo-1.svg',
  '/assets/2025/04/New18-logo-1.svg',
  '/assets/2025/04/Timesnow-1.svg',
  '/assets/2025/04/Zee_news-2.svg',
  '/assets/2025/04/2024_new_msn_logo-1.svg',
  '/assets/2025/04/dailyhunt-1.svg',
  '/assets/2025/04/doctube_logo-1.svg',
];

const faqData = [
  { q: 'What makes Dr. Rajeev Agarwal one of the best IVF Doctors in Kolkata?', a: 'Dr. Rajeev Agarwal is known for his compassionate and patient-centered approach. He takes the time to understand each patient\u2019s unique circumstances and provides personalized treatment plans. His expertise in various fertility treatments, including IVF, IUI, and embryo transfer, contributes significantly to these impressive results.' },
  { q: 'What is the cost of IVF in Kolkata?', a: 'A very cost-effective IVF treatment is offered by Dr. Rajeev Agarwal an IVF specialist treating infertility problems under 1,00,000 INR also depending upon factors like the number of cycles or medications.' },
  { q: 'Is it possible to get IVF treatment under \u20B9100,000?', a: 'Yes, In-Vitro Fertilization (IVF) is possible for under Rs 100000 in Kolkata with Dr. Rajeev Agarwal and his team of IVF Doctors who specialize in fertility management for infertility problems.' },
  { q: 'Is IVF safe?', a: 'Yes, IVF being one the most trustworthy practices of fertility treatments is generally very safe for infertility issues. There may be certain risks concerned which may not be significantly different from natural conception.' },
  { q: 'How long does IVF take?', a: 'An IVF cycle normally takes around 6-8 weeks. Varying from patient to patient after consultation, ovarian stimulation that lasts 8-14 days, egg retrieval, fertilisation, embryo transfer, and a pregnancy test.' },
  { q: 'Is infertility limited to female partners only?', a: 'No, Infertility issues can arise from both male and female partners in equal measure. Some cases of infertility problems are a combination of both.' },
  { q: 'What are the constraints while undergoing IVF treatment?', a: 'IVF Doctors recommend avoiding travelling long distances after the implantation of embryos in the uterus, avoiding intercourse until two weeks, drinking, smoking, consumption of supplements, etc during an IVF treatment, and following the prescription for medicine properly.' },
  { q: 'Are there any side effects of IVF treatment?', a: 'Stress, nausea, bloating, cramping, and constipation are among some very common side effects of IVF treatments. Complications from the procedure to retrieve eggs, ovarian hyperstimulation syndrome, ectopic pregnancy, and multiple pregnancies are some of the rare side effects of IVF treatments.' },
  { q: 'Is IVF treatment painful?', a: 'Generally, no. IVF is typically not a painful process. Most patients may experience discomfort while undergoing certain stages of the process or mild cramping.' },
  { q: 'Is IVF treatment done under anesthesia?', a: 'Although IVF is not painful, Egg retrieval from the ovaries is a painful part of In-vitro Fertilization (IVF). The procedure may be done under sedation (anesthesia) and pain relief (analgesia) to avoid the feeling of uneasiness in patients.' },
  { q: 'How long does it take to conceive after an IVF?', a: 'Some patients are fortunate enough to get pregnant after only one round of treatment after the methodology of embryo transfer is completed, it takes about 10-14 days for pregnancy to happen.' },
];

const gallery = [
  { image: '/assets/2025/02/DSC9265.webp', label: 'Modern consultation environment' },
  { image: '/assets/2025/02/A7402009.webp', label: 'Technology-led clinical planning' },
  { image: '/assets/2025/02/image-44.webp', label: 'Counselling before treatment' },
];

function PublicationCarousel() {
  const [current, setCurrent] = useState(0);
  const [paused, setPaused] = useState(false);
  const trackRef = useRef(null);
  const [cardWidth, setCardWidth] = useState(0);
  const [cardsPerView, setCardsPerView] = useState(5);
  const gap = 10;

  useEffect(() => {
    const update = () => {
      const w = window.innerWidth;
      let perView = 5;
      if (w < 768) perView = 2;
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

  const stepWidth = (cardWidth - gap) / cardsPerView + gap;
  const maxIndex = publications.length - cardsPerView;

  useEffect(() => {
    if (maxIndex <= 0 || paused) return;
    const id = setInterval(() => {
      setCurrent(prev => (prev >= maxIndex ? 0 : prev + 1));
    }, 5000);
    return () => clearInterval(id);
  }, [maxIndex, paused]);

  return (
    <div className="ra-pub-carousel" onMouseEnter={() => setPaused(true)} onMouseLeave={() => setPaused(false)}>
      <div className="ra-pub-carousel-viewport">
        <div className="ra-pub-carousel-track" ref={trackRef} style={{ transform: `translateX(-${current * stepWidth}px)`, gap: `${gap}px` }}>
          {publications.map((img, i) => (
            <div className="ra-pub-card" key={i} style={{ width: `calc((100% - ${gap}px) / ${cardsPerView})`, flex: '0 0 auto' }}>
              <div className="ra-pub-card-inner">
                <img src={img} alt={`Media ${i + 1}`} />
              </div>
            </div>
          ))}
        </div>
      </div>
      <div className="ra-pub-dots">
        {Array.from({ length: maxIndex + 1 }, (_, i) => (
          <button key={i} className={i === current ? 'active' : ''} type="button" onClick={() => setCurrent(i)} aria-label={`Slide ${i + 1}`} />
        ))}
      </div>
    </div>
  );
}

export default function About({ onBookClick }) {
  const [aboutVideoOpen, setAboutVideoOpen] = useState(false);
  const [openFaq, setOpenFaq] = useState(null);

  return (
    <div className="about-page">
      <section className="about-hero-image-section">
        <div className="about-hero-image-wrap">
          <img src={aboutHeroImg} alt="Dr. Rajeev Agarwal – Fertility Specialist in Kolkata" />
          <div className="about-hero-image-overlay">
            <div className="ra-container about-hero-image-content">
              <h1><span className="heading-blue">Helping Families Grow with</span> <span className="heading-gold">Care and Expertise</span></h1>
              <p className="about-hero-image-sub">Expert fertility care &amp; gynaecology — trusted by thousands of families across Kolkata.</p>
              <div className="about-hero-image-actions">
                <Link className="ra-btn ra-btn-primary" to="/all-services">Explore my Services</Link>
                <button className="ra-btn ra-btn-soft" type="button" onClick={onBookClick}>Request an Appointment</button>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section className="about-intro-section">
        <div className="ra-container">
          <p>Growing up in a household where my father, a dedicated Gynaecologist, transformed part of our home into a compassionate clinic, I witnessed firsthand the transformative power of healthcare. Watching patients place their trust in him and leave with renewed hope left an indelible mark on me. From a young age, I knew I didn&rsquo;t just want to become a doctor&mdash;I wanted to specialize in Gynaecology and make a meaningful difference in people&rsquo;s lives.</p>
        </div>
      </section>

      <section className="about-story-section">
        <div className="ra-container about-story-grid">
          <div className="about-story-copy">
            <span className="ra-label">Clinical Philosophy</span>
            <h2>Every treatment plan should feel clear, considered and <em>personal</em>.</h2>
            <p>Dr. Agarwal combines fertility science with careful diagnosis, emotional support and transparent medical reasoning. His approach helps patients understand why a treatment is suggested, what alternatives exist and how each step fits their larger parenthood journey.</p>
            <p>At Renew Healthcare, the goal is not just to offer advanced IVF or gynaecological procedures. It is to create a calmer clinical experience where patients feel heard, informed and guided by an expert team.</p>
          </div>
          <div className="about-focus-grid">
            {focusCards.map(({ icon: Icon, title, text }) => (
              <div className="about-focus-card" key={title}>
                <span className="about-focus-icon"><Icon size={22} /></span>
                <div><h3>{title}</h3><p>{text}</p></div>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className="about-care-section">
        <div className="ra-container">
          <div className="about-care-card">
            <div className="about-care-image"><img src="/assets/2025/02/image-44.webp" alt="Dr. Rajeev Agarwal counselling patients" /></div>
            <div className="about-care-copy">
              <span className="ra-label">Care Experience</span>
              <h2>Premium care should still feel <em>human</em>.</h2>
              <p>Fertility care can be emotionally heavy. The practice is designed around calm explanation, modern clinical standards and steady support from first consultation to treatment follow-up.</p>
              <div className="about-check-list">
                {['Evidence-led diagnosis before treatment decisions', 'Clear discussion of success factors, risks and next steps', 'Fertility, gynaecology and laparoscopy expertise in one place', 'Modern clinic environment with dedicated patient support'].map((item) => (
                  <span key={item}><CheckCircle size={18} />{item}</span>
                ))}
              </div>
              <Link className="about-inline-link" to="/all-services">Explore services <ArrowRight size={16} /></Link>
            </div>
          </div>
        </div>
      </section>

      <section className="ra-section ra-doctor-video-section">
        <div className="ra-container">
          <div className="ra-doctor-video-embed">
            {aboutVideoOpen ? (
              <iframe
                src="https://www.youtube.com/embed/gyxPUYWlsko?autoplay=1&rel=0&modestbranding=1"
                title="Dr. Rajeev Agarwal – Care Experience"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowFullScreen
              />
            ) : (
              <button
                className="ra-doctor-video-cover"
                type="button"
                onClick={() => setAboutVideoOpen(true)}
                aria-label="Play video about Dr. Rajeev Agarwal's care experience"
              >
                <img src="https://img.youtube.com/vi/gyxPUYWlsko/maxresdefault.jpg" alt="" />
                <span className="ra-doctor-video-control" aria-hidden="true">
                  <span><Play size={26} fill="currentColor" /></span>
                </span>
              </button>
            )}
          </div>
        </div>
      </section>

      <section className="about-journey-section">
        <div className="ra-container">
          <div className="about-section-head">
            <span className="ra-label">Career Journey</span>
            <h2>A practice shaped by training, mentorship and <em>clinical leadership</em>.</h2>
          </div>
          <div className="about-timeline">
            {milestones.map(({ icon: Icon, period, title, text }) => (
              <article className="about-timeline-card" key={title}>
                <span className="about-timeline-icon"><Icon size={22} /></span>
                <small>{period}</small>
                <h3>{title}</h3>
                <p>{text}</p>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="about-gallery-section">
        <div className="ra-container">
          <div className="about-section-head about-section-head-row">
            <div>
              <span className="ra-label">Renew Healthcare</span>
              <h2>Designed for privacy, confidence and <em>modern fertility care</em>.</h2>
            </div>
            <div className="about-location-pill"><MapPin size={16} /> Kolkata, West Bengal</div>
          </div>
          <div className="about-gallery-grid">
            {gallery.map(({ image, label }) => (
              <figure className="about-gallery-card" key={image}><img src={image} alt={label} /><figcaption>{label}</figcaption></figure>
            ))}
          </div>
        </div>
      </section>

      <WhyMeSection />

      {/* MY PUBLICATIONS */}
      <section className="ra-section">
        <div className="ra-container">
          <div className="ra-section-head">
            <span className="ra-label">MY PUBLICATIONS</span>
            <h2>Publications &amp; <em>Research</em></h2>
          </div>
          <PublicationCarousel />
        </div>
      </section>

      {/* Frequently Asked Questions */}
      <section className="ra-section ra-section-blue">
        <div className="ra-container ra-faq">
          <div className="ra-section-head">
            <span className="ra-label">FAQ</span>
            <h2>Frequently Asked <em>Questions</em></h2>
          </div>
          <div className="ra-faq-accordion">
            {faqData.map((item, i) => {
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

      <FloatingLeadForm formName="About Me Floating Bottom Form" />
    </div>
  );
}
