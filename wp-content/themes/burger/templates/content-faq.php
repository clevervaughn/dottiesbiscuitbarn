<?php $data = ct_get_posts_grouped_by_cat(array('post_type' => 'faq', 'showposts' => -1), 'faq_category'); ?>

<?php $breadcrumbs = ct_show_index_post_breadcrumbs('faq') ? 'yes' : 'no'; ?>
<?php $pageTitle = ct_get_index_post_title('faq'); ?>
<?php $custom = get_post_custom(get_the_ID());?>



<div class="bg-2 section">
	<div class="inner" data-topspace="100" data-bottomspace="140" data-scroll="scroll" data-image="<?php echo CT_THEME_ASSETS . '/images/content/background-5.jpg' ?>">
		<div class="container">

            <?php if (($custom["show_title"][0] !='no')): ?>
                <?php if (($custom["show_title"][0] =='global')): ?>

                    <?php if (ct_get_option("faq_index_show_title", 1) && ($pageTitle)): ?>
                        <h3 class="hdr1"><?php echo $pageTitle; ?></h3>
                    <?php endif; ?>

                <?php else: ?>
                    <?php if ($pageTitle): ?>
                        <h3 class="hdr1"><?php echo $pageTitle; ?></h3>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>

			<div class="row faqrow">
				<div class="col-md-12">
					<div class="progress onlyfaq">
						<div class="progress-bar">
							<span class="pull-left">Find your answer</span>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-4">
					<?php if ($data): ?>
						<div id="faq1" class="faqMenu" data-spy="affix" data-offset-top="10">
							<ul class="nav">
								<?php $counter = 0; ?>
								<?php foreach ($data as $catId => $details): ?>
									<?php if (isset($details['cat'])): ?>
										<?php $counter++; ?>
										<li<?php if ($counter == 1): ?> class="active"<?php endif; ?>><a href="#q<?php echo $catId ?>"><?php echo $details['cat']; ?></a></li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>
				</div>
				<div class="col-md-8">
					<?php if ($data): ?>
						<?php foreach ($data as $catId => $details): ?>
							<div class="sectionFaq" id="q<?php echo $catId; ?>">
								<?php if (isset($details['posts']) && isset($details['cat'])): ?>
									<h4 class="hdr3"><?php echo $details['cat'] ?></h4>
									<?php $html = '[accordion]'; ?>
									<?php foreach ($details['posts'] as $faq): ?>
										<?php $html .= '[accordion_item title="' . $faq->post_title . '"]' . $faq->post_content . '[/accordion_item]'; ?>
									<?php endforeach; ?>
									<?php $html .= '[/accordion]'; ?>
									<?php echo do_shortcode($html) ?>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>

		</div>
	</div>
</div>


