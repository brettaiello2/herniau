<?php
/**
 * Template part for displaying page content in default post types
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package herniau
 */

?>

<?php

		$first_name     = get_field('first_name', $post_id);
		$last_name     = get_field('last_name', $post_id);
		$med_credentials     = get_field('med_credentials', $post_id);
    $intro = get_field('short_bio');
    $bio = get_field('additional_info');
    $headshot = get_field('photo');
		if ($headshot && isset($headshot['sizes']['medium'])) {
		    $headshot_url = $headshot['sizes']['medium'];
		} else {
		    $headshot_url = '/wp-content/uploads/2025/08/Coming-Soon-HU.png';
		}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header page-hero">
		<div class="background-image" style="background-image:url(<?php echo esc_url( get_the_post_thumbnail_url(null, 'full') ); ?>);">
		</div>
		<div class="header-content container">

			<div class="headshot">
				<img src="<?php echo esc_url($headshot_url); ?>" alt="<?php echo esc_attr(trim("$first_name $last_name $med_credentials")); ?>" />
			</div>

			<div class="intro">
				<h1>
					<?php echo esc_html(get_the_title()); ?> <?php echo esc_html($med_credentials); ?>
				</h1>
				<?php echo $intro;	 ?>
			</div>
		</div>
	</header>

	<div class="entry-content">
		<div class="container">
			<?php echo $bio; ?>
		</div>
	</div><!-- .entry-content -->


</article><!-- #post-<?php the_ID(); ?> -->


