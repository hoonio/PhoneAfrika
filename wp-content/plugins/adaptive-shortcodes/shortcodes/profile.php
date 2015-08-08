<?php

class AdapProfileSC extends AdapAutoVCShortcode
{

	function shortcode_handler($atts, $content = null)
	{
		extract($this->getPreparedAtts($atts, $content));

		$src = $src ? wp_get_attachment_image_src($src, $image_size) : '';
		$src = is_array($src) ? $src[0] : '';

		$show_twitter = strlen(trim($twitter_url)) > 0;
		$show_facebook = strlen(trim($facebook_url)) > 0;
		$show_google = strlen(trim($google_url)) > 0;
		$show_linkedin = strlen(trim($linkedin_url)) > 0;

		ob_start();
		?>
		<div class="adap-profile-shortcode">
			<div class="thumbnail">
				<?php if ($src != null) echo '<img class="profile-picture" src="' . $src . '" title="' . $name . '" alt="' . $name . '">'; ?>
				<div class="caption">
					<h3 class="profile-name"><?php echo $name ?></h3>
					<ul class="profile-social-links">
						<?php if ($show_twitter) { ?>
							<li><a href="<?php echo $twitter_url; ?>"><i class="icon-twitter"></i></a></li><?php } ?>
						<?php if ($show_facebook) { ?>
							<li><a href="<?php echo $facebook_url; ?>"><i class="icon-facebook"></i></a></li><?php } ?>
						<?php if ($show_google) { ?>
							<li><a href="<?php echo $google_url; ?>"><i class="icon-google-plus"></i></a></li><?php } ?>
						<?php if ($show_linkedin) { ?>
							<li><a href="<?php echo $linkedin_url; ?>"><i class="icon-linkedin"></i></a></li><?php } ?>
					</ul>
					<p class="profile-title"><?php echo $title; ?></p>

					<div class="profile-text"><?php echo do_shortcode($content); ?></div>
				</div>
			</div>
		</div>

		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	function configureParams()
	{
		$this->params = array(
			'name' => 'Profile',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),
			'params' => array(
				array(
					'type' => 'attach_image',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Profile Image', 'adap_sc'),
					'param_name' => 'src',
					'value' => null,
					'description' => __('', 'adap_sc')
				),
				AdapAutoVCShortcode::$image_size_param,
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Name', 'adap_sc'),
					'param_name' => 'name',
					'value' => __('John Doe', 'adap_sc'),
					'description' => __('', 'adap_sc')
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Title', 'adap_sc'),
					'param_name' => 'title',
					'value' => __('Founder, CEO', 'adap_sc'),
					'description' => __('', 'adap_sc')
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Twitter URL', 'adap_sc'),
					'param_name' => 'twitter_url',
					'value' => __('', 'adap_sc'),
					'description' => __('', 'adap_sc')
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Facebook URL', 'adap_sc'),
					'param_name' => 'facebook_url',
					'value' => __('', 'adap_sc'),
					'description' => __('', 'adap_sc')
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Google+ URL', 'adap_sc'),
					'param_name' => 'google_url',
					'value' => __('', 'adap_sc'),
					'description' => __('', 'adap_sc')
				),
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __('LinkedIn URL', 'adap_sc'),
					'param_name' => 'linkedin_url',
					'value' => __('', 'adap_sc'),
					'description' => __('', 'adap_sc')
				),
				array(
					"type" => "textarea_html",
					"holder" => "div",
					"class" => "",
					"heading" => __("Content", 'adap_sc'),
					"param_name" => "content",
					"value" => __("Profile text.", 'adap_sc'),
					"description" => __("", 'adap_sc')
				),
			)
		);
	}

}

new AdapProfileSC('profile');