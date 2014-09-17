<?php

/**
 * Flex Slider Item shortcode
 */
class ctCircleSliderItemShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Circle Slider Item';
	}

	/**
	 * Parent shortcode name
	 * @return null
	 */
	public function getParentShortcodeName() {
		return 'circle_slider';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'circle_slider_item';
	}

	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return string
	 */
	public function handle($atts, $content = null) {
		extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));

		$preLink = $link ? ('<a href="' . $link . '">') : '';
		$postLink = $link ? '</a>' : '';
		$title = $title ? do_shortcode('[header level="4" style="'.$title_style.'"]'.$title.'[/header]') : '';
		$subtitle = $subtitle ? do_shortcode('[header level="5" style="'.$subtitle_style.'"]'.$subtitle.'[/header]') : '';
        $line = $title_line ? do_shortcode('[line style="none"]') : '';

        if(ct_get_option('products_currency_position','before_price')=='before_price' || ct_get_option('products_currency_position','before_price')==''){
            $priceHtml = '<span class="price"><em>'.$currency.'</em>'.$price.'<span>'.$subprice.'</span></span>';
        }else{
            $priceHtml = '<span class="price">'.$price.'<span>'.$subprice.'</span><em>'.$currency.'</em></span>';
        }



        if ($type == '2'){
            $imageShortcode = $imgsrc ?  '<div class="frameImg type2">[rounded_img  size="260" src ="'.$imgsrc.'"][/rounded_img]</div>' : '';
        }else{
            $imageShortcode = $imgsrc ?  '[rounded_img  size="320" src ="'.$imgsrc.'"][/rounded_img]' : '';
        }


        $content = '[paragraph]'.$content.'[/paragraph]';
        $mainContainerAtts = array(
            'class'  => array($class)
        );
        $mainContainerAtts = array();
        $item = '
                    <li '.$this->buildContainerAttributes($mainContainerAtts,$atts).'>
                        ' . $preLink . '
                        <div class="descArea">
                           '.$title.$line.$subtitle.$content.$priceHtml.'
                        </div>
                        '.$imageShortcode.$postLink.'
                    </li>
                ';
		return do_shortcode($item);
	}


	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
				'imgsrc' => array('label' => __("source", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image", 'ct_theme')),
				'link' => array('label' => __('link', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Link from image", 'ct_theme')),
				'title' => array('label' => __('title', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Title", 'ct_theme')),
                'title_line' => array('label' => __('Title bottom line', 'ct_theme'), 'default' => 'yes', 'type' => 'select', 'choices' => array("yes" => "yes", "no" => "no"), 'help' => __("Title line", 'ct_theme')),
				'title_style' => array('label' => __('Select title style', 'ct_theme'), 'default' => 'none', 'type' => 'select', 'options' => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
				'7' => '7',
				'none' => 'none')),
				'subtitle' => array('label' => __('Subtitle', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Subtitle", 'ct_theme')),
				'subtitle_style' => array('label' => __('Select subtitle style', 'ct_theme'), 'default' => 'none', 'type' => 'select', 'options' => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
				'7' => '7',
				'none' => 'none')),
                'price' => array('label' => __('price', 'ct_theme'), 'default' => '', 'type' => 'input', 'example' => '456,50'),
                'subprice' => array('label' => __('subprice', 'ct_theme'), 'default' => '', 'type' => 'input'),
                'currency' => array('label' => __('currency', 'ct_theme'), 'default' => __('$', 'ct_theme'), 'type' => 'input'),
				'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => "textarea"),
                'type' => array('label' => __('Select slider style', 'ct_theme'), 'default' => '1', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2')),
                'class' => array('label' => __('Custom class', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
		);
	}

}

new ctCircleSliderItemShortcode();