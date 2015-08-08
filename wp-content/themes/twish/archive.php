<?php get_header(); ?>

<!-- Subhead
================================================== -->
<header class="jumbotron subhead" id="overview">
	<div class="container">
		<?php get_template_part('breadcrumb'); ?>
		<?php if (is_category()) { ?>
			<h1 class="archive-title h2">
				<span><?php _e("Posts Categorized:", 'adap'); ?></span> <?php single_cat_title(); ?>
			</h1>

		<?php } elseif (is_tag()) { ?>
			<h1 class="archive-title h2">
				<span><?php _e("Posts Tagged:", 'adap'); ?></span> <?php single_tag_title(); ?>
			</h1>

		<?php
		} elseif (is_author()) {
			global $post;
			$author_id = $post->post_author;
			?>
			<h1 class="archive-title h2">
				<span><?php _e("Posts By:", 'adap'); ?></span> <?php the_author_meta('display_name', $author_id); ?>
			</h1>
		<?php } elseif (is_day()) { ?>
			<?php $date_format = get_option('date_format'); ?>
			<h1 class="archive-title h2">
				<span><?php _e("Daily Archives:", 'adap'); ?></span> <?php the_time($date_format); ?>
			</h1>

		<?php } elseif (is_month()) { ?>
			<h1 class="archive-title h2">
				<?php $date_format = 'F Y'; ?>
				<span><?php _e("Monthly Archives:", 'adap'); ?></span> <?php the_time($date_format); ?>
			</h1>

		<?php } elseif (is_year()) { ?>
			<h1 class="archive-title h2">
				<?php $date_format = 'Y'; ?>
				<span><?php _e("Yearly Archives:", 'adap'); ?></span> <?php the_time($date_format); ?>
			</h1>
		<?php } ?>
	</div>
</header>

<div class="container">
	<div class="row">

		<!-- Content
		================================================== -->
		<div id="content" class="<?php echo AdapThemeOptions::get_archive_content_classes(); ?>" role="main">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<section class="post-preview <?php echo 'adap-post-format-' . get_post_format(); ?>">
					<?php get_template_part('content', get_post_format()); ?>
				</section>
			<?php endwhile; ?>

				<div class="blog-pagination">
					<?php if (function_exists('bones_page_navi')) { ?>
						<?php bones_page_navi(); ?>
					<?php } else { ?>
						<nav class="wp-prev-next">
							<ul class="clearfix">
								<li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', 'adap')) ?></li>
								<li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', 'adap')) ?></li>
							</ul>
						</nav>
					<?php } ?>
				</div>

			<?php else : ?>

				<article id="post-not-found" class="hentry clearfix">
					<header class="article-header">
						<h1><?php _e("Oops, Post Not Found!", 'adap'); ?></h1>
					</header>
					<section class="entry-content">
						<p><?php _e("Uh Oh. Something is missing. Try double checking things.", 'adap'); ?></p>
					</section>
					<footer class="article-footer">
						<p><?php _e("This is the error message from the Adaptive Shortcodes' Blog Shortcode ", 'adap'); ?></p>
					</footer>
				</article>

			<?php endif; ?>
		</div>

		<!-- Sidebar
		================================================== -->
		<?php if (AdapThemeOptions::show_archive_sidebar()) { ?>

			<div class="<?php echo AdapThemeOptions::get_archive_sidebar_classes(); ?> bs-docs-sidebar">
				<?php get_sidebar(); ?>
			</div>

		<?php } ?>

	</div>
</div>
<?php get_footer(); ?>
