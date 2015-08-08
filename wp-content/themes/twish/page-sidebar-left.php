<?php
/*
Template Name: Page with Left Sidebar
*/
?>

<?php get_header(); ?>

<!-- Subhead
================================================== -->
<header class="jumbotron subhead" id="overview">
	<div class="container">
		<?php get_template_part('breadcrumb'); ?>

		<h1><?php the_title(); ?></h1>

		<p class="lead"><?php if (function_exists('the_subtitle')) the_subtitle(); ?></p>
	</div>
</header>

<div class="container">
	<div class="row">

		<!-- Content
		================================================== -->
		<div class="span8 offset1 pull-right" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php get_template_part('content', 'page'); ?>

			<?php endwhile; else : ?>

				<article id="post-not-found" class="hentry clearfix">
					<header class="article-header">
						<h1><?php _e("Oops, Post Not Found!", 'adap'); ?></h1>
					</header>
					<section class="entry-content">
						<p><?php _e("Uh Oh. Something is missing. Try double checking things.", 'adap'); ?></p>
					</section>
					<footer class="article-footer">
						<p><?php _e("This is the error message in the page-custom.php template.", 'adap'); ?></p>
					</footer>
				</article>

			<?php endif; ?>

		</div>

		<!-- Sidebar
		================================================== -->
		<div class="span3 bs-docs-sidebar pull-left">
			<?php get_sidebar(); ?>
		</div>

	</div>
</div>

<?php get_footer(); ?>
