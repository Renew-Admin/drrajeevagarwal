import React, { useState, useEffect } from 'react';
import { useParams, Link } from 'react-router-dom';
import { Calendar, ArrowLeft, Award, GraduationCap, CheckCircle } from 'lucide-react';

const doctorsData = {
  'dr-emily-walker': {
    name: 'Dr. Emily Walker',
    role: 'Senior Consultant Reproductive Medicine',
    degree: 'MBBS, MD, FRCOG (London)',
    exp: '15+ Years Clinical Experience',
    bio: 'Dr. Emily Walker is a globally recognized reproductive endocrinologist specializing in IVF, recurrent pregnancy loss, and poor ovarian reserve. She completed her advanced fellowships in Reproductive Medicine in London and has published multiple peer-reviewed studies on embryo implantation enhancement.',
    expertise: ['In-Vitro Fertilization (IVF)', 'Intracytoplasmic Sperm Injection (ICSI)', 'Recurrent Pregnancy Loss Management', 'Ovarian Rejuvenation (PRP)']
  },
  'dr-olivia-bennett': {
    name: 'Dr. Olivia Bennett',
    role: 'Consultant Gynaecologist & Laparoscopy Specialist',
    degree: 'MBBS, MS (OBGYN), FMAS',
    exp: '10+ Years Clinical Experience',
    bio: 'Dr. Olivia Bennett specializes in advanced keyhole surgeries and laparoscopic therapies for complex gynecological conditions, focusing on tissue-preserving procedures for uterine fibroids, ovarian cysts, and stage-4 endometriosis.',
    expertise: ['Laparoscopic Myomectomy (Fibroid Removal)', 'Endometriosis Excision Surgery', 'Hysteroscopic Septum Resection', 'Minimally Invasive Ovarian Cystectomy']
  },
  'dr-sussie-wolff': {
    name: 'Dr. Sussie Wolff',
    role: 'Clinical Embryologist & IVF Specialist',
    degree: 'M.Sc. Clinical Embryology (UK), Ph.D.',
    exp: '12+ Years Experience',
    bio: 'Dr. Sussie Wolff leads the Embryology Lab at Renew Healthcare. She has spent over 12 years perfecting lab protocols including embryo culture optimization, blastocyst culture, and vitrification, maintaining one of the highest IVF success rates.',
    expertise: ['Blastocyst Culture & Selection', 'Laser-Assisted Hatching', 'Oocyte & Embryo Vitrification', 'Intracytoplasmic Morphologically Selected Sperm Injection (IMSI)']
  },
  'dr-ethan-williams': {
    name: 'Dr. Ethan Williams',
    role: 'Consultant Andrologist & Male Fertility Expert',
    degree: 'MBBS, MS, M.Ch (Urology)',
    exp: '14+ Years Experience',
    bio: 'Dr. Ethan Williams is a specialist urologist and andrologist dedicated to resolving male factor infertility, specializing in sperm DNA fragmentation treatment, micro-TESE procedures, and hormone therapies.',
    expertise: ['Micro-TESE (Sperm Retrieval)', 'Sperm DNA Fragmentation Treatment', 'Varicocele Repair Microsurgery', 'Male Hormone Balancing']
  }
};

export default function DoctorProfile({ onBookClick }) {
  const { slug } = useParams();
  const [doc, setDoc] = useState(null);

  useEffect(() => {
    if (slug) setDoc(doctorsData[slug.trim().replace(/\/$/, '')] || null);
  }, [slug]);

  if (!doc) {
    return (
      <div className="inner-page" style={{ display: 'flex', alignItems: 'center', minHeight: '60vh' }}>
        <div className="ra-container" style={{ textAlign: 'center', maxWidth: 600 }}>
          <h2 style={{ fontWeight: 800, color: 'var(--deep-teal)' }}>Doctor Profile Not Found</h2>
          <p style={{ color: 'var(--text-soft)', marginTop: 8 }}>We apologize, but the profile you are looking for does not exist.</p>
          <Link to="/about-me" className="ra-btn ra-btn-primary" style={{ marginTop: 24 }}>Back to Team</Link>
        </div>
      </div>
    );
  }

  return (
    <div className="inner-page" style={{ background: 'var(--soft-blue)', paddingBottom: 80 }}>
      <div className="ra-container profile-grid" style={{ paddingTop: 40 }}>
        <div className="profile-main">
          <Link to="/about-me" className="article-back"><ArrowLeft size={16} /> Back to Team</Link>
          <h1 className="doctor-name" style={{ fontSize: 'clamp(26px, 3.5vw, 36px)', marginBottom: 6, lineHeight: 1.15 }}>{doc.name}</h1>
          <span className="doctor-role" style={{ fontSize: 13, marginBottom: 24, display: 'block' }}>{doc.role}</span>
          <div style={{ background: 'var(--soft-blue)', border: '1px solid var(--border)', borderRadius: 16, padding: '20px 24px', display: 'flex', flexDirection: 'column', gap: 12, marginBottom: 28 }}>
            <div className="doctor-meta"><GraduationCap size={18} color="var(--deep-teal)" /><span><strong>Qualifications:</strong> {doc.degree}</span></div>
            <div className="doctor-meta"><Award size={18} color="var(--deep-teal)" /><span><strong>Experience:</strong> {doc.exp}</span></div>
          </div>
          <h3 style={{ fontSize: 20, fontWeight: 800, color: 'var(--deep-teal)', marginBottom: 14, borderBottom: '2px solid var(--border)', paddingBottom: 8 }}>Biography</h3>
          <p style={{ fontSize: 15, lineHeight: 1.85, color: 'var(--text-mid)' }}>{doc.bio}</p>
          <h3 style={{ fontSize: 20, fontWeight: 800, color: 'var(--deep-teal)', marginTop: 32, marginBottom: 14, borderBottom: '2px solid var(--border)', paddingBottom: 8 }}>Areas of Expertise</h3>
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(2, 1fr)', gap: 16, marginTop: 16 }}>
            {doc.expertise.map((exp, i) => (
              <div key={i} style={{ display: 'flex', gap: 10, alignItems: 'flex-start', fontSize: 14, lineHeight: 1.4 }}>
                <CheckCircle size={16} color="var(--deep-teal)" style={{ flexShrink: 0, marginTop: 3 }} />
                <span style={{ color: 'var(--text-mid)', fontWeight: 500 }}>{exp}</span>
              </div>
            ))}
          </div>
        </div>
        <div className="profile-sidebar">
          <div className="profile-cta-card">
            <div className="doctor-avatar" style={{ width: 90, height: 90, fontSize: 26 }}>
              {doc.name.split(' ').filter(n => n.includes('.')).length > 0
                ? doc.name.split(' ').slice(1).map(n => n[0]).join('')
                : doc.name.split(' ').map(n => n[0]).join('')}
            </div>
            <h3 style={{ fontSize: 18, fontWeight: 800, color: 'var(--deep-teal)', margin: '16px 0 8px' }}>Consult {doc.name}</h3>
            <p style={{ fontSize: 13, color: 'var(--text-soft)', lineHeight: 1.6, marginBottom: 22 }}>Book an in-person or video consultation with {doc.name} at Renew Healthcare.</p>
            <button className="ra-btn ra-btn-primary" onClick={onBookClick} style={{ width: '100%', borderRadius: 12, display: 'flex', gap: 8, alignItems: 'center', justifyContent: 'center' }}>
              <Calendar size={16} /> Request Consultation
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}
