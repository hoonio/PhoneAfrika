<?php

class AdapBoxSC extends AdapAutoVCShortcode
{

	function shortcode_handler($atts, $content = null)
	{
		extract($this->getPreparedAtts($atts, $content));


		$icon = $icon_type == 'fontawesome' ? $fontawesome_icon : $entypo_icon;
		if ($icon_type == 'fontawesome') {
			$icon_class = 'icon' . '-' . $icon;
		} else {
			$icon_class = 'entypo' . '-' . $icon;
		}


		// Generate a Unique ID for the Element
		$element_id = uniqid('box_');

		// Configure Custom CSS
		global $custom_css;
		ob_start();
		?>
		#<?php echo $element_id; ?> .box-shortcode-icon {
		color: <?php echo $icon_color; ?>;
		}
		#<?php echo $element_id; ?> .box-shortcode-heading {
		color: <?php echo $title_color; ?>;
		}

		<?php if ($box_style == 'style2' || $box_style == 'style3' || $box_style == 'style6') { ?>

		#<?php echo $element_id; ?> .box-shortcode-icon-wrapper {
		background-color: <?php echo $icon_background_color; ?>;
		}

	<?php } ?>

		<?php if ($box_style == 'style2' || $box_style == 'style4' || $box_style == 'style6') { ?>

		#<?php echo $element_id; ?> .box-shortcode-icon-wrapper {
		border-color: <?php echo $icon_border_color; ?>;
		}

	<?php } ?>

		<?php if ($box_style == 'style6') { ?>

		#<?php echo $element_id; ?> .box-shortcode-inner-wrapper {
		background-color: <?php echo $box_background_color; ?>;
		<?php if ($content_color) { ?> color: <?php echo $content_color; ?>; <?php } ?>
		}

		#<?php echo $element_id; ?> .box-shortcode-inner-wrapper p {
		<?php if ($content_color) { ?> color: <?php echo $content_color; ?>; <?php } ?>
		}
	<?php } ?>

		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();

		ob_start();
		?>
		<div id="<?php echo $element_id; ?>" class="box-shortcode box-shortcode-<?php echo $box_style; ?> box-icon-type-<?php echo $icon_type; ?>"><span class="box-shortcode-icon-wrapper"><i class="box-shortcode-icon <?php echo $icon_class; ?>"></i></span><div class="box-shortcode-inner-wrapper"><h3 class="box-shortcode-heading"><?php echo $title; ?></h3><div class="box-shortcode-content"><?php echo trim(do_shortcode($content)); ?></div></div></div>
		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	// Simple box with plain icon to the left of the heading and the text below
	function print_style1_box($title, $title_color, $content, $icon_type, $icon, $icon_color)
	{

	}

	// Simple box with icon w/ color background to the left of the heading and text below
	function print_style2_box($title, $title_color, $content, $icon_type, $icon, $icon_color, $icon_bg_color)
	{

	}

	// large centered icon w/color background, centered heading and text below
	function print_style3_box($title, $title_color, $content, $icon_type, $icon, $icon_color, $icon_bg_color)
	{

	}

	// Large centered icon w/ color border, centered heading and text below
	function print_style4_box($title, $title_color, $content, $icon_type, $icon, $icon_color, $icon_border_color)
	{

	}

	// Simple box identical to style1, except that the content is aligned with the heading
	function print_style5_box($title, $title_color, $content, $icon_type, $icon, $icon_color)
	{

	}

	// The works! Colored box with a large centered icon w/color bg and border, and a box background
	function print_style6_box($title, $title_color, $content, $icon_type, $icon, $icon_color, $icon_bg_color, $icon_border_color,
							  $content_color, $box_background_color)
	{

	}

	function configureParams()
	{

		global $icon_listing;
		global $entypo_listing;
		global $icon_type_listing;

		$this->params = array(
			'name' => 'Box',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),
			'params' => array(

				array(

					'type' => 'adap_dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('adap_sc'),
					'param_name' => 'box_style',
					'sch_default' => 'style6',
					'value' => array(
						'Style #1  (icon to left of header)' => 'style1',
						'Style #2 (icon with background to left of header)' => 'style2',
						'Style #3 (big centered icon with color background)' => 'style3',
						'Style #4 (big centered icon with color border)' => 'style4',
						'Style #5 (icon to left of header and content)' => 'style5',
						'Style #6 (big centered icon with content in colored box)' => 'style6'
					),
					'description' => 'Choose which style of content box you\'d like.'
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Title', 'adap_sc'),
					'param_name' => 'title',
					'value' => __('Title', 'adap_sc'),
					'description' => __('The heading to show next to the icon', 'adap_sc')
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Title Color', 'adap_sc'),
					'param_name' => 'title_color',
					'value' => null,
					'description' => __('The color of the icon.', 'adap_sc')
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
					'value' => $icon_listing,
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
					'value' => $entypo_listing,
					'description' => 'Choose an Entypo Icon to appear at the top of this content box. <a target="_blank" href="http://www.entypo.com/">Browse the icons here</a>.',
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
					"dependency" => Array('element' => "color", 'value' => array('custom'))
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Icon Background Color', 'adap_sc'),
					'param_name' => 'icon_background_color',
					'value' => null,
					'description' => __('The background color of the icon background circle.', 'adap_sc'),
					"dependency" => Array('element' => "box_style", 'value' => array('style2', 'style3', 'style6'))
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Icon Circle Border Color', 'adap_sc'),
					'param_name' => 'icon_border_color',
					'value' => null,
					'description' => __('The border color of the icon background circle', 'adap_sc'),
					"dependency" => Array('element' => "box_style", 'value' => array('style4', 'style6'))
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Content Color', 'adap_sc'),
					'param_name' => 'content_color',
					'value' => null,
					'description' => __('The text color of the content contained in this box.', 'adap_sc'),
					"dependency" => Array('element' => "box_style", 'value' => array('style6'))
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Box Background Color', 'adap_sc'),
					'param_name' => 'box_background_color',
					'value' => null,
					'description' => __('The background color of the box.', 'adap_sc'),
					"dependency" => Array('element' => "box_style", 'value' => array('style6'))
				),
				array(
					"type" => "textarea_html",
					"holder" => "div",
					"class" => "",
					"heading" => __("Content", 'adap_sc'),
					"param_name" => "content",
					"value" => __("Content", 'adap_sc'),
					"description" => __("This is an example quote.", 'adap_sc')
				),
			)
		);
	}
}

new AdapBoxSC('box');

/**
 * Register Container Behavior
 */
//add_action('init', 'vc_box_class');
//function vc_box_class()
//{
//    if (class_exists('WPBakeryShortCode_Adap_Container')) {
//        class WPBakeryShortCode_Box extends WPBakeryShortCode_Adap_Container
//        {
//        }
//    }
//}
