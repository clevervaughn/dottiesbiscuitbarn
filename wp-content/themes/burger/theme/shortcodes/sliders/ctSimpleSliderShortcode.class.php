<?php
/**
 * Flex Slider shortcode
 */
class ctSimpleSliderShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Simple Slider';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'simple_slider';
	}

    public function enqueueHeadScripts() {

        wp_register_style('ct-flex-slider-css', CT_THEME_ASSETS .'/js/flexslider/css/flexslider.css');
        wp_enqueue_style('ct-flex-slider-css');


        wp_register_script('ct-flex-slider', CT_THEME_ASSETS . '/js/flexslider/jquery.flexslider-min.js', array('jquery'),false,true);
        wp_enqueue_script('ct-flex-slider');

        wp_register_script('ct-flex-easing', CT_THEME_ASSETS . '/js/flexslider/jquery.easing.1.3.min.js', array('jquery'),false,true);
        wp_enqueue_script('ct-flex-easing');


    }



	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return string
	 */

	public function handle($atts, $content = null) {
		$attributes = shortcode_atts($this->extractShortcodeAttributes($atts), $atts);
		extract($attributes);
		$id = rand(100,1000);
        $this->addInlineJS($this->flexSliderGetInlineJS($attributes, $id));


        $mainContainerAtts = array(
            'class' => array(
                'flexslider',
                'flexSimple',
				$class
            )
        );


        $html = '
            <div id="flexslider' . $id . '" ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>
                <ul class="slides">'
                    . $content .
                '</ul>
            </div>
            ';


        return do_shortcode($html);
	}

	/**
	 * returns JS
	 * @param $id
	 * @return string
	 */
	protected function flexSliderGetInlineJS($attributes, $id) {
		extract($attributes);

		return'
		// flexFade slider init
	 jQuery("#flexslider'.$id.'").flexslider({
		animation: "'.$effect.'",              //String: Select your animation type, "fade" or "slide"
		// easing: "easeInOutExpo",               //{NEW} String: Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
		// easing types :
		// swing, easeInQuad, easeOutQuad, easeInOutQuad, easeInCubic, easeOutCubic,
		// easeInOutCubic, easeInQuart, easeOutQuart, easeInOutQuart, easeInQuint,
		// easeOutQuint, easeInOutQuint, easeInSine, easeOutSine, easeInOutSine,
		// easeInExpo, easeOutExpo, easeInOutExpo, easeInCirc, easeOutCirc,
		// easeInOutCirc, easeInElastic, easeOutElastic, easeInOutElastic, easeInBack,
		// easeOutBack, easeInOutBack, easeInBounce, easeOutBounce, easeInOutBounce

        slideshow: ' . $slideshow . ',
        initDelay: ' . $init_delay . ',
        slideshowSpeed: ' . $slideshow_speed . ',           //Integer: Set the speed of the slideshow cycling, in milliseconds
        animationSpeed: ' . $animspeed . ',            //Integer: Set the speed of animations, in milliseconds
        animationLoop: ' . $animation_loop . ',
        pauseOnAction: ' . $pause_on_action . ',            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
        pauseOnHover: ' . $pause_on_hover . ',            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering


		// Primary Controls
		controlNav: '.$controlnav.',               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
        directionNav: '.$dirnav.',             //Boolean: Create navigation for previous/next navigation? (true/false)
        touch: '.$touch.',
	});

';

	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
            'effect' => array('label' => __('effect', 'ct_theme'), 'default' => 'fade', 'type' => 'select', 'choices' => array("slide" => "slide", "fade" => "fade"), 'help' => __("Slider effect", 'ct_theme')),
			'animspeed' => array('label' => __('animation speed', 'ct_theme'), 'default' => 1000, 'type' => 'input', 'help' => __('slide transition speed in miliseconds (1 sec = 1000 milisec)', 'ct_theme')),
			'controlnav' => array('label' => __('show control navigation', 'ct_theme'), 'default' => 'false', 'type' => 'select', 'choices' => array("true" => __("true", "ct_theme"), "false" => __("false", "ct_theme"))),
			'dirnav' => array('label' => __('show direction navigation', 'ct_theme'), 'default' => 'true', 'type' => 'select', 'choices' => array("true" => __("true", "ct_theme"), "false" => __("false", "ct_theme"))),
			'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
            'touch' => array('label' => __('touch', 'ct_theme'), 'default' => 'true', 'type' => 'select', 'choices' => array('true' => __('true', 'ct_theme'), 'false' => __('false', 'ct_theme')), 'help' => __("Allow touch swipe navigation of the slider on touch-enabled devices", 'ct_theme')),
            'slideshow' => array('label' => __('Slideshow', 'ct_theme'), 'default' => 'false', 'type' => 'select', 'choices' => array('true' => __('true', 'ct_theme'), 'false' => __('false', 'ct_theme'))),
            'slideshow_speed' => array('label' => __('Slideshow speed', 'ct_theme'), 'default' => 7000, 'type' => 'input', 'help' => __('how long each slide will show in miliseconds (1 sec = 1000 milisec)', 'ct_theme')),
            'animation_loop' => array('label' => __('Animation loop', 'ct_theme'), 'default' => 'true', 'type' => 'select', 'choices' => array('true' => __('true', 'ct_theme'), 'false' => __('false', 'ct_theme')), 'help' => __('Gives the slider a seamless infinite loop.', 'ct_theme')),
            'init_delay' => array('label' => __('Init Delay', 'ct_theme'), 'default' => 5000, 'type' => 'input', 'help' => __('Set an initialization delay, in milliseconds (1 sec = 1000 milisec)', 'ct_theme')),
            'pause_on_action' => array('label' => __('Pause on action', 'ct_theme'), 'default' => 'true', 'type' => 'select', 'choices' => array('true' => __('true', 'ct_theme'), 'false' => __('false', 'ct_theme')), 'help' => __('Pause the slideshow when interacting with control elements.', 'ct_theme')),
            'pause_on_hover' => array('label' => __('Pause on hover', 'ct_theme'), 'default' => 'true', 'type' => 'select', 'choices' => array('true' => __('true', 'ct_theme'), 'false' => __('false', 'ct_theme')), 'help' => __('Pause the slideshow when hovering over slider, then resume when no longer hovering.', 'ct_theme')),

        );
	}

	public function getChildShortcodeInfo() {
		return array('name' => 'simple_slider_item', 'min' => 1, 'max' => 20, 'default_qty' => 3);
	}


}

new ctSimpleSliderShortcode();