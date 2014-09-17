<?php

/**
 * Flex Slider shortcode
 */
class ctGallerySliderShortcode extends ctShortcodeQueryable
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Gallery Slider';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'gallery_slider';
    }

    public function enqueueScripts()
    {

        wp_register_style('ct-flex-slider-css', CT_THEME_ASSETS . '/js/flexslider/css/flexslider.css');
        wp_enqueue_style('ct-flex-slider-css');


        wp_register_script('ct-flex-slider', CT_THEME_ASSETS . '/js/flexslider/jquery.flexslider-min.js', array('jquery'), false, true);
        wp_enqueue_script('ct-flex-slider');

        wp_register_script('ct-flex-easing', CT_THEME_ASSETS . '/js/flexslider/jquery.easing.1.3.min.js', array('ct-flex-slider'), false, true);
        wp_enqueue_script('ct-flex-easing');


    }


    private function getAttachedImages($id, $size)
    {
        $urlArr = array();
        $imageUrl = '';
        $width = 270;
        $height = 160;
        $args = array(
            'post_type' => 'attachment',
            'numberposts' => -1,
            'post_status' => null,
            'post_parent' => $id
        );

        $attachments = get_posts($args);
        if ($attachments) {
            foreach ($attachments as $attach) {
                $image = wp_get_attachment_image_src($attach->ID, $size);

                $imageUrl = $image[0];
                $urlArr[] = $imageUrl;
            }
        }
        return $urlArr;
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
        $id = ($id=='')? 'gallery_slider'.rand(100, 1000): $id;

        $this->addInlineJS($this->flexSliderGetInlineJS($attributes, $id));

        $posts = $this->getCollection($attributes, array('post_type' => $post_type));


        /* Get attached images array*/
        $images = array();
        foreach ($posts as $p) {
            if ($img = ct_get_feature_image_src($p->ID, $image_size)) {
                $images[] = $img;
            }

            $attached_images = $this->getAttachedImages($p->ID, $image_size);
            if (!empty($attached_images)) {
                $images = array_merge($images, $attached_images);
            }
        }

        /*build slider items*/
        $items = '';
        foreach ($images as $img) {
            $imageShortcode = '[img src ="' . $img . '"][/img]';
            $items .= '<li>' . $imageShortcode . '</li>';
        }


        $mainContainerAtts = array(
            'class' => array(
                'flexslider',
                'std-slider',
                'center-controls',
                $class
            ),
            'data-height' => $height,
            'id' => $id

        );


        $html = '<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>';
        $html .= '<ul class="slides">' . $items . '</ul>';
        $html .= '</div>';
        return do_shortcode($html);
    }

    /**
     * returns JS
     * @param $id
     * @return string
     */
    protected function flexSliderGetInlineJS($attributes, $id)
    {
        extract($attributes);
        return '
		// flexfull slider init
        jQuery("#'.$id . '").flexslider({
        animation: "' . $effect . '",              //String: Select your animation type, "fade" or "slide"
        easing: "easeInOutExpo",               //{NEW} String: Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
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
        controlNav: ' . $controlnav . ',               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
        directionNav: ' . $dirnav . ',             //Boolean: Create navigation for previous/next navigation? (true/false)
        prevText: "Previous",           //String: Set the text for the "previous" directionNav item
        nextText: "Next",               //String: Set the text for the "next" directionNav item

        // Usability features
        touch: ' . $touch . ',                    //{NEW} Boolean: Allow touch swipe navigation of the slider on touch-enabled devices
        video: true,                   //{NEW} Boolean: If using video in the slider, will prevent CSS3 3D Transforms to avoid graphical glitches
        useCSS: true,                   //{NEW} Boolean: Slider will use CSS3 transitions if available

        // Secondary Navigation
        keyboard: true,                 //Boolean: Allow slider navigating via keyboard left/right keys
        multipleKeyboard: false,        //{NEW} Boolean: Allow keyboard navigation to affect multiple sliders. Default behavior cuts out keyboard navigation with more than one slider present.
        mousewheel: false,              //{UPDATED} Boolean: Requires jquery.mousewheel.js (https://github.com/brandonaaron/jquery-mousewheel) - Allows slider navigating via mousewheel
        pausePlay: false,               //Boolean: Create pause/play dynamic element
        pauseText: "Pause",             //String: Set the text for the "pause" pausePlay item
        playText: "Play",               //String: Set the text for the "play" pausePlay item

        // Callback API
        start: function () {
            jQuery(".flexslider.flexFull").removeClass("loading-slider");
        }
    });

';

    }

    /**
     * Returns config
     * @return null
     *
     *
     */
    public function getAttributes()
    {
        /*get post types and registered image sizes*/
        $imageSizeArr = array();
        $postTypeArr = array();
        foreach (get_post_types() as $postType) {
            $postTypeArr[$postType] = $postType;
        }

        foreach (get_intermediate_image_sizes() as $size_name => $size_attrs) {

            $imageSizeArr[$size_attrs]=$size_attrs;
        }

        $atts = $this->getAttributesWithQuery(array(
            'id' => array('label' => __('Slider id', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("html id attribute", 'ct_theme')),
            'post_type' => array('label' => __('Select post type', 'ct_theme'), 'default' => 'post', 'type' => 'select', 'choices' => $postTypeArr),
            'image_size' => array('label' => __('Select registered image size', 'ct_theme'), 'default' => 'featured_image_related_posts', 'type' => 'select', 'choices' => $imageSizeArr),
            'limit' => array('label' => __('Limit', 'ct_theme'), 'default' => '3', 'type' => 'input'),
            'height' => array('label' => __('Height', 'ct_theme'), 'default' => '100%', 'type' => 'input'),
            'effect' => array('label' => __('Effect', 'ct_theme'), 'default' => 'slide', 'type' => 'select', 'choices' => array("slide" => "slide", "fade" => "fade"), 'help' => __("Slider effect", 'ct_theme')),
            'animspeed' => array('label' => __('Animation speed', 'ct_theme'), 'default' => 800, 'type' => 'input', 'help' => __('slide transition speed in miliseconds (1 sec = 1000 milisec)', 'ct_theme')),
            'controlnav' => array('label' => __('Show control navigation', 'ct_theme'), 'default' => 'true', 'type' => 'select', 'choices' => array("true" => __("true", "ct_theme"), "false" => __("false", "ct_theme"))),
            'dirnav' => array('label' => __('Show direction navigation', 'ct_theme'), 'default' => 'true', 'type' => 'select', 'choices' => array("true" => __("true", "ct_theme"), "false" => __("false", "ct_theme"))),
            'touch' => array('label' => __('Touch', 'ct_theme'), 'default' => 'false', 'type' => 'select', 'choices' => array('true' => __('true', 'ct_theme'), 'false' => __('false', 'ct_theme')), 'help' => __("Allow touch swipe navigation of the slider on touch-enabled devices", 'ct_theme')),
            'slideshow' => array('label' => __('Slideshow', 'ct_theme'), 'default' => 'false', 'type' => 'select', 'choices' => array('true' => __('true', 'ct_theme'), 'false' => __('false', 'ct_theme'))),
            'slideshow_speed' => array('label' => __('Slideshow speed', 'ct_theme'), 'default' => 7000, 'type' => 'input', 'help' => __('how long each slide will show in miliseconds (1 sec = 1000 milisec)', 'ct_theme')),
            'animation_loop' => array('label' => __('Animation loop', 'ct_theme'), 'default' => 'true', 'type' => 'select', 'choices' => array('true' => __('true', 'ct_theme'), 'false' => __('false', 'ct_theme')), 'help' => __('Gives the slider a seamless infinite loop.', 'ct_theme')),
            'init_delay' => array('label' => __('Init Delay', 'ct_theme'), 'default' => 5000, 'type' => 'input', 'help' => __('Set an initialization delay, in milliseconds (1 sec = 1000 milisec)', 'ct_theme')),
            'pause_on_action' => array('label' => __('Pause on action', 'ct_theme'), 'default' => 'true', 'type' => 'select', 'choices' => array('true' => __('true', 'ct_theme'), 'false' => __('false', 'ct_theme')), 'help' => __('Pause the slideshow when interacting with control elements.', 'ct_theme')),
            'pause_on_hover' => array('label' => __('Pause on hover', 'ct_theme'), 'default' => 'true', 'type' => 'select', 'choices' => array('true' => __('true', 'ct_theme'), 'false' => __('false', 'ct_theme')), 'help' => __('Pause the slideshow when hovering over slider, then resume when no longer hovering.', 'ct_theme')),
            'class' => array('label' => __('Custom class', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        ));
        return $atts;

    }


}

new ctGallerySliderShortcode();