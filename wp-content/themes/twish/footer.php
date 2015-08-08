</div> <!-- close .main-content (opened in header.php) -->
<footer class="footer" role="contentinfo">

	<?php if (AdapThemeOptions::show_footer_widget_area()) { ?>

		<div id="inner-footer" class="wrap clearfix inner-footer">

			<div class="container">
				<div class="row-fluid">

					<?php if (AdapThemeOptions::show_footer_column_1()) { ?>

						<div
							class="footer-column footer-column-1 <?php echo AdapThemeOptions::get_footer_column_1_classes(); ?>">
							<?php
							if (is_active_sidebar('footer1')) {
								dynamic_sidebar('footer1');
							}
							?>
						</div>

					<?php } ?>

					<?php if (AdapThemeOptions::show_footer_column_2()) { ?>

						<div
							class="footer-column footer-column-2 <?php echo AdapThemeOptions::get_footer_column_2_classes(); ?>">
							<?php
							if (is_active_sidebar('footer2')) {
								dynamic_sidebar('footer2');
							}
							?>
						</div>

					<?php } ?>

					<?php if (AdapThemeOptions::show_footer_column_3()) { ?>

						<div
							class="footer-column footer-column-3 <?php echo AdapThemeOptions::get_footer_column_3_classes(); ?>">
							<?php
							if (is_active_sidebar('footer3')) {
								dynamic_sidebar('footer3');
							}
							?>
						</div>

					<?php } ?>

					<?php if (AdapThemeOptions::show_footer_column_4()) { ?>

						<div
							class="footer-column footer-column-4 <?php echo AdapThemeOptions::get_footer_column_4_classes(); ?>">
							<?php
							if (is_active_sidebar('footer4')) {
								dynamic_sidebar('footer4');
							}
							?>
						</div>

					<?php } ?>

				</div>
			</div>
		</div>
		<!-- end #inner-footer -->

	<?php } ?>

	<?php if (AdapThemeOptions::show_subfooter()) { ?>

		<div class="subfooter">
			<div class="container">
				<p class="source-org copyright"><?php echo AdapThemeOptions::get_subfooter_copyright_text(); ?></p>

				<nav role="navigation"><?php bones_footer_links(); ?></nav>
				<div class="social-icons subfooter-social-icons">
					<?php AdapThemeOptions::print_subfooter_social_icons(); ?>
				</div>
			</div>
		</div>

	<?php } ?>

</footer> <!-- end footer -->

<!-- all js scripts are loaded in library/bones.php -->
<?php wp_footer(); ?>

</body>

</html> <!-- end page. what a ride! -->
