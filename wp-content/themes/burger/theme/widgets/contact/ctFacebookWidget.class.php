<?php
require_once CT_THEME_LIB_WIDGETS . '/ctShortcodeWidget.class.php';

/**
 * Newsletter widget
 * @author hc
 */

class ctFacebookWidget extends ctShortcodeWidget {
	/**
	 * Creates wordpress
	 */
	function __construct() {
		$widget_ops = array('classname' => 'widget_facebook', 'description' => __('Displays newsletter form.', 'ct_theme'));
		parent::__construct('fb', 'CT - ' . __('Facebook', 'ct_theme'), $widget_ops);
	}

	/**
	 * Returns shortcode class
	 * @return mixed
	 */
	protected function getShortcodeName() {
		return 'fb';
	}
}

register_widget('ctFacebookWidget');
