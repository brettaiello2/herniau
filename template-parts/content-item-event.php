<article <?php post_class("event-card swiper-slide content-item"); ?> id="post-<?php the_ID(); ?>">

        <?php 
	    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
        $description = get_post_field('post_excerpt', get_the_ID());
		$event_date = get_post_meta(get_the_ID(), '_event_start_date', true);
		$event_time = get_post_meta(get_the_ID(), '_event_start_time', true);

		$event_datetime_string = $event_date . ' ' . $event_time;
		$timestamp = strtotime($event_datetime_string);

		$formatted_date_time = date('F j, Y \a\t g:i A', $timestamp);
        ?>

    <div class="thumb">
        <a href="<?php the_permalink(); ?>">
            <img src="<?php echo esc_url($image_url); ?>" />
        </a>
    </div>

    <div class="body">
        <div class="meta">
            <span class="category"><?php echo get_primary_term_html( get_the_ID() ); ?></span>
        </div>
        <h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <div class="date mb-2" style="font-style: italic;color:var(--gold);">
        	<?php echo $formatted_date_time; ?>
        </div>
        
        <div class="description"><?php echo $description; ?></div>
    </div>

</article>