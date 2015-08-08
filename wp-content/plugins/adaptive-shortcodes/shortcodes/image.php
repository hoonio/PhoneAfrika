<?php

class AdapFramedImageSC extends AdapAutoVCShortcode
{
	public function getExtraClass($el_class)
	{
		$output = '';
		if ($el_class != '') {
			$output = " " . str_replace(".", "", $el_class);
		}
		return $output;
	}

	public function getCSSAnimation($css_animation)
	{
		$output = '';
		if ($css_animation != '') {
			wp_enqueue_script('waypoints');
			$output = ' wpb_animate_when_almost_visible wpb_' . $css_animation;
		}
		return $output;
	}

	public function endBlockComment($string)
	{
		//return '';
		return (!empty($_GET['wpb_debug']) && $_GET['wpb_debug'] == 'true' ? '<!-- END ' . $string . ' -->' : '');
	}

	function shortcode_handler($atts, $content = null)
	{
		if (function_exists('wpb_map')) {
//        extract($this->getPreparedAtts($atts, $content));
//
//        $src = $src ? wp_get_attachment_image_src($src, $image_size) : '';
//        $src = is_array($src) ? $src[0] : '';
//
//        return sprintf('<img src="%s" class="img-%s">', $src, $style);

			$output = $el_class = $image = $img_size = $img_link = $img_link_target = $img_link_large = $title = $css_animation = '';

			extract(shortcode_atts(array(
				'title' => '',
				'image' => $image,
				'img_size' => 'full',
				'img_link_large' => false,
				'img_link' => '',
				'img_link_target' => '_self',
				'el_class' => '',
				'css_animation' => '',
				'style' => '',
				'align' => 'none'
			), $atts));

			$img_id = preg_replace('/[^\d]/', '', $image);
			$img = wpb_getImageBySize(array('attach_id' => $img_id, 'thumb_size' => $img_size));
			if ($img == NULL) $img['thumbnail'] = '<img src="http://placekitten.com/g/400/300" /> <small>' . __('This is image placeholder, edit your page to replace it.', 'adap_sc') . '</small>';

			$el_class = $this->getExtraClass($el_class);

			$a_class = '';

			if ($img_link_target == 'lightbox') {
				wp_enqueue_script('prettyphoto');
				wp_enqueue_style('prettyphoto');
				$a_class = ' class="prettyphoto"';
			} elseif ($el_class != '') {
				$tmp_class = explode(" ", strtolower($el_class));
				$tmp_class = str_replace(".", "", $tmp_class);
				if (in_array("prettyphoto", $tmp_class)) {
					wp_enqueue_script('prettyphoto');
					wp_enqueue_style('prettyphoto');
					$a_class = ' class="prettyphoto"';
					$el_class = str_ireplace(" prettyphoto", "", $el_class);
				}
			}


			$link_to = '';
			if ($img_link_large == true) {
				$link_to = wp_get_attachment_image_src($img_id, 'large');
				$link_to = $link_to[0];
			} else if (!empty($img_link)) {
				$link_to = $img_link;
			}

			$img['thumbnail'] = str_replace('class="', 'class="' . $style . ' ', $img['thumbnail']);

			$image_string = !empty($link_to) ? '<a' . $a_class . ' href="' . $link_to . '"' . ($img_link_target != '_self' ? ' target="' . $img_link_target . '"' : '') . '>' . $img['thumbnail'] . '</a>' : $img['thumbnail'];


			$css_class = $this->getCSSAnimation($css_animation);
			$css_class .= ' pull-' . $align;

			$output .= "\n\t" . '<div class="' . $css_class . '">';
			$output .= "\n\t\t" . '<div class="wpb_wrapper">';
			$output .= "\n\t\t\t" . wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_singleimage_heading'));
			$output .= "\n\t\t\t" . $image_string;
			$output .= "\n\t\t" . '</div> ' . $this->endBlockComment('.wpb_wrapper');
			$output .= "\n\t" . '</div> ' . $this->endBlockComment('.wpb_single_image');

			return $output;
		} else return '';
	}

	function configureParams()
	{
		$this->params = array(
			"name" => __("Image", 'adap_sc'),
			"base" => "framed_image",
			"icon" => "icon-wpb-single-image",
			"category" => __('Content', 'adap_sc'),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => __("Widget title", 'adap_sc'),
					"param_name" => "title",
					"description" => __("What text use as a widget title. Leave blank if no title is needed.", 'adap_sc')
				),
				array(
					"type" => "attach_image",
					"heading" => __("Image", 'adap_sc'),
					"param_name" => "image",
					"value" => "",
					"description" => __("Select image from media library.", 'adap_sc')
				),
				AdapAutoVCShortcode::$css_animation_param,
				array(
					"type" => "textfield",
					"heading" => __("Image size", 'adap_sc'),
					"param_name" => "img_size",
					"value" => 'full',
					"description" => __("Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use 'thumbnail' size.", 'adap_sc')
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Styling', 'adap_sc'),
					'param_name' => 'style',
					'value' => array('None' => '', 'Rounded' => 'img-rounded', 'Circle' => 'img-circle', 'Polaroid' => 'img-polaroid')
				),
				array(
					"type" => 'checkbox',
					"heading" => __("Link to large image?", 'adap_sc'),
					"param_name" => "img_link_large",
					"description" => __("If selected, image will be linked to the bigger image.", 'adap_sc'),
					"value" => Array(__("Yes, please", 'adap_sc') => 'yes')
				),
				array(
					"type" => "textfield",
					"heading" => __("Image link", 'adap_sc'),
					"param_name" => "img_link",
					"description" => __("Enter url if you want this image to have link.", 'adap_sc'),
					"dependency" => Array('element' => "img_link_large", 'is_empty' => true, 'callback' => 'wpb_single_image_img_link_dependency_callback')
				),
				array(
					"type" => "dropdown",
					"heading" => __("Link Target", 'adap_sc'),
					"param_name" => "img_link_target",
					"value" => array_merge(AdapAutoVCShortcode::$target_param,
						array('Lightbox' => 'lightbox')),
					"dependency" => Array('element' => "img_link", 'not_empty' => true)
				),
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", 'adap_sc'),
					"param_name" => "el_class",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'adap_sc')
				),
				array(
					'type' => 'dropdown',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Alignment', 'adap_sc'),
					'param_name' => 'align',
					'sch_default' => 'none',
					'value' => array('None' => 'none', 'Left' => 'left', 'Right' => 'right'),
					'description' => __('The image alignment', 'adap_sc')
				),
			));
	}
}

new AdapFramedImageSC('framed_image');