<?php
// Get additional CSS classes from Gutenberg block
$addClass = isset($block['className']) ? $block['className'] : "";

// Check if slides exist
if (have_rows('hero_carousel')):

  $idrand = rand(1, 1000000);
  $carousel_id = 'carousel-' . $idrand;
  ?>

  <div class="hero-carousel swiper <?php echo esc_attr($addClass); ?>" id="<?php echo esc_attr($carousel_id); ?>">
    <div class="swiper-wrapper">

      <?php while (have_rows('hero_carousel')): the_row();
        $background_image = get_sub_field("background_image");
        $pre_header       = get_sub_field("pre_header");
        $main_title       = get_sub_field("main_title");
        $button_label     = get_sub_field("button_label");
        $button_link      = get_sub_field("button_link");
        $description      = get_sub_field("description");
      ?>

        <div class="swiper-slide hero-carousel-slide" 
             style="background-image:url('<?php echo esc_url($background_image['url']); ?>');">

          <div class="slide-content container">
            <?php if ($pre_header): ?>
              <p class="pre-header"><?php echo $pre_header; ?></p>
            <?php endif; ?>

            <?php if ($main_title): ?>
              <h2 class="main-title"><?php echo esc_html($main_title); ?></h2>
            <?php endif; ?>

            <?php if ($description): ?>
              <div class="description"><?php echo wp_kses_post($description); ?></div>
            <?php endif; ?>

            <?php if ($button_label && $button_link): ?>
              <div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($button_label); ?></a></div>

            <?php endif; ?>
          </div>
        </div>

      <?php endwhile; ?>

    </div>

    <!-- Swiper Controls -->
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      new Swiper("#<?php echo esc_js($carousel_id); ?>", {
        loop: true,
        autoplay: {
          delay: 5000,
          disableOnInteraction: true,
        },
        pagination: {
          el: "#<?php echo esc_js($carousel_id); ?> .swiper-pagination",
          clickable: true,
        },
        navigation: {
          nextEl: "#<?php echo esc_js($carousel_id); ?> .swiper-button-next",
          prevEl: "#<?php echo esc_js($carousel_id); ?> .swiper-button-prev",
        },
        slidesPerView: 1,
        effect: "fade",
        speed: 800,
      });
    });
  </script>

<?php endif; ?>




