<?php
/**
 * Plugin Name: GeorgianChant.org Custom Post Types
 * Description: Creates the GeorgianChant.org custom post types.
 * Author: Nathan Shane
 */

require_once(dirname(__FILE__) . '/chant-post-type/setup.php');
require_once(dirname(__FILE__) . '/chant-variant-post-type/setup.php');
require_once(dirname(__FILE__) . '/recording-post-type/setup.php');

/*
 * Sanitize text field but retain line breaks.
 * Identical to sanitize_text_field function in formatting.php, EXCEPT does not strip "\n" characters.
 */
function gc_sanitize_text_field_retain_line_breaks($str) {
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

function gc_verify_nonce( $nonce, $key ) {
    if ( !isset( $_POST[$nonce] ) || !wp_verify_nonce( $_POST[$nonce], $key . '-action' ) ) {
        return false;
    } else {
        return true;
    }
}

function gc_save_post_parent( $post_id, $nonce, $key, $sanitize ) {

    if ( !gc_verify_nonce( $nonce, $key )) {
        return $post_id;
    }

    $new_parent_id = ( isset( $_POST[$key] ) ? $sanitize($_POST[$key]) : '' );

    remove_action('save_post', 'gc_save_all_meta');

    wp_update_post ( array(
        'ID'            =>  $post_id,
        'post_parent'   =>  ($new_parent_id !== '' ) ? $new_parent_id : 0
    ));

    add_action('save_post', 'gc_save_all_meta');
}

/*
 * Save a single meta box's metadata.
 * Code copied and modified from http://www.smashingmagazine.com/2011/10/04/create-custom-post-meta-boxes-wordpress/
 */
function gc_save_single_meta( $post_id, $post, $meta_nonce, $meta_key, $sanitize ) {

    /* Verify the nonce before proceeding. */
    if ( !gc_verify_nonce( $meta_nonce, $meta_key ) ) {
        return $post_id;
    }

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

function gc_save_all_meta( $post_id, $post ) {

    $post_type = $post->post_type;

    if ( $post_type === "gc_chant" ) {
        gc_chant_save_meta( $post_id, $post );
    } else if ( $post_type === "gc_chant_variant" ) {
        save_chant_variant_meta( $post_id, $post );
    } else if ( $post_type === "gc_recording" ) {
        save_recordings_post_type_meta( $post_id, $post );
    }
}

function gc_setup_meta_boxes() {
    add_action( 'add_meta_boxes', 'gc_chant_add_meta_boxes' );
    add_action( 'add_meta_boxes', 'gc_chant_variant_add_meta_boxes' );
    add_action( 'add_meta_boxes', 'gc_recordings_add_meta_boxes' );
    add_action( 'save_post', 'gc_save_all_meta', 10, 2 );
}

add_action( 'load-post.php', 'gc_setup_meta_boxes' );
add_action( 'load-post-new.php', 'gc_setup_meta_boxes' );

function gc_echo_post_title( $post_id ) {
    $post_title = $post_id === 0 ? 'Unassigned' : get_post( $post_id ) -> post_title;

    if ( $post_title === 'Unassigned' ) {
        echo $post_title;
    } else {
        echo '<a href="' . get_edit_post_link($post_id) . '">' . $post_title . '</a>';
    }
}

function gc_enqueue_scripts() {
    gc_chant_enqueue_scripts();
    gc_recording_enqueue_scripts();
}

function gc_add_style() {
    wp_enqueue_style( 'my-admin-theme', plugins_url( 'gc-style.css', __FILE__ ));
}

add_action( 'admin_init', 'gc_enqueue_scripts' );
add_action( 'admin_enqueue_scripts', 'gc_add_style' );
