<?php

/**
 * Draws products
 */
class ctProductsShortcode extends ctShortcodeQueryable
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Products';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'products';
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
        $rounded = '';
        extract($attributes);

        $products = $this->getCollection($attributes, array('post_type' => 'product'));

        $counter = 0;
        $counter2 = 0;

        $productBoxHtml = '';
        foreach ($products as $p) {
            $counter2++;
            if ($counter2 == 1) {
                $productBoxHtml .= '[row]';
            }
            $align = '';
            if ($counter2 == 1) {
                $align = 'left';
            } elseif ($counter2 == 3) {
                $align = 'right';
            }


            $productBoxHtml .= '[third_column sm="6"]';

            //forward params
            $productBoxHtml .= $this->embedShortcode('product', array_merge($attributes, array('id' => $p->ID, 'align' => $align, 'style' => $counter2, 'rounded' => $rounded)));

            $productBoxHtml .= '[/third_column]';

            if ($counter2 == 3 || $counter == count($products)) {
                $counter2 = 0;
                $productBoxHtml .= '[/row]';
            }
        }

        return do_shortcode($productBoxHtml);
    }


    /**
     * Returns params from array ($custom)
     * @param $arr
     * @param $key
     * @param int $index
     * @param string $default
     * @return bool
     */

    protected function getFromArray($arr, $key, $index = 0, $default = '')
    {
        return isset($arr[$key][$index]) ? $arr[$key][$index] : $default;;
    }

    /**
     * Shortcode type
     * @return string
     */
    public function getShortcodeType()
    {
        return self::TYPE_SHORTCODE_SELF_CLOSING;
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        $atts = $this->getAttributesWithQuery(array(
            'cat_name' => array('query_map' => 'category_name', 'default' => '', 'type' => 'input', 'label' => __("Category name", 'ct_theme'), 'help' => __("Name of category to filter", 'ct_theme')),
            'tag' => array('default' => '', 'type' => 'input', 'label' => __("Tag name (slug)", 'ct_theme'), 'help' => __("Comma separated values: tag1,tag2 To exclude tags use '-' minus: -mytag will exclude tag 'mytag'", 'ct_theme')),
            'limit' => array('label' => __('limit', 'ct_theme'), 'default' => 4, 'type' => 'input', 'help' => __("Number of elements", 'ct_theme')),
            'above_price_text' => array('label' => __("Above price text", 'ct_theme'), 'default' => 'just', 'type' => 'input', 'help' => __("Word above the price", 'ct_theme')),
            'images' => array('label' => __('images', 'ct_theme'), 'default' => 'yes', 'type' => 'select', 'choices' => array('yes' => __('yes', 'ct_theme'), 'no' => __('no', 'ct_theme')), 'help' => __("Show images?", 'ct_theme')),
            'use_thumbnail' => array('label' => __('Use thumbnail image', 'ct_theme'), 'default' => 'yes', 'type' => 'select', 'options' => array(
                'yes' => 'yes',
                'no' => 'no',
            ), 'help' => __('Use thumbnail image instead of product one?', 'ct_theme')),
            'rounded' => array('label' => __('Rounded ?', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'options' => array(
                'yes' => 'yes',
                'no' => 'no',
            )),
            'showprice' => array('label' => __('Show price ?', 'ct_theme'), 'default' => 'yes', 'type' => 'select', 'options' => array(
                'yes' => 'yes',
                'no' => 'no',
            )),
        ));

        if (isset($atts['cat'])) {
            unset($atts['cat']);
        }
        return $atts;
    }
}

new ctProductsShortcode();