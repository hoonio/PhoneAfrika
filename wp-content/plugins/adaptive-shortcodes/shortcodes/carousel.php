<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hiron
 * Date: 6/6/13
 * Time: 11:20 AM
 * T
 */
global $carousel_slide_count;

class AdapCarouselSC extends AdapShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		$defaults = array(
			'interval' => 'false'
		);
		extract(shortcode_atts($defaults, $atts));

		$interval = strtolower($interval);

		ob_start();

		$div_id = uniqid('carousel-');

		global $carousel_slide_count;
		$carousel_slide_count = 0;

		$content = do_shortcode($content);
		?>

		<div id="<?php echo $div_id; ?>" class="carousel slide" data-interval="<?php echo $interval; ?>">
			<ol class="carousel-indicators">
				<?php
				global $carousel_slide_count;
				for ($i = 0; $i < $carousel_slide_count; $i++) {
					?>
					<li data-target="#<?php echo $div_id; ?>" data-slide-to="<?php echo $i; ?>"></li>
				<?php
				}
				$carousel_slide_count = 0;
				?>
			</ol>
			<div class="carousel-inner">
				<?php echo $content ?>
			</div>
			<a class="left carousel-control" href="#<?php echo $div_id; ?>" data-slide="prev">&lsaquo;</a>
			<a class="right carousel-control" href="#<?php echo $div_id; ?>" data-slide="next">&rsaquo;</a>
		</div>

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

new AdapCarouselSC('carousel');

class AdapCarouselItem extends AdapShortcode
{
	function shortcode_handler($atts, $content = null)
	{
		$defaults = array(
			'src' => '#',
			'alt' => ''
		);
		extract(shortcode_atts($defaults, $atts));

		global $carousel_slide_count;
		$carousel_slide_count++;

		ob_start();
		?>

		<div class="item">
			<img src="<?php echo $src; ?>" alt="<?php echo $alt; ?>">

			<div class="carousel-caption">
				<?php echo do_shortcode($content); ?>
			</div>
		</div>

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

new AdapCarouselItem('carousel_item');