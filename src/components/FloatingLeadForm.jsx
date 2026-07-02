import React, { useEffect, useState } from 'react';
import { submitLead } from '../lib/supabaseBlogAdmin';

export default function FloatingLeadForm({ formName = 'Floating Bottom Form' }) {
  const [hasScrolled, setHasScrolled] = useState(false);
  const [footerVisible, setFooterVisible] = useState(false);
  const [submitted, setSubmitted] = useState(false);
  const [submitting, setSubmitting] = useState(false);
  const [submitError, setSubmitError] = useState('');
  const [formData, setFormData] = useState({
    name: '',
    phone: '',
    email: '',
    service: '',
    concern: '',
  });

  useEffect(() => {
    const onScroll = () => setHasScrolled(window.scrollY > 420);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
    return () => window.removeEventListener('scroll', onScroll);
  }, []);

  useEffect(() => {
    const footer = document.querySelector('.ra-footer-wrap');
    if (!footer || typeof IntersectionObserver === 'undefined') return undefined;

    const observer = new IntersectionObserver(
      ([entry]) => setFooterVisible(entry.isIntersecting),
      { rootMargin: '0px 0px -12% 0px', threshold: 0.04 }
    );

    observer.observe(footer);
    return () => observer.disconnect();
  }, []);

  const visible = hasScrolled && !footerVisible;
  const hiddenTabIndex = visible ? undefined : -1;

  const handleChange = (event) => {
    const { name, value } = event.target;
    setFormData((current) => ({ ...current, [name]: value }));
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    if (submitting) return;

    setSubmitting(true);
    setSubmitError('');

    try {
      const result = await submitLead(formName, formData);
      if (!result) throw new Error('No response from server.');
      setSubmitted(true);
      setFormData({ name: '', phone: '', email: '', service: '', concern: '' });
    } catch (error) {
      setSubmitError(error.message || 'Could not submit the callback request. Please try again.');
    } finally {
      setSubmitting(false);
    }
  };

  return (
    <aside className={`ra-floating-lead ${visible ? 'is-visible' : ''}`} aria-label="Quick appointment request">
      <div className="ra-floating-lead-inner">
        {submitted ? (
          <p className="ra-floating-lead-success">Thank you. Our team will contact you shortly.</p>
        ) : (
          <>
            <div className="ra-floating-lead-copy">
              <strong>Need guidance?</strong>
              <span>Request a call back from Dr. Rajeev's team.</span>
            </div>
            <form className="ra-floating-lead-form" onSubmit={handleSubmit}>
              <input
                aria-label="Full name"
                name="name"
                placeholder="Name"
                required
                tabIndex={hiddenTabIndex}
                type="text"
                value={formData.name}
                onChange={handleChange}
              />
              <input
                aria-label="Phone number"
                name="phone"
                placeholder="Phone"
                required
                tabIndex={hiddenTabIndex}
                type="tel"
                value={formData.phone}
                onChange={handleChange}
              />
              <input
                aria-label="Email"
                name="email"
                placeholder="Email"
                tabIndex={hiddenTabIndex}
                type="email"
                value={formData.email}
                onChange={handleChange}
              />
              <select
                aria-label="Service"
                name="service"
                tabIndex={hiddenTabIndex}
                value={formData.service}
                onChange={handleChange}
              >
                <option value="">Service</option>
                <option value="Fertility Support">Fertility Support</option>
                <option value="PCOS Care">PCOS Care</option>
                <option value="Appointment">Appointment</option>
                <option value="General Query">General Query</option>
              </select>
              <input
                aria-label="Concern"
                name="concern"
                placeholder="Concern"
                tabIndex={hiddenTabIndex}
                type="text"
                value={formData.concern}
                onChange={handleChange}
              />
              <button tabIndex={hiddenTabIndex} type="submit">Request Call</button>
            </form>
            {submitError && <p className="ra-floating-lead-error">{submitError}</p>}
            {submitting && <p className="ra-floating-lead-status">Submitting...</p>}
          </>
        )}
      </div>
    </aside>
  );
}
