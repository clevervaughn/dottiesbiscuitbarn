<?php
require_once CT_THEME_LIB_WIDGETS.'/ctShortcodeWidget.class.php';

/**
 * Flickr widget
 * @author hc
 */

class ctRecentTweetsWidget extends ctShortcodeWidget {
	/**
	 * Creates wordpress
	 */
	function __construct() {
		$widget_ops = array('classname' => 'recent_tweets', 'description' => __('Displays Recent Tweets.', 'ct_theme'));
		parent::__construct('twitter', 'CT - ' . __('twitter', 'ct_theme'), $widget_ops);
	}

	/**
	 * Returns shortcode class
	 * @return mixed
	 */
	protected function getShortcodeName() {
		return 'twitter';
	}
}

register_widget('ctRecentTweetsWidget');
