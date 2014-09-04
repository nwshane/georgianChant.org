<?php

function gc_chant_variant_display_by_parent( $chant ) {
    $chant_variants = get_posts( array(
        'post_type' => 'gc_chant_variant',
        'post_parent' => $chant->ID
    )); 
    
    foreach( $chant_variants as $chant_variant ) { ?>
        <div>
            <h3><a href="<?= get_edit_post_link( $chant_variant->ID ) ?>"><?=$chant_variant->post_title;?></a></h3>
            
            <h3>Recordings</h3>
            <?= gc_recordings_display_by_parent( $chant_variant ); ?>
        </div>

    <?php }
}