<?php
function theme_comments($comment, $args, $depth) {
$GLOBALS['comment'] = $comment;?>

<li>
	<div class="oneComment" id="comment-<?php comment_ID(); ?>">
		<div class="media">
                <span class="pull-left roundedImg">
	                <?php echo get_avatar($comment, $size = '55', $default = 'mystery'); ?>
                </span>

			<div class="media-body">
				<?php echo get_comment_author_link() ?><br>
				<?php echo get_comment_date(); ?><?php if (get_comment_time()): ?> <?php _e('at', 'ct_theme') ?> <?php echo get_comment_time() ?><?php endif; ?>
				<?php if (ct_get_option("posts_single_show_comment_form", 1)): ?>
					<div class="pull-right"><?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div><?php endif; ?>
			</div>
			<?php comment_text() ?>
		</div>

	</div>
	<?php
	}
	?>


	<?php if (((get_post_type() == 'portfolio' && ct_get_option("portfolio_single_show_comments", 0)) || (get_post_type() == 'post' && ct_get_option("posts_single_show_comments", 1)) || (get_post_type() == 'page' && ct_get_option("pages_single_show_comments", 0))) && have_comments()): ?>
		<div class="space50px" id="comments"></div>
		<h4> <?php echo __("Comments", "ct_theme"); ?></h4>
		<ul class="commentList list-unstyled">
			<?php wp_list_comments(array('callback' => 'theme_comments', 'style' => 'ol')); ?>
		</ul>
		<div class="pagination-comments">
			<?php paginate_comments_links(array('type' => 'list', 'prev_text' => '<i class="fa fa-chevron-left"></i>', 'next_text' => '<i class="fa fa-chevron-right"></i>')); ?>
		</div>
	<?php endif; ?>


	<?php if (((get_post_type() == 'portfolio' && ct_get_option("portfolio_single_show_comment_form", 0)) || (get_post_type() == 'post' && ct_get_option("posts_single_show_comment_form", 1)) || get_post_type() == 'page' && ct_get_option("pages_single_show_comment_form", 0)) && comments_open()) : // Comment Form ?>

		<!-- comment form ****** -->

		<div class="space50px" id="respond"></div>
		<h4><?php echo __('Leave a comment', 'ct_theme') ?></h4>

		<form class="simpleForm commentForm" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">
			<fieldset>
				<div class="form-group">
					<label class="label-sm">Your name</label>
					<input type="text" class="form-control input-sm" name="name" placeholder="<?php _e('your name...', 'ct_theme') ?>">
				</div>
				<div class="form-group">
					<label class="label-sm">Your email</label>
					<input type="email" required class="form-control input-sm" name="email" placeholder="<?php _e('your email...', 'ct_theme') ?>">
				</div>
				<div class="form-group">
					<label class="label-sm">Your message</label>
					<textarea class="form-control input-sm" rows="5" name="comment" placeholder="<?php _e('your message goes here...', 'ct_theme') ?>"></textarea>
				</div>
				<input class="btn btn-default" type="submit" value="Submit">
			</fieldset>
			<?php comment_id_fields(); ?>
			<?php do_action('comment_form', get_the_ID()); ?>
			<?php if (false): ?><?php comment_form() ?><?php endif; ?>
		</form>


		<!-- ********************* -->
		<!-- / comment form ****** -->

	<?php endif; ?>



