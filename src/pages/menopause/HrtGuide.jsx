import { Link } from 'react-router-dom';

import MenopauseLayout from '../../components/menopause/MenopauseLayout';
import MenopauseFaq from '../../components/menopause/MenopauseFaq';
import VideoCard from '../../components/menopause/VideoCard';
import { MENOPAUSE_VIDEOS } from '../../data/menopauseCare';

const sideNav = [
  { id: 'what-is-it', label: 'What it is' },
  { id: 'what-happened', label: 'What actually happened' },
  { id: 'safety', label: 'Is it safe' },
  { id: 'routes', label: 'How it is taken' },
  { id: 'duration', label: 'How long' },
  { id: 'risks', label: 'Risks in real numbers' },
  { id: 'alternatives', label: 'Non-hormonal options' },
  { id: 'faq', label: 'FAQ' },
];

const suitability = [
  ['Premature or early menopause — HRT is strongly recommended here', 'Personal history of breast cancer'],
  ['Bothersome vasomotor symptoms under 60 or within 10 years of menopause', 'Unexplained vaginal bleeding'],
  ['Bone protection when started at the right time', 'Active or past blood clot (VTE)'],
  ['Genitourinary symptoms, often via local rather than systemic therapy', 'Active liver disease'],
];

const hrtVideo = MENOPAUSE_VIDEOS.find((video) => video.id === 'l_3Qv8OUNqQ');
const fearVideo = MENOPAUSE_VIDEOS.find((video) => video.id === 'fHpiDpnxtbE');

