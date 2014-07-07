<?php

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
}

add_action('init', 'setup_gc_chant_variant');

function chant_variants_meta_box_callback( $chant_variant ) { ?>

    <p>If the chant variant comes out of the oral tradition.........</p>

    <?php
    wp_nonce_field( basename( __FILE__ ), 'monastery_tradition_nonce' );
    $monastery_tradition = esc_attr(get_post_meta( $chant_variant->ID, 'monastery-tradition', true));
    ?>

    <div>
        <label for="monastery-tradition"><b><?php _e( 'Monastery Tradition', 'example' )?></b> - <?php _e( 'Enter the monastery tradition of the chant.', 'example' ); ?></label>
        <br>
        <select id="monastery-tradition" name="monastery-tradition">
            <option value></option>

            <?php
            $possible_monastery_traditions = [ "Gelati", "Shemokmedi", "East Georgia" ];
            foreach ( $possible_monastery_traditions as $possible_monastery_tradition ) { ?>
                <option value="<?php echo $possible_monastery_tradition; ?>" <?php if ( $monastery_tradition === $possible_monastery_tradition ) { ?>selected<?php } ?>><?php echo $possible_monastery_tradition; ?></option>
            <?php } ?>

        </select>
    </div>

<?php }

function gc_chant_variant_add_post_meta_boxes() {
    add_meta_box(
        'chant-variants-meta-box',
        esc_html__( 'Variants', 'example' ),
        'chant_variants_meta_box_callback',
        'gc_chant_variant',
        'normal',
        'default'
    );
}

function setup_gc_chant_variant_meta_boxes() {
    add_action( 'add_meta_boxes', 'gc_chant_variant_add_post_meta_boxes' );
}

add_action( 'load-post.php', 'setup_gc_chant_variant_meta_boxes' );
add_action( 'load-post-new.php', 'setup_gc_chant_variant_meta_boxes' );

