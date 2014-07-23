<?php

function recording_file_meta_box_callback( $recording ) { ?>

    <?php

    wp_nonce_field( 'recording-file-action', 'recording_file_nonce' );
    $recording_file = get_post_meta( $recording->ID, 'recording-file', true );
    $recording_file_url = ( ! ($recording_file === "" ) ? $recording_file['url'] : "" );
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

function update_recording_file( $post_id ) {
    $meta_value = get_post_meta($post_id, 'recording-file', true);

    if ( $meta_value !== "" && $_POST[ 'recording-file-url' ] === "" ) {
        delete_post_meta( $post_id, 'recording-file', $meta_value);
        unlink( $meta_value['file'] );
    }

    $meta_nonce = 'recording_file_nonce';
    $meta_key = 'recording-file-action';

    if ( !isset ( $_POST[$meta_nonce] ) || !wp_verify_nonce( $_POST[$meta_nonce], $meta_key ) ) {
        print 'Sorry, your nonce did not verify for the meta key ' . $meta_key . '.';
        return $post_id;
    }

    if( empty( $_FILES['recording-file']['name'] )) {
        return $post_id;
    } else {

        $supported_file_types = array('audio/mpeg');
        $uploaded_file_type = wp_check_filetype(basename($_FILES['recording-file']['name']))['type'];

        if ( ! in_array( $uploaded_file_type, $supported_file_types )) {
            return $post_id;
        }

        if ( $meta_value !== "" ) {
            unlink( $meta_value['file'] );
        }

        $upload = wp_upload_bits( $_FILES['recording-file']['name'], null, file_get_contents( $_FILES['recording-file']['tmp_name'] ));

        if ( ! $upload['error'] ) {
            update_post_meta( $post_id, 'recording-file', $upload );
        } else {
            print 'Upload failed. Error: ' . $upload['error'];
        }
    }
}

function save_recordings_post_type_meta( $post_id, $post ) {
    update_recording_file( $post_id, $post );
    save_single_meta( $post_id, $post, 'artist_name_nonce', 'artist-name', 'sanitize_text_field' );
}

function add_enctype_to_form_tag() {
    echo ' enctype="multipart/form-data"';
}

add_action( 'post_edit_form_tag' , 'add_enctype_to_form_tag' );

//function add_remove_recording_script() {
//    wp_register_script( 'remove-recording-script', dirname(__FILE__) . '/remove-recording.js');
//    wp_enqueue_script('remove-recording-script');
//}
//
//add_action('load-post.php', 'add_remove_recording_script');
//add_action('load-post-new.php', 'add_remove_recording_script');