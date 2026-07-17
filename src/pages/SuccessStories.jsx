import { useState } from 'react';
import { Play, Baby, HeartPulse, Award, Users, Quote } from 'lucide-react';
import useSeo from '../utils/useSeo';
import { getMetaForPath } from '../utils/seoMeta';
import ssHero from '../assets/ss-hero.webp';
import ssPinakpani from '../assets/ss-pinakpani.webp';
import ssZaheda from '../assets/ss-zaheda.webp';
import ssPillay from '../assets/ss-p-pillay.webp';
import ssShreha from '../assets/ss-shreha.webp';
import ssPragya from '../assets/ss-pragya.webp';
import ssKirti from '../assets/ss-kirti.webp';
import ssGurleen from '../assets/ss-gurleen.webp';
import ssSweta from '../assets/ss-sweta.webp';
import ssPooja from '../assets/ss-pooja.webp';
import ssDevpriya from '../assets/ss-devpriya.webp';

const pacientes = [
  {
    name: 'Pinakpani Mazumder',
    image: ssPinakpani,
    text: 'We were married for five years, but due to my wife\'s gynaecological related problems, she was unable to conceive for years. We went to many renowned medical practitioners, took reproductive medicines and other treatments, but it was all in vain. Finally, last year after going through some reviews of Rajeev Sir, we took an appointment, and met him in his chamber in Care IVF. He is polite, caring and very supportive from the very beginning. We felt very happy after meeting him, and decided to do my wife\'s pregnancy related treatment there. After a series of tests my wife\'s embryo transfer took place on the first week of Jan-2020, and all these months she was under the supervision of Dr.Rajeev Agarwal, who with his extensive experience did and instructed what is needed for my wife in the best possible way. Finally, in the last week of August-2020, Rajeev Sir operated my wife, and we were blessed with healthy twin babies, one boy, and a girl. Rajeev Sir is outstanding, and the best IVF specialist, and obstetrician that I have known or seen.'
  },
  {
    name: 'Zaheda Tarannum',
    image: ssZaheda,
    text: 'I went to Dr. Rajeev Agarwal for IVF treatment with no hope as other fertility center did not entertain me. My husband contacted him through mail and he answered with yes. But I was nervous. And when I met him and his team, as if I got a new life. I asked one thing — are you treating me? And he said we are starting treatment. His team Dr. Ruby Yadav and center in charge Mithu are very supportive. They take care of everything more than patients themselves. During the treatment I was diagnosed with polyp. Dr. Rajeev said he will remove it during the course. So my ovum pick up and Hysteroscopy were done. It was so smooth that after coming from OT I had no hangover and right from there I was doing my daily work. Staff and nurses are very cordial and competent.'
  },
  {
    name: 'P Pillay',
    image: ssPillay,
    text: 'My experience with doctor Rajeev has been amazing. We delivered a nice and healthy baby by God\'s grace, all thanks to Sir. Right from reception, to scan unit, everyone is very helpful. We would like to thank Sir, for the best gift in our life.'
  },
  {
    name: 'Shreha Sanganeria',
    image: ssShreha,
    text: 'I heard a lot about Dr. Rajeev and decided to consult him for my pregnancy and trust me the very first time we met him we realised why people say such great things about him. The way he treats you and takes care of your each and every parameter of health is just outstanding. During my 8th month of pregnancy I suddenly got very high BP issue so on doctor\'s recommendation had to get hospitalised immediately. The day I got admitted Dr. Rajeev made sure that I am getting the immediate treatment in the hospital and when things got little off hand and he had to get me shifted to ICU, Dr. Rajeev didn\'t even wait for the lift to reach ICU and ran through stairs to make all the arrangements. The very next day he decided to get me operated and even though we didn\'t have any previous booking in the hospital he made sure all arrangements are done. Finally because of him both me and my daughter who was born on 8th April are fine and sound.'
  },
  {
    name: 'Pragya Jain',
    image: ssPragya,
    text: 'I really can\'t thank Dr. Agarwal and the entire Renew Healthcare team enough for being our companion in this journey. Dr. Agarwal is really an exceptional doctor whose care for his patients is very visible in the way he treats each of them. He was really patient with me and shared very clearly the approach through my pregnancy and IVF journey which gave me clarity on what to expect. In spite of all the complications, everything finally went smooth for my husband and me thanks to Dr. Agarwal\'s experience and exceptional knowledge. An added advantage of getting most of the tests done in-house and in one place was super helpful and calming for me. Would highly recommend Renew Healthcare to other couples for their pregnancy journey.'
  },
  {
    name: 'Kirti Sharma',
    image: ssKirti,
    text: 'Dr. Rajeev is one of the finest human being and doctor I have come across. Being a doctor myself I know that 9 months of pregnancy has lots of ups and downs and things get difficult when you are working.. but the fact that he always maintained calm with a smile on his face and always encouraging me to continue working kept my spirits high! Thank you Rajeev Sir for a smooth journey throughout my pregnancy and delivery!'
  },
  {
    name: 'Gurleen Sachdeva',
    image: ssGurleen,
    text: 'Dr. Rajeev Agarwal and his team are outstanding. They make sure that your journey at Renew is smooth and comforting. Their knowledge and calm demeanour makes you feel confident and at ease throughout. The postpartum care is equally excellent with attentive follow up and support.'
  },
  {
    name: 'Sweta Agarwal',
    image: ssSweta,
    text: 'This was my second baby under Dr Rajeev.. both were normal deliveries. He is always calm and composed and takes utmost care of everything the patient is facing. Sir and his entire team were so supporting throughout the pregnancy. I will be forever grateful to the Renew team.'
  },
  {
    name: 'Pooja Mehta',
    image: ssPooja,
    text: 'My pregnancy journey with Renew was so smooth. I hadn\'t imagined the journey to be so easy. Dr Rajeev and the entire Renew team made pregnancy feel like a cake walk. Sir is really approachable and was available for me every time I needed help. Managed a normal delivery only because the entire team was so supportive. The best part is that everything we need during the journey including doctor consultations, medicines, scans, blood tests, prenatal yoga and meditation etc are all available under one roof. Being a doctor myself — it was because of the entire team that I managed to work every single day of my pregnancy too.'
  },
  {
    name: 'Devpriya Singhania',
    image: ssDevpriya,
    text: 'My experience with Dr Rajeev and the whole team of Renew Healthcare has been great. Dr Rajeev made sure I was at ease, whenever I felt nervous or anxious. He always used to smile and tell me that he will take care of everything. And he definitely did! He always answered all my questions very patiently. Even queries over WhatsApp were answered promptly. Dr Rajeev\'s close monitoring, regular follow ups made my pregnancy journey very smooth and easy and helped to avoid any complications. I highly recommend Dr Rajeev and Renew for your fertility and pregnancy journey.'
  }
];

