<?php

function recording_file_meta_box_callback() {

}

function gc_recordings_add_meta_boxes() {
    add_meta_box(
        'recording-file-meta-box',
        esc_html__( 'Recording File', 'example' ),
        'recording_file_meta_box_callback',
        'gc_recording',
        'normal',
        'default'
    );
}

function save_recordings_post_type_meta( $post_id, $post ) {

}