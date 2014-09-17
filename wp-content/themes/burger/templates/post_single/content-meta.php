<div class="meta_box">
    <?php if (ct_get_option("posts_single_show_date", 1)): ?>
    <span class="meta_date"><?php echo get_the_date() ?></span>
<?php endif ?>
<?php if (ct_get_option("posts_single_show_comments_link", 1)): ?>
    <span class="meta_comments"><a href="<?php echo get_permalink(get_the_ID()) ?>#comments"><em><?php echo wp_count_comments(get_the_ID())->approved ?></em><span><?php echo __('Comments', 'ct_theme')?></span></a></span>
<?php endif ?>
<?php if (ct_get_option("posts_single_show_author", 1)): ?>
    <span class="meta_author">by <?php the_author_posts_link() ?></span>
<?php endif ?>
</div>
