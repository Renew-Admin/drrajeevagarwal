
/** A lazily-loaded YouTube embed with its caption, used across the section. */
export default function VideoCard({ video, compact = false }) {
  return (
    <figure className={`mc-video${compact ? ' is-compact' : ''}`}>
      <div className="mc-video-frame">
        <iframe
          src={`https://www.youtube.com/embed/${video.id}`}
          title={video.title}
          loading="lazy"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowFullScreen
        />
      </div>
      <figcaption>
        <h3>{video.title}</h3>
        <p>{video.blurb}</p>
      </figcaption>
    </figure>
  );
}
