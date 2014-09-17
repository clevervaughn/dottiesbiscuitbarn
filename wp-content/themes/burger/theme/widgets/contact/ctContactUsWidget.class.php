<?php
require_once CT_THEME_LIB_WIDGETS.'/ctShortcodeWidget.class.php';

/**
 * Flickr widget
 * @author hc
 */

class ctContactUsWidget extends ctShortcodeWidget {
	/**
	 * Creates wordpress
	 */
	function __construct() {
		$widget_ops = array('classname' => 'contact', 'description' => __('Displays contact widget', 'ct_theme'));
		parent::__construct('contact', 'CT - ' . __('contact', 'ct_theme'), $widget_ops);
	}


	/**
	 * Returns shortcode class
	 * @return mixed
	 */
	protected function getShortcodeName() {
		return 'contact';
	}
}

register_widget('ctContactUsWidget');