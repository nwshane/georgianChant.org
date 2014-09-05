<?php

function gc_chant_dropdown( $selected_chant_id, $dropdown_tag_id, $label_description ) { ?>

    <div>
        <label for='<?= $dropdown_tag_id ?>'><b><?php _e( 'Chant', 'example' )?></b> - <?php _e( $label_description, 'example' ); ?></label>
        <br>
        <select id='<?= $dropdown_tag_id ?>' name='<?= $dropdown_tag_id ?>'>
            <option value=""></option>
            <!--            Fill with available chant posts. -->
            <?php
            $all_chants = get_posts( array( 'post_type' => 'gc_chant' ));

            foreach ($all_chants as $chant) { ?>
                <option value="<?= $chant->ID ?>"<?php if ( $selected_chant_id === $chant->ID ) { ?>selected<?php } ?>>
                    <?= $chant->post_title ?>
                </option>
            <?php } ?>

        </select>
        <?php if ( $selected_chant_id !== 0 ) { ?>
            <p>Edit currently selected chant: <a href="<?=get_edit_post_link( $selected_chant_id )?>"><?= get_post( $selected_chant_id )->post_title ?></a></p>
        <?php } ?>
    </div>
<?php }