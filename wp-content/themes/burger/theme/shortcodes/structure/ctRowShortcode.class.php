<?php

/**
 * Wide row shortcode
 */
class ctRowShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Row';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'row';
	}

	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return string
	 */

	public function handle($atts, $content = null) {
		$spacerTopShortcode = '';
		$spacerBottomShortcode = '';
		extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));


		$headerShortcode = $header ? $header = ('[header level="' . $header_level . '" style="' . $header_style = ($header_style == '') ? '"]' . $header . '[/header]' : $header_style . '"]' . $header . '[/header]') : '';

		if ($top_margin == 'true' || $top_margin == 'yes') {
			$spacerTopShortcode = '[spacer]';
		} elseif ($top_margin != '' && is_numeric($top_margin)) {
			$spacerTopShortcode = '[spacer height= "' . $top_margin . '"]';
		}

		if ($bottom_margin == 'true' || $bottom_margin == 'yes') {
			$spacerBottomShortcode = '[spacer]';
		} elseif ($bottom_margin != '' && is_numeric($bottom_margin)) {
			$spacerBottomShortcode = '[spacer height= "' . $bottom_margin . '"]';
		}


		$mainContainerAtts = array(
				'class' => array(
						'row',
						$class,
						($wide_style == 'yes' || $wide_style == 'true' || $wide_style == '1') ? 'nomargin' : '',
						($wide_style == 'yes' || $wide_style == 'true' || $wide_style == '1') ? 'threeBoxes' : '',
						($align == 'center') ? 'text-center' : '',
						($align == 'left') ? 'text-left' : '',
						($align == 'right') ? 'text-right' : ''
				),
				'style' => $inline_style,
				'id' => $id ? $id : ''

		);

		//$narrowcontent = false;

		if ($wide_style == 'yes' || $wide_style == 'true' || $wide_style == '1') {
			$wideRowShortcode = array('start' => '[full_width]', 'end' => '[/full_width]');
			$narrowcontent = false;
		} else {
			$wideRowShortcode = array('start' => '', 'end' => '');
		}


		$narrowDivOpen = ($narrowcontent == 'true' || $narrowcontent == 'yes' || $narrowcontent == '1') ? '<div class="container ' . '" ' . '>' : '';
		$narrowDivClose = ($narrowcontent == 'true' || $narrowcontent == 'yes' || $narrowcontent == '1') ? '</div>' : '';
		$narrowDivOpen2 = ($narrowcontent == 'true' || $narrowcontent == 'yes' || $narrowcontent == '1') ? '<div class="row">' : '';
		$narrowDivClose2 = ($narrowcontent == 'true' || $narrowcontent == 'yes' || $narrowcontent == '1') ? '</div>' : '';

		$Row = ($spacerTopShortcode . $wideRowShortcode['start'] . '<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>' . $narrowDivOpen . $headerShortcode . $narrowDivOpen2 . $content . $narrowDivClose2 . $narrowDivClose . '</div>' . $wideRowShortcode['end'] . $spacerBottomShortcode);

		return do_shortcode($Row);

	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		$defaultNarrow = $this->isSidebar() ? false : true;

		return array(
				'id' => array('label' => __('header id', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("html id attribute", 'ct_theme')),
				'class' => array('label' => __('CSS class', 'ct_theme'), 'default' => '', 'type' => 'input'),
				'top_margin' => array('label' => __('Top margin', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("space above row (in px)", 'ct_theme')),
				'bottom_margin' => array('label' => __('Bottom margin', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("space below row (in px) ", 'ct_theme')),
				'narrowcontent' => array('label' => __('narrow content?', 'ct_theme'), 'type' => "checkbox", 'default' => $defaultNarrow, 'help' => __("Make content narrow even if inside full width container?", 'ct_theme')),
				'wide_style' => array('default' => 'no', 'type' => 'select', 'options' => array('yes' => 'yes', 'no' => 'no'), 'label' => __('Wide style', 'ct_theme')),
				'header' => array('label' => __('header', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Header text", 'ct_theme')),
				'header_level' => array('label' => __('Level of header', 'ct_theme'), 'default' => '3', 'type' => 'select', 'options' => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
				)),
				'header_style' => array('label' => __('Select header style', 'ct_theme'), 'default' => '1', 'type' => 'select', 'options' => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'7' => '7',
                    '8' => '8',
                    '9' => '9',
						'' => '')),
				'align' => array('label' => __('Align', 'ct_theme'), 'default' => 'none', 'type' => 'select', 'options' => array(
						'none' => 'none',
						'center' => 'center',
						'right' => 'right',
						'left' => 'left',
				)),
				'inline_style' => array('label' => __('Additional inline style', 'ct_theme'), 'default' => '')
		);
	}

	/**
	 * Zwraca rodzaj shortcode
	 * @return string
	 */
	public function getShortcodeType() {
		return self::TYPE_SHORTCODE_ENCLOSING;
	}


	/**
	 * is template with sidebar?
	 * @return bool
	 */
	protected function isSidebar() {
		return is_page_template('page-custom.php') || is_page_template('page-custom-left.php');
	}
}

new ctRowShortcode();