// ContactTracking — one delegated listener for contact-intent links (tel:,
// WhatsApp, mailto:), appointment CTAs and form validation failures. Mounted
// once in AppRoutes. Never calls preventDefault; sends only the event name, a
// CTA placement and the page category — never numbers, addresses or values.
import { useEffect } from 'react';
import { track } from '../lib/analytics';

function ctaLocation(el) {
  const explicit = el.closest('[data-cta-location]');
  if (explicit) return explicit.getAttribute('data-cta-location');
  if (el.closest('.ra-floating-lead')) return 'floating';
  if (el.closest('.ra-mobile-menu')) return 'mobile_menu';
  if (el.closest('header, .ra-header')) return 'header';
  if (el.closest('footer, .ra-footer-wrap')) return 'footer';
  return 'body';
}

function classifyContactTarget(el) {
  const link = el.closest('a[href]');
  if (link) {
    const href = (link.getAttribute('href') || '').trim().toLowerCase();
    if (href.startsWith('tel:')) return { name: 'phone_click', el: link };
    if (href.startsWith('mailto:')) return { name: 'email_click', el: link };
    if (/^https?:\/\/(wa\.me|api\.whatsapp\.com|chat\.whatsapp\.com|web\.whatsapp\.com)\//.test(href) || href.startsWith('whatsapp:')) {
      return { name: 'whatsapp_click', el: link };
    }
    if (href === '/book-an-appointment' || href.endsWith('/book-an-appointment') || link.matches('[data-cta="appointment"]')) {
      return { name: 'appointment_cta_click', el: link, ctaType: 'appointment_link' };
    }
  }
  const button = el.closest('button');
  if (button && button.matches('[data-cta="appointment"]')) {
    return { name: 'appointment_cta_click', el: button, ctaType: 'appointment_popup' };
  }
  return null;
}

let installed = false;

export default function ContactTracking() {
  useEffect(() => {
    if (installed) return undefined;
    installed = true;
    const onClick = (event) => {
      try {
        if (!(event.target instanceof Element)) return;
        const hit = classifyContactTarget(event.target);
        if (!hit) return;
        const params = { cta_location: ctaLocation(hit.el) };
        if (hit.ctaType) params.cta_type = hit.ctaType;
        track(hit.name, params);
      } catch {
        /* never break a click */
      }
    };
    // One form_error per failed attempt, carrying the first field's NAME only.
    const reported = new WeakSet();
    const onInvalid = (event) => {
      try {
        const field = event.target;
        const form = field && field.form;
        if (!form || !form.hasAttribute('data-form-type') || reported.has(form)) return;
        reported.add(form);
        window.setTimeout(() => reported.delete(form), 0);
        track('form_error', {
          form_type: form.getAttribute('data-form-type'),
          error_field: field.name || field.type || 'field',
          error_type: 'validation',
        });
      } catch {
        /* never break validation */
      }
    };
    document.addEventListener('click', onClick, true);
    document.addEventListener('invalid', onInvalid, true);
    return () => {
      document.removeEventListener('click', onClick, true);
      document.removeEventListener('invalid', onInvalid, true);
      installed = false;
    };
  }, []);
  return null;
}