const stats = [
  { icon: Users, value: '10k+', label: 'Patients Served' },
  { icon: HeartPulse, value: '99.5%', label: 'Happy Patients' },
  { icon: Award, value: '25+', label: 'Years of Experience' },
  { icon: Baby, value: '70%', label: 'IVF Success Rate' },
];

const videos = [
  { id: '03H2gLBLUHY', title: 'Patient Testimonial' },
  { id: '-xrPLlMc4dw', title: 'Patient Experience Short' },
  { id: 'cEoAa5159p4', title: 'Success Story Short' },
  { id: 'ZIOyJuCiap8', title: 'Fertility Journey Short' },
  { id: 'XVxy_BmPeeM', title: 'Patient Story Short' },
  { id: '12LCASXxv30', title: 'IVF Success Short' },
];

const successStoriesSeo = {
  ...getMetaForPath('/success-stories'),
  canonicalUrl: 'https://drrajeevagarwal.co.in/success-stories',
};

export default function SuccessStories({ onBookClick }) {
  useSeo(successStoriesSeo);
  const [playing, setPlaying] = useState(null);
  const [videoIdx, setVideoIdx] = useState(0);
  const maxV = videos.length - 1;

  return (
    <div className="success-stories-page">
      <section className="about-hero-image-section">
        <div className="about-hero-image-wrap">
          <img src={ssHero} alt="Success Stories" />
          <div className="about-hero-image-overlay">
            <div className="ra-container about-hero-image-content">
              <h1>
                <span style={{ color: '#fff' }}>Success </span>
                <span className="heading-gold">Stories</span>
              </h1>
              <p className="about-hero-image-sub">Real journeys of hope, care, and parenthood with Dr. Rajeev Agarwal.</p>
              <div className="about-hero-image-actions">
                <button className="ra-btn ra-btn-primary" type="button" onClick={onBookClick}>
                  Request an Appointment
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section className="ss-patients-section">
        <div className="ra-container">
          <div className="ra-section-head">
            <span className="ra-label">TESTIMONIALS</span>
            <h2>Testimonials that illuminate the impact of <em>my commitment</em></h2>
          </div>
          <div className="ss-patients-grid">
            {pacientes.map((p, i) => (
              <div className="ss-tcard" key={i}>
                <span className="ss-tcard-quote">
                  <Quote size={22} />
                </span>
                <div className="ss-tcard-text">
                  <p>{p.text}</p>
                </div>
                <div className="ss-tcard-author">
                  <div className="ss-tcard-img-wrap">
                    <img src={p.image} alt={p.name} />
                  </div>
                  <strong>{p.name}</strong>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className="ss-stats-section">
        <div className="ra-container">
          <div className="ss-stats-grid">
            {stats.map(({ icon: Icon, value, label }, i) => (
              <div className="ss-stat-card" key={i}>
                <span className="ss-stat-icon"><Icon size={32} /></span>
                <span className="ss-stat-value">{value}</span>
                <span className="ss-stat-label">{label}</span>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className="ss-videos-section">
        <div className="ra-container">
          <div className="ra-section-head">
            <span className="ra-label">TESTIMONIALS</span>
            <h2>Video <em>Success Stories</em></h2>
          </div>
          <div className="ss-video-carousel">
            <div className="ss-video-track" style={{ transform: `translateX(-${videoIdx * 280}px)` }}>
              {videos.map((v, i) => (
                <div className="ss-video-card" key={i}>
                  {playing === i ? (
                    <iframe
                      src={`https://www.youtube.com/embed/${v.id}?autoplay=1&rel=0&modestbranding=1`}
                      title={v.title}
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                      allowFullScreen
                      className="ss-video-frame"
                    />
                  ) : (
                    <button
                      className="ss-video-cover"
                      type="button"
                      onClick={() => setPlaying(i)}
                      aria-label={`Play ${v.title}`}
                    >
                      <img
                        src={`https://img.youtube.com/vi/${v.id}/hqdefault.jpg`}
                        alt={v.title}
                        loading="lazy"
                      />
                      <span className="ss-video-play" aria-hidden="true">
                        <span className="ss-shorts-icon">
                          <svg width="20" height="24" viewBox="0 0 20 24" fill="none">
                            <rect x="1" y="2" width="18" height="20" rx="4" stroke="currentColor" strokeWidth="2"/>
                            <polygon points="8,7 15,12 8,17" fill="currentColor"/>
                          </svg>
                        </span>
                      </span>
                    </button>
                  )}
                </div>
              ))}
            </div>
            <button className="ss-carousel-arrow ss-carousel-prev" type="button" onClick={() => setVideoIdx(Math.max(0, videoIdx - 1))} disabled={videoIdx === 0} aria-label="Previous">
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M12 4L6 10L12 16" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/></svg>
            </button>
            <button className="ss-carousel-arrow ss-carousel-next" type="button" onClick={() => setVideoIdx(Math.min(maxV, videoIdx + 1))} disabled={videoIdx === maxV} aria-label="Next">
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M8 4L14 10L8 16" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"/></svg>
            </button>
          </div>
        </div>
      </section>
    </div>
  );
}
