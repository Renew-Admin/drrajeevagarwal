// consent — the visitor's analytics/ads choice, stored first-party and mirrored
// into Google Consent Mode v2. Defaults (all denied) are set in index.html
// before gtag loads. ad_personalization is never granted.
export const CONSENT_KEY = 'dra_consent';
export const CONSENT_VERSION = 1;
export const CONSENT_EVENT = 'dra:consent-change';
export const OPEN_SETTINGS_EVENT = 'dra:open-consent-settings';

export function readConsent() {
  if (typeof window === 'undefined') return null;
  try {
    const value = JSON.parse(window.localStorage.getItem(CONSENT_KEY) || 'null');
    return value && value.v === CONSENT_VERSION ? value : null;
  } catch {
    return null;
  }
}

export function consentSignals(choice) {
  const analytics = choice?.analytics === 'granted' ? 'granted' : 'denied';
  const ads = analytics === 'granted' && choice?.ads === 'granted' ? 'granted' : 'denied';
  return { analytics_storage: analytics, ad_storage: ads, ad_user_data: ads, ad_personalization: 'denied' };
}

export function saveConsent({ analytics, ads }) {
  const choice = {
    v: CONSENT_VERSION,
    analytics: analytics === 'granted' ? 'granted' : 'denied',
    ads: analytics === 'granted' && ads === 'granted' ? 'granted' : 'denied',
    at: new Date().toISOString(),
  };
  try {
    window.localStorage.setItem(CONSENT_KEY, JSON.stringify(choice));
  } catch {
    /* storage blocked — the choice still applies for this page view */
  }
  try {
    if (typeof window.gtag === 'function') window.gtag('consent', 'update', consentSignals(choice));
  } catch {
    /* never break the page */
  }
  window.dispatchEvent(new CustomEvent(CONSENT_EVENT, { detail: choice }));
  return choice;
}

export function openConsentSettings() {
  window.dispatchEvent(new Event(OPEN_SETTINGS_EVENT));
}
