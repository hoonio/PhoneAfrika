<?php

class AdapTestimonialsSC extends AdapAutoVCShortcode
{

	function shortcode_handler($atts, $content = null)
	{
		$args = $this->getPreparedAtts($atts, $content);

		// Extract args into variables
		extract($this->getPreparedAtts($atts, $content));

		// Generate a Unique ID for the Element
		$element_id = uniqid('testimonial_');

		// Fix integers.
		if (isset($args['limit'])) $args['limit'] = intval($args['limit']);
		if (isset($args['id'])) $args['id'] = intval($args['id']);
		if (isset($args['size']) && (0 < intval($args['size']))) $args['size'] = intval($args['size']);
//		if (isset($args['category']) && is_numeric($args['category'])) $args['category'] = intval($args['category']);
		// Fix booleans.
		foreach (array('display_url', 'pagination') as $k => $v) {
			if (isset($args[$v]) && ('true' == $args[$v])) {
				$args[$v] = true;
			} else {
				$args[$v] = false;
			}
		}
		$args['display_author'] = true;
		$args['display_avatar'] = false;


		// Generate Testimonial
		ob_start();

		$style_class = '';
		if (isset($style)) {
			$style_class = 'testimonial-shortcode-style-' . $style;
		}

		echo '<div class="testimonial-shortcode ' . $style_class . '" id="' . $element_id . '">';

		do_action('adap_testimonials', $args);

		echo '</div>';

		$ret_val = ob_get_contents();
		ob_end_clean();

		global $custom_css;
		ob_start();
		?>

		<?php if (isset($text_color)) { ?>
		#<?php echo $element_id; ?> .testimonials-text {
		color: <?php echo $text_color; ?>;
		}
	<?php } ?>

		<?php if (isset($background_color)) { ?>
		#<?php echo $element_id; ?> .testimonials-text {
		background: <?php echo $background_color; ?>;
		<?php
		if (isset($opacity) && $opacity != '1') {
			//convert background color to hex
			$rgb = html2rgb($background_color);
			printf('background: rgba( %s, %s, %s, %s);', $rgb[0], $rgb[1], $rgb[2], $opacity);
		}
		?>
		}
		#<?php echo $element_id; ?> .testimonials-text .arrow-down {
		border-top-color: <?php echo $background_color; ?>;

		<?php
		if (isset($opacity) && $opacity != '1') {
			//convert background color to hex
			echo 'opacity: ' . $opacity . ';';
		}
		?>

		}
	<?php } ?>

		<?php if (isset($author_name_color)) { ?>
		#<?php echo $element_id; ?> .author-name,
		#<?php echo $element_id; ?> .testimonial-shortcode-user-icon,
		#<?php echo $element_id; ?> .testimonial-shortcode-user-chevron {
		color: <?php echo $author_name_color; ?>;
		}
	<?php } ?>

		<?php if (isset($author_title_color)) { ?>
		#<?php echo $element_id; ?> .author-title {
		color: <?php echo $author_title_color; ?>;
		}
	<?php } ?>


		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();

		// Return the shortcode
		return $ret_val;
	}

	function configureParams()
	{
		$cats = get_terms('testimonial-category');
		$cat_vals = array('None' => '');
		foreach ($cats as $c) {
			$cat_vals[$c->name] = $c->slug;
		}


		$this->params = array(
			'name' => 'Testimonials',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => __('Number of Items', 'adap_sc'),
					'param_name' => 'limit',
					'value' => '5',
					'description' => __('The number of testimonials to show', 'adap_sc')
				),
				array(
					'type' => 'textfield',
					'heading' => __('Interval', 'adap_sc'),
					'param_name' => 'interval',
					'value' => '7000',
					'description' => __('The rate (in milliseconds) to animate through the testimonials', 'adap_sc')
				),
				AdapAutoVCShortcode::$order_param,
				AdapAutoVCShortcode::$orderby_param,
//                AdapAutoVCShortcode::bool_param('display_author', 'Display Author'),
//                AdapAutoVCShortcode::bool_param('display_avatar', 'Display Avatar'),
				array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Testimonial Category', 'adap_sc'),
					'param_name' => 'category',
					'sch_default' => null,
					'value' => $cat_vals,
					'description' => __('The category to draw testimonials from.', 'adap_sc')
				),
				array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Style", 'adap_sc'),
					'param_name' => 'style',
					'sch_default' => 'normal',
					'value' => array('Style #1 (bubble)' => 'style1', 'Style #2 (block)' => 'style2'),
					'description' => __('The style of the testimonials.', 'adap_sc'),
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Text Color', 'adap_sc'),
					'param_name' => 'text_color',
					'value' => null,
					'description' => __('The text color of testimonials.', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Background Color', 'adap_sc'),
					'param_name' => 'background_color',
					'value' => null,
					'description' => __('The background color of testimonials.', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Author Name Color', 'adap_sc'),
					'param_name' => 'author_name_color',
					'value' => null,
					'description' => __('The text color of the author\'s name.', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Author Title Color', 'adap_sc'),
					'param_name' => 'author_title_color',
					'value' => null,
					'description' => __('The text color of the author\'s name.', 'adap_sc'),
				),
				array(
					'type' => 'textfield',
					'heading' => __('Opacity', 'adap_sc'),
					'param_name' => 'opacity',
					'value' => '1',
					'description' => __('The opacity of the testimonial (0-1 decimal)', 'adap_sc')
				),)
		);
	}

}

new AdapTestimonialsSC('testimonials');