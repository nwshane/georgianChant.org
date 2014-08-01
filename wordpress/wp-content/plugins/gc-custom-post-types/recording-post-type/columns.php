<?php

function setup_gc_recording_custom_columns() {
    add_filter ( 'manage_gc_recording_posts_columns', 'gc_recording_custom_column_headers', 10, 2 );
    add_action( 'manage_gc_recording_posts_custom_column', 'gc_recording_fill_custom_columns', 10, 2 );
}

function gc_recording_custom_column_headers( $columns ) {
    $columns[ 'chant_variant' ] = 'Chant Variant';
    $columns[ 'chant' ] = 'Chant';

    return $columns;
}

function gc_recording_fill_custom_columns( $column_name, $post_id ) {
    $chant_variant_id = get_post( $post_id ) -> post_parent;
    $chant_id = get_post( $chant_variant_id ) -> post_parent;

    if ( $column_name === 'chant_variant' ) {
        $chant_variant_title = get_post( $chant_variant_id ) -> post_title;
        echo '<a href="' . get_edit_post_link($chant_variant_id) . '">' . $chant_variant_title . '</a>';
    }

    if ( $column_name === 'chant' ) {
        $chant_title = get_post( $chant_id ) -> post_title;
        echo '<a href="' . get_edit_post_link($chant_id) . '">' . $chant_title . '</a>';
    }
}