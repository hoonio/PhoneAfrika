<?php get_header(); ?>


<!-- Subhead
================================================== -->
<header class="jumbotron subhead" id="overview">
	<div class="container">
		<?php get_template_part('breadcrumb'); ?>

		<h1><?php echo __('Blog', 'adap'); ?></h1>

		<p class="lead"><?php if (function_exists('the_subtitle')) the_subtitle(); ?></p>
	</div>
</header>


<div class="container">
	<div class="row">
		<div class="<?php echo AdapThemeOptions::get_post_content_classes(); ?>" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<section class="<?php echo 'adap-post-format-' . get_post_format(); ?>">

					<?php get_template_part('content', get_post_format()); ?>

				</section>

			<?php endwhile; ?>

			<?php else : ?>

				<article id="post-not-found" class="hentry clearfix">
					<header class="article-header">
						<h1><?php _e("Oops, Post Not Found!", 'adap'); ?></h1>
					</header>
					<section class="entry-content">
						<p><?php _e("Uh Oh. Something is missing. Try double checking things.", 'adap'); ?></p>
					</section>
					<footer class="article-footer">
						<p><?php _e("This is the error message in the single.php template.", 'adap'); ?></p>
					</footer>
				</article>

			<?php endif; ?>


		</div>

		<!-- Sidebar
		================================================== -->
		<?php if (AdapThemeOptions::show_post_sidebar()) { ?>
			<div class="<?php echo AdapThemeOptions::get_post_sidebar_classes(); ?>  bs-docs-sidebar">
				<?php get_sidebar(); ?>
			</div>
		<?php } ?>

	</div>
</div>


<?php get_footer(); ?>
