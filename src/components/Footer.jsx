import React from 'react';
import { Link } from 'react-router-dom';

const concernServices = [
  ['Fertility Support', '/fertility-support-services'],
  ['PCOS Care', '/pcos-care'],
  ['Period Pain Relief', '/period-pain-relief'],
  ['Menopause Wellness', '/menopause-wellness'],
  ['Fibroid Solutions', '/fibroids-solutions'],
];

const procedureServices = [
  ['Preconception Care', '/preconception-care'],
  ['Fertility Treatments', '/advanced-fertility-treatments'],
  ['Vaginismus Therapy', '/vaginismus-therapy'],
  ['Urinary Laser Therapy', '/urinary-laser-therapy'],
  ['Laparoscopic Surgery', '/laparoscopic-surgery'],
];

const resources = [
  ['About Dr. Rajeev Agarwal', '/about-me'],
  ['Courses', '/courses'],
  ['Success Stories', '/success-stories'],
  ['Book an Appointment', '/book-an-appointment'],
  ['Blogs', '/blog'],
  ['Videos', 'https://www.youtube.com/@RenewHealthCare', true],
];

const policies = [
  ['terms & conditions', '/terms-conditions'],
  ['privacy policy', '/privacy-policy'],
  ['disclaimer Policy', '/disclaimer-policy'],
  ['Cancellation refund policy', '/cancellation-refund-policy'],
];

export default function Footer() {
  return (
    <div className="ra-footer-wrap">
      <footer className="ra-footer-card">
        <div className="ra-footer-top">
          <div className="ra-footer-left">
            <h2 className="ra-footer-name">Dr. Rajeev Agarwal</h2>
            <p className="ra-footer-desc">
              Dr. Agarwal's expertise, passion, and dedication have made him a trailblazer in fertility
              and healthcare innovation. His pioneering work and unwavering commitment to excellence continue to
              set benchmarks in the medical field.
            </p>

            <h3 className="ra-footer-sub">Contact Us</h3>

            <div className="ra-footer-contact">
              <div className="ra-footer-contact-row">
                <span className="ra-footer-label">Address:</span>
                <span>Renew Health Care, 18C Mandeville Gardens, Kolkata – 700019, West Bengal</span>
              </div>
              <div className="ra-footer-contact-row">
                <span className="ra-footer-label">Contact:</span>
                <a href="tel:+918336968661">+91 83369 68661</a>
              </div>
              <div className="ra-footer-contact-row">
                <span className="ra-footer-label">Email:</span>
                <a href="mailto:fertilitywithoutborders@gmail.com">fertilitywithoutborders@gmail.com</a>
              </div>
            </div>

                        <div className="ra-footer-socials" aria-label="Social links">
              <a href="https://www.facebook.com/profile.php?id=100064167933706" target="_blank" rel="noreferrer" aria-label="Facebook">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3V2z" stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" strokeLinejoin="round"/></svg>
              </a>
              <a href="https://www.instagram.com/docrajeevagarwal/" target="_blank" rel="noreferrer" aria-label="Instagram">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="2" y="2" width="20" height="20" rx="5" stroke="currentColor" strokeWidth="1.6"/><circle cx="12" cy="12" r="5" stroke="currentColor" strokeWidth="1.6"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor"/></svg>
              </a>
              <a href="https://www.youtube.com/@DrRajeevAgarwal" target="_blank" rel="noreferrer" aria-label="YouTube">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58 2.78 2.78 0 0 0 1.94 2C5.12 20 12 20 12 20s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z" stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" strokeLinejoin="round"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="currentColor" stroke="currentColor" strokeWidth="1" strokeLinecap="round" strokeLinejoin="round"/></svg>
              </a>
              <a href="https://www.linkedin.com/in/drrajeevagarwal/" target="_blank" rel="noreferrer" aria-label="LinkedIn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" strokeLinejoin="round"/><path d="M2 9h4v12H2z" stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" strokeLinejoin="round"/><circle cx="4" cy="4" r="2" fill="currentColor" stroke="currentColor" strokeWidth="1.6"/></svg>
              </a>
              <a href="https://wa.me/918336968661" target="_blank" rel="noreferrer" aria-label="WhatsApp">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" strokeLinejoin="round"/></svg>
              </a>
            </div>
          </div>

          <div className="ra-footer-right">
            <div className="ra-footer-hours-card">
              <h3 className="ra-footer-hours-title">Working Hours</h3>
              <p>Monday, Tuesday &amp; Thursday – <strong>Mandeville</strong></p>
              <div className="ra-footer-h-line" />
              <p>Wednesday &amp; Friday – <strong>Saltlake</strong></p>
              <div className="ra-footer-h-line" />
              <p>Timings – <strong>9:30AM – 6:00PM</strong></p>
              <div className="ra-footer-h-line" />
              <p className="ra-footer-h-note">*timings may vary depending on availability</p>
              <Link className="ra-footer-h-btn" to="/book-an-appointment">Book A Visit</Link>
            </div>
          </div>
        </div>

        <div className="ra-footer-divider" />

        <div className="ra-footer-links">
          <div>
            <h4>Services by Concern</h4>
            {concernServices.map(([label, path]) => (
              <Link key={path} to={path}>{label}</Link>
            ))}
          </div>
          <div>
            <h4>Services by Procedure</h4>
            {procedureServices.map(([label, path]) => (
              <Link key={path} to={path}>{label}</Link>
            ))}
          </div>
          <div>
            <h4>Resources</h4>
            {resources.map(([label, path, external]) => (
              external ? (
                <a key={path} href={path} target="_blank" rel="noreferrer">{label}</a>
              ) : (
                <Link key={path} to={path}>{label}</Link>
              )
            ))}
          </div>
        </div>
      </footer>

      <div className="ra-footer-bar">
        <span>&copy; {new Date().getFullYear()} Dr. Rajeev Agarwal | All Rights Reserved</span>
        <div className="ra-footer-bar-links">
          {policies.map(([label, path]) => (
            <Link key={path} to={path}>{label}</Link>
          ))}
        </div>
      </div>
    </div>
  );
}
