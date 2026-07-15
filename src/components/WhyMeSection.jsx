import { useEffect, useState } from 'react';
import quoteBg from '../assets/quote-bg.svg';
import googleRatingIcon from '../assets/star-icon.webp';
import t1 from '../assets/testimonial-1.webp';
import t2 from '../assets/testimonial-2.webp';
import t3 from '../assets/testimonial-3.webp';
import t4 from '../assets/testimonial-4.webp';
import t5 from '../assets/testimonial-5.webp';
import t6 from '../assets/testimonial-6.webp';
import whyMeDrDesktop from '../assets/why-me-dr-desktop.webp';
import whyMeDrMobile from '../assets/why-me-dr-mobile.webp';
import whyMeSideDesktop from '../assets/why-me-side-desktop.webp';
import whyMeSideMobile from '../assets/why-me-side-mobile.webp';

const testimonials = [
  { text: "His dedication to women's health goes beyond the clinic. Dr. Rajeev is an inspiration, and I feel lucky to have been under his care.", name: 'Megha Roy', avatar: t1 },
  { text: "He's not just a doctor. He's a healer. Dr. Rajeev treated me with kindness, listened patiently, and guided me every step of the way in my motherhood journey. I'm forever grateful.", name: 'Priya & Kunal Singh', avatar: t2 },
  { text: 'From the first consultation to the final procedure, Dr. Rajeev was professional, reassuring, and deeply knowledgeable. I felt safe and cared for throughout.', name: 'Ananya Sen', avatar: t3 },
  { text: 'After years of failed treatments, meeting Dr. Rajeev changed everything. His personalized care and honest advice led us to the happiest chapter of our lives.', name: 'Farah & Imran Siddiqui', avatar: t4 },
  { text: "What sets Dr. Rajeev apart is his integrity and empathy. He doesn't treat only a condition. He truly understands the emotional journey behind it.", name: 'Shweta Dwivedi', avatar: t5 },
  { text: 'I was nervous about laparoscopic surgery, but Dr. Rajeev explained everything so clearly and made me feel at ease. The recovery was smooth and the results excellent.', name: 'Reena TS', avatar: t6 },
];

function TestimonialCarousel() {
  const [current, setCurrent] = useState(3);
  const [paused, setPaused] = useState(false);

  useEffect(() => {
    if (paused) return undefined;
    const id = setInterval(() => {
      setCurrent(prev => (prev >= testimonials.length - 1 ? 0 : prev + 1));
    }, 5000);
    return () => clearInterval(id);
  }, [paused]);

  return (
    <div className="ra-testimonial-carousel" onMouseEnter={() => setPaused(true)} onMouseLeave={() => setPaused(false)}>
      <div className="ra-testimonial-viewport">
        <div className="ra-testimonial-track" style={{ transform: `translateX(-${current * 100}%)` }}>
          {testimonials.map((t, i) => (
            <div className="ra-testimonial-card" key={i}>
              <div className="ra-testimonial-card-inner">
                <img className="ra-testimonial-quote" src={quoteBg} alt="" aria-hidden="true" />
                <p>{t.text}</p>
                <div className="ra-testimonial-author">
                  <img src={t.avatar} alt={t.name} />
                  <strong>{t.name}</strong>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
      <div className="ra-testimonial-dots">
        {testimonials.map((_, i) => (
          <button key={i} className={i === current ? 'active' : ''} type="button" onClick={() => setCurrent(i)} aria-label={`Testimonial ${i + 1}`} />
        ))}
      </div>
    </div>
  );
}

export default function WhyMeSection() {
  return (
    <section className="ra-section about-why-section">
      <div className="ra-container about-why-layout">
        <div className="about-why-copy">
          <div className="about-why-heading">
            <span className="ra-label">WHY ME?</span>
            <h2>Unique Approach To<br /> Your <em>Health Needs</em></h2>
          </div>
          <TestimonialCarousel />
        </div>

        <div className="about-why-visual">
          <picture className="about-why-photo about-why-photo-main">
            <source media="(max-width: 767px)" srcSet={whyMeDrMobile} />
            <img src={whyMeDrDesktop} alt="Dr. Rajeev Agarwal in consultation room" />
          </picture>

          <div className="about-why-stat about-why-stat-patients">
            <strong>10K</strong>
            <span>happy patients</span>
          </div>

          <div className="about-why-stat about-why-stat-rating">
            <img src={googleRatingIcon} alt="" aria-hidden="true" />
            <strong>4.9</strong>
            <span>google ratings</span>
          </div>

          <picture className="about-why-photo about-why-photo-side">
            <source media="(max-width: 767px)" srcSet={whyMeSideMobile} />
            <img src={whyMeSideDesktop} alt="Dr. Rajeev Agarwal portrait" />
          </picture>
        </div>
      </div>
    </section>
  );
}
