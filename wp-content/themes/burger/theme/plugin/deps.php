<?php
/**
 * Array of plugin arrays. Required keys are name and slug.
 * If the source is NOT from the .org repo, then source is also required.
 */
$plugins = array(
		array(
				'name' => 'Multiple Featured Images', // The plugin name
				'slug' => 'multiple-featured-images', // The plugin slug (typically the folder name)
				'source' => CT_THEME_DIR . '/vendor/multiple-featured-images/multiple-featured-images.zip', // The plugin source
				'required' => false, // If false, the plugin is only 'recommended' instead of required
				'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),
		array(
				'name' => 'Custom Sidebars (included)', // The plugin name
				'slug' => 'custom-sidebars', // The plugin slug (typically the folder name)
				'source' => CT_THEME_DIR . '/vendor/custom-sidebars/custom-sidebars.zip', // The plugin source
				'required' => false, // If false, the plugin is only 'recommended' instead of required
				'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
				'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),
);
