import { Mail, Phone, MapPin, Clock3 } from 'lucide-react';
import AppointmentForm from '../components/AppointmentForm';
import DoctorMap from '../components/DoctorMap';
import useSeo from '../utils/useSeo';
import { getMetaForPath } from '../utils/seoMeta';

export default function Contact() {
  useSeo(getMetaForPath('/contact-us'));

  return (
    <div className="inner-page contact-page">
      <section className="booking-hero">
        <div className="ra-container booking-hero-grid">
          <div className="booking-hero-copy">
            <span className="booking-eyebrow">Contact us</span>
            <h1>Get in touch with <em>Dr. Rajeev Agarwal.</em></h1>
            <p>Questions about fertility care or an appointment? Reach our team by phone, email, or the form below.</p>
          </div>
        </div>
      </section>

      <div className="ra-container contact-page-grid">
        <section className="contact-page-card" aria-labelledby="contact-form-title">
          <span className="ra-label">Send a request</span>
          <h2 id="contact-form-title">How can we help?</h2>
          <AppointmentForm formName="Contact Page Form" />
        </section>

        <section className="contact-page-card" aria-labelledby="contact-details-title">
          <span className="ra-label">Visit or reach us</span>
          <h2 id="contact-details-title">Contact details</h2>
          <ul className="contact-page-details">
            <li><Phone size={20} aria-hidden="true" /><a href="tel:+916292312076">+91 62923 12076</a></li>
            <li><Mail size={20} aria-hidden="true" /><a href="mailto:fertilitywithoutborders@gmail.com">fertilitywithoutborders@gmail.com</a></li>
            <li><MapPin size={20} aria-hidden="true" /><span>Ground Floor, 18 C, Mandeville Gardens, Ballygunge, Kolkata 700019</span></li>
            <li><Clock3 size={20} aria-hidden="true" /><span>Monday to Saturday, 9:00 AM – 6:30 PM</span></li>
          </ul>
        </section>
      </div>

      <section className="ra-section doctor-map-section" aria-labelledby="contact-map-title">
        <div className="ra-container">
          <span className="ra-label">Find us</span>
          <h2 id="contact-map-title" className="ra-title">Dr. Rajeev Agarwal on Google Maps</h2>
          <DoctorMap />
        </div>
      </section>
    </div>
  );
}
