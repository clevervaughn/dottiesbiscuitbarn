<?php

/**
 * Alert Box shortcode
 */
class ctAlertBoxShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Alert Box';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'alert_box';
	}

	/**
	 * Shortcode type
	 * @return string
	 */
	public function getShortcodeType() {
		return self::TYPE_SHORTCODE_ENCLOSING;
	}


	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return string
	 */
	public function handle($atts, $content = null) {
		extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));

		$mainContainerAtts = array(
				'class' => array(
						'alert',
						'alert-dismissable',
						($type == 'danger') ? 'alert-danger' : '',
						($type == 'success') ? 'alert-success' : '',
						($type == 'info') ? 'alert-info' : '',
						($type == 'warning') ? 'alert-warning' : '',
						$class
				),
				'id' => $id
		);

		//default
		$iconClass = 'fa fa-check-circle-o';

		switch ($type) {
			case 'danger':
				$iconClass = 'fa fa-ban';
				break;
			case 'info':
				$iconClass = 'fa fa-info-circle';
				break;
			case 'warning':
				$iconClass = 'fa fa-exclamation-circle';
				break;
		}
		$iconHtml = '<i class="' . $iconClass . '"></i>';
		$buttonHtml = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';

		$html = '<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>' . $buttonHtml . $iconHtml . $content . '</div>';
		return do_shortcode($html);
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
				'type' => array('label' => __('type', 'ct_theme'), 'default' => 'info', 'type' => "select",
						'choices' => array(
								'danger' => __('danger', 'ct_theme'),
								'success' => __('success', 'ct_theme'),
								'info' => __('info', 'ct_theme'),
								'warning' => __('warning', 'ct_theme'),
						)
				),
				'content' => array('label' => __('Message', 'ct_theme'), 'default' => '', 'type' => 'textarea'),
				'id' => array('type' => false, 'default' => ''),
				'class' => array('label' => __("Custom CSS class", 'ct_theme'))
		);
	}
}

new ctAlertBoxShortcode();