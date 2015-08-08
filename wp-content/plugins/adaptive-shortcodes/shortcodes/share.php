<?php

class AdapShareSC extends AdapAutoVCShortcode
{

	function shortcode_handler($atts, $content = null)
	{
		extract($this->getPreparedAtts($atts, $content));

		$uri = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$fbSharerURI = sprintf('http://www.facebook.com/sharer/sharer.php?u=%s', $uri);
		$twitLink = sprintf('http://twitter.com/home?status=%s', $uri);
		$linkedLink = sprintf('http://linkedin.com/shareArticle?mini=true&amp;url=%s', $uri);
		$gplusLink = sprintf('http://google.com/bookmarks/mark?op=edit&amp;bkmk=%s', $uri);
		$emailLink = sprintf('?subject=%s&amp;body=%s', $uri, $uri);
		$uri = 'http://www.google.com';
		$tumblrLink = sprintf('http://www.tumblr.com/share');
		$pinterestLink = sprintf('http://pinterest.com/pin/create/button/?url=%s', $uri);


		ob_start();
		?>
		<div class="social-sharing-sc">
			<?php echo $share_text; ?>
			<ul class="social-sharing-links">
				<?php if (isset($twitter) && $twitter == 'true') { ?>
					<li><a href="<?php echo $twitLink; ?>"><i class="entypo-twitter-circled"></i></a></li>
				<?php } ?>
				<?php if (isset($facebook) && $facebook == 'true') { ?>
					<li><a href="<?php echo $fbSharerURI; ?>"><i class="entypo-facebook-circled"></i></a></li>
				<?php } ?>
				<?php if (isset($google) && $google == 'true') { ?>
					<li><a href="<?php echo $gplusLink; ?>"><i class="entypo-gplus-circled"></i></a></li>
				<?php } ?>
				<?php if (isset($linkedin) && $linkedin == 'true') { ?>
					<li><a href="<?php echo $linkedLink; ?>"><i class="entypo-linkedin-circled"></i></a></li>
				<?php } ?>
				<?php if (isset($tumblr) && $tumblr == 'true') { ?>
					<li><a href="<?php echo $tumblrLink; ?>"><i class="entypo-tumblr-circled"></i></a></li>
				<?php } ?>
				<?php if (isset($pinterest) && $pinterest == 'true') { ?>
					<li><a href="<?php echo $pinterestLink; ?>"><i class="entypo-pinterest-circled"></a></i></li>
				<?php } ?>
				<?php if (isset($email) && $email == 'true') { ?>
					<li><a href="mailto:<?php echo $emailLink; ?>"><i class="entypo-mail"></i></a></li>
				<?php } ?>
			</ul>
		</div>
		<?php ?>

		<?php
		$ret_val = ob_get_contents();
		ob_end_clean();
		return $ret_val;
	}

	function configureParams()
	{
		$this->params = array(
			'name' => 'Share',
			'base' => $this->sc_handle,
			'class' => '',
			'category' => __('Content', 'adap_sc'),
			'params' => array(
				array(
					'type' => 'textfield',
					'holder' => 'div',
					'class' => '',
					'heading' => __("Share Text", 'adap_sc'),
					'param_name' => 'share_text',
					'value' => 'Share via',
					'description' => ''
				),
				array(
					'type' => 'checkbox',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Show Twitter?', 'adap_sc'),
					'param_name' => 'twitter',
					'sch_default' => 'false',
					'value' => array('Enable' => 'true'),
					'description' => __('Show Twitter share button.', 'adap_sc')
				),
				array(
					'type' => 'checkbox',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Show Facebook?', 'adap_sc'),
					'param_name' => 'facebook',
					'sch_default' => 'false',
					'value' => array('Enable' => 'true'),
					'description' => __('Show Facebook share button.', 'adap_sc')
				),
				array(
					'type' => 'checkbox',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Show Google+?', 'adap_sc'),
					'param_name' => 'google',
					'sch_default' => 'false',
					'value' => array('Enable' => 'true'),
					'description' => __('Show Google+ share button.', 'adap_sc')
				),
				array(
					'type' => 'checkbox',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Show LinkedIn?', 'adap_sc'),
					'param_name' => 'linkedin',
					'sch_default' => 'false',
					'value' => array('Enable' => 'true'),
					'description' => __('Show LinkedIn share button.', 'adap_sc')
				),
				array(
					'type' => 'checkbox',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Show Tumblr?', 'adap_sc'),
					'param_name' => 'tumblr',
					'sch_default' => 'false',
					'value' => array('Enable' => 'true'),
					'description' => __('Show Tumblr share button.', 'adap_sc')
				),
				array(
					'type' => 'checkbox',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Show Pinterest?', 'adap_sc'),
					'param_name' => 'pinterest',
					'sch_default' => 'false',
					'value' => array('Enable' => 'true'),
					'description' => __('Show Pinterest share button.', 'adap_sc')
				),
				array(
					'type' => 'checkbox',
					'holder' => 'div',
					'class' => '',
					'heading' => __('Show Email?', 'adap_sc'),
					'param_name' => 'email',
					'sch_default' => 'false',
					'value' => array('Enable' => 'true'),
					'description' => __('Show Email share button.', 'adap_sc')
				),
			)
		);
	}
}

new AdapShareSC('share');