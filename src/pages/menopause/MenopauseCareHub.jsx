import { Link } from 'react-router-dom';
import { ArrowRight, ClipboardList, HeartPulse, Stethoscope } from 'lucide-react';

import MenopauseLayout from '../../components/menopause/MenopauseLayout';
import MenopauseFaq from '../../components/menopause/MenopauseFaq';
import VideoCard from '../../components/menopause/VideoCard';
import { MENOPAUSE_SUBPAGES, MENOPAUSE_VIDEOS } from '../../data/menopauseCare';

const stats = [
  ['80%', 'of women experience perimenopausal symptoms'],
  ['30%', 'receive appropriate support or treatment'],
  ['35–38', 'age at which symptoms can realistically begin'],
  ['4–10', 'years the transition typically lasts'],
];

const startHere = [
  {
    tag: 'Start here',
    tone: 'rose',
    icon: ClipboardList,
    title: 'Do my symptoms match?',
    body:
      'Irregular periods, brain fog, hot flashes, weight change, mood shifts — an 18-question tool that scores your pattern against what perimenopause typically looks like.',
    to: '/menopause-care/perimenopause-symptoms-quiz',
    cta: 'Take the symptom quiz',
  },
  {
    tag: 'Most asked',
    tone: 'amber',
    icon: HeartPulse,
    title: 'What about HRT?',
    body:
      'What changed after the WHI scare, whether it is safe, how it is actually taken, and how long it should continue — in plain language, without the fear-mongering.',
    to: '/menopause-care/hrt-hormone-therapy',
    cta: 'Read the HRT guide',
  },
  {
    tag: 'Talk to someone',
    tone: 'sage',
    icon: Stethoscope,
    title: 'Ready to be seen?',
    body:
      'A consultation with Dr. Agarwal and, where useful, the wider care team — metabolic health, mental health, exercise and nutrition, coordinated around one plan.',
    to: '/menopause-care/care-team',
    cta: 'Meet the care team',
  },
];

const disciplines = [
  'Gynaecology · clinical lead',
  'Obesity and metabolic medicine',
  'Mental health counselling',
  'Exercise medicine',
  'Clinical nutrition',
  'Genetics',
];

/** Illustrative estrogen trend across the transition — fluctuating, not a clean drop. */
function EstrogenCurve() {
  return (
    <figure className="mc-curve">
      <svg viewBox="0 0 480 200" width="100%" role="img" aria-label="Illustrative estrogen trend through the menopause transition: fluctuating peaks and dips before a gradual decline">
        <line x1="0" y1="150" x2="480" y2="150" stroke="currentColor" strokeDasharray="4 4" opacity="0.25" />
        <path
          className="mc-curve-path"
          d="M10,50 C40,35 60,65 90,55 C120,45 140,75 170,60 C200,45 210,90 240,85 C270,80 280,120 310,110 C340,100 350,140 380,145 C410,150 430,155 470,158"
          fill="none"
          strokeWidth="3"
          strokeLinecap="round"
        />
        <circle className="mc-curve-dot" cx="240" cy="85" r="4" />
      </svg>
      <div className="mc-curve-stages">
        <span>Reproductive</span><span>Perimenopause</span><span>Menopause</span><span>Postmenopause</span>
      </div>
      <figcaption>
        Illustrative estrogen trend across the transition — fluctuating, not a clean drop. This is why
        symptoms come and go unpredictably.
      </figcaption>
    </figure>
  );
}

export default function MenopauseCareHub({ onBookClick }) {
  return (
    <MenopauseLayout
      pageKey="hub"
      onBookClick={onBookClick}
      heroAside={<EstrogenCurve />}
      lede={
        <p>
          Perimenopause can begin eight to ten years before your final period — and is often mistaken for
          stress, ageing or "just a bad year". Dr. Rajeev Agarwal's menopause practice in Kolkata is built
          around one idea: you deserve a precise answer, not a shrug.
        </p>
      }
      heroActions={
        <>
          <Link className="mc-btn mc-btn-primary" to="/menopause-care/perimenopause-symptoms-quiz">
            Not sure if this is perimenopause? Take the quiz <ArrowRight size={16} />
          </Link>
          {onBookClick ? (
            <button type="button" className="mc-btn mc-btn-outline" onClick={onBookClick}>Book a consultation</button>
          ) : (
            <Link className="mc-btn mc-btn-outline" to="/book-an-appointment">Book a consultation</Link>
          )}
        </>
      }
    >
      <div className="mc-cards mc-cards-3">
        {startHere.map((card) => {
          const Icon = card.icon;
          return (
            <article className="mc-card" key={card.title}>
              <span className={`mc-tag is-${card.tone}`}><Icon size={14} /> {card.tag}</span>
              <h3>{card.title}</h3>
              <p>{card.body}</p>
              <Link className="mc-card-link" to={card.to}>{card.cta} <ArrowRight size={15} /></Link>
            </article>
          );
        })}
      </div>

      <div className="mc-divider"><span>Why here</span></div>

      <h2 id="why-here">The gap this section exists to close</h2>
      <div className="mc-stats">
        {stats.map(([value, label]) => (
          <div className="mc-stat" key={label}>
            <strong>{value}</strong>
            <span>{label}</span>
          </div>
        ))}
      </div>
      <p>
        Dr. Rajeev Agarwal, MBBS, MD (Obstetrics and Gynaecology), has practised gynaecology in Kolkata for
        over two decades. Menopause care here is built around a multidisciplinary team rather than a single
        prescription pad:
      </p>
      <div className="mc-chips">
        {disciplines.map((item) => <span className="mc-chip" key={item}>{item}</span>)}
      </div>
      <p className="mc-small">
        <Link to="/menopause-care/care-team">Meet the full care team →</Link>
      </p>

      <div className="mc-divider"><span>Latest from the clinic</span></div>

      <h2 id="videos">Watch it explained</h2>
      <div className="mc-video-grid">
        {MENOPAUSE_VIDEOS.map((video) => <VideoCard key={video.id} video={video} />)}
      </div>
      <p className="mc-small">
        <Link to="/menopause-care/articles-and-videos">See all videos and articles →</Link>
      </p>

      <div className="mc-divider"><span>Explore the section</span></div>

      <h2 id="explore">Start where you are</h2>
      <div className="mc-cards mc-cards-3">
        {MENOPAUSE_SUBPAGES.map((page) => (
          <article className="mc-card" key={page.path}>
            <h3><Link to={page.path}>{page.navLabel}</Link></h3>
            <p>{page.summary}</p>
          </article>
        ))}
        <article className="mc-card">
          <h3><Link to="/menopause-wellness">Menopause Wellness service</Link></h3>
          <p>How menopause care is delivered at the clinic, alongside the rest of Dr. Agarwal's services.</p>
        </article>
      </div>

      <MenopauseFaq pageKey="hub" />
    </MenopauseLayout>
  );
}
