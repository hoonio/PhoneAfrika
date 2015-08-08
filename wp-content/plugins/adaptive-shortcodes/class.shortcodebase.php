<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hiron
 * Date: 6/11/13
 * Time: 12:45 PM
 * To change this template use File | Settings | File Templates.
 */

//here to remove the behavior of the
//default dropdown field which puts the value
//as a class on the select as well.
//this conflicts with a lot of css, so we use
//this tweaked version.
function adap_dropdown_settings_field($param, $param_value)
{
	$dependency = vc_generate_dependencies_attributes($param);

	$param_line = '<select name="' . $param['param_name'] . '" class="wpb_vc_param_value wpb-input wpb-select ' . $param['param_name'] . ' ' . $param['type'] . '"' . $dependency . '>';

	foreach ($param['value'] as $text_val => $val) {
		if (is_numeric($text_val) && is_string($val) || is_numeric($text_val) && is_numeric($val)) {
			$text_val = $val;
		}
		$text_val = __($text_val, "adap_sc");
		//$val = strtolower(str_replace(array(" "), array("_"), $val));
		$val = strtolower(str_replace(array(" "), array("_"), $val)); //issue #464 github
		$selected = '';
		if ($val == $param_value) $selected = ' selected="selected"';
		$param_line .= '<option value="' . $val . '"' . $selected . '>' . $text_val . '</option>';
	}
	$param_line .= '</select>';

	return $param_line;
}

add_action('init', 'add_adap_dropdown');
function add_adap_dropdown()
{
	if (function_exists('add_shortcode_param')) {
		add_shortcode_param('adap_dropdown', 'adap_dropdown_settings_field');
	}
}

abstract class AdapShortcode
{
	protected $sc_handle;

	function __construct($sc_handle, $fix_wpautop = true)
	{
		$this->sc_handle = $sc_handle;
		$this->register_shortcode();

		if ($fix_wpautop) {
			global $wpex_sc_array;
			$wpex_sc_array[] = $this->sc_handle;
		}

		add_action('admin_init', array($this, 'check_and_register_vc'));
	}

	function register_shortcode()
	{
		add_shortcode($this->sc_handle, array($this, 'shortcode_handler'));
	}

	function check_and_register_vc()
	{
		if (function_exists('wpb_map')) {
			$this->register_vc();
		}
	}

	abstract function shortcode_handler($atts, $content = null);

	abstract function register_vc();
}

abstract class AdapAutoVCShortcode
{
	protected $sc_handle;
	protected $params;
	static $image_size_param;
	static $orderby_param;
	static $order_param;
	static $target_param;
	static $css_animation_param;

	static function init()
	{
		$image_sizes = array();
		$image_sizes[] = 'full';
		$image_sizes = array_merge($image_sizes, get_intermediate_image_sizes());

		AdapAutoVCShortcode::$target_param = array(__("Same window", 'adap_sc') => "_self", __("New window", 'adap_sc') => "_blank");

		AdapAutoVCShortcode::$css_animation_param = array(
			"type" => "dropdown",
			"heading" => __("CSS Animation", 'adap_sc'),
			"param_name" => "css_animation",
			"admin_label" => true,
			"value" => array(__("No", 'adap_sc') => '', __("Top to bottom", 'adap_sc') => "top-to-bottom", __("Bottom to top", 'adap_sc') => "bottom-to-top", __("Left to right", 'adap_sc') => "left-to-right", __("Right to left", 'adap_sc') => "right-to-left", __("Appear from center", 'adap_sc') => "appear"),
			"description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", 'adap_sc')
		);

		AdapAutoVCShortcode::$image_size_param = array(
			'type' => 'dropdown',
			'holder' => 'div',
			'class' => '',
			'heading' => __('Image Size', 'adap_sc'),
			'param_name' => 'image_size',

			'sch_default' => 'full',
			'value' => $image_sizes,
			'description' => __('The image size', 'adap_sc')
		);

		AdapAutoVCShortcode::$orderby_param = array(
			'type' => 'dropdown',
			'holder' => 'div',
			'class' => '',
			'heading' => __('Order By', 'adap_sc'),
			'param_name' => 'orderby',

			'sch_default' => 'date',
			'value' => array(
				'Date' => 'date',
				'Date Last Modified' => 'modified',
				'Menu Order' => 'menu_order',
				'None' => 'none',
				'ID' => 'ID',
				'Author' => 'author',
				'Title' => 'title',
				'Name' => 'name',
				'Parent' => 'parent',
				'Random' => 'rand',
				'Popularity (Comment Count)' => 'comment_count'
			),
			'description' => __('The parameter to order by.', 'adap_sc')
		);

