<?php

function chant_rubric_meta_box_callback( $chant ) { ?>

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

<?php wp_nonce_field( 'specific-rubric-action', 'specific_rubric_nonce' ) ?>

<div>
    <label for="specific-rubric"><b><?php _e( 'Specific Rubric', 'example' )?></b> - <?php _e( 'Enter the specific rubric of this chant. (Examples: 3rd Heirmoi of the Nativity; Troparion for Palm Sunday; etc.)', 'example' ); ?></label>
    <br>
    <input type="text" name="specific-rubric" id="specific-rubric" value="<?php echo esc_attr(get_post_meta( $chant->ID, 'specific-rubric', true ))?>">
</div>

<?php wp_nonce_field( 'rubric-notes-action', 'rubric_notes_nonce' ) ?>

<div>
    <label for="rubric-notes"><b><?php _e( 'Notes', 'example' )?></b> - <?php _e( 'Enter any further information about this chant\'s rubric.', 'example' ); ?></label>
    <br>
    <textarea class="widefat" type="text" name="rubric-notes" id="rubric-notes" size="30"><?php echo esc_attr(get_post_meta( $chant->ID, 'rubric-notes', true))?></textarea>
</div>
<?php }

function chant_text_meta_box_callback( $chant ) { ?>

    <?php wp_nonce_field( 'georgian-text-action', 'georgian_text_nonce' ) ?>

    <p>
        <label for="georgian-text"><b><?php _e( 'Georgian Text', 'example' )?></b> - <?php _e( 'Enter the text of the chant in Georgian.', 'example' ); ?></label>
        <br>
        <textarea class="widefat" type="text" name="georgian-text" id="georgian-text" size="30"><?php echo esc_attr(get_post_meta( $chant->ID, 'georgian-text', true))?></textarea>
    </p>

    <?php wp_nonce_field( 'text-author-action', 'text_author_nonce' ) ?>

    <p>
        <label for="text-author"><b><?php _e( 'Author', 'example' )?></b> - <?php _e( 'Enter the author of the chant, if applicable.', 'example' ); ?></label>
        <br>
        <input type="text" name="text-author" id="text-author" value="<?php echo esc_attr(get_post_meta( $chant->ID, 'text-author', true))?>">
    </p>

    <?php wp_nonce_field( 'text-date-action', 'text_date_nonce' ) ?>

    <p>
        <label for="text-date"><b><?php _e( 'Date of Authorship', 'example' )?></b> - <?php _e( 'Enter the date the chant text was written, if applicable.', 'example' ); ?></label>
        <br>
        <input type="text" name="text-date" id="text-date" value="<?php echo esc_attr(get_post_meta( $chant->ID, 'text-date', true))?>">
    </p>

    <?php wp_nonce_field( 'latin-transliteration-action', 'latin_transliteration_nonce' ) ?>

    <p>
        <script type="text/javascript">
            jQuery.getScript("../wp-content/plugins/gc-chant/js/georgian-latin-transliterator.js");
        </script>
        <label for="latin-transliteration"><b><?php _e( 'Latin Transliteration', 'example' )?></b> - <a onclick="transliterateIntoLatin()"> <?php _e( 'Transliterate directly from "Georgian Text" above', 'example' ); ?></a>, <?php _e( 'or enter the chant text in Georgian with Latin letters yourself.', 'example' ); ?></label>
        <br>
        <textarea class="widefat" type="text" name="latin-transliteration" id="latin-transliteration" size="30"><?php echo esc_attr(get_post_meta( $chant->ID, 'latin-transliteration', true))?></textarea>
    </p>

    <?php wp_nonce_field( 'english-translation-action', 'english_translation_nonce' ) ?>

    <p>
        <label for="english-translation"><b><?php _e( 'English Translation', 'example' )?></b> - <?php _e( 'Enter the English Translation of the chant.', 'example' ); ?></label>
        <br>
        <textarea class="widefat" type="text" name="english-translation" id="english-translation" size="30"><?php echo esc_attr(get_post_meta( $chant->ID, 'english-translation', true))?></textarea>
    </p>

    <?php wp_nonce_field( 'english-translation-author-action', 'english_translation_author_nonce' ) ?>

    <p>
        <label for="english-translation-author"><b><?php _e( 'English Translation Author', 'example' )?></b> - <?php _e( 'Enter the author of the English translation.', 'example' ); ?></label>
        <br>
        <input type="text" name="english-translation-author" id="english-translation-author" value="<?php echo esc_attr(get_post_meta( $chant->ID, 'english-translation-author', true))?>">
    </p>

    <?php wp_nonce_field( 'english-translation-source-action', 'english_translation_source_nonce' ) ?>

    <p>
        <label for="english-translation-source"><b><?php _e( 'English Translation Source', 'example' )?></b> - <?php _e( 'Enter the source of the English translation (i.e. a website URL, book name, etc.).', 'example' ); ?></label>
        <br>
        <input type="text" name="english-translation-source" id="english-translation-source" value="<?php echo esc_attr(get_post_meta( $chant->ID, 'english-translation-source', true))?>">
    </p>

    <?php wp_nonce_field( 'text-notes-action', 'text_notes_nonce' ) ?>

    <p>
        <label for="text-notes"><b><?php _e( 'Notes', 'example' )?></b> - <?php _e( 'Enter any further information about this chant text.', 'example' ); ?></label>
        <br>
        <textarea class="widefat" type="text" name="text-notes" id="text-notes" size="30"><?php echo esc_attr(get_post_meta( $chant->ID, 'text-notes', true))?></textarea>
    </p>
<?php }

