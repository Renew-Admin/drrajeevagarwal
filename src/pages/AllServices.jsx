import React, { useState } from 'react';
import { Calendar, Stethoscope, Heart, Activity, ArrowRight, Users, Search } from 'lucide-react';
import { Link } from 'react-router-dom';

const servicesByConcern = [
  { title: "Fertility Support", description: "Personalised fertility guidance for couples planning pregnancy or facing delays in conception.", link: "/fertility-support-services", icon: Heart },
  { title: "PCOS Care", description: "Diagnosis, hormonal support, lifestyle guidance and fertility-focused treatment for PCOS.", link: "/pcos-care", icon: Activity },
  { title: "Period Pain Relief", description: "Evaluation and treatment for severe menstrual pain, endometriosis, fibroids and hormonal causes.", link: "/period-pain-relief", icon: Stethoscope },
  { title: "Menopause Wellness", description: "Holistic support for hot flashes, mood changes, bone health, hormones and confident ageing.", link: "/menopause-wellness", icon: Activity },
  { title: "Fibroid Solutions", description: "Medical and minimally invasive treatment options for fibroids affecting fertility or menstrual health.", link: "/fibroids-solutions", icon: Stethoscope },
  { title: "Infertility Help", description: "Expert evaluation and fertility planning for couples facing difficulty conceiving.", link: "/infertility-help", icon: Heart },
  { title: "Urinary Health", description: "Modern care for urinary incontinence, pelvic health and post-childbirth concerns.", link: "/urinary-incontinence", icon: Activity },
  { title: "Healthy Aging", description: "Hormonal balance, bone health, metabolic wellness and long-term women's health support.", link: "/healthy-aging", icon: Heart },
  { title: "Sexual Pain Relief", description: "Compassionate evaluation and treatment plans for pain during intercourse and pelvic discomfort.", link: "/sexual-pain-relief", icon: Stethoscope },
];

const fertilityProcedures = [
  { title: "Preconception Care", description: "Comprehensive health check and counseling before planning a pregnancy.", link: "/preconception-care", bestFor: "Planning Pregnancy" },
  { title: "Ovulation Induction", description: "Medical stimulation of ovulation to increase the chances of natural conception.", link: "/advanced-fertility-treatments", bestFor: "Irregular Cycles" },
  { title: "IUI (Intrauterine Insemination)", description: "Placing sperm directly into the uterus during ovulation.", link: "/advanced-fertility-treatments", bestFor: "Mild Male Factor" },
  { title: "IVF, ICSI & Embryo Culture", description: "Advanced assisted reproductive technologies for complex fertility issues.", link: "/advanced-fertility-treatments", bestFor: "Blocked Tubes / Severe Male Factor" },
  { title: "Fertility Preservation", description: "Egg and sperm freezing for medical or social reasons.", link: "/advanced-fertility-treatments", bestFor: "Future Planning" },
  { title: "Fertility Treatments", description: "A wide array of treatments tailored to your unique reproductive needs.", link: "/advanced-fertility-treatments", bestFor: "Comprehensive Care" },
];

const womensHealthProcedures = [
  { title: "Vaginismus Therapy", description: "Compassionate therapy and treatment for involuntary pelvic muscle spasms.", link: "/vaginismus-therapy", bestFor: "Painful Intercourse" },
  { title: "Urinary Laser Therapy", description: "Non-surgical laser treatment for urinary incontinence and vaginal health.", link: "/urinary-laser-therapy", bestFor: "Incontinence" },
  { title: "Laparoscopic Surgery", description: "Minimally invasive keyhole surgery for diagnosing and treating pelvic conditions.", link: "/laparoscopic-surgery", bestFor: "Endometriosis / Fibroids" },
  { title: "Hysteroscopic Procedure", description: "Examining and treating conditions inside the uterine cavity without incisions.", link: "/hysteroscopic-procedure", bestFor: "Polyps / Septum" },
  { title: "Virtual Consults", description: "Convenient online consultations for expert advice from the comfort of your home.", link: "/virtual-consults", bestFor: "Remote Care" },
  { title: "Women's Health Check", description: "Comprehensive preventive health screenings designed for women at every stage.", link: "/womens-health-check", bestFor: "Preventive Care" },
];

