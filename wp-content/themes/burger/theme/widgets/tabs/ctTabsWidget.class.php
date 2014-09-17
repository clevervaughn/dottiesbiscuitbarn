<?php
require_once CT_THEME_LIB_WIDGETS . '/ctShortcodeWidget.class.php';

/**
 * Socials widget
 * @author hc
 */
class ctTabsWidget extends ctShortcodeWidget {

	/**
	 * Creates wordpress
	 */
	function __construct() {
		$widget_ops = array('classname' => 'tabs', 'description' => __('Your tabs', 'ct_theme'));
		parent::__construct('tabs', 'CT - ' . __('Tabs', 'ct_theme'), $widget_ops);
	}

	/**
	 * Returns shortcode class
	 * @return mixed
	 */
	protected function getShortcodeName() {
		return 'tabs';
	}
}

register_widget('ctTabsWidget');
