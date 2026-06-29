import React from 'react';
import AppointmentForm from '../components/AppointmentForm';
import { Phone, Mail, MapPin, ShieldCheck, Heart } from 'lucide-react';

export default function BookAppointment() {
  return (
    <div className="inner-page" style={{ background: 'var(--soft-blue)', paddingBottom: 80 }}>
      <div className="ra-container booking-grid" style={{ paddingTop: 50 }}>
        <div className="inner-card" style={{ padding: 44 }}>
          <h2 style={{ fontSize: 28, color: 'var(--deep-teal)', marginBottom: 10, fontWeight: 800 }}>Book Your Consultation</h2>
          <p style={{ color: 'var(--text-soft)', fontSize: 15, marginBottom: 28, lineHeight: 1.6, fontWeight: 500 }}>
            Fill out the form below, and our care coordinator will reach out to confirm your slot within 24 hours.
          </p>
          <AppointmentForm formName="Appointment Page Form" />
        </div>

        <div style={{ display: 'flex', flexDirection: 'column', gap: 24 }}>
          <div className="booking-info-card">
            <h3 style={{ fontSize: 20, color: 'var(--deep-teal)', marginBottom: 20, fontWeight: 800, borderBottom: '2px solid var(--border)', paddingBottom: 8 }}>Renew Healthcare Kolkata</h3>
            <ul style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex', flexDirection: 'column', gap: 22 }}>
              {[
                { icon: Phone, label: 'Phone Contact', value: '+91 83369 68661' },
                { icon: Mail, label: 'Email Inquiry', value: 'fertilitywithoutborders@gmail.com', href: 'mailto:fertilitywithoutborders@gmail.com' },
                { icon: MapPin, label: 'Address', value: 'Renew Healthcare, 18C Mandeville Gardens, Kolkata, West Bengal 700019' },
              ].map((item, i) => {
                const Icon = item.icon;
                return (
                  <li key={i} style={{ display: 'flex', gap: 16, alignItems: 'flex-start' }}>
                    <div style={{ width: 42, height: 42, borderRadius: '50%', background: 'var(--blue-pale)', display: 'grid', placeItems: 'center', flexShrink: 0 }}>
                      <Icon size={18} color="var(--deep-teal)" />
                    </div>
                    <div>
                      <strong style={{ color: 'var(--deep-teal)', fontSize: 15 }}>{item.label}</strong>
                      {item.href ? (
                        <p style={{ margin: '4px 0 0', fontSize: 14, color: 'var(--text-mid)', fontWeight: 500 }}><a href={item.href} style={{ color: 'inherit' }}>{item.value}</a></p>
                      ) : (
                        <p style={{ margin: '4px 0 0', fontSize: 14, color: 'var(--text-mid)', fontWeight: 500, lineHeight: 1.5 }}>{item.value}</p>
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