export default function HrtGuide({ onBookClick }) {
  return (
    <MenopauseLayout
      pageKey="hrt"
      onBookClick={onBookClick}
      sideNav={sideNav}
      lede={
        <p>
          "Do not fear hormones. Fear the lack of good information." This page covers what HRT/MHT is, what
          actually happened after 2002, how it is taken, and what the real numbers say — at the molecule level,
          not by brand.
        </p>
      }
    >
      <h2 id="what-is-it">What is HRT / MHT?</h2>
      <p>
        You will see this called both HRT (hormone replacement therapy) and MHT (menopausal hormone therapy).
        MHT is the term current guidelines prefer, but HRT is still what most people search for, so this page
        uses both. Either way, it means replacing the estrogen — and, if you still have a uterus, a partnering
        progestogen — that your ovaries are producing less of during the transition.
      </p>
      <p>
        It can help with hot flashes and night sweats, sleep problems, mood swings, brain fog, vaginal dryness,
        bone protection, muscle strength and skin changes. It is not automatically right for everyone, and it
        is not a single product — it is a category of treatment that gets individualised to you.
      </p>

      {hrtVideo && <VideoCard video={hrtVideo} compact />}

      <h2 id="what-happened">What actually happened with HRT</h2>
      <p>HRT was never banned. What happened is more specific — and more fixable — than that.</p>
      <p>
        In 2002, the Women's Health Initiative (WHI), a large US trial launched in 1991, published results that
        were widely reported as "HRT causes breast cancer and heart disease". Prescribing collapsed almost
        overnight, worldwide, and has never fully recovered. But the trial had real limitations that took years
        to become widely understood:
      </p>
      <ul className="mc-list">
        <li>
          The progestin used was medroxyprogesterone acetate — a synthetic progestin now known to carry a worse
          risk profile than the micronised progesterone commonly used today.
        </li>
        <li>
          Participants were on average 63 years old and more than 12 years past menopause — much older than the
          women who typically start HRT for menopausal symptoms.
        </li>
        <li>
          In the estrogen-alone arm (women without a uterus), 20-year follow-up data actually showed a{' '}
          <strong>reduced</strong> breast cancer risk and reduced breast cancer mortality — a finding that got
          far less coverage than the original headlines.
        </li>
      </ul>
      <p>
        Since then the evidence base has matured considerably. In November 2025 the US FDA announced the
        removal of the boxed warning from estrogen-containing menopausal hormone therapy products — a label
        that had shaped two decades of prescribing caution. Current guidance from menopause societies supports
        individualised HRT use rather than blanket avoidance.
      </p>

      {fearVideo && <VideoCard video={fearVideo} compact />}

      <h2 id="safety">Is it safe? Who is it for?</h2>
      <p>
        For most women under 60, or within 10 years of menopause, the risk-benefit balance for HRT is generally
        favourable — this is sometimes called the "window of opportunity". Outside that window the calculation
        changes and needs individual review.
      </p>
      <div className="mc-table-wrap">
        <table className="mc-table">
          <thead>
            <tr><th scope="col">Generally favourable</th><th scope="col">Needs careful individual review</th></tr>
          </thead>
          <tbody>
            {suitability.map(([yes, caution]) => (
              <tr key={yes}><td>{yes}</td><td>{caution}</td></tr>
            ))}
          </tbody>
        </table>
      </div>
      <p className="mc-small mc-muted">
        This table is a starting orientation, not a substitute for your own history being reviewed
        individually.
      </p>

      <h2 id="routes">How is it actually taken?</h2>
      <p>Estrogen comes in several delivery forms, and the route matters clinically — not just for convenience:</p>
      <ul className="mc-list">
        <li>
          <strong>Oral</strong> — a daily tablet. Simple, but it passes through the liver first, which is part
          of why it carries a higher clot and stroke risk than transdermal routes.
        </li>
        <li>
          <strong>Transdermal (gel, patch or spray)</strong> — absorbed through the skin, bypassing the liver.
          Associated with more stable hormone levels and, importantly, without the increased clot and stroke
          risk seen with oral estrogen.
        </li>
        <li>
          <strong>Vaginal (cream, tablet or ring)</strong> — for genitourinary symptoms specifically. Delivers
          estrogen locally with minimal absorption elsewhere, so a progestogen partner is usually not needed at
          these doses.
        </li>
      </ul>
      <p>
        If you still have a uterus, estrogen needs to be paired with a progestogen — either micronised
        progesterone or a synthetic progestogen such as dydrogesterone — to protect the uterine lining. Women
        who have had a hysterectomy can generally take estrogen alone.
      </p>
      <div className="mc-callout mc-callout-amber">
        <strong>How you use the product matters</strong>
        <p>
          Application technique for gels and patches genuinely affects how well they work. See the{' '}
          <Link to="/menopause-care/articles-and-videos">video library</Link> for Dr. Agarwal's walkthroughs,
          and always confirm technique at your consultation.
        </p>
      </div>

      <h2 id="duration">How long should it continue?</h2>
      <p>
        As a general starting point: continue until at least the average age of natural menopause (around 50 to
        51), then reassess. For bone or heart protection, or in premature or early menopause, longer use can be
        appropriate — this is individualised and reviewed periodically rather than decided once.
      </p>

      <h2 id="risks">Risks, in real numbers</h2>
      <p>
        Headlines tend to report <em>relative</em> risk, which sounds dramatic in isolation and means very
        little without the <em>absolute</em> risk it is built on. For most healthy women starting HRT within 10
        years of menopause, the absolute increase in breast cancer risk is small, and for estrogen-alone
        therapy long-term data actually shows a reduction. The real, individual numbers — including your own
        history — are something to work through in a consultation, not to estimate from a general chart.
      </p>

      <h2 id="alternatives">If HRT is not right for you</h2>
      <p>
        Non-hormonal options exist for many symptoms — certain non-hormonal medications for hot flashes,
        vaginal moisturisers and lubricants for dryness, cognitive behavioural approaches for sleep and mood,
        and the lifestyle foundations on the{' '}
        <Link to="/menopause-care/diet-exercise-and-lifestyle">diet, exercise and lifestyle page</Link>, which
        matter regardless of whether you take HRT. Which tests inform that decision is covered under{' '}
        <Link to="/menopause-care/tests-and-diagnostics">tests and diagnostics</Link>.
      </p>

      <MenopauseFaq pageKey="hrt" />
    </MenopauseLayout>
  );
}
