<?php
/**
 * Template part for displaying IHS page content in default post types
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package herniau
 */

?>





<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>



			<?php
			the_content();
			?>



</article><!-- #post-<?php the_ID(); ?> -->


