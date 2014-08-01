<?php

function gc_chant_variant_setup_columns() {
    add_filter ( 'manage_gc_chant_variant_posts_columns', 'gc_chant_variant_column_headers', 10, 2 );
    add_action( 'manage_gc_chant_variant_posts_custom_column', 'gc_chant_variant_fill_columns', 10, 2 );

}

function gc_chant_variant_column_headers( $columns ) {
    $columns[ 'chant' ] = 'Chant';

    return $columns;
}

function gc_chant_variant_fill_columns( $column_name, $post_id ) {
    $chant_id = get_post( $post_id ) -> post_parent;

    if ( $column_name === 'chant' ) {
        gc_echo_post_title( $chant_id );
    }
}