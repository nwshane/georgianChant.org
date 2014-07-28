<?php

function setup_gc_recording_custom_columns() {
    add_filter ( 'manage_gc_recording_posts_columns', 'gc_recording_custom_column_headers', 10, 2 );
    add_action( 'manage_gc_recording_posts_custom_column', 'gc_recording_fill_custom_columns', 10, 2 );

    // Sorting columns
    add_filter( 'manage_edit-gc_recording_sortable_columns', 'gc_recording_sortable_columns' );
//    add_filter( 'posts_orderby', 'posts_orderby_set_column_order' );
    add_filter ( 'pre_get_posts', 'pre_get_posts_set_column_order' );
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
        echo $chant_variant_title;
    }

    if ( $column_name === 'chant' ) {
        $chant_title = get_post( $chant_id ) -> post_title;
        echo $chant_title;
    }
}

function gc_recording_sortable_columns( $sortable_columns ) {
    $sortable_columns[ 'chant_variant' ] = 'chant_variant';
    $sortable_columns[ 'chant' ] = 'chant';

    return $sortable_columns;
}

//function gc_recording_chant_variant_orderby( $orderby ) {
////    if ( isset( $vars[ 'orderby' ] ) && 'chant_variant' === $vars[ 'orderby' ] ) {
////        $vars = array_merge( $vars, array(
////            'meta_key' => 'parent',
////            'orderby' => 'meta_value'
////        ));
////    }
////
////    return $vars;
//
//    return "post_parent ASC, post_parent DESC";
//
//}

//function posts_orderby_set_column_order( $orderby ) {
//    print $orderby;
//
//    return $orderby;
//}



function pre_get_posts_set_column_order( $wp_query ) {
    if ( is_admin() ) {
        $post_type = $wp_query->query[ 'post_type' ];

        if ( $post_type === 'gc_recording' ) {
            if ( empty( $_GET[ 'orderby' ])) {
                $wp_query->set( 'orderby', 'title' );
                $wp_query->set( 'order', 'ASC' );
            }
        }
    }
}