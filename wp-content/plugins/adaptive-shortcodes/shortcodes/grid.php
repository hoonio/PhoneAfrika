<?php

class AdapRowSC extends AdapShortcode
{

	function shortcode_handler($atts, $content = null)
	{
		return sprintf('<div class="row-fluid">%s</div>', do_shortcode($content));
	}

	function register_vc()
	{
		// TODO: Implement register_vc() method.
	}
}

new AdapRowSC('row');

class AdapSpanSC extends AdapShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		extract(
			shortcode_atts(
				array(
					'span' => '12',
					'offset' => false
				), $atts)
		);
		if ($offset != false) {
			$offset = 'offset' . $offset;
		} else {
			$offset = '';
		}
		return sprintf('<div class="span%s %s">%s</div>', $span, $offset, do_shortcode($content));
	}

	function register_vc()
	{
		// TODO: Implement register_vc() method.
	}
}

new AdapSpanSC('span');

