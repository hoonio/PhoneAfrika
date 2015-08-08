<?php

class AdapLeadCopySC extends AdapShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		return sprintf('<p class="lead">%s</p>', do_shortcode($content));
	}

	function register_vc()
	{
		// TODO: Implement register_vc() method.
	}
}

new AdapLeadCopySC('lead_copy');


class AdapAlignSC extends AdapShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		$defaults = array(
			'align' => 'left',
		);
		extract(shortcode_atts($defaults, $atts));

		return sprintf('<p class="text-%s">%s</p>', $align, do_shortcode($content));
	}

	function register_vc()
	{
		// TODO: Implement register_vc() method.
	}
}

new AdapAlignSC('align');

class AdapEmphasisSC extends AdapShortcode
{

	function shortcode_handler($atts, $content = null)
	{
		$defaults = array(
			'style' => 'warning',
		);
		extract(shortcode_atts($defaults, $atts));

		if ($style != 'muted') {
			$style = 'text-' . $style;
		}
		return sprintf('<p class="%s">%s</p>', $style, do_shortcode($content));
	}

	function register_vc()
	{
		// TODO: Implement register_vc() method.
	}
}

new AdapEmphasisSC('emphasis');

class AdapAbbrSC extends AdapShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		$defaults = array(
			'title' => 'Hover Text',
			'initialism' => false
		);
		extract(shortcode_atts($defaults, $atts));

		$class = $initialism != false ? $initialism : '';

		return sprintf('<abbr title="%s" class="%s">%s</abbr>', $title, $class, do_shortcode($content));
	}

	function register_vc()
	{
		// TODO: Implement register_vc() method.
	}
}

new AdapAbbrSC('abbr');


class AdapDescriptionListSC extends AdapShortcode
{

	function shortcode_handler($atts, $content = null)
	{
		return sprintf('<dl>%s</dl>', do_shortcode($content));
	}

	function register_vc()
	{
		// TODO: Implement register_vc() method.
	}
}

new AdapDescriptionListSC('description_list');

class AdapDescriptionSC extends AdapShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		$defaults = array(
			'title' => 'Description Title'
		);
		extract(shortcode_atts($defaults, $atts));
		return sprintf('<dt>%s</dt><dd>%s</dd>', $title, do_shortcode($content));
	}

	function register_vc()
	{
		// TODO: Implement register_vc() method.
	}
}

new AdapDescriptionSC('description');

class AdapLabelSC extends AdapShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		$defaults = array(
			'background_color' => null,
			'text_color' => null,
			'clear' => 'false'
		);
		extract(shortcode_atts($defaults, $atts));

		// Generate a Unique ID for the Element
		$element_id = uniqid('label_');

		// Configure Custom Colors
		global $custom_css;
		ob_start();
		?>
		#<?php echo $element_id; ?> {

		<?php if ($background_color !== null) : ?>
		background: <?php echo $background_color; ?>;
	<?php endif; ?>
		<?php if ($text_color !== null) : ?>
		color: <?php echo $text_color; ?>;
	<?php endif; ?>
		}

		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();

		// Generate label
		ob_start();
		?>
		<span id="<?php echo $element_id; ?>" class="label label-shortcode"><?php echo do_shortcode($content); ?></span>
		<?php if (isset($clear) && $clear != 'false') { ?>
		<div class="clear"></div>
	<?php } ?>
		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;

	}

	function register_vc()
	{
		// TODO: Implement register_vc() method.
	}
}

new AdapLabelSC('label');

class AdapBadgeSC extends AdapShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		$defaults = array(
			'background_color' => null,
			'text_color' => null,
			'clear' => 'false'
		);
		extract(shortcode_atts($defaults, $atts));

		// Generate a Unique ID for the Element
		$element_id = uniqid('label_');

		// Configure Custom Colors
		global $custom_css;
		ob_start();
		?>
		#<?php echo $element_id; ?> {
		<?php if ($background_color !== null) : ?>
		background: <?php echo $background_color; ?>;
	<?php endif; ?>
		<?php if ($text_color !== null) : ?>
		color: <?php echo $text_color; ?>;
	<?php endif; ?>
		}

		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();

		// Generate label
		ob_start();
		?>
		<span id="<?php echo $element_id; ?>" class="badge badge-shortcode"><?php echo do_shortcode($content); ?></span>
		<?php if (isset($clear) && $clear != 'false') { ?>
		<div class="clear"></div>
	<?php } ?>
		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	function register_vc()
	{
		// TODO: Implement register_vc() method.
	}
}

