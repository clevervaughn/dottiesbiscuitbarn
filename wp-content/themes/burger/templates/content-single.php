<div class="inner">
    <div class="blog-post">
        <?php while (have_posts()) : the_post(); ?>
            <?php $format = get_post_format();
            $format = $format ? $format : 'standard';
            $class = $format == 'standard' ? 'blogItem post format-type-image' : 'blogItem post format-' . $format;
            ?>
            <div class="<?php echo $class; ?>">
                <?php get_template_part('templates/post_single/content-' . $format); ?>
            </div>
            <?php comments_template('/templates/comments.php'); ?>
        <?php endwhile; ?>
    </div>
</div>
