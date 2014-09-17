<?php

/**
 * Button shortcode
 */
class ctProgressBarShortcode extends ctShortcode
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Progress bar';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'progress_bar';
    }

    /**
     * Shortcode type
     * @return string
     */
    public function getShortcodeType()
    {
        return self::TYPE_SHORTCODE_ENCLOSING;
    }

    public function enqueueScripts() {


        wp_register_script('ct-appear', CT_THEME_ASSETS . '/js/jquery.appear.js', array('jquery'),false,true);
        wp_enqueue_script('ct-appear');

    }


    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return string
     */

    public function handle($atts, $content = null)
    {
        extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));
        $this->addInlineJS($this->getInlineJS($attributes, $id),true);
        $mainContainerAtts = array(
            'class' => array(
                'progress',
                $class
            ),
        );

        $subContainerAtts = array(
            'class' => array(
                'progress-bar',
            ),
            'role' => 'progressbar',
            'data-percentage' => $percentage? $percentage : '0',
            'aria-value_now' => $valuenow? $valuenow : '0',
            'aria-value_min' => $valuemin? $valuemin : '0',
            'aria-value_max' => $valuemax? $valuemax : '0'
        );


        $html = '<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>';
        $html.= '<div ' . $this->buildContainerAttributes($subContainerAtts, $atts,'sub-container') . '>';
        $html.= '<span class="pull-left">'.$text_left.'</span>';
        $html.= '<span class="pull-right" style="display:none;">'.$text_right.'<sub>'.$sub_text_right.'</sub></span>';
        $html.='</div>';
        $html.='</div>';
        return do_shortcode($html);
    }



    /**
     * returns JS
     * @param $id
     * @return string
     */
    protected function getInlineJS($attributes, $id) {
        return'
                // progress bar animation

                    if(jQuery().appear) {
                        jQuery(".progress").appear(function () {
                            var $this = jQuery(this);
                            $this.each(function () {
                                var $innerbar = $this.find(".progress-bar");
                                var percentage = $innerbar.attr("data-percentage");

                                $innerbar.addClass("animating").css("width", percentage + "%");

                                $innerbar.on("transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd", function () {
                                                    $innerbar.find(".pull-right").fadeIn(900);
                                                });

                            });
                        }, {accY: -100});
                    }
        ';
    }


    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'text_left' => array('label' => __('Text left', 'ct_theme'), 'type' => "input"),
            'text_right' => array('label' => __('Text right', 'ct_theme'), 'type' => "input"),
            'sub_text_right' => array('label' => __('Sub text right', 'ct_theme'), 'type' => "input"),
            'percentage' => array('label' => __('percentage', 'ct_theme'), 'type' => "input"),
            'value_now' => array('label' => __('valuenow', 'ct_theme'), 'type' => "input"),
            'value_min' => array('label' => __('valuemin', 'ct_theme'), 'type' => "input"),
            'value_max' => array('label' => __('valuemax', 'ct_theme'), 'type' => "input"),
            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),

        );
    }
}

new ctProgressBarShortcode();

