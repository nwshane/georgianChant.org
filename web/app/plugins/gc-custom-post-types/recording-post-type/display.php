<?php

function gc_recordings_display_by_parent( $chant_variant ) {
    $recordings = get_posts( array( 
        'post_type' => 'gc_recording',
        'post_parent' => $chant_variant->ID
    ));

    foreach( $recordings as $recording ) { ?>
    <div>
        <h4><a href="<?=get_edit_post_link( $recording->ID )?>"><?=$recording->post_title;?></a></h4>
        <?php gc_recording_display_file( $recording, false ); ?> 
    </div>
    <?php }
}

function gc_recording_display_file( $recording, $editable ) {
    wp_nonce_field( 'recording-file-action', 'recording_file_nonce' );

    $recording_file = get_post_meta( $recording->ID, 'recording-file', true );
    $recording_file_url = ( $recording_file !== "" ? $recording_file['url'] : "" );
    $recording_file_name = substr( $recording_file_url, strrpos ( $recording_file_url, '/' ) + 1 );
    ?>

    <div id="recording-file-display">
         <?php if ( $recording_file !== "" ) { ?>

        Currently uploaded recording: <a href="<?=$recording_file_url?>"><?=$recording_file_name?></a>
        <br>
        <audio controls>
            <source src="<?=$recording_file_url?>" type="audio/mpeg">
        </audio>

        <?php } else { ?>
        <p>No recording has been uploaded.</p>
        <?php } ?>
    </div>
        
    <?php if ( $editable ) { ?>
        <div id="recording-file-edit">
            <?php if ( $recording_file !== "" ) { ?>
                <input type="text" id="recording-file-url" name="recording-file-url" value="<?=$recording_file_url?>" hidden>
                <p id="remove-recording">
                    <a onclick="remove_recording()">Remove current recording</a>
                </p>
                <br>
            <?php } ?>
            <label for="recording-file">Choose a <?php if ( $recording_file !== "" ) { ?>different <?php } ?>recording:</label>
            <input type="file" id="recording-file" name="recording-file" value="<?php if ( $recording_file ) { echo $recording_file_url; } ?>">
        </div>
    <?php }
}