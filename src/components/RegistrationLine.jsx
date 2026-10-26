import { DOCTOR_REGISTRATION_LINE } from '../data/doctorRegistration';

export default function RegistrationLine({ className = 'ra-footer-desc ra-footer-reg' }) {
  return <p className={className}>{DOCTOR_REGISTRATION_LINE}</p>;
}
