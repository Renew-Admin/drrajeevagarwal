import React from 'react';
import AppointmentForm from '../components/AppointmentForm';
import { Phone, Mail, MapPin, ShieldCheck, Heart } from 'lucide-react';
import useSeo from '../utils/useSeo';
import { getMetaForPath } from '../utils/seoMeta';

export default function BookAppointment() {
  useSeo(getMetaForPath('/book-an-appointment'));
  return (
    <div className="inner-page booking-page-wrap" style={{ background: 'var(--soft-blue)', paddingBottom: 80 }}>
      <div className="ra-container booking-grid" style={{ paddingTop: 30 }}>
        <div className="inner-card" style={{ padding: 44 }}>
          {/* The page's main heading, so it is an h1 — this route previously
              shipped no h1 at all. Every visual property is set inline and the
              global h1/h2/h3 rules are identical, so this renders unchanged. */}
          <h1 style={{ fontSize: 28, color: 'var(--deep-teal)', marginBottom: 10, fontWeight: 800 }}>Book Your Consultation</h1>
          <p style={{ color: 'var(--text-soft)', fontSize: 15, marginBottom: 28, lineHeight: 1.6, fontWeight: 500 }}>
            Fill out the form below, and our care coordinator will reach out to confirm your slot within 24 hours.
          </p>
          <AppointmentForm formName="Appointment Page Form" />
        </div>

        <div className="booking-sidebar">
          <div className="booking-info-card">
            <h3 className="booking-info-title">Renew Healthcare Kolkata</h3>
            <ul className="booking-contact-list">
              {[
                { icon: Phone, label: 'Phone Contact', value: '+91 83369 68661' },
                { icon: Mail, label: 'Email Inquiry', value: 'fertilitywithoutborders@gmail.com', href: 'mailto:fertilitywithoutborders@gmail.com' },
                { icon: MapPin, label: 'Address', value: 'Renew Healthcare, 18C Mandeville Gardens, Kolkata, West Bengal 700019' },
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
      </div>
    </div>
  );
}
