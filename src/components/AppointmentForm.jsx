import React, { useState } from 'react';

export default function AppointmentForm({ formName = "General Booking", onSuccess }) {
  const [formData, setFormData] = useState({
    name: '',
    phone: '',
    email: '',
    date: '',
    timeSlot: 'Morning (9:00 AM - 12:00 PM)',
    message: ''
  });

  const [submitted, setSubmitted] = useState(false);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({ ...prev, [name]: value }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    
    // Create submission object
    const newSubmission = {
      id: Date.now(),
      formName,
      data: formData,
      submittedAt: new Date().toLocaleString()
    };
    
    // Save to localStorage
    const existingSubmissions = JSON.parse(localStorage.getItem('formSubmissions') || '[]');
    existingSubmissions.unshift(newSubmission);
    localStorage.setItem('formSubmissions', JSON.stringify(existingSubmissions));
    
    // Reset form
    setSubmitted(true);
    if (onSuccess) {
      setTimeout(() => {
        onSuccess();
      }, 1500);
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
          <label className="form-label" htmlFor="phone">Phone Number *</label>
          <input
            type="tel"
            id="phone"
            name="phone"
            required
            value={formData.phone}
            onChange={handleChange}
            className="form-control"
            placeholder="e.g. +91 98300 12345"
          />
        </div>
        <div className="form-group">
          <label className="form-label" htmlFor="email">Email Address *</label>
          <input
            type="email"
            id="email"
            name="email"
            required
            value={formData.email}
            onChange={handleChange}
            className="form-control"
            placeholder="e.g. name@example.com"
          />
        </div>
      </div>

      <div className="grid-2" style={{ gap: '16px', margin: 0 }}>
        <div className="form-group">
          <label className="form-label" htmlFor="date">Preferred Date *</label>
          <input
            type="date"
            id="date"
            name="date"
            required
            value={formData.date}
            onChange={handleChange}
            className="form-control"
          />
        </div>
        <div className="form-group">
          <label className="form-label" htmlFor="timeSlot">Preferred Time Slot *</label>
          <select
            id="timeSlot"
            name="timeSlot"
            required
            value={formData.timeSlot}
            onChange={handleChange}
            className="form-control"
          >
            <option>Morning (9:00 AM - 12:00 PM)</option>
            <option>Afternoon (12:00 PM - 4:00 PM)</option>
            <option>Evening (4:00 PM - 8:00 PM)</option>
          </select>
        </div>
      </div>

      <div className="form-group">
        <label className="form-label" htmlFor="message">Medical Concerns / Notes</label>
        <textarea
          id="message"
          name="message"
          rows="3"
          value={formData.message}
          onChange={handleChange}
          className="form-control"
          placeholder="Briefly describe your concerns or queries..."
          style={{ resize: 'vertical' }}
        />
      </div>

      <button type="submit" className="btn btn-primary" style={{ width: '100%', marginTop: '8px' }}>
        Confirm Appointment Request
      </button>
    </form>
  );
}
