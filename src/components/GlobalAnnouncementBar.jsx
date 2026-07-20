import { useEffect, useState } from 'react';
import { useLocation } from 'react-router-dom';
import { Megaphone } from 'lucide-react';
import { getActiveAnnouncement } from '../lib/supabaseBlogAdmin';

function isAdminPath(pathname) {
  return pathname === '/admin' || pathname.startsWith('/admin/');
}

export default function GlobalAnnouncementBar() {
  const location = useLocation();
  const [announcement, setAnnouncement] = useState(null);

  useEffect(() => {
    let active = true;

    async function loadAnnouncement() {
      const row = await getActiveAnnouncement();
      if (active) setAnnouncement(row);
    }

    loadAnnouncement();

    return () => {
      active = false;
    };
  }, []);

  if (isAdminPath(location.pathname) || !announcement?.message) {
    return null;
  }

  const message = announcement.message.trim();
  const barStyle = {
    display: 'block',
    overflow: 'hidden',
    width: '100%',
  };
  const trackStyle = {
    display: 'inline-flex',
    flexWrap: 'nowrap',
    minWidth: '100%',
    width: 'max-content',
    whiteSpace: 'nowrap',
  };
  const groupStyle = {
    display: 'inline-flex',
    flex: '0 0 auto',
    minWidth: '100vw',
  };
  const itemStyle = {
    display: 'inline-flex',
    alignItems: 'center',
    flex: '0 0 auto',
    whiteSpace: 'nowrap',
  };

  const content = (
    <span className="site-announcement-track" style={trackStyle}>
      {[0, 1].map((item) => (
        <span
          className={`site-announcement-set ${item > 0 ? 'site-announcement-set--clone' : ''}`}
          key={item}
          aria-hidden={item > 0}
          style={groupStyle}
        >
          <span className="site-announcement-inner" style={itemStyle}>
            <Megaphone size={17} />
            <span>{message}</span>
          </span>
        </span>
      ))}
    </span>
  );

  if (announcement.linkUrl) {
    return (
      <a className="site-announcement-bar" href={announcement.linkUrl} style={barStyle}>
        {content}
      </a>
    );
  }

  return (
    <div className="site-announcement-bar" style={barStyle}>
      {content}
    </div>
  );
}
