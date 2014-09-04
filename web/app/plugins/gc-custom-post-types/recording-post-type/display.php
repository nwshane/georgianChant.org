<?php

function gc_recordings_display_by_parent( $chant_variant ) {
    $recordings = get_posts( array( 
        'post_type' => 'gc_recording',
        'post_parent' => $chant_variant->ID
    ));

    foreach( $recordings as $recording ) { ?>
    <div>
        <h4><a href="<?=get_edit_post_link( $recording->ID )?>"><?=$recording->post_title;?></a></h4>
        <?php gc_recording_file_display( $recording, false ); ?> 
    </div>
    <?php }
}