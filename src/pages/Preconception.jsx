import { useEffect, useState, useMemo, useRef } from 'react';
import { Link } from 'react-router-dom';
import {
  Baby,
  BookOpen,
  CalendarCheck,
  CheckCircle,
  HeartPulse,
  ShieldCheck,
  Sparkles,
  Stethoscope,
  ChevronDown,
  Play,
  Cigarette,
  ClipboardList,
  Clock,
  Dna,
  Dumbbell,
  FlaskConical,
  Mail,
  MapPin,
  Microscope,
  Moon,
  Phone,
  Pill,
  Route,
  Scale,
  Star,
  UserCheck,
  Users,
  Video,
  Wine,
} from 'lucide-react';

import { blogsData as initialBlogs } from '../data/blogs_data';
import { liveBlogUpdates } from '../data/live_blog_updates';
import { buildBlogPresentation, getBlogImage, getBlogCategory } from '../utils/blogPresentation';
import { listPublishedBlogs } from '../lib/supabaseBlogAdmin';

const ASSET_PATH = '/assets/preconception-workshop/';
const PRECONCEPTION_VIDEO_URL = '/assets/2026/02/sir-video-new-com.mp4';

const planningHighlights = [
  {
    title: 'Health Snapshot',
    text: 'Review cycles, medical history, thyroid, sugar, weight, and current medicines before trying.',
    icon: Stethoscope,
  },
  {
    title: 'Fertility Timing',
    text: 'Understand ovulation windows, age-related timelines, and when a medical review is useful.',
    icon: CalendarCheck,
  },
  {
    title: 'Nutrition Basics',
    text: 'Clarify folic acid, Vitamin D, iron, sleep, stress, and partner health habits.',
    icon: HeartPulse,
  },
  {
    title: 'Next-Step Notes',
    text: 'Leave with a practical checklist to discuss during your preconception consultation.',
    icon: CheckCircle,
  },
];

const pillars = [
  {
    title: 'Know Your Baseline',
    text: 'Understand cycles, age, hormones, thyroid, weight, and fertility markers before you begin trying.',
    icon: ShieldCheck,
  },
  {
    title: 'Plan Tests Wisely',
    text: 'Learn which investigations matter now and which ones can wait, so you avoid confusion and over-testing.',
    icon: BookOpen,
  },
  {
    title: 'Prepare Together',
    text: 'Include male fertility, stress, sleep, nutrition, and shared decisions in one practical plan.',
    icon: HeartPulse,
  },
  {
    title: 'Act At The Right Time',
    text: 'Know when to relax, when to seek help, and how to get IVF-ready if treatment becomes necessary.',
    icon: CalendarCheck,
  },
];

const suitableFor = [
  'Couples planning pregnancy within 6-24 months',
  'First-time parents who want evidence-based guidance',
  'Couples trying naturally but unsure what to check',
  'People with PCOS, thyroid, diabetes, irregular periods, or previous pregnancy loss',
];

const agenda = [
  {
    title: 'Fertility Baseline',
    text: 'Understand where you are starting from before you begin trying.',
    icon: ShieldCheck,
    points: ['Cycles and ovulation window', 'Age, AMH, thyroid, Vitamin D', 'When a baseline check is useful'],
  },
  {
    title: 'Smart Testing Plan',
    text: 'Know which investigations matter now and which can wait.',
    icon: BookOpen,
    points: ['Female fertility tests', 'Semen analysis basics', 'Avoiding unnecessary panic tests'],
  },
  {
    title: 'Body Preparation',
    text: 'Build a healthier pre-pregnancy routine with realistic changes.',
    icon: HeartPulse,
    points: ['Nutrition and supplements', 'Weight, sleep, and stress', 'Hormonal balance habits'],
  },
  {
    title: 'Partner Health',
    text: 'Make fertility planning a shared couple process.',
    icon: Baby,
    points: ['Male fertility factors', 'Lifestyle risks for sperm health', 'How partners can support the plan'],
  },
  {
    title: 'When To Act',
    text: 'Learn when patience is fine and when medical review is sensible.',
    icon: CalendarCheck,
    points: ['Trying timelines by age', 'Warning signs to not ignore', 'Past loss or failed cycles'],
  },
  {
    title: 'Next-Step Roadmap',
    text: 'Leave with a clear action plan instead of scattered advice.',
    icon: CheckCircle,
    points: ['Natural conception plan', 'IVF readiness if needed', 'Questions to ask your doctor'],
  },
];

const heroProofStats = [
  { value: '80%', text: 'of couples conceive in the first 6 months, when conditions are right' },
  { value: '90%', text: 'conceive within a year, but only if nothing was missed before they started' },
  { value: '1 in 6', text: 'couples face fertility challenges, most are identifiable before conception' },
];

const prepareSteps = [
  { letter: 'P', title: 'Planning & Preconception Goals', text: 'Age, timelines, ovarian reserve, supplements' },
  { letter: 'R', title: 'Review of Medical History', text: 'Medical, surgical, obstetric, genetic, both partners' },
  { letter: 'E', title: 'Evaluate with Tests', text: 'Fertility hormones, semen analysis, genetic screening' },
  { letter: 'P', title: 'Prevent & Protect', text: 'Vaccination, rubella, varicella, hepatitis B' },
  { letter: 'A', title: 'Assess Chronic Conditions', text: 'PCOS, thyroid, diabetes, endometriosis' },
  { letter: 'R', title: 'Reinforce Education & Support', text: 'Ovulation, fertility myths, emotional wellbeing' },
  { letter: 'E', title: 'Enhance Lifestyle Optimisation', text: 'Diet, exercise, sleep, weight, stress, EDC exposure' },
];

const bandStats = [
  { value: '5%', text: 'weight loss is enough to measurably improve fertility outcomes' },
  { value: '10%', text: 'reduction in conception rate for every BMI unit over 30' },
  { value: '4.9★', text: 'average Google rating, Renew Healthcare, Kolkata' },
];

