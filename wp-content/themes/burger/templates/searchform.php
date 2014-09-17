<?php global $wp_query;
$arrgs = $wp_query->query_vars; ?>
<form role="search" method="get" id="searchform" class="form-search" action="<?php echo home_url('/'); ?>">
	<fieldset>

		<?php if (is_404()) { ?>
		<div class="row">
			<div class="col-md-7 col-sm-6">
				<input type="text" class="form-control" value="<?php echo (isset($arrgs['s']) && $arrgs['s']) ? $arrgs['s'] : ''; ?>" name="s" id="s" placeholder="<?php _e('type your search here', 'ct_theme') ?>">
			</div>
				<div class="col-md-5 col-sm-6">
					<div class="visible-xs"></div>
					<input type="submit" value="<?php _e('search', 'ct_theme'); ?>" class="btn btn-primary btn-lg btn-block">
				</div>
		</div>
		<?php } else { ?>
			<div class="searchFormWidget">
				<input type="text" class="form-control" value="<?php echo (isset($arrgs['s']) && $arrgs['s']) ? $arrgs['s'] : ''; ?>" name="s" id="s" placeholder="<?php _e('Search', 'ct_theme') ?>">
				<button type="submit" class="btn btn-primary" name="<?php _e('search', 'ct_theme'); ?>"><i class="fa fa-search"></i></button>
			</div>
		<?php } ?>
	</fieldset>

</form>