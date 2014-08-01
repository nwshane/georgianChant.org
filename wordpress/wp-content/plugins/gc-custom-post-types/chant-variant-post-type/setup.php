<?php

require_once(dirname(__FILE__) . '/meta.php');
require_once(dirname(__FILE__) . '/columns.php');

function setup_gc_chant_variant() {
    $labels = array(
        'name'                  => _x( 'Chant Variants', 'post type general name'),
        'singular_name'         => _x( 'Chant Variant', 'post type singular name'),
        'add_new'               => _x( 'Add New', 'book'),
        'add_new_item'          => __( 'Add New Chant Variant' ),
        'edit_item'             => __( 'Edit Chant Variant'),
        'new_item'              => __( 'New Chant Variant' ),
        'all_items'             => __( 'All Chant Variants' ),
        'view_item'             => __( 'View Chant Variant' ),
        'search_items'          => __( 'Search Chant Variants' ),
        'not_found'             => __( 'No chant variants found' ),
        'not_found_in_trash'    => __( 'No chant variants found in the trash' ),
        'parent_item_colon'     => '',
        'menu_name'             => 'Chant Variants'
    );

    $args = array(
        'label'         => 'Chant Variants',
        'labels'        => $labels,
        'description'   => 'The information associated with an individual chant variant.',
        'public'        => true,
        'hierarchical'  => true,
        'supports'      => array( 'title' ),
        'has_archive'   => true
    );

    register_post_type("gc_chant_variant", $args);
    setup_gc_chant_variant_columns();

}

add_action('init', 'setup_gc_chant_variant');
