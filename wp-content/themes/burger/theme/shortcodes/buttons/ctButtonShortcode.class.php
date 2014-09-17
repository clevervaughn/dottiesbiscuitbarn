<?php

/**
 * Button shortcode
 */
class ctButtonShortcode extends ctShortcode
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Button';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'button';
    }

    /**
     * Shortcode type
     * @return string
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
                'btn',
                'btn-' . $type,
                ($size != 'default') ? 'btn-' . $size : '',
                ($status =='disabled')? 'disabled' : '',
                $class
            ),
                 'href'=>$link
        );

        if ($new_window == 'true' || $new_window == 'yes'){
            $mainContainerAtts['target'] = '_blank';
        }


        if ($id) {
            $mainContainerAtts['id'] = $id;
        }
        if ($width) {
            if (is_numeric($width)) {
                $width = $width . 'px';
            }
            $width = ' style="width:' . $width . ';"';
            $mainContainerAtts['style'] = 'width:' . $width;
        }


        if ($icon && $type == 'primary'){
            $iconHtml = '<i class="fa ' . $icon . '"></i>';
            $content = '<span>'.$content.'</span>';
            $contentIconHtml = $iconHtml.$content;

        }else if($icon && $type == 'default'){
            $iconHtml = '<i class="fa ' . $icon . '"></i>';
            $content = '<span>'.$content.'</span>';
            $contentIconHtml = $content.$iconHtml;

        }else{
            $contentIconHtml = $content;
        }

        $ButtonHtml = '<a ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>' .$contentIconHtml. '</a>';

        return do_shortcode($ButtonHtml);
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {

        return array(
            'id' => array('default' => false, 'type' => false),
            'size' => array('label' => __('Size', 'ct_theme'), 'default' => 'default', 'type' => 'select', 'choices' => array('default' => __('default', 'ct_theme'), 'lg' => __('large', 'ct_theme'), 'sm' => __('small', 'ct_theme'), 'xs' => __('Extra small', 'ct_theme'), 'block' => __('Block', 'ct_theme')), 'help' => __("Button size", 'ct_theme')),
            'type' => array('label' => __('Type', 'ct_theme'), 'default' => 'default', 'type' => 'select', 'choices' => array('default' => __('default', 'ct_theme'), 'primary' => __('Primary', 'ct_theme')), 'help' => __("Button type", 'ct_theme')),
            'link' => array('label' => __('Link', 'ct_theme'), 'help' => __("ex. http://www.google.com", 'ct_theme')),
            'new_window' => array('label' => __('Open link in new Window?', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'choices' => array('yes' => __('yes', 'ct_theme'), 'no' => __('no', 'ct_theme'))),
            'width' => array('label' => __('Width', 'ct_theme'), 'type' => "input"),
            'icon' => array('label' => __('Icon', 'ct_theme'), 'type' => "icon", 'default' => '', 'link' => CT_THEME_ASSETS . '/shortcode/awesome/index.html'),
            'content' => array('label' => __('Content', 'ct_theme'), 'default' => '', 'type' => 'textarea'),
            'status' => array('default' => 'enabled', 'type' => 'select', 'options' => array('enabled' => 'enabled', 'disabled' => 'disabled'), 'label' => __('Status', 'ct_theme')),
            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );
    }
}

new ctButtonShortcode();