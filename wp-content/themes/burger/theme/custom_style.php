
<?php
global $wp_customize;


?>
<?php _custom_background_cb()?>

<style type="text/css" media="all">


    <?php if($style = get_theme_mod('top_bg1')):?>

    .navbar-default .inner{ background: transparent url("<?php echo $style ?>") repeat-x center top}
    <?php endif;?>

    <?php if($style = get_theme_mod('top_bg2')):?>
    .navbar-default .inner:before{ background: transparent url("<?php echo $style ?>") repeat-x center top}
    <?php endif;?>

    <?php if($style = get_theme_mod('top_bg3')):?>
    body{ background: transparent url("<?php echo $style ?>") repeat-y top center}
    <?php endif;?>

    <?php if($style = get_theme_mod('top_bg4')):?>

    body .navbar-default .inner .btm{ background:transparent url("<?php echo $style ?>") repeat-x center -264px!important;}
    <?php endif;?>


    <?php if($style = get_theme_mod('footer_bg1')):?>

    footer:before{ background: transparent url("<?php echo $style ?>") repeat-x center top!important}
    <?php endif;?>

    <?php if($style = get_theme_mod('footer_bg2')):?>
    footer{ background: transparent url("<?php echo $style ?>") repeat top center!important}
    <?php endif;?>

	<?php $font = ct_get_option('style_font_style'); $fontSize = ct_get_option_pattern('style_font_size', 'font-size: %dpx;',14); ?>
	<?php if($font||($fontSize && $fontSize!=14)):?>
    body {
	<?php if ($font): ?> <?php $normalized = explode(':', $font); ?>
		<?php if (isset($normalized[1])): ?>
            font-family: '<?php echo $normalized[0]?>', sans-serif;
	        <?php if(is_numeric($normalized[1])): ?>
            font-weight: <?php echo $normalized[1];?>;
	    <?php else:?>
	        font-style: <?php echo $normalized[1];?>;
	    <?php endif;?>
			<?php endif; ?> <?php endif;?>
	<?php echo $fontSize?>



	<?php //default styles ?> <?php echo ct_get_option_pattern('style_color_basic_background', 'background-color: %s;')?>
    <?php echo ct_get_option_pattern('style_color_basic_background_image', 'background: url(%s) repeat;')?>
    <?php echo ct_get_option_pattern('style_color_basic_text', 'color: %s;')?>
    <?php if (ct_get_option('style_color_basic_background') && !ct_get_option('style_color_basic_background_image')): ?> background-image: none;
		<?php endif;?>
    }
    <?php endif;?>

	<?php $sizes = array('1'=>45,'2'=>40,'3'=>35,'4'=>25,'5'=>25,'6'=>20)?>
	<?php foreach($sizes as $tag=>$size):?>
			<?php echo ct_get_option_pattern('style_font_size_h'.$tag, 'h'.$tag.'{font-size: %dpx;}',$size)?>
	<?php endforeach;?>

	<?php /*custom style - code tab*/ ?>
	<?php echo ct_get_option('code_custom_styles_css')?>
</style>