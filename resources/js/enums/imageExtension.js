export const ImageExtension = Object.freeze({
  JPG: 'jpg',
  PNG: 'png',
  GIF: 'gif',
  JPEG: 'jpeg',
  TIF: 'tif',
  WEBP: 'webp',
  SVG: 'svg',
});

export const getAll = () => {
  return Object.values(ImageExtension);
};
