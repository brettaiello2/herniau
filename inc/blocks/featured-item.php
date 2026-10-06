<?php
/**
 * Featured Item Block Template
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during backend preview render.
 * @param int    $post_id    The post ID the block is rendering on.
 */
$headline         = get_field( 'headline' );
$sub_line         = get_field( 'sub_line' );
$body_description = get_field( 'body_description' );
$featured_image   = get_field( 'featured_image' ); // return_format = url
$button_text      = get_field( 'button_text' );
$button_link      = get_field( 'button_link' );
$layout           = get_field( 'layout' ) ?: 'left'; // default to 'left'
$corner_banner    = get_field( 'corner_banner_text' );
$block_id   = 'featured-item-' . $block['id'];
$class_name = 'featured-item featured-item--' . esc_attr( $layout );
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
?>
<div id="<?php echo esc_attr( $block_id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">

			<?php if ( $corner_banner ) : ?>
					<span class="featured-item__corner-banner"><?php echo esc_html( $corner_banner ); ?></span>
				<?php endif; ?>

	<div class="featured-item__inner">
		<?php if ( $featured_image ) : ?>
			<div class="featured-item__media">
	
				<img
					src="<?php echo esc_url( $featured_image ); ?>"
					alt="<?php echo esc_attr( $headline ); ?>"
					class="featured-item__image"
					loading="lazy"
				/>
			</div>
		<?php endif; ?>
		<div class="featured-item__content">
			<?php if ( $sub_line ) : ?>
				<p class="featured-item__sub-line"><?php echo esc_html( $sub_line ); ?></p>
			<?php endif; ?>
			<?php if ( $headline ) : ?>
				<h2 class="featured-item__headline"><?php echo esc_html( $headline ); ?></h2>
			<?php endif; ?>
			<?php if ( $body_description ) : ?>
				<div class="featured-item__description">
					<?php echo wp_kses_post( $body_description ); ?>
				</div>
			<?php endif; ?>
			<?php if ( $button_text && $button_link ) : ?>
				<a href="<?php echo esc_url( $button_link ); ?>" class="featured-item__button">
					<?php echo esc_html( $button_text ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php
/**
 * Print the block styles once per page, no matter how many
 * Featured Item blocks are placed on it.
 */
if ( ! defined( 'HERNIAU_FEATURED_ITEM_STYLES_PRINTED' ) ) :
	define( 'HERNIAU_FEATURED_ITEM_STYLES_PRINTED', true );
	?>
	<style type="text/css">
.featured-item  {
    padding: 3em;
    background: #2b2d45;
    border-radius: 2em;
    margin-bottom: 4em;
    overflow: hidden;
    position: relative;
}
		.featured-item__inner {
			display: flex;
			flex-wrap: nowrap;
			align-items: center;
			gap: 4rem;
		}
		.featured-item__media,
		.featured-item__content {
			flex: 1 1 50%;
			min-width: 280px;
		}
		.featured-item__media {
			position: relative;
		}
		.featured-item__image {
			width: 100%;
			height: auto;
			display: block;
			border-radius: 20px;
			box-shadow: var( --box-shadow, 0 15px 15px -12px rgba(18, 67, 117, 0.35) );
		}
.featured-item__corner-banner {
    position: absolute;
    top: 30px;
    left: -43px;
    z-index: 2;
    background: var(--gold, #ffb32f);
    color: #000;
    padding: 6px 18px;
    border-radius: 4px;
    font-weight: 700;
    font-size: 0.85em;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.25);
    font-weight: 800;
    transform: rotate(-40deg);
    min-width: 200px;
    text-align: center;
}
		.featured-item__content {
			color: var( --type-color, #e4e9f2 );
		}
		.featured-item__sub-line {
			margin: 0 0 0.75rem;
			font-size: 0.85rem !important;
			font-weight: 700;
			letter-spacing: 0.08em;
			text-transform: uppercase;
			color: var( --gold, #ffb32f );
		}
		.featured-item__headline {
			margin: 0 0 1rem;
			font-size: clamp(1.6rem, 1.1rem + 2vw, 2.5rem);
			font-weight: 700;
			line-height: 1.15;
			color: var( --white, #fff );
		}
		.featured-item__description {
			font-size: 1.05rem;
			line-height: 1.7;
			color: var( --type-color, #e4e9f2 );
		}
		.featured-item__description p {
			margin: 0 0 1em;
		}
		.featured-item__description p:last-child {
			margin-bottom: 0;
		}
		.featured-item__button {
			display: inline-block;
			margin-top: 1.75rem;
			padding: 14px 32px;
			border-radius: 60px;
			background: var( --button-color, linear-gradient(90deg, rgba(255, 196, 88, 1) 0%, rgba(255, 159, 0, 1) 100%) );
			color: var( --primary, #110e22 );
			font-weight: 600;
			text-decoration: none;
			position: relative;
			top: 0;
			transition: all 0.3s;
		}
		.featured-item__button:hover {
			background: var( --button-hover, linear-gradient(90deg, rgb(255 214 139) 0%, rgb(255 175 43) 100%) );
			color: var( --primary, #110e22 );
			top: -2px;
		}
		/* Right layout: flip the visual order, image goes right */
		.featured-item--right .featured-item__inner {
			flex-direction: row-reverse;
		}
		@media (max-width: 767px) {
    .featured-item {
        padding: 1em;
    }
			.featured-item__inner {
				flex-direction: column;
				gap: 2rem;
			}
			.featured-item--right .featured-item__inner {
				flex-direction: column;
			}
		}
	</style>
<?php endif; ?>
