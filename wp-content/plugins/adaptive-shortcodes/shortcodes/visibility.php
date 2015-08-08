<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hiron
 * Date: 6/4/13
 * Time: 3:38 PM
 * To change this template use File | Settings | File Templates.
 */

class AdapVisibleSC extends AdapShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'phone' => 'true',
					'tablet' => 'true',
					'desktop' => 'true'
				), $atts)
		);

		$phone = strtolower($phone) == 'true' ? 'visible-phone' : 'hidden-phone';
		$tablet = strtolower($tablet) == 'true' ? 'visible-tablet' : 'hidden-tablet';
		$desktop = strtolower($desktop) == 'true' ? 'visible-desktop' : 'hidden-desktop';

		return sprintf('<div class="%s %s %s">%s</div>', $phone, $tablet, $desktop, do_shortcode($content));
	}

	function register_vc()
	{
		// TODO: Implement register_vc() method.
	}
}

new AdapVisibleSC('visible');
