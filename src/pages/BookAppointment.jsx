import React from 'react';
import AppointmentForm from '../components/AppointmentForm';
import { Phone, Mail, MapPin, ShieldCheck, Heart, Clock3, MessageCircle } from 'lucide-react';
import useSeo from '../utils/useSeo';
import { getMetaForPath } from '../utils/seoMeta';

export default function BookAppointment() {
  useSeo(getMetaForPath('/book-an-appointment'));
  return (
    <div className="inner-page booking-page-wrap">
      <section className="booking-hero">
        <div className="ra-container booking-hero-grid">
          <div className="booking-hero-copy">
            <span className="booking-eyebrow"><MessageCircle size={16} /> We’re here to help</span>
            <h1>Start with a conversation.<br /><em>Feel cared for.</em></h1>
            <p>Whether you are planning a pregnancy, exploring fertility care, or looking for a second opinion, our team will help you find the right next step.</p>
            <div className="booking-hero-details"><span><Clock3 size={17} /> Response within 24 hours</span><span><ShieldCheck size={17} /> Your details stay private</span></div>
          </div>
          <div className="booking-hero-note"><span className="booking-note-number">01</span><strong>Tell us how we can help</strong><p>Share a few details and our care coordinator will call you to understand your needs and confirm an appointment.</p></div>
        </div>
      </section>
      <main className="ra-container booking-content">
        <div className="inner-card" style={{ padding: 44 }}>
          <div className="booking-card-heading"><span className="ra-label">Book a consultation</span><h2>We’ll take it from here.</h2><p>Fill out the form below. There is no pressure and no obligation.</p></div>
          <AppointmentForm formName="Appointment Page Form" />
        </div>

        <div className="booking-sidebar">
          <div className="booking-info-card">
            <span className="ra-label">Visit or reach us</span><h3 className="booking-info-title">Renew Healthcare Kolkata</h3>
            <ul className="booking-contact-list">
              {[
                { icon: Phone, label: 'Call us', value: '+91 83369 68661', href: 'tel:+918336968661' },
                { icon: Mail, label: 'Email us', value: 'fertilitywithoutborders@gmail.com', href: 'mailto:fertilitywithoutborders@gmail.com' },
                { icon: MapPin, label: 'Find us', value: '18C Mandeville Gardens, Kolkata, West Bengal 700019' },
              ].map((item, i) => {
                const Icon = item.icon;
                return (
                  <li className="booking-contact-item" key={i}>
                    <div className="booking-contact-icon">
                      <Icon size={18} color="var(--deep-teal)" />
                    </div>
                    <div className="booking-contact-copy">
                      <strong style={{ color: 'var(--deep-teal)', fontSize: 15 }}>{item.label}</strong>
                      {item.href ? (
                        <p className="booking-contact-value"><a href={item.href} style={{ color: 'inherit' }}>{item.value}</a></p>
                      ) : (
                        <p className="booking-contact-value">{item.value}</p>
                      )}
                    </div>
                  </li>
                );
              })}
            </ul>
          </div>

          <div className="booking-guarantee">
            <div style={{ display: 'flex', alignItems: 'center', gap: 14 }}>
              <ShieldCheck size={22} color="var(--deep-teal)" style={{ flexShrink: 0 }} />
              <span style={{ color: 'var(--deep-teal)', fontSize: 14, fontWeight: 500 }}><strong style={{ fontWeight: 700 }}>100% Privacy</strong> of medical details & history</span>
            </div>
            <div style={{ display: 'flex', alignItems: 'center', gap: 14 }}>
              <Heart size={22} color="var(--deep-teal)" fill="var(--deep-teal)" style={{ flexShrink: 0 }} />
              <span style={{ color: 'var(--deep-teal)', fontSize: 14, fontWeight: 500 }}><strong style={{ fontWeight: 700 }}>No Hidden Charges</strong> or unwanted clinical tests</span>
            </div>
          </div>
        </div>
      </main>
    </div>
  );
}
