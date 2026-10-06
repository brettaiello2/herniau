<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package herniau
 */

?>

	<section class="footer-ss">
		<div class="container">

			<h3>Supporting Societies</h3>

			<div class="logo-list">
				<div><img src="/wp-content/uploads/2025/06/Frame-360.png" /></div>
				<div><img src="/wp-content/uploads/2025/06/Frame-361.png" /></div>
				<div><img src="/wp-content/uploads/2025/06/image-54.png" /></div>
				<div><img src="/wp-content/uploads/2025/06/image-56.png" /></div>
				<div><img src="/wp-content/uploads/2025/06/Frame-362.png" /></div>
				<div><img src="/wp-content/uploads/2025/06/Frame-363.png" /></div>
			</div>

		</div>

	</section>


	<footer id="colophon" class="site-footer">

		<div class="container">

			<div class="footer-brand"><img src="/wp-content/uploads/2025/06/Group-40.png" /></div>

			<nav class="footer-main-nav">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-1',
					)
				);
				?>
			</nav>

			<nav class="footer-sub-nav">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-2',
					)
				);
				?>
			</nav>

		</div>

		<div class="footer-copy">
			<p>
			BD, the BD Logo, Bard and Davol are trademarks of Becton, Dickinson and Company or its affiliates. All other trademarks are the property of their respective owners. © 2023 BD. All rights reserved. In accordance with the AdvaMed Code of Ethics, this program is limited to Healthcare Professionals only who have a bona fide interest in the presentation topic. Consult product labels and inserts for any indications, contraindications, hazards, warnings, precautions and instructions for use.
			</p>
		</div>

	</footer><!-- #colophon -->
</div><!-- #page -->




<?php wp_footer(); ?>


<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <?php echo do_shortcode('[acf_login_block]'); ?>
      </div>
    </div>
  </div>
</div>


<?php require get_template_directory() . '/inc/cookie-notice.php'; ?>

</body>
</html>
