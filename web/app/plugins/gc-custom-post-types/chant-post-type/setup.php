<?php

require_once(dirname(__FILE__) . '/meta.php');
require_once(dirname(__FILE__) . '/dropdown.php');

function gc_chant_setup() {
    $labels = array(
        'name'                  => _x( 'Chants', 'post type general name'),
        'singular_name'         => _x( 'Chant', 'post type singular name'),
        'add_new'               => _x( 'Add New', 'book'),
        'add_new_item'          => __( 'Add New Chant' ),
        'edit_item'             => __( 'Edit Chant'),
        'new_item'              => __( 'New Chant' ),
        'all_items'             => __( 'All Chants' ),
        'view_item'             => __( 'View Chant' ),
        'search_items'          => __( 'Search Chants' ),
        'not_found'             => __( 'No chants found' ),
        'not_found_in_trash'    => __( 'No chants found in the trash' ),
        'parent_item_colon'     => '',
        'menu_name'             => 'Chants'
    );

    $args = array(
        'label'         => 'Chants',
        'labels'        => $labels,
        'description'   => 'The information associated with an individual chant.',
        'public'        => true,
        'menu_position' => 5,
        'supports'      => array('title'),
        'has_archive'   => true
    );

    register_post_type("gc_chant", $args);
}

function gc_chant_enqueue_scripts() {
    wp_enqueue_script( 'georgian-latin-transliterator', plugins_url( '/gc-custom-post-types/chant-post-type/georgian-latin-transliterator.js' ), array( 'jquery' ), false, true );
}

add_action('init', 'gc_chant_setup');