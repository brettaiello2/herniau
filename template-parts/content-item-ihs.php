<article <?php post_class("swiper-slide content-item"); ?> id="post-<?php the_ID(); ?>">

    <div class="thumb">
        <?php 
        $image_url = get_the_post_thumbnail_url(get_the_ID(),'large'); 
        ?>
        <a href="<?php the_permalink(); ?>">
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($thumbnail['alt'] ?? ''); ?>" />
        </a>
    </div>

    <div class="body">
        <h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    </div>

</article>