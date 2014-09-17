<?php
/**
 * Table shortcode
 */
class ctTableShortcode extends ctShortcode {

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Table';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'table';
	}

	/**
	 * Returns shortcode type
	 * @return mixed|string
	 */

	public function getShortcodeType() {
		return self::TYPE_SHORTCODE_ENCLOSING;
	}


	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return string
	 */

	public function handle($atts, $content = null) {
		extract(shortcode_atts($this->extractShortcodeAttributes($atts), $atts));

        $titleShortcode = $title? '[paragraph]'.$title.'[/paragraph]' : '';
		return do_shortcode($titleShortcode.'<div class="'.$class.' pretty-table table-responsive"><table class="table">' . $content . '</table></div>');
	}

	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		return array(
            'title'=> array('label' => __('Header', 'ct_theme'), 'default' => '', 'type' => 'input'),
			'content' => array('label' => __('content', 'ct_theme'), 'default' => '', 'type' => 'textarea', 'help' => __("Please enter complete HTML Table markup with &lt;table&gt;..&lt;/table&gt;",'ct_theme'), 'example' => array($this, 'getExampleContent')),
            'class'=> array('label' => __('Class', 'ct_theme'), 'default' => '', 'type' => 'input'),
        );
	}

	/**
	 * Returns example content
	 * @return string
	 */
	public function getExampleContent() {
		return ' <thead>
                    <tr>
                        <th>SPECS</th>
                        <th>XEON E5-2687W</th>
                        <th>CORE I7 990X</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>BRAND</td>
                        <td>Intel</td>
                        <td>Intel</td>
                    </tr>
                    <tr>
                        <td>SPEED</td>
                        <td>3.10GHz</td>
                        <td>3.47GHz</td>
                    </tr>
                    <tr>
                        <td>COST</td>
                        <td>$1800</td>
                        <td>$1100</td>
                    </tr>
                    <tr>
                        <td>CPU MARK</td>
                        <td>17,872</td>
                        <td>10,550</td>
                    </tr>
                    </tbody>
               ';

	}
}

new ctTableShortcode();