function chant_history_meta_box_callback( $chant ) { ?>

    <?php wp_nonce_field( 'history-action', 'history_nonce' ) ?>

    <label for="history"><b><?php _e( 'Chant History', 'example' )?></b> - <?php _e( 'Tell the historical story of this chant.', 'example' ); ?></label>
    <br>
    <textarea class="widefat" type="text" name="history" id="history" size="30"><?php echo esc_attr(get_post_meta( $chant->ID, 'history', true))?></textarea>

<?php }

function chant_liturgy_culture_meta_box_callback( $chant ) { ?>

    <?php wp_nonce_field( 'liturgy-culture-action', 'liturgy_culture_nonce' ) ?>

    <label for="Current Role in Liturgy and Culture"><b><?php _e( 'Notes', 'example' )?></b> - <?php _e( 'Describe this chant\'s contemporary role in liturgy and culture.', 'example' ); ?></label>
    <br>
    <textarea class="widefat" type="text" name="liturgy-culture" id="liturgy-culture" size="30"><?php echo esc_attr(get_post_meta( $chant->ID, 'liturgy-culture', true))?></textarea>

<?php }

function gc_chant_add_meta_boxes() {
    add_meta_box(
        'chant-rubric-meta-box',
        esc_html__( 'Rubric', 'example' ),
        'chant_rubric_meta_box_callback',
        'gc_chant',
        'normal',
        'default'
    );

    add_meta_box(
        'chant-text-meta-box',
        esc_html__( 'Text', 'example' ),
        'chant_text_meta_box_callback',
        'gc_chant',
        'normal',
        'default'
    );

    add_meta_box(
        'chant-history-meta-box',
        esc_html__( 'History', 'example' ),
        'chant_history_meta_box_callback',
        'gc_chant',
        'normal',
        'default'
    );

    add_meta_box(
        'chant-liturgy-culture-meta-box',
        esc_html__( 'Liturgical and Cultural Role', 'example' ),
        'chant_liturgy_culture_meta_box_callback',
        'gc_chant',
        'normal',
        'default'
    );
}

function save_chant_post_type_meta( $post_id, $post ) {
    // Chant Rubric Meta
    save_single_meta( $post_id, $post, 'feast_day_service_nonce', 'feast-day-service', 'sanitize_text_field' );
    save_single_meta( $post_id, $post, 'rubric_genre_nonce', 'rubric-genre', 'sanitize_text_field' );
    save_single_meta( $post_id, $post, 'rubric_tone_nonce', 'rubric-tone', 'sanitize_text_field' );
    save_single_meta( $post_id, $post, 'specific_rubric_nonce', 'specific-rubric', 'sanitize_text_field_retain_line_breaks' );
    save_single_meta( $post_id, $post, 'rubric_notes_nonce', 'rubric-notes', 'sanitize_text_field_retain_line_breaks' );

    // Chant Text Meta
    save_single_meta( $post_id, $post, 'georgian_text_nonce', 'georgian-text', 'sanitize_text_field_retain_line_breaks' );
    save_single_meta( $post_id, $post, 'text_author_nonce', 'text-author', 'sanitize_text_field' );
    save_single_meta( $post_id, $post, 'text_date_nonce', 'text-date', 'sanitize_text_field' );
    save_single_meta( $post_id, $post, 'latin_transliteration_nonce', 'latin-transliteration', 'sanitize_text_field_retain_line_breaks' );
    save_single_meta( $post_id, $post, 'english_translation_nonce', 'english-translation', 'sanitize_text_field_retain_line_breaks' );
    save_single_meta( $post_id, $post, 'english_translation_author_nonce', 'english-translation-author', 'sanitize_text_field');
    save_single_meta( $post_id, $post, 'english_translation_source_nonce', 'english-translation-source', 'sanitize_text_field');
    save_single_meta( $post_id, $post, 'text_notes_nonce', 'text-notes', 'sanitize_text_field_retain_line_breaks' );

    // History Meta
    save_single_meta( $post_id, $post, 'history_nonce', 'history', 'sanitize_text_field_retain_line_breaks' );

    // Liturgy and Culture Meta
    save_single_meta( $post_id, $post, 'liturgy_culture_nonce', 'liturgy-culture', 'sanitize_text_field_retain_line_breaks' );

}