import React from 'react';
import { Link } from 'react-router-dom';
import { Award, GraduationCap, ArrowRight } from 'lucide-react';

const doctorsList = [
  { name: 'Dr. Emily Walker', slug: 'dr-emily-walker', role: 'Senior Consultant Reproductive Medicine', degree: 'MBBS, MD, FRCOG (London)', exp: '15+ Years Experience' },
  { name: 'Dr. Olivia Bennett', slug: 'dr-olivia-bennett', role: 'Consultant Gynaecologist & Laparoscopy Specialist', degree: 'MBBS, MS (OBGYN), FMAS', exp: '10+ Years Experience' },
  { name: 'Dr. Sussie Wolff', slug: 'dr-sussie-wolff', role: 'Clinical Embryologist & IVF Specialist', degree: 'M.Sc. Clinical Embryology (UK), Ph.D.', exp: '12+ Years Experience' },
  { name: 'Dr. Ethan Williams', slug: 'dr-ethan-williams', role: 'Consultant Andrologist & Male Fertility Expert', degree: 'MBBS, MS, M.Ch (Urology)', exp: '14+ Years Experience' },
];

export default function Doctors() {
  return (
    <div className="inner-page">
      <section className="inner-hero">
        <div className="ra-container">
          <span className="tag tag-yellow">Renew Healthcare Team</span>
          <h1>Meet Our Fertility & Gynaecology Experts</h1>
          <p>Dedicated specialists combining decades of clinical excellence with personalized patient care.</p>
        </div>
      </section>

      <section className="inner-section inner-section-blue">
        <div className="ra-container">
          <div className="doctor-grid">
            {doctorsList.map((doc, i) => (
              <div key={i} className="doctor-card">
                <div className="doctor-avatar">
                  {doc.name.split(' ').filter(n => n.includes('.')).length > 0
                    ? doc.name.split(' ').slice(1).map(n => n[0]).join('')
                    : doc.name.split(' ').map(n => n[0]).join('')}
                </div>
                <div className="doctor-info">
                  <h3 className="doctor-name">{doc.name}</h3>
                  <span className="doctor-role">{doc.role}</span>
                  <div className="doctor-meta"><GraduationCap size={16} /><span>{doc.degree}</span></div>
                  <div className="doctor-meta"><Award size={16} /><span>{doc.exp}</span></div>
                  <Link to={`/doctors/${doc.slug}`} className="ra-btn ra-btn-soft" style={{ marginTop: 16, alignSelf: 'flex-start', height: 42, fontSize: 13, borderRadius: 12, padding: '0 20px' }}>
                    View Professional Profile <ArrowRight size={14} style={{ marginLeft: 6 }} />
                  </Link>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
    </div>
  );
}
