<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package herniau
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class("search-result"); ?>>

<div class="thumb">
    <?php if ( get_post_type() === 'video' || get_post_type() === 'lecture' ) : ?>
        <?php 
        $thumbnail = get_field('thumbnail');
        if ( $thumbnail ) :
        ?>
            <a href="<?php the_permalink(); ?>">
                <img src="<?php echo esc_url( $thumbnail['url'] ); ?>" alt="<?php echo esc_attr( $thumbnail['alt'] ); ?>" />
            </a>
        <?php endif; ?>

    <?php elseif( get_post_type() === 'instructor'): ?>
        <?php 
        $thumbnail = get_field('photo');
        if ( $thumbnail ) :
        ?>
            <a href="<?php the_permalink(); ?>">
                <img src="<?php echo esc_url( $thumbnail['url'] ); ?>" alt="<?php echo esc_attr( $thumbnail['alt'] ); ?>" />
            </a>
        <?php endif; ?>

    <?php else : ?>
        <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium'); ?>
            </a>
        <?php endif; ?>
    <?php endif; ?>		
</div>

	<div class="content-result">
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">

		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php if ( get_post_type() === 'video' || get_post_type() === 'lecture' ) : ?>
		    <p><?php the_field('description'); ?></p>
		<?php else : ?>
		    <p><?php the_excerpt(); ?></p>
		<?php endif; ?>
	</div><!-- .entry-summary -->
</div>
</article><!-- #post-<?php the_ID(); ?> -->
