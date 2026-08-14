/**
 * Single source of truth for the Menopause Care hub (/menopause-care/*).
 *
 * Everything that has to agree across the site is derived from this file:
 *   - the routes registered in src/App.jsx
 *   - the in-section navigation, hub cards and cross-links
 *   - <title>/description for the client (src/utils/seoMeta.js), the build-time
 *     injector (scripts/inject-seo-tags.mjs) and — via the generated
 *     src/data/menopauseSeo.cjs — the Worker and prerenderer (seoMeta.cjs)
 *   - the sitemap entries written by scripts/gen-seo-assets.mjs
 *   - the FAQPage / MedicalWebPage JSON-LD built in src/utils/jsonLd.cjs
 *
 * Adding a sub-page here is therefore enough for it to be routed, linked,
 * indexed, prerendered and described in structured data. The one thing it does
 * NOT do is create the component — add that to MENOPAUSE_PAGE_COMPONENTS in
 * src/App.jsx.
 */

export const MENOPAUSE_BASE = '/menopause-care';

/** Shown in the breadcrumb and as the parent label of every sub-page. */
export const MENOPAUSE_SECTION_LABEL = 'Menopause Care';

export const MENOPAUSE_PAGES = [
  {
    path: '/menopause-care',
    key: 'hub',
    // Short label for the section nav; `navLabel` is the longer form used in
    // the site header, footer and hub cards where there is no section context.
    label: 'Overview',
    navLabel: 'Perimenopause & Menopause Care',
    breadcrumb: 'Menopause Care',
    eyebrow: 'Perimenopause & Menopause',
    heading: 'Your hormones are changing. Here is exactly what that means.',
    summary:
      'Start here: how the transition works, what it does to the rest of your body, and where to go next.',
    title: 'Perimenopause & Menopause Care in Kolkata | Dr. Rajeev Agarwal',
    description:
      'Evidence-based perimenopause and menopause care in Kolkata with Dr. Rajeev Agarwal — symptom guidance, a free symptom quiz, HRT/MHT explained, tests, diet and a multidisciplinary care team.',
    faqs: [
      {
        q: 'What is the difference between perimenopause and menopause?',
        a: 'Menopause is a single point in time — the day you complete 12 consecutive months without a period. Perimenopause is the transition leading up to it, which can last four to ten years, and it is when most of the disruptive symptoms actually happen.',
      },
      {
        q: 'When should I see a doctor about perimenopause?',
        a: 'As soon as symptoms start affecting your sleep, mood, work or relationships — you do not need to wait until your periods stop. Early assessment also matters because bone loss can begin two to three years before your final period.',
      },
      {
        q: 'Where does Dr. Rajeev Agarwal see patients for menopause care?',
        a: 'At Renew Healthcare, 18C Mandeville Gardens, Kolkata 700019, with centres in Gariahat, Salt Lake and Jamshedpur. Virtual consultations are also available.',
      },
    ],
  },
  {
    path: '/menopause-care/perimenopause-symptoms-quiz',
    key: 'symptoms',
    label: 'Symptoms & Quiz',
    navLabel: 'Perimenopause Symptoms & Quiz',
    breadcrumb: 'Perimenopause Symptoms & Quiz',
    eyebrow: 'Symptoms & Symptom Quiz',
    heading: 'The whole-body transition nobody explained to you',
    summary:
      'The 18 symptoms that actually signal perimenopause — plus a five-minute quiz that maps your own pattern.',
    title: 'Perimenopause Symptoms Quiz — 18 Signs Checked in 5 Minutes | Dr. Rajeev Agarwal',
    description:
      'Free perimenopause symptom quiz by Dr. Rajeev Agarwal, Kolkata. Check 18 symptoms — irregular periods, hot flashes, sleep, mood, brain fog and weight — and get a scored pattern you can take to your consultation.',
    faqs: [
      {
        q: 'Is perimenopause the same as menopause?',
        a: 'No. Menopause is a single point in time — 12 months after your last period. Perimenopause is everything leading up to it, sometimes for a decade, and it is when most of the disruptive symptoms actually occur.',
      },
      {
        q: 'Can perimenopause really start at 35?',
        a: 'Yes, though it is less common than a 40s onset. Early perimenopause deserves the same attention as a textbook case — earlier onset can carry different implications for bone and cardiovascular health, which is why timely evaluation matters.',
      },
      {
        q: 'Is perimenopause the same experience for everyone?',
        a: 'No. Some women barely notice the transition; others find it genuinely disruptive to work and relationships. Both are normal — the range of experience is part of why symptom tracking, not assumption, is the right starting point.',
      },
      {
        q: 'Do I need blood tests to confirm perimenopause?',
        a: 'Perimenopause is usually diagnosed clinically, from your symptom pattern and cycle history, rather than from a single hormone test — levels fluctuate too much day to day to be definitive on their own. Tests are still used to rule out thyroid disease, anaemia and other conditions that mimic it.',
      },
      {
        q: 'Does this quiz diagnose perimenopause?',
        a: 'No. It is a correlation tool that scores how closely your symptom pattern resembles perimenopause, so you and your doctor start the consultation from the same place. Only a clinical assessment can diagnose you.',
      },
    ],
  },
  {
    path: '/menopause-care/hrt-hormone-therapy',
    key: 'hrt',
    label: 'HRT / MHT',
    navLabel: 'HRT / MHT Guide',
    breadcrumb: 'HRT / MHT Guide',
    eyebrow: 'HRT / MHT',
    heading: 'Hormone therapy, explained without the fear',
    summary:
      'What HRT actually is, what the 2002 WHI trial really showed, how it is taken, and the risks in real numbers.',
    title: 'HRT / MHT Explained — Safety, Routes & Risks | Dr. Rajeev Agarwal, Kolkata',
    description:
      'A plain-language guide to hormone replacement therapy (HRT/MHT) from Dr. Rajeev Agarwal, Kolkata — what the WHI trial really showed, who it suits, oral vs transdermal routes, how long to continue, and non-hormonal alternatives.',
    faqs: [
      {
        q: 'Will HRT make me gain weight?',
        a: 'HRT itself is not a major driver of weight gain. The weight shift many women notice in this decade is more closely tied to declining estrogen changing fat distribution and muscle mass — something HRT can actually help offset for some women.',
      },
      {
        q: 'Can I take HRT if I get migraines?',
        a: 'Often yes, especially with transdermal routes, but migraine with aura needs individual review. This is exactly the kind of history-specific question to bring to a consultation rather than answer generically.',
      },
      {
        q: 'Is bioidentical HRT safer than synthetic HRT?',
        a: '"Bioidentical" simply describes hormones structurally identical to the ones your body makes — many regulated prescription HRT products already are bioidentical. The real safety distinctions are the route (oral versus transdermal) and which progestogen is used, not the bioidentical label itself.',
      },
      {
        q: 'What if I have a family history of breast cancer?',
        a: 'Family history matters and should be discussed directly, but it does not automatically rule HRT out. The picture depends on which relatives, at what age, and whether genetic testing is relevant — a consultation conversation, not a page-level answer.',
      },
      {
        q: 'How long can I stay on HRT?',
        a: 'As a starting point, until at least the average age of natural menopause (around 50–51), then reassess. For bone or heart protection, or in premature or early menopause, longer use can be appropriate. It is reviewed periodically rather than decided once.',
      },
    ],
  },
  {
    path: '/menopause-care/tests-and-diagnostics',
    key: 'tests',
    label: 'Tests & Diagnostics',
    navLabel: 'Menopause Tests & Diagnostics',
    breadcrumb: 'Tests & Diagnostics',
    eyebrow: 'Tests & Diagnostics',
    heading: 'Why we order the tests we order',
    summary:
      'Blood work, thyroid, metabolic, cardiac, bone and screening tests — what each one is actually looking for.',
    title: 'Menopause Blood Tests & Health Screening in Kolkata | Dr. Rajeev Agarwal',
    description:
      'Which tests matter in perimenopause and menopause — thyroid, FSH and estradiol, HbA1c and insulin resistance, lipids, DEXA bone scan, vitamin D, Pap smear and mammography — and what each one rules in or out.',
    faqs: [
      {
        q: 'Can a blood test confirm menopause?',
        a: 'Not on its own during perimenopause. FSH and estradiol fluctuate day to day, so a single reading can look normal in a woman with clear symptoms. Blood tests are most useful for staging the transition and for ruling out thyroid disease, anaemia and diabetes, which mimic menopausal symptoms closely.',
      },
      {
        q: 'Which tests should I do before starting HRT?',
        a: 'Typically a baseline that covers thyroid function, blood counts and ferritin, liver and kidney function, fasting glucose or HbA1c, a lipid profile, and up-to-date breast and cervical screening. The exact list depends on your history — the clinic confirms it for you.',
      },
      {
        q: 'When should I get a DEXA bone scan?',
        a: 'A DEXA scan is considered around the menopause transition and earlier if you have risk factors such as premature menopause, steroid use, a low body weight, a fracture history or a family history of osteoporosis. Up to 20% of bone mass can be lost in the first five years after menopause, usually silently.',
      },
    ],
  },
  {
    path: '/menopause-care/diet-exercise-and-lifestyle',
    key: 'lifestyle',
    label: 'Diet, Exercise & Lifestyle',
    navLabel: 'Menopause Diet & Exercise',
    breadcrumb: 'Diet, Exercise & Lifestyle',
    eyebrow: 'Diet, Exercise & Lifestyle',
    heading: 'The foundation no prescription replaces',
    summary:
      'Blood-sugar-stable eating, protein targets, resistance and impact training, plus a BMI and waist check.',
    title: 'Menopause Diet, Exercise & Supplements Guide | Dr. Rajeev Agarwal, Kolkata',
    description:
      'What to eat and how to train through perimenopause and menopause — blood sugar stability, 25–30g protein per meal, resistance and impact training for bone, supplements worth discussing, and a BMI and waist calculator.',
    faqs: [
      {
        q: 'How much protein do I need during menopause?',
        a: 'Around 25–30g of good-quality protein per meal is the working target, because muscle becomes harder to build and easier to lose as estrogen falls. Spreading it across meals works better than one large serving.',
      },
      {
        q: 'Is it too late to start exercising in my 40s or 50s?',
        a: 'No. Women who start resistance training in their 40s or 50s see gains equal to or greater than those who started younger. Ten to fifteen minutes a day, low-impact first, with form before load, is a legitimate starting point.',
      },
      {
        q: 'Which supplements actually help in menopause?',
        a: 'Vitamin D, magnesium glycinate, omega-3, B12, creatine, collagen and fibre are the ones most often worth discussing — alongside diet and exercise, never instead of them. What you need depends on your blood results, so review them with your doctor rather than self-prescribing.',
      },
    ],
  },
  {
    path: '/menopause-care/care-team',
    key: 'team',
    label: 'Care Team',
    navLabel: 'Menopause Care Team',
    breadcrumb: 'Care Team',
    eyebrow: 'The Care Team',
    heading: 'Not a single prescription pad',
    summary:
      'Gynaecology, metabolic medicine, mental health, exercise, nutrition and genetics — one coordinated plan.',
    title: 'Menopause Care Team in Kolkata — Multidisciplinary Support | Dr. Rajeev Agarwal',
    description:
      'Meet the multidisciplinary menopause care team led by Dr. Rajeev Agarwal, MBBS MD (Obs & Gynae), Kolkata — metabolic medicine, mental health counselling, exercise medicine, clinical nutrition and genetics under one plan.',
    faqs: [
      {
        q: 'Who leads menopause care at the clinic?',
        a: 'Dr. Rajeev Agarwal, MBBS, MD (Obstetrics and Gynaecology), with over 25 years of clinical practice in gynaecology, obstetrics and fertility medicine in Kolkata.',
      },
      {
        q: 'Why does menopause care need more than a gynaecologist?',
        a: 'The transition affects metabolism, bone, muscle, mood and sleep at the same time. Hormone therapy addresses part of it; insulin resistance, nutrition, strength training and mental health need their own expertise, coordinated around one plan rather than handed off separately.',
      },
    ],
  },
  {
    path: '/menopause-care/articles-and-videos',
    key: 'library',
    label: 'Articles & Videos',
    navLabel: 'Menopause Articles & Videos',
    breadcrumb: 'Articles & Videos',
    eyebrow: 'Library',
    heading: 'Watch it explained, then read the detail',
    summary:
      "Dr. Agarwal's video library on perimenopause and HRT, alongside the written articles from the blog.",
    title: 'Menopause & Perimenopause Videos and Articles | Dr. Rajeev Agarwal',
    description:
      "Dr. Rajeev Agarwal's video library and written articles on perimenopause, menopause and HRT — signs and symptoms, hormone therapy myths, and evidence-based answers to the questions patients ask most.",
    faqs: [
      {
        q: 'Where can I watch Dr. Rajeev Agarwal explain perimenopause?',
        a: 'The video library on this page collects his talks on the signs and symptoms of perimenopause and on hormone replacement therapy. The full channel is on YouTube at @DrRajeevAgarwal.',
      },
    ],
  },
];

