/**
 * Question bank and scoring rules for the perimenopause symptom quiz
 * (/menopause-care/perimenopause-symptoms-quiz).
 *
 * Every question belongs to a domain so the result can be broken down by body
 * system instead of collapsing to a single number — a woman scoring 55% almost
 * entirely on sleep and mood needs a different conversation from one scoring
 * 55% spread evenly, and the domain bars are what make that visible.
 */

/** Answer scale. Index doubles as the score for that answer (0–3). */
export const QUIZ_CHOICES = [
  { label: 'Not at all', hint: 'Never, or not since this started' },
  { label: 'A little', hint: 'Occasionally, easy to ignore' },
  { label: 'Moderately', hint: 'Regularly, and I notice it' },
  { label: 'A lot', hint: 'Frequently, and it gets in the way' },
];

export const MAX_ANSWER_SCORE = QUIZ_CHOICES.length - 1;

/**
 * Domains, in the order they are shown on the result screen when scores tie.
 * `advice` is the one-line next step surfaced when a domain lands in the
 * quiz-taker's top priorities.
 */
export const QUIZ_DOMAINS = {
  cycle: {
    label: 'Cycle changes',
    advice: 'Track your last three cycle lengths before the consultation — the pattern matters more than any single month.',
  },
  vasomotor: {
    label: 'Hot flashes & night sweats',
    advice: 'Vasomotor symptoms are the most studied indication for hormone therapy, and among the most treatable.',
  },
  sleep: {
    label: 'Sleep',
    advice: 'Note whether you wake from heat or wake for no reason — they point to different fixes.',
  },
  mood: {
    label: 'Mood & anxiety',
    advice: 'Hormonal mood change is real and treatable; it is worth raising even if it feels like "just stress".',
  },
  cognition: {
    label: 'Focus & memory',
    advice: 'Brain fog in this decade is usually hormonal rather than an early dementia sign — worth saying out loud.',
  },
  energy: {
    label: 'Energy & stamina',
    advice: 'Ferritin, thyroid and B12 explain a large share of midlife fatigue — ask for them to be checked.',
  },
  metabolic: {
    label: 'Weight & metabolism',
    advice: 'Ask about insulin resistance (HOMA-IR or HbA1c) rather than weight alone.',
  },
  physical: {
    label: 'Muscle, joints, skin & hair',
    advice: 'Resistance training plus adequate protein does more here than any supplement.',
  },
  genitourinary: {
    label: 'Vaginal, urinary & sexual health',
    advice: 'Local vaginal estrogen treats this specifically, and is a different decision from systemic HRT.',
  },
  systemic: {
    label: 'Palpitations & headaches',
    advice: 'Worth a cardiac and migraine history at the consultation before attributing these to hormones.',
  },
  impact: {
    label: 'Impact on daily life',
    advice: 'How much this costs you day to day is a legitimate clinical input, not a complaint.',
  },
  timing: {
    label: 'Onset & fluctuation',
    advice: 'Symptoms that fluctuate rather than stay constant are characteristic of the transition.',
  },
};

/**
 * `cycle` questions are skipped for anyone post-hysterectomy or no longer
 * menstruating, and the denominator shrinks with them so the percentage stays
 * comparable.
 */
