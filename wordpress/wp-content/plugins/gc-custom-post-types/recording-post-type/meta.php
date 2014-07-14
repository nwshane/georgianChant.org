<?php

function recording_file_meta_box_callback( $recording ) { ?>

    <?php
    wp_nonce_field( 'recording-file-action', 'recording_file_nonce' );
    $recording_file = esc_attr(get_post_meta( $recording->ID, 'recording-file', true));
    ?>

    <input type="file" id="recording-file" name="recording-file">
    <br>
    <audio controls>
<!--        <source src="--><?//=$recording_file?><!--" type="audio/ogg">-->
<!--        <source src="--><?//=$recording_file?><!--" type="audio/mpeg">-->
<!--        <source src="--><?//=$recording_file?><!--" type="audio/m4a">-->
        <source src="<?php echo dirname(__FILE__) . '/01KristeAghsdga.mp3' ?>" type="audio/mp3">
        Your browser does not support the audio element.
    </audio>

<?php }

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
    save_single_meta( $post_id, $post, 'recording_file_nonce', 'recording-file', 'sanitize_file_name' );
    save_single_meta( $post_id, $post, 'artist_name_nonce', 'artist-name', 'sanitize_text_field' );
}