import { useCallback, useEffect, useMemo, useRef, useState, useSyncExternalStore } from 'react';
import { Link } from 'react-router-dom';
import {
  ArrowLeft,
  ArrowRight,
  CalendarCheck,
  Check,
  ClipboardList,
  Loader2,
  Printer,
  RotateCcw,
  Send,
  ShieldCheck,
  Sparkles,
} from 'lucide-react';

import {
  QUIZ_CHOICES,
  QUIZ_QUESTIONS,
  MAX_ANSWER_SCORE,
  scoreQuiz,
} from '../../data/menopauseQuiz';
import { submitLead } from '../../lib/supabaseBlogAdmin';

const STORAGE_KEY = 'ra-perimenopause-quiz-result';
const LEAD_FORM_NAME = 'Perimenopause Symptom Quiz';

/**
 * Previous attempt, read straight from localStorage.
 *
 * useSyncExternalStore rather than an effect because the value only exists in
 * the browser: the server snapshot is null, so the prerendered HTML and the
 * first client render agree, and no hydration mismatch is possible. The parsed
 * object is cached against its raw string so the snapshot stays referentially
 * stable between renders.
 */
let cachedRaw;
let cachedResult = null;

function readSavedResult() {
  try {
    const raw = window.localStorage.getItem(STORAGE_KEY);
    if (raw !== cachedRaw) {
      cachedRaw = raw;
      cachedResult = raw ? JSON.parse(raw) : null;
    }
    return cachedResult;
  } catch {
    return null; // private mode, or a corrupt entry — the quiz works without it
  }
}

function subscribeToSavedResult(onChange) {
  window.addEventListener('storage', onChange);
  return () => window.removeEventListener('storage', onChange);
}

/** Domains that need at least this score to be called out as a priority. */
const PRIORITY_THRESHOLD = 50;
const MAX_PRIORITIES = 3;

function buildSummaryText(result, questions, answers) {
  const lines = [
    `Perimenopause symptom quiz — overall pattern match: ${result.percent}% (${result.tier.label})`,
    '',
    'By area:',
    ...result.domains.map((d) => `  ${d.label}: ${d.percent}%`),
    '',
    'Answers:',
    ...questions.map((q, i) => {
      const value = answers[i];
      const choice = Number.isInteger(value) ? QUIZ_CHOICES[value].label : 'Not answered';
      return `  ${q.text} — ${choice}`;
    }),
  ];
  return lines.join('\n');
}

function ScoreGauge({ percent, tone }) {
  const radius = 54;
  const circumference = 2 * Math.PI * radius;
  const [drawn, setDrawn] = useState(0);

  useEffect(() => {
    // Draw from zero on mount so the arc animates to the score rather than
    // snapping to it. rAF keeps the initial 0 in the first painted frame.
    const frame = requestAnimationFrame(() => setDrawn(percent));
    return () => cancelAnimationFrame(frame);
  }, [percent]);

  return (
    <div className={`mcq-gauge is-${tone}`}>
      <svg viewBox="0 0 140 140" role="img" aria-label={`${percent}% overall pattern match`}>
        <circle className="mcq-gauge-track" cx="70" cy="70" r={radius} />
        <circle
          className="mcq-gauge-value"
          cx="70"
          cy="70"
          r={radius}
          strokeDasharray={circumference}
          strokeDashoffset={circumference - (circumference * drawn) / 100}
        />
      </svg>
      <div className="mcq-gauge-inner">
        <strong>{percent}%</strong>
        <span>pattern match</span>
      </div>
    </div>
  );
}

