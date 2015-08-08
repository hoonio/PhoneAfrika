<?php
/*
The comments page for Bones
*/

// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');

if (post_password_required()) {
	?>
	<div class="alert alert-help">
		<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments.", 'adap'); ?></p>
	</div>
	<?php
	return;
}
?>

	<!-- You can start editing here. -->

<?php if (have_comments()) : ?>
	<h3 id="comments"
		class="h4 comments-title"><?php comments_number(__('Comments', 'adap'), __('Comments', 'adap'), _n('Comments', 'Comments', 'adap')); ?></h3>

	<div class="comments">
		<?php wp_list_comments(array('type' => 'all', 'callback' => 'bones_comments', 'end-callback' => 'bones_comments_end', 'style' => 'div'));
		// you can find bones_comments & bones_comments_end in functions.php
		?>
	</div>
	<div class="navigation">
		<?php paginate_comments_links(); ?>
	</div>


<?php else : // this is displayed if there are no comments so far ?>

	<?php if (comments_open()) : ?>
		<!-- If comments are open, but there are no comments. -->

	<?php else : // comments are closed ?>

		<!-- If comments are closed. -->
		<!--p class="nocomments"><?php _e("Comments are closed.", 'adap'); ?></p-->

	<?php endif; ?>

<?php endif; ?>


<?php if (comments_open()) : ?>

	<?php do_action('comment_form_before'); ?>

	<section id="respond" class="respond-form">

		<h3 id="comment-form-title"
			class="h4"><?php comment_form_title(__('Post your comment', 'adap'), __('Leave a Reply to %s', 'adap')); ?></h3>

		<div id="cancel-comment-reply">
			<p class="small"><?php cancel_comment_reply_link(); ?></p>
		</div>

		<?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
			<div class="alert alert-help">
				<p><?php printf(__('You must be %1$slogged in%2$s to post a comment.', 'adap'), '<a href="<?php echo wp_login_url( get_permalink() ); ?>">', '</a>'); ?></p>
				<?php do_action('comment_form_must_log_in_after'); ?>
			</div>
		<?php else : ?>

			<?php if(of_get_option('use_wp_comment_form')){
				comment_form();
			}
			else{
			?>
			<form class="form-horizontal comment-form"
				  action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php"
				  method="post" id="commentform">
				<?php do_action('comment_form_top'); ?>

				<div class="control-group">
					<label class="control-label"
						   for="comment"><?php _e("Comment", 'adap'); ?>  <?php if ($req) _e("(required)", 'adap'); ?></label>

					<div class="controls">
						<textarea name="comment" rows="12" id="comment"
								  placeholder="<?php _e('Your Comment here...', 'adap'); ?>" tabindex="4"></textarea>
					</div>
				</div>


				<?php if (is_user_logged_in()) : ?>

					<p class="comments-logged-in-as"><?php _e("Logged in as", 'adap'); ?> <a
							href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>.
						<a
							href="<?php echo wp_logout_url(get_permalink()); ?>"
							title="<?php _e("Log out of this account", 'adap'); ?>"><?php _e("Log out", 'adap'); ?> <?php _e("&raquo;", 'adap'); ?></a>
					</p>

				<?php else : ?>
					<?php do_action('comment_form_before_fields'); ?>


					<div class="row-fluid">

						<div class="control-group span6 name-field-wrapper">
							<label class="control-label"
								   for="author"><?php _e("Name", 'adap'); ?> <?php if ($req) _e("(required)", 'adap'); ?></label>

							<div class="controls">
								<input type="text" name="author" id="author"
									   value="<?php echo esc_attr($comment_author); ?>"
									   placeholder="<?php _e('Your Name*', 'adap'); ?>"
									   tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
							</div>
						</div>

						<div class="control-group span6 email-field-wrapper">
							<label class="control-label"
								   for="email"><?php _e("Email", 'adap'); ?> <?php if ($req) _e("(required)", 'adap'); ?></label>

							<div class="controls">
								<input type="email" name="email" id="email"
									   value="<?php echo esc_attr($comment_author_email); ?>"
									   placeholder="<?php _e('Your E-Mail*', 'adap'); ?>"
									   tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
							</div>
						</div>

					</div>

					<div class="row-fluid">

						<?php // TODO Make the website field optional ?>
						<div class="control-group span6 website-field-wrapper">
							<label class="control-label" for="url"><?php _e("Website", 'adap'); ?></label>

							<div class="controls">
								<input type="url" name="url" id="url"
									   value="<?php echo esc_attr($comment_author_url); ?>"
									   placeholder="<?php _e('Got a website?', 'adap'); ?>" tabindex="3"/>
							</div>
						</div>

					</div>

					<?php do_action('comment_form_after_fields'); ?>

				<?php endif; ?>

				<div class="control-group submit-field-wrapper">
					<div class="controls">
						<input name="submit" type="submit" id="submit" class="button btn" tabindex="5"
							   value="<?php _e('Send Message', 'adap'); ?>"/>
						<?php comment_id_fields(); ?>
					</div>
				</div>



				<?php do_action('comment_form', $post->ID); ?>

			</form>
				<?php } ?>
			<?php do_action('comment_form_after'); ?>

		<?php endif; // If registration required and not logged in ?>
	</section>

<?php endif; // if you delete this the sky will fall on your head ?>