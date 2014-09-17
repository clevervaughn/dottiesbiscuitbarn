<?php

/**
 * Imports/exports settings from WP which are not handled by default WRX Export/import (Wordpress Importer Plugin)
 */
class ctDemoExporterImporter {

	/**
	 * Export settings to file
	 */

	const EXPORT_FILE = 'F';

	/**
	 * Export to display (echo)
	 */

	const EXPORT_DISPLAY = 'D';

	/**
	 * @param $data
	 * @return string
	 */
	function compress($data) {
		return serialize($data);
	}


	/**
	 * Export data
	 * @param string $format
	 * @param array $options
	 * @throws Exception
	 */
	public function export($format = self::EXPORT_DISPLAY, $options = array()) {
		global $wpdb;
		$options = array();
		$options['upload_dir'] = wp_upload_dir();
		$options['options'] = array();

		$options['options']['permalink_structure'] = get_option('permalink_structure');

		$widgets = $wpdb->get_results("SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE 'widget_%'");
		foreach ($widgets as $widget) {
			$options['options'][$widget->option_name] = $this->compress(get_option($widget->option_name));
		}
		$options['options']['sidebars_widgets'] = $this->compress(get_option('sidebars_widgets'));

		$current_template = get_option('stylesheet');
		$options['options']["theme_mods_{$current_template}"] = $this->compress(get_option("theme_mods_{$current_template}"));

		$data = serialize($options);

		if ($format == self::EXPORT_DISPLAY) {

			echo '<textarea>' . $data . '</textarea>';
		}

		//export settings to file
		if ($format == self::EXPORT_FILE) {
			$path = isset($options['path']) ? $options['path'] : self::getWpOptionsPath();
			if (!file_put_contents($path, $data)) {
				throw new Exception("Cannot save settings to: " . $path);
			}
		}
	}

	/**
	 * Rebuild every demo file
	 */

	public function rebuild(ctImport $xmlImporter, ctNHP_Options $options) {

		//echo ctImport::getThemeOptionsPath();exit;
		//theme options
		if (file_put_contents(ctImport::getThemeOptionsPath(), $options->export()) === false) {
			throw new Exception("Cannot save file to: " . ctImport::getThemeOptionsPath());
		}
		$this->export(self::EXPORT_FILE);
		error_reporting(E_ERROR);
		require_once ABSPATH . 'wp-admin/includes/export.php';
		flush();
		ob_start();
		export_wp(array('content' => 'all'));
		$xml = ob_get_contents();
		ob_end_clean();
		file_put_contents(ctImport::getXmlPath(), $xml);
	}

	/**
	 * Get path to exported settings
	 * @author alex
	 * @return string
	 */
	public static function getWpOptionsPath() {
		return ctImport::getDemoContentBaseDir() . '/wp_options.txt';
	}

	/**
	 * Import settings
	 * @param array $processed_terms
	 * @param null $path
	 */
	public function import($processed_terms, $path = null) {

		//import wordpress options
		$path = $path ? $path : self::getWpOptionsPath();
		$current_template = get_stylesheet();

		if (file_exists($path)) {
			if ($data = unserialize(file_get_contents($path))) {

				//update wordpress options
				if (isset($data['options'])) {
					foreach ($data['options'] as $key => $val) {
						$e = @unserialize($val);
						if ($val !== false && $e !== false) {
							$val = $e;
						}

						//navigation - remap it
						if (strpos($key, "theme_mods_") !== false) {

							foreach ($val['nav_menu_locations'] as $navName => $navId) {
								if(isset($processed_terms[(int)$navId])){
									$menuId = $processed_terms[(int)$navId];
									$val['nav_menu_locations'][$navName] = $menuId;
								}
							}

							$key = 'theme_mods_' . $current_template;
						}

						update_option($key, $val);
					}
				}

				flush_rewrite_rules();
			}
		}
	}

}