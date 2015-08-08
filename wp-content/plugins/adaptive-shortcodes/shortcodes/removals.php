<?php

add_action('init', 'adap_remove_vc_shortcodes');

function adap_remove_vc_shortcodes()
{
	//NOTE: removal calls associated with OVERRIDING are done inline
	// with the shortcode class definitions (See accordion.php and tab.php etc.).

	if (function_exists('wpb_remove')) {
		//Remove the vc shortcodes that we don't support
		wpb_remove('vc_tour');
		wpb_remove('vc_posts_slider');
		wpb_remove('vc_single_image');
		wpb_remove('vc_button');
		wpb_remove('vc_cta_button');
		wpb_remove('vc_teaser_grid');
		wpb_remove('vc_progress_bar');
		wpb_remove('vc_separator');
		wpb_remove('vc_text_separator');
	}
}