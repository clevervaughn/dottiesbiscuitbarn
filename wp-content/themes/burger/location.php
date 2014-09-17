<?php
$path = dirname(__FILE__) . '/../../..';
//load wp
if (file_exists($path . '/wp-load.php')) {
	include_once $path . '/wp-load.php';
} elseif (file_exists($path . '/../wp-load.php')) {
	include_once $path . '/../wp-load.php';
}
//check is everything ok
if (!isset($_REQUEST['k']) || $_REQUEST['k'] != ct_get_option('general_location_secret')) {
	die("Invalid key. Please make sure you are using valid URL");
}
$updated = false;
if (isset($_POST['lat'])) {
	update_option('general_locations', array('lat' => $_POST['lat'], 'lng' => $_POST['lng'], 'location' => $_POST['location']));
	$updated = true;
}
?>

<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title><?php wp_title('|', true, 'right');
		bloginfo('name'); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<?php wp_head(); ?>

	<!--[if lt IE 9]>
	<script src="<?php echo CT_THEME_ASSETS ?>/bootstrap/js/html5shiv.js"></script>
	<script src="<?php echo CT_THEME_ASSETS ?>/bootstrap/js/respond.min.js"></script>
	<![endif]-->

	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
</head>

<body>
<div id="boxedWrapper">
	<div class="container">
		<div class="row">
			<div class="cold-md-12">
				<?php if ($updated): ?>
					<div class="alert alert-success alert-dismissable text-center">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<strong><?php echo __('Settings saved!', 'ct_theme') ?></strong>
					</div>
				<?php endif; ?>                <h3 class="hdr1"><?php echo get_bloginfo('name') ?></h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div id="gmap" style="width:100%; height: 400px"></div>
				<script>
					function updateGeocodeAddress(pos) {
						var geocoder = new google.maps.Geocoder();
						geocoder.geocode({
							latLng: pos
						}, function (responses) {
							if (responses && responses.length > 0) {
								jQuery('#location').val(responses[0].formatted_address);
							}
						});
					}

					function success(position) {
						var coords = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
						jQuery('#lat').val(position.coords.latitude);
						jQuery('#lng').val(position.coords.longitude);
						updateGeocodeAddress(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));

						var options = {
							zoom: 15,
							center: coords,
							mapTypeControl: false,
							draggable: false,
							panControl: true,
							navigationControlOptions: {
								style: google.maps.NavigationControlStyle.SMALL
							},
							mapTypeId: google.maps.MapTypeId.ROADMAP
						};


						var map = new google.maps.Map(document.getElementById("gmap"), options);

						var marker = new google.maps.Marker({
							position: coords,
							map: map,
							draggable: true,
							title: "You are here!"
						});

						google.maps.event.addListener(marker, 'dragend', function (evt) {
							jQuery('#lat').val(evt.latLng.lat());
							jQuery('#lng').val(evt.latLng.lng());
							updateGeocodeAddress(evt.latLng);
						});


					}

					if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(success);
					} else {
						error('Geo Location is not supported');
					}
				</script>
				<div class="row">
					<div class="col-md-12 text-center">
						<form method="POST">
							<input type="hidden" name="k" value="<?php echo $_REQUEST['k'] ?>">
							<input type="hidden" name="lat" id="lat" value="">
							<input type="hidden" name="lng" id="lng" value="">
							<input type="hidden" name="location" id="location" value="">
							<input type="submit" class="btn btn-primary" value="<?php echo __("Set location", 'ct_theme') ?>">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--footer-->
<?php wp_footer(); ?>
</body>
</html>
