<?php
require_once CT_THEME_LIB_WIDGETS.'/ctShortcodeWidget.class.php';

/**
 * Flickr widget
 * @author hc
 */

class ctGoogleMapsWidget extends ctShortcodeWidget {
	/**
	 * Creates wordpress
	 */
	function __construct() {
		$widget_ops = array('classname' => 'google_maps', 'description' => __('Displays Google map.', 'ct_theme'));
		parent::__construct('google_maps', 'CT - ' . __('Google Maps', 'ct_theme'), $widget_ops);
	}


	/**
	 * Returns shortcode class
	 * @return mixed
	 */
	protected function getShortcodeName() {
		return 'google_maps';
	}
}

register_widget('ctGoogleMapsWidget');