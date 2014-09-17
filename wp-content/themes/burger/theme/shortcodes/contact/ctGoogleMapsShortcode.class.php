<?php

/**
 * Google maps shortcode
 */
class ctGoogleMapsShortcode extends ctShortcode
{

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Google maps';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'google_maps';
    }

    /**
     * Enqueue scripts
     */

    public function enqueueScripts()
    {
        wp_register_script('ct-gmap', CT_THEME_ASSETS . '/js/gmap3.min.js', array('jquery'), false, true);
        wp_enqueue_script('ct-gmap');

        wp_register_script('ct-gmap-api', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', array('jquery'), false, true);
        wp_enqueue_script('ct-gmap-api');
    }


    /**
     * Handles shortcode
     * @param $atts
     * @param null $content
     * @return string
     */

    public function handle($atts, $content = null)
    {
        $attributes = shortcode_atts($this->extractShortcodeAttributes($atts), $atts);
        extract($attributes);
        $id = ($id == '') ? 'gmap' . rand(100, 1000) : $id;

        $this->addInlineJS($this->getInlineJS($attributes, $id), true);

        $savedLocations = get_option('general_locations', array());
        //see location.php file for details
        if ($foodtruck_locator == 'yes' || $foodtruck_locator == 'true') {
            if ($savedLocations) {
                $location = '';
                $latitude = $savedLocations['lat'];
                $longitude = $savedLocations['lng'];
            }

        }

        if (!is_numeric($height)) {
            $height = '286';
        }

        if ($attributes['map_draggable'] == 'yes') {
            $attributes['map_draggable'] = 'true';
        } else if ($attributes['map_draggable'] == 'no') {
            $attributes['map_draggable'] = 'false';
        }


        if (ct_is_browser_type('mobile') == true){
            $attributes['map_draggable'] = 'false';
        }

        $mainContainerAtts = array(
            'class' => array(
                'googleMap',
                $class
            ),
            'data-height' => $height,
            'data-offset' => $offset,
            'data-location' => $location,
            'data-text' => strtr($custom_marker, array('%foodtruck_locator_address%' => isset($savedLocations['location']) ? $savedLocations['location'] : '')),
            'data-latitude' => $latitude,
            'data-longitude' => $longitude,
            'data-map_draggable' => $attributes['map_draggable'],
            'data-street_view' => $attributes['street_view'],
            'data-map_type' => $attributes['map_type'],
            'id' => $id

        );

        $titleShortcode = $title ? '[header class="special" level="3" style="' . $title_style . '"]' . $title . '[/header]' : '';

        if ($curved_subtitle == 'yes' || $curved_subtitle == 'true') {
            $curved_subtitle = 'curved="yes" radius="' . $radius . '" direction="' . $direction . '"';
        } else {
            $curved_subtitle = '';
        }

        if ($subtitle) {
            $overlayHtml = array(
                'start' => '<div class="mapWithOverlay">[header level="4" style="' . $subtitle_style . '" ' . $curved_subtitle . ']' . $subtitle . '[/header]',
                'end' => '</div>');
        } else {
            $overlayHtml = array(
                'start' => '',
                'end' => '');
        }

        $html = do_shortcode($overlayHtml['start'] . $titleShortcode . '<div ' . $this->buildContainerAttributes($mainContainerAtts, $atts) . '></div>' . $overlayHtml['end']);

        return $html;
    }


    /**
     * returns inline js
     * @param $attributes
     * @param $id
     * @return string
     */
    protected function getInlineJS($attributes, $id)
    {


        return '

            jQuery(".googleMap:not(.markersGoogleMap)").each(function () {
                var atcenter = "";
                var $this = jQuery(this);
                var location = $this.data("location");
                var text = $this.data("text");
                var lat = $this.data("latitude");
    						var long = $this.data("longitude");

                var offset = -30;


                if (validateDataAttr($this.data("offset"))) {
                    offset = $this.data("offset");
                }

                if (validateDataAttr(location)) {

                    $this.gmap3({
				marker: {
                        address: location,
					options: {
                            visible: false
					},
					callback: function (marker) {
                            atcenter = marker.getPosition();
                        }
				},
				map: {
                        options: {
                        draggable: $this.data("map_draggable"),
                        streetViewControl: $this.data("street_view"),
                            //maxZoom:11,
                            zoom: 17,
						mapTypeId: google.maps.MapTypeId[$this.data("map_type")],
						scrollwheel: false,
						disableDoubleClickZoom: false,
						mapTypeControlOptions: {
                                //mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.HYBRID],
                                //style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                                //position: google.maps.ControlPosition.RIGHT_CENTER
                                mapTypeIds: []
						}
					},
                        events: {
                            idle: function () {
                                if (!$this.data("idle")) {
                                    $this.gmap3("get").panBy(0, offset);
                                    $this.data("idle", true);
                                }
                            }
                        }
                    },
				overlay: {
                        address: location,
					options: {
                            content: \'<div class="customMarker"><span>\' + text + \'</span><i></i></div>\',
						offset: {
                                y: -47,
							x: -25
						}
					}
				}
				//},"autofit"
			});

			// center on resize
			google.maps.event.addDomListener(window, "resize", function () {
                //var userLocation = new google.maps.LatLng(53.8018,-1.553);
                $this.gmap3("get").setCenter(atcenter);
                $this.gmap3("get").panBy(0, offset);
            });

			// set height
			$this.css("min-height", $this.data("height") + "px");
		} else

                if (validateDataAttr(lat)) {

                    $this.gmap3({
				marker: {
					latLng: [lat, long],
					options: {
                            visible: false
					},
					callback: function (marker) {
                            atcenter = marker.getPosition();
                        }
				},
				map: {
                        options: {
                        draggable: $this.data("map_draggable"),
                        streetViewControl: $this.data("street_view"),
                            //maxZoom:11,
                            zoom: 17,
						mapTypeId: google.maps.MapTypeId[$this.data("map_type")],

						scrollwheel: false,
						disableDoubleClickZoom: false,
						mapTypeControlOptions: {
                                //mapTypeIds: [google.maps.MapTypeId.ROADMAP, google.maps.MapTypeId.HYBRID],
                                //style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                                //position: google.maps.ControlPosition.RIGHT_CENTER
                                mapTypeIds: []
						}
					},
                        events: {
                            idle: function () {
                                if (!$this.data("idle")) {
                                    $this.gmap3("get").panBy(0, offset);
                                    $this.data("idle", true);
                                }
                            }
                        }
                    },
				overlay: {
						latLng: [lat, long],
					options: {
                            content: \'<div class="customMarker"><span>\' + text + \'</span><i></i></div>\',
						offset: {
                                y: -47,
							x: -25
						}
					}
				}
				//},"autofit"
			});

			// center on resize
			google.maps.event.addDomListener(window, "resize", function () {
                //var userLocation = new google.maps.LatLng(53.8018,-1.553);
                $this.gmap3("get").setCenter(atcenter);
                $this.gmap3("get").panBy(0, offset);
            });

			// set height
			$this.css("min-height", $this.data("height") + "px");
		}

            })


        ';
    }

    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'id' => array('label' => __('ID', 'ct_theme'), 'default' => '', 'type' => 'input'),
            'location' => array('label' => __('Location', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Enter location eg town", 'ct_theme')),
            "latitude" => array('label' => __('latitude', 'ct_theme'), 'default' => 0, 'type' => 'input'),
            "longitude" => array('label' => __('longitude', 'ct_theme'), 'default' => 0, 'type' => 'input'),
            "foodtruck_locator" => array('label' => __('Use location updater?', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'choices' => array('yes' => __('yes', 'ct_theme'), 'no' => __('no', 'ct_theme')), 'help' => __("Please go to Appearance - Theme Options - General - Location Updater for mor info", 'ct_theme')),
            'custom_marker' => array('label' => __('Label', 'ct_theme'), 'default' => __('We are here!', 'ct_theme'), 'type' => 'input', 'help' => __("Enter custom marker text. When using google maps, your label can be updated automatically - %foodtruck_locator_address% will be replaced with your current location.", 'ct_theme')),
            'height' => array('label' => __('height', 'ct_theme'), 'default' => '286', 'type' => 'input'),
            'offset' => array('label' => __('Map vertical offset', 'ct_theme'), 'default' => '0', 'type' => 'input'),
            'title' => array('label' => __('Title', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Title", 'ct_theme')),
            'subtitle' => array('label' => __('Subtitle', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Title", 'ct_theme')),
            'title_style' => array('label' => __('Select title style', 'ct_theme'), 'default' => '', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '' => '')),
            'subtitle_style' => array('label' => __('Select title style', 'ct_theme'), 'default' => '', 'type' => 'select', 'options' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
                '7' => '7',
                '8' => '8',
                '9' => '9',
                '' => '')),
            'curved_subtitle' => array('Curved header' => __('Curved subtitle', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'options' => array('yes' => 'yes', 'no' => 'no')),
            'radius' => array('label' => __('Curvature radius subtitle', 'ct_theme'), 'default' => '800', 'type' => "input"),
            'direction' => array('label' => __('Curvature direction subtitle', 'ct_theme'), 'default' => '1', 'type' => "input"),
            'street_view' => array('label' => __('Street View control ', 'ct_theme'), 'default' => 'true', 'type' => 'select', 'options' => array('true' => 'true', 'false' => 'false')),
            'map_type' => array('label' => __('Select map type', 'ct_theme'), 'default' => 'HYBRID', 'type' => 'select', 'options' => array(
                'ROADMAP' => 'Roadmap',
                'SATELLITE' => 'Satellite',
                'HYBRID' => 'Hybrid',
                'TERRAIN' => 'Terrain',
            )),
            'map_draggable' => array('label' => __('Draggable', 'ct_theme'), 'default' => 'true', 'type' => 'select', 'options' => array('true' => 'true', 'false' => 'false'), 'help' => __("locked automatically on mobile devices", 'ct_theme')),
            'class' => array('label' => __("Custom class", 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __('Adding custom class allows you to set diverse styles in css to the element. Type in name of class, which you defined in css. You can add as much classes as you like.', 'ct_theme')),
        );

    }
}

new ctGoogleMapsShortcode();