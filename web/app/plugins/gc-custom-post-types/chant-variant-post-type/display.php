<?php

function gc_chant_variant_display_by_parent( $chant ) {
    gc_display_post_by_parent( 'gc_chant_variant', $chant );
}

function gc_chant_variant_display_content( $chant_variant ) { ?>
    <h4>Recordings</h4>
    <?= gc_recordings_display_by_parent( $chant_variant );
}