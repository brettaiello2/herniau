<div class="login-block">
	<div class="badge">
		<img src="/wp-content/uploads/2025/07/Member-Badge-dyn.png" />
		<div class="user-count">
			<?php
			$user_count = count_users();
			$roles = $user_count['avail_roles'];
			$subscriber_count = isset($roles['subscriber']) ? $roles['subscriber'] : 0;
			echo number_format($subscriber_count);
			?>

		</div>
	</div>
	<!-- <div class="intro">Register for Free</div> -->
<!-- 	<div class="nav-pills">
		<ul>
			<li class="active"><a href="#">Login</a></li>
			<li><a href="/register">Register</a></li>
		</ul>
	</div> -->
	<?php echo do_shortcode('[ultimatemember form_id="1107"]'); ?>
	<div class="connect-hr"><span>Or Connect With</span></div>
	<?php echo do_shortcode('[ultimatemember_social_login id=4626]'); ?>
</div>