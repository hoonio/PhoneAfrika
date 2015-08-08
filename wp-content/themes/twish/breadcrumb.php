<?php if (function_exists('bcn_display')) { ?>
	<?php
	$align = get_post_meta(get_the_ID(), '_peach_breadcrumb_align', true);
	$align = $align ? 'align-' . $align : 'align-left';

	$hide = get_post_meta(get_the_ID(), '_peach_hide_breadcrumb', true);
	$hide = $hide ? 'hide' : '';

	$bcn_classes = $align . ' ' . $hide;
	?>

	<div class="theme-breadcrumbs <?php echo $bcn_classes ?>">
		<?php bcn_display(); ?>
	</div>
<?php } ?>