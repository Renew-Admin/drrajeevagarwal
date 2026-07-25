import { useEffect, useState } from 'react';
import { X } from 'lucide-react';
import { useLocation, useNavigate } from 'react-router-dom';
import desktopPopupImage from '../assets/Website Pop-up (Desktop) (V2).jpg.jpeg';
import mobilePopupImage from '../assets/Website Pop-up (Mobile) (V1).jpg.jpeg';
import { getActivePromotionPopup } from '../lib/supabaseBlogAdmin';

function isAdminPath(pathname) {
  return pathname === '/admin' || pathname.startsWith('/admin/');
}

function isExternalUrl(value) {
  return /^https?:\/\//i.test(value || '');
}

export default function GlobalPromotionPopup() {
  const location = useLocation();
  const navigate = useNavigate();
  const [popup, setPopup] = useState(null);
  const [isOpen, setIsOpen] = useState(false);
  const [loadedVisitId, setLoadedVisitId] = useState(null);
  const visitId = location.key || location.pathname;

  useEffect(() => {
    let active = true;
    let triggered = false;

    const triggerPopup = async () => {
      if (!active || triggered || location.pathname !== '/') return;
      triggered = true;

      const settings = await getActivePromotionPopup({
        desktopImageUrl: desktopPopupImage,
        mobileImageUrl: mobilePopupImage,
      });

      if (active && settings?.enabled) {
        setPopup(settings);
        setLoadedVisitId(visitId);
        setIsOpen(true);
      }
    };

    const checkScrollPosition = () => {
      const hero = document.querySelector('.ra-hero');
      const heroBottom = hero?.getBoundingClientRect().bottom ?? window.innerHeight;
      const triggerLine = window.innerHeight * 0.65;

      // Keep the hero unobstructed. Trigger only after the next section starts
      // entering the viewport and the user has engaged with the page.
      if (heroBottom <= triggerLine) triggerPopup();
    };

    if (location.pathname !== '/') return undefined;

    window.addEventListener('scroll', checkScrollPosition, { passive: true });
    const restoreScrollTimer = window.setTimeout(checkScrollPosition, 1200);

    return () => {
      active = false;
      window.clearTimeout(restoreScrollTimer);
      window.removeEventListener('scroll', checkScrollPosition);
    };
  }, [location.pathname, visitId]);

  useEffect(() => {
    if (!isOpen) return undefined;

    const handleKeyDown = (event) => {
      if (event.key === 'Escape') setIsOpen(false);
    };

    document.addEventListener('keydown', handleKeyDown);
    document.body.classList.add('promotion-popup-open');
    return () => {
      document.removeEventListener('keydown', handleKeyDown);
      document.body.classList.remove('promotion-popup-open');
    };
  }, [isOpen]);

  if (isAdminPath(location.pathname) || location.pathname !== '/' || loadedVisitId !== visitId || !isOpen || !popup) return null;

  const handleClick = (event) => {
    const url = popup.clickUrl || '/preconception';
    if (!isExternalUrl(url) && url.startsWith('/')) {
      event.preventDefault();
      setIsOpen(false);
      navigate(url);
    }
  };

  return (
    <div className="promotion-popup-backdrop" role="presentation" onMouseDown={(event) => {
      if (event.target === event.currentTarget) setIsOpen(false);
    }}>
      <div className="promotion-popup" role="dialog" aria-modal="true" aria-label="Website promotion">
        <button
          type="button"
          className="promotion-popup-close"
          aria-label="Close promotion"
          title="Close promotion"
          onClick={() => setIsOpen(false)}
        >
          <X size={22} strokeWidth={2.5} />
        </button>
        <a href={popup.clickUrl || '/preconception'} onClick={handleClick} className="promotion-popup-link">
          <picture>
            <source media="(max-width: 640px)" srcSet={popup.mobileImageUrl || mobilePopupImage} />
            <img src={popup.desktopImageUrl || desktopPopupImage} alt="Preconception care promotion" />
          </picture>
        </a>
      </div>
    </div>
  );
}