new AdapBadgeSC('badge');


class AdapBigTextSC extends AdapShortcode
{

	function shortcode_handler($atts, $content = null)
	{

		ob_start();
		?>
		<span class="big-text-shortcode">
<?php echo $content; ?>
        </span>
		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	function register_vc()
	{
		// TODO: Implement register_vc() method.
	}

}

new AdapBigTextSC('bigtext');


class AdapCustomTextSC extends AdapShortcode
{

	function shortcode_handler($atts, $content = null)
	{
		$defaults = array(
			'font_size' => null,
			'font_weight' => null,
			'line_height' => null
		);
		extract(shortcode_atts($defaults, $atts));


		// Generate a Unique ID for the Element
		$element_id = uniqid('customtext_');

		global $custom_css;
		ob_start();
		?>

		#<?php echo $element_id; ?> {

		<?php if (!is_null($font_size)) { ?>
		font-size: <?php echo $font_size; ?>;
	<?php } ?>

		<?php if (!is_null($font_weight)) { ?>
		font-weight: <?php echo $font_weight; ?>;
	<?php } ?>

		<?php if (!is_null($line_height)) { ?>
		line-height: <?php echo $line_height; ?>;
	<?php } ?>

		}
		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();


		ob_start();
		?>
		<span id="<?php echo $element_id; ?>" class="custom-text-shortcode"><?php echo $content; ?></span>
		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	function register_vc()
	{
		// TODO: Implement register_vc() method.
	}

}

new AdapCustomTextSC('customtext');


class AdapLeadSC extends AdapAutoVCShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		extract($this->getPreparedAtts($atts, $content));

		return sprintf('<span class="lead">%s</span>', do_shortcode($content));
	}

	function configureParams()
	{
		$this->params = array(
			'name' => 'Lead',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),
			'params' => array(
				array(
					"type" => "textarea_html",
					"holder" => "div",
					"class" => "",
					"heading" => __("Content", 'adap_sc'),
					"param_name" => "content",
					"value" => __("This content of the lead text.", 'adap_sc'),
//                    "description" => __("This is an example well content.")
				)
			)
		);
	}
}

new AdapLeadSC('lead');

class AdapIntroSC extends AdapAutoVCShortcode {

	function shortcode_handler($atts, $content = null)
	{
		extract($this->getPreparedAtts($atts, $content));

		return sprintf('<span class="intro">%s</span>', do_shortcode($content));
	}

	function configureParams()
	{
		$this->params = array(
			'name' => 'Intro',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),
			'params' => array(
				array(
					"type" => "textarea_html",
					"holder" => "div",
					"class" => "",
					"heading" => __("Content", 'adap_sc'),
					"param_name" => "content",
					"value" => __("This content of the intro text.", 'adap_sc'),
//                    "description" => __("This is an example well content.")
				)
			)
		);
	}
}

new AdapIntroSC('intro');

class AdapSmallSC extends AdapAutoVCShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		extract($this->getPreparedAtts($atts, $content));

		return sprintf('<small>%s</small>', do_shortcode($content));
	}

	function configureParams()
	{
		$this->params = array(
			'name' => 'Small',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),
			'params' => array(
				array(
					"type" => "textarea_html",
					"holder" => "div",
					"class" => "",
					"heading" => __("Content", 'adap_sc'),
					"param_name" => "content",
					"value" => __("This content of the lead text.", 'adap_sc'),
//                    "description" => __("This is an example well content.")
				)
			)
		);
	}
}

new AdapSmallSC('small');



