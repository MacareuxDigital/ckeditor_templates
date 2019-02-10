# concrete5 Add-on: Content Templates for CKEditor

Add a "Content Templates" button to your WYSIWYG editor.

"[Content Templates](https://ckeditor.com/cke4/addon/templates)" is the plugin that provides a dialog to offer predefined content templates.

## Notes

1. You must enable the "Templates" button on "Rich Text Editor" pade in your dashboard.
2. You can change the templates by setting the config value of `sites.default.editor.ckeditor4.custom_config_options.templates_files`.
This value should be an array contain the paths of the templates.
3. If `templates.js` file exists in the active theme, it will be loaded automatically.

## Example of templates.js

```
CKEDITOR.addTemplates( 'default', {
    // The name of sub folder which hold the shortcut preview images of the
    // templates.
    imagesPath: CKEDITOR.getUrl(CCM_REL + '/themes/example/template_images/'),

    // The templates definitions.
    templates: [{
        title: 'Jumbotron',
        image: 'jumbotron.jpg',
        description: 'An example of a template for CKEditor',
        html: '<div class="jumbotron">'
            + '<h1>Hello, world!</h1>'
            + '<p>...</p>'
            + '<p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>'
            + '</div>'
    }]
});
```

## License

MIT License.

"Content Templates" plugin is licensed under GPL or other licenses. Please see the [download page](https://ckeditor.com/cke4/addon/templates).
