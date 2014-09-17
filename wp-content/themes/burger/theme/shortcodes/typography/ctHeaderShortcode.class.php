<?php

/**
 * Header shortcode
 */
class ctHeader extends ctShortcode
{


    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Header';
    }


    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'header';
    }

    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return string
     */

    public function handle($atts, $content = null)
    {
        $curved = 'no';
        $style = '';
        extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));
        $spanOpen = ($easybox_line == "yes" || $easybox_line == "true") ? '<span>' : '';
        $spanClose = $spanOpen ? '</span>' : '';

	    $styleName = '';
        if ($style !== ''){
            if ($style == '8'){
                $styleName = 'hdr1 type2';
            }else if($style == '9'){
                $styleName = 'hdr1 type3';
            }else{
                $styleName = 'hdr' . $style;
            }
        }

        if ($curved == 'yes' || $curved == 'true') {
            $radius = 'data-radius="' . $radius . '"';
            $direction = 'data-direction="' . $direction . '"';
            wp_register_script('ct-arctext', CT_THEME_ASSETS . '/js/jquery.arctext.js', array('jquery'),false,true);
            $classCurved = 'curved';
            wp_enqueue_script('ct-arctext');
        } else {
            $classCurved = '';
            $radius='';
            $direction='';
        }

        $class = $class ? $class : '';
        $html = ($line == 'top' || $line == 'both') ? do_shortcode('[line style="' . $top_line_style . '"]') : '';
        $html .= '<h' . $level . ' ' . $radius . ' ' . $direction . ' class="' . $classCurved . ' ' . $styleName . ' ' . $class . '">' . $spanOpen . do_shortcode($content) . $spanClose . '</h' . $level . '>';
        $html .= ($line == 'bottom' || $line == 'both') ? do_shortcode('[line style="' . $bottom_line_style . '"]') : '';

        return do_shortcode($html);
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'level' => array('label' => __('Level of header', 'ct_theme'), 'default' => '3', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
            )),
            'style' => array('label' => __('Select header style', 'ct_theme'), 'default' => '', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '' => '')),
            'easybox_line' => array('label' => __('Easy Box stylish line', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'options' => array('yes' => 'yes', 'no' => 'no'), 'help' => __("only inside the Easy Box component", 'ct_theme')),
            'line' => array('label' => __('Line position', 'ct_theme'), 'default' => '', 'type' => 'select', 'options' => array(
                'top' => 'top',
                'bottom' => 'bottom',
                'both' => 'both',
                '' => '',

            )),
            'top_line_style' => array('label' => __('Top line style', 'ct_theme'), 'default' => '1', 'type' => 'select', 'options' => array(
                '1' => '1',
                'separator' => 'separator',
                '' => ''
            )),
            'bottom_line_style' => array('label' => __('Bottom line style', 'ct_theme'), 'default' => '1', 'type' => 'select', 'options' => array(
                '1' => '1',
                'separator' => 'separator',
                '' => ''
            )),

            'content' => array('label' => __('Header text', 'ct_theme'), 'default' => '', 'type' => "textarea"),


            'curved' => array('Curved' => __('Curved header', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'options' => array('yes' => 'yes', 'no' => 'no')),
            'radius' => array('label' => __('Radius of curvature', 'ct_theme'), 'default' => '800', 'type' => "input"),
            'direction' => array('label' => __('Direction of curvature', 'ct_theme'), 'default' => '1', 'type' => "input"),

            'class' => array('label' => __("Header custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Image class", 'ct_theme')),
        );
    }

}

new ctHeader();