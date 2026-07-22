import React, { useEffect, useState } from 'react';

const COVER_FIT_MAX_RATIO = 1.8;

export default function BlogImage({ fitMode, onLoad, ...props }) {
  const [fit, setFit] = useState(fitMode || 'contain');

  useEffect(() => {
    if (fitMode) {
      setFit(fitMode);
    }
  }, [fitMode]);

  const handleLoad = (event) => {
    const image = event.currentTarget;
    const ratio = image.naturalHeight > 0 ? image.naturalWidth / image.naturalHeight : 0;

    setFit(fitMode || (ratio > 0 && ratio < COVER_FIT_MAX_RATIO ? 'cover' : 'contain'));
    onLoad?.(event);
  };

  return <img {...props} data-fit={fit} onLoad={handleLoad} />;
}
