const DOCTOR_MAP_EMBED = 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29484.34663639596!2d88.30627107910156!3d22.52131090000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a02773023f59565%3A0xc6346807009ae71f!2sDr.%20Rajeev%20Agarwal!5e0!3m2!1sen!2sin!4v1793265514104!5m2!1sen!2sin';

export default function DoctorMap() {
  return (
    <iframe
      className="doctor-map-embed"
      src={DOCTOR_MAP_EMBED}
      title="Dr. Rajeev Agarwal on Google Maps"
      width="600"
      height="450"
      loading="lazy"
      referrerPolicy="strict-origin-when-cross-origin"
      allowFullScreen
    />
  );
}
