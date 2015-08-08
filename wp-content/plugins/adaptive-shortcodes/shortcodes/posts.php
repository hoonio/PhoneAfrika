<?php

class AdapPostsSC extends AdapAutoVCShortcode
{

	function shortcode_handler($atts, $content = null)
	{
		ob_start();

		$atts = $this->getPreparedAtts($atts, $content);

		$atts = shortcode_atts(array(
			'blog_type' => 'posts',
			'paginate' => 'false',
			'items' => '2',
			'categories' => '', //comma delimited ID (int) value
			'post_type' => 'post',
			'taxonomy' => 'category',
			'display' => 'excerpt', //as opposed to "excerpt"
			'show_excerpt' => 'show_excerpt',
		), $atts);

		extract($atts);


		$column_span = 12 / intval($items);
		$span_class = 'span' . $column_span;

		switch ($items) {
			case 3:
				$image_size = 'portfolio-three-column';
				break;
			case 2:
				$image_size = 'portfolio-two-column';
				break;
			case 1:
				$image_size = 'portfolio-one-column';
				break;
			default:
				$image_size = 'portfolio-four-column';
				break;
		}


		$this->do_query($atts);
		?>

		<div class="row-fluid recent-posts-shortcode">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


		<div class="<?php echo $span_class; ?>">

			<section class="post-preview">
				<article <?php post_class('clearfix'); ?> role="article">

					<?php if (has_post_thumbnail()) : ?>
						<a class="recent-posts-image" href="<?php the_permalink(); ?>"
						   title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail($image_size); ?>
						</a>
					<?php endif; ?>

					<header class="article-header">

						<h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark"
										  title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

						<p class="byline vcard"><?php
							printf(__('<time class="updated" datetime="%1$s">%2$s</time>', 'adap_sc'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), bones_get_the_author_posts_link(), get_the_category_list(', '));
							?>

						<div class="byline-item byline-comments"><a href="<?php comments_link(); ?>"
																	class="entypo-comment"><?php echo number_format_i18n(get_comments_number()); ?></a>
						</div>
						</p>

					</header>
					<!-- end article header -->

					<div class="entry-content clearfix entry-excerpt">
						<?php

						if ($show_excerpt == 'show_excerpt') {
							the_excerpt();
						}

						?>
					</div>
					<!-- end article section -->

					<footer class="article-footer">
						<p class="tags"><?php the_tags('<span class="tags-title">' . __('Tags:', 'adap_sc') . '</span> ', ', ', ''); ?></p>

					</footer>
					<!-- end article footer -->

					<?php // comments_template(); // uncomment if you want to use them ?>

				</article>
				<!-- end article -->
			</section>

		</div>

	<?php endwhile; ?>
		</div>

	<?php else : ?>

		<article id="post-not-found" class="hentry clearfix">
			<header class="article-header">
				<h1><?php _e("Oops, Post Not Found!", 'adap_sc'); ?></h1>
			</header>
			<section class="entry-content">
				<p><?php _e("Uh Oh. Something is missing. Try double checking things.", 'adap_sc'); ?></p>
			</section>
			<footer class="article-footer">
				<p><?php _e("This is the error message from the Adaptive Shortcodes' Blog Shortcode ", 'adap_sc'); ?></p>
			</footer>
		</article>

	<?php endif; ?>

		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();

		wp_reset_query();
		return $ret_val;
	}

	function configureParams()
	{
		$cats = get_categories();
		$cat_vals = array();
		foreach ($cats as $c) {
			$cat_vals[$c->name] = $c->slug;
		}

		$this->params = array(
			'name' => 'Posts',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),
			'params' => array(
				array(
					'type' => 'dropdown',
					'heading' => __('Number of Items', 'adap_sc'),
					'param_name' => 'items',
					'value' => array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '6' => '6'),
					'description' => 'The number of items to show on a given page. Set to -1 to show all.'
				),
				array(
					'type' => 'dropdown',
					'heading' => __('Excerpt', 'adap_sc'),
					'param_name' => 'show_excerpt',
					'value' => array("Hide Excerpt" => 'hide_excerpt', 'Show Excerpt' => 'show_excerpt'),
					'description' => __('Whether to show or hide the post excerpt.', 'adap_sc')
				),
				array(
					"type" => "checkbox",
					"heading" => __("Categories", 'adap_sc'),
					"param_name" => "categories",
					"value" => $cat_vals,
					"description" => __("If you want to narrow output, select category names here. Note: Only selected categories will be included.", 'adap_sc')
				),
			));
	}

	function do_query($params)
	{
		$query = array();

		if (!empty($params['categories']) && is_string($params['categories'])) {
			$terms = explode(',', $params['categories']);
		}

		$page = get_query_var('paged') ? get_query_var('paged') : get_query_var('page');
		if (!$page) $page = 1;
		if (isset($terms[0]) &&
			!empty($terms[0]) &&
			!is_null($terms[0]) &&
			$terms[0] != "null" &&
			!empty($params['taxonomy'])
		) {
			$query = array('paged' => $page,
				'posts_per_page' => $params['items'],
				'tax_query' => array(array('taxonomy' => $params['taxonomy'],
					'field' => 'slug',
					'terms' => $terms,
					'operator' => 'IN')));
		} else {
			$query = array('paged' => $page,
				'posts_per_page' => $params['items'],
				'post_type' => $params['post_type']);
		}

		query_posts($query);
	}

}

new AdapPostsSC('posts');