<?php

// Get the additional CSS classes from Gutenberg block
if(array_key_exists('className', $block)) {
  $addClass = $block['className'];
} else {
  $addClass = "";
}

if( have_rows('accordion') ):

  $idrand = rand(1, 1000000);

	echo '<div class="hernia-accordion '.$addClass.'" id="accordion-'.$idrand.'">';
   
    while( have_rows('accordion') ) : the_row(); ?>

      <?php

      if(get_row_index() === 1 && get_field('open_first')) {
        $show = "show";
        $collapsed = null;
      } else {
        $show = null;
        $collapsed = "collapsed";
      }

      ?>

      <div class="accordion-item">

        <h3 class="accordion-header" id="heading-<?php echo $idrand; ?>-<?php echo get_row_index(); ?>">
          <button class="accordion-button <?php echo $collapsed; ?>" data-bs-toggle="collapse" data-bs-target="#collapse-<?php echo $idrand; ?>-<?php echo get_row_index(); ?>" aria-expanded="true" aria-controls="collapse-<?php echo $idrand; ?>-<?php echo get_row_index(); ?>">
           <?php echo get_sub_field("header"); ?>
          </button>
        </h3>

        <div id="collapse-<?php echo $idrand; ?>-<?php echo get_row_index(); ?>" class="accordion-collapse collapse <?php echo $show; ?>" aria-labelledby="heading-<?php echo $idrand; ?>-<?php echo get_row_index(); ?>" data-bs-parent="#accordion-<?php echo $idrand; ?>">
          <div class="accordion-body">
           <?php echo get_sub_field("content"); ?>
          </div>
        </div>

      </div>
        

<?php

    endwhile;

      echo "</div>";

endif;

?>



<?php if(get_field("schema") != null || get_field("schema") != 0): ?>

<!-- FAQPAGE SCHEMA -->
  <?php 
  $rows = count(get_field('accordion'));
  if (have_rows('accordion')):
  ?>
    <script type="application/ld+json">
    
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        <?php 
        while (have_rows('accordion')):
        $count = get_row_index() + 1;
        the_row();
        $question = strip_tags(get_sub_field( 'header' ));
        $answer = strip_tags(get_sub_field( 'content' ));
        ?>
          {
            "@type": "Question",
            "name": "<?php echo $question; ?>",
            "acceptedAnswer": {
            "@type": "Answer",
            "text": "<?php echo $answer; ?>"
            }
          }<?php if($rows != $count): ?>,<?php endif; ?>
        <?php endwhile; ?>
      ]
    }
    </script>

<?php endif; ?>

  <?php endif; ?>


