<?php

function recording_file_meta_box_callback() {

}

function recording_information_meta_box_callback( $recording ) { ?>

<?php wp_nonce_field( 'artist-name-action', 'artist_name_nonce' ) ?>

<div>
    <label for="artist-name"><b><?php _e( 'Artist', 'example' )?></b> - <?php _e( 'Enter the name of the artist who performs in this recording.', 'example' ); ?></label>
    <br>
    <input type="text" name="artist-name" id="artist-name" value="<?php echo esc_attr(get_post_meta( $recording->ID, 'artist-name', true ))?>">
</div>
<?php }

function gc_recordings_add_meta_boxes() {
    add_meta_box(
        'recording-file-meta-box',
        esc_html__( 'Recording File', 'example' ),
        'recording_file_meta_box_callback',
        'gc_recording',
        'normal',
        'default'
    );

    add_meta_box(
        'recording-information-meta-box',
        esc_html__( 'Recording Information', 'example' ),
        'recording_information_meta_box_callback',
        'gc_recording',
        'normal',
        'default'
    );
}

function save_recordings_post_type_meta( $post_id, $post ) {
    save_single_meta( $post_id, $post, 'artist_name_nonce', 'artist-name', 'sanitize_text_field' );
}