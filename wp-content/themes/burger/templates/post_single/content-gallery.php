<h3 class="blog_title"><a href="<?php echo get_permalink(get_the_ID()) ?>"><?php echo ct_get_blog_item_title() ?></a>
</h3>
<?php if (ct_get_option("posts_index_show_image", 1)): ?>
    <div class="blog_thumbnail">
        <a href=" <?php echo get_permalink(get_the_ID()) ?>">
            <?php get_template_part('templates/post/content-gallery','gallery'); ?>
            <span class="ribbon_details">
              <span class="ribbon_details_date"><?php echo ct_get_post_short_month_name() ?>
                  <br><?php echo ct_get_post_day() ?></span>
              <span class="ribbon_details_comments"><?php echo ct_get_comments_count() ?> <i class="fa fa-comments"></i></span>
            </span>
        </a>
    </div>
<?php endif; ?>
<?php get_template_part('templates/post/content-meta'); ?>

<?php the_content(); ?>

