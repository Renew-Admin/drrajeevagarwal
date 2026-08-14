import { useState } from 'react';
import { Link } from 'react-router-dom';
import { Check, ExternalLink, Loader2 } from 'lucide-react';

import MenopauseLayout from '../../components/menopause/MenopauseLayout';
import MenopauseFaq from '../../components/menopause/MenopauseFaq';
import { submitLead } from '../../lib/supabaseBlogAdmin';

const sideNav = [
  { id: 'panels', label: 'What we order and why' },
  { id: 'book-tests', label: 'Book your investigations' },
  { id: 'tools', label: 'Risk calculators' },
  { id: 'faq', label: 'FAQ' },
];

const panels = [
  {
    id: 'general',
    title: 'General and blood health',
    rows: [
      ['Haemoglobin and ferritin', 'Low ferritin causes fatigue and leg cramps even when haemoglobin is normal.'],
      ['Liver and kidney function', 'Silent strain can make medicines, supplements or HRT unsafe.'],
      ['Urine routine and culture', 'Picks up early diabetes or a hidden urinary infection.'],
    ],
  },
  {
    id: 'hormones',
    title: 'Hormones and thyroid',
    rows: [
      ['TSH, T3, T4', 'Thyroid disease mimics menopause closely — fatigue, mood swings, weight gain.'],
      ['FSH, LH, estradiol, testosterone', 'Clarifies the menopausal stage; low testosterone can explain low libido and poor muscle tone.'],
    ],
  },
  {
    id: 'metabolic',
    title: 'Sugar and metabolic health',
    rows: [
      ['Fasting glucose, HbA1c', 'Menopause accelerates diabetes risk.'],
      ['HOMA-IR, 2-hour glucose (75g load)', 'Detects insulin resistance years before diabetes develops.'],
    ],
  },
  {
    id: 'heart',
    title: 'Heart and inflammation',
    rows: [
      ['Lipid profile and apolipoprotein A', "Estrogen's natural heart protection fades after menopause."],
      ['hs-CRP, homocysteine', 'Low-grade inflammation, and stroke and dementia risk markers.'],
    ],
  },
  {
    id: 'bone',
    title: 'Bone and vitamins',
    rows: [
      ['DEXA scan', 'Up to 20% of bone mass can be lost in the first five years after menopause — usually silently.'],
      ['Vitamin D, magnesium, B12', 'Support bone, sleep, mood and energy.'],
    ],
  },
  {
    id: 'screening',
    title: 'Reproductive and cancer screening',
    rows: [
      ['Pap smear', 'Still essential after menopause.'],
      ['Transvaginal ultrasound', 'Picks up polyps, fibroids or endometrial thickening.'],
      ['Mammography (age 40+)', 'Detects cancers years before a lump can be felt.'],
    ],
  },
];

function InvestigationForm() {
  const [form, setForm] = useState({ name: '', phone: '', tests: '' });
  const [status, setStatus] = useState('idle');
  const [error, setError] = useState('');

  const update = (field) => (event) => setForm((prev) => ({ ...prev, [field]: event.target.value }));

  const handleSubmit = async (event) => {
    event.preventDefault();
    setStatus('sending');
    setError('');

    try {
      await submitLead('Menopause Investigation Booking', {
        name: form.name,
        contact_number: form.phone,
        whatsapp_number: form.phone,
        purpose_of_visit: 'New Gynae',
        requested_investigations: form.tests,
      });
      setStatus('sent');
    } catch (submitError) {
      setStatus('idle');
      setError(submitError.message || 'Could not send your request. Please try again, or call the clinic.');
    }
  };

  if (status === 'sent') {
    return (
      <p className="mcq-sent">
        <Check size={18} /> Request received. A team member will contact you to schedule your investigations.
      </p>
    );
  }

  return (
    <form className="mcq-form" onSubmit={handleSubmit}>
      <div className="mcq-field">
        <label htmlFor="inv-name">Name</label>
        <input id="inv-name" type="text" required value={form.name} onChange={update('name')} placeholder="Your name" />
      </div>
      <div className="mcq-field">
        <label htmlFor="inv-phone">Phone / WhatsApp</label>
        <input id="inv-phone" type="tel" required value={form.phone} onChange={update('phone')} placeholder="e.g. +91 98300 12345" />
      </div>
      <div className="mcq-field">
        <label htmlFor="inv-tests">Which investigations?</label>
        <textarea
          id="inv-tests"
          rows={3}
          value={form.tests}
          onChange={update('tests')}
          placeholder="e.g. hormone panel and DEXA scan — or 'not sure, need guidance'"
        />
      </div>
      {error && <p className="mcq-error">{error}</p>}
      <button type="submit" className="mc-btn mc-btn-primary" disabled={status === 'sending'}>
        {status === 'sending' ? <Loader2 size={17} className="mcq-spin" /> : null}
        {status === 'sending' ? 'Sending…' : 'Book my slot'}
      </button>
    </form>
  );
}

