<?php
/*
Template Name: Archives
*/
?>

<?php get_template_part('templates/page', 'head'); ?>

<?php $breadcrumbs = ct_show_index_post_breadcrumbs('post') ? 'yes' : 'no';?>
<?php
$pageTitle = __('Archive', 'ct_theme');
if (is_day()) {
	$pageTitle = __('Archive for', 'ct_theme') . ' ' . get_the_time(get_option('date_format'));
}
if (is_month()) {
	$pageTitle = __('Archive for', 'ct_theme') . ' ' . get_the_time('F, Y');
}
if (is_year()) {
	$pageTitle = __('Archive for', 'ct_theme') . ' ' . get_the_time('Y');
}
?>

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