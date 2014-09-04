<?php

function gc_chant_variants_meta_box( $chant_variant ) { ?>

    <!--    Chant dropdown -->
    <?php
    wp_nonce_field( 'chant-variant-parent-action', 'chant_variant_parent_nonce' );

    $chant_variant_parent_id_int = 0 + $chant_variant->post_parent;
    ?>

    <div>
        <label for="chant-variant-parent"><b><?php _e( 'Chant', 'example' )?></b> - <?php _e( 'Select the chant to which this variant belongs. If the chant is not available, it must be created as a "Chant" post.', 'example' ); ?></label>
        <br>
        <select id="chant-variant-parent" name="chant-variant-parent">
            <option value=""></option>
            <!--            Fill with available chant posts. -->
            <?php
            $all_chants = get_posts( array( 'post_type' => 'gc_chant' ));

            foreach ($all_chants as $chant) { ?>
                <option value="<?= $chant->ID ?>" <?php if ( $chant_variant_parent_id_int === $chant->ID ) { ?>selected<?php } ?>><?= $chant->post_title ?></option>
            <?php } ?>

        </select>
        <p>Edit currently selected chant: <a href="<?= get_edit_post_link( $chant->ID ) ?>"><?= $chant->post_title ?></a></p>
    </div>

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

function gc_chant_variant_add_meta_boxes() {
    add_meta_box(
        'chant-variants-meta-box',
        esc_html__( 'Variants', 'example' ),
        'gc_chant_variants_meta_box',
        'gc_chant_variant',
        'normal',
        'default'
    );

    add_meta_box(
        'recordings-display-meta-box',
        esc_html__( 'Recordings', 'example' ),
        'gc_recordings_display_by_parent',
        'gc_chant_variant',
        'normal',
        'default'
    );
}

function save_chant_variant_meta( $post_id, $post ) {
    gc_save_post_parent($post_id, 'chant_variant_parent_nonce', 'chant-variant-parent', 'sanitize_text_field');
}