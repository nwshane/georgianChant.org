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

add_action( 'load-post.php', 'gc_chant_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'gc_chant_post_meta_boxes_setup' );

function gc_chant_post_meta_boxes_setup() {
    add_action( 'add_meta_boxes', 'gc_chant_add_post_meta_boxes' );
}

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

function georgian_text_meta_box_callback( $chant ) { ?>

    <?php wp_nonce_field( basename( __FILE__ ), 'georgian_text_meta_box_nonce' ) ?>

    <p>
        <label for="georgian-text-meta-box"><?php _e('Enter the text of the chant in Georgian.', 'example'); ?></label>
        <br>
        <input class="widefat" type="text" name="georgian-text-meta-box" id="georgian-text-meta-box" value="<?php echo esc_attr(get_post_meta( $chant->ID, 'georgian-text-meta-box', true))?>" size="30">
    </p>
<?php }