const whyItMatters = [
  {
    title: "Genetic risks you don't know you carry",
    text: 'Thalassaemia, SMA, and other inherited conditions can pass silently from carrier parents to children. Carrier screening before conception allows couples to make informed decisions, not emergency ones.',
    statLabel: 'In India:',
    statText: 'thalassaemia carrier rate is 3–4% of the general population',
    icon: Dna,
  },
  {
    title: 'Undiagnosed conditions that worsen with time',
    text: 'PCOS, endometriosis, thyroid disease, and subclinical diabetes are frequently present at marriage but undetected. Each year of delay allows these conditions to progress and reduce fertility further.',
    statLabel: 'Endometriosis:',
    statText: "progressive and recurrent, symptoms don't always match severity",
    icon: Microscope,
  },
  {
    title: 'Medications that cannot continue into pregnancy',
    text: 'Valproate, isotretinoin, methotrexate, and several other common medications are contraindicated in pregnancy. A preconception visit ensures safe substitution well before conception, not in a panic at a positive test.',
    statLabel: 'Valproate:',
    statText: '10× higher neural tube defect risk, requires 4–5 mg folate supplementation',
    icon: Pill,
  },
];

const clinicalDomains = [
  { title: 'Pregnancy planning & age', text: 'Ovarian reserve, age-related risks, oocyte preservation counselling' },
  { title: 'Full medical history review', text: 'Both partners, chronic conditions, medications, surgical history' },
  { title: 'Fertility investigations', text: 'AMH, AFC, TSH, semen analysis, DFI, carrier screening' },
  { title: 'Vaccination & immunity', text: 'Rubella and varicella cannot be given in pregnancy, must be confirmed before' },
  { title: 'Chronic condition management', text: 'PCOS, thyroid, diabetes, endometriosis, hypertension, treatment-optimised for conception' },
  { title: 'Genetic & family history', text: 'Three-generation family history, consanguinity, carrier risk profiling' },
  { title: 'Male fertility assessment', text: 'Sperm parameters, DFI, hormonal profile, lifestyle impact, occupational exposure' },
  { title: 'Lifestyle & environment', text: 'Weight, diet, sleep, alcohol, smoking, endocrine disruptors, stress' },
];

const whoShouldBook = [
  {
    title: 'Recently married or engaged',
    text: 'Planning a family in the next 1–2 years? The Zero Trimester begins now, not when you decide to start trying.',
    tag: 'Planning ahead',
    icon: Users,
  },
  {
    title: 'Actively trying to conceive',
    text: "If you've been trying for 3–6 months without success, a structured preconception evaluation will identify what's been missed.",
    tag: 'TTC support',
    icon: CalendarCheck,
  },
  {
    title: 'Known medical conditions',
    text: 'PCOS, thyroid disease, endometriosis, diabetes, or hypertension, these require preconception optimisation before pregnancy is safe.',
    tag: 'Condition management',
    icon: Stethoscope,
  },
  {
    title: 'Family history of genetic conditions',
    text: 'Thalassaemia, hearing loss, SMA, or other inherited conditions in your family warrant carrier screening before conception.',
    tag: 'Genetic risk',
    icon: Dna,
  },
  {
    title: 'Planning to delay parenthood',
    text: 'Want children in 3–5 years but concerned about fertility? Ovarian reserve assessment and fertility preservation counselling is available now.',
    tag: 'Fertility preservation',
    icon: Clock,
  },
  {
    title: 'Planning a second pregnancy',
    text: 'Secondary infertility is more common than most couples expect. A structured review after your first pregnancy identifies new and changed risk factors.',
    tag: 'Second pregnancy',
    icon: Baby,
  },
];

const lifestyleFactors = [
  {
    title: 'Weight & BMI',
    text: 'Every unit of BMI above 30 reduces conception rate by 10%. For men, obesity reduces sperm concentration by 15–20% and increases DNA fragmentation by 30–40%.',
    fact: 'Even 5% weight loss improves fertility outcomes.',
    icon: Scale,
  },
  {
    title: 'Smoking & Tobacco',
    text: 'Smoking accelerates egg depletion, increases miscarriage risk, and reduces sperm count, motility, and morphology. Hookah and sheesha carry greater risk than cigarettes.',
    fact: 'Smoking women are significantly more likely to be infertile.',
    icon: Cigarette,
  },
  {
    title: 'Alcohol',
    text: 'Consumption above 2 drinks/day is associated with infertility in both partners. For the zero trimester specifically, abstinence is the evidence-based recommendation.',
    fact: 'The safest amount during the zero trimester is zero.',
    icon: Wine,
  },
  {
    title: 'Sleep',
    text: '7–9 hours is the target. Women sleeping past midnight show increased infertility risk. Sleep disruption alters LH rhythms, melatonin levels, and insulin sensitivity, all critical for ovulation.',
    fact: 'Late sleep disrupts ovulation at a hormonal level.',
    icon: Moon,
  },
  {
    title: 'Exercise',
    text: 'Mild to moderate exercise increases fertility by ~15%. For women with PCOS, vigorous aerobic and resistance training outperforms moderate exercise. Results require consistency over 50+ hours of training.',
    fact: 'Sedentary lifestyle and extreme training are both harmful.',
    icon: Dumbbell,
  },
  {
    title: 'Endocrine Disruptors',
    text: 'Plastics, synthetic fragrances, pesticides, and cosmetics containing BPA and phthalates disrupt hormonal signalling. EDC exposure is linked to PCOS, endometriosis, and early menopause.',
    fact: 'What you put on your skin enters your bloodstream.',
    icon: FlaskConical,
  },
];

const videoLibrary = [
  {
    id: '8FGOYJNYXOE',
    topic: 'Environment & Fertility',
    title: 'Endocrine Disruptors and Your Fertility, What They Are, Where They Hide, and What to Do',
    text: 'A clinical deep-dive into the everyday chemicals, in your plastics, cosmetics, air fresheners, and food, that interfere with reproductive hormones in both partners.',
    href: 'https://youtu.be/8FGOYJNYXOE?si=khIf73hZfTtU-dFq',
  },
  {
    id: 'nlrEKSAaG7M',
    topic: 'Natural Conception',
    title: '25 Fertility Questions & Myths Around Trying Naturally, Answered by a Fertility Specialist',
    text: 'Everything couples are embarrassed to ask: timing of intercourse, frequency, positions, LH kits, ovulation apps, lubricants, and the evidence behind each. Clinically accurate, myth-free.',
    href: 'https://youtu.be/nlrEKSAaG7M?si=B0pIiqkx4km2yurH',
  },
];

