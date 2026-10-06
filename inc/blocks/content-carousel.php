<?php
$title = get_field("carousel_title");
$section_link = get_field("section_link");
$total_slides = get_field("total_slides");
$slides_per_view = get_field("slides_per_view");
$carousel_id = random_int(100000, 999999);
$sort_by = get_field("sort_by");
$manual_selection = get_field("manual_selection");


// Check for different post types
if(get_field("post_type")) {
	$post_type = get_field("post_type");
} else {
	$post_type = "post";
}
?>

<!-- Get the additional CSS classes from Gutenberg block -->
<?php 
if(array_key_exists('className', $block)) {
	$addClass = $block['className'];
} else {
	$addClass = "";
}
?>


<section class="content-carousel lm-cont-<?php echo $carousel_id; ?> <?php echo $addClass; ?>">

<?php

$args = array(
    'post_status' => 'publish',
);

// Override everything if manual selection exists
if ( ! empty( $manual_selection ) ) {
    $args['post__in']       = $manual_selection;  
    $args['orderby']        = 'post__in';        
    $args['posts_per_page'] = -1;                
    $args['post_type'] = 'any';
} else {

    // Normal query logic when no manual selection exists
    $args['post_type']      = $post_type;
    $args['posts_per_page'] = $total_slides;


    switch ( $sort_by ) {
        case 'published_date':
            $args['orderby'] = 'date';
            $args['order']   = 'DESC';
            break;
		case 'recorded_on':
		    $args['meta_key'] = 'recorded_on';
		    $args['orderby']  = 'meta_value_num'; // stored as Ymd
		    $args['order']    = 'DESC'; // newest → oldest
		    break;
        case 'menu_order':
        default:
            $args['orderby'] = 'menu_order';
            $args['order']   = 'ASC';
            break;
    }

// Event-specific logic
if ( $post_type == "event" ) {
    // Subtract 1 day (24 hours) from the current time
    $buffer_date = date( 'Y-m-d', strtotime( '-1 day' ) );

    $args['meta_query'] = array(
        array(
            'key'     => '_event_start_date',
            'value'   => $buffer_date, // Now compares against yesterday
            'compare' => '>=',
            'type'    => 'DATE',
        ),
    );
    $args['meta_key'] = '_event_start_date';
    $args['orderby']  = 'meta_value';
    $args['order']    = 'ASC';
}

}

$carousel_query = new WP_Query( $args );

?>


	<div class="swiper content-swiper-<?php echo $carousel_id; ?>">

<?php 
$title_icon ="";
if(get_field("title_icon")) {
	$title_icon = "<img class='title-icon' src='".get_field("title_icon")."'/>";
}
?>

<?php if ($title): ?>
    <h2 class="carousel-title">
        <?php echo $title_icon; ?>
        <?php if ($section_link): ?>
            <a href="<?php echo esc_url($section_link); ?>"><?php echo esc_html($title); ?></a>
        <?php else: ?>
            <?php echo esc_html($title); ?>
        <?php endif; ?>
    </h2>
<?php endif; ?>


	<div class="swiper-pagination"></div>
    <div class="swiper-wrapper">

<?php if ( $carousel_query->have_posts() ) : ?>

    <?php while ( $carousel_query->have_posts() ) : $carousel_query->the_post(); ?>

        <?php
        if ( $post_type == "event" ) {
            include get_template_directory() . '/template-parts/content-item-event.php';
        } else {
            include get_template_directory() . '/template-parts/content-item-general.php';
        }
        ?>

    <?php endwhile; ?>

<?php else : ?>

    <div class="no-results">No <?php echo esc_html($post_type); ?> items found.</div>

<?php endif; ?>


	</div>



	</div>

<div class="swiper-button-prev-<?php echo $carousel_id; ?> h-swiper-btn h-swiper-btn-prev"></div>
<div class="swiper-button-next-<?php echo $carousel_id; ?> h-swiper-btn h-swiper-btn-next"></div>


<script>
	document.addEventListener('DOMContentLoaded', function() {
		var swiper = new Swiper(".content-swiper-<?php echo $carousel_id; ?>", {
			slidesPerView: 5,
			spaceBetween: 30,
			loop:true,
			pagination: {
				el: ".swiper-pagination",
				clickable: true,
			},
			navigation: {
				nextEl: ".swiper-button-next-<?php echo $carousel_id; ?>",
				prevEl: ".swiper-button-prev-<?php echo $carousel_id; ?>",
			},
			breakpoints: {
				0: { slidesPerView: 1 },
				520: { slidesPerView: 2 },
				767: { slidesPerView: 3 },
				1100: { slidesPerView: <?php echo intval($slides_per_view) ?: 4; ?> }
			}
		});
	});
</script>

</section>

<?php wp_reset_postdata(); ?>