const faqs = [
  { question: "When should I consult a fertility specialist?", answer: "You should consider seeing a fertility specialist if you are under 35 and have been trying to conceive for a year without success, or if you are over 35 and have been trying for six months. It's also advisable if you have known issues like irregular periods, PCOS, endometriosis, or a history of miscarriages." },
  { question: "What fertility treatments are available?", answer: "We offer a comprehensive range of treatments including Ovulation Induction, Intrauterine Insemination (IUI), In Vitro Fertilization (IVF), Intracytoplasmic Sperm Injection (ICSI), and Fertility Preservation (egg/sperm freezing)." },
  { question: "Is IVF the only option for infertility?", answer: "No, IVF is not the only option. Depending on the diagnosis, treatments like lifestyle modifications, medication for ovulation induction, or IUI might be recommended first." },
  { question: "What is the difference between IUI and IVF?", answer: "IUI involves placing specially prepared sperm directly into the uterus during ovulation. IVF involves retrieving eggs, fertilizing them with sperm in a lab, and transferring the resulting embryo(s) back into the uterus." },
  { question: "Can PCOS affect fertility?", answer: "Yes, PCOS is a common cause of female infertility because it can interfere with regular ovulation. However, with appropriate management, many women with PCOS successfully conceive." },
  { question: "When is laparoscopic surgery needed?", answer: "Laparoscopic surgery is often recommended to diagnose or treat conditions affecting fertility or causing pelvic pain, such as endometriosis, ovarian cysts, uterine fibroids, or blocked fallopian tubes." },
  { question: "Do you offer online consultation?", answer: "Yes, we offer virtual consults for your convenience. This allows you to discuss your medical history, get expert advice, and formulate a plan from the comfort of your home." },
  { question: "How do I book an appointment?", answer: "You can book an appointment by clicking the 'Book Appointment' button on our website, calling our clinic directly, or reaching out to us via WhatsApp." },
];