const upcomingVideoTopics = [
  'Weight & BMI for fertility',
  'Folic acid vs L-methylfolate',
  'Thalassaemia carrier screening',
  'PCOS & preconception',
  'Thyroid before pregnancy',
  'Alcohol & sperm DNA',
  'Paternal age & fertility',
  'Ovarian reserve & egg freezing',
  'Sleep & fertility hormones',
  'Vaccination before pregnancy',
  'Male preconception health',
  'Vitamin D & fertility',
];

const consultationJourney = [
  {
    title: 'Before you arrive',
    text: 'You and your partner complete a detailed preconception health profile, 12 domains covering your full medical, genetic, and lifestyle history. Bring any previous test results.',
    icon: ClipboardList,
  },
  {
    title: 'The consultation',
    text: 'Dr. Agarwal conducts a structured clinical assessment across all 8 domains, both partners. Every relevant risk factor is identified and documented.',
    icon: UserCheck,
  },
  {
    title: 'Investigations ordered',
    text: 'A targeted investigation panel is ordered based on your history, not a generic screen. Results are interpreted in the context of your specific situation.',
    icon: FlaskConical,
  },
  {
    title: 'Your 90-day roadmap',
    text: 'You leave with a written personalised plan: your supplement programme, investigations, vaccinations, lifestyle changes, and follow-up schedule. Not generic advice, yours specifically.',
    icon: Route,
  },
];

const consultBadges = [
  'In-person at Renew Healthcare, Kolkata',
  'Both partners always included',
  'Personalised 90-day action plan',
  'Structured 8-domain clinical assessment',
];

const patientStories = [
  {
    name: 'Priya S.',
    detail: 'Kolkata, preconception consultation, 2024',
    initial: 'P',
    text: "We had been trying for eight months before our consultation with Dr. Agarwal. Within the first visit, he identified my husband's borderline sperm DNA fragmentation and my subclinical thyroid, neither of which had been picked up before. Three months later we were pregnant.",
  },
  {
    name: 'Anuradha M.',
    detail: 'Kolkata, preconception screening, 2024',
    initial: 'A',
    text: 'We came before we even started trying, just to make sure everything was in order. Dr. Agarwal found I was a thalassaemia carrier and my husband was tested immediately. That one conversation changed the entire course of our planning. We are deeply grateful.',
  },
  {
    name: 'Reshma K.',
    detail: 'Kolkata, PCOS preconception, 2023',
    initial: 'R',
    text: 'I have PCOS and was told by multiple doctors to "just try for a year first." Dr. Agarwal\'s approach was completely different, structured, evidence-based, and respectful. He optimised my condition before we started, and I conceived naturally within four months.',
  },
];

const reviews = [
  {
    name: 'Mr & Mrs Gupta',
    text: 'No unnecessary tests, no pressure, just clear guidance for our situation. The session helped us understand what to do next.',
  },
  {
    name: 'Mr & Mrs Tanuja',
    text: 'We did not know small things like Vitamin D, stress, and sleep could affect fertility. The advice was easy to understand and follow.',
  },
  {
    name: 'Mr & Mrs Soni',
    text: 'We had doubts about when to start, what to eat, and what tests to do. The counselling made us feel prepared instead of anxious.',
  },
];

const storyImages = [
  ['happiness-01.jpg', 'Family smiling after fertility care'],
  ['happiness-02.jpg', 'Couple sharing a parenthood success moment'],
  ['happiness-03.jpg', 'Happy parents with their baby'],
  ['happiness-04.jpg', 'Fertility success story family photo'],
];

const awardImages = [
  ['award-01.jpg', 'Award recognition for Dr. Rajeev Agarwal'],
  ['award-02.png', 'Healthcare award received by Dr. Rajeev Agarwal'],
  ['award-03.jpg', 'Dr. Rajeev Agarwal award ceremony photograph'],
  ['award-04.png', 'Fertility care award certificate'],
  ['award-05.jpg', 'Dr. Rajeev Agarwal recognition event'],
  ['award-06.png', 'Medical excellence award'],
  ['award-07.png', 'Healthcare recognition plaque'],
  ['award-08.png', 'Fertility specialist award'],
];

const faqs = [
  {
    title: "When should we start preconception planning?",
    text: "Ideally, you should start planning at least 3 months (the 'Zero Trimester') before you begin actively trying to conceive. This gives you enough time to check and correct nutritional gaps, complete vaccinations, adjust medications, and optimize health conditions."
  },
  {
    title: "What happens during a preconception consultation?",
    text: "During the consultation, Dr. Rajeev Agarwal reviews your medical history, menstrual cycle patterns, and lifestyle habits. He advises on essential pre-pregnancy blood tests, checks immunity status, conducts a pelvic scan to evaluate your uterine lining and ovarian reserve, and outlines a personalized care roadmap."
  },
  {
    title: "What are the essential tests recommended before pregnancy?",
    text: "Essential tests include Haemoglobin & Ferritin (iron storage), Vitamin D & B12, Thyroid (TSH), Glucose metabolism (75g Oral Glucose Load & HOMA-IR), Rubella & Varicella immunity, and basic genetic carrier screening like HPLC for Thalassemia."
  },
  {
    title: "Why is the husband's health evaluated during planning?",
    text: "Male fertility accounts for nearly half of all conception delays. A simple semen analysis assesses sperm count, motility, and shape. Evaluating partner habits (sleep, stress, smoking) is also key to ensuring a healthy environment for the developing embryo."
  },
  {
    title: "If I feel completely healthy, do I still need counselling?",
    text: "Yes. Many conditions that affect pregnancy, such as mild thyroid dysfunction, low ferritin, or genetic carrier status, have absolutely no symptoms. Preconception checks ensure your body is fully optimized, reducing risks of early loss or complications."
  },
  {
    title: "Does weight affect fertility?",
    text: "Yes. For every BMI unit above 30, the chance of conception per cycle drops by approximately 10%. In men, obesity reduces sperm concentration by 15–20% and increases DNA fragmentation by 30–40%. Even a 5% reduction in body weight measurably improves fertility outcomes in both partners."
  },
  {
    title: "Is alcohol safe when trying to conceive?",
    text: "No safe level of alcohol has been established during the preconception period. Alcohol above 2 standard drinks per day reduces fertility in both partners. In men it reduces testosterone and sperm quality. In women it disrupts ovulation and hormonal signalling. Complete abstinence for both partners during the Zero Trimester is the evidence-based recommendation."
  },
  {
    title: "Does shisha or hookah affect fertility?",
    text: "Yes, and significantly more than most people realise. A single shisha session can deliver the equivalent of 100–200 cigarettes' worth of smoke. It carries the same reproductive risks as cigarette smoking: reduced sperm quality, disrupted ovulation, increased miscarriage risk, and higher carbon monoxide exposure. The belief that shisha is \"safer\" is not supported by the evidence."
  },
  {
    title: "What vaccinations should I have before getting pregnant?",
    text: "Rubella and varicella vaccines cannot be given during pregnancy, immunity must be confirmed before conception. Other recommended vaccines include hepatitis B (3 doses), influenza, and Tdap. If you are not immune to rubella or varicella, you must be vaccinated and wait at least one month before trying. Immunity is confirmed with a simple IgG blood test as part of preconception screening."
  },
  {
    title: "What is thalassaemia screening and should I do it?",
    text: "Thalassaemia is an inherited blood disorder with a carrier rate of 3–4% in India's general population, significantly higher in some communities. A simple HPLC blood test identifies carriers. If both partners carry the gene, each pregnancy has a 25% chance of thalassaemia major. Screening before conception is essential, it allows informed decision-making and access to prenatal testing."
  },
  {
    title: "What are endocrine disruptors and how do they affect fertility?",
    text: "Endocrine-disrupting chemicals (EDCs) are found in plastics, synthetic fragrances, pesticides, and cosmetics. BPA and phthalates are among the most studied. Exposure is linked to PCOS, endometriosis, reduced sperm quality, and poor IVF outcomes. Both partners should reduce EDC exposure during the Zero Trimester, especially through food storage, cookware, and personal care product choices."
  },
  {
    title: "Is folic acid enough preconception supplementation?",
    text: "For most women, folic acid is the foundation, but it is not sufficient on its own. Vitamin D, B12, and iodine are frequently deficient in Indian women and should be assessed and supplemented. Women with the MTHFR variant, absorption issues, or on valproate require L-methylfolate or higher-dose folic acid. Male partners benefit from a targeted antioxidant programme including CoQ10, zinc, selenium, and omega-3. A preconception consultation determines what each individual needs."
  }
];

