<?php
function herniau_breadcrumbs() {
    global $post;

    $cpt_page_map = [
        'lecture'    => '/lectures/',
        'video'      => '/videos/',
        'instructor' => '/instructors/',
    ];

    $separator = ' &gt; ';
    $parts = [];
    $parts[] = '<a href="' . esc_url( home_url( '/' ) ) . '">Home</a>';

    $get_cpt_list_url = function( $cpt_slug ) use ( $cpt_page_map ) {
        if ( $link = get_post_type_archive_link( $cpt_slug ) ) {
            return $link;
        }
        if ( isset( $cpt_page_map[ $cpt_slug ] ) ) {
            return home_url( $cpt_page_map[ $cpt_slug ] );
        }
        foreach ( [ $cpt_slug, $cpt_slug . 's' ] as $try ) {
            if ( $page = get_page_by_path( trim( $try, '/' ) ) ) {
                return get_permalink( $page );
            }
        }
        return '';
    };

    if ( is_page() ) {
        if ( $post && $post->post_parent ) {
            $parent_id = (int) $post->post_parent;
            $parts[] = '<a href="' . esc_url( get_permalink( $parent_id ) ) . '">' . esc_html( get_the_title( $parent_id ) ) . '</a>';
        }
        $parts[] = esc_html( get_the_title( $post ) );
        return '<nav class="breadcrumbs">' . implode( $separator, $parts ) . '</nav>';
    }

    if ( is_singular() ) {
        $pt = get_post_type( $post );
        if ( $pt && $pt !== 'page' ) {
            $obj   = get_post_type_object( $pt );
            $label = $obj ? $obj->labels->name : ucwords( str_replace( ['-', '_'], ' ', $pt ) );
            $url   = $get_cpt_list_url( $pt );

            if ( $url ) {
                $parts[] = '<a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
            } else {
                $parts[] = esc_html( $label );
            }
        }
        $parts[] = esc_html( get_the_title( $post ) );
        return '<nav class="breadcrumbs">' . implode( $separator, $parts ) . '</nav>';
    }

    if ( is_tax() ) {
        $term = get_queried_object();
        if ( $term && ! is_wp_error( $term ) ) {
            $tax_obj  = get_taxonomy( $term->taxonomy );
            $cpt_slug = '';
            if ( $tax_obj && ! empty( $tax_obj->object_type ) ) {
                $cpt_slug = is_array( $tax_obj->object_type ) ? reset( $tax_obj->object_type ) : $tax_obj->object_type;
            }
            if ( $cpt_slug ) {
                $cpt_obj   = get_post_type_object( $cpt_slug );
                $cpt_label = $cpt_obj ? $cpt_obj->labels->name : ucwords( str_replace( ['-', '_'], ' ', $cpt_slug ) );
                $cpt_url   = $get_cpt_list_url( $cpt_slug );

                if ( $cpt_url ) {
                    $parts[] = '<a href="' . esc_url( $cpt_url ) . '">' . esc_html( $cpt_label ) . '</a>';
                } else {
                    $parts[] = esc_html( $cpt_label );
                }
            }

            if ( $term->parent ) {
                $parents = [];
                $pid = (int) $term->parent;
                while ( $pid ) {
                    $p = get_term( $pid, $term->taxonomy );
                    if ( ! $p || is_wp_error( $p ) ) break;
                    $parents[] = '<a href="' . esc_url( get_term_link( $p ) ) . '">' . esc_html( $p->name ) . '</a>';
                    $pid = (int) $p->parent;
                }
                if ( $parents ) {
                    $parts = array_merge( $parts, array_reverse( $parents ) );
                }
            }

            $parts[] = esc_html( $term->name );
        }
        return '<nav class="breadcrumbs">' . implode( $separator, $parts ) . '</nav>';
    }

    if ( is_post_type_archive() ) {
        $pt = get_query_var( 'post_type' );
        if ( $pt ) {
            $obj = get_post_type_object( $pt );
            $parts[] = esc_html( $obj ? $obj->labels->name : ucwords( $pt ) );
        }
        return '<nav class="breadcrumbs">' . implode( $separator, $parts ) . '</nav>';
    }

    // Default: just Home
    return '<nav class="breadcrumbs">' . implode( $separator, $parts ) . '</nav>';
}
add_shortcode( 'breadcrumbs', 'herniau_breadcrumbs' );
