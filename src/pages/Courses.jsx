import React, { useState } from 'react';
import {
  Apple,
  ArrowRight,
  Baby,
  BookOpen,
  CheckCircle,
  GraduationCap,
  HeartPulse,
  MessageCircle,
  Podcast,
  ShieldCheck,
  Star,
  Stethoscope,
  Users,
} from 'lucide-react';
import FloatingLeadForm from '../components/FloatingLeadForm';
import PopupFormWrapper from '../components/PopupFormWrapper';
import courseHeroImg from '../assets/course-hero.webp';
import { submitLead } from '../lib/supabaseBlogAdmin';

const courseCards = [
  {
    title: 'Everything You Need to Know About IVF & ART',
    audience: 'For doctors, fertility teams and informed patients',
    highlight: 'Support Patients with Confidence',
    description: 'Learn effective communication and counselling for fertility patients.',
    bullets: [
      'Emotional support strategies.',
      'Ethical and patient-centric approaches.',
      'Enhance trust and outcomes.',
    ],
  },
  {
    title: 'Fertility Counselling & Patient Communication',
    audience: 'For medical professionals and clinic teams',
    highlight: 'Support Patients with Confidence',
    description: 'Build practical counselling skills for IVF, ART and complex fertility journeys.',
    bullets: [
      'Emotional support strategies.',
      'Ethical and patient-centric approaches.',
      'Enhance trust and outcomes.',
    ],
  },
  {
    title: 'ART Practice Essentials for Clinical Teams',
    audience: 'For fertility experts and care coordinators',
    highlight: 'Support Patients with Confidence',
    description: 'Understand the patient journey, key decision points and care handoffs in ART.',
    bullets: [
      'Emotional support strategies.',
      'Ethical and patient-centric approaches.',
      'Enhance trust and outcomes.',
    ],
  },
];

const servicePillars = [
  { icon: Baby, title: 'Fertility Care', text: 'IVF, IUI and fertility planning explained with clinical clarity.' },
  { icon: Stethoscope, title: 'Gynecology', text: 'Practical learning across reproductive and women\'s health concerns.' },
  { icon: HeartPulse, title: 'Reproductive Health', text: 'Patient-first education for decision-making and long-term confidence.' },
];

const stats = [
  ['25+', 'years of specialist experience'],
  ['4.5', 'course learner rating'],
  ['90+', 'reviewed learning experiences'],
];