// Accordion helper removed to use standard ra-faq structure

const SEO_KEYWORDS =
  'preconception counselling Kolkata, how to prepare for pregnancy, fertility specialist Kolkata, before pregnancy checkup, preconception care, thalassemia screening before pregnancy, PCOS and pregnancy, thyroid before pregnancy, natural conception tips, fertility doctor Kolkata, weight and fertility, smoking and fertility, alcohol and fertility, shisha and fertility, endocrine disruptors fertility, sperm DNA fragmentation, ovarian reserve testing, AMH test Kolkata, preconception vitamins, folic acid pregnancy, carrier screening India, fertility tests before pregnancy, trying to conceive naturally, zero trimester';

function buildPreconceptionSchema(origin) {
  const pageUrl = `${origin}/preconception`;

  return {
    '@context': 'https://schema.org',
    '@graph': [
      {
        '@type': 'Physician',
        '@id': `${origin}/#physician`,
        name: 'Dr. Rajeev Agarwal',
        url: origin,
        image: `${origin}${ASSET_PATH}expert-dr-rajeev-agarwal.jpg`,
        description:
          'Gynaecologist and fertility specialist at Renew Healthcare, Kolkata. Specialist in preconception counselling, IVF, PCOS, endometriosis, and reproductive medicine.',
        medicalSpecialty: ['Obstetrics and Gynecology', 'Reproductive Medicine'],
        telephone: '+918336968661',
        email: 'fertilitywithoutborders@gmail.com',
        address: {
          '@type': 'PostalAddress',
          name: 'Renew Healthcare',
          addressLocality: 'Kolkata',
          addressRegion: 'West Bengal',
          addressCountry: 'IN',
        },
        aggregateRating: {
          '@type': 'AggregateRating',
          ratingValue: '4.9',
          reviewCount: '200',
          bestRating: '5',
        },
        sameAs: ['https://www.youtube.com/@RenewHealthCare'],
      },
      {
        '@type': 'MedicalWebPage',
        '@id': `${pageUrl}#webpage`,
        url: pageUrl,
        name: 'Preconception Counselling in Kolkata | The Zero Trimester',
        inLanguage: 'en',
        about: { '@id': `${origin}/#physician` },
        keywords: SEO_KEYWORDS,
      },
      {
        '@type': 'BreadcrumbList',
        '@id': `${pageUrl}#breadcrumb`,
        itemListElement: [
          { '@type': 'ListItem', position: 1, name: 'Home', item: origin },
          { '@type': 'ListItem', position: 2, name: 'Services', item: `${origin}/all-services` },
          {
            '@type': 'ListItem',
            position: 3,
            name: 'The Zero Trimester, Preconception Counselling',
            item: pageUrl,
          },
        ],
      },
      ...videoLibrary.map((video) => ({
        '@type': 'VideoObject',
        name: video.title,
        description: video.text,
        embedUrl: `https://www.youtube.com/embed/${video.id}`,
        contentUrl: `https://youtu.be/${video.id}`,
        thumbnailUrl: `https://img.youtube.com/vi/${video.id}/maxresdefault.jpg`,
        uploadDate: '2024-01-01',
      })),
      {
        '@type': 'FAQPage',
        '@id': `${pageUrl}#faq`,
        mainEntity: faqs.map((item) => ({
          '@type': 'Question',
          name: item.title,
          acceptedAnswer: { '@type': 'Answer', text: item.text },
        })),
      },
    ],
  };
}

