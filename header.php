<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package herniau
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon.ico" type="image/x-icon">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="192x192" href="<?php echo get_template_directory_uri(); ?>/assets/img/android-chrome-512x512.png">
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/apple-touch-icon.png">


	<?php wp_head(); ?>
	<link rel='stylesheet' id='custom-um-css-css' href='/wp-content/themes/herniau/assets/css/custom-um.css?ver=1750111114' media='all' />
<link rel='stylesheet' id='custom-um-css-css' href='/wp-content/themes/herniau/assets/css/custom-ld.css' media='all' />
<style type="text/css"><?php echo get_field("custom_css"); ?></style>

</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">

<?php
// $post_types = get_post_types([], 'names'); 

// foreach ($post_types as $post_type) {
//     echo $post_type . '<br>';
// }
?>



	<header id="masthead" class="site-header">
		<div class="container">

			<div class="nav-toggle" onclick="menuBtnFunction(this)">
				<span></span> 
			</div>

			<div class="site-branding">
				<a href="/"><img src="/wp-content/uploads/2025/06/herniau-logo.png" alt="HerniaU"/></a>
			</div>


			<?php if ( is_user_logged_in() ): ?>
			<div class="search-wrap">
			<?php get_search_form(); ?>
			</div>

			
			<div class="account-menu">
				<?php
				$current_user = wp_get_current_user();
				$first_name = $current_user->first_name;
				  if ( empty( $first_name ) ) {
				        $first_name = $current_user->display_name;
				   }
    			$first_letter = strtoupper( mb_substr( $first_name, 0, 1 ) );
				?>
				<div class="trigger"><?php echo $first_letter; ?></div>
				<nav>
					<ul>
						<li><a href="/account">Account</a></li>
						<li><a href="/my-courses">My Courses</a></li>
						<li><a href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a></li>
					</ul>
				</nav>

			</div>
			<?php else: ?>

				<div class="wp-block-button header-login-button"><a class="wp-block-button__link wp-element-button" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#loginModal">Login / Register</a></div>

			<?php endif; ?>

		</div>

		<nav class="flyout-menu">

			<div class="inner">

				<div class="close-btn">Close</div>

			<?php
				wp_nav_menu(
					array(
						'theme_location' => 'main-nav',
					)
				);
				?>

			</div>

		</nav>

	</header>