export default function PerimenopauseQuiz({ onBookClick }) {
  const [stage, setStage] = useState('intro');
  const [skipCycle, setSkipCycle] = useState(false);
  const [index, setIndex] = useState(0);
  const [answers, setAnswers] = useState([]);

  const [contact, setContact] = useState({ name: '', phone: '', email: '' });
  const [sending, setSending] = useState(false);
  const [sendError, setSendError] = useState('');
  const [sent, setSent] = useState(false);

  const cardRef = useRef(null);
  const savedResult = useSyncExternalStore(subscribeToSavedResult, readSavedResult, () => null);

  const questions = useMemo(
    () => (skipCycle ? QUIZ_QUESTIONS.filter((q) => q.domain !== 'cycle') : QUIZ_QUESTIONS),
    [skipCycle],
  );

  const result = useMemo(() => {
    if (stage !== 'result') return null;
    return scoreQuiz(questions.map((question, i) => ({ question, value: answers[i] })));
  }, [stage, questions, answers]);

  const priorities = useMemo(() => {
    if (!result) return [];
    return result.domains.filter((d) => d.percent >= PRIORITY_THRESHOLD).slice(0, MAX_PRIORITIES);
  }, [result]);

  useEffect(() => {
    if (!result) return;
    try {
      window.localStorage.setItem(
        STORAGE_KEY,
        JSON.stringify({ percent: result.percent, tier: result.tier.label, savedAt: new Date().toISOString() }),
      );
    } catch {
      /* non-fatal */
    }
  }, [result]);

  const answered = Number.isInteger(answers[index]);
  const progress = stage === 'result' ? 100 : Math.round((index / questions.length) * 100);

  const start = () => {
    setAnswers([]);
    setIndex(0);
    setSent(false);
    setSendError('');
    setStage('quiz');
  };

  const goNext = useCallback(() => {
    if (!Number.isInteger(answers[index])) return;
    if (index < questions.length - 1) {
      setIndex((i) => i + 1);
    } else {
      setStage('result');
    }
  }, [answers, index, questions.length]);

  const goBack = useCallback(() => {
    setIndex((i) => Math.max(0, i - 1));
  }, []);

  const select = useCallback(
    (value) => {
      setAnswers((prev) => {
        const next = [...prev];
        next[index] = value;
        return next;
      });
    },
    [index],
  );

  // 1–4 picks an answer, Enter advances, ← / Backspace goes back. Typing in the
  // contact fields on the result screen must not be intercepted, so this only
  // binds during the question stage.
  useEffect(() => {
    if (stage !== 'quiz') return undefined;

    const onKeyDown = (event) => {
      if (event.metaKey || event.ctrlKey || event.altKey) return;
      const tag = event.target?.tagName;
      if (tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT') return;

      const numeric = Number(event.key);
      if (numeric >= 1 && numeric <= QUIZ_CHOICES.length) {
        event.preventDefault();
        select(numeric - 1);
        return;
      }
      if (event.key === 'Enter' || event.key === 'ArrowRight') {
        event.preventDefault();
        goNext();
      }
      if (event.key === 'ArrowLeft' || event.key === 'Backspace') {
        event.preventDefault();
        goBack();
      }
    };

    window.addEventListener('keydown', onKeyDown);
    return () => window.removeEventListener('keydown', onKeyDown);
  }, [stage, select, goNext, goBack]);

  // Keep the card in view when the question changes on a small screen, without
  // yanking the page on the very first render.
  useEffect(() => {
    if (stage !== 'quiz' || index === 0) return;
    cardRef.current?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }, [stage, index]);

  const retake = () => {
    setAnswers([]);
    setIndex(0);
    setSent(false);
    setSendError('');
    setStage('intro');
  };

  const sendToClinic = async (event) => {
    event.preventDefault();
    if (!result) return;

    setSending(true);
    setSendError('');

    try {
      await submitLead(LEAD_FORM_NAME, {
        name: contact.name,
        contact_number: contact.phone,
        whatsapp_number: contact.phone,
        email: contact.email,
        purpose_of_visit: 'New Gynae',
        quiz_score_percent: result.percent,
        quiz_tier: result.tier.label,
        quiz_domains: result.domains.map((d) => `${d.label}: ${d.percent}%`).join(', '),
        quiz_summary: buildSummaryText(result, questions, answers),
      });
      setSent(true);
    } catch (error) {
      setSendError(error.message || 'Could not send your results. Please try again, or call the clinic.');
    } finally {
      setSending(false);
    }
  };

  const question = questions[index];

  return (
    <div className="mcq">
      {stage !== 'intro' && (
        <div className="mcq-progress" aria-hidden={stage === 'result'}>
          <div className="mcq-progress-meta">
            <span>
              {stage === 'result'
                ? 'Complete'
                : `Question ${index + 1} of ${questions.length} · ${question.section}`}
            </span>
            <span className="mcq-progress-pct">{progress}%</span>
          </div>
          <div className="mcq-progress-track">
            <div className="mcq-progress-fill" style={{ width: `${progress}%` }} />
          </div>
        </div>
      )}

      {stage === 'intro' && (
        <div className="mcq-card mcq-intro">
          <span className="mcq-eyebrow"><ClipboardList size={15} /> 18 questions · about 5 minutes</span>
          <h3>Before you start</h3>
          <p>
            Rate each symptom by how much it has affected you over the <strong>past one to two months</strong>,
            not just today. Your answers are scored against the pattern perimenopause typically produces and
            broken down by body system.
          </p>

          <ul className="mcq-intro-points">
            <li><ShieldCheck size={17} /> Nothing is sent anywhere unless you choose to send it at the end.</li>
            <li><Sparkles size={17} /> You get a per-area breakdown, not just one number.</li>
            <li><CalendarCheck size={17} /> Take the result into your consultation as a starting point.</li>
          </ul>

          <label className="mcq-check">
            <input
              type="checkbox"
              checked={skipCycle}
              onChange={(event) => setSkipCycle(event.target.checked)}
            />
            <span>I no longer have periods, or I have had a hysterectomy — skip the menstrual cycle questions</span>
          </label>

          {savedResult && (
            <p className="mcq-saved-note">
              You last scored <strong>{savedResult.percent}%</strong> ({savedResult.tier}). Starting again replaces that result.
            </p>
          )}

          <button type="button" className="mc-btn mc-btn-primary mcq-start" onClick={start}>
            Start the quiz <ArrowRight size={17} />
          </button>

          <p className="mcq-fineprint">
            This is a correlation tool, not a diagnosis, and it does not replace clinical assessment.
          </p>
        </div>
      )}

      {stage === 'quiz' && (
        <div className="mcq-card mcq-question" ref={cardRef}>
          <span className="mcq-eyebrow">{question.section}</span>
          <h3 id="mcq-question-text">{question.text}</h3>
          <p className="mcq-help">{question.help}</p>

          <div className="mcq-options" role="radiogroup" aria-labelledby="mcq-question-text">
            {QUIZ_CHOICES.map((choice, value) => {
              const isSelected = answers[index] === value;
              return (
                <button
                  key={choice.label}
                  type="button"
                  role="radio"
                  aria-checked={isSelected}
                  className={`mcq-option${isSelected ? ' is-selected' : ''}`}
                  onClick={() => select(value)}
                >
                  <span className="mcq-option-key" aria-hidden="true">{value + 1}</span>
                  <span className="mcq-option-body">
                    <strong>{choice.label}</strong>
                    <em>{choice.hint}</em>
                  </span>
                  <span className="mcq-option-scale" aria-hidden="true">
                    {Array.from({ length: MAX_ANSWER_SCORE }, (_, dot) => (
                      <i key={dot} className={dot < value ? 'is-on' : ''} />
                    ))}
                  </span>
                  {isSelected && <Check className="mcq-option-tick" size={18} aria-hidden="true" />}
                </button>
              );
            })}
          </div>

          <div className="mcq-nav">
            <button type="button" className="mc-btn-quiet" onClick={goBack} disabled={index === 0}>
              <ArrowLeft size={16} /> Back
            </button>
            <span className="mcq-keyhint" aria-hidden="true">Press 1–4 to answer, Enter to continue</span>
            <button type="button" className="mc-btn mc-btn-primary" onClick={goNext} disabled={!answered}>
              {index === questions.length - 1 ? 'See my result' : 'Next'} <ArrowRight size={16} />
            </button>
          </div>
        </div>
      )}

      {stage === 'result' && result && (
        <div className="mcq-result">
          <div className={`mcq-card mcq-result-head is-${result.tier.tone}`}>
            <ScoreGauge percent={result.percent} tone={result.tier.tone} />
            <div>
              <span className="mcq-eyebrow">Your result</span>
              <h3>{result.tier.label}</h3>
              <p>{result.tier.summary}</p>
            </div>
          </div>

          <div className="mcq-card">
            <h4>Where your symptoms concentrate</h4>
            <p className="mcq-help">
              Scored per area, so you can see what to raise first rather than describing everything at once.
            </p>
            <div className="mcq-bars">
              {result.domains.map((domain) => (
                <div className="mcq-bar" key={domain.key}>
                  <div className="mcq-bar-label">
                    <span>{domain.label}</span>
                    <span className="mcq-bar-pct">{domain.percent}%</span>
                  </div>
                  <div className="mcq-bar-track">
                    <div
                      className={`mcq-bar-fill${domain.percent >= PRIORITY_THRESHOLD ? ' is-high' : ''}`}
                      style={{ width: `${domain.percent}%` }}
                    />
                  </div>
                </div>
              ))}
            </div>
          </div>

          {priorities.length > 0 && (
            <div className="mcq-card">
              <h4>Worth raising first</h4>
              <ol className="mcq-priorities">
                {priorities.map((domain) => (
                  <li key={domain.key}>
                    <strong>{domain.label}</strong>
                    <span>{domain.advice}</span>
                  </li>
                ))}
              </ol>
            </div>
          )}

          <div className="mc-callout mc-callout-sage">
            <strong>A reminder before you act on this</strong>
            <p>
              This is a pattern-correlation tool, not a diagnosis. Symptoms like these can also come from
              thyroid disease, anaemia, diabetes or other causes — a consultation, and usually a few blood
              tests, is how you actually find out. See{' '}
              <Link to="/menopause-care/tests-and-diagnostics">tests and diagnostics</Link>.
            </p>
          </div>

          <div className="mcq-card mcq-actions-card">
            <h4>What next</h4>
            <div className="mcq-actions">
              {onBookClick ? (
                <button type="button" className="mc-btn mc-btn-primary" onClick={onBookClick}>
                  <CalendarCheck size={17} /> Discuss this with Dr. Agarwal
                </button>
              ) : (
                <Link className="mc-btn mc-btn-primary" to="/book-an-appointment">
                  <CalendarCheck size={17} /> Discuss this with Dr. Agarwal
                </Link>
              )}
              <button type="button" className="mc-btn mc-btn-outline" onClick={() => window.print()}>
                <Printer size={17} /> Print or save as PDF
              </button>
              <button type="button" className="mc-btn-quiet" onClick={retake}>
                <RotateCcw size={15} /> Retake the quiz
              </button>
            </div>
          </div>

          <div className="mcq-card mcq-send">
            <h4>Send this result to the clinic</h4>
            {sent ? (
              <p className="mcq-sent">
                <Check size={18} /> Sent. The team has your result and will get in touch to arrange a consultation.
              </p>
            ) : (
              <>
                <p className="mcq-help">
                  Optional. Your score, the per-area breakdown and your answers go to the clinic so the
                  consultation starts with the detail already in hand.
                </p>
                <form onSubmit={sendToClinic} className="mcq-form">
                  <div className="mcq-field">
                    <label htmlFor="mcq-name">Name</label>
                    <input
                      id="mcq-name"
                      type="text"
                      required
                      value={contact.name}
                      onChange={(event) => setContact((c) => ({ ...c, name: event.target.value }))}
                      placeholder="Your name"
                    />
                  </div>
                  <div className="mcq-field">
                    <label htmlFor="mcq-phone">Phone / WhatsApp</label>
                    <input
                      id="mcq-phone"
                      type="tel"
                      required
                      value={contact.phone}
                      onChange={(event) => setContact((c) => ({ ...c, phone: event.target.value }))}
                      placeholder="e.g. +91 98300 12345"
                    />
                  </div>
                  <div className="mcq-field">
                    <label htmlFor="mcq-email">Email (optional)</label>
                    <input
                      id="mcq-email"
                      type="email"
                      value={contact.email}
                      onChange={(event) => setContact((c) => ({ ...c, email: event.target.value }))}
                      placeholder="you@example.com"
                    />
                  </div>
                  {sendError && <p className="mcq-error">{sendError}</p>}
                  <button type="submit" className="mc-btn mc-btn-primary" disabled={sending}>
                    {sending ? <Loader2 size={17} className="mcq-spin" /> : <Send size={17} />}
                    {sending ? 'Sending…' : 'Send my result'}
                  </button>
                </form>
              </>
            )}
          </div>
        </div>
      )}
    </div>
  );
}