function usePreconceptionSeo() {
  useEffect(() => {
    const title = 'Preconception Counselling in Kolkata | The Zero Trimester | Dr. Rajeev Agarwal';
    const description =
      'Dr. Rajeev Agarwal offers evidence-based preconception counselling in Kolkata. Prepare for pregnancy with a structured 8-domain assessment, fertility tests, genetic screening, PCOS, thyroid, vaccination, and lifestyle optimisation for both partners.';
    const previousTitle = document.title;

    const ensureMeta = (selector, attrs) => {
      let element = document.head.querySelector(selector);
      if (!element) {
        element = document.createElement('meta');
        document.head.appendChild(element);
      }
      Object.entries(attrs).forEach(([key, value]) => element.setAttribute(key, value));
    };

    document.title = title;
    ensureMeta('meta[name="description"]', { name: 'description', content: description });
    ensureMeta('meta[name="keywords"]', { name: 'keywords', content: SEO_KEYWORDS });
    ensureMeta('meta[property="og:title"]', { property: 'og:title', content: title });
    ensureMeta('meta[property="og:description"]', { property: 'og:description', content: description });
    ensureMeta('meta[property="og:image"]', {
      property: 'og:image',
      content: `${window.location.origin}${ASSET_PATH}hero-video-cover.jpg`,
    });

    let canonical = document.head.querySelector('link[rel="canonical"]');
    if (!canonical) {
      canonical = document.createElement('link');
      canonical.rel = 'canonical';
      document.head.appendChild(canonical);
    }
    canonical.href = `${window.location.origin}/preconception`;

    const schemaScript = document.createElement('script');
    schemaScript.type = 'application/ld+json';
    schemaScript.dataset.preconceptionSchema = 'true';
    schemaScript.textContent = JSON.stringify(buildPreconceptionSchema(window.location.origin));
    document.head.appendChild(schemaScript);

    return () => {
      document.title = previousTitle;
      schemaScript.remove();
    };
  }, []);
}

const SERVICE_BLOG_CATEGORIES = {
  'preconception': ['Preconception Care', 'Safe Pregnancy'],
};

function getAllowedCategories(slug) {
  return SERVICE_BLOG_CATEGORIES[slug] || ['Preconception Care', 'Safe Pregnancy'];
}

const RELATED_BLOG_KEYWORDS = {
  'preconception': ['preconception', 'zero trimester', 'before pregnancy', 'trying to conceive', 'fertility readiness', 'thyroid', 'tests before pregnancy'],
};

function RelatedBlogs({ serviceSlug, serviceTitle }) {
  const [blogs, setBlogs] = useState([]);
  const [loaded, setLoaded] = useState(false);

  useEffect(() => {
    let active = true;

    async function loadBlogs() {
      try {
        let fallback = [];
        try {
          const saved = localStorage.getItem('blogsList');
          fallback = saved ? JSON.parse(saved) : initialBlogs;
        } catch {
          fallback = initialBlogs;
        }

        const remoteBlogs = await listPublishedBlogs();

        if (active) {
          const seen = new Set();
          const combined = [...remoteBlogs, ...liveBlogUpdates, ...fallback].filter(b => {
            if (seen.has(b.slug)) return false;
            seen.add(b.slug);
            return true;
          });

          const presented = combined.map((item, index) => buildBlogPresentation(item, index));
          setBlogs(presented);
          setLoaded(true);
        }
      } catch (err) {
        console.error('Error loading related blogs:', err);
      }
    }

    loadBlogs();

    return () => {
      active = false;
    };
  }, []);

  const related = useMemo(() => {
    if (!loaded || blogs.length === 0) return [];

    // Sort all blogs by date descending
    const sorted = [...blogs].sort((a, b) => new Date(b.date) - new Date(a.date));

    // Get allowed categories for this page
    const allowedCats = getAllowedCategories(serviceSlug);

    // Filter blogs to only include those in the allowed categories
    const categoryBlogs = sorted.filter(blog => {
      const cat = getBlogCategory(blog);
      return allowedCats.includes(cat);
    });

    const keywords = RELATED_BLOG_KEYWORDS[serviceSlug] || [];
    const titleWords = serviceTitle
      .toLowerCase()
      .replace(/[^\w\s]/g, '')
      .split(/\s+/)
      .filter(w => w.length > 3);

    const allKeywords = Array.from(new Set([...keywords, ...titleWords]));

    // Find matching blogs within the allowed categories
    const matched = [];
    categoryBlogs.forEach(blog => {
      let isMatch = false;
      const title = (blog.title || '').toLowerCase();
      const excerpt = (blog.excerpt || '').toLowerCase();
      const tags = Array.isArray(blog.tags) ? blog.tags.map(t => t.toLowerCase()) : [];

      for (const kw of allKeywords) {
        const kwLower = kw.toLowerCase();
        if (tags.some(tag => tag.includes(kwLower)) || title.includes(kwLower) || excerpt.includes(kwLower)) {
          isMatch = true;
          break;
        }
      }

      if (isMatch) {
        matched.push(blog);
      }
    });

    // Take top 3 matched blogs
    const result = matched.slice(0, 3);

    // If less than 3 matched, fill the remaining slots with the most recent blogs FROM THE SAME CATEGORY GROUP
    if (result.length < 3) {
      const usedSlugs = new Set(result.map(b => b.slug));
      for (const blog of categoryBlogs) {
        if (!usedSlugs.has(blog.slug)) {
          result.push(blog);
          usedSlugs.add(blog.slug);
        }
        if (result.length === 3) break;
      }
    }

    // In the extremely rare case we still have less than 3, fill from the general list
    if (result.length < 3) {
      const usedSlugs = new Set(result.map(b => b.slug));
      for (const blog of sorted) {
        if (!usedSlugs.has(blog.slug)) {
          result.push(blog);
          usedSlugs.add(blog.slug);
        }
        if (result.length === 3) break;
      }
    }

    return result;
  }, [blogs, loaded, serviceSlug, serviceTitle]);

  if (!loaded || related.length === 0) {
    return null;
  }

  return (
    <section className="ra-blog-section" style={{ background: '#fcfdff', borderTop: '1px solid #eef2f7', padding: '70px 0' }}>
      <div className="ra-container">
        <div className="ra-section-head">
          <span className="ra-label">Related Articles</span>
          <h2>Read Insights About <em>{serviceTitle}</em></h2>
        </div>
        <div className="ra-blog-grid">
          {related.map((post, index) => (
            <article className="ra-blog-card" key={post.slug}>
              <div className="ra-blog-img-wrap">
                <img src={post.image || getBlogImage(post, index)} alt={post.title} loading="lazy" />
              </div>
              <div className="ra-blog-body">
                <span className="ra-blog-badge">{getBlogCategory(post)}</span>
                <h3>{post.title}</h3>
                <p>{post.excerpt}</p>
                <time dateTime={post.date}>{post.displayDate || post.date}</time>
                <Link to={`/blog/${post.slug}`} className="ra-blog-link">Read Article</Link>
              </div>
            </article>
          ))}
        </div>
      </div>
    </section>
  );
}

