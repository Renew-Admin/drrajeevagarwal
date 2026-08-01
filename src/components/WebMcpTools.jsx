import { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';

import { pagesData } from '../data/pages_data';
import { blogsData } from '../data/blogs_data';
import { liveBlogUpdates } from '../data/live_blog_updates';
import { buildBlogPresentation, stripBlogHtml } from '../utils/blogPresentation';

/**
 * WebMCP tool provider.
 *
 * Exposes this site's real capabilities to browser-based AI agents through
 * navigator.modelContext (https://webmachinelearning.github.io/webmcp/).
 * Every tool is backed by content that already ships in the bundle or by an
 * action a visitor can take, so nothing here advertises a capability the site
 * does not actually have.
 *
 * The API is experimental and only present behind a flag in Chrome, so the
 * whole thing is feature-detected and is a no-op everywhere else. Registration
 * happens in an effect, which also keeps it out of the build-time prerender
 * (scripts/prerender.mjs), where `navigator` does not exist.
 */

const SITE_ORIGIN = 'https://drrajeevagarwal.co.in';

// Mirrors the service routes in scripts/gen-seo-assets.mjs. Kept explicit
// rather than derived from pagesData, which still holds WordPress leftovers
// such as "elementor-10995" and "home-page".
const SERVICE_SLUGS = [
  'advanced-fertility-treatments',
  'infertility-help',
  'fertility-support-services',
  'pcos-care',
  'laparoscopic-surgery',
  'hysteroscopic-procedure',
  'fibroids-solutions',
  'menopause-wellness',
  'healthy-aging',
  'womens-health-check',
  'period-pain-relief',
  'sexual-pain-relief',
  'vaginismus-therapy',
  'urinary-incontinence',
  'urinary-laser-therapy',
  'virtual-consults',
  'learn-with-dr-rajeev-agarwal',
];

const CLINIC_INFO = {
  practice: 'Renew Healthcare',
  doctor: 'Dr. Rajeev Agarwal',
  specialty: 'Fertility Specialist & Gynaecologist',
  phone: '+91 83369 68661',
  email: 'fertilitywithoutborders@gmail.com',
  address: 'Renew Healthcare, 18C Mandeville Gardens, Kolkata, West Bengal 700019',
  centres: ['Gariahat — Kolkata', 'Salt Lake — Kolkata', 'Jamshedpur'],
  hours: 'Monday to Friday, 9:00 AM – 7:00 PM',
  bookingUrl: `${SITE_ORIGIN}/book-an-appointment`,
  virtualConsultUrl: `${SITE_ORIGIN}/virtual-consults`,
};

function summarise(html, maxLength = 220) {
  const text = stripBlogHtml(html || '').replace(/\s+/g, ' ').trim();
  if (text.length <= maxLength) return text;
  return `${text.slice(0, maxLength).replace(/\s+\S*$/, '')}…`;
}

function listServices() {
  return SERVICE_SLUGS.map((slug) => {
    const page = pagesData[slug];
    return {
      name: page?.title || slug.replace(/-/g, ' '),
      url: `${SITE_ORIGIN}/${slug}`,
      summary: summarise(page?.content, 180),
    };
  }).filter((service) => service.name);
}

function allArticles() {
  const seen = new Set();
  return [...liveBlogUpdates, ...blogsData]
    .filter((post) => {
      if (!post?.slug || seen.has(post.slug)) return false;
      seen.add(post.slug);
      return true;
    })
    .map((post, index) => buildBlogPresentation(post, index));
}

function asText(payload) {
  return { content: [{ type: 'text', text: JSON.stringify(payload, null, 2) }] };
}

export default function WebMcpTools({ onBookClick }) {
  const navigate = useNavigate();

  useEffect(() => {
    const modelContext = typeof navigator !== 'undefined' ? navigator.modelContext : undefined;
    if (!modelContext || typeof modelContext.provideContext !== 'function') return;

    const tools = [
      {
        name: 'list_services',
        description:
          'List the fertility, gynaecology and women’s health services offered by Dr. Rajeev Agarwal, each with a short summary and the page URL.',
        inputSchema: { type: 'object', properties: {}, additionalProperties: false },
        execute: async () => asText({ services: listServices() }),
      },
      {
        name: 'search_articles',
        description:
          'Search Dr. Rajeev Agarwal’s health blog for articles about fertility, pregnancy, PCOS, menopause, IVF and women’s health. Returns matching article titles, summaries and URLs.',
        inputSchema: {
          type: 'object',
          properties: {
            query: { type: 'string', description: 'Search terms, e.g. "PCOS diet" or "thyroid before pregnancy".' },
            limit: { type: 'integer', minimum: 1, maximum: 20, default: 5 },
          },
          required: ['query'],
          additionalProperties: false,
        },
        execute: async ({ query, limit = 5 }) => {
          const needle = String(query || '').toLowerCase().trim();
          const matches = needle
            ? allArticles().filter((post) => post.searchText.includes(needle))
            : [];
          return asText({
            query,
            resultCount: matches.length,
            results: matches.slice(0, limit).map((post) => ({
              title: post.title,
              url: `${SITE_ORIGIN}/blog/${post.slug}`,
              category: post.category,
              published: post.displayDate,
              readingTimeMinutes: post.readingTime,
              excerpt: post.excerpt,
            })),
          });
        },
      },
      {
        name: 'get_clinic_info',
        description:
          'Get contact and visiting information for Dr. Rajeev Agarwal at Renew Healthcare, Kolkata — phone, email, address, consultation centres, working hours and the booking URL.',
        inputSchema: { type: 'object', properties: {}, additionalProperties: false },
        execute: async () => asText(CLINIC_INFO),
      },
      {
        name: 'open_appointment_form',
        description:
          'Open the appointment booking form on this page so the visitor can request a consultation with Dr. Rajeev Agarwal. Opens a dialog; it does not submit anything or book on the visitor’s behalf.',
        inputSchema: { type: 'object', properties: {}, additionalProperties: false },
        execute: async () => {
          if (typeof onBookClick === 'function') {
            onBookClick();
            return asText({ opened: true, note: 'The booking dialog is open. The visitor still has to fill it in and submit.' });
          }
          navigate('/book-an-appointment');
          return asText({ opened: true, navigatedTo: `${SITE_ORIGIN}/book-an-appointment` });
        },
      },
    ];

    try {
      modelContext.provideContext({ tools });
    } catch {
      // An unsupported or changed shape must never take the page down.
    }
  }, [navigate, onBookClick]);

  return null;
}
