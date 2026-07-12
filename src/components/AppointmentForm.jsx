import React, { useState } from 'react';
import { submitLead } from '../lib/supabaseBlogAdmin';
import { LEAD_PURPOSE_OPTIONS } from '../lib/leadFormOptions';

export default function AppointmentForm({ formName = "General Booking", onSuccess }) {
  const [formData, setFormData] = useState({
    name: '',
    contact_number: '',
    whatsapp_number: '',
    purpose_of_visit: '',
  });

  const [submitted, setSubmitted] = useState(false);
  const [submitting, setSubmitting] = useState(false);
  const [submitError, setSubmitError] = useState('');

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({ ...prev, [name]: value }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    setSubmitting(true);
    setSubmitError('');

    try {
      await submitLead(formName, formData);
      setSubmitted(true);
      if (onSuccess) {
        setTimeout(() => {
          onSuccess();
        }, 1500);
      }
    } catch (error) {
      setSubmitError(error.message || 'Could not submit the appointment request. Please try again.');
    } finally {
      setSubmitting(false);
    }
  };

  if (submitted) {
    return (
      <div style={{ textAlign: 'center', padding: '24px' }}>
        <div style={{ fontSize: '48px', color: 'var(--primary)', marginBottom: '16px' }}>✓</div>
        <h3 style={{ marginBottom: '8px' }}>Submission Successful!</h3>
        <p>Thank you, {formData.name}. Your details have been saved, and we will contact you shortly.</p>
      </div>
    );
  }

  return (
    <form onSubmit={handleSubmit} className="appointment-form">
      <div className="form-group">
        <label className="form-label" htmlFor="name">Full Name *</label>
        <input
          type="text"
          id="name"
          name="name"
          required
          value={formData.name}
          onChange={handleChange}
          className="form-control"
          placeholder="e.g. Priyanjana Das"
        />
      </div>
      
      <div className="grid-2" style={{ gap: '16px', margin: 0 }}>
        <div className="form-group">
          <label className="form-label" htmlFor="contact_number">contact number *</label>
          <input
            type="tel"
            id="contact_number"
            name="contact_number"
            required
            value={formData.contact_number}
            onChange={handleChange}
            className="form-control"
            placeholder="e.g. +91 98300 12345"
          />
        </div>
        <div className="form-group">
          <label className="form-label" htmlFor="whatsapp_number">whatsapp number *</label>
          <input
            type="tel"
            id="whatsapp_number"
            name="whatsapp_number"
            required
            value={formData.whatsapp_number}
            onChange={handleChange}
            className="form-control"
            placeholder="e.g. +91 98300 12345"
          />
        </div>
      </div>

      <div className="form-group">
        <label className="form-label" htmlFor="purpose_of_visit">purrpose of vist *</label>
        <select
          id="purpose_of_visit"
          name="purpose_of_visit"
          required
          value={formData.purpose_of_visit}
          onChange={handleChange}
          className="form-control"
        >
          <option value="">Select purpose</option>
          {LEAD_PURPOSE_OPTIONS.map((option) => (
            <option key={option} value={option}>{option}</option>
          ))}
        </select>
      </div>

      {submitError && (
        <p className="form-submit-error">{submitError}</p>
      )}

      <button type="submit" className="btn btn-primary" style={{ width: '100%', marginTop: '8px' }} disabled={submitting}>
        {submitting ? 'Submitting...' : 'Confirm Appointment Request'}
      </button>
    </form>
  );
}
