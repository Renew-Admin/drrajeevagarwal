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

  const content = (
    <span className="site-announcement-track">
      {Array.from({ length: 8 }, (_, item) => (
        <span className="site-announcement-inner" key={item} aria-hidden={item > 0}>
          <Megaphone size={17} />
          <span>{announcement.message}</span>
        </span>
      ))}
    </span>
  );

  if (announcement.linkUrl) {
    return (
      <a className="site-announcement-bar" href={announcement.linkUrl}>
        {content}
      </a>
    );
  }

  return (
    <div className="site-announcement-bar">
      {content}
    </div>
  );
}
