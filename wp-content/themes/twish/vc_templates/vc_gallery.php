<?php
$output = $title = $type = $onclick = $custom_links = $img_size = $custom_links_target = $images = $el_class = $interval = '';
extract(shortcode_atts(array(
	'title' => '',
	'type' => 'flexslider',
	'onclick' => 'link_image',
	'custom_links' => '',
	'custom_links_target' => '',
	'img_size' => 'thumbnail',
	'images' => '',
	'el_class' => '',
	'interval' => '5',
	'show_title' => 'true',
	'show_caption' => 'true'
), $atts));
if ($type == 'nivo') {
	$gal_images = '';
	$link_start = '';
	$link_end = '';
	$el_start = '';
	$el_end = '';
	$slides_wrap_start = '';
	$slides_wrap_end = '';

	$el_class = $this->getExtraClass($el_class);

	if ($type == 'nivo') {
		$type = ' wpb_slider_nivo theme-default';
		wp_enqueue_script('nivo-slider');
		wp_enqueue_style('nivo-slider-css');
		wp_enqueue_style('nivo-slider-theme');

		$slides_wrap_start = '<div class="nivoSlider">';
		$slides_wrap_end = '</div>';
	}

	if ($onclick == 'link_image') {
		wp_enqueue_script('prettyphoto');
		wp_enqueue_style('prettyphoto');
	}

	/*
	 else if ( $type == 'fading' ) {
		$type = ' wpb_slider_fading';
		$el_start = '<li>';
		$el_end = '</li>';
		$slides_wrap_start = '<ul class="slides">';
		$slides_wrap_end = '</ul>';
		wp_enqueue_script( 'cycle' );
	}*/

//if ( $images == '' ) return null;
	if ($images == '') $images = '-1,-2,-3';

	$pretty_rel_random = 'rel-' . rand();

	if ($onclick == 'custom_link') {
		$custom_links = explode(',', $custom_links);
	}
	$images = explode(',', $images);
	$i = -1;

	foreach ($images as $attach_id) {
		$i++;
		if ($attach_id > 0) {
			$post_thumbnail = wpb_getImageBySize(array('attach_id' => $attach_id, 'thumb_size' => $img_size));
		} else {
			$different_kitten = 400 + $i;
			$post_thumbnail = array();
			$post_thumbnail['thumbnail'] = '<img src="http://placekitten.com/g/' . $different_kitten . '/300" />';
			$post_thumbnail['p_img_large'][0] = 'http://placekitten.com/g/1024/768';
		}

		$thumbnail = $post_thumbnail['thumbnail'];
		$p_img_large = $post_thumbnail['p_img_large'];
		$link_start = $link_end = '';

		if ($onclick == 'link_image') {
			$link_start = '<a class="prettyphoto" href="' . $p_img_large[0] . '">';
			$link_end = '</a>';
		} else if ($onclick == 'custom_link' && isset($custom_links[$i]) && $custom_links[$i] != '') {
			$link_start = '<a href="' . $custom_links[$i] . '"' . (!empty($custom_links_target) ? ' target="' . $custom_links_target . '"' : '') . '>';
			$link_end = '</a>';
		}
		$gal_images .= $el_start . $link_start . $thumbnail . $link_end . $el_end;
	}
	$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_gallery wpb_content_element' . $el_class . ' clearfix', $this->settings['base']);
	$output .= "\n\t" . '<div class="' . $css_class . '">';
	$output .= "\n\t\t" . '<div class="wpb_wrapper">';
	$output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_gallery_heading'));

	$flex_fx = isset($flex_fx) ? $flex_fx : '';
	$output .= '<div class="wpb_gallery_slides' . $type . '" data-interval="' . $interval . '"' . $flex_fx . '>' . $slides_wrap_start . $gal_images . $slides_wrap_end . '</div>';
	$output .= "\n\t\t" . '</div> ' . $this->endBlockComment('.wpb_wrapper');
	$output .= "\n\t" . '</div> ' . $this->endBlockComment('.wpb_gallery');

	echo $output;

} else {
	$gal_images = '';
	$link_start = '';
	$link_end = '';
	$el_start = '';
	$el_end = '';
	$slides_wrap_start = '';
	$slides_wrap_end = '';

	$el_class = $this->getExtraClass($el_class);

	if ($type == 'flexslider' || $type == 'flexslider_fade' || $type == 'flexslider_slide' || $type == 'fading') {
		$el_start = '<li>';
		$el_end = '</li>';
		$slides_wrap_start = '<ul class="slides">';
		$slides_wrap_end = '</ul>';
		wp_enqueue_style('flexslider');
		wp_enqueue_script('flexslider');
	} else if ($type == 'image_grid') {
		wp_enqueue_script('isotope');

		$el_start = '<li class="isotope-item">';
		$el_end = '</li>';
		$slides_wrap_start = '<ul class="wpb_image_grid_ul">';
		$slides_wrap_end = '</ul>';
	}

	if ($onclick == 'link_image') {
		wp_enqueue_script('prettyphoto');
		wp_enqueue_style('prettyphoto');
	}

	$flex_fx = '';
	if ($type == 'flexslider' || $type == 'flexslider_fade' || $type == 'fading') {
		$type = ' wpb_flexslider flexslider_fade flexslider';
		$flex_fx = ' data-flex_fx="fade"';
	} else if ($type == 'flexslider_slide') {
		$type = ' wpb_flexslider flexslider_slide flexslider';
		$flex_fx = ' data-flex_fx="slide"';
	} else if ($type == 'image_grid') {
		$type = ' wpb_image_grid';
	}


	/*
	 else if ( $type == 'fading' ) {
		$type = ' wpb_slider_fading';
		$el_start = '<li>';
		$el_end = '</li>';
		$slides_wrap_start = '<ul class="slides">';
		$slides_wrap_end = '</ul>';
		wp_enqueue_script( 'cycle' );
	}*/

//if ( $images == '' ) return null;
	if ($images == '') $images = '-1,-2,-3';

	$pretty_rel_random = 'rel-' . rand();

	if ($onclick == 'custom_link') {
		$custom_links = explode(',', $custom_links);
	}
	$images = explode(',', $images);
	$i = -1;

	foreach ($images as $attach_id) {
		$i++;
		if ($attach_id > 0) {
			$post_thumbnail = wpb_getImageBySize(array('attach_id' => $attach_id, 'thumb_size' => $img_size));
			$attachment = get_post($attach_id);

			$post_thumbnail['title'] = $attachment->post_title;
			$post_thumbnail['caption'] = $attachment->post_excerpt;
		} else {
			$different_kitten = 400 + $i;
			$post_thumbnail = array();
			$post_thumbnail['thumbnail'] = '<img src="http://placekitten.com/g/' . $different_kitten . '/300" />';
			$post_thumbnail['p_img_large'][0] = 'http://placekitten.com/g/1024/768';
		}

		$thumbnail = $post_thumbnail['thumbnail'];
		$p_img_large = $post_thumbnail['p_img_large'];
		$link_start = $link_end = '';

		if ($onclick == 'link_image') {
			$link_start = '<a class="prettyphoto" href="' . $p_img_large[0] . '">';
			$link_end = '</a>';
		} else if ($onclick == 'custom_link' && isset($custom_links[$i]) && $custom_links[$i] != '') {
			$link_start = '<a href="' . $custom_links[$i] . '"' . (!empty($custom_links_target) ? ' target="' . $custom_links_target . '"' : '') . '>';
			$link_end = '</a>';
		}

		$title_el = '';
		if ($show_title != 'false') {
			if (strlen($post_thumbnail['title']) > 0) {
				$title_el = '<h3>' . $post_thumbnail['title'] . '</h3>';
			}
		}

		$caption_el = '';
		if ($show_caption != 'false') {
			if (strlen($post_thumbnail['caption']) > 0) {
				$caption_el = '<span>' . $post_thumbnail['caption'] . '</span>';
			}
		}

		$slide_text = '';
		if (strlen($title_el) > 0 || strlen($caption_el)) {
			$slide_text = '<div class="slide-text-wrapper">' . $title_el . $caption_el . '</div>';
		}

		$gal_images .= $el_start . $link_start . $thumbnail . $link_end . $slide_text . $el_end;
	}


	$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_gallery wpb_content_element' . $el_class . ' clearfix', $this->settings['base']);
	$output .= "\n\t" . '<div class="' . $css_class . '">';
	$output .= "\n\t\t" . '<div class="wpb_wrapper">';
	$output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_gallery_heading'));
	$output .= '<div class="wpb_gallery_slides' . $type . '" data-interval="' . $interval . '"' . $flex_fx . '>' . $slides_wrap_start . $gal_images . $slides_wrap_end . '</div>';
	$output .= "\n\t\t" . '</div> ' . $this->endBlockComment('.wpb_wrapper');
	$output .= "\n\t" . '</div> ' . $this->endBlockComment('.wpb_gallery');

	echo $output;
}