export default function TestsAndDiagnostics({ onBookClick }) {
  return (
    <MenopauseLayout
      pageKey="tests"
      onBookClick={onBookClick}
      sideNav={sideNav}
      lede={
        <p>
          Not every test applies to every woman. This is a reference for what is typically considered through
          the menopause transition and what each one is actually looking for — so you know why a panel was
          ordered, and what a result would change.
        </p>
      }
    >
      <h2 id="panels">What we order, and what it connects to</h2>
      {panels.map((panel) => (
        <section key={panel.id}>
          <h3 id={panel.id}>{panel.title}</h3>
          <div className="mc-table-wrap">
            <table className="mc-table">
              <thead>
                <tr><th scope="col">Test</th><th scope="col">What it connects to</th></tr>
              </thead>
              <tbody>
                {panel.rows.map(([test, why]) => (
                  <tr key={test}><td>{test}</td><td>{why}</td></tr>
                ))}
              </tbody>
            </table>
          </div>
        </section>
      ))}

      <div className="mc-callout">
        <strong>A reference, not a self-order checklist</strong>
        <p>
          Which of these apply to you depends on your symptoms and history. If you are unsure, send your
          details below and the clinic will confirm the list — or bring your{' '}
          <Link to="/menopause-care/perimenopause-symptoms-quiz">symptom quiz result</Link> to a consultation
          and work through it there.
        </p>
      </div>

      <h2 id="book-tests">Book your slot for investigations</h2>
      <div className="mc-tool">
        <p className="mc-muted">
          Already know which tests you need? Send your details and a team member will contact you to schedule.
        </p>
        <InvestigationForm />
      </div>

      <div className="mc-divider"><span>Tools</span></div>

      <h2 id="tools">Risk calculators used in consultations</h2>

      <div className="mc-tool">
        <span className="mc-tag is-amber">Cardiovascular risk</span>
        <h3>ASCVD and QRISK3</h3>
        <ul className="mc-list">
          <li>
            <a href="https://tools.acc.org/ascvd-risk-estimator-plus" target="_blank" rel="noreferrer">
              ASCVD Risk Estimator Plus <ExternalLink size={13} />
            </a>{' '}
            — widely used, but validated mainly on white and Black American cohorts.
          </li>
          <li>
            <a href="https://qrisk.org/three/" target="_blank" rel="noreferrer">
              QRISK3 <ExternalLink size={13} />
            </a>{' '}
            — includes a built-in South Asian ancestry adjustment (roughly 1.3–1.7×) that ASCVD does not.
          </li>
        </ul>
        <div className="mc-callout mc-callout-amber">
          <strong>Why this matters here</strong>
          <p>
            Standard calculators tend to underestimate cardiovascular risk in South Asian women. Treat an ASCVD
            result as a floor, not a ceiling.
          </p>
        </div>
      </div>

      <div className="mc-tool">
        <span className="mc-tag is-sage">Contraception</span>
        <h3>US MEC 2024</h3>
        <p className="mc-muted">
          Perimenopause is not contraception. The US Medical Eligibility Criteria are what clinicians use to
          match a method to your medical history.
        </p>
        <a
          className="mc-btn mc-btn-outline"
          href="https://www.cdc.gov/contraception/hcp/usmec/index.html"
          target="_blank"
          rel="noreferrer"
        >
          Open US MEC 2024 <ExternalLink size={15} />
        </a>
      </div>

      <p className="mc-small mc-muted">
        Weight, waist and metabolic screening are covered on the{' '}
        <Link to="/menopause-care/diet-exercise-and-lifestyle">diet, exercise and lifestyle page</Link>, which
        includes a BMI and waist-circumference check.
      </p>

      <MenopauseFaq pageKey="tests" />
    </MenopauseLayout>
  );
}
