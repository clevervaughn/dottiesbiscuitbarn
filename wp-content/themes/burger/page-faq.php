<?php
/*
Template Name: Faq Template
*/
?>
<?php get_template_part('templates/page', 'head'); ?>
<?php $breadcrumbs = ct_show_index_post_breadcrumbs('faq') ? 'yes' : 'no'; ?>
<?php $pageTitle = ct_get_index_post_title('faq'); ?>

</div>
<?php get_template_part('templates/content', 'faq'); ?>
<div class="container">