<!doctype html>

<!--[if lt IE 7]>
<html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7 <?php adap_html_class('test-class-1'); ?>"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]>
<html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 <?php adap_html_class('test-class-1'); ?>"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]>
<html <?php language_attributes(); ?> class="no-js lt-ie9 <?php adap_html_class('test-class-1'); ?>"><![endif]-->
<!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?> class="no-js <?php adap_html_class('test-class-1'); ?>"><!--<![endif]-->

<head>
	<meta charset="utf-8">
	<title><?php bloginfo('name'); ?> <?php wp_title(); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php // TODO Add WordPress Description ?>">
	<meta name="author" content="<?php // TODO Add WordPress Author ?>">

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">


	<!-- wordpress head functions -->
	<?php wp_head(); ?>
	<!-- end of wordpress head -->

	<!-- drop Google Analytics Here -->
	<!-- end analytics -->

</head>

<body <?php body_class(adap_body_classes()); ?>>


<!-- Navbar
================================================== -->
<div class="navbar navbar-static-top header-navbar">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
				<div class="btn-navbar-inner">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</div>
			</a>
			<a class="brand" href="<?php echo home_url(); ?>"
			   data-mobile-height="<?php echo AdapThemeOptions::get_logo_mobile_height(true); ?>"
			   data-mobile-width="<?php echo AdapThemeOptions::get_logo_mobile_width(true); ?>"
				data-fullsize-height="<?php echo AdapThemeOptions::get_logo_fullsize_height(true); ?>"
				data-fullsize-width="<?php echo AdapThemeOptions::get_logo_fullsize_width(true); ?>"
				data-fullsize-voffset="<?php echo AdapThemeOptions::get_logo_fullsize_voffset(true); ?>"
				data-mobile-voffset="<?php echo AdapThemeOptions::get_logo_mobile_voffset(true); ?>">
				<?php AdapThemeOptions::print_site_logo_img_element(); ?>
			</a>

			<div class="social-icons header-social-icons">
				<?php AdapThemeOptions::print_header_social_icons(); ?>
			</div>
			<div class="nav-collapse collapse">
				<?php bones_main_nav(); ?>
			</div>

		</div>
	</div>
	<div class="clear"></div>
</div>
<div class="main-content">