function CourseEnrolForm({ courseTitle, onSuccess }) {
  const [submitted, setSubmitted] = useState(false);
  const [submitting, setSubmitting] = useState(false);
  const [submitError, setSubmitError] = useState('');
  const [formData, setFormData] = useState({
    name: '',
    phone: '',
    email: '',
    profile: 'Medical Professional',
    course: courseTitle,
    message: '',
  });

  const handleChange = (event) => {
    const { name, value } = event.target;
    setFormData((current) => ({ ...current, [name]: value }));
  };

  const handleSubmit = async (event) => {
    event.preventDefault();

    setSubmitting(true);
    setSubmitError('');

    try {
      await submitLead(`Course Enrolment - ${courseTitle}`, formData);
      setSubmitted(true);
      window.setTimeout(() => {
        onSuccess?.();
      }, 1500);
    } catch (error) {
      setSubmitError(error.message || 'Could not submit the enrolment request. Please try again.');
    } finally {
      setSubmitting(false);
    }
  };

  if (submitted) {
    return (
      <div className="course-enrol-success">
        <CheckCircle size={46} />
        <h3>Enrolment Request Sent</h3>
        <p>Thank you, {formData.name}. The team will contact you with course details shortly.</p>
      </div>
    );
  }

  return (
    <form className="course-enrol-form" onSubmit={handleSubmit}>
      <div className="form-group">
        <label className="form-label" htmlFor="course-name">Full Name *</label>
        <input
          className="form-control"
          id="course-name"
          name="name"
          onChange={handleChange}
          placeholder="e.g. Priyanjana Das"
          required
          type="text"
          value={formData.name}
        />
      </div>

      <div className="course-form-grid">
        <div className="form-group">
          <label className="form-label" htmlFor="course-phone">Phone Number *</label>
          <input
            className="form-control"
            id="course-phone"
            name="phone"
            onChange={handleChange}
            placeholder="e.g. +91 98300 12345"
            required
            type="tel"
            value={formData.phone}
          />
        </div>
        <div className="form-group">
          <label className="form-label" htmlFor="course-email">Email Address *</label>
          <input
            className="form-control"
            id="course-email"
            name="email"
            onChange={handleChange}
            placeholder="e.g. name@example.com"
            required
            type="email"
            value={formData.email}
          />
        </div>
      </div>

      <div className="course-form-grid">
        <div className="form-group">
          <label className="form-label" htmlFor="course-profile">I am a *</label>
          <select
            className="form-control"
            id="course-profile"
            name="profile"
            onChange={handleChange}
            required
            value={formData.profile}
          >
            <option>Medical Professional</option>
            <option>Fertility Expert</option>
            <option>Care Coordinator</option>
            <option>Informed Patient</option>
          </select>
        </div>
        <div className="form-group">
          <label className="form-label" htmlFor="course-interest">Course Interest *</label>
          <select
            className="form-control"
            id="course-interest"
            name="course"
            onChange={handleChange}
            required
            value={formData.course}
          >
            {[...courseCards.map((course) => course.title), 'PCOS Management & Reproductive Health'].map((course) => (
              <option key={course}>{course}</option>
            ))}
          </select>
        </div>
      </div>

      <div className="form-group">
        <label className="form-label" htmlFor="course-message">Message</label>
        <textarea
          className="form-control"
          id="course-message"
          name="message"
          onChange={handleChange}
          placeholder="Share your learning goal or question..."
          rows="3"
          value={formData.message}
        />
      </div>

      <button className="ra-btn ra-btn-primary course-form-submit" type="submit" disabled={submitting}>
        {submitting ? 'Submitting...' : 'Submit Enrolment Request'}
      </button>
      {submitError && <p className="form-submit-error">{submitError}</p>}
    </form>
  );
}

