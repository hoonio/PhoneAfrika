<?php

class AdapProgressSC extends AdapAutoVCShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		wp_enqueue_script('jquery-waypoints');
		wp_enqueue_script('jquery-countto');

		extract($this->getPreparedAtts($atts, $content));

		$percentage = trim($percent, '%');
		// Configure Icons
		$show_icon = false;
		$icon = $icon_type == 'fontawesome' ? $fontawesome_icon : $entypo_icon;
		if ($icon_type == 'fontawesome' && $fontawesome_icon != 'none') {
			$icon_class = 'icon' . '-' . $icon;
			$show_icon = true;
		} else if ($entypo_icon != 'none') {
			$icon_class = 'entypo' . '-' . $icon;
			$show_icon = true;
		}

		// Bar Color
		if (isset($bar_color) && $bar_color != 'custom') {
			$bar_custom_color = null;
		}


		// Generate a Unique ID for the Element
		$element_id = uniqid('progressbar_');

		// Configure Custom CSS
		global $custom_css;
		ob_start();
		?>

		<?php if ($icon_color !== null) : ?>
		#<?php echo $element_id; ?> .progress-bar-icon {
		color: <?php echo $icon_color; ?>;
		}
	<?php endif; ?>

		<?php if ($label_color !== null) : ?>
		#<?php echo $element_id; ?> .progress-bar-label {
		color: <?php echo $label_color; ?>;
		}
	<?php endif; ?>

		<?php if ($label_background_color !== null) : ?>
		#<?php echo $element_id; ?> .progress-bar-label-wrapper {
		background-color: <?php echo $label_background_color; ?>;
		}
	<?php endif; ?>

		<?php if ($bar_custom_color) { ?>
		#<?php echo $element_id; ?> .progress .bar {
		background: <?php echo $bar_custom_color; ?>;
		}
	<?php } ?>

		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();

		ob_start();
		?>

		<div id="<?php echo $element_id; ?>"
			 class="progress-bar-shortcode progress-bar-icon-type-<?php echo $icon_type ?>">
			<div class="progress-bar-label-wrapper">
				<?php if ($show_icon) { ?>
					<i class="<?php echo $icon_class; ?> progress-bar-icon"></i>
				<?php } ?>
				<h4 class="progress-bar-label"><?php echo $label; ?></h4>
			</div>
			<div class="progress">
				<div class="bar" style="width: <?php echo $percentage; ?>%;"></div>
			</div>
		</div>

		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	function configureParams()
	{
		global $icon_listing_with_none;
		global $entypo_listing_with_none;
		global $icon_type_listing;

		$this->params = array(
			'name' => 'Progress Bar',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),

			'params' => array(
				array(
					"type" => "textfield",
					"heading" => __("Percentage", 'adap_sc'),
					"param_name" => "percent",
					"value" => '75',
					"description" => __("What percentage should the bar be filled?", 'adap_sc')
				),
				array(
					"type" => "textfield",
					"heading" => __("Label", 'adap_sc'),
					"param_name" => "label",
					"value" => 'Example Bar Label',
					"description" => __("The label to display above the progress bar.", 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Label Color', 'adap_sc'),
					'param_name' => 'label_color',
					'value' => null,
					'description' => __('The text color of the label.', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Label Background Color', 'adap_sc'),
					'param_name' => 'label_background_color',
					'value' => null,
					'description' => __('The background color of the label.', 'adap_sc')
				),

//                AdapAutoVCShortcode::bool_param('striped', 'Stripe Styling'),
//                AdapAutoVCShortcode::bool_param('animated', 'Animate Strips', null, null, true,
//                    array('element' => "striped", 'value' => array('true'))),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Bar Custom Color', 'adap_sc'),
					'param_name' => 'bar_custom_color',
					'value' => null,
					'description' => __('The color of the progress bar.', 'adap_sc'),
				),
				array(
					'type' => 'adap_dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Icon Type", 'adap_sc'),
					'param_name' => 'icon_type',
					'sch_default' => 'None',
					'value' => $icon_type_listing,
					'description' => __('Which icon set would you like to use?', 'adap_sc')
				),
				array(
					'type' => 'adap_dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Font Awesome Icon", 'adap_sc'),
					'param_name' => 'fontawesome_icon',
					'sch_default' => 'None',
					'value' => $icon_listing_with_none,
					'description' => __('Choose a Font Awesome Icon to appear at the top of this content box. <a target="_blank" href="http://fortawesome.github.io/Font-Awesome/icons/">Browse the icons here</a>.', 'adap_sc'),
					"dependency" => Array('element' => "icon_type", 'value' => array('fontawesome'))
				),
				array(
					'type' => 'adap_dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Entypo Icon", 'adap_sc'),
					'param_name' => 'entypo_icon',
					'sch_default' => 'None',
					'value' => $entypo_listing_with_none,
					'description' => __('Choose an Entypo Icon to appear at the top of this content box. <a target="_blank" href="http://www.entypo.com/">Browse the icons here</a>.', 'adap_sc'),
					"dependency" => Array('element' => "icon_type", 'value' => array('entypo'))
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Icon Color', 'adap_sc'),
					'param_name' => 'icon_color',
					'value' => null,
					'description' => __('The color of the icon.', 'adap_sc'),
				)
			)
		);
	}
}

