<?php

/**
 * Pricelist shortcode
 */
class ctIconShortcode extends ctShortcode
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Icon';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'icon';
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
                $awesome,
                $class
            )
        );

        $html = '<i '.$this->buildContainerAttributes($mainContainerAtts, $atts).'></i>';
        return $html;
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'awesome' => array('label' => __('icon', 'ct_theme'), 'type' => "icon", 'default' => 'icon-picture','link'=>CT_THEME_ASSETS.'/shortcode/awesome/index.html'),
            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );

    }
}

new ctIconShortcode();
