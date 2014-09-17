<?php

/**
 * Pricelist shortcode
 */
class ctTitleBoxShortcode extends ctShortcode
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Title box';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'title_box';
    }

    /**
     * Returns shortcode type
     * @return mixed|string
     */

    public function getShortcodeType()
    {
        return self::TYPE_SHORTCODE_ENCLOSING;
    }


    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return string
     */

    public function handle($atts, $content = null)
    {
        $title = '';
        $subtitle = '';
        extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));


        $mainContainerAtts = array(
            'class' => array(
                $class,
                'iconBox',
                'text-center'
            )
        );

        $headerShortcode = $title ? '[header style="' . $title_style . '" level="3"]' . $title . '[/header]' : '';
        $subHeaderShortcode = $subtitle ? '[header style="' . $subtitle_style . '" level="4" line="bottom" bottom_line_style="1"]'  . ' ' . $subtitle . '[/header]' : '';

        $shortcode = $headerShortcode . $subHeaderShortcode;
        return do_shortcode($shortcode);
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'title' => array('label' => __('Title', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'subtitle' => array('label' => __('Subtitle', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'title_style' => array('label' => __('Select title style', 'ct_theme'), 'default' => '2', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '' => '')),
            'subtitle_style' => array('label' => __('Select subtitle style', 'ct_theme'), 'default' => '3', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '' => '')),
            'line' => array('label' => __('Line', 'ct_theme'), 'default' => 'yes', 'type' => 'select', 'choices' => array('yes' => __('yes', 'ct_theme'), 'no' => __('no', 'ct_theme')), 'help' => __("Show line?", 'ct_theme')),
            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Custom class name", 'ct_theme')),

        );

    }
}

new ctTitleBoxShortcode();
