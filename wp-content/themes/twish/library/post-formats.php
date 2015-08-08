<?php

function adap_curr_post()
{
	$curr_post['id'] = get_the_ID();
	$curr_post['title'] = get_the_title();
	$curr_post['content'] = get_the_content();
	$curr_post['featured'] = '';
	$curr_post['feature_size'] = 'full';
//    if (is_search() || is_archive()) {
//        $curr_post['preview_content'] = wp_kses_post(get_the_excerpt());
//    } else {
//        $curr_post['preview_content'] = get_the_content(__('Read More', 'adap'));
//    }

	$curr_post['preview_content'] = get_the_content(__('Read More', 'adap'));


	if (function_exists('sharing_display')) {
		add_filter('the_content', 'sharing_display', 19);
	}

	$curr_post = apply_filters('adap_post_formatting', $curr_post);

	return $curr_post;
}

/**
 * Filters current post to to modify for given post formats
 */
class AdapPostFiltering
{
	public static function post_format_filter($curr_post)
	{
		if (get_post_type() == 'portfolio') {
			//grab format from portfolio-item options
			$format = get_post_meta(get_the_ID(), '_adap_sc_format', true);
			$format = $format ? $format : 'standard';

			if ($format == 'standard') {
				$resize_image = get_post_meta(get_the_ID(), '_adap_sc_resize_detail_image', true);
				if ($resize_image) {
					$layout = get_post_meta(get_the_ID(), '_adap_sc_layout');
					if (is_array($layout)) {
						$layout = $layout[0];
					}

					if ($layout == 'compact') {
						$curr_post['feature_size'] = 'portfolio-compact';


					} elseif ($layout == 'full-width') {
						$curr_post['feature_size'] = 'portfolio-one-column';
					}
				}
			}

		} else {
			$format = get_post_format($curr_post['id']);
			$format = $format == false ? 'standard' : $format;
		}

		if (method_exists('AdapPostFiltering', $format)) {
			$curr_post = AdapPostFiltering::$format($curr_post);
		}

		//Make sure that 'the_content' filters get applied.
//        $curr_post['content'] = str_replace(']]>', ']]&gt;',
//            apply_filters('the_content', $curr_post['content']));

		//We need to do this in order the remove the_content from the curretn
		//filter list since we're going to call it explicitly.
		//This fixes Jetpack sharing w/ the blog shortcode
		global $wp_current_filter;
		if (($key = array_search('the_content', $wp_current_filter)) !== false) {
			unset($wp_current_filter[$key]);
		}


		$curr_post['preview_content'] = str_replace(']]>', ']]&gt;',
			apply_filters('the_content', $curr_post['preview_content']));


		return $curr_post;
	}

	public static function image($curr_post)
	{
		$image = get_the_post_thumbnail($curr_post['id'], $curr_post['feature_size']);
		if ($image) {
			$curr_post['featured'] = $image;
		}
		return $curr_post;
	}


	public static function standard($curr_post)
	{
		$curr_post['featured'] = get_the_post_thumbnail(get_the_ID(), $curr_post['feature_size']);
		return $curr_post;
	}

	/**
	 * Grabs the first video from the content and moves it to $curr_post['featured']
	 * @param $curr_post
	 * @return mixed
	 */
	public static function video($curr_post)
	{
		$content = preg_replace('|^\s*(https?://[^\s"]+)\s*$|im', "[embed]$1[/embed]", $curr_post['content']);
		preg_match("!\[embed.+?\]!", $content, $vids);

		if (!empty($vids)) {
			global $wp_embed;
			$video = $vids[0];
			//update the current post, setting the featured to the
			//video embed markup
			$curr_post['featured'] = do_shortcode($wp_embed->run_shortcode($video));
			$curr_post['content'] = str_replace($video, '', $content);

			$preview_content = preg_replace('|^\s*(https?://[^\s"]+)\s*$|im', "[embed]$1[/embed]", $curr_post['preview_content']);
			preg_match("!\[embed.+?\]!", $preview_content, $pvids);

			$curr_post['preview_content'] = str_replace($video, '', $preview_content);
		}

		return $curr_post;
	}

	public static function link($curr_post)
	{
		$reg = '!^(https?|ftp)://(-\.)?([^\s/?\.#-]+\.?)+(/[^\s]*)?!';
		preg_match($reg, $curr_post['content'], $matches);
		if (!empty($matches[0])) {
			$l = $matches[0];
			$curr_post['title'] = sprintf('<a href="%s" title="%s">%s</a>', $l, $curr_post['title'], $curr_post['title']);
			$curr_post['content'] = str_replace($l, '', $curr_post['content']);
			$curr_post['preview_content'] = str_replace($l, '', $curr_post['preview_content']);
		}

		return $curr_post;
	}

	public static function quote($curr_post)
	{
		$content = $curr_post['content'];
		$shortcode = 'blockquote';
		preg_match("!\[$shortcode(.*?)?\]\s*(?:(.+?)\s*?\[\/$shortcode\])?!", $content, $quotes);

		if (!empty($quotes)) {
			$curr_post['featured'] = do_shortcode($quotes[0]);
			$curr_post['content'] = str_replace($quotes[0], '', $content);
			$curr_post['preview_content'] = str_replace($quotes[0], '', $curr_post['preview_content']);

		}
		return $curr_post;
	}

	public static function gallery($curr_post)
	{
		$content = $curr_post['content'];

		if (function_exists('wpb_map')) {
			preg_match("!\[vc_gallery.+?\]!", $content, $galleries);
			preg_match("!\[gallery.*?\]!", $content, $wp_galleries);
			$galleries = array_merge($galleries, $wp_galleries);
		} else {
			preg_match("!\[gallery.*?\]!", $content, $galleries);
		}

		if (!empty($galleries)) {
			$curr_post['featured'] = do_shortcode($galleries[0]);
			$curr_post['content'] = str_replace($galleries[0], '', $content);
			$curr_post['preview_content'] = str_replace($galleries[0], '', $curr_post['preview_content']);
		}
		return $curr_post;
	}

}

add_filter('adap_post_formatting', array('AdapPostFiltering', 'post_format_filter'), 11, 1);