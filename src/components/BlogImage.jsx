export default function BlogImage({ fitMode, style, src, ...props }) {
  const backgroundImage = src
    ? `linear-gradient(rgba(238, 242, 248, 0.32), rgba(238, 242, 248, 0.32)), url(${JSON.stringify(src)})`
    : undefined;

  return (
    <img
      {...props}
      src={src}
      data-fit={fitMode || 'contain'}
      style={{ backgroundImage, backgroundSize: 'cover', backgroundPosition: 'center', ...style }}
    />
  );
}
