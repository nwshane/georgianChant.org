<?php

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

function gc_chant_variant_add_meta_boxes() {
    add_meta_box(
        'chant-variants-meta-box',
        esc_html__( 'Variants', 'example' ),
        'chant_variants_meta_box_callback',
        'gc_chant_variant',
        'normal',
        'default'
    );
}

function save_chant_variant_post_type_meta( $post_id, $post ) {

}