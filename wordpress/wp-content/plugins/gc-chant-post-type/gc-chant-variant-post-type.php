<?php

function setup_gc_chant_variant() {
    $labels = array(
        'name'                  => _x( 'Chant Variants', 'post type general name'),
        'singular_name'         => _x( 'Chant Variant', 'post type singular name'),
    );

    $args = array(
        'label'         => 'Chant Variants',
        'labels'        => $labels,
        'description'   => 'The information associated with an individual chant variant.',
        'public'        => true,
        'supports'      => false,
        'has_archive'   => true
    );

    register_post_type("gc_chant_variant", $args);
}

add_action('init', 'setup_gc_chant_variant');