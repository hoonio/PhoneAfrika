<div id="sidebar1" class="sidebar" role="complementary">
	<?php
	global $show_subnav;
	if ($show_subnav) {
		?>
		<div class="widget widget-sidenav">
			<?php
			wp_reset_query();
			$anc = get_post_ancestors($post->ID);
			$parent = end($anc);
			?>
			<ul>
				<?php
				$parent_li = is_page($parent) ? '<li class="current_page_item">' : '<li>';
				echo $parent_li;
				?>
				<a href="<?php echo get_permalink($parent); ?>"
				   title="Parent"><?php echo get_the_title($parent); ?></a>

				<ul>
					<?php
					$page_listing = $parent ? wp_list_pages("title_li=&child_of=" . $parent . "&echo=0") : wp_list_pages("title_li=&child_of=" . $post->ID . "&echo=0");

					if ($page_listing) {
						echo $page_listing;
					}
					?>
				</ul>
				</li>

			</ul>
		</div>
	<?php
	}
	?>
	<?php if (is_active_sidebar('sidebar1')) : ?>

		<?php dynamic_sidebar('sidebar1'); ?>

	<?php else : ?>

		<!-- This content shows up if there are no widgets defined in the backend. -->

		<div class="alert alert-help">
			<p><?php _e("Please activate some Widgets.", 'adap'); ?></p>
		</div>

	<?php endif; ?>

</div>