		AdapAutoVCShortcode::$order_param = array(
			'type' => 'dropdown',
			'holder' => 'div',
			'class' => '',
			'heading' => __('Order', 'adap_sc'),
			'param_name' => 'order',
			'sch_default' => 'DESC',
			'value' => array(
				'Descending' => 'DESC',
				'Ascending' => 'ASC'
			),
			'description' => __('The direction to apply the ordering.', 'adap_sc')
		);
	}

	static function bool_param($param_name, $heading, $true_string = null, $false_string = null, $default_is_true = true, $dependency = false)
	{
		if ($true_string == null) {
			$true_string = $heading;
		}

		if ($false_string == null) {
			$false_string = 'Don\'t ' . $heading;
		}

		if ($default_is_true === true || $default_is_true == 'true') {
			$sch_default = 'true';
			$value = array($true_string => 'true', $false_string => 'false');
		} else {
			$sch_default = 'false';
			$value = array($false_string => 'false', $true_string => 'true');
		}

		$ret_array = array(
			'type' => 'dropdown',
			'heading' => $heading,
			'param_name' => $param_name,
			'sch_default' => $sch_default,
			'value' => $value
		);

		if ($dependency)
			$ret_array['dependency'] = $dependency;

		return $ret_array;
	}

	function __construct($sc_handle, $fix_wpautop = true)
	{
		$this->sc_handle = $sc_handle;
		$this->register_shortcode();

		if ($fix_wpautop) {
			global $wpex_sc_array;
			$wpex_sc_array[] = $this->sc_handle;
		}

		add_action('init', array($this, 'configureParams'));
		add_action('admin_init', array($this, 'check_and_register_vc'));

	}

	function register_shortcode()
	{
		add_shortcode($this->sc_handle, array($this, 'shortcode_handler'));
	}

	function check_and_register_vc()
	{
		if (function_exists('wpb_map')) {
			if (!empty($this->params)) {
				$this->params['icon'] = "icon-wpb-adap_" . $this->sc_handle;
				wpb_map($this->params);
			}
		}
	}

	abstract function shortcode_handler($atts, $content = null);

	abstract function configureParams();

	function getShortcodeDefaults()
	{
		$params = $this->params['params'];
		$defaults = array();
		if (is_array($params)) {
			foreach ($params as $p) {
				$val = isset($p['sch_default']) ? $p['sch_default'] : $p['value'];
				if ($p['param_name'] == 'order') $val = strtoupper($val);
				$defaults[$p['param_name']] = $val;
			}
		}
		return $defaults;
	}

	function getPreparedAtts($atts, $content)
	{
		$defs = $this->getShortcodeDefaults();
		if ($content != null) unset($defs['content']);


		if (is_array($atts)) {
			foreach ($atts as $a_key => $a_value) {
				if (!isset($defs[$a_key])) {
					$defs[$a_key] = $a_value;
				}
			}
		} else {
			$atts = array();
		}

		return shortcode_atts($defs, $atts);
	}
}

AdapAutoVCShortcode::init();


add_action('init', 'adap_vc_container_class');

function adap_vc_container_class()
{
	if (class_exists('WPBakeryShortCode_VC_Column')) {
		class WPBakeryShortCode_Adap_Container extends WPBakeryShortCode_VC_Column
		{
			public function getColumnControls($controls, $extended_css = '')
			{

				$title = $extended_css != 'bottom-controls' ? '<h4>' . $this->settings['name'] . '</h4>' : '';

				$controls_start = $title . '<div class="controls controls_column' . (!empty($extended_css) ? " {$extended_css}" : '') . '">';
				$controls_end = '</div>';

				if ($extended_css == 'bottom-controls') $control_title = __('Append to this column', 'adap_sc');
				else $control_title = __('Prepend to this column', 'adap_sc');

				$controls_add = ' <a class="column_add" href="#" title="' . $control_title . '"></a>';
				$controls_edit = ' <a class="column_edit" href="#" title="' . __('Edit this column', 'adap_sc') . '"></a>';
				$controls_delete = '<a class="column_delete" href="#" title="' . __('Delete this column', 'adap_sc') . '"></a>';

				return $controls_start . $controls_add . $controls_edit . $controls_delete . $controls_end;
			}

			/**
			 * We override here in order to remove the vc_span* class.
			 * @param $width
			 * @param $i
			 * @return string
			 */
			public function mainHtmlBlockParams($width, $i)
			{
				return 'data-element_type="' . $this->settings["base"] . '" data-vc-column-width="' . wpb_vc_get_column_width_indent($width[$i]) . '" class="adap_content_holder wpb_' . $this->settings['base'] . ' wpb_sortable ' . ' wpb_content_holder"' . $this->customAdminBlockParams();
			}

		}
	}
}