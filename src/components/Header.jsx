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
  { title: 'Preconception Care', href: '/preconception' },
  { title: 'Fertility Treatments', href: '/advanced-fertility-treatments' },
  { title: 'Vaginismus Therapy', href: '/vaginismus-therapy' },
  { title: 'Urinary Laser Therapy', href: '/urinary-laser-therapy' },
  { title: 'Laparoscopic Surgery', href: '/laparoscopic-surgery' },
  { title: 'Hysteroscopic Procedure', href: '/hysteroscopic-procedure' },
];

export default function Header({ onBookClick }) {
  const [open, setOpen] = useState(false);
  const [servicesOpen, setServicesOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const [visible, setVisible] = useState(true);
  const location = useLocation();

  useEffect(() => {
    let lastY = window.scrollY;
    
    const onScroll = () => {
      const currentY = window.scrollY;
      setScrolled(currentY > 20);
      
      if (window.innerWidth <= 1120) {
        if (currentY > lastY && currentY > 82) {
          setVisible(false);
        } else {
          setVisible(true);
        }
      } else {
        setVisible(true);
      }
      
      lastY = currentY;
    };
    
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
    return () => window.removeEventListener('scroll', onScroll);
  }, []);

  useEffect(() => {
    setOpen(false);
    setServicesOpen(false);
  }, [location.pathname]);

  const book = () => {
    setOpen(false);
    setServicesOpen(false);
    onBookClick?.();
  };

  const toggleMenu = () => {
    setServicesOpen(false);
    setOpen((value) => !value);
  };

  const closeMobileMenu = () => {
    setServicesOpen(false);
    setOpen(false);
  };

  const nav = (
    <>
      <Link to="/" className={location.pathname === '/' ? 'is-active' : ''}>Home</Link>
      <Link to="/about-me" className={location.pathname === '/about-me' ? 'is-active' : ''}>About Me</Link>
      <div className="ra-nav-dropdown">
        <Link to="/all-services" className="ra-nav-dropdown-link">
          Services <ChevronDown size={14} />
        </Link>
        <div className="ra-mega" aria-label="Services menu">
          <div>
            <span>Explore Services</span>
            <Link to="/all-services">All Services</Link>
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
      <Link to="/courses" className={location.pathname === '/courses' ? 'is-active' : ''}>Courses</Link>
      <Link to="/blog" className={location.pathname.startsWith('/blog') ? 'is-active' : ''}>Blog</Link>
      <Link to="/success-stories" className={location.pathname === '/success-stories' ? 'is-active' : ''}>Success Stories</Link>
    </>
  );

  const mobileNav = (
    <>
      <Link to="/" className={location.pathname === '/' ? 'is-active' : ''} onClick={closeMobileMenu}>Home</Link>
      <Link to="/about-me" className={location.pathname === '/about-me' ? 'is-active' : ''} onClick={closeMobileMenu}>About Me</Link>
      <div className={`ra-mobile-services ${servicesOpen ? 'is-open' : ''}`}>
        <button type="button" aria-expanded={servicesOpen} onClick={() => setServicesOpen((value) => !value)}>
          Services <ChevronDown size={15} />
        </button>
        {servicesOpen && (
          <>
            <button
              className="ra-mobile-services-backdrop"
              type="button"
              aria-label="Close services menu"
              onClick={() => setServicesOpen(false)}
            />
            <div className="ra-mobile-services-panel" role="dialog" aria-label="Services menu">
              <button
                className="ra-mobile-services-close"
                type="button"
                aria-label="Close services menu"
                onClick={() => setServicesOpen(false)}
              >
                <X size={17} />
              </button>
              <div className="ra-mobile-services-panel-body">
                <div>
                  <span>Explore Services</span>
                  <Link to="/all-services" onClick={closeMobileMenu}>All Services</Link>
                  {dropdownConcerns.map((item) => (
                    <Link key={item.title} to={item.href} onClick={closeMobileMenu}>{item.title}</Link>
                  ))}
                </div>
                <div>
                  <span>By Procedure</span>
                  {dropdownProcedures.map((item) => (
                    <Link key={item.title} to={item.href} onClick={closeMobileMenu}>{item.title}</Link>
                  ))}
                </div>
              </div>
            </div>
          </>
        )}
      </div>
      <Link to="/courses" className={location.pathname === '/courses' ? 'is-active' : ''} onClick={closeMobileMenu}>Courses</Link>
      <Link to="/blog" className={location.pathname.startsWith('/blog') ? 'is-active' : ''} onClick={closeMobileMenu}>Blog</Link>
      <Link to="/success-stories" className={location.pathname === '/success-stories' ? 'is-active' : ''} onClick={closeMobileMenu}>Success Stories</Link>
    </>
  );

  return (
    <header className={`ra-header site-header-modern ${scrolled ? 'is-scrolled' : ''} ${!visible && !open ? 'is-hidden' : ''}`}>
      <div className="ra-header-inner">
        <Link className="ra-logo" to="/" aria-label="Dr. Rajeev Agarwal home">
          <picture>
            <source srcSet="/assets/2025/01/Rajeev-Sir-Logo-2.webp" type="image/webp" />
            <img src="/assets/2025/01/Rajeev-Sir-Logo.png" alt="" />
          </picture>
        </Link>

        <nav className="ra-nav" aria-label="Primary navigation">{nav}</nav>

        <div className="ra-header-actions">
          {location.pathname !== '/book-an-appointment' && (
            <button className="ra-btn ra-btn-primary" type="button" onClick={book}>Book Appointment</button>
          )}
          <a className="ra-icon-btn" href="https://wa.me/916292269060" aria-label="WhatsApp Dr. Rajeev Agarwal">
            <MessageCircle size={20} />
          </a>
          <button className="ra-menu-btn" type="button" onClick={toggleMenu} aria-label="Toggle menu" aria-expanded={open}>
            {open ? <X size={22} /> : <Menu size={22} />}
          </button>
        </div>
      </div>

      {open && (
        <div className="ra-mobile-menu">
          {mobileNav}
          {location.pathname !== '/book-an-appointment' && (
            <button className="ra-btn ra-btn-primary" type="button" onClick={book}>Book Appointment</button>
          )}
        </div>
      )}
    </header>
  );
}
