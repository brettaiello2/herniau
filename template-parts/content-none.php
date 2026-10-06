<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package herniau
 */

?>

<section class="no-results not-found">


	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'herniau' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		elseif ( is_search() ) :
			?>

			<div class="page-hero">
			<div class="container pt-md-4 pb-md-4">
				<h1 class="page-title">
					<?php
					printf( esc_html__( 'Search Results for: %s', 'herniau' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</div>
			</div>

			<div class="entry-content">
			<div class="container" style="text-align: center;">
			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'herniau' ); ?></p>
			<?php get_search_form(); ?>
			</div>
			</div>


			<?php
		else :
			?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'herniau' ); ?></p>
			<?php
			get_search_form();

		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
