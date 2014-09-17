<?php

/**
 * Recent posts
 * ver. 2.0
 */
class ctRecentPostsShortcode extends ctShortcodeQueryable
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Recent posts';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'recent_posts';
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

        extract($attributes);
        $recentposts = $this->getCollection($attributes);


        $mainContainerAtts = array(
            'class' => array(
                ($widgetmode == 'true') ? 'media-list' : 'recent_posts blog-main',
                $class
            ),
        );


        if ($widgetmode == 'true') {


            foreach ($recentposts as $p) {
                $picture = '';
                if ($type == 'image') {

                    $picture = '<a class="pull-left" href="' . get_permalink($p) . '">
                            ' . get_the_post_thumbnail($p->ID, array(84, 82)) . '
                             </a>';
                }
                $html .= '
					<li class="media">
						' . $picture . '
						<a href="' . get_permalink($p) . '">
                        <p class="media-heading">' . $p->post_title . '</p>
                        <div class="media-body">
                            <p>' . substr($p->post_content, '0', '70') . '</p>
                        </div>
                        </a>
                        <span class="date">' . get_the_time('M d, Y', $p) . '</span>
			        </li>';
            }
            return do_shortcode('
					' . $headerHtml . '
				<ul ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '>' . $html . '</ul>'
            );

        } else {


            $index_url = get_permalink(ct_get_option("posts_index_page", '#'));
            $index_button_text = ($index_button_text != '') ? '<a href="' . $index_url . '" class="btn btn-block btn-sm btn-default">' . $index_button_text . '</a>' : '';

            /* Build title column */
            $html = '<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '><div class="row withMargin">
            <div class="col-md-3 col-sm-3 col-xs-6">
                    <h3 class="page-title hdr2">' . $title . '</h3>
                    <h4 class="hdr3">' . $subtitle . '</h4>
                    ' . $index_button_text . '
            </div>';

						$is_first_row = true;
            $stop = 3;
            $counter = 0;
            foreach ($recentposts as $p) {

                //$custom = get_post_custom($p->ID);
                $postFormat = (get_post_format($p->ID));
                $class = $postFormat == false ? 'blog-item' : 'blog-item format-' . $postFormat;

                /* Bulid article thumb column */
                $html .= '<div class="col-md-3 col-sm-3 col-xs-6"><article id="post-' . $p->ID . '" class="' . $class . '">';



                $comments = wp_count_comments($p->ID)->approved;
                $comments = $comments > 0 ? $comments . ' ' . __('comments', 'ct_theme') : __(' Leave a comment', 'ct_theme');
                $postMetaHtml = '<div class="meta_box">';
                if (ct_get_option("posts_index_show_date", 1)) {
                    $postMetaHtml .= '<span class="meta_date">' . get_the_time('M d, Y', $p) . ' </span>';
                }
                if (ct_get_option("posts_index_show_comments_link", 1)) {
                    $postMetaHtml .= '<span class="meta_comments"><a href="' . get_permalink($p) . '#comments">' . $comments . '</a></span>';
                }
                $postMetaHtml .= '</div>';


                /*get post featured image*/
                $postFeaturedImage = ct_get_feature_image_src($p->ID, 'featured_image_related_posts');

                switch ($postFormat) {
                    case false: //false = post standard (image)
                    case 'image':

                        if ($postFeaturedImage != '') {
                            $html .= '<div class="blog-thumbnail ' . $thumbnail_class . '" ><a href="' . get_permalink($p->ID) . '">';
                            $html .= '<img src="' . $postFeaturedImage . '" alt=" "></a></div>';
                        } else {
                            $html .= '<div class="blog-thumbnail ' . $thumbnail_class . '" ></div>';
                        }

                        $html .= $postMetaHtml;
                        $html .= '<h5 class="entry-title"><a href="' . get_permalink($p->ID) . '">' . $p->post_title . '</a></h5>';

                        break;


                    case 'video':


                        if (get_post_meta($p->ID, 'videoM4V', true) != '') {
                            $embed = get_post_meta($p->ID, 'videoM4V', true);
                        } elseif (get_post_meta($p->ID, 'videoOGV', true) != '') {
                            $embed = get_post_meta($p->ID, 'videoOGV', true);
                        } elseif (get_post_meta($p->ID, 'videoDirect', true) != '') {
                            $embed = get_post_meta($p->ID, 'videoDirect', true);
                        } else {
                            $embed = '';

                        }



                        if ($embed == '') {
                            if ($postFeaturedImage != '') {
                                $html .= '<div class="blog-thumbnail ' . $thumbnail_class . '">';
                                $html .= '<img src="' . ct_get_feature_image_src($p->ID, 'featured_image_related_posts') . '" alt=" ">
                            ';
                                $html .= '</div>';
                            } else {
                                $html .= '<div class="blog-thumbnail ' . $thumbnail_class . '" >
                                <div class="blog-thumbnail ' . $thumbnail_class . '" ></div>
                                ';
                            }
                        } else {
                            if ($postFeaturedImage != '') {
                                $html .= '<div class="blog-thumbnail ' . $thumbnail_class . '">';
                                $html .= '<a href="' . $embed . '" class="popup-iframe">
                                <img src="' . ct_get_feature_image_src($p->ID, 'featured_image_related_posts') . '" alt=" ">
                            </a>';
                                $html .= '</div>';
                            } else {

                                $html .= '<div class="blog-thumbnail ' . $thumbnail_class . '" >
                                <a  href="' . $embed . '" class="popup-iframe">
                                <div class="blog-thumbnail ' . $thumbnail_class . '" ></div>
                            </a>
                                ';
                            }
                        }


                        $html .= $postMetaHtml;
                        $html .= '<h5 class="entry-title"><a href="' . get_permalink($p->ID) . '">' . $p->post_title . '</a>
                        </h5>';
                        break;


                    case 'quote':
                        $html .= '<div class="blog-thumbnail ' . $thumbnail_class . '" ></div>';
                        $html .= $postMetaHtml;
                        $html .= '<blockquote class="inner">';
                        $html .= '<a href="' . get_permalink($p->ID) . '">';
                        $html .= '<p>' . get_post_meta($p->ID, 'quote', true) . '</p>';
                        $html .= '<span class="author">' . get_post_meta($p->ID, 'quoteAuthor', true) . '</span></a>';
                        $html .= '</blockquote>';
                        break;


                    case 'link':
                        $html .= '<div class="blog-thumbnail ' . $thumbnail_class . '" ></div>';
                        $html .= $postMetaHtml;
                        $html .= '<h5 class="entry-title"><a href="' . get_post_meta($p->ID, 'link', true) . '">' . $p->post_content . '</a></h5>';
                        break;


                    case 'image':
                        break;


                    case 'gallery':

                        $html .= '<div class="blog-thumbnail ' . $thumbnail_class . '">';
                        $html .= '[gallery_slider limit="100" ID="' . $p->ID . '"]';
                        $html .= ' </div>';
                        $html .= $postMetaHtml;
                        $html .= '<h5 class="entry-title"><a href="' . get_permalink($p->ID) . '">' . $p->post_title . '</a></h5>';
                        break;


                    case 'audio':
                        if (get_post_meta($p->ID, 'audioOGA', true) != '') {
                            $embed = get_post_meta($p->ID, 'audioOGA', true);
                        } elseif (get_post_meta($p->ID, 'audioMP3', true) != '') {
                            $embed = get_post_meta($p->ID, 'audioMP3', true);
                        }


                        if (empty($embed)) {
                            $html .= '<div class="blog-thumbnail ' . $thumbnail_class . '" ></div>';
                        } else {
                            //$html .= ct_get_the_post_audio($p->ID, 270, 160);
                            $html .= '<div class="blog-thumbnail ' . $thumbnail_class . '" >' . ct_get_the_post_audio($p->ID, 270, 160) . '</div>';
                        }
                        $html .= $postMetaHtml;
                        $html .= '<h5 class="entry-title"><a href="' . get_permalink($p->ID) . '">' . $p->post_title . '</a>';
                        $html .= '</h5>';
                        break;


                    case 'aside':
                        $html .= '<div class="blog-thumbnail ' . $thumbnail_class . '" ></div>';
                        $html .= $postMetaHtml;
                        $html .= '<h5>' . strip_tags($p->post_content) . '<h5>';
                        break;
                }

                $counter++;

                if ($counter == $stop) {
                    // Close article; Close article column; Close Row; Open Row
                    $html .= '</article></div></div><div class="row withMargin">';
                    $counter = 0;
                    $stop = 4;
	                  $is_first_row = false;
                } else if ($counter == $limit) {
                    // Close article; Close article column; Close Row; Open Row
                    $html .= '</article></div></div><div class="row withMargin">';
                    $counter = 0;
                } else {
                    /* Here, the Row is not closed yet. Next item will be placed in the Row.
                     Close article; Close article column;*/

                    $html .= '</article></div>';

	                  if($is_first_row) {
		                  if ($counter == 1) {
				                  $html .= "<div class='clearfix visible-xs'></div>";
				                }
	                  } else {
		                  if ($counter == 2) {
				                  $html .= "<div class='clearfix visible-xs'></div>";
				                }
	                  }
                }


            }
            $html .= '</div></div>';
            return do_shortcode($html);
        }
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
            'title' => array('label' => __('Title', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'subtitle' => array('label' => __('Subtitle', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'index_button_text' => array('label' => __('Blog index button text', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'widgetmode' => array('default' => 'false', 'type' => false),
            'limit' => array('label' => __('limit', 'ct_theme'), 'default' => 3, 'type' => 'input'),
            'thumbnail_class' => array('label' => __("Custom thumbnail class", 'ct_theme'), 'default' => '', 'type' => 'input'),
            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input'),

        ));
        return $atts;
    }
}

new ctRecentPostsShortcode();