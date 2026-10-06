<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package herniau
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<div class="page-hero">
			<div class="container">

				<?php
				echo do_shortcode('[breadcrumbs]');
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>

			</div>
			</div>

			<div class="entry-content">
			<div class="container">
			<section class="grid-posts">
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				include get_template_directory() . '/template-parts/content-item-general.php';

			endwhile;


			?>

			</section>

			<?php global $wp_query; ?>
			<?php if ( $wp_query->max_num_pages > 1 ) : ?>
			    <div class="load-more-wrap">
			        <button 
			            class="load-more"
			            data-current-page="<?php echo max(1, get_query_var('paged')); ?>" 
			            data-max-pages="<?php echo $wp_query->max_num_pages; ?>"
			            data-post-type="<?php echo get_post_type(); ?>" 
			            data-posts-per-page="<?php echo get_query_var('posts_per_page'); ?>"
			            data-taxonomy="<?php echo get_queried_object()->taxonomy ?? ''; ?>"
			            data-term="<?php echo get_queried_object()->slug ?? ''; ?>"
			        >
			            Load More
			        </button>
			    </div>
			<?php endif; ?>

			</div>
			</div>

			<?php

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
