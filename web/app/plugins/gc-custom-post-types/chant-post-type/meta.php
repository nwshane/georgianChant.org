<?php

function gc_chant_input_label( $inputId, $inputLabel, $inputDescription ) { ?>
    <label for="<?=$inputId?>"><b><?php _e( $inputLabel, 'example' )?></b> - <?php _e( $inputDescription, 'example' ); ?></label>
<?php }

function gc_chant_text_input( $chant, $inputId, $inputLabel, $inputDescription, $isTextarea ) {
    wp_nonce_field( $inputId . '-action', str_replace( '-' , '_', $inputId ) . '_nonce' ); ?>

    <div>
        <?php gc_chant_input_label( $inputId, $inputLabel, $inputDescription ); ?>
        <br>

<!--        If $isTextarea is true, displays the input as a text area. If false, displays as a normal text input -->
        <?php if ( $isTextarea ) { ?>
        <textarea class='widefat' type="text" name="<?=$inputId?>" id="<?=$inputId?>"><?php echo esc_attr(get_post_meta( $chant->ID, $inputId, true ))?></textarea>
        <?php } else { ?>
        <input type="text" name="<?=$inputId?>" id="<?=$inputId?>" value="<?php echo esc_attr(get_post_meta( $chant->ID, $inputId, true ))?>">
        <?php } ?>
    </div>
<?php }

function gc_chant_title_meta_box( $chant ) {
    // Title in Georgian


    // Title in Georgian transliterated

    // Translated title


}

function gc_chant_rubric_meta_box( $chant ) { ?>
    <?php
    wp_nonce_field( 'feast-day-service-action', 'feast_day_service_nonce' );
    $feast_day_service = esc_attr(get_post_meta( $chant->ID, 'feast-day-service', true));
    ?>

    <div>
        <label for="feast-day-service"><b><?php _e( 'Feast Day/Service', 'example' )?></b> - <?php _e( 'Enter the feast day or the type of service in which the chant is performed.', 'example' ); ?></label>
        <br>
        <select id="feast-day-service" name="feast-day-service">
            <option value></option>
            <optgroup label="Services">
                <?php
                $services = [ "Vespers", "Matins" ];
                foreach ( $services as $service ) { ?>
                    <option value="<?php echo $service; ?>" <?php if ( $feast_day_service === $service ) { ?>selected<?php } ?>><?php echo $service; ?></option>
                <?php } ?>
            </optgroup>
            <optgroup label="Feast Days">
                <?php
                $feast_days = [ "September 1st", "October 8th" ];
                foreach ( $feast_days as $feast_day ) { ?>
                    <option value="<?= $feast_day ?>" <?php if ( $feast_day_service === $feast_day ) { ?>selected<?php } ?>><?php echo $feast_day; ?></option>
                <?php } ?>
            </optgroup>
        </select>
    </div>

    <?php
    wp_nonce_field( 'rubric-genre-action', 'rubric_genre_nonce' );
    $rubric_genre = esc_attr(get_post_meta( $chant->ID, 'rubric-genre', true));
    ?>

    <div>
        <label for="rubric-genre"><b><?php _e( 'Genre', 'example' )?></b> - <?php _e( 'Enter the genre of the chant.', 'example' ); ?></label>
        <br>
        <select id="rubric-genre" name="rubric-genre">
            <option value></option>

            <?php
            $genres = [ "Troparion", "Squigglydoo", "Dooduh" ];
            foreach ( $genres as $genre ) { ?>
                <option value="<?php echo $genre; ?>" <?php if ( $rubric_genre === $genre ) { ?>selected<?php } ?>><?php echo $genre; ?></option>
            <?php } ?>

        </select>
    </div>

    <?php
    wp_nonce_field( 'rubric-tone-action', 'rubric_tone_nonce' );
    $rubric_tone = esc_attr(get_post_meta( $chant->ID, 'rubric-tone', true));
    $rubric_tone_int = 0 + $rubric_tone;
    ?>

    <div>
        <label for="rubric-tone"><b><?php _e( 'Tone', 'example' )?></b> - <?php _e( 'Enter the tone of the chant, if applicable.', 'example' ); ?></label>
        <br>
        <select id="rubric-tone" name="rubric-tone">
            <option value=""></option>
            <option value="Unassigned" <?php if ( $rubric_tone === "Unassigned" ) { ?>selected<?php } ?>>Unassigned</option>
            <?php for ($i = 1; $i <= 8; $i++) { ?>
                <option value="<?php echo $i; ?>" <?php if ( $rubric_tone_int === $i ) { ?>selected<?php } ?>><?php echo $i; ?></option>
            <?php } ?>
        </select>
    </div>

    <?php
    gc_chant_text_input( $chant, 'specific-rubric', 'Specific Rubric', 'Enter the specific rubric of this chant. (Examples: 3rd Heirmoi of the Nativity; Troparion for Palm Sunday; etc.)', false );
    gc_chant_text_input( $chant, 'rubric-notes', 'Notes', 'Enter any further information about this chant\'s rubric.', true );
    ?>

<?php }

