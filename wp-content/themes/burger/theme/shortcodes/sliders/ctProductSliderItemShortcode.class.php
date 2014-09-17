<?php

/**
 * Flex Slider Item shortcode
 */
class ctProductSliderItemShortcode extends ctShortcode
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Product Slider Item';
    }

    /**
     * Parent shortcode name
     * @return null
     */
    public function getParentShortcodeName()
    {
        return 'product_slider';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'product_slider_item';
    }

    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return string
     */
    public function handle($atts, $content = null)
    {
        $content_position = '';
        extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));

        $preLink = $link ? ('<a href="' . $link . '">') : '';
        $postLink = $link ? '</a>' : '';
        $title = $title ? do_shortcode('[header level="3" style="' . $title_style . '"]' . $title . '[/header]') : '';
        $subtitle = $subtitle ? do_shortcode('[header level="4" style="' . $subtitle_style . '"]' . $subtitle . '[/header]') : '';


        $mainContainerAtts = array(
            'class' => array($class)

        );

        if ($content_position == 'bottom') {
            $slideContent = $title . $subtitle . $content;

        }else{
            $slideContent = $content. $title . $subtitle;
        }

        $item = '
                        <li ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>
				            ' . $preLink . '
                            <div class="container">
	                            <img src="' . $imgsrc . '" alt=" ">
	                            ' . $slideContent . '
                            </div>
				            ' . $postLink . '
			            </li>
                    ';

        return do_shortcode($item);
    }


    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(

            'imgsrc' => array('label' => __("source", 'ct_theme'), 'default' => '', 'type' => 'image', 'help' => __("Image", 'ct_theme')),
            'link' => array('label' => __('link', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Link from image", 'ct_theme')),
            'title' => array('label' => __('title', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Title", 'ct_theme')),
            'title_style' => array('label' => __('Select style', 'ct_theme'), 'default' => '2', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                'none' => 'none')),
            'subtitle' => array('label' => __('Subtitle', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Subtitle", 'ct_theme')),
            'subtitle_style' => array('label' => __('Select style', 'ct_theme'), 'default' => '3', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                'none' => 'none')),
            'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => "textarea"),
            'content_position' => array('label' => __('Content position', 'ct_theme'), 'default' => 'bottom', 'type' => 'select', 'options' => array(
                'top' => 'top',
                'bottom' => 'bottom',

            )),
            'class' => array('label' => __('Custom class', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),

        );
    }

}

new ctProductSliderItemShortcode();