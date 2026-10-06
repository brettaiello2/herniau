<?php
/**
 * Template part for displaying page content in default post types
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package herniau
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header page-hero">
		<div class="background-image" style="background-image:url(<?php echo esc_url( get_the_post_thumbnail_url(null, 'full') ); ?>);">
		</div>
		<div class="header-content container">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</div>
	</header>

	<div class="entry-content">
		<div class="container">
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'herniau' ),
					'after'  => '</div>',
				)
			);
			?>
		</div>
	</div><!-- .entry-content -->


</article><!-- #post-<?php the_ID(); ?> -->


