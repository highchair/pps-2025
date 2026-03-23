const scrollIntoViewHorizontally = (container, child) => {
  const childOffsetLeft = child.offsetLeft;
  const childOffsetRight = childOffsetLeft + child.offsetWidth;
  const containerScrollLeft = container.scrollLeft;
  const containerOffsetRight = containerScrollLeft + container.offsetWidth;

  // If the child is to the left of the visible area, scroll left to align it
  if (containerScrollLeft > childOffsetLeft) {
    container.scrollLeft = childOffsetLeft;
  }
  // If the child is to the right of the visible area, scroll right to align it
  else if (containerOffsetRight < childOffsetRight) {
    container.scrollLeft += childOffsetRight - containerOffsetRight;
  }
};   

document.addEventListener("DOMContentLoaded", () => {
  // All radio selectors
  const container = document.querySelector('.hcd-lightbox-gallery__nav');
  const radios = document.querySelectorAll('.hcd-lightbox-gallery__selector');

  radios.forEach(radio => {
    radio.addEventListener('change', () => {
      // Remove "selected" from any currently selected label
      document
        .querySelectorAll('.hcd-lightbox-gallery__thumb.checked')
        .forEach(el => el.classList.remove('checked'));

      // Find the matching label via [for="id"]
      const matchingLabel = document.querySelector(`label[for="${radio.id}"]`);
      if (matchingLabel) {
        matchingLabel.classList.add('checked');
        scrollIntoViewHorizontally( container, matchingLabel );
        //matchingLabel.scrollLeft({ behavior: 'smooth' });
        // Enhancement: Add the matched element's "for" value to the URL hash
        // When a partial element hash is detected, how that element
      }
    });
  });
});
