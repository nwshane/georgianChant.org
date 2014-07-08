<?php

require_once(dirname(__FILE__) . '/meta.php');

function setup_gc_recordings() {
    $labels = array(
        'name'                  => _x( 'Recordings', 'post type general name'),
        'singular_name'         => _x( 'Recording', 'post type singular name'),
        'add_new'               => _x( 'Add New', 'book'),
        'add_new_item'          => __( 'Add New Recording' ),
        'edit_item'             => __( 'Edit Recording'),
        'new_item'              => __( 'New Recording' ),
        'all_items'             => __( 'All Recordings' ),
        'view_item'             => __( 'View Recording' ),
        'search_items'          => __( 'Search Recordings' ),
        'not_found'             => __( 'No recordings found' ),
        'not_found_in_trash'    => __( 'No recordings found in the trash' ),
        'parent_item_colon'     => '',
        'menu_name'             => 'Recordings'
    );

    $args = array(
        'label'         => 'Recordings',
        'labels'        => $labels,
        'description'   => 'A chant recording and its associated information.',
        'public'        => true,
        'menu_position' => 5,
        'supports'      => array('title'),
        'has_archive'   => true
    );

    register_post_type("gc_recordings", $args);
}

add_action('init', 'setup_gc_recordings');