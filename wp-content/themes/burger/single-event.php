</div>
<?php $breadcrumbs = ct_get_option('event_single_show_breadcrumbs') ? 'yes' : 'no';?>
    <?php $pageTitle = ct_get_option('event_single_show_title')? ct_get_single_post_title('event') : ''?>

    <!--container!--></div>
<div class="bg-2 section" id="blogBgImage">
    <div class="inner"
         data-scroll="scroll"
         data-topspace="35">
        <div class="container">

            <?php if ($pageTitle || $breadcrumbs == "yes"): ?>
                <?php echo do_shortcode('[title_row header="' . ct_get_single_post_title('event') . '" breadcrumbs="' . $breadcrumbs . '"]') ?>
            <?php endif ?>
            <div class="divider-triangle"></div>
            <section class="container">
                <?php get_template_part('templates/content', 'single-event'); ?>
            </section>


        </div>
    </div>



