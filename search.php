<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package herniau
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<div class="page-hero">
			<div class="container pt-md-4 pb-md-4">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'herniau' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</div>
			</div>

			<div class="entry-content">
			<div class="container">
					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );

					endwhile;

	
				    the_posts_pagination( array(
				        'mid_size'  => 2,
				        'prev_text' => __( '« Prev', 'herniau' ),
				        'next_text' => __( 'Next »', 'herniau' ),
				    ) );


				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
			</div>
			</div>



	</main><!-- #main -->

<?php
get_footer();
