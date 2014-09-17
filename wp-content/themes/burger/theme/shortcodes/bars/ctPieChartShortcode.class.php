<?php

/**
 * Button shortcode
 */
class ctPieChartShortcode extends ctShortcode
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Pie Chart';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'pie_chart';
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
        wp_register_script('ct-easypiechart', CT_THEME_ASSETS . '/js/jquery.easypiechart.min.js', array('jquery'),false,true);
        wp_enqueue_script('ct-easypiechart');
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
                'pie-chart',
	            $class
            ),
            'data-percent' => $percentage,
	          'data-color' => $barcolor
        );
        $text = $icon? '<i class="fa '.$icon.'"></i>' : $text;
        $html = '<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>';
        $html.= '<span>'.$text.'<sub>'.$sub_text.'</sub></span>';
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
                // easy pie chart
                if(jQuery().appear) {
                    jQuery(".pie-chart").appear(function () {
                        jQuery(this).easyPieChart({
                                barColor: jQuery(this).attr("data-color"),
                                trackColor: "transparent",
                                scaleColor:	false,
                                lineCap:	"square",
                                animate:1500,
                                lineWidth:24,
                                size:	155
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
            'text' => array('label' => __('Text', 'ct_theme'), 'type' => "input"),
            'sub_text' => array('label' => __('Sub text right', 'ct_theme'), 'type' => "input"),
            'percentage' => array('label' => __('Percentage', 'ct_theme'), 'type' => "input"),
	          'barcolor' => array('label' => __("Bar color",'ct_theme'), 'type' => "colorpicker"),
            'icon' => array('label' => __('icon', 'ct_theme'), 'type' => "icon", 'default' => '', 'link' => CT_THEME_ASSETS . '/shortcode/awesome/index.html'),
            'class' => array('label' => __('Custom class', 'ct_theme'), 'type' => "input", 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),

        );
    }
}

new ctPieChartShortcode();
