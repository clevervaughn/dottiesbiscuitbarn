<?php

/**
 * Flex Slider shortcode
 */
class ctPolaroidSliderShortcode extends ctShortcode
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Polaroid Slider';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'polaroid_slider';
    }


    public function enqueueHeadScripts()
    {
        wp_register_style('ct-bxslider_css', CT_THEME_ASSETS . '/js/bxslider/jquery.bxslider.css');
        wp_enqueue_style('ct-bxslider_css');
    }


    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return string
     */

    public function handle($atts, $content = null)
    {
        $attributes = shortcode_atts($this->extractShortcodeAttributes($atts), $atts);
        extract($attributes);



        $id =  rand(100, 1000);
        $this->addInlineJS($this->bxSliderGetInlineJS($attributes, $id));

        $mainContainerAtts = array(
            'class' => array(
                'text-center',
                $class
            ),
            'id' => 'polaroid_slider' .$id
        );


        $html = '<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>
                        <div  class="polaroidSlider ' . $class . '">
                            <img src="' . CT_THEME_ASSETS . '/images/scotchtape.png" alt=" " class="scotchtape">
                            <div class="inner">
                                <ul id="bxslider' . $id . '" class="bxslider">
                                    ' . $content . '
                                </ul>
                            </div>
                        </div></div>
                ';
        return do_shortcode($html);
    }


    protected function bxSliderGetInlineJS($attributes, $id)
    {
        extract($attributes);

        return '



		// init bxslider
	jQuery("#bxslider' . $id . '").bxSlider({
		// GENERAL
		mode: "horizontal",
		slideSelector: "",
		infiniteLoop: true,
		hideControlOnEnd: false,
		speed: ' . $animspeed . ',
		easing: null,
		slideMargin: 0,
		startSlide: 0,
		randomStart: false,
		captions: false,
		ticker: false,
		tickerHover: false,
		adaptiveHeight: false,
		adaptiveHeightSpeed: 500,
		video: false,
		useCSS: true,
		preloadImages: "visible",
		responsive: true,

		// TOUCH
		touchEnabled: true,
		swipeThreshold: 50,
		oneToOneTouch: true,
		preventDefaultSwipeX: true,
		preventDefaultSwipeY: false,

		// PAGER
		pager: false,
		pagerType: "full",
		pagerShortSeparator: " / ",
		pagerSelector: null,
		buildPager: null,
		pagerCustom: null,

		// CONTROLS
		controls: true,
		nextText: "Next",
		prevText: "Prev",
		nextSelector: null,
		prevSelector: null,
		autoControls: false,
		startText: "Start",
		stopText: "Stop",
		autoControlsCombine: false,
		autoControlsSelector: null,

		// AUTO
		auto: false,
		pause: 4000,
		autoStart: true,
		autoDirection: "next",
		autoHover: false,
		autoDelay: 0,

		// CAROUSEL
		minSlides: 1,
		maxSlides: 1,
		moveSlides: 0,
		slideWidth: 0,

		// CALLBACKS
		onSliderLoad: function () {
		},
		onSlideBefore: function () {
		},
		onSlideAfter: function () {
		},
		onSlideNext: function () {
		},
		onSlidePrev: function () {
		}
	});




';

    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'animspeed' => array('label' => __('animation speed', 'ct_theme'), 'default' => 500, 'type' => 'input', 'help' => __('slide transition speed in miliseconds (1 sec = 1000 milisec)', 'ct_theme')),
            'class' => array('label' => __('Custom class', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );
    }

    public function getChildShortcodeInfo()
    {
        return array('name' => 'polaroid_slider_item', 'min' => 1, 'max' => 20, 'default_qty' => 3);
    }


}

new ctPolaroidSliderShortcode();