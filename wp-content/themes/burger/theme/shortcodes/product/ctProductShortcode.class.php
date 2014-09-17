<?php

/**
 * Draws products
 */
class ctProductShortcode extends ctShortcodeQueryable
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Product';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'product';
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

        //we grab only 1 product
        $products = $this->getCollection($attributes, array('post_type' => 'product', 'limit' => 1));
        if (!isset($products[0])) {
            return '';
        }
        $p = $products[0];
        $custom = get_post_custom($p->ID);

        $imageSrc = '';
        if ($images == 'yes') {
            if ($rounded == 'yes'){
                $imageSrc = $use_thumbnail == 'yes' ? ct_product_featured_image2_src($p->ID, 'product_thumb', 'product_box_2') : ct_get_feature_image_src($p->ID, 'product_box');
            }else{
                $imageSrc = $use_thumbnail == 'yes' ? ct_product_featured_image2_src($p->ID, 'product_thumb', 'product_box') : ct_get_feature_image_src($p->ID, 'product_box');
            }
        }

        $price = str_replace('.', ',', $this->getFromArray($custom, 'price'));
        $productPrice = explode(",", $price);

        $shortcode = $this->embedShortcode('product_box', array(
            'button_label' => $button_label,
            'button_link' => $button_link,
            'postscript' => $this->getFromArray($custom, 'postscript'),
            'align' => $align,
            'style' => $style,
            'rounded' => $rounded,
            'title' => $p->post_title,
            'image' => $imageSrc,
            'price' => ($showprice =='yes' || $showprice =='true')?  $productPrice[0] : '',
            'subprice' => isset($productPrice[1]) ? $productPrice[1] : '',
            'currency' => $this->getFromArray($custom, 'currency'),
            'above_price_text' => $above_price_text,
        ), $p->post_content);

        return do_shortcode($shortcode);
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
        //here we want use default IQueryable attributes because we want to get only 1 element
        return array(
            'slug' => array('query_map' => 'category_name', 'default' => '', 'type' => 'posts_select', 'post_type' => 'product', 'value_method' => 'slug', 'label' => __("Product", 'ct_theme')),
            'id' => array('default' => '', 'type' => 'posts_select', 'post_type' => 'input', 'label' => __("Product ID", 'ct_theme'), 'help' => array(__("Product ID. You can use slug or ID to find a product", 'ct_theme'))),
            'above_price_text' => array('label' => __("Above price text", 'ct_theme'), 'default' => 'just', 'type' => 'input', 'help' => __("Word above the price", 'ct_theme')),
            'button_label' => array('default' => '', 'type' => 'input', 'label' => __("button text", 'ct_theme')),
            'button_link' => array('default' => '', 'type' => 'input', 'label' => __("button link", 'ct_theme')),
            'images' => array('label' => __('Show images?', 'ct_theme'), 'default' => 'yes', 'type' => 'select', 'choices' => array('yes' => __('yes', 'ct_theme'), 'no' => __('no', 'ct_theme')), 'help' => __("Show images ? ", 'ct_theme')),
            'use_thumbnail' => array('label' => __('Use thumbnail', 'ct_theme'), 'default' => 'yes', 'type' => 'select', 'options' => array(
                'yes' => 'yes',
                'no' => 'no',
            ), 'help' => __('Should thumbnail image be used instead of default product image?', 'ct_theme')),
            'align' => array('label' => __('Align', 'ct_theme'), 'default' => '', 'type' => 'select', 'options' => array(
                '' => __('default', 'ct_theme'),
                'left' => __('left', 'ct_theme'),
                'right' => __('right', 'ct_theme')
            )),
            'style' => array('label' => __('Select style', 'ct_theme'), 'default' => '1', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
            )),
            'rounded' => array('label' => __('Rounded ?', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'options' => array(
                'yes' => 'yes',
                'no' => 'no',
            )),
            'showprice' => array('label' => __('Show price ?', 'ct_theme'), 'default' => 'yes', 'type' => 'select', 'options' => array(
                'yes' => 'yes',
                'no' => 'no',
            )),
        );
    }
}

new ctProductShortcode();