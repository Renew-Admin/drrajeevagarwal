import { Plus } from 'lucide-react';

import { MENOPAUSE_PAGE_BY_KEY } from '../../data/menopauseCare';

/**
 * FAQ accordion driven by the same entries that produce the page's FAQPage
 * JSON-LD (src/utils/jsonLd.cjs), so the rich result can never advertise a
 * question the page does not answer.
 *
 * Built on <details> rather than JS state: the answers are in the DOM for
 * crawlers and for the prerendered HTML, and they still work with JS disabled.
 */
export default function MenopauseFaq({ pageKey, id = 'faq', heading = 'Frequently asked' }) {
  const faqs = MENOPAUSE_PAGE_BY_KEY[pageKey]?.faqs || [];
  if (faqs.length === 0) return null;

  return (
    <section className="mc-faq">
      <h2 id={id}>{heading}</h2>
      <div className="mc-faq-list">
        {faqs.map((faq) => (
          <details key={faq.q} className="mc-faq-item">
            <summary>
              <span>{faq.q}</span>
              <Plus size={18} aria-hidden="true" />
            </summary>
            <div className="mc-faq-answer"><p>{faq.a}</p></div>
          </details>
        ))}
      </div>
    </section>
  );
}
