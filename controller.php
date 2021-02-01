<?php
namespace Concrete\Package\CkeditorTemplates;

use Concrete\Core\Asset\AssetList;
use Concrete\Core\Editor\EditorInterface;
use Concrete\Core\Editor\Plugin;
use Concrete\Core\Package\Package;
use Concrete\Core\Page\Theme\Theme;
use Concrete\Core\Site\Config\Liaison;

class Controller extends Package
{
    protected $pkgHandle = 'ckeditor_templates';
    protected $pkgVersion = '0.1.1';
    protected $appVersionRequired = '8.0';

    /**
     * @inheritDoc
     */
    public function getPackageName()
    {
        return t('Content Templates for CKEditor');
    }

    /**
     * @inheritDoc
     */
    public function getPackageDescription()
    {
        return t('Add a Template button to your WYSIWYG editor.');
    }

    public function install()
    {
        $plugin_js_file = $this->getPackagePath() . '/js/templates/plugin.js';
        if (!file_exists($plugin_js_file)) {
            throw new \Exception(t('Content Templates plugin not found. Please download the plugin from %s, then upload the contents in %s.', 'https://ckeditor.com/cke4/addon/templates', '/packages/ckeditor_templates/js/templates'));
        }

        return parent::install();
    }

    public function on_start()
    {
        if (!Application::isRunThroughCommandLineInterface()) {
            $assetList = AssetList::getInstance();
            $assetList->register(
                'javascript',
                'editor/ckeditor4/templates',
                'js/register.js',
                [],
                $this->getPackageHandle()
            );

            /** @var EditorInterface $editor */
            $editor = $this->app->make(EditorInterface::class);
            $pluginManager = $editor->getPluginManager();
            try {
                $plugin = new Plugin();
                $plugin->setKey('templates');
                $plugin->setName(t('Templates'));
                $plugin->requireAsset('javascript', 'editor/ckeditor4/templates');
                $pluginManager->register($plugin);
            } catch (\Exception $e) {
            }

            /** @var Liaison $config */
            $config = $this->app->make('site')->getDefault()->getConfigRepository();
            $templates_files = $config->get('editor.ckeditor4.custom_config_options.templates_files', []);
            if (count($templates_files) === 0) {
                $activeTheme = Theme::getSiteTheme();
                $template_file_path = str_replace(DIR_REL, '', $activeTheme->getThemeURL() . '/templates.js');
                if (file_exists(DIR_BASE . $template_file_path)) {
                    $templates_files[] = $template_file_path;
                } else {
                    $templates_files[] = $this->getRelativePath() . '/js/templates/templates/default.js';
                }
            }
            $config->set('editor.ckeditor4.custom_config_options.templates_files', $templates_files);
        }
    }
}
