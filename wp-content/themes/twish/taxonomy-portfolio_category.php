<?php get_header(); ?>

<!-- Subhead
================================================== -->
<header class="jumbotron subhead" id="overview">
	<div class="container">
		<?php get_template_part('breadcrumb'); ?>

		<h1 class="archive-title h2">
			<span><?php _e("Portfolio Category:", 'adap'); ?></span> <?php single_cat_title(); ?>
		</h1>

	</div>
</header>

<div class="container">
	<div class="row">

		<!-- Content
		================================================== -->
		<div class="span12" role="main">

			<?php echo do_shortcode('[portfolio show_filters="false" categories="' . get_queried_object()->slug .'"]'); ?>

		</div>

	</div>
</div>

<?php get_footer(); ?>
