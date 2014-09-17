<?php if (ct_get_option('navbar_type') == 'sticky') {
	$ClassSticky = 'full-sticky-menu';
} else {
	$ClassSticky = '';
}?>


<nav class="navbar navbar-default <?php echo $ClassSticky; ?>" role="navigation">
	<div class="inner">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle btn btn-primary" data-toggle="collapse"
				        data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<div class="text-center">
					<p class="address"><?php echo trim(ct_get_option('general_header_text')) ?></p>
				</div>
				<?php

				if (ct_get_option('navbar_type') == 'standard') {
                    //set general logo (logo small)
					if ($plain = ct_get_option('general_logo_html')) {
						echo '<div class="navbar-brand">' . $plain . '</div>';
					} elseif ($logo = ct_get_option('general_logo_small')) {
						echo '<a class="small-brand" href="' . home_url() . '" data-width="'.(ct_get_option('general_logo_small_width')+(-2*ct_get_option('general_logo_small_margin_left'))).'" data-top="' . ct_get_option('general_logo_small_margin_top', 0) . '"><img src="' . esc_url($logo) . '" alt=" "></a>';
					}

				} elseif (ct_get_option('navbar_type') == 'sticky') {
                    //Set menu sticky big logo
					if ($plain = ct_get_option('general_logo_html')) {
						echo '<div class="navbar-brand">' . $plain . '</div>';
					} elseif ($logo = ct_get_option('general_logo')) {
						echo '<a class="navbar-brand" href="' . home_url() . '" data-width="' . (ct_get_option('general_logo_width')+(-2*ct_get_option('general_logo_margin_left'))) . '" data-top="' . ct_get_option('general_logo_margin_top', 0) . '"><img src="' . esc_url($logo) . '" alt=" "></a>';
					}

					// Set menu sticky logo small
					if ($logo_small = ct_get_option('general_logo_small')) {
						echo '<a class="small-brand" href="' . home_url() . '" style="display:none;" data-width="'.(ct_get_option('general_logo_small_width')+(-2*ct_get_option('general_logo_small_margin_left'))).'" data-top="' . ct_get_option('general_logo_small_margin_top', 0) . '"><img src="' . esc_url($logo_small) . '" alt=" "></a>';
					} elseif ($plain = ct_get_option('general_logo_small_html')) {
						echo '<div class="small-brand" style="display:none;">' . $plain . '</div>';

                    //If logo-small is empty then use logo-sticky src:
					} elseif ($logo = ct_get_option('general_logo')) {
						echo '<a class="small-brand" href="' . home_url() . '" style="display:none;" data-width="'.(ct_get_option('general_logo_width')+(-2*ct_get_option('general_logo_margin_left'))).'" data-top="' . ct_get_option('general_logo_margin_top', 0) . '"><img src="' . esc_url($logo) . '" alt=" "></a>';
					}
				}?>
                <?php

                /*logo mobile*/
                if ($plain = ct_get_option('general_logo_mobile_html')) {
                    echo '<div class="mobile-brand" style="display:none;">' . $plain . '</div>';
                } elseif ($logo = ct_get_option('general_logo_mobile')) {
                    echo '<a class="mobile-brand" style="display:none;" href="' . home_url() . '" data-width="'.(ct_get_option('general_logo_mobile_width')+(-2*ct_get_option('general_logo_mobile_margin_left'))).'" data-top="' . ct_get_option('general_logo_mobile_margin_top', 0) . '"><img src="' . esc_url($logo) . '" alt=" "></a>';
                }elseif ($logo = ct_get_option('general_logo_small')) {
                    echo '<a class="mobile-brand" style="display:none;" href="' . home_url() . '" data-width="'.(ct_get_option('general_logo_small_width')+(-2*ct_get_option('general_logo_small_margin_left'))).'" data-top="' . ct_get_option('general_logo_small_margin_top', 0) . '"><img src="' . esc_url($logo) . '" alt=" "></a>';
                }


                ?>


				<?php if ($mobTel = ct_get_option('general_mobile_phone')): ?>
					<a href="tel:<?php echo $mobTel; ?>" class="phoneIcon"
					   style="display:none"><?php echo $mobTel; ?></a>
				<?php endif ?>
				<?php if ($mobMap = ct_get_option('general_mobile_map')):
					$locations = get_option('general_locations', array());
					$mobMap = htmlentities(strtr($mobMap, array(
							'%foodtruck_locator_lat%' => isset($locations['lat']) ? $locations['lat'] : '',
							'%foodtruck_locator_lng%' => isset($locations['lng']) ? $locations['lng'] : '',
							'%foodtruck_locator_address%' => isset($locations['location']) ? urlencode($locations['location']) : '',
					)));

					?>
					<a href="<?php echo $mobMap; ?>" class="locationIcon" target="_blank"
					   style="display:none;"><?php echo $mobMap; ?></a>
				<?php endif ?>

				<?php $socials = ct_socials_code('small', 'bottom');

				if ($socials != '') {
					echo do_shortcode($socials);
				}?>


			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<?php


				if (ct_get_option('navbar_type') == 'standard') {
					if (ct_is_location_contains_menu('nav_standard')) {

						wp_nav_menu(
								array(
										'items_wrap' => '<ul data-type="margin-top" data-pos="'.ct_get_option('navbar_margin_top',135).'" id="%1$s" class="%2$s">%3$s</ul>',
										'theme_location' => 'nav_standard',
										'menu_class' => 'nav navbar-nav text-center',
										'menu_id' => 'menu_' . ct_get_option('navbar_standard_menu')
								)
						);
					}
				}
				if (ct_get_option('navbar_type') == 'sticky') {
					if (ct_is_location_contains_menu('nav_sticky_left')) {

						wp_nav_menu(
								array(
										'items_wrap' => '<ul data-type="margin-top" data-pos="'.ct_get_option('navbar_margin_top',145).'" id="%1$s" class="%2$s">%3$s</ul>',
										'theme_location' => 'nav_sticky_left',
										'menu_class' => 'nav navbar-nav pull-left',
										'menu_id' => 'menu_2',
								));
					}
					if (ct_is_location_contains_menu('nav_sticky_right')) {

						wp_nav_menu(
								array(
										'items_wrap' => '<ul data-type="margin-top" data-pos="'.ct_get_option('navbar_margin_top',145).'" id="%1$s" class="%2$s">%3$s</ul>',
										'theme_location' => 'nav_sticky_right',
										'menu_class' => 'nav navbar-nav pull-right',
										'menu_id' => 'menu_3',
								)
						);
					}
				}
				?>
			</div>
			<!-- /.navbar-collapse -->
		</div>
		<!-- / container -->

		<div class="btm"></div>
	</div>

</nav>