function gc_chant_text_meta_box( $chant ) { ?>

    <?php
    gc_chant_text_input( $chant, 'georgian-text', 'Georgian Text', 'Enter the text of the chant in Georgian.', true );
    gc_chant_text_input( $chant, 'text-author', 'Author', 'Enter the author of the chant, if applicable.', false );
    gc_chant_text_input( $chant, 'text-date', 'Date of Authorship', 'Enter the date the chant text was written, if applicable.', false );

    wp_nonce_field( 'latin-transliteration-action', 'latin_transliteration_nonce' ) ?>

    <p>
        <label for="latin-transliteration"><b><?php _e( 'Latin Transliteration', 'example' )?></b> - <a id="latin-transliterate-button" onclick="gc_transliterate_into_latin()"> <?php _e( 'Transliterate directly from "Georgian Text" above', 'example' ); ?></a>, <?php _e( 'or enter the chant text in Georgian with Latin letters yourself.', 'example' ); ?></label>
        <br>
        <textarea class="widefat" type="text" name="latin-transliteration" id="latin-transliteration" size="30"><?php echo esc_attr(get_post_meta( $chant->ID, 'latin-transliteration', true))?></textarea>
    </p>
    <?php

    gc_chant_text_input( $chant, 'english-translation', 'English Translation', 'Enter the English Translation of the chant.', true );
    gc_chant_text_input( $chant, 'english-translation-author', 'English Translation Author', 'Enter the author of the English translation.', false );
    gc_chant_text_input( $chant, 'english-translation-source', 'English Translation Source', 'Enter the source of the English translation (i.e. a website URL, book name, etc.).', false );
    gc_chant_text_input( $chant, 'text-notes', 'Notes', 'Enter any further information about this chant text.', true );
}

function gc_chant_history_meta_box( $chant ) {
    gc_chant_text_input( $chant, 'history', 'Chant History', 'Tell the historical story of this chant.', true );
}

function gc_chant_liturgy_culture_meta_box( $chant ) {
    gc_chant_text_input( $chant, 'liturgy-culture', 'Current Role in Liturgy and Culture', 'Describe this chant\'s contemporary role in liturgy and culture.', true );
}

function gc_chant_add_meta_boxes() {
    add_meta_box(
        'chant-title-meta-box',
        esc_html__( 'Title', 'example' ),
        'gc_chant_title_meta_box',
        'gc_chant',
        'normal',
        'default'
    );

    add_meta_box(
        'chant-rubric-meta-box',
        esc_html__( 'Rubric', 'example' ),
        'gc_chant_rubric_meta_box',
        'gc_chant',
        'normal',
        'default'
    );

    add_meta_box(
        'chant-text-meta-box',
        esc_html__( 'Text', 'example' ),
        'gc_chant_text_meta_box',
        'gc_chant',
        'normal',
        'default'
    );

    add_meta_box(
        'chant-history-meta-box',
        esc_html__( 'History', 'example' ),
        'gc_chant_history_meta_box',
        'gc_chant',
        'normal',
        'default'
    );

    add_meta_box(
        'chant-liturgy-culture-meta-box',
        esc_html__( 'Liturgical and Cultural Role', 'example' ),
        'gc_chant_liturgy_culture_meta_box',
        'gc_chant',
        'normal',
        'default'
    );

    add_meta_box(
        'display-variants-meta-box',
        esc_html__( 'Variants', 'example' ),
        'gc_chant_variant_display_by_parent',
        'gc_chant',
        'normal',
        'default'
    );
}

function gc_chant_save_meta( $post_id, $post ) {
    // Chant Rubric Meta
    gc_save_single_meta( $post_id, $post, 'feast_day_service_nonce', 'feast-day-service', 'sanitize_text_field' );
    gc_save_single_meta( $post_id, $post, 'rubric_genre_nonce', 'rubric-genre', 'sanitize_text_field' );
    gc_save_single_meta( $post_id, $post, 'rubric_tone_nonce', 'rubric-tone', 'sanitize_text_field' );
    gc_save_single_meta( $post_id, $post, 'specific_rubric_nonce', 'specific-rubric', 'gc_sanitize_text_field_retain_line_breaks' );
    gc_save_single_meta( $post_id, $post, 'rubric_notes_nonce', 'rubric-notes', 'gc_sanitize_text_field_retain_line_breaks' );

    // Chant Text Meta
    gc_save_single_meta( $post_id, $post, 'georgian_text_nonce', 'georgian-text', 'gc_sanitize_text_field_retain_line_breaks' );
    gc_save_single_meta( $post_id, $post, 'text_author_nonce', 'text-author', 'sanitize_text_field' );
    gc_save_single_meta( $post_id, $post, 'text_date_nonce', 'text-date', 'sanitize_text_field' );
    gc_save_single_meta( $post_id, $post, 'latin_transliteration_nonce', 'latin-transliteration', 'gc_sanitize_text_field_retain_line_breaks' );
    gc_save_single_meta( $post_id, $post, 'english_translation_nonce', 'english-translation', 'gc_sanitize_text_field_retain_line_breaks' );
    gc_save_single_meta( $post_id, $post, 'english_translation_author_nonce', 'english-translation-author', 'sanitize_text_field');
    gc_save_single_meta( $post_id, $post, 'english_translation_source_nonce', 'english-translation-source', 'sanitize_text_field');
    gc_save_single_meta( $post_id, $post, 'text_notes_nonce', 'text-notes', 'gc_sanitize_text_field_retain_line_breaks' );

    // History Meta
    gc_save_single_meta( $post_id, $post, 'history_nonce', 'history', 'gc_sanitize_text_field_retain_line_breaks' );

    // Liturgy and Culture Meta
    gc_save_single_meta( $post_id, $post, 'liturgy_culture_nonce', 'liturgy-culture', 'gc_sanitize_text_field_retain_line_breaks' );

}