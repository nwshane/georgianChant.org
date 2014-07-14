<?php

function recording_meta_fields( $form_fields, $recording ) {
    $fields['recording-year'] = array(
        'label' => 'Year',
        'input' => 'text',
        'value' => get_post_meta( $recording->ID, 'recording-year', true ),
        'helps' => 'Enter the year in which the recording was made.'
    );

    return $fields;
}

add_filter( 'attachment_fields_to_edit', 'recording_meta_fields', 10, 2);