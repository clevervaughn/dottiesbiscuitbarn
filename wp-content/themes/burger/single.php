<?php $breadcrumbs = ct_show_index_post_breadcrumbs('post') ? 'yes' : 'no'; ?>

<!--container!--></div>
<div class="bg-2 section" id="blogBgImage">
    <div class="inner"
         data-scroll="scroll"
         data-topspace="45">
        <div class="container">
            <?php $breadcrumbs = ct_show_index_post_breadcrumbs('post') ? 'yes' : 'no'; ?>
            <?php if (ct_get_single_post_title('post') || $breadcrumbs == "yes"): ?>
                <?php echo do_shortcode('[title_row header="' . ct_get_single_post_title('post') . '" breadcrumbs="' . $breadcrumbs . '"]') ?>
            <?php endif ?>
            <div class="divider-triangle"></div>
            <div id="pageWithSidebar" class="">

                <div class="blog-list">
                    <div class="row">
                        <div class="col-md-8 blog-main">
                            <?php get_template_part('templates/content', 'single'); ?>
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



