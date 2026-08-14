import { useState } from 'react';
import { Link } from 'react-router-dom';

import MenopauseLayout from '../../components/menopause/MenopauseLayout';
import MenopauseFaq from '../../components/menopause/MenopauseFaq';

const sideNav = [
  { id: 'diet', label: 'Diet foundations' },
  { id: 'exercise', label: 'Exercise' },
  { id: 'supplements', label: 'Supplements' },
  { id: 'bmi', label: 'BMI and waist check' },
  { id: 'faq', label: 'FAQ' },
];

const dietPillars = [
  [
    'Blood sugar stability',
    'Protein, fibre and healthy fats at every meal; fewer refined carbohydrates; eat every three to four hours on unstable days.',
  ],
  [
    'Anti-inflammatory eating',
    'Olive oil, nuts, seeds, whole grains and omega-3 twice a week — this can reduce hot flashes and joint pain.',
  ],
  [
    'Protein for muscle',
    '25–30g of good-quality protein per meal protects against the muscle loss that accelerates after 40.',
  ],
];

const exercise = [
  ['Resistance training', 'Builds muscle and counters sarcopenia — the single highest-yield change for most women in this decade.'],
  ['Weight-bearing and impact work', 'Increases bone density; even 10–20 vertical jumps a day has produced measurable hip BMD gains in trials.'],
  ['Aerobic activity', 'Improves insulin sensitivity and cardiovascular fitness as estrogen protection fades.'],
  ['Daily movement', 'Regular, unstructured movement improves mood and sleep independently of formal training.'],
];

const supplements = [
  'Omega-3', 'Collagen', 'Magnesium glycinate', 'Creatine', 'Fibre', 'Vitamin D', 'Vitamin B12',
];

/** Waist threshold (cm) above which metabolic risk rises for women. */
const WAIST_THRESHOLD = 88;

function BmiCalculator() {
  const [values, setValues] = useState({ height: '', weight: '', waist: '' });
  const [result, setResult] = useState(null);

  const update = (field) => (event) => setValues((prev) => ({ ...prev, [field]: event.target.value }));

  const calculate = (event) => {
    event.preventDefault();
    const heightM = parseFloat(values.height) / 100;
    const weightKg = parseFloat(values.weight);
    const waistCm = parseFloat(values.waist);

    if (!heightM || !weightKg) {
      setResult({ error: 'Enter your height and weight to calculate.' });
      return;
    }

    const bmi = weightKg / (heightM * heightM);
    let band = 'Normal range';
    if (bmi < 18.5) band = 'Underweight';
    else if (bmi >= 25 && bmi < 30) band = 'Overweight range';
    else if (bmi >= 30) band = 'Obese range';

    setResult({
      bmi: bmi.toFixed(1),
      band,
      waist: Number.isFinite(waistCm)
        ? waistCm > WAIST_THRESHOLD
          ? `Waist ${waistCm}cm — above the ${WAIST_THRESHOLD}cm threshold associated with higher metabolic risk.`
          : `Waist ${waistCm}cm — within the typical range.`
        : null,
    });
  };

  return (
    <form className="mc-bmi" onSubmit={calculate}>
      <div className="mc-bmi-fields">
        <div className="mcq-field">
          <label htmlFor="bmi-height">Height (cm)</label>
          <input id="bmi-height" type="number" inputMode="decimal" value={values.height} onChange={update('height')} placeholder="160" />
        </div>
        <div className="mcq-field">
          <label htmlFor="bmi-weight">Weight (kg)</label>
          <input id="bmi-weight" type="number" inputMode="decimal" value={values.weight} onChange={update('weight')} placeholder="65" />
        </div>
        <div className="mcq-field">
          <label htmlFor="bmi-waist">Waist (cm) — optional</label>
          <input id="bmi-waist" type="number" inputMode="decimal" value={values.waist} onChange={update('waist')} placeholder="80" />
        </div>
      </div>
      <button type="submit" className="mc-btn mc-btn-primary">Calculate</button>

      {result && (
        <div className="mc-bmi-result" role="status">
          {result.error ? (
            <p>{result.error}</p>
          ) : (
            <>
              <p><strong>BMI {result.bmi}</strong> · {result.band}</p>
              {result.waist && <p className="mc-small">{result.waist}</p>}
              <p className="mc-small mc-muted">
                BMI is a screening number, not a diagnosis — it does not distinguish muscle from fat, and it
                reads differently in South Asian populations, where metabolic risk rises at a lower BMI.
              </p>
            </>
          )}
        </div>
      )}
    </form>
  );
}

export default function DietExerciseLifestyle({ onBookClick }) {
  return (
    <MenopauseLayout
      pageKey="lifestyle"
      onBookClick={onBookClick}
      sideNav={sideNav}
      lede={
        <p>
          Health through this transition is roughly 70% diet, 20% activity and 10% supplements — and none of
          the three replaces the others. This is what that looks like in practice, whether or not you take
          hormone therapy.
        </p>
      }
    >
      <h2 id="diet">Diet foundations</h2>
      <div className="mc-cards mc-cards-3">
        {dietPillars.map(([title, body]) => (
          <article className="mc-card" key={title}>
            <h3>{title}</h3>
            <p>{body}</p>
          </article>
        ))}
      </div>

      <h2 id="exercise">Exercise: what earns its place</h2>
      <div className="mc-cards mc-cards-2">
        {exercise.map(([title, body]) => (
          <article className="mc-card is-tight" key={title}>
            <h3>{title}</h3>
            <p>{body}</p>
          </article>
        ))}
      </div>
      <div className="mc-callout mc-callout-sage">
        <strong>New to exercise?</strong>
        <p>
          Perimenopause is still a good time to start — 10 to 15 minutes a day, low-impact first, form before
          load. Women who start in their 40s or 50s see gains equal to or greater than those who started
          younger.
        </p>
      </div>

      <h2 id="supplements">Supplements worth discussing</h2>
      <p className="mc-muted">
        Useful alongside diet and exercise, never instead of them — and worth matching to your blood results
        rather than buying on reputation. See{' '}
        <Link to="/menopause-care/tests-and-diagnostics">tests and diagnostics</Link> for what to check first.
      </p>
      <div className="mc-chips">
        {supplements.map((item) => <span className="mc-chip" key={item}>{item}</span>)}
      </div>
      <p className="mc-small mc-muted">
        This is not advice from a single prescription pad — nutrition, exercise medicine and metabolic health
        each have their own specialist on the{' '}
        <Link to="/menopause-care/care-team">care team</Link>.
      </p>

      <h2 id="bmi">Quick check: BMI and waist circumference</h2>
      <div className="mc-tool">
        <span className="mc-tag is-rose">Quick check</span>
        <p className="mc-muted">
          Waist circumference tracks central fat, which is what shifts most through the transition — it is
          often the more useful of the two numbers.
        </p>
        <BmiCalculator />
      </div>

      <MenopauseFaq pageKey="lifestyle" />
    </MenopauseLayout>
  );
}
