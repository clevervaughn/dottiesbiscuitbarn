<?php

/**
 * Price tag shortcode
 */
class ctPriceTag extends ctShortcode {


	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Price tag';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'price_tag';
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
                'priceHeader',
                $class
            ),
        );

		$html = '
		<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '">
                    <span class="lft">'.$left_header.'</span>
                    <span class="price">
                      <span class="el_1">'.$above_price_text.'</span>
                      '.((ct_get_option('products_currency_position','before_price')=='before_price' || ct_get_option('products_currency_position','before_price')=='')?'<span class="el_2">'.$currency.'</span>':'<span class="el_3">'.$price.'</span> <span class="el_4">'.$sub_price.'</span>').'
                      '.((ct_get_option('products_currency_position','before_price')=='before_price' || ct_get_option('products_currency_position','before_price')=='')?'<span class="el_3">'.$price.'</span> <span class="el_4">'.$sub_price.'</span>':'<span class="el_2">'.$currency.'</span>').'

                    </span>
                    <span class="rt">'.$right_header.'</span>
        </div>';
		return do_shortcode($html);
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
			'left_header' => array('label' => __("Left header", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Text in the left header", 'ct_theme')),
			'right_header' => array('label' => __("Right header", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Text in the right header", 'ct_theme')),
			'above_price_text' => array('label' => __("Above price text", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Word above the price", 'ct_theme')),
			'price' => array('label' => __("Price", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Price", 'ct_theme')),
            'sub_price' => array('label' => __("Sub price", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Sub price", 'ct_theme')),
			'currency' => array('label' => __("Currency symbol", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Currency symbol", 'ct_theme')),
			'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Custom class name", 'ct_theme')),
		);
	}

}

new ctPriceTag();