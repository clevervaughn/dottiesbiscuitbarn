
<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<?php dynamic_sidebar('sidebar-footer1'); ?>
				</div>

				<div class="col-md-6">
					<?php dynamic_sidebar('sidebar-footer2'); ?>
				</div>

				<div class="col-md-3">
					<?php dynamic_sidebar('sidebar-footer3'); ?>
				</div>
			</div>

		</div>
	<p class="copyright"> <?php echo strtr(ct_get_option('general_footer_text', ''), array('%year%' => date('Y'), '%name%' => get_bloginfo('name', 'display'))); ?></p>
	<a href="#" id="toTop"></a>
</footer>
