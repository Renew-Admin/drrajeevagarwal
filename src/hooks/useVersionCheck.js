import { useEffect, useRef } from 'react';

const buildVersion = import.meta.env.VITE_APP_VERSION || null;

function reloadWithCacheBust(version) {
  try {
    const storageKey = `drrajeev:version-reload:${version}`;
    if (sessionStorage.getItem(storageKey) === '1') return;
    sessionStorage.setItem(storageKey, '1');
  } catch {
    // Some privacy modes block sessionStorage; reload anyway in that case.
  }

  const url = new URL(window.location.href);
  url.searchParams.set('__site_version', version);
  window.location.replace(url.toString());
}

export function useVersionCheck(intervalMs = 60000) {
  const currentVersion = useRef(buildVersion);

  useEffect(() => {
    const checkVersion = async () => {
      try {
        const res = await fetch(`/version.json?t=${Date.now()}`, {
          cache: 'no-store',
        });

        if (!res.ok) return;

        const data = await res.json();
        if (!data.version) return;

        if (currentVersion.current === null) {
          currentVersion.current = data.version;
          return;
        }

        if (data.version !== currentVersion.current) {
          reloadWithCacheBust(data.version);
        }
      } catch {
        // Network/cache failures should not interrupt normal site usage.
      }
    };

    checkVersion();
    const id = setInterval(checkVersion, intervalMs);
    return () => clearInterval(id);
  }, [intervalMs]);
}
