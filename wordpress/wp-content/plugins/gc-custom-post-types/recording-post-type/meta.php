<?php

function chant_identification_meta_box_callback ( $recording ) { ?>

<!--    Chant dropdown -->
    <?php
    wp_nonce_field( 'chant-parent-action', 'chant_parent_nonce' );

    $chant_parent_int = 0 + get_post_meta( $recording->ID, 'chant-parent', true );
    ?>

    <div>
        <label for="chant-parent"><b><?php _e( 'Chant', 'example' )?></b> - <?php _e( 'Select the chant that is being performed. If the chant is not available, it must be created as a "Chant" post.', 'example' ); ?></label>
        <br>
        <select id="chant-parent" name="chant-parent">
            <option value=""></option>
<!--            Fill with available chant posts. -->
            <?php
            $all_chants = get_posts( array( 'post_type' => 'gc_chant' ));

            foreach ($all_chants as $chant) { ?>
            <option value="<?= $chant->ID ?>" <?php if ( $chant_parent_int === $chant->ID ) { ?>selected<?php } ?>><?= $chant->post_title ?></option>
            <?php } ?>

        </select>
    </div>
<?php }

function recording_file_meta_box_callback( $recording ) { ?>

    <?php
    wp_nonce_field( 'recording-file-action', 'recording_file_nonce' );

    $recording_file = get_post_meta( $recording->ID, 'recording-file', true );
    $recording_file_url = ( $recording_file !== "" ? $recording_file['url'] : "" );
    $recording_file_name = substr( $recording_file_url, strrpos ( $recording_file_url, '/' ) + 1 );
    ?>

    <script type="text/javascript">
        jQuery.getScript("../wp-content/plugins/gc-custom-post-types/recording-post-type/remove-recording.js");
    </script>

    <?php if ( $recording_file !== "" ) { ?>
    <div id="recording-controls">
        Currently uploaded recording: <a href="<?=$recording_file_url?>"><?=$recording_file_name?></a>
        <br>
        <audio controls>
            <source src="<?=$recording_file_url?>" type="audio/mpeg">
        </audio>
        <br>
        <input type="text" id="recording-file-url" name="recording-file-url" value="<?=$recording_file_url?>" hidden>
        <p id="remove-recording">
            <a onclick="removeRecording()">Remove current recording</a>
        </p>
    </div>
    <br>
    <?php } ?>
    <label for="recording-file">Choose a <?php if ( $recording_file !== "" ) { ?>different <?php } ?>recording:</label>
    <input type="file" id="recording-file" name="recording-file" value="<?php if ( $recording_file ) { echo $recording_file_url; } ?>">

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
        'chant-identification-meta-box',
        esc_html__( 'Chant Identification', 'example' ),
        'chant_identification_meta_box_callback',
        'gc_recording',
        'normal',
        'default'
    );

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

function remove_recording_file ( $post_id, $meta_value ) {
    delete_post_meta( $post_id, 'recording-file', $meta_value);
    unlink( $meta_value['file'] );
}

function upload_new_recording( $post_id ) {
    $upload = wp_upload_bits( $_FILES['recording-file']['name'], null, file_get_contents( $_FILES['recording-file']['tmp_name'] ));

    if ( ! $upload['error'] ) {
        update_post_meta( $post_id, 'recording-file', $upload );
    } else {
        print 'Upload failed. Error: ' . $upload['error'];
    }
}

function update_recording_file( $post_id ) {

    // Security checks
    $recording_file_nonce = 'recording_file_nonce';
    $recording_file_action = 'recording-file-action';

    if ( !isset ( $_POST[$recording_file_nonce] ) || !wp_verify_nonce( $_POST[$recording_file_nonce], $recording_file_action ) ) {
        print 'Sorry, your nonce did not verify for the meta key ' . $recording_file_action . '.';
        return $post_id;
    }

    $meta_value = get_post_meta($post_id, 'recording-file', true);

    // Check if a new file has been chosen
    if ( !empty ( $_FILES['recording-file']['name'] )) {

        $supported_file_types = array('audio/mpeg');
        $uploaded_file_type = wp_check_filetype(basename($_FILES['recording-file']['name']))['type'];

        if ( ! in_array( $uploaded_file_type, $supported_file_types )) {
            return $post_id;
        }

        // Remove old file and metadata
        if ( $meta_value !== "" ) {
            remove_recording_file( $post_id, $meta_value );
        }

        upload_new_recording( $post_id );

    // If no new file has been chosen, check if uploaded file should be deleted. If so, delete.
    } else if ( $meta_value !== "" && $_POST[ 'recording-file-url' ] === "" ) {
        remove_recording_file( $post_id, $meta_value );
    }
}

function save_recordings_post_type_meta( $post_id, $post ) {
    update_recording_file( $post_id, $post );
    save_single_meta( $post_id, $post, 'chant_parent_nonce', 'chant-parent', 'sanitize_text_field' );
    save_single_meta( $post_id, $post, 'artist_name_nonce', 'artist-name', 'sanitize_text_field' );
}

function add_enctype_to_form_tag() {
    echo ' enctype="multipart/form-data"';
}

add_action( 'post_edit_form_tag' , 'add_enctype_to_form_tag' );