<?php

function gc_chant_variant_display_by_parent( $chant ) {
    $chant_variants = get_posts( array(
        'post_type' => 'gc_chant_variant',
        'post_parent' => $chant->ID
    )); 

    ?>
    <ul>
    <?php
    foreach( $chant_variants as $chant_variant ) { ?>
        <li class='single-chant-variant'>
            <h4>
                <span class='toggle-button' onclick='toggle_content()'>&#x025BE;</span>
                <a href="<?= get_edit_post_link( $chant_variant->ID ) ?>"><?=$chant_variant->post_title;?></a>
            </h4>
            <div class='content'>
                <h4>Recordings</h4>
                <?= gc_recordings_display_by_parent( $chant_variant ); ?>
            </div>
        </li>
    <?php } ?>
    </ul>
<?php }