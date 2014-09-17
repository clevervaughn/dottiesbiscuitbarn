<?php

/**
 * Google maps shortcode
 */
class ctGoogleMapMarkerShortcode extends ctShortcode
{

    /**
     * Markers counter
     * @var int
     */

    public  static $counter = 0;

    /**
     * @inheritdoc
     */
    public function __construct() {
        parent::__construct();

        //connect for additional code
        //remember - method must be PUBLIC!
        $this->connectPreFilter('google_maps_markers', array($this, 'handlePreFilter'));
    }

    /**
     * Returns name
     * @return string|void
     */
    public function getName()
    {
        return 'Google map Marker';
    }

    /**
     * Shortcode name
     * @return string
     */
    public function getShortcodeName()
    {
        return 'google_map_marker';
    }


    /**
     * Parent shortcode name
     * @return null
     */

    public function getParentShortcodeName() {
        return 'google_maps_markers';
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

        $markerArray = array();

        if ($location != '') {


            $markerArray['address'] = $location;
            $markerArray['data'] = $label;
            $markerArray['options'] = array('icon' => $icon);
        } else {
            $markerArray['latLng'] = array($latitude, $longitude);
            $markerArray['data'] = $label;
            $markerArray['options'] = array('icon' => $icon);
        }


        $this->setData(self::$counter++, $markerArray);

      }

    /**
     * Adds content before filters
     * @param string $content
     * @return string
     */
    public function handlePreFilter($content) {
        return $this->getAllData();
    }




    /**
     * Returns config
     * @return null
     */
    public function getAttributes()
    {
        return array(
            'label' => array('label' => __('Label', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Label", 'ct_theme')),
            'location' => array('label' => __('Location', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Enter location eg town", 'ct_theme')),
            "latitude" => array('label' => __('latitude', 'ct_theme'), 'default' => 0, 'type' => 'input'),
            "longitude" => array('label' => __('longitude', 'ct_theme'), 'default' => 0, 'type' => 'input'),
            'icon' => array('label' => __("Icon", 'ct_theme'), 'default' => get_stylesheet_directory_uri() . '/assets/images/marker-icon.png', 'type' => 'image', 'help' => __("Image source", 'ct_theme')),

        );

    }
}

new ctGoogleMapMarkerShortcode();