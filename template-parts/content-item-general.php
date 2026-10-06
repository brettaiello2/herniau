<article <?php post_class("swiper-slide content-item"); ?> id="post-<?php the_ID(); ?>">

    <div class="thumb">
        <?php 
        $thumbnail = get_field("thumbnail", get_the_ID());
        $image_url = '';
        $description = get_field("description", get_the_ID());
        $short_description = wp_trim_words($description, 15, '...');
        $gated = get_field("gated", get_the_ID());

        if (is_array($thumbnail) && isset($thumbnail['sizes']['medium'])) {
            $image_url = $thumbnail['sizes']['medium'];
        } elseif (is_array($thumbnail) && isset($thumbnail['url'])) {
            $image_url = $thumbnail['url'];
        }
        ?>
        <a href="<?php the_permalink(); ?>">
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($thumbnail['alt'] ?? ''); ?>" />
        </a>

        <?php if(get_field('duration',get_the_ID())): ?>
        <div class="duration-badge">
                <?php echo format_video_duration(get_field('duration',get_the_ID())); ?>
        </div>
        <?php endif; ?> 

        <?php if($gated): ?>

            <div class="gated-badge" data-bs-toggle="tooltip" data-bs-placement="top" title="Create a free account to view">
                <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24" id="Lock">
                  <path d="M17,9V7c0-2.8-2.2-5-5-5S7,4.2,7,7v2c-1.7,0-3,1.3-3,3v7c0,1.7,1.3,3,3,3h10c1.7,0,3-1.3,3-3v-7C20,10.3,18.7,9,17,9z M9,7
                    c0-1.7,1.3-3,3-3s3,1.3,3,3v2H9V7z M13.1,15.5c0,0-0.1,0.1-0.1,0.1V17c0,0.6-0.4,1-1,1s-1-0.4-1-1v-1.4c-0.6-0.6-0.7-1.5-0.1-2.1
                    c0.6-0.6,1.5-0.7,2.1-0.1C13.6,13.9,13.7,14.9,13.1,15.5z" fill="#ffb32f" class="color000000 svgShape"></path>
                </svg>
            </div>

        <?php else: ?>

            <div class="gated-badge" data-bs-toggle="tooltip" data-bs-placement="top" title="Available to view for non-members">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" id="Eye">
                  <path fill="none" d="M0 0h48v48H0z"></path>
                  <path d="M24 9C14 9 5.46 15.22 2 24c3.46 8.78 12 15 22 15 10.01 0 18.54-6.22 22-15-3.46-8.78-11.99-15-22-15zm0 25c-5.52 0-10-4.48-10-10s4.48-10 10-10 10 4.48 10 10-4.48 10-10 10zm0-16c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6z" fill="#ffb32f" class="color000000 svgShape"></path>
                </svg>
            </div>

        <?php endif; ?>

    </div>

    <div class="body">
<div class="meta">
    <?php
    $taxonomies = get_object_taxonomies( get_post_type( get_the_ID() ) );
    $term_links = [];

    if ( !empty($taxonomies) ) {
        foreach ( $taxonomies as $taxonomy ) {
            $terms = get_the_terms( get_the_ID(), $taxonomy );

            if ( !empty($terms) && !is_wp_error($terms) ) {
                foreach ( $terms as $term ) {
                    $term_links[] = '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';
                    if ( count($term_links) >= 3 ) break 2; // stop after 3 terms total
                }
            }
        }
    }

    if ( !empty($term_links) ) {
        echo '<span class="category">' . implode(', ', $term_links) . '</span>';
    }
    ?>
</div>



        <h3 class="post-title">
          <a href="<?php the_permalink(); ?>">
            <?php echo wp_trim_words(get_the_title(), 9, '...'); ?>
          </a>
        </h3>
        <div class="description"><?php echo $short_description; ?></div>
    </div>

</article>