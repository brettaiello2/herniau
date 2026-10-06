<section class="instructor-cards">

<?php

if( have_rows('card_item') ):

    while( have_rows('card_item') ) : the_row();

    	$instructor_id = get_sub_field('instructor');
    	$role = get_sub_field('role');
        $name = get_the_title($instructor_id);
        $intro = get_field('short_bio',$instructor_id);
        $intro_trimmed = wp_trim_words( wp_strip_all_tags($intro), 20, '...' );
        $headshot = get_field('photo',$instructor_id);
        
        ?>


        <div class="instructor-card">

        	<div class="headshot">
                <?php if($headshot): ?>
        		<img src="<?php echo $headshot['sizes']['medium']; ?>" alt="<?php echo esc_attr($name); ?>" />
                <?php else: ?>
                <img src="/wp-content/uploads/2025/08/Coming-Soon-HU.png" />
                <?php endif; ?>
        	</div>

        	<div class="role">
        		<?php echo $role; ?>
        	</div>

            <div class="name">
                <?php 
                    echo $name; 
                    if (get_field("med_credentials",$instructor_id)) {
                        echo " " . get_field("med_credentials",$instructor_id);
                    }
                ?>
            </div>


        	<div class="bio">
        		<?php echo $intro_trimmed; ?>
        	</div>

        	<div class="actions">
        		<a href="<?php echo get_permalink( $instructor_id ); ?>" class="wp-block-button__link wp-element-button">Read More</a>
        	</div>

        </div>


        <?php


    endwhile;

endif;

?>

</section>