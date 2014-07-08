<?php
/**
 * Plugin Name: Chant Custom Post Type
 * Description: Creates the chant custom post type and the associated chant variant custom post type
 * Author: Nathan Shane
 */

require_once(dirname(__FILE__) . '/php/chant-post-type-setup.php');
require_once(dirname(__FILE__) . '/php/chant-variant-post-type-setup.php');
require_once(dirname(__FILE__) . '/php/recordings-post-type-setup.php');

/*
 * Sanitize text field but retain line breaks.
 * Identical to sanitize_text_field function in formatting.php, EXCEPT does not strip "\n" characters.
 */
function sanitize_text_field_retain_line_breaks($str) {
    $filtered = wp_check_invalid_utf8( $str );

    if ( strpos($filtered, '<') !== false ) {
        $filtered = wp_pre_kses_less_than( $filtered );
        // This will strip extra whitespace for us.
        $filtered = wp_strip_all_tags( $filtered, true );
    } else {
        $filtered = trim( preg_replace('/[\r\t ]+/', ' ', $filtered) );
    }

    $found = false;
    while ( preg_match('/%[a-f0-9]{2}/i', $filtered, $match) ) {
        $filtered = str_replace($match[0], '', $filtered);
        $found = true;
    }

    if ( $found ) {
        // Strip out the whitespace that may now exist after removing the octets.
        $filtered = trim( preg_replace('/ +/', ' ', $filtered) );
    }

    return apply_filters( 'sanitize_text_field', $filtered, $str );
}

/*
 * Save a single meta box's metadata.
 * Code copied and modified from http://www.smashingmagazine.com/2011/10/04/create-custom-post-meta-boxes-wordpress/
 */
function save_single_meta( $post_id, $post, $meta_nonce, $meta_key, $sanitize ) {

    /* Verify the nonce before proceeding. */
    if ( !isset( $_POST[$meta_nonce] ) || !wp_verify_nonce( $_POST[$meta_nonce], $meta_key . '-action' ) ) {
        print 'Sorry, your nonce did not verify for the meta key ' . $meta_key . '.';
        exit;
    } else {
        /* Get the post type object. */
        $post_type = get_post_type_object( $post->post_type );

        /* Check if the current user has permission to edit the post. */
        if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
            return $post_id;

        /* Get the posted data and sanitize it for use as an HTML class. */
        $new_meta_value = ( isset( $_POST[$meta_key] ) ? $sanitize($_POST[$meta_key]) : '' );

        /* Get the meta value of the custom field key. */
        $meta_value = get_post_meta( $post_id, $meta_key, true );

        /* If a new meta value was added and there was no previous value, add it. */
        if ( $new_meta_value && '' == $meta_value )
            add_post_meta( $post_id, $meta_key, $new_meta_value, true );

        /* If the new meta value does not match the old value, update it. */
        elseif ( $new_meta_value && $new_meta_value != $meta_value )
            update_post_meta( $post_id, $meta_key, $new_meta_value );

        /* If there is no new meta value but an old value exists, delete it. */
        elseif ( '' == $new_meta_value && $meta_value )
            delete_post_meta( $post_id, $meta_key, $meta_value );
    }
}

function save_all_meta( $post_id, $post ) {

    $post_type = $post->post_type;

    if ( $post_type === "gc_chant" ) {
        save_chant_post_type_meta( $post_id, $post );
    } else if ( $post_type === "gc_chant_variant" ) {
        save_chant_variant_post_type_meta( $post_id, $post );
    } else if ( $post_type === "gc_recordings" ) {
        save_recordings_post_type_meta( $post_id, $post );
    }
}

function setup_meta_boxes() {
    add_action( 'add_meta_boxes', 'gc_chant_add_meta_boxes' );
    add_action( 'add_meta_boxes', 'gc_chant_variant_add_meta_boxes' );
    add_action( 'add_meta_boxes', 'gc_recordings_add_meta_boxes' );
    add_action( 'save_post', 'save_all_meta', 10, 2 );
}

add_action( 'load-post.php', 'setup_meta_boxes' );
add_action( 'load-post-new.php', 'setup_meta_boxes' );
