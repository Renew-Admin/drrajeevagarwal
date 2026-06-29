import React, { useEffect, useState } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { ChevronDown, Menu, MessageCircle, X } from 'lucide-react';

const dropdownConcerns = [
  { title: 'Fertility Support', href: '/fertility-support-services' },
  { title: 'PCOS Care', href: '/pcos-care' },
  { title: 'Period Pain Relief', href: '/period-pain-relief' },
  { title: 'Infertility Help', href: '/infertility-help' },
  { title: 'Menopause Wellness', href: '/menopause-wellness' },
  { title: 'Fibroid Solutions', href: '/fibroids-solutions' },
];

const dropdownProcedures = [
  { title: 'Preconception Care', href: '/preconception-care' },
  { title: 'Fertility Treatments', href: '/advanced-fertility-treatments' },
  { title: 'Vaginismus Therapy', href: '/vaginismus-therapy' },
  { title: 'Urinary Laser Therapy', href: '/urinary-laser-therapy' },
  { title: 'Laparoscopic Surgery', href: '/laparoscopic-surgery' },
  { title: 'Hysteroscopic Procedure', href: '/hysteroscopic-procedure' },
];

export default function Header({ onBookClick }) {
  const [open, setOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const location = useLocation();

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 20);
    onScroll();
    window.addEventListener('scroll', onScroll);
    return () => window.removeEventListener('scroll', onScroll);
  }, []);

  useEffect(() => {
    setOpen(false);
  }, [location.pathname]);

  const book = () => {
    setOpen(false);
    onBookClick?.();
  };

  const homeAnchor = (hash) => (location.pathname === '/' ? hash : `/${hash}`);
  const nav = (
    <>
      <Link to="/about-me" className={location.pathname === '/about-me' ? 'is-active' : ''}>About Me</Link>
      <div className="ra-nav-dropdown">
        <Link to="/all-services" className="ra-nav-dropdown-link">
          Services <ChevronDown size={14} />
        </Link>
        <div className="ra-mega" aria-label="Services menu">
          <div>
            <span>By Concern</span>
            {dropdownConcerns.map((item) => (
              <Link key={item.title} to={item.href}>{item.title}</Link>
            ))}
          </div>
          <div>
            <span>By Procedure</span>
            {dropdownProcedures.map((item) => (
              <Link key={item.title} to={item.href}>{item.title}</Link>
            ))}
          </div>
        </div>
      </div>
      <div className="ra-nav-dropdown">
        <button type="button">
          Resources <ChevronDown size={14} />
        </button>
        <div className="ra-mega ra-mega-single" aria-label="Resources menu">
          <div>
            <span>Learning</span>
            <a href={homeAnchor('#courses')}>Courses</a>
            <a href={homeAnchor('#doctor-intro-video')}>Videos</a>
            <a href={homeAnchor('#instagram')}>Instagram</a>
          </div>
        </div>
      </div>
      <Link to="/blog" className={location.pathname.startsWith('/blog') ? 'is-active' : ''}>Blog</Link>
      <Link to="/success-stories" className={location.pathname === '/success-stories' ? 'is-active' : ''}>Success Stories</Link>
    </>
  );

  return (
    <header className={`ra-header site-header-modern ${scrolled ? 'is-scrolled' : ''}`}>
      <div className="ra-header-inner">
        <Link className="ra-logo" to="/" aria-label="Dr. Rajeev Agarwal home">
          <img src="/assets/2025/01/Rajeev-Sir-Logo-2.webp" alt="Dr. Rajeev Agarwal logo" />
        </Link>

        <nav className="ra-nav" aria-label="Primary navigation">{nav}</nav>

        <div className="ra-header-actions">
          <button className="ra-btn ra-btn-primary" type="button" onClick={book}>Book Appointment</button>
          <a className="ra-icon-btn" href="https://wa.me/916292269060" aria-label="WhatsApp Dr. Rajeev Agarwal">
            <MessageCircle size={20} />
          </a>
          <button className="ra-menu-btn" type="button" onClick={() => setOpen((value) => !value)} aria-label="Toggle menu" aria-expanded={open}>
            {open ? <X size={22} /> : <Menu size={22} />}
          </button>
        </div>
      </div>

      {open && (
        <div className="ra-mobile-menu">
          {nav}
          <button className="ra-btn ra-btn-primary" type="button" onClick={book}>Book Appointment</button>
        </div>
      )}
    </header>
  );
}
