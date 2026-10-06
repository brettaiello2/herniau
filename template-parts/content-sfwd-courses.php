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

	<?php $featured_image = get_the_post_thumbnail_url(null, 'full'); ?>

	<input type="hidden" id="background-image" value="<?php echo esc_url($featured_image); ?>">
	
	<?php the_content(); ?>
	
</article>