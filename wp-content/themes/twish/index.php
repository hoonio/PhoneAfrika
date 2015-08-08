<?php get_header(); ?>


<!-- Subhead
================================================== -->
<header class="jumbotron subhead" id="overview">
	<div class="container">
		<?php get_template_part('breadcrumb'); ?>
		<?php
		// Get the page title
		$pid = is_home() ? get_option('page_for_posts') : false;
		$title = $pid ? get_the_title($pid) : __('Blog', 'adap');

		$subtitle = function_exists('get_the_subtitle') && $pid ? get_the_subtitle($pid) : '';
		?>
		<!--h1><?php echo $title; ?></h1-->

		<p class="lead"><?php echo $subtitle; ?></p>
	</div>
</header>

<div class="container">
	<div class="row">

		<!-- Content
		================================================== -->
		<div id="content" class="<?php echo AdapThemeOptions::get_blog_content_classes(); ?>" role="main">
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
		<?php if (AdapThemeOptions::show_blog_sidebar()) { ?>
			<div class="<?php echo AdapThemeOptions::get_blog_sidebar_classes(); ?> bs-docs-sidebar">
				<?php get_sidebar(); ?>
			</div>
		<?php } ?>

	</div>
</div>
<?php get_footer(); ?>
