<?php
require_once CT_THEME_LIB_WIDGETS.'/ctShortcodeWidget.class.php';

/**
 * Flickr widget
 * @author hc
 */

class GoogleMapsMarkersWidget extends ctShortcodeWidget {
	/**
	 * Creates wordpress
	 */
	function __construct() {
		$widget_ops = array('classname' => 'google_maps_markers', 'description' => __('Displays Google map markers', 'ct_theme'));
		parent::__construct('google_maps_markers', 'CT - ' . __('Google Maps Markers', 'ct_theme'), $widget_ops);
	}


	/**
	 * Returns shortcode class
	 * @return mixed
	 */
	protected function getShortcodeName() {
		return 'google_maps_markers';
	}
}

register_widget('GoogleMapsMarkersWidget');