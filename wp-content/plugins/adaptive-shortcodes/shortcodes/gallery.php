<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hiron
 * Date: 8/4/13
 * Time: 12:36 PM
 * To change this template use File | Settings | File Templates.
 */

class AdapGallerySC extends AdapShortcode
{

	function shortcode_handler($atts, $content = null)
	{
		// This never gets executed because VC's handler takes care of this.
		// override the shortcode output via the Shortcode templating through the theme.
	}

	function register_vc()
	{
		wpb_add_param('vc_gallery', AdapAutoVCShortcode::bool_param('show_title', 'Show Title'));
		wpb_add_param('vc_gallery', AdapAutoVCShortcode::bool_param('show_caption', 'Show Caption'));
	}
}

global $gallery_sc_handler;
$gallery_sc_handler = new AdapGallerySC('vc_gallery');