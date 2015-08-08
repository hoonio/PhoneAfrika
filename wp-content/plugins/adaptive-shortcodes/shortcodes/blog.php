<?php
class AdapBlogSC extends AdapAutoVCShortcode
{

	function shortcode_handler($atts, $content = null)
	{
		ob_start();

		$atts = $this->getPreparedAtts($atts, $content);
		$defaults = array(
			'items' => '10',
			'paginate' => 'yes',
			'categories' => '', //comma delimited ID (int) value
			'post_type' => 'post',
			'taxonomy' => 'category',
			'display' => 'content', //as opposed to "excerpt"
			'order' => 'DESC',
			'orderby' => 'date',
			'layout' => 'large-image'
		);
		//since we don't want to have to declare all the $atts in defaults
		//since they're being provided by getPreparedAtts as well
		foreach ($defaults as $k => $v) {
			if (!isset($atts[$k]))
				$atts[$k] = $v;
		}

		switch ($atts['layout']) {
			case 'large-image':
				$this->image_size = 'blog-large';
				break;
			case 'medium-image':
				$this->image_size = 'blog-medium';
				break;
			case 'grid':
				$this->image_size = 'blog-grid';
				break;
			case 'full-image-alt':
			case 'full-image':
			default:
				$this->image_size = 'blog-full-width';
				break;
		}

		add_filter('adap_post_formatting', array($this, 'filter_post_size'), 9, 1);

		global $more;
		$orig_more = $more;
		$more = 0;

		if ($atts['layout'] == 'grid') {
			return $this->grid_blog($atts, $content);
		} else {
			$this->display = $atts['display'];
			add_filter('adap_post_formatting', array($this, 'excerpt_or_content_filter'), 9, 1);
			return $this->normal_blog($atts, $content);
		}

	}

	function excerpt_or_content_filter($curr_post)
	{
		$format = get_post_format($curr_post['id']);
		$format = $format ? $format : 'standard';

		if ($format == 'standard' || $format == 'gallery' || $format == 'video') {
			if ($this->display == 'content' && !has_excerpt()) {
				$curr_post['preview_content'] = get_the_content(__('Read More', 'adap_sc'));
			} else {
				$curr_post['preview_content'] = wp_kses_post(get_the_excerpt());
			}
		}

		return $curr_post;
	}

	function filter_post_size($curr_post)
	{
		$curr_post['feature_size'] = $this->image_size;

		return $curr_post;
	}


	function normal_blog($atts, $content = null)
	{


		extract($atts);


		global $wp_query;
		$orig_query = $wp_query;
		$wp_query = $this->get_query($atts);
		?>


		<div
			class="adap-blog-shortcode blog-shortcode-layout-<?php echo $layout; ?>">    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<section class="post-preview <?php echo 'adap-post-format-' . get_post_format(); ?>">
					<?php get_template_part('content', get_post_format()); ?>
				</section>
			<?php endwhile; ?>

				<div class="blog-pagination">
					<hr class="post-divider">
					<?php if (function_exists('bones_page_navi')) { ?>
						<?php bones_page_navi('', '', 'Newer Posts', 'Older Posts'); ?>
					<?php } else { ?>
						<nav class="wp-prev-next">
							<ul class="clearfix">
								<li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', 'adap_sc')) ?></li>
								<li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', 'adap_sc')) ?></li>
							</ul>
						</nav>
					<?php } ?>
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

			<?php endif; ?></div>

		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();

		$wp_query = $orig_query;
		wp_reset_query();
		return $ret_val;
	}

	function grid_blog($atts, $content = null)
	{
		extract($atts);

		switch ($columns) {
			case 3:
				$column_class = 'span4';
				$mod = 3;
				break;
			case 2:
				$column_class = 'span6';
				$mod = 2;
				break;
			case 1:
				$column_class = 'span12';
				$mod = 1;
				break;
			default:
				$column_class = 'span3';
				$mod = 4;
				break;
		}

		$this->get_query($atts);
		global $wp_query;
		$total_num_posts = $wp_query->post_count;
		$count = 0;
		?>
		<div class="row-fluid adap-blog-layout-grid">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php
		$count++;
		if ($count % $mod == 0 && $count != $total_num_posts) {
			$new_row = true;
		} else {
			$new_row = false;
		}

		$curr_post['id'] = get_the_ID();
		$curr_post['title'] = get_the_title();
		$curr_post['content'] = get_the_content();
		$curr_post['featured'] = '';
		$curr_post['feature_size'] = 'medium';

		$img_size = $columns == 1 ? 'full' : 'large';
		$curr_post['featured'] = get_the_post_thumbnail(get_the_ID(), $img_size);


//        $curr_post = apply_filters('adap_post_formatting', $curr_post);
		?>
		<section class="post-preview <?php echo $column_class; ?> thumbnail">
			<article <?php post_class('clearfix'); ?> role="article" class="thumbnail">

				<header class="article-header">
					<?php echo $curr_post['featured']; ?>
					<?php if ($grid_show_title != 'false'): ?>
						<h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark"
										  title="<?php the_title_attribute(); ?>"><?php echo $curr_post['title']; ?></a>
						</h1>
					<?php endif; ?>

					<?php if ($grid_show_meta != 'false'): ?>
						<p class="byline vcard"><?php
							printf(__('Posted <time class="updated" datetime="%1$s">%2$s</time> by <span class="author">%3$s</span> <span class="amp">&</span> filed under %4$s.', 'adap_sc'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), bones_get_the_author_posts_link(), get_the_category_list(', '));
							?></p>
					<?php endif; ?>


				</header>
				<!-- end article header -->

				<div class="entry-content clearfix">
					<?php

					if ($grid_show_excerpt != 'false') the_excerpt();

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
		<?php if ($new_row): ?>
			</div>
			<div class="row-fluid">
		<?php endif; ?>

	<?php endwhile; ?>

		<?php if (function_exists('bones_page_navi')) { ?>
			<?php bones_page_navi('', '', 'Newer Posts', 'Older Posts'); ?>
		<?php } else { ?>
			<nav class="wp-prev-next">
				<ul class="clearfix">
					<li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', 'adap_sc')) ?></li>
					<li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', 'adap_sc')) ?></li>
				</ul>
			</nav>
		<?php } ?>

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
		</div>
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
			'name' => 'Blog',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => 'Items',
					'param_name' => 'items',
					'value' => '10',
					'description' => 'The number of items to show on a given page. Set to -1 to show all.'
				),
				array(
					'type' => 'dropdown',
					'heading' => 'Layout',
					'param_name' => 'layout',
					'sch_default' => 'large-image',
					'value' => array(
						'Large Images' => 'large-image',
						'Medium Image' => 'medium-image',
						'Full Size' => 'full-image',
						'Full Size (Alternate)' => 'full-image-alt',
						'Grid' => 'grid'
					),
					'description' => 'What to display for each post.'

				),
				array(
					'type' => 'dropdown',
					'heading' => 'Number of Columns',
					'param_name' => 'columns',
					'sch_default' => 4,
					'value' => array('Four' => 4, 'Three' => 3, 'Two' => 2, 'One' => 1),
					"dependency" => Array('element' => "layout", 'value' => array('grid'))

				),
				AdapAutoVCShortcode::bool_param('grid_show_title', 'Show Title', null, null, true,
					Array('element' => "layout", 'value' => array('grid'))),
				AdapAutoVCShortcode::bool_param('grid_show_excerpt', 'Show Excerpt', null, null, true,
					Array('element' => "layout", 'value' => array('grid'))),
				AdapAutoVCShortcode::bool_param('grid_show_meta', 'Show Meta', null, null, true,
					Array('element' => "layout", 'value' => array('grid'))),

				AdapAutoVCShortcode::$order_param,
				AdapAutoVCShortcode::$orderby_param,
				array(
					'type' => 'dropdown',
					'heading' => 'Paginate',
					'param_name' => 'paginate',
					'value' => array('Paginate' => 'yes', 'Don\'t Paginate' => 'no'),
				),
				array(
					"type" => "checkbox",
					"heading" => __("Categories", 'adap_sc'),
					"param_name" => "categories",
					"value" => $cat_vals,
					"description" => __("If you want to narrow output, select category names here. Note: Only selected categories will be included.", 'adap_sc')
				),
				array(
					'type' => 'dropdown',
					'heading' => 'Display',
					'param_name' => 'display',
					'value' => array('Content' => 'content', 'Excerpt' => 'excerpt'),
					'description' => 'What to display for each post.'

				)
			));
	}

	function get_query($params)
	{
		if ($params['paginate'] == 'false' || $params['paginate'] == 'no')
			$params['items'] = false;

		if (!empty($params['categories']) && is_string($params['categories'])) {
			$cat_terms = explode(',', $params['categories']);
		}

		$page = get_query_var('paged') ? get_query_var('paged') : get_query_var('page');
		if (!$page) $page = 1;
		if (isset($cat_terms[0]) &&
			!empty($cat_terms[0]) &&
			!is_null($cat_terms[0]) &&
			$cat_terms[0] != "null" &&
			!empty($params['taxonomy'])
		) {
			$query = array(
				'orderby' => $params['orderby'],
				'order' => $params['order'],
				'paged' => $page,
				'posts_per_page' => $params['items'],
				'tax_query' => array(array('taxonomy' => $params['taxonomy'],
					'field' => 'slug',
					'terms' => $cat_terms,
					'operator' => 'IN')));
		} else {
			$query = array(
				'orderby' => $params['orderby'],
				'order' => $params['order'],
				'paged' => $page,
				'posts_per_page' => $params['items'],
				'post_type' => $params['post_type']);
		}

		return new WP_Query($query);
	}
}

new AdapBlogSC('blog');