<?php

class AdapThumbnailSC extends AdapAutoVCShortcode
{

	function shortcode_handler($atts, $content = null)
	{
		extract($this->getPreparedAtts($atts, $content));

		$src = $src ? wp_get_attachment_image_src($src, $image_size) : '';
		$src = is_array($src) ? $src[0] : '';

		// Generate a Unique ID for the Element
		$element_id = uniqid('thumbnail_');


		global $custom_css;
		ob_start();
		?>

		<?php if (isset($alignment)) { ?>
		#<?php echo $element_id; ?> {
		text-align: <?php echo $alignment; ?>;
		}
	<?php } ?>

		<?php if (isset($background_color)) { ?>
		#<?php echo $element_id; ?> {
		background: <?php echo $background_color; ?>;
		}
	<?php } ?>

		<?php if (isset($text_color)) { ?>
		#<?php echo $element_id; ?>, #<?php echo $element_id; ?> p {
		color: <?php echo $text_color; ?>;
		}
	<?php } ?>

		<?php if (isset($heading_color)) { ?>
		#<?php echo $element_id; ?> h1,
		#<?php echo $element_id; ?> h2,
		#<?php echo $element_id; ?> h3,
		#<?php echo $element_id; ?> h4,
		#<?php echo $element_id; ?> h5,
		#<?php echo $element_id; ?> h6{
		color: <?php echo $heading_color; ?>;
		}
	<?php } ?>


		<?php
		$custom_css .= ob_get_contents();
		ob_end_clean();


		ob_start();
		?>
		<div id="<?php echo $element_id; ?>" class="thumbnail thumbnail-shortcode">
			<?php if ($src != null) echo '<img src="' . $src . '" title="' . $title . '" alt="' . $alt . '">'; ?>
			<div class="caption"><?php echo do_shortcode($content); ?></div>
		</div>

		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	function configureParams()
	{
		$this->params = array(
			'name' => 'Thumbnail',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),

			//START VC Container Related Params
			"allowed_container_element" => false,
			"is_container" => true,
			'js_view' => 'VcColumnView',
			//END VC Container related Params

			'params' => array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Title', 'adap_sc'),
					'param_name' => 'title',
					'value' => __('', 'adap_sc'),
					'description' => __('The title of the image.', 'adap_sc')
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Alt', 'adap_sc'),
					'param_name' => 'alt',
					'value' => __('', 'adap_sc'),
					'description' => __('The "alt" text for the image.', 'adap_sc')
				),
				array(
					'type' => 'attach_image',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Image', 'adap_sc'),
					'param_name' => 'src',
					'value' => null,
					'description' => __('The image to show at the top of the thumbnail.', 'adap_sc')
				),
				AdapAutoVCShortcode::$image_size_param,
				array(
					'type' => 'dropdown',
					'heading' => __('Content Alignment', 'adap_sc'),
					'param_name' => 'alignment',
					'sch_default' => 'align-left',
					'value' => array('Left' => 'left', 'Center' => 'center', 'Right' => 'right'),
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Background Color', 'adap_sc'),
					'param_name' => 'background_color',
					'value' => null,
					'description' => __('The background color of the thumbnail content.', 'adap_sc'),
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Text Color', 'adap_sc'),
					'param_name' => 'text_color',
					'value' => null,
					'description' => __('The text color of the thumbnail content.', 'adap_sc'),
				),
				array(
					'type' => 'colorpicker',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Heading Color', 'adap_sc'),
					'param_name' => 'heading_color',
					'value' => null,
					'description' => __('The color of headings in the thumbnail content.', 'adap_sc'),
				),
			)
		);
	}
}

new AdapThumbnailSC('thumbnail');

/**
 * Register Container Behavior
 */
add_action('init', 'vc_thumbnail_class');
function vc_thumbnail_class()
{
	if (class_exists('WPBakeryShortCode_Adap_Container')) {
		class WPBakeryShortCode_Thumbnail extends WPBakeryShortCode_Adap_Container
		{
		}
	}
}