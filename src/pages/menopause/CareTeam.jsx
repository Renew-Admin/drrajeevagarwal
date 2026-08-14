import { Link } from 'react-router-dom';
import { Activity, Apple, Brain, Dna, HeartPulse, Stethoscope } from 'lucide-react';

import MenopauseLayout from '../../components/menopause/MenopauseLayout';
import MenopauseFaq from '../../components/menopause/MenopauseFaq';

const team = [
  {
    icon: HeartPulse,
    tone: 'amber',
    tag: 'Metabolic health',
    title: 'Obesity and metabolic medicine',
    body: 'For the insulin resistance, weight shift and metabolic changes that accelerate in this decade.',
  },
  {
    icon: Brain,
    tone: 'sage',
    tag: 'Mental health',
    title: 'Counselling',
    body: 'For mood, anxiety and the emotional weight of a transition that is often minimised elsewhere.',
  },
  {
    icon: Activity,
    tone: 'rose',
    tag: 'Movement',
    title: 'Exercise medicine',
    body: 'For the resistance and impact training that protects bone and muscle through the transition.',
  },
  {
    icon: Apple,
    tone: 'amber',
    tag: 'Nutrition',
    title: 'Clinical nutrition',
    body: 'For the dietary foundation that does more than any single supplement.',
  },
  {
    icon: Dna,
    tone: 'sage',
    tag: 'Genetics',
    title: 'Genetics',
    body: 'For family-history-informed risk conversations, including around breast cancer and HRT.',
  },
];

export default function CareTeam({ onBookClick }) {
  return (
    <MenopauseLayout
      pageKey="team"
      onBookClick={onBookClick}
      lede={
        <p>
          Perimenopause touches your hormones, metabolism, mood, muscles and sleep at the same time — so the
          team built around it is not just one specialty.
        </p>
      }
    >
      <article className="mc-card mc-lead-card">
        <span className="mc-tag is-rose"><Stethoscope size={14} /> Clinical lead</span>
        <h2>Dr. Rajeev Agarwal</h2>
        <p className="mc-muted">MBBS, MD (Obstetrics and Gynaecology) — Kasturba Medical College</p>
        <p>
          Over two decades of clinical practice in gynaecology, obstetrics and infertility, including as
          Medical Director of a leading IVF centre from 2005 to 2021. He now practises at Renew Healthcare in
          Kolkata, with memberships including ISAR and ESHRE.
        </p>
        <p className="mc-small">
          <Link to="/about-me">Read the full profile →</Link>
        </p>
      </article>

      <div className="mc-divider"><span>The wider team</span></div>

      <h2 id="wider-team">Who else is involved, and when</h2>
      <div className="mc-cards mc-cards-3">
        {team.map((member) => {
          const Icon = member.icon;
          return (
            <article className="mc-card" key={member.title}>
              <span className={`mc-tag is-${member.tone}`}><Icon size={14} /> {member.tag}</span>
              <h3>{member.title}</h3>
              <p>{member.body}</p>
            </article>
          );
        })}
      </div>

      <div className="mc-callout mc-callout-sage">
        <strong>How referrals actually work here</strong>
        <p>
          You start with a gynaecology consultation. Where a second discipline would genuinely change the plan
          — insulin resistance, low mood, bone loss, a family history that changes the HRT conversation — it is
          brought in around the same plan rather than handed off as a separate problem. See the{' '}
          <Link to="/doctors">clinic team</Link> and the{' '}
          <Link to="/menopause-wellness">menopause wellness service</Link>.
        </p>
      </div>

      <MenopauseFaq pageKey="team" />
    </MenopauseLayout>
  );
}
