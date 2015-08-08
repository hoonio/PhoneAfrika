<?php get_header(); ?>

<header class="jumbotron subhead" id="overview">
	<div class="container">
		<?php get_template_part('breadcrumb'); ?>

		<h1><span><?php _e('Search Results for:', 'adap'); ?></span> <?php echo esc_attr(get_search_query()); ?></h1>
	</div>
</header>


<div class="container">
	<div class="row">

		<!-- Content
		================================================== -->
		<div id="content" class="span8" role="main">
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
						<h1><?php _e("Couldn't find what you're looking for.", 'adap'); ?></h1>
					</header>
					<section class="entry-content">
						<p><?php _e("Please try another search phrase.", 'adap'); ?></p>
					</section>
				</article>

			<?php endif; ?>
		</div>

		<!-- Sidebar
		================================================== -->
		<div class="span3 offset1 bs-docs-sidebar">
			<?php get_sidebar(); ?>
		</div>

	</div>
</div>
<?php get_footer(); ?>