export default function Courses({ onBookClick }) {
  const [selectedCourse, setSelectedCourse] = useState(null);

  const openEnrolment = (courseTitle) => setSelectedCourse(courseTitle);
  const closeEnrolment = () => setSelectedCourse(null);
  const scrollToCourses = () => {
    document.getElementById('course-list')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
  };

  return (
    <div className="course-page">
      <section className="course-hero-section">
        <div className="course-hero-image-wrap">
          <img src={courseHeroImg} alt="Dr. Rajeev Agarwal leading a fertility care learning session" />
          <div className="course-hero-overlay">
            <div className="ra-container course-hero-content">
              <span className="course-kicker">Expert-Led Courses</span>
              <h1>Explore Our <em>Expert-Led Courses</em></h1>
              <p>
                Gain expert knowledge and hands-on skills in fertility care, gynecology, and reproductive
                health with courses by Dr. Rajeev Agarwal - designed for medical professionals, fertility
                experts, and informed patients.
              </p>
              <div className="course-hero-actions">
                <button className="ra-btn ra-btn-primary" type="button" onClick={onBookClick}>
                  Request Appointment
                </button>
                <button className="ra-btn ra-btn-soft" type="button" onClick={scrollToCourses}>
                  View Courses <ArrowRight size={17} />
                </button>
              </div>
              <div className="course-podcast-actions" aria-label="Podcast platform links">
                <a
                  className="course-podcast-btn course-podcast-apple"
                  href="https://podcasts.apple.com/in/podcast/the-fertility-motherhood-and-wellness-show-true/id1503354252"
                  target="_blank"
                  rel="noreferrer"
                >
                  <Apple size={18} /> Apple Podcasts
                </a>
                <a
                  className="course-podcast-btn course-podcast-google"
                  href="https://music.youtube.com/googlepodcasts"
                  target="_blank"
                  rel="noreferrer"
                >
                  <Podcast size={18} /> Google Podcasts
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section className="course-service-section">
        <div className="ra-container course-service-layout">
          <div className="course-service-copy">
            <span className="ra-label">MY SERVICES</span>
            <h2>Fertility Without <em>Borders</em></h2>
            <p>
              Redefining fertility care with state-of-the-art technology and a compassionate approach,
              ensuring every couple's journey to parenthood is supported and successful.
            </p>
          </div>
          <div className="course-service-grid">
            {servicePillars.map(({ icon: Icon, title, text }) => (
              <article className="course-service-card" key={title}>
                <span><Icon size={22} /></span>
                <h3>{title}</h3>
                <p>{text}</p>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="course-catalog-section" id="course-list">
        <div className="ra-container">
          <div className="course-section-head">
            <span className="ra-label">Course Catalogue</span>
            <h2>Structured learning for fertility care and <em>patient confidence</em>.</h2>
          </div>
          <div className="course-grid">
            {courseCards.map((course) => (
              <article className="course-card" key={course.title}>
                <div className="course-card-topline">
                  <span className="course-audience"><BookOpen size={15} /> {course.audience}</span>
                  <span className="course-rating"><Star size={15} fill="currentColor" /> 4.5 (90 Reviews)</span>
                </div>
                <h3>{course.title}</h3>
                <h4>{course.highlight}</h4>
                <p>{course.description}</p>
                <ul>
                  {course.bullets.map((bullet) => (
                    <li key={bullet}><CheckCircle size={17} /> {bullet}</li>
                  ))}
                </ul>
                <button className="course-enrol-btn" type="button" onClick={() => openEnrolment(course.title)}>
                  Enrol Now <ArrowRight size={16} />
                </button>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="featured-course-section">
        <div className="ra-container featured-course-layout">
          <div className="featured-course-media">
            <img src={courseHeroImg} alt="Dr. Rajeev Agarwal discussing reproductive health in clinic" />
          </div>
          <div className="featured-course-copy">
            <div className="featured-course-tags">
              <span><Users size={15} /> Dr Rajeev</span>
              <span><GraduationCap size={15} /> Featured Course</span>
            </div>
            <h2>PCOS Management &amp; Reproductive Health</h2>
            <div className="featured-rating"><Star size={17} fill="currentColor" /> 4.5 (90 Reviews)</div>
            <h3>Support Patients with Confidence</h3>
            <p>Learn effective communication and counselling for fertility patients.</p>
            <ul>
              <li><ShieldCheck size={18} /> Emotional support strategies.</li>
              <li><MessageCircle size={18} /> Ethical and patient-centric approaches.</li>
              <li><CheckCircle size={18} /> Enhance trust and outcomes.</li>
            </ul>
            <button
              className="ra-btn ra-btn-primary featured-enrol-btn"
              type="button"
              onClick={() => openEnrolment('PCOS Management & Reproductive Health')}
            >
              Enrol Now
            </button>
          </div>
        </div>
      </section>

      <section className="course-proof-section">
        <div className="ra-container course-proof-grid">
          {stats.map(([value, label]) => (
            <div className="course-proof-item" key={label}>
              <strong>{value}</strong>
              <span>{label}</span>
            </div>
          ))}
        </div>
      </section>

      <FloatingLeadForm formName="Courses Floating Bottom Form" />

      <PopupFormWrapper
        isOpen={Boolean(selectedCourse)}
        onClose={closeEnrolment}
        title="Course Enrolment"
      >
        {selectedCourse && (
          <CourseEnrolForm courseTitle={selectedCourse} onSuccess={closeEnrolment} />
        )}
      </PopupFormWrapper>
    </div>
  );
}
