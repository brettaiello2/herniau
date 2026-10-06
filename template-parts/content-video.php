<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package herniau
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php $featured_image = get_the_post_thumbnail_url(null, 'full'); ?>

<input type="hidden" id="background-image" value="<?php echo esc_url($featured_image); ?>">

<div class="page-hero video-hero-container">
<div class="container">
<div class="breadcrumb-wrap right">
<?php echo do_shortcode('[breadcrumbs]'); ?>
</div>

<?php if ( is_user_logged_in() ): ?>

<div class="video-container">
  <video-js
      data-account="81909694001"
      data-player="rxDeY9XEJ"
      data-embed="default"
      controls
      data-video-id="<?php echo get_field('brightcove_id'); ?>"
      data-playlist-id=""
      data-application-id=""
      class="vjs-fluid">  
   </video-js>
</div>
<?php else: ?>
<div class="video-container">
<div class="blocked-video">
	<img src="/wp-content/uploads/2025/09/blocked-vid-2.jpg" />
	<div class="restricted-message">This content is restricted for non-members. Please <span class="login-modal-trigger" data-bs-toggle="modal" data-bs-target="#loginModal">login or register</span> to view</div>
</div>
</div>
<?php endif; ?>

    <div class="video-caption mb-5" style="display: none;">
    		<?php echo get_field("description"); ?>
    </div>

    <div class="video-meta mt-4">

    	<h1 class="wp-block-heading mb-2"><?php echo get_the_title(); ?></h1>

    	<?php if(get_field('description')): ?>
    	<div class="item">
    		<label>Case Description</label>
    		<div class="content"><?php echo get_field('description') ?></div>
    	</div>
    	<?php endif; ?>

			<?php if ( get_field('doctors') ): ?>
			  <div class="item">
			    <label>Doctors</label>
			    <div class="content">
			      <?php
			      $doctors = get_field('doctors'); 
			      $names   = [];

			      foreach ( $doctors as $doctor ) {
			          // $doctor is already a WP_Post object
			          $doctor_id = $doctor->ID;
			          $name      = $doctor->post_title; // ✅ use post_title
			          $link      = get_permalink($doctor_id);

			          if ( $name ) {
			              $names[] = sprintf(
			                  '<a href="%s">%s</a>',
			                  esc_url($link),
			                  esc_html($name)
			              );
			          }
			      }

			      echo implode(', ', $names);
			      ?>
			    </div>
			  </div>
			<?php endif; ?>


    	<?php if(get_field('products_used')): ?>
    	<div class="item">
    		<label>Products Used</label>
    		<div class="content"><?php echo get_field('products_used') ?></div>
    	</div>
    	<?php endif; ?>

    	<?php if(get_field('recorded_on')): ?>
     	<div class="item">
    		<label>Recorded</label>
    		<div class="content"><?php echo get_field('recorded_on') ?></div>
    	</div>   	   
    	<?php endif; ?> 	

		<?php if(get_field('duration')): ?>
		<div class="item">
		    <label>Video Duration</label>
		    <div class="content">
		        <?php echo format_video_duration(get_field('duration')); ?>
		    </div>
		</div>
		<?php endif; ?>	


			<?php
			$taxonomies = get_object_taxonomies( get_post_type(), 'objects' );

			foreach ( $taxonomies as $taxonomy_slug => $taxonomy ) {
			    // Skip built-in ones like 'post_format' if you don't want them
			    if ( in_array( $taxonomy_slug, array( 'post_format' ), true ) ) {
			        continue;
			    }

			    $terms = get_the_terms( get_the_ID(), $taxonomy_slug );

			    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>
			        <div class="item">
			          <label><?php echo esc_html( $taxonomy->labels->singular_name ); ?></label>
			          <div class="content">
			            <?php
			            $term_links = array();
			            foreach ( $terms as $term ) {
			                $term_links[] = sprintf(
			                    '<a href="%s">%s</a>',
			                    esc_url( get_term_link( $term ) ),
			                    esc_html( $term->name )
			                );
			            }
			            echo implode( ', ', $term_links );
			            ?>
			          </div>
			        </div>
			    <?php endif;
			}
			?>


    </div>

</div>
</div>


<div class="entry-content">
<div class="container">

<section class="content-carousel reco lm-cont-<?php echo $carousel_id; ?> <?php echo $addClass; ?>">
<h2 class="carousel-title">
        <img class="title-icon" src="/wp-content/uploads/2025/06/Star.png">                    
        You Might Also Like
</h2>

	<?php

	$post_type = get_post_type();
	$total_slides = 15;
	$slides_per_view = 5;
	$carousel_id = random_int(100000, 999999);

	$args = array(
	    'post_type'      => $post_type,
	    'posts_per_page' => $total_slides,
	    'post_status'    => 'publish',
	    'meta_query'     => array(
	        'relation' => 'OR',
	        array(
	            'key'     => 'recorded_on',
	            'compare' => 'EXISTS',
	        ),
	        array(
	            'key'     => 'recorded_on',
	            'compare' => 'NOT EXISTS',
	        ),
	    ),
	);

        $args['meta_key'] = 'recorded_on';
        $args['orderby']  = 'meta_value_num';
        $args['order']    = 'DESC'; 


	$carousel_query = new WP_Query($args); 

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

	<?php 

	while($carousel_query->have_posts()) : $carousel_query->the_post(); 

			include get_template_directory() . '/template-parts/content-item-general.php';

		
	 endwhile; 

	 ?>

	</div>
	</div>


  <script>
  	document.addEventListener('DOMContentLoaded', function(){ 
	    var swiper = new Swiper(".content-swiper-<?php echo $carousel_id; ?>", {
	      slidesPerView: 5,
	      spaceBetween: 30,
	      pagination: {
	        el: ".swiper-pagination",
	        clickable: true,
	      },

      breakpoints: {
        0: {
          slidesPerView: 1
        },
        520: {
          slidesPerView: 2
        },
        767: {
          slidesPerView: 3
        },
        1100: {
            slidesPerView: <?php echo $slides_per_view; ?>
        }
      }	      
	    });
    }, false);
  </script>

</section>

<?php wp_reset_postdata(); ?>

</div>
</div>

	
</article>
