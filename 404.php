<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package herniau
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found container" style="padding:50px 0 100px 0; text-align: center;">
			<header class="page-header">
				<div class="text-404">404</div>
				<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'herniau' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">

				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a quick search?', 'herniau' ); ?></p>

					<?php
					get_search_form();
			
					?>



			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
