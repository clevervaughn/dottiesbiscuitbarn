<?php

/**
 * Pricelist shortcode
 */
class ctIconBoxShortcode extends ctShortcode
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Icon box';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'icon_box';
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
        extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));


        $mainContainerAtts = array(
            'class' => array(
                'iconBox',
                'text-center',
	            $class
            )
        );

        $iconShortcode = $icon ? '[icon awesome="fa '.$icon.'"]' : '';
        $headerShortcode = $header ? '[header style="none" level="3"]'.$iconShortcode.' '.$header.'[/header]' : '';
        $contentShortcode = $content ? '[paragraph]'.$content.'[/paragraph]' : '';

        $html = '<div '.$this->buildContainerAttributes($mainContainerAtts, $atts).'>'.$headerShortcode.$contentShortcode.'</div>';
        return do_shortcode($html);
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'header' => array('label' => __('Title', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'content' => array('label' => __('Description', 'ct_theme'), 'default' => '', 'type' => 'textarea'),
            'icon' => array('label' => __('icon', 'ct_theme'), 'type' => "icon", 'default' => '','link'=>CT_THEME_ASSETS.'/shortcode/awesome/index.html'),
            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),

        );

    }
}

new ctIconBoxShortcode();
