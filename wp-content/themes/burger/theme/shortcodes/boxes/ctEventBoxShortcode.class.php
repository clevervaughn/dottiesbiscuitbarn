<?php
/**
 * Pricelist shortcode
 */
class ctEventBoxShortcode extends ctShortcode
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Event Box';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'event_box';
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
        $image='';
        extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));





        $args = array(
            'name' => $slug,
            'post_type' => 'event',
            'post_status' => 'publish',
            'numberposts' => 1
        );
        $my_posts = get_posts($args);

        if ($my_posts) {
            $id = $my_posts[0]->ID;

            $title = $my_posts[0]->post_title;
            $content = get_post_field('post_content', $id);



        if ($id) {

            $custom = get_post_custom($id);
            $permalink = (get_permalink($id));

            $date = $custom['date'][0];
            $subtitle = $custom['subtitle'][0];
            $amap = $custom['amap'][0];

            $date = $date ? strtotime($date) : '';
            if ($date != '') {
                $timestamp = mktime(0, 0, 0, date('m', $date), 1);
                $month = __(strtoupper(strftime('%b', $timestamp)), 'ct_theme');
                $day = date('d', $date);

            } else {
                $month = '';
                $day = '';
            }

        }




        wp_reset_postdata();

        /*is amap iframe?*/
        preg_match('/src="([^"]+)"/', $amap, $match);
        if ($match == null){
            $amap.= '&output=embed?iframe=true&width=640&height=480';
        }else{
            $amap = $match[1].'?iframe=true&width=640&height=480';
        }


        $image =  (ct_get_option('event_show_featured_image', 0) && ct_get_feature_image_src($id, 'large'))  ?
            '<span class="date featureImg"><a target="_blank" data-rel="prettyPhoto" href="'.ct_get_feature_image_src($id, 'large').'" ><img src="'.ct_get_feature_image_src($id, 'thumb_square').'" alt=""></a></span>'
             : '';

        $type2 = ($style == '2')? 'type2' : '';

            $mainContainerAtts = array(
                'class' => array(
                    'eventBox',
                    $type2,
                    $class
                ),
            );


        $html = '

        <div '.$this->buildContainerAttributes($mainContainerAtts,$atts).'>
        <span class="date">' . $month . '<span>' . $day . '</span></span>

        <h4 class="hdr2">' . $title . '

          <span class="place">' . $content . '</span>
          <span class="time">' . $subtitle . '</span>
        </h4>
        <hr>



        <div class="clearfix"></div>
        <!-- go to http://amap.to/ and create your own map -->
        '.$image.'<a href="' . htmlentities($amap).'" data-rel="prettyPhoto" class="mapit"><i></i>'.__('Map it', 'ct_theme').'</a>
        <a target="_blank" href="http://www.facebook.com/sharer/sharer.php?u=' . $permalink . '" class="shareit"><i></i>'.__('Share it', 'ct_theme').'</a>

      </div>
		';
        return do_shortcode($html);

        }else{
            return'';
        }
    }


    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'slug' => array('label' => __('Event slug', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'style' => array('label' => __('Style', 'ct_theme'), 'default' => '1', 'type' => 'select',
                'choices' => array("1" => "1", "2" => "2", "" => ""), 'help' => __("Event box style", 'ct_theme')),
            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );

    }
}

new ctEventBoxShortcode();
