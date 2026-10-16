// ConsentBanner — first-visit privacy choice for drrajeevagarwal.co.in.
// Nothing non-essential is stored until the visitor chooses; the footer
// "Cookie settings" link reopens it (withdrawal is as easy as consent).
import { useEffect, useState } from 'react';
import { OPEN_SETTINGS_EVENT, readConsent, saveConsent } from '../lib/consent';

const box = {
  // Above the header (40-45) but below popups/modals (100+), so it never covers
  // a form the visitor opened; right: 88 keeps the floating buttons clear.
  position: 'fixed', left: 16, right: 88, bottom: 16, zIndex: 90,
  maxWidth: 560, margin: '0 auto', background: '#ffffff', color: '#1f2333',
  borderRadius: 14, boxShadow: '0 10px 40px rgba(32,38,92,.25)', padding: '18px 20px',
  fontSize: 14, lineHeight: 1.5, textAlign: 'left',
};
const row = { display: 'flex', flexWrap: 'wrap', gap: 10, marginTop: 14 };
const btn = {
  flex: '1 1 140px', minHeight: 44, borderRadius: 10, fontWeight: 700, fontSize: 14,
  cursor: 'pointer', border: '1.5px solid #20265C', padding: '10px 14px',
};
const primary = { ...btn, background: '#20265C', color: '#ffffff' };
const secondary = { ...btn, background: '#ffffff', color: '#20265C' };
const label = { display: 'flex', gap: 8, alignItems: 'flex-start' };

export default function ConsentBanner() {
  const [open, setOpen] = useState(false);
  const [showDetails, setShowDetails] = useState(false);
  const [analytics, setAnalytics] = useState(true);
  const [ads, setAds] = useState(false);

  useEffect(() => {
    // Deferred one tick: the prerendered HTML never contains the banner, so
    // visitors who already chose do not see it flash in.
    const first = window.setTimeout(() => {
      if (!readConsent()) setOpen(true);
    }, 0);
    const reopen = () => {
      const current = readConsent();
      setAnalytics(current ? current.analytics === 'granted' : true);
      setAds(current?.ads === 'granted');
      setShowDetails(true);
      setOpen(true);
    };
    window.addEventListener(OPEN_SETTINGS_EVENT, reopen);
    return () => {
      window.clearTimeout(first);
      window.removeEventListener(OPEN_SETTINGS_EVENT, reopen);
    };
  }, []);

  if (!open) return null;

  const choose = (analyticsChoice, adsChoice) => {
    saveConsent({ analytics: analyticsChoice, ads: adsChoice });
    setOpen(false);
  };

  return (
    <div role="dialog" aria-modal="false" aria-labelledby="dra-consent-title" style={box} data-consent-banner="">
      <strong id="dra-consent-title" style={{ fontSize: 15 }}>Your privacy</strong>
      <p style={{ margin: '6px 0 0' }}>
        We use cookies to understand how visitors use this site and to measure our ads. We never send your
        name, contact details or health information to analytics or ad platforms.{' '}
        <a href="/privacy-policy" style={{ color: '#20265C', fontWeight: 600 }}>Privacy policy</a>
      </p>
      {showDetails && (
        <div style={{ marginTop: 12, display: 'grid', gap: 8 }}>
          <label style={label}>
            <input type="checkbox" checked disabled style={{ marginTop: 3 }} />
            <span><b>Essential</b> — needed for the site and forms to work.</span>
          </label>
          <label style={label}>
            <input type="checkbox" checked={analytics} onChange={(e) => setAnalytics(e.target.checked)} style={{ marginTop: 3 }} />
            <span><b>Analytics</b> — anonymous visit statistics (Google Analytics).</span>
          </label>
          <label style={label}>
            <input type="checkbox" checked={ads} disabled={!analytics} onChange={(e) => setAds(e.target.checked)} style={{ marginTop: 3 }} />
            <span><b>Ad measurement</b> — lets us see which ads bring enquiries. No personalised ads.</span>
          </label>
        </div>
      )}
      <div style={row}>
        <button type="button" style={secondary} onClick={() => choose('denied', 'denied')}>Reject non-essential</button>
        {showDetails ? (
          <button type="button" style={primary} onClick={() => choose(analytics ? 'granted' : 'denied', analytics && ads ? 'granted' : 'denied')}>Save choices</button>
        ) : (
          <>
            <button type="button" style={secondary} onClick={() => setShowDetails(true)}>Customise</button>
            <button type="button" style={primary} onClick={() => choose('granted', 'granted')}>Accept all</button>
          </>
        )}
      </div>
    </div>
  );
}