export const QUIZ_QUESTIONS = [
  {
    id: 'cycle-predictability',
    section: 'Cycles',
    domain: 'cycle',
    text: 'Have your periods become less predictable?',
    help: 'Skipped months, or a cycle you can no longer plan around.',
  },
  {
    id: 'cycle-interval',
    section: 'Cycles',
    domain: 'cycle',
    text: 'Have your periods become closer together or further apart?',
    help: 'Either direction counts — shortening cycles are often the earliest sign.',
  },
  {
    id: 'vasomotor',
    section: 'Temperature',
    domain: 'vasomotor',
    text: 'Have you had hot flashes or night sweats?',
    help: 'Sudden heat in the face, neck or chest, or waking up damp.',
  },
  {
    id: 'sleep',
    section: 'Sleep',
    domain: 'sleep',
    text: 'Have you had new or worsening difficulty sleeping?',
    help: 'Trouble falling asleep, or waking at 3am and staying awake.',
  },
  {
    id: 'mood',
    section: 'Mood',
    domain: 'mood',
    text: 'Have you noticed new anxiety, irritability or low mood?',
    help: 'Including a shorter fuse than usual, or tearfulness that surprises you.',
  },
  {
    id: 'cognition',
    section: 'Cognition',
    domain: 'cognition',
    text: 'Have you noticed brain fog or forgetfulness?',
    help: 'Losing words mid-sentence, or re-reading the same paragraph.',
  },
  {
    id: 'energy',
    section: 'Energy',
    domain: 'energy',
    text: 'Have you had unusual fatigue or reduced stamina?',
    help: 'Tired in a way that sleep does not fix.',
  },
  {
    id: 'metabolic',
    section: 'Metabolism',
    domain: 'metabolic',
    text: 'Have you gained weight, especially around your middle?',
    help: 'Weight that settled centrally even without a change in eating.',
  },
  {
    id: 'strength',
    section: 'Muscles',
    domain: 'physical',
    text: 'Have you noticed reduced strength or slower recovery?',
    help: 'Workouts or daily lifting feel harder than they did.',
  },
  {
    id: 'joints',
    section: 'Joints',
    domain: 'physical',
    text: 'Have you developed new aches or joint stiffness?',
    help: 'Especially morning stiffness in hands, shoulders or knees.',
  },
  {
    id: 'skin-hair',
    section: 'Skin & hair',
    domain: 'physical',
    text: 'Have you noticed skin or hair changes?',
    help: 'Thinning hair, dryness, itching, or skin that lost its bounce.',
  },
  {
    id: 'libido',
    section: 'Sexual health',
    domain: 'genitourinary',
    text: 'Have you noticed lower libido?',
    help: 'Reduced desire, arousal or satisfaction.',
  },
  {
    id: 'gsm',
    section: 'Vaginal & urinary',
    domain: 'genitourinary',
    text: 'Have you had vaginal dryness or urinary changes?',
    help: 'Dryness, discomfort with sex, urgency, leaking or repeat infections.',
  },
  {
    id: 'palpitations',
    section: 'Heart',
    domain: 'systemic',
    text: 'Have you noticed new palpitations?',
    help: 'A racing or thumping heartbeat, often at night or with a flush.',
  },
  {
    id: 'headache',
    section: 'Head',
    domain: 'systemic',
    text: 'Have you had new headaches or migraines?',
    help: 'Or existing migraines that changed pattern or intensity.',
  },
  {
    id: 'impact',
    section: 'Daily life',
    domain: 'impact',
    text: 'Are these symptoms affecting work, relationships or confidence?',
    help: 'Be honest here — it is one of the strongest signals for treatment.',
  },
  {
    id: 'onset',
    section: 'Timing',
    domain: 'timing',
    text: 'Did several of these symptoms begin within the last few years?',
    help: 'Clustered onset matters more than any one symptom alone.',
  },
  {
    id: 'fluctuation',
    section: 'Pattern',
    domain: 'timing',
    text: 'Do your symptoms fluctuate rather than stay the same every day?',
    help: 'Good weeks and bad weeks are typical of fluctuating estrogen.',
  },
];

/** Result bands, checked in order — first match wins. */
export const QUIZ_TIERS = [
  {
    id: 'strong',
    min: 60,
    label: 'Strong symptom pattern',
    tone: 'high',
    summary:
      'Your answers line up closely with what perimenopause typically looks like. This is worth a proper clinical review rather than another year of waiting it out.',
  },
  {
    id: 'possible',
    min: 30,
    label: 'Possible symptom pattern',
    tone: 'mid',
    summary:
      'Your answers show a pattern worth discussing with a clinician, alongside your cycle history, thyroid function and general health.',
  },
  {
    id: 'limited',
    min: 0,
    label: 'Limited symptom pattern',
    tone: 'low',
    summary:
      'Your answers show fewer of the features commonly associated with perimenopause. If symptoms persist or worsen, a clinical review can still help find the cause.',
  },
];

export function getTierForScore(percent) {
  return QUIZ_TIERS.find((tier) => percent >= tier.min) || QUIZ_TIERS[QUIZ_TIERS.length - 1];
}

/**
 * Score a completed question set.
 *
 * @param {Array<{question: object, value: number}>} responses
 * @returns {{percent:number, total:number, max:number, tier:object, domains:Array}}
 */
export function scoreQuiz(responses) {
  const answered = responses.filter((r) => Number.isInteger(r.value));
  const total = answered.reduce((sum, r) => sum + r.value, 0);
  const max = answered.length * MAX_ANSWER_SCORE;
  const percent = max > 0 ? Math.round((total / max) * 100) : 0;

  const byDomain = new Map();
  for (const { question, value } of answered) {
    const entry = byDomain.get(question.domain) || { key: question.domain, total: 0, max: 0, count: 0 };
    entry.total += value;
    entry.max += MAX_ANSWER_SCORE;
    entry.count += 1;
    byDomain.set(question.domain, entry);
  }

  const domains = [...byDomain.values()]
    .map((entry) => ({
      ...entry,
      label: QUIZ_DOMAINS[entry.key]?.label || entry.key,
      advice: QUIZ_DOMAINS[entry.key]?.advice || '',
      percent: entry.max > 0 ? Math.round((entry.total / entry.max) * 100) : 0,
    }))
    .sort((a, b) => b.percent - a.percent || a.label.localeCompare(b.label));

  return { percent, total, max, tier: getTierForScore(percent), domains };
}
