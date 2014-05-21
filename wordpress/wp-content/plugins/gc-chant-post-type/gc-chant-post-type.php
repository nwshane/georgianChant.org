<?php
/**
 * Plugin Name: Chant Custom Post Type
 * Description: Creates the chant custom post type
 * Author: Nathan Shane
 */

/**
 * Adds custom_post_type chant
 */
function my_custom_post_chant() {
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
        'labels'        => $labels,
        'description'   => 'All the information associated with an individual chant.',
        'public'        => true,
        'menu_position' => 5,
        'supports'      => array('title', 'editor', 'thumbnail', 'excerpt'),
        'has_archive'   => true
    );
    register_post_type("gc_chant", $args);
}

add_action('init', 'my_custom_post_chant');




/**
 * Adds meta boxes
 */

function georgian_text_meta_box_callback( $chant ) { ?>

    <?php wp_nonce_field( basename( __FILE__ ), 'georgian_text_meta_box_nonce' ) ?>

    <p>
        <label for="georgian-text-meta-box"><?php _e('Enter the text of the chant in Georgian.', 'example'); ?></label>
        <br>
        <input class="widefat" type="text" name="georgian-text-meta-box" id="georgian-text-meta-box" value="<?php echo esc_attr(get_post_meta( $chant->ID, 'georgian-text-meta-box', true))?>" size="30">
    </p>
<?php }

function gc_chant_add_post_meta_boxes() {
    add_meta_box(
        'georgian-text-meta-box',
        esc_html__( 'Georgian Text', 'example' ),
        'georgian_text_meta_box_callback',
        'gc_chant',
        'side',
        'default'
    );
}

/*
 * Save the meta box's post metadata.
 * Code copied and modified from http://www.smashingmagazine.com/2011/10/04/create-custom-post-meta-boxes-wordpress/
 */
function gc_chant_save_post_meta( $post_id, $post ) {

    /* Verify the nonce before proceeding. */
    if ( !isset( $_POST['georgian_text_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['georgian_text_meta_box_nonce'], basename( __FILE__ ) ) )
        return $post_id;

    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );

    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

    /* Get the posted data and sanitize it for use as an HTML class. */
    $new_meta_value = ( isset( $_POST['georgian-text-meta-box'] ) ? sanitize_text_field( $_POST['georgian-text-meta-box'] ) : '' );

    /* Get the meta key. */
    $meta_key = 'georgian-text-meta-box';

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

/**
 * Sets up meta boxes
 */
function gc_chant_post_meta_boxes_setup() {
    add_action( 'add_meta_boxes', 'gc_chant_add_post_meta_boxes' );

    add_action( 'save_post', 'gc_chant_save_post_meta', 10, 2);
}

add_action( 'load-post.php', 'gc_chant_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'gc_chant_post_meta_boxes_setup' );