export default function AllServices({ onBookClick }) {
  const [activeTab, setActiveTab] = useState('All Services');
  const [openFaq, setOpenFaq] = useState(null);

  const scrollToSection = (sectionId, tabName) => {
    setActiveTab(tabName);
    const el = document.getElementById(sectionId);
    if (el) {
      const top = el.getBoundingClientRect().top + window.pageYOffset - 130;
      window.scrollTo({ top, behavior: "smooth" });
    }
  };

  const tabs = [
    { name: 'All Services', id: 'intro' },
    { name: 'By Concern', id: 'services-concern' },
    { name: 'Fertility Care', id: 'fertility-procedures' },
    { name: "Women's Health", id: 'womens-procedures' },
  ];

  return (
    <div className="inner-page" style={{ paddingTop: 0 }}>
      {/* 1. Hero — full-width image with overlay */}
      <section className="about-hero-image-section">
        <div className="about-hero-image-wrap">
          <img src="/assets/all-services-hero.webp" alt="Dr. Rajeev Agarwal – Fertility Specialist" />
          <div className="about-hero-image-overlay" style={{ alignItems: 'center' }}>
            <div className="ra-container about-hero-image-content services-hero-content">
              <div className="services-hero-inner">
                <h1>
                  <span className="services-hero-title-white">Fertility &amp; </span>
                  <span className="services-hero-title-gold">Gynecological Services</span>
                </h1>
                <p className="services-hero-sub">Advanced IVF, IUI, laparoscopic &amp; women's health — designed around your goals.</p>
                <div className="services-hero-actions">
                  <button className="ra-btn ra-btn-primary" onClick={onBookClick}>Book Appointment</button>
                  <button className="ra-btn ra-btn-soft" onClick={() => scrollToSection('services-concern', 'By Concern')}>View Services</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* 2. Sticky Nav */}
      <div className="sticky-nav">
        <div className="ra-container">
          <div className="sticky-nav-inner">
            {tabs.map(tab => (
              <button key={tab.name} onClick={() => scrollToSection(tab.id, tab.name)} className={`sticky-nav-btn ${activeTab === tab.name ? 'active' : ''}`}>{tab.name}</button>
            ))}
          </div>
        </div>
      </div>

      {/* 3. Intro */}
      <section id="intro" className="inner-section">
        <div className="ra-container">
          <div className="section-head">
            <h2>Care Designed Around Your <em>Journey</em></h2>
            <p>Whether you are planning pregnancy, struggling with infertility, managing PCOS, or looking for advanced surgical care, Dr. Rajeev Agarwal offers evidence-based treatment with empathy, precision and transparency.</p>
          </div>
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(220px, 1fr))', gap: 24, maxWidth: 800, margin: '0 auto' }}>
            {[
              { title: 'Diagnose Clearly', icon: Activity },
              { title: 'Treat Personally', icon: Heart },
              { title: 'Guide Compassionately', icon: Stethoscope },
            ].map((item, i) => {
              const Icon = item.icon;
              return (
                <div key={i} className="inner-card" style={{ display: 'flex', flexDirection: 'column', alignItems: 'center', gap: 12, textAlign: 'center', padding: 28 }}>
                  <div className="inner-card-icon" style={{ width: 54, height: 54, borderRadius: '50%' }}><Icon size={24} /></div>
                  <h3 style={{ fontSize: 16, fontWeight: 700, color: 'var(--deep-teal)' }}>{item.title}</h3>
                </div>
              );
            })}
          </div>
        </div>
      </section>

      {/* 4. Services by Concern */}
      <section id="services-concern" className="inner-section inner-section-blue">
        <div className="ra-container">
          <div className="section-head">
            <h2>Find Care by <em>Concern</em></h2>
            <p>Choose the health concern closest to your current need and explore the right treatment pathway.</p>
          </div>
          <div className="service-concern-grid">
            {servicesByConcern.map((svc, i) => {
              const Icon = svc.icon;
              return (
                <div key={i} className="service-concern-card">
                  <div className="service-concern-icon"><Icon size={28} /></div>
                  <h3>{svc.title}</h3>
                  <p>{svc.description}</p>
                  <div className="service-concern-footer">
                    <Link to={svc.link} className="service-concern-link">Learn More <ArrowRight size={14} /></Link>
                    <button onClick={onBookClick} className="service-concern-book">Book</button>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </section>

      {/* 5. Procedures */}
      <section className="inner-section">
        <div className="ra-container">
          <div className="section-head">
            <h2>Explore Treatments by <em>Procedure</em></h2>
            <p>Advanced fertility and gynaecological procedures delivered with clinical precision and personalised care.</p>
          </div>

          <div id="fertility-procedures" style={{ marginBottom: 56 }}>
            <h3 style={{ fontSize: 24, fontWeight: 800, color: 'var(--deep-teal)', marginBottom: 24, paddingBottom: 14, borderBottom: '2px solid var(--soft-blue)' }}>Fertility Procedures</h3>
            <div className="procedure-grid">
              {fertilityProcedures.map((proc, i) => (
                <div key={i} className="procedure-card">
                  <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: 14 }}>
                    <h4 style={{ maxWidth: '70%' }}>{proc.title}</h4>
                    <span className="procedure-badge">{proc.bestFor}</span>
                  </div>
                  <p style={{ color: 'var(--text-soft)', fontSize: 14, lineHeight: 1.6, marginBottom: 20 }}>{proc.description}</p>
                  <Link to={proc.link} style={{ display: 'flex', alignItems: 'center', gap: 6, color: 'var(--deep-teal)', fontWeight: 700, fontSize: 14 }}>Learn More <ArrowRight size={14} /></Link>
                </div>
              ))}
            </div>
          </div>

          <div id="womens-procedures">
            <h3 style={{ fontSize: 24, fontWeight: 800, color: 'var(--deep-teal)', marginBottom: 24, paddingBottom: 14, borderBottom: '2px solid var(--soft-blue)' }}>Advanced Women's Health Procedures</h3>
            <div className="procedure-grid">
              {womensHealthProcedures.map((proc, i) => (
                <div key={i} className="procedure-card">
                  <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: 14 }}>
                    <h4 style={{ maxWidth: '70%' }}>{proc.title}</h4>
                    <span className="procedure-badge">{proc.bestFor}</span>
                  </div>
                  <p style={{ color: 'var(--text-soft)', fontSize: 14, lineHeight: 1.6, marginBottom: 20 }}>{proc.description}</p>
                  <Link to={proc.link} style={{ display: 'flex', alignItems: 'center', gap: 6, color: 'var(--deep-teal)', fontWeight: 700, fontSize: 14 }}>Learn More <ArrowRight size={14} /></Link>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* 6. Journey */}
      <section className="inner-section inner-section-blue">
        <div className="ra-container">
          <div className="section-head"><h2>Your Care <em>Journey</em></h2></div>
          <div className="journey-modern">
            <div className="journey-line"></div>
            {[
              { step: 1, title: 'Book Consultation', icon: Calendar },
              { step: 2, title: 'Diagnosis & Evaluation', icon: Search },
              { step: 3, title: 'Personalised Plan', icon: Stethoscope },
              { step: 4, title: 'Procedure / Treatment', icon: Heart },
              { step: 5, title: 'Ongoing Support', icon: Users },
            ].map((item, i) => {
              const Icon = item.icon;
              return (
                <div key={i} className="journey-step">
                  <div className="journey-circle"><Icon size={26} /><span className="journey-number">{item.step}</span></div>
                  <h4 style={{ fontWeight: 700, color: 'var(--deep-teal)', fontSize: 14 }}>{item.title}</h4>
                </div>
              );
            })}
          </div>
        </div>
      </section>

      {/* 7. Trust Section */}
      <section className="dark-section">
        <div className="ra-container">
          <div className="section-head"><h2>Why Patients <em>Trust</em> Dr. Rajeev Agarwal</h2></div>
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(260px, 1fr))', gap: 28 }}>
            {[
              { stat: '25+', text: 'Years of expertise in IVF & reproductive medicine' },
              { stat: '10,000+', text: 'Patients successfully treated' },
              { stat: 'Advanced', text: 'Fertility and laboratory support' },
              { stat: 'Personalised', text: 'Treatment plans for every journey' },
              { stat: 'Ethical', text: 'Transparent and compassionate care' },
              { stat: 'Expertise', text: 'In IVF, IUI, ICSI, laparoscopy and hysteroscopy' },
            ].map((item, i) => (
              <div key={i} className="dark-stat-card">
                <h3>{item.stat}</h3>
                <p>{item.text}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* 8. Featured CTA */}
      <section className="inner-section inner-section-blue">
        <div className="ra-container">
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(280px, 1fr))', gap: 28 }}>
            <div className="inner-card" style={{ padding: 36 }}>
              <h3 style={{ fontSize: 20, fontWeight: 800, color: 'var(--deep-teal)', marginBottom: 16 }}>IVF & Advanced Fertility Treatments</h3>
              <Link to="/advanced-fertility-treatments" className="ra-btn ra-btn-primary" style={{ width: '100%', justifyContent: 'center' }}>Explore IVF Care</Link>
            </div>
            <div className="inner-card" style={{ padding: 36, background: 'var(--deep-teal)', color: '#fff' }}>
              <h3 style={{ fontSize: 20, fontWeight: 800, color: '#fff', marginBottom: 16 }}>Laparoscopic & Hysteroscopic Surgery</h3>
              <Link to="/laparoscopic-surgery" className="ra-btn ra-btn-soft" style={{ width: '100%', justifyContent: 'center', background: '#fff', color: 'var(--deep-teal)' }}>View Surgical Care</Link>
            </div>
            <div className="inner-card" style={{ padding: 36 }}>
              <h3 style={{ fontSize: 20, fontWeight: 800, color: 'var(--deep-teal)', marginBottom: 16 }}>Women's Health & Wellness</h3>
              <button onClick={onBookClick} className="ra-btn ra-btn-primary" style={{ width: '100%', justifyContent: 'center' }}>Start Consultation</button>
            </div>
          </div>
        </div>
      </section>

      {/* 9. FAQ */}
      <section className="ra-section ra-section-blue">
        <div className="ra-container ra-faq">
          <div className="ra-section-head">
            <span className="ra-label">FAQ</span>
            <h2>Questions Patients Often <em>Ask</em></h2>
          </div>
          <div className="ra-faq-accordion">
            {faqs.map((faq, i) => {
              const open = openFaq === i;
              return (
                <div key={i} className={`ra-faq-item ${open ? 'ra-faq-item--open' : ''}`}>
                  <button className="ra-faq-q" onClick={() => setOpenFaq(open ? null : i)}>
                    <span>{faq.question}</span>
                    <span className={`ra-faq-icon ${open ? 'ra-faq-icon--open' : ''}`}>
                      <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M9 3v12M3 9h12" stroke="currentColor" strokeWidth="2" strokeLinecap="round"/></svg>
                    </span>
                  </button>
                  <div className={`ra-faq-a-wrap ${open ? 'ra-faq-a-wrap--open' : ''}`}>
                    <div className="ra-faq-a">{faq.answer}</div>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </section>

      {/* 10. Final CTA */}
      <section className="inner-section" style={{ paddingTop: 0 }}>
        <div className="ra-container">
          <div className="cta-modern">
            <h2>Not sure which service is <em>right</em> for you?</h2>
            <p>Book a consultation with Dr. Rajeev Agarwal and receive personalised guidance based on your health condition, age, medical history and fertility goals.</p>
            <div className="cta-actions">
              <button className="ra-btn ra-btn-primary" onClick={onBookClick} style={{ padding: '0 32px', height: 50, fontSize: 16 }}>Book Appointment</button>
              <a href="https://wa.me/918336977755" target="_blank" rel="noopener noreferrer" className="ra-btn ra-btn-soft" style={{ padding: '0 32px', height: 50, fontSize: 16 }}>WhatsApp Us</a>
            </div>
          </div>
        </div>
      </section>
    </div>
  );
}