export default function Preconception() {
  usePreconceptionSeo();
  const [openFaq, setOpenFaq] = useState(null);
  const [heroVideoPlaying, setHeroVideoPlaying] = useState(false);
  const heroVideoRef = useRef(null);

  const handleHeroVideoPlay = () => {
    setHeroVideoPlaying(true);
    const video = heroVideoRef.current;
    if (!video) return;

    const playPromise = video.play();
    if (playPromise?.catch) {
      playPromise.catch(() => {
        // Native controls remain visible if the browser blocks programmatic playback.
      });
    }
  };

  useEffect(() => {
    document.body.classList.add('pcw-route');
    return () => document.body.classList.remove('pcw-route');
  }, []);

  return (
    <div className="pcw-page preconception-page">
      <section className="preconception-hero">
        <div className="ra-container preconception-hero-grid">
          <div className="preconception-hero-copy">
            <span className="ra-label"><Baby size={16} /> Zero Trimester Planning</span>
            <h1>Prepare For Pregnancy With <em>Clarity</em></h1>
            <p>
              A focused counselling pathway for couples who want to understand fertility, testing,
              nutrition, and timing before pregnancy begins.
            </p>
            <div className="preconception-hero-actions">
              <Link className="ra-btn ra-btn-primary preconception-hero-cta" to="/preconception-workshop">
                <CalendarCheck size={18} />
                Join Preconception Workshop
              </Link>
              <a className="ra-btn ra-btn-soft preconception-hero-cta" href="#videos">
                <Video size={18} />
                Watch Free Videos
              </a>
            </div>
            <dl className="preconception-hero-stats">
              {heroProofStats.map(({ value, text }) => (
                <div className="preconception-hero-stat" key={value}>
                  <dt>{value}</dt>
                  <dd>{text}</dd>
                </div>
              ))}
            </dl>
          </div>

          <div className="preconception-hero-media">
            <div className="preconception-hero-video-wrap">
              <video
                className="preconception-hero-video"
                controls={heroVideoPlaying}
                playsInline
                poster={`${ASSET_PATH}hero-video-cover.jpg`}
                preload="metadata"
                ref={heroVideoRef}
              >
                <source src={PRECONCEPTION_VIDEO_URL} type="video/mp4" />
              </video>
              {!heroVideoPlaying && (
                <button
                  aria-label="Play preconception counselling video"
                  className="preconception-hero-video-trigger"
                  onClick={handleHeroVideoPlay}
                  type="button"
                >
                  <img
                    alt="Preconception counselling with Dr. Rajeev Agarwal"
                    src={`${ASSET_PATH}hero-video-cover.jpg`}
                  />
                  <span className="preconception-hero-play" aria-hidden="true">
                    <Play size={30} fill="currentColor" />
                  </span>
                </button>
              )}
            </div>
            <div className="preconception-floating-note">
              <strong>Guided by Dr. Rajeev Agarwal</strong>
              <span>25+ years in fertility and reproductive medicine</span>
            </div>
          </div>

          <aside className="preconception-plan-panel" id="preconception-planning" aria-label="Preconception planning checklist">
            <div className="preconception-plan-card">
              <div className="preconception-plan-intro">
                <span className="ra-label"><ShieldCheck size={16} /> Planning Checklist</span>
                <h2>Start With The Right Pre-Pregnancy Questions</h2>
                <p>
                  Use this page as a starting point for a more structured preconception conversation,
                  so your consultation can focus on what matters for your health and timeline.
                </p>
              </div>
              <div className="preconception-plan-grid">
                {planningHighlights.map(({ title, text, icon: Icon }) => (
                  <article className="preconception-plan-item" key={title}>
                    <span><Icon size={20} /></span>
                    <h3>{title}</h3>
                    <p>{text}</p>
                  </article>
                ))}
              </div>
            </div>
          </aside>
        </div>
      </section>

      <section className="preconception-statband" aria-label="Preconception outcomes at a glance">
        <div className="ra-container preconception-statband-grid">
          {bandStats.map(({ value, text }) => (
            <div className="preconception-statband-item" key={value}>
              <strong>{value}</strong>
              <span>{text}</span>
            </div>
          ))}
        </div>
      </section>

      <section className="preconception-section preconception-prepare-section">
        <div className="ra-container">
          <div className="ra-section-head">
            <span className="ra-label"><ClipboardList size={16} /> The PREPARE Framework</span>
            <h2>What We Cover In Your <em>Consultation</em></h2>
            <p>Eight clinical domains, structured around a seven-step framework, for both partners.</p>
          </div>
          <ol className="preconception-prepare-list">
            {prepareSteps.map(({ letter, title, text }, index) => (
              <li className="preconception-prepare-item" key={`${letter}-${index}`}>
                <span className="preconception-prepare-letter" aria-hidden="true">{letter}</span>
                <div>
                  <h3>{title}</h3>
                  <p>{text}</p>
                </div>
              </li>
            ))}
          </ol>
        </div>
      </section>

      <section className="preconception-section preconception-why-section">
        <div className="ra-container">
          <div className="ra-section-head">
            <span className="ra-label"><ShieldCheck size={16} /> Why The Zero Trimester Matters</span>
            <h2>Most Fertility Problems Are Identifiable <em>Before You Start Trying</em></h2>
          </div>
          <div className="preconception-why-grid">
            {whyItMatters.map(({ title, text, statLabel, statText, icon: Icon }, index) => (
              <article className="preconception-why-card" key={title}>
                <div className="preconception-why-top">
                  <span><Icon size={22} /></span>
                  <strong>{String(index + 1).padStart(2, '0')}</strong>
                </div>
                <h3>{title}</h3>
                <p>{text}</p>
                <p className="preconception-why-stat">
                  <strong>{statLabel}</strong> <em>{statText}</em>
                </p>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="preconception-section preconception-pillars-section">
        <div className="ra-container">
          <div className="ra-section-head">
            <span className="ra-label"><ShieldCheck size={16} /> What You Will Get</span>
            <h2>Preconception Care That Feels <em>Practical</em></h2>
          </div>
          <div className="preconception-pillar-grid">
            {pillars.map(({ title, text, icon: Icon }) => (
              <article className="preconception-pillar-card" key={title}>
                <span><Icon size={22} /></span>
                <h3>{title}</h3>
                <p>{text}</p>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="preconception-section preconception-proof-section">
        <div className="ra-container preconception-proof-layout">
          <div className="preconception-proof-copy">
            <span className="ra-label"><Baby size={16} /> Real Stories</span>
            <h2>Couples Leave With More <em>Confidence</em></h2>
            <p>
              The counselling approach is designed to reduce guesswork before pregnancy planning. These
              stories and photographs reflect the kind of clarity and reassurance couples look for.
            </p>
            <div className="preconception-story-grid">
              {storyImages.map(([image, alt]) => (
                <img alt={alt} key={image} loading="lazy" src={`${ASSET_PATH}${image}`} />
              ))}
            </div>
          </div>
          <div className="preconception-review-grid">
            {reviews.map((review) => (
              <article className="preconception-review-card" key={review.name}>
                <img alt={`${review.name} review avatar`} loading="lazy" src={`${ASSET_PATH}user-icon.jpg`} />
                <p>"{review.text}"</p>
                <strong>{review.name}</strong>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="preconception-section preconception-fit-section">
        <div className="ra-container preconception-split">
          <div>
            <span className="ra-label"><HeartPulse size={16} /> Who Should Attend</span>
            <h2>Built For Couples Who Want A Calm, Informed <em>Start</em></h2>
            <p>
              This is not a pressure-heavy treatment pitch. It is a structured session that
              helps you decide what matters for your body, your partner, and your timeline.
            </p>
          </div>
          <div className="preconception-list-panel">
            {suitableFor.map((item) => (
              <span key={item}><CheckCircle size={20} /> {item}</span>
            ))}
          </div>
        </div>
      </section>

      <section className="preconception-section preconception-agenda-section">
        <div className="ra-container">
          <div className="preconception-agenda-card">
            <div className="preconception-agenda-head">
              <div>
                <span className="ra-label"><BookOpen size={16} /> Care Outline</span>
                <h2>What The Counselling <em>Covers</em></h2>
                <p>Six practical areas, designed to help you make calmer decisions before pregnancy.</p>
              </div>
              <a className="ra-btn ra-btn-soft" href="/book-an-appointment">Discuss Care Plan</a>
            </div>
            <div className="preconception-agenda-grid">
              {agenda.map(({ title, text, icon: Icon, points }, index) => (
                <article className="preconception-agenda-module" key={title}>
                  <div className="preconception-module-top">
                    <span><Icon size={22} /></span>
                    <strong>{String(index + 1).padStart(2, '0')}</strong>
                  </div>
                  <h3>{title}</h3>
                  <p>{text}</p>
                  <ul>
                    {points.map((point) => (
                      <li key={point}><CheckCircle size={15} /> {point}</li>
                    ))}
                  </ul>
                </article>
              ))}
            </div>
          </div>
        </div>
      </section>

      <section className="preconception-section preconception-domains-section">
        <div className="ra-container preconception-domains-layout">
          <ol className="preconception-domain-list">
            {clinicalDomains.map(({ title, text }, index) => (
              <li className="preconception-domain-item" key={title}>
                <span aria-hidden="true">{String(index + 1).padStart(2, '0')}</span>
                <div>
                  <h3>{title}</h3>
                  <p>{text}</p>
                </div>
              </li>
            ))}
          </ol>
          <div className="preconception-domains-copy">
            <span className="ra-label"><Stethoscope size={16} /> A Comprehensive Consultation</span>
            <h2>This Is Not A Routine <em>Gynaecology Visit</em></h2>
            <p>
              Most preconception appointments end with a folic acid prescription. Dr. Agarwal's
              consultation is structured across eight clinical domains, both partners, both
              biologies, with evidence-based investigation and a personalised 90-day action plan.
            </p>
            <div className="preconception-domains-highlight">
              <strong>The question most specialists don't ask:</strong>
              <p>
                Are you doing more than prescribing folic acid? The literature is clear, folic acid
                alone, without assessing immunity, genetics, chronic disease, and male health, leaves
                most of the risk unaddressed.
              </p>
            </div>
            <a className="ra-btn ra-btn-primary" href="/book-an-appointment">Book Your Consultation</a>
          </div>
        </div>
      </section>

      <section className="preconception-section preconception-audience-section">
        <div className="ra-container">
          <div className="ra-section-head">
            <span className="ra-label"><Users size={16} /> Is This Consultation For You?</span>
            <h2>You Don't Need To Be Struggling To <em>Benefit</em></h2>
            <p>
              The ideal time for preconception counselling is before you start trying, not after
              six months of disappointment.
            </p>
          </div>
          <div className="preconception-audience-grid">
            {whoShouldBook.map(({ title, text, tag, icon: Icon }) => (
              <article className="preconception-audience-card" key={title}>
                <span className="preconception-audience-icon"><Icon size={22} /></span>
                <h3>{title}</h3>
                <p>{text}</p>
                <span className="preconception-audience-tag">{tag}</span>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="preconception-section preconception-lifestyle-section">
        <div className="ra-container">
          <div className="ra-section-head">
            <span className="ra-label"><HeartPulse size={16} /> What You Do Before Conception Matters</span>
            <h2>Six Lifestyle Factors That Directly Affect Your Fertility And Your <em>Child's Health</em></h2>
            <p>
              The research is unambiguous. What both partners eat, weigh, sleep, drink, and inhale in
              the three months before conception shapes not just whether pregnancy occurs, but the
              health trajectory of the child born.
            </p>
          </div>
          <div className="preconception-lifestyle-grid">
            {lifestyleFactors.map(({ title, text, fact, icon: Icon }) => (
              <article className="preconception-lifestyle-card" key={title}>
                <span className="preconception-lifestyle-icon"><Icon size={22} /></span>
                <h3>{title}</h3>
                <p>{text}</p>
                <p className="preconception-lifestyle-fact">{fact}</p>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="preconception-section preconception-video-section" id="videos">
        <div className="ra-container">
          <div className="ra-section-head">
            <span className="ra-label"><Video size={16} /> Free Educational Resources</span>
            <h2>Watch Before Your <em>Consultation</em></h2>
          </div>
          <div className="preconception-video-grid">
            {videoLibrary.map(({ id, topic, title, text, href }) => (
              <article className="preconception-video-card" key={id}>
                <a
                  className="preconception-video-thumb"
                  href={href}
                  target="_blank"
                  rel="noopener noreferrer"
                  aria-label={`Watch on YouTube: ${title}`}
                >
                  <img
                    alt={`Video thumbnail: ${title}`}
                    loading="lazy"
                    src={`https://img.youtube.com/vi/${id}/hqdefault.jpg`}
                  />
                  <span className="preconception-video-play" aria-hidden="true">
                    <Play size={26} fill="currentColor" />
                  </span>
                </a>
                <div className="preconception-video-body">
                  <span className="preconception-video-topic">{topic}</span>
                  <h3>{title}</h3>
                  <p>{text}</p>
                  <a
                    className="preconception-video-link"
                    href={href}
                    target="_blank"
                    rel="noopener noreferrer"
                  >
                    Watch on YouTube
                  </a>
                </div>
              </article>
            ))}
          </div>
          <div className="preconception-video-upcoming">
            <h3>Coming soon, new videos releasing monthly</h3>
            <ul>
              {upcomingVideoTopics.map((topic) => (
                <li key={topic}>{topic}</li>
              ))}
            </ul>
          </div>
        </div>
      </section>

      <section className="preconception-section preconception-journey-section">
        <div className="ra-container">
          <div className="ra-section-head">
            <span className="ra-label"><Route size={16} /> What To Expect</span>
            <h2>Your Consultation, <em>Step By Step</em></h2>
          </div>
          <ol className="preconception-journey-list">
            {consultationJourney.map(({ title, text, icon: Icon }, index) => (
              <li className="preconception-journey-item" key={title}>
                <span className="preconception-journey-marker" aria-hidden="true">
                  <Icon size={20} />
                  <strong>{index + 1}</strong>
                </span>
                <div>
                  <h3>{title}</h3>
                  <p>{text}</p>
                </div>
              </li>
            ))}
          </ol>
        </div>
      </section>

      <section className="preconception-section preconception-stories-section">
        <div className="ra-container">
          <div className="ra-section-head">
            <span className="ra-label"><Star size={16} /> Patient Stories</span>
            <h2>What Couples Say After Their Zero Trimester <em>Consultation</em></h2>
            <p>
              Real feedback from couples who came for preconception counselling at Renew Healthcare,
              Kolkata.
            </p>
          </div>
          <div className="preconception-stories-grid">
            {patientStories.map(({ name, detail, initial, text }) => (
              <figure className="preconception-story-card" key={name}>
                <div className="preconception-story-rating" aria-label="Rated 5 out of 5">
                  {[0, 1, 2, 3, 4].map((star) => (
                    <Star key={star} size={15} fill="currentColor" aria-hidden="true" />
                  ))}
                </div>
                <blockquote>{text}</blockquote>
                <figcaption>
                  <span className="preconception-story-avatar" aria-hidden="true">{initial}</span>
                  <span>
                    <strong>{name}</strong>
                    <em>{detail}</em>
                  </span>
                </figcaption>
              </figure>
            ))}
          </div>
          <a
            className="ra-btn ra-btn-soft preconception-stories-cta"
            href="https://www.google.com/maps/search/Renew+Healthcare+Kolkata"
            target="_blank"
            rel="noopener noreferrer"
          >
            Read more reviews on Google
          </a>
        </div>
      </section>

      <section className="preconception-section preconception-expert-section">
        <div className="ra-container">
          <div className="preconception-expert-card">
            <img
              alt="Dr. Rajeev Agarwal, Senior IVF Specialist"
              src={`${ASSET_PATH}expert-dr-rajeev-agarwal.jpg`}
              loading="lazy"
            />
            <div>
              <span className="ra-label"><Stethoscope size={16} /> Expert Led</span>
              <h2>Dr. Rajeev Agarwal</h2>
              <p>Senior IVF Specialist with 25+ years of experience and 10,000+ patient journeys guided.</p>
            </div>
          </div>
        </div>
      </section>

      <section className="preconception-section preconception-awards-section">
        <div className="ra-container">
          <div className="ra-section-head">
            <span className="ra-label"><Sparkles size={16} /> Recognition</span>
            <h2>Awards & <em>Recognition</em></h2>
          </div>
          <div className="preconception-awards-grid" aria-label="Awards and recognitions">
            {awardImages.map(([image, alt]) => (
              <figure key={image}>
                <img alt={alt} loading="lazy" src={`${ASSET_PATH}${image}`} />
              </figure>
            ))}
          </div>
        </div>
      </section>

      <section className="ra-section ra-section-blue">
        <div className="ra-container ra-faq">
          <div className="ra-section-head">
            <span className="ra-label">FAQ</span>
            <h2>Frequently Asked <em>Questions</em></h2>
          </div>
          <div className="ra-faq-accordion">
            {faqs.map((item, i) => {
              const open = openFaq === i;
              return (
                <div key={i} className={`ra-faq-item ${open ? 'ra-faq-item--open' : ''}`}>
                  <button className="ra-faq-q" onClick={() => setOpenFaq(open ? null : i)}>
                    <span>{item.title}</span>
                    <span className={`ra-faq-icon ${open ? 'ra-faq-icon--open' : ''}`}>
                      <ChevronDown size={18} />
                    </span>
                  </button>
                  <div className={`ra-faq-a-wrap ${open ? 'ra-faq-a-wrap--open' : ''}`}>
                    <div className="ra-faq-a">{item.text}</div>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </section>

      <RelatedBlogs serviceSlug="preconception" serviceTitle="Preconception Care" />

      <section className="preconception-final-cta">
        <div className="ra-container preconception-final-panel">
          <div>
            <span className="ra-label"><Sparkles size={16} /> Preconception Visit</span>
            <h2>Plan Your Preconception Consultation With Clear Questions.</h2>
            <p>
              Bring your cycle details, medical history, and current questions. The goal is to
              understand what to check now, what can wait, and how to prepare before pregnancy.
            </p>
            <ul className="preconception-consult-badges">
              {consultBadges.map((badge) => (
                <li key={badge}><CheckCircle size={16} /> {badge}</li>
              ))}
            </ul>
          </div>
          <a className="ra-btn ra-btn-primary" href="/book-an-appointment">Book Appointment</a>
        </div>
        <div className="ra-container preconception-contact-strip">
          <a href="tel:+918336968661"><Phone size={16} /> +91 83369 68661</a>
          <a href="mailto:fertilitywithoutborders@gmail.com"><Mail size={16} /> fertilitywithoutborders@gmail.com</a>
          <span><MapPin size={16} /> Renew Healthcare, Kolkata</span>
          <span><Clock size={16} /> Monday-Friday, 9:30 AM - 6:00 PM</span>
        </div>
      </section>
    </div>
  );
}
