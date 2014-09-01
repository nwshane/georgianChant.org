<?php

function gc_recording_setup_columns() {
    add_filter ( 'manage_gc_recording_posts_columns', 'gc_recording_column_headers', 10, 2 );
    add_action( 'manage_gc_recording_posts_custom_column', 'gc_recording_fill_columns', 10, 2 );
}

function gc_recording_column_headers( $columns ) {
    $columns[ 'chant_variant' ] = 'Chant Variant';
    $columns[ 'chant' ] = 'Chant';

    return $columns;
}

function gc_recording_fill_columns( $column_name, $post_id ) {
    $chant_variant_id = get_post( $post_id ) -> post_parent;
    $chant_id = get_post( $chant_variant_id ) -> post_parent;

    if ( $column_name === 'chant_variant' ) {
        gc_echo_post_title( $chant_variant_id );
    } else if ( $column_name === 'chant' ) {
        gc_echo_post_title( $chant_id );
    }
}