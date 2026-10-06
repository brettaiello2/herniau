<?php
$button_type = get_field("type");
$button_text = get_field("button_text");
$button_link = get_field("button_link");
?>

<?php if ( $button_type === "default" ) : ?>

    <div class="wp-block-button" style="display:inline-block;">
        <a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $button_link ); ?>">
            <?php echo esc_html( $button_text ); ?>
        </a>
    </div>

<?php elseif ( $button_type === "add-to-calendar" ) : ?>

    <?php
    global $EM_Event;

    // ACF block editor preview
    if ( ! empty( $is_preview ) ) : ?>

        <div class="wp-block-button" style="display:inline-block; opacity:0.6;">
            <a class="wp-block-button__link wp-element-button btn btn-secondary" href="#">
                <img src="/wp-content/uploads/2025/07/cal.png" alt="" />
                <?php echo esc_html( $button_text ); ?>
            </a>
        </div>

    <?php
    // Frontend – real dynamic Events Manager button
    elseif ( $EM_Event instanceof EM_Event ) :

        $format = '
            <div class="wp-block-button" style="display:inline-block;">
                <a href="#_EVENTICALURL" target="_blank" class="wp-block-button__link wp-element-button btn btn-secondary">
                    <img src="/wp-content/uploads/2025/07/cal.png" alt="" />
                    ' . esc_html( $button_text ) . '
                </a>
            </div>
        ';

        echo $EM_Event->output( $format, "html" );

    // Optional: fallback if no event context
    else : ?>

        <div class="wp-block-button" style="display:inline-block; opacity:0.6;">
            <a class="wp-block-button__link wp-element-button btn btn-secondary" href="#">
                <?php echo esc_html( $button_text ); ?>
            </a>
        </div>

    <?php endif; ?>

<?php endif; ?>
