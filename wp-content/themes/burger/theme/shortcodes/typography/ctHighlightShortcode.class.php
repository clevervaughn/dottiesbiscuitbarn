<?php

/**
 * Highlight shortcode
 */
class ctHighlightShortcode extends ctShortcode
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Highlight';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'highlight';
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


        $html = '<span class="highlight type' . $type . '" data-toggle="tooltip" data-placement="'.$tooltip_placement.'" title data-original-title="'.$title.'" >' . $content . '</span>';
        return $html;
    }


    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'content' => array('label' => __('Content', 'ct_theme'), 'default' => '', 'type' => "textarea"),
            'title' => array('label' => __('Tooltip title', 'ct_theme'), 'default' => '', 'type' => "input"),
            'type' => array('label' => __('Type', 'ct_theme'), 'default' => '1', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
            )),
            'tooltip_placement' => array('label' => __('Tooltip placement', 'ct_theme'), 'default' => 'top', 'type' => 'select', 'options' => array('top' => __('top', 'ct_theme'), 'right' => __('right', 'ct_theme'), 'bottom' => __('bottom', 'ct_theme')), 'left' => __('left', 'ct_theme'), 'none' => __('none', 'ct_theme'), 'help' => __("Select tooltip position", 'ct_theme')),
        );
    }
}

new ctHighlightShortcode();