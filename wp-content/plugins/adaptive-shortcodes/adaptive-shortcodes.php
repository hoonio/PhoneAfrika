<?php
/*
Plugin Name: Adaptive Shortcodes
Plugin URI: http://wpadaptive.com/
Description: The plugin that provides shortcodes for usage with Adaptive Themes WordPress themes
Version: 1.0.1
Author: Adaptive Themes
Author URI: http://wpadaptive.com/
License: Split License (http://support.envato.com/index.php?/Knowledgebase/Article/View/428)
*/

define("ADAP_SC_MIN_WP_VERSION", '3.5');
define("ADAP_SC_SUPPORTED_WP_VERSION", version_compare(get_bloginfo("version"), ADAP_SC_MIN_WP_VERSION, '>='));

require_once(WP_PLUGIN_DIR . "/" . basename(dirname(__FILE__)) . "/common.php");

require_once(WP_PLUGIN_DIR . "/" . basename(dirname(__FILE__)) . "/library/icon-listings.php");

require_once(WP_PLUGIN_DIR . "/" . basename(dirname(__FILE__)) . "/inc/testimonials/testimonials.php");

require_once(AdapCommon::get_base_path() . '/class.shortcodebase.php');

//Auto import all the PHP files in the "shortcodes" folder
$scdir = AdapCommon::get_base_path() . "/shortcodes";
foreach (scandir($scdir) as $filename) {
    $path = $scdir . "/" . $filename;
    if (is_file($path)) {
        require_once $path;
    }
}

// Setup a variable for all custom CSS that will be enqueued via wp_add_inline_style
$custom_css = '';

class AdapSC
{
    public static function init()
    {
        if (IS_ADMIN()) {

            add_action('admin_enqueue_scripts', array('AdapSC', 'admin_enqueue_css'));

        } else {
            add_action('wp_enqueue_scripts', array('AdapSC', 'enqueue_scripts'));
            add_action('wp_enqueue_scripts', array('AdapSC', 'enqueue_styles'), 901);
            add_action('wp_head', array('AdapSC', 'enqueue_custom_styles'));
			add_action('wp_footer', array('AdapSC', 'enqueue_custom_inline_styles'));

		}
    }

    public static function enqueue_scripts()
    {
        wp_enqueue_script('adap-sc-js', AdapCommon::get_base_url() . '/js/sc-script.js', array('jquery', 'underscore'), false, true);
        wp_enqueue_script('tumblr', 'http://platform.tumblr.com/v1/share.js', false, false, true);
    }

    public static function enqueue_styles()
    {
        wp_enqueue_style('adap-sc-css', AdapCommon::get_base_url() . '/css/shortcodes.css');
    }

    public static function enqueue_custom_styles()
    {
		wp_enqueue_style('adap-custom-css', AdapCommon::get_base_url() . '/css/shortcodes-custom.css');
    }

	public static function enqueue_custom_inline_styles()
	{
		global $custom_css;
		wp_add_inline_style('adap-custom-css', $custom_css);
	}

    public static function admin_enqueue_css()
    {
        wp_enqueue_style('adap-sc', AdapCommon::get_base_url() . '/css/adap-sc-admin.css');
    }

}

AdapSC::init();


// Non-abusive way of cleaning up any <p> and <br/> elements auto-added by WordPress
// around shortcodes. Note that it only applies to the shortcodes included with this plugin
//function wpex_fix_shortcodes($content){
//    $array = array (
//        '<p>[' => '[',
//        ']</p>' => ']',
//        ']<br />' => ']'
//    );
//
//    $content = strtr($content, $array);
//    return $content;
//}

function adap_sc_remove_wpautop($content) {
	$content = do_shortcode( shortcode_unautop($content) );
	$content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );
	return $content;
}

if (!function_exists('wpex_fix_shortcodes')) {
    global $wpex_sc_array;

    function wpex_fix_shortcodes($content)
    {
        global $wpex_sc_array;

        // array of custom shortcodes requiring the fix
        $block = join("|", $wpex_sc_array
//        array(
//            "accordion",
//            "accordion_item",
//            "alert",
//            "box",
//            "button",
//            "button_group",
//            "button_toolbar",
//            "carousel",
//            "carousel_item",
//            "divider",
//            "row",
//            "span",
//            "framed_image",
//            "progress",
//            "searchbar",
//            "tab",
//            "tabs",
//            "tooltip",
//            "popover",
//            "visibility"
//        )
        );

        // opening tag
        $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content);

        // closing tag
        $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $rep);

        return $rep;
    }

    add_filter('the_content', 'wpex_fix_shortcodes');
}

function run_shortcodes_on_text_widgets($content)
{
    return do_shortcode($content);
}

add_filter('widget_text', 'run_shortcodes_on_text_widgets');


function custom_css_classes_for_vc_row_and_vc_column($class_string, $tag)
{
    if ($tag == 'vc_row' || $tag == 'vc_row_inner') {
        $class_string = str_replace('vc_row-fluid', 'row-fluid', $class_string);
        $class_string = str_replace('wpb_row', '', $class_string);
    }
    if ($tag == 'vc_column' || $tag == 'vc_column_inner') {
        $class_string = preg_replace('/vc_span(\d{1,2})/', 'span$1', $class_string);
        $class_string = str_replace('wpb_column', '', $class_string);
        $class_string = str_replace('column_container', '', $class_string);
    }
    return $class_string;
}

// Filter to Replace default css class for vc_row shortcode and vc_column
add_filter('vc_shortcodes_css_class', 'custom_css_classes_for_vc_row_and_vc_column', 10, 2);


if (!function_exists('html2rgb')) {
    function html2rgb($color)
    {
        if ($color[0] == '#')
            $color = substr($color, 1);
        if (strlen($color) == 6)
            list($r, $g, $b) = array($color[0] . $color[1],
                $color[2] . $color[3],
                $color[4] . $color[5]);
        elseif (strlen($color) == 3)
            list($r, $g, $b) = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]); else
            return false;
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        return array($r, $g, $b);
    }
}