<div class="blog-post format-link">
    <h3 class="blog_title"><a href="<?php echo get_permalink(get_the_ID())?>"><?php echo ct_get_blog_item_title()?></a></h3>
    <div class="blog_thumbnail">
        <a href=" <?php echo get_post_meta($post->ID, 'link', true) ?>" class="box_text">
            <span class="ribbon_icon"><i class="fa fa-link"></i></span>
            <div class="inner">
                <?php the_content()?>
            </div>
        </a>
    </div>
<?php get_template_part('templates/post/content-meta'); ?>
<hr class="dashed-separator">
</div>