/** Lookup by route path, e.g. MENOPAUSE_PAGE_BY_PATH['/menopause-care/care-team']. */
export const MENOPAUSE_PAGE_BY_PATH = Object.fromEntries(
  MENOPAUSE_PAGES.map((page) => [page.path, page]),
);

/** Lookup by short key, e.g. MENOPAUSE_PAGE_BY_KEY.hrt.path. */
export const MENOPAUSE_PAGE_BY_KEY = Object.fromEntries(
  MENOPAUSE_PAGES.map((page) => [page.key, page]),
);

/** The sub-pages, i.e. everything except the hub itself. */
export const MENOPAUSE_SUBPAGES = MENOPAUSE_PAGES.filter((page) => page.path !== MENOPAUSE_BASE);

/** Route paths, in nav order — consumed by the sitemap generator. */
export const MENOPAUSE_ROUTES = MENOPAUSE_PAGES.map((page) => page.path);

/** { '/menopause-care/...': { title, description } } for the ROUTE_META tables. */
export const MENOPAUSE_ROUTE_META = Object.fromEntries(
  MENOPAUSE_PAGES.map(({ path, title, description }) => [path, { title, description }]),
);

/** The three YouTube talks embedded across the section. */
export const MENOPAUSE_VIDEOS = [
  {
    id: 'k-FTqI7ajms',
    title: 'Signs and symptoms of perimenopause',
    blurb: 'What to actually look out for, in plain language.',
  },
  {
    id: 'fHpiDpnxtbE',
    title: 'Are you still scared of hormone replacement therapy?',
    blurb: 'Addressing the fear head-on — and where it came from.',
  },
  {
    id: 'l_3Qv8OUNqQ',
    title: 'HRT, perimenopause and menopause',
    blurb: 'How hormone therapy fits into the transition.',
  },
];
