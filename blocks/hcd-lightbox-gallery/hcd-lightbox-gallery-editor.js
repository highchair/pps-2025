(function(blocks, element, editor, components) {
  var el = element.createElement;
  var MediaUpload = editor.MediaUpload;
  var Button = components.Button;

  blocks.registerBlockType('hcd-lightbox-gallery/lightbox-gallery', {
    title: 'Lightbox Gallery',
    icon: 'format-gallery',
    category: 'media',
    attributes: {
      images: { type: 'array', default: [] }
    },
    edit: function(props) {
      var images = props.attributes.images || [];

      function onSelectImages(newImages) {
        props.setAttributes({ images: newImages.map(function(img) {
          return { id: img.id, url: img.url, alt: img.alt };
        })});
      }

      return el('div', { className: 'hcd-lightbox-gallery-editor' },
        el(MediaUpload, {
          onSelect: onSelectImages,
          allowedTypes: ['image'],
          multiple: true,
          gallery: true,
          value: images.map(function(img){ return img.id; }),
          render: function(obj) {
            return el(Button, { onClick: obj.open, variant: 'primary' },
              images.length ? 'Edit Gallery' : 'Select Images'
            );
          }
        }),
        images.length > 0 && el('div', { className: 'hcd-gallery-preview' },
          images.map(function(img) {
            return el('img', { key: img.id, src: img.url, alt: img.alt });
          })
        )
      );
    },
    save: function() { return null; } // rendered via PHP
  });
})(window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.components);
