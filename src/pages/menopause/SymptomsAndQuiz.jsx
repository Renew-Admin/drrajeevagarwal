import { Link } from 'react-router-dom';
import { ArrowDown } from 'lucide-react';

import MenopauseLayout from '../../components/menopause/MenopauseLayout';
import MenopauseFaq from '../../components/menopause/MenopauseFaq';
import PerimenopauseQuiz from '../../components/menopause/PerimenopauseQuiz';

const sideNav = [
  { id: 'timeline', label: 'The life-stage timeline' },
  { id: 'onset', label: 'When it begins' },
  { id: 'symptoms', label: 'Top symptoms' },
  { id: 'why-now', label: 'Why act now' },
  { id: 'quiz', label: 'Take the quiz' },
  { id: 'faq', label: 'FAQ' },
];

const stages = ['Puberty', 'Reproductive years', 'Perimenopause', 'Menopause', 'Postmenopause'];

const onsetStats = [
  ['45', 'average age of onset'],
  ['35–38', 'can start as early as'],
  ['4–7 yrs', 'average duration'],
  ['10 yrs', 'possible duration for some women'],
];

const symptoms = [
  ['Irregular periods', 'Often the first sign — cycles shorten, lengthen, or become unpredictable.'],
  ['Hot flashes and night sweats', 'Vasomotor symptoms driven by fluctuating estrogen.'],
  ['Brain fog and forgetfulness', 'Genuinely hormonal, not "just getting older".'],
  ['Weight gain, especially central', 'Estrogen decline shifts fat storage toward the midsection.'],
  ['Mood swings and anxiety', 'Fluctuating hormones affect neurotransmitter regulation.'],
  ['Vaginal dryness', 'Part of the genitourinary syndrome of menopause.'],
  ['Sleep trouble', 'Independent of night sweats — hormonal shifts disrupt sleep architecture directly.'],
  ['Hair thinning and skin changes', 'Collagen and hair follicle sensitivity are estrogen-dependent.'],
  ['Palpitations, urine leak, low libido', 'Often dismissed individually — worth naming together.'],
];

export default function SymptomsAndQuiz({ onBookClick }) {
  return (
    <MenopauseLayout
      pageKey="symptoms"
      onBookClick={onBookClick}
      sideNav={sideNav}
      lede={
        <p>
          Perimenopause is not just irregular periods. It is a hormonal recalibration that touches your brain,
          bones, mood, metabolism, sleep and skin — often starting years before you would expect. Read the
          pattern below, or go straight to the quiz.
        </p>
      }
      heroActions={
        <a className="mc-btn mc-btn-primary" href="#quiz">Skip to the 5-minute quiz <ArrowDown size={16} /></a>
      }
    >
      <h2 id="timeline">Where perimenopause sits in the timeline</h2>
      <p>
        Perimenopause is a transitional phase, not an event. Menopause itself is a single point in time — the
        moment you have gone 12 consecutive months without a period. Everything before that, sometimes for a
        decade, is perimenopause.
      </p>
      <ol className="mc-timeline">
        {stages.map((stage) => (
          <li key={stage} className={stage === 'Perimenopause' ? 'is-active' : ''}>
            <span>{stage}</span>
          </li>
        ))}
      </ol>

      <h2 id="onset">When does it actually begin?</h2>
      <div className="mc-stats">
        {onsetStats.map(([value, label]) => (
          <div className="mc-stat" key={label}>
            <strong>{value}</strong>
            <span>{label}</span>
          </div>
        ))}
      </div>
      <p>
        Perimenopause can begin eight to ten years before your final period — often without any obvious
        warning. Most women are caught off guard: anxiety, weight gain, insomnia, low libido or hair thinning
        get quietly filed under "stress" or "getting older", when fluctuating estrogen and declining
        progesterone are often the real cause.
      </p>

      <h2 id="symptoms">The top symptoms</h2>
      <p className="mc-muted">
        Tracking which of these apply to you — and how often — is the fastest way to get a useful conversation
        started with a doctor. The quiz below does exactly that, in about five minutes.
      </p>
      <div className="mc-cards mc-cards-3">
        {symptoms.map(([title, body]) => (
          <article className="mc-card is-tight" key={title}>
            <h3>{title}</h3>
            <p>{body}</p>
          </article>
        ))}
      </div>

      <h2 id="why-now">Why your 40s are the decade to act</h2>
      <ul className="mc-list">
        <li>Bone loss can begin two to three years <em>before</em> menopause, not after.</li>
        <li>Muscle mass starts declining in your 30s.</li>
        <li>Cardiovascular risk rises after menopause as estrogen's protective effect fades.</li>
        <li>Insulin resistance and central weight gain can creep in silently.</li>
      </ul>
      <div className="mc-callout">
        <strong>The reframe that matters</strong>
        <p>
          This is not the beginning of decline — it is your body's clearest signal to build the foundation for
          your 50s and 60s. Early awareness changes outcomes. What that looks like day to day is on the{' '}
          <Link to="/menopause-care/diet-exercise-and-lifestyle">diet, exercise and lifestyle page</Link>.
        </p>
      </div>

      <div className="mc-divider"><span>The quiz</span></div>

      <h2 id="quiz">Does this look like perimenopause?</h2>
      <p className="mc-muted">
        Eighteen questions, about five minutes. It correlates your symptom pattern against what perimenopause
        typically looks like, and breaks the score down by body system — it does not diagnose you.
      </p>
      <PerimenopauseQuiz onBookClick={onBookClick} />

      <MenopauseFaq pageKey="symptoms" />
    </MenopauseLayout>
  );
}
