<div class="blog-post">
    <h3 class="blog_title"><a href="<?php echo get_permalink(get_the_ID())?>"><?php echo ct_get_blog_item_title()?></a></h3>
    <?php if (ct_get_option("posts_index_show_image", 1)): ?>
        <div class="blog_thumbnail">
            <div class="videoFrameContainer">
                <?php
                $embed = get_post_meta($post->ID, 'videoCode', true);
                if (!empty($embed)) {
                    echo stripslashes(htmlspecialchars_decode($embed));
                } else {
                    ct_post_video($post->ID, 541, 256);
                }
                ?>
            </div>
        </div>
    <?php endif; ?>
    <?php get_template_part('templates/post/content-meta'); ?>
    <?php if (ct_get_option("posts_index_show_excerpt", 1) && get_the_content()): ?>
        <p><?php echo strip_tags(get_the_excerpt()) ?></p>
    <?php endif ?>
    <?php if (ct_get_option("posts_index_show_excerpt", 1)): ?>
        <a class="btn btn-primary btn-sm btn-blog" href="<?php echo get_permalink(get_the_ID())?>"><?php echo __('read more', 'ct_theme')?></a>
    <?php elseif (ct_get_option("posts_index_show_fulltext", 0)): ?>
        <?php the_content(); ?>
    <?php endif ?>
    <hr class="dashed-separator">
</div>