new AdapProgressSC('progress');

class AdapCounterBoxSC extends AdapAutoVCShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		wp_enqueue_script('jquery-waypoints');
		wp_enqueue_script('jquery-countto');

		extract($this->getPreparedAtts($atts, $content));

		$to = trim($to, '%');
		$from = trim($from, '%');

		ob_start();

		// Generate a Unique ID for the Element
		$element_id = uniqid('animatedcircle_');

		global $custom_css;
		ob_start();
		?>

		<?php if ($background_color !== null) : ?>
		#<?php echo $element_id; ?> {
		background-color: <?php echo $background_color; ?>;
		}
	<?php endif; ?>


		<?php if ($percentage_count_color !== null) : ?>
		#<?php echo $element_id; ?> .count-wrapper {
		color: <?php echo $percentage_count_color; ?>;
		}
	<?php endif; ?>

		<?php if ($caption_color !== null) : ?>
		#<?php echo $element_id; ?> .count-caption {
		color: <?php echo $caption_color; ?>;
		}
	<?php endif; ?>

		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();


		$caption_class = '';
		if ($bold_caption && $bold_caption == "true") {
			$caption_class = 'bolded-caption';
		}

		$counter_class = '';
		if ($bold_percent && $bold_percent == "true") {
			$counter_class = 'bolded-counter';
		}


		?>

		<div id="<?php echo $element_id; ?>" class="count-box thumbnail">
			<div class="count-wrapper <?php echo $counter_class; ?>"><span class="count-inner" data-speed="900"
																		   data-from="<?php echo $from; ?>"
																		   data-to="<?php echo $to; ?>"></span>%
			</div>
			<div class="count-caption <?php echo $caption_class; ?>"><?php echo $caption; ?></div>
		</div>

		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	function configureParams()
	{
		$this->params = array(
			'name' => 'Counter Box',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content'),

			'params' => array(
				array(
					"type" => "textfield",
					"heading" => __("Final Percentage", 'adap_sc'),
					"param_name" => "to",
					"value" => '100',
					"description" => __("The target percentage (should be a number between 1 and 100).", 'adap_sc')
				),
				array(
					"type" => "textfield",
					"heading" => __("Start Percentage", 'adap_sc'),
					"param_name" => "from",
					"value" => '0',
					"description" => __("The starting percentage (should be a number between 0 and 100).", 'adap_sc')
				),
				array(
					"type" => "textfield",
					"heading" => __("Caption", 'adap_sc'),
					"param_name" => "caption",
					"value" => '',
					"description" => __("The caption to display just below the percentage count. Leave blank if no caption is needed.", 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Percentage Count Color', 'adap_sc'),
					'param_name' => 'percentage_count_color',
					'value' => null,
					'description' => __('The text color of the percentage count.', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Caption Color', 'adap_sc'),
					'param_name' => 'caption_color',
					'value' => null,
					'description' => __('The text color of the caption.', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Background Color', 'adap_sc'),
					'param_name' => 'background_color',
					'value' => null,
					'description' => __('The background color of the box.', 'adap_sc')
				),
				array(
					'type' => 'checkbox',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Bold Percentage Count?', 'adap_sc'),
					'param_name' => 'bold_percent',

					'sch_default' => 'false',
					'value' => array('Enable' => 'true'),
					'description' => __('Whether the percentage count should have a bold font-weight.', 'adap_sc')
				),
				array(
					'type' => 'checkbox',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Bold Caption?', 'adap_sc'),
					'param_name' => 'bold_caption',

					'sch_default' => 'false',
					'value' => array('Enable' => 'true'),
					'description' => __('Whether the caption should have a bold font-weight.', 'adap_sc')
				),
			)


		);
	}
}

new AdapCounterBoxSC('counter_box');

class AdapCounterCircleSC extends AdapAutoVCShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		wp_enqueue_script('gauge');

		extract($this->getPreparedAtts($atts, $content));

		$to = trim($to, '%');

		// Generate a Unique ID for the Element
		$element_id = uniqid('animatedcircle_');

		if (!$track_color) {
			if (function_exists('of_get_option')) {
				$track_color = of_get_option('main_content_counter_circle_track_color');
			}
		}
		if (!$bar_color) {
			if (function_exists('of_get_option')) {
				$bar_color = of_get_option('main_content_counter_circle_bar_color');
			}
		}
		$has_intro = false;
		$intro_class = 'no-intro';
		if ($intro && strlen($intro) > 0) {
			$has_intro = true;
			$intro_class = 'has-intro';
		}


		$container_icon_class = '';
		if ($label_style == 'icon') {
			$icon = $icon_type == 'fontawesome' ? $fontawesome_icon : $entypo_icon;

			if ($icon_type == 'fontawesome' && $fontawesome_icon != 'none') {
				$icon_class = 'icon' . '-' . $icon;
				$container_icon_class = 'animated-circle-has-icon-' . $icon_type;
			} else if ($icon_type == 'entypo' && $entypo_icon != 'none') {
				$icon_class = 'entypo' . '-' . $icon;
				$container_icon_class = 'animated-circle-has-icon-' . $icon_type;
			}
		}

		global $custom_css;
		ob_start();
		?>

		<?php if ($label_color) { ?>
		#<?php echo $element_id; ?> .animated-circle-content .animated-circle-intro,
		#<?php echo $element_id; ?> .animated-circle-content .animated-circle-label{
		color: <?php echo $label_color; ?>;
		}
	<?php } ?>

		<?php if ($background_color) { ?>
		#<?php echo $element_id; ?> canvas {
		background: <?php echo $background_color; ?>;
		}
	<?php } ?>


		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();


		ob_start();

		?>
		<div id="<?php echo $element_id; ?>"
			 class="animated-circle-wrapper <?php echo $intro_class; ?> <?php echo $container_icon_class; ?>">
			<canvas data-value="<?php echo $to; ?>" data-background-color="<?php echo $background_color; ?>"
					data-bar-color="<?php echo $bar_color ?>"
					data-track-color="<?php echo $track_color; ?>" width="600" height="600"
					class="animated-circle"></canvas>
			<div class="animated-circle-content">
				<?php if ($has_intro && $label_style == "text") { ?><h4 class="animated-circle-intro">
					<span><?php echo $intro; ?></span></h4><?php } ?>
				<div class="animated-circle-label">
					<?php if ($label_style == 'text') { ?>
						<span><?php echo $label; ?></span>
					<?php } else { ?>
						<i class="<?php echo $icon_class; ?> animated-circle-icon"></i>
					<?php } ?>
					<div class="clear"></div>
				</div>
			</div>
		</div>


		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	function configureParams()
	{

		global $icon_listing;
		global $entypo_listing;
		global $icon_type_listing;

		$this->params = array(
			'name' => 'Counter Circle',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),

			'params' => array(
				array(
					'type' => 'adap_dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Label Style", 'adap_sc'),
					'param_name' => 'label_style',
					'sch_default' => 'text',
					'value' => array(
						'Text' => 'text',
						'Icon' => 'icon'
					),
					'description' => __('Choose which style of label you\'d like.', 'adap_sc')
				),
				array(
					"type" => "textfield",
					"heading" => __("Percentage", 'adap_sc'),
					"param_name" => "to",
					"value" => '100',
					"description" => __("What percentage complete should the circle be?", 'adap_sc')
				),
				array(
					"type" => "textfield",
					"heading" => __("Intro", 'adap_sc'),
					"param_name" => "intro",
					"value" => '',
					"description" => __("The intro text to display just above the label.", 'adap_sc'),
					"dependency" => Array('element' => "label_style", 'value' => array('text'))
				),
				array(
					"type" => "textfield",
					"heading" => __("Label", 'adap_sc'),
					"param_name" => "label",
					"value" => '',
					"description" => __("The label text.", 'adap_sc'),
					"dependency" => Array('element' => "box_style", 'value' => array('text')),
					"dependency" => Array('element' => "label_style", 'value' => array('text'))
				),
				array(
					'type' => 'adap_dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Icon Type", 'adap_sc'),
					'param_name' => 'icon_type',
					'sch_default' => 'None',
					'value' => $icon_type_listing,
					'description' => __('Which icon set would you like to use?', 'adap_sc'),
					"dependency" => Array('element' => "label_style", 'value' => array('icon'))
				),
				array(
					'type' => 'adap_dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Font Awesome Icon", 'adap_sc'),
					'param_name' => 'fontawesome_icon',
					'sch_default' => 'None',
					'value' => $icon_listing,
					'description' => __('Choose a Font Awesome Icon to appear at the top of this content box. <a target="_blank" href="http://fortawesome.github.io/Font-Awesome/icons/">Browse the icons here</a>.', 'adap_sc'),
					"dependency" => Array('element' => "label_style", 'value' => array('icon'))
				),
				array(
					'type' => 'adap_dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Entypo Icon", 'adap_sc'),
					'param_name' => 'entypo_icon',
					'sch_default' => 'None',
					'value' => $entypo_listing,
					'description' => __('Choose an Entypo Icon to appear at the top of this content box. <a target="_blank" href="http://www.entypo.com/">Browse the icons here</a>.', 'adap_sc'),
					"dependency" => Array('element' => "label_style", 'value' => array('icon'))
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Label Color', 'adap_sc'),
					'param_name' => 'label_color',
					'value' => null,
					'description' => __('The color of the label or icon.', 'adap_sc'),
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Track Color', 'adap_sc'),
					'param_name' => 'track_color',
					'value' => null,
					'description' => __('The color of the progress bar track.', 'adap_sc'),
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Bar Color', 'adap_sc'),
					'param_name' => 'bar_color',
					'value' => null,
					'description' => __('The color of the progress bar.', 'adap_sc'),
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Background Color', 'adap_sc'),
					'param_name' => 'background_color',
					'value' => null,
					'description' => __('The background color of the element.', 'adap_sc'),
				),
//                array(
//                    "type" => "textfield",
//                    "heading" => __("Circle Diameter in 1170 widescreen layout (px)", 'adap_sc'),
//                    "param_name" => "width_1170",
//                    "value" => '',
//                    "description" => __("How wide should the circle be in the 1170 layout?", 'adap_sc'),
//                ),
//                array(
//                    "type" => "textfield",
//                    "heading" => __("Circle Diameter in 980 desktop layout (px)", 'adap_sc'),
//                    "param_name" => "width_980",
//                    "value" => '',
//                    "description" => __("How wide should the circle be in the 980 layout?", 'adap_sc'),
//                ),
//                array(
//                    "type" => "textfield",
//                    "heading" => __("Circle Diameter in 768 tablet layout (px)", 'adap_sc'),
//                    "param_name" => "width_768",
//                    "value" => '',
//                    "description" => __("How wide should the circle be in the 768 layout?", 'adap_sc'),
//                ),
//                array(
//                    "type" => "textfield",
//                    "heading" => __("Circle Diameter in 480 mobile layout (px)", 'adap_sc'),
//                    "param_name" => "width_480",
//                    "value" => '',
//                    "description" => __("How wide should the circle be in the 480 layout?", 'adap_sc'),
//                ),

			)


		);
	}
}

new AdapCounterCircleSC('counter_circle');

add_action('wp_enqueue_scripts', 'adap_sc_enqueue_progress_scripts');
function adap_sc_enqueue_progress_scripts()
{
	wp_register_script('jquery-waypoints', AdapCommon::get_base_url() . '/js/lib/waypoints.min.js', array('jquery'));
	wp_register_script('jquery-countto', AdapCommon::get_base_url() . '/js/lib/jquery.countTo.js', array('jquery'));
	wp_register_script('gauge', AdapCommon::get_base_url() . '/js/lib/gauge.min.js', array('jquery'));

}