<h3 class="blog_title"><a href="<?php echo get_permalink(get_the_ID()) ?>"><?php echo ct_get_blog_item_title() ?></a>
</h3>
<div class="blog_thumbnail">
    <a href=" <?php echo get_permalink(get_the_ID()) ?>" class="box_text">
        <span class="ribbon_icon"><i class="fa fa-quote-left"></i></span>
        <blockquote class="inner">
            <p><?php echo get_post_meta($post->ID, 'quote', true) ?></p>
            <span class="author"><?php echo get_post_meta($post->ID, 'quoteAuthor', true) ?></span>
        </blockquote>
    </a>
</div>
<?php get_template_part('templates/post/content-meta'); ?>

