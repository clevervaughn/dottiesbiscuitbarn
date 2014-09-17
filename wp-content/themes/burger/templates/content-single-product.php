

<?php
    while (have_posts()) : the_post();{
        $custom = get_post_custom(get_the_ID());

        $post_data = get_post($post->ID, ARRAY_A);

        $slug = $post_data['post_name'];



        $price = $custom['date'][0];
        $date = $custom['date'][0];
        $date = $custom['date'][0];
        $date = $custom['date'][0];
        $html='';
        $html.= do_shortcode('

                [row]
                    [event_box slug="'.$slug.'"]
                [/row]

        ');

    }endwhile;
    echo $html;

?>




