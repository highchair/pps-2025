wp.domReady( () => {

  wp.blocks.registerBlockStyle( 'core/button', [
    {
      name: 'primary',
      label: 'Primary',
      isDefault: true,
    },
    {
      name: 'secondary',
      label: 'Secondary',
    }
  ]);
} );