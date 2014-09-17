<?php
/*
Template Name: Author
*/
?>

<?php get_template_part('templates/page', 'head'); ?>
<?php $breadcrumbs = ct_show_index_post_breadcrumbs('post') ? 'yes' : 'no'; ?>
<?php $pageTitle = ''; ?>
<?php if (have_posts()) : ?>
	<?php the_post(); ?>
	<?php $pageTitle = get_the_author(); ?>
	<?php rewind_posts(); ?>
<?php endif; ?>
<?php $pageTitle = $pageTitle ? (__('Posts by', 'ct_theme') . ' ' . $pageTitle) : __('Posts', 'ct_theme'); ?>


<!--container!--></div>
<div class="bg-2 section" id="blogBgImage">
	<div class="inner"
	     data-scroll="scroll"
	     data-topspace="75">
		<div class="container">
			<?php
			if (ct_get_option("posts_index_show_p_title", 1)):?>
				<h3 class="hdr1"><?php echo $pageTitle ?></h3>
			<?php endif ?>
			<div class="divider-triangle"></div>
			<div id="pageWithSidebar" class="">

				<div class="blog-list">
					<div class="row">
						<div class="col-md-8 blog-main">
							<?php get_template_part('templates/content'); ?>
						</div>


						<?php if (ct_use_blog_index_sidebar()): ?>
							<div class="col-md-4 blog-sidebar">
								<?php get_template_part('templates/sidebar') ?>
							</div>
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
	</div>