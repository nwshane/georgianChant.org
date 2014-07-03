<?php
/**
 * Plugin Name: Chant Custom Post Type
 * Description: Creates the chant custom post type
 * Author: Nathan Shane
 */

/**
 * Adds custom_post_type chant
 */
function setup_gc_chant() {
    $labels = array(
        'name'                  => _x( 'Chants', 'post type general name'),
        'singular_name'         => _x( 'Chant', 'post type singular name'),
        'add_new'               => _x( 'Add New', 'book'),
        'add_new_item'          => __( 'Add New Chant' ),
        'edit_item'             => __( 'Edit Chant'),
        'new_item'              => __( 'New Chant' ),
        'all_items'             => __( 'All Chants' ),
        'view_item'             => __( 'View Chant' ),
        'search_items'          => __( 'Search Chants' ),
        'not_found'             => __( 'No chants found' ),
        'not_found_in_trash'    => __( 'No chants found in the trash' ),
        'parent_item_colon'     => '',
        'menu_name'             => 'Chants'
    );

    $args = array(
        'labels'        => $labels,
        'description'   => 'The information associated with an individual chant.',
        'public'        => true,
        'menu_position' => 5,
        'supports'      => array('title'),
        'has_archive'   => true
    );

    register_post_type("gc_chant", $args);
}

add_action('init', 'setup_gc_chant');

/*
 * Adds chant rubric meta box HTML to chant editor
 */
function chant_rubric_meta_box_callback( $chant ) { ?>

    <?php
    wp_nonce_field( basename( __FILE__ ), 'feast_day_service_nonce' );
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
    wp_nonce_field( basename( __FILE__ ), 'rubric_genre_nonce' );
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
    wp_nonce_field( basename( __FILE__ ), 'rubric_tone_nonce' );
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

    <?php wp_nonce_field( basename( __FILE__ ), 'specific_rubric_nonce' ) ?>

    <div>
        <label for="specific-rubric"><b><?php _e( 'Specific Rubric', 'example' )?></b> - <?php _e( 'Enter the specific rubric of this chant. (Examples: 3rd Heirmoi of the Nativity; Troparion for Palm Sunday; etc.)', 'example' ); ?></label>
        <br>
        <input type="text" name="specific-rubric" id="specific-rubric" value="<?php echo esc_attr(get_post_meta( $chant->ID, 'specific-rubric', true ))?>">
    </div>

    <?php wp_nonce_field( basename( __FILE__ ), 'rubric_notes_nonce' ) ?>

    <div>
        <label for="rubric-notes"><b><?php _e( 'Notes', 'example' )?></b> - <?php _e( 'Enter any further information about this chant\'s rubric.', 'example' ); ?></label>
        <br>
        <textarea class="widefat" type="text" name="rubric-notes" id="rubric-notes" size="30"><?php echo esc_attr(get_post_meta( $chant->ID, 'rubric-notes', true))?></textarea>
    </div>
<?php }

/**
 * Adds chant text meta box HTML to chant editor
 */
function chant_text_meta_box_callback( $chant ) { ?>

    <?php wp_nonce_field( basename( __FILE__ ), 'georgian_text_nonce' ) ?>

    <p>
        <label for="georgian-text"><b><?php _e( 'Georgian Text', 'example' )?></b> - <?php _e( 'Enter the text of the chant in Georgian.', 'example' ); ?></label>
        <br>
        <textarea class="widefat" type="text" name="georgian-text" id="georgian-text" size="30"><?php echo esc_attr(get_post_meta( $chant->ID, 'georgian-text', true))?></textarea>
    </p>

    <?php wp_nonce_field( basename( __FILE__ ), 'text_author_nonce' ) ?>

    <p>
        <label for="text-author"><b><?php _e( 'Author', 'example' )?></b> - <?php _e( 'Enter the author of the chant, if applicable.', 'example' ); ?></label>
        <br>
        <input type="text" name="text-author" id="text-author" value="<?php echo esc_attr(get_post_meta( $chant->ID, 'text-author', true))?>">
    </p>

    <?php wp_nonce_field( basename( __FILE__ ), 'text_date_nonce' ) ?>

    <p>
        <label for="text-date"><b><?php _e( 'Date of Authorship', 'example' )?></b> - <?php _e( 'Enter the date the chant text was written, if applicable.', 'example' ); ?></label>
        <br>
        <input type="text" name="text-date" id="text-date" value="<?php echo esc_attr(get_post_meta( $chant->ID, 'text-date', true))?>">
    </p>

    <?php wp_nonce_field( basename( __FILE__ ), 'latin_transliteration_nonce' ) ?>

    <p>
        <script type="text/javascript">
            jQuery.getScript("../wp-content/plugins/gc-chant-post-type/georgian-latin-transliterator.js");
        </script>
        <label for="latin-transliteration"><b><?php _e( 'Latin Transliteration', 'example' )?></b> - <a onclick="transliterateIntoLatin()"> <?php _e( 'Transliterate directly from "Georgian Text" above', 'example' ); ?></a>, <?php _e( 'or enter the chant text in Georgian with Latin letters yourself.', 'example' ); ?></label>
        <br>
        <textarea class="widefat" type="text" name="latin-transliteration" id="latin-transliteration" size="30"><?php echo esc_attr(get_post_meta( $chant->ID, 'latin-transliteration', true))?></textarea>
    </p>

    <?php wp_nonce_field( basename( __FILE__ ), 'english_translation_nonce' ) ?>

    <p>
        <label for="english-translation"><b><?php _e( 'English Translation', 'example' )?></b> - <?php _e( 'Enter the English Translation of the chant.', 'example' ); ?></label>
        <br>
        <textarea class="widefat" type="text" name="english-translation" id="english-translation" size="30"><?php echo esc_attr(get_post_meta( $chant->ID, 'english-translation', true))?></textarea>
    </p>

    <?php wp_nonce_field( basename( __FILE__ ), 'english_translation_author_nonce' ) ?>

    <p>
        <label for="english-translation-author"><b><?php _e( 'English Translation Author', 'example' )?></b> - <?php _e( 'Enter the author of the English translation.', 'example' ); ?></label>
        <br>
        <input type="text" name="english-translation-author" id="english-translation-author" value="<?php echo esc_attr(get_post_meta( $chant->ID, 'english-translation-author', true))?>">
    </p>

    <?php wp_nonce_field( basename( __FILE__ ), 'english_translation_source_nonce' ) ?>

    <p>
        <label for="english-translation-source"><b><?php _e( 'English Translation Source', 'example' )?></b> - <?php _e( 'Enter the source of the English translation (i.e. a website URL, book name, etc.).', 'example' ); ?></label>
        <br>
        <input type="text" name="english-translation-source" id="english-translation-source" value="<?php echo esc_attr(get_post_meta( $chant->ID, 'english-translation-source', true))?>">
    </p>

    <?php wp_nonce_field( basename( __FILE__ ), 'text_notes_nonce' ) ?>

    <p>
        <label for="text-notes"><b><?php _e( 'Notes', 'example' )?></b> - <?php _e( 'Enter any further information about this chant text.', 'example' ); ?></label>
        <br>
        <textarea class="widefat" type="text" name="text-notes" id="text-notes" size="30"><?php echo esc_attr(get_post_meta( $chant->ID, 'text-notes', true))?></textarea>
    </p>
<?php }

function chant_history_meta_box_callback( $chant ) { ?>

    <?php wp_nonce_field( basename( __FILE__ ), 'history_nonce' ) ?>

    <label for="history"><b><?php _e( 'Chant History', 'example' )?></b> - <?php _e( 'Tell the historical story of this chant.', 'example' ); ?></label>
    <br>
    <textarea class="widefat" type="text" name="history" id="history" size="30"><?php echo esc_attr(get_post_meta( $chant->ID, 'history', true))?></textarea>

<?php }

function chant_liturgy_culture_meta_box_callback( $chant ) { ?>

    <?php wp_nonce_field( basename( __FILE__ ), 'liturgy_culture_nonce' ) ?>

    <label for="Current Role in Liturgy and Culture"><b><?php _e( 'Notes', 'example' )?></b> - <?php _e( 'Describe this chant\'s contemporary role in liturgy and culture.', 'example' ); ?></label>
    <br>
    <textarea class="widefat" type="text" name="liturgy-culture" id="liturgy-culture" size="30"><?php echo esc_attr(get_post_meta( $chant->ID, 'liturgy-culture', true))?></textarea>

<?php }

function chant_variants_meta_box_callback( $chant ) { ?>

    <p>If the chant variant comes out of the oral tradition...</p>

    <?php
    wp_nonce_field( basename( __FILE__ ), 'monastery_tradition_nonce' );
    $monastery_tradition = esc_attr(get_post_meta( $chant->ID, 'monastery-tradition', true));
    ?>

    <div>
        <label for="monastery-tradition"><b><?php _e( 'Monastery Tradition', 'example' )?></b> - <?php _e( 'Enter the monastery tradition of the chant.', 'example' ); ?></label>
        <br>
        <select id="monastery-tradition" name="monastery-tradition">
            <option value></option>

            <?php
            $possible_monastery_traditions = [ "Gelati", "Shemokmedi", "East Georgia" ];
            foreach ( $possible_monastery_traditions as $possible_monastery_tradition ) { ?>
                <option value="<?php echo $possible_monastery_tradition; ?>" <?php if ( $monastery_tradition === $possible_monastery_tradition ) { ?>selected<?php } ?>><?php echo $possible_monastery_tradition; ?></option>
            <?php } ?>

        </select>
    </div>

<?php }

function gc_chant_add_post_meta_boxes() {
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

    add_meta_box(
        'chant-variants-meta-box',
        esc_html__( 'Variants', 'example' ),
        'chant_variants_meta_box_callback',
        'gc_chant',
        'normal',
        'default'
    );
}

/*
 * Sanitize text field but retain line breaks.
 * Identical to sanitize_text_field function in formatting.php, EXCEPT does not strip "\n" characters.
 */
function sanitize_text_field_retain_line_breaks($str) {
    $filtered = wp_check_invalid_utf8( $str );

    if ( strpos($filtered, '<') !== false ) {
        $filtered = wp_pre_kses_less_than( $filtered );
        // This will strip extra whitespace for us.
        $filtered = wp_strip_all_tags( $filtered, true );
    } else {
        $filtered = trim( preg_replace('/[\r\t ]+/', ' ', $filtered) );
    }

    $found = false;
    while ( preg_match('/%[a-f0-9]{2}/i', $filtered, $match) ) {
        $filtered = str_replace($match[0], '', $filtered);
        $found = true;
    }

    if ( $found ) {
        // Strip out the whitespace that may now exist after removing the octets.
        $filtered = trim( preg_replace('/ +/', ' ', $filtered) );
    }

    return apply_filters( 'sanitize_text_field', $filtered, $str );
}

/*
 * Save a single meta box's metadata.
 * Code copied and modified from http://www.smashingmagazine.com/2011/10/04/create-custom-post-meta-boxes-wordpress/
 */
function gc_chant_save_meta( $post_id, $post, $meta_nonce, $meta_key, $sanitize ) {
    /* Verify the nonce before proceeding. */
    if ( !isset( $_POST[$meta_nonce] ) || !wp_verify_nonce( $_POST[$meta_nonce], basename( __FILE__ ) ) )
        return $post_id;

    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );

    /* Check if the current user has permission to edit the post. */
    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
        return $post_id;

    /* Get the posted data and sanitize it for use as an HTML class. */
    $new_meta_value = ( isset( $_POST[$meta_key] ) ? $sanitize($_POST[$meta_key]) : '' );

    /* Get the meta value of the custom field key. */
    $meta_value = get_post_meta( $post_id, $meta_key, true );

    /* If a new meta value was added and there was no previous value, add it. */
    if ( $new_meta_value && '' == $meta_value )
        add_post_meta( $post_id, $meta_key, $new_meta_value, true );

    /* If the new meta value does not match the old value, update it. */
    elseif ( $new_meta_value && $new_meta_value != $meta_value )
        update_post_meta( $post_id, $meta_key, $new_meta_value );

    /* If there is no new meta value but an old value exists, delete it. */
    elseif ( '' == $new_meta_value && $meta_value )
        delete_post_meta( $post_id, $meta_key, $meta_value );
}

function gc_chant_save_all_meta( $post_id, $post ) {
    // Chant Rubric Meta
    gc_chant_save_meta( $post_id, $post, 'feast_day_service_nonce', 'feast-day-service', 'sanitize_text_field' );
    gc_chant_save_meta( $post_id, $post, 'rubric_genre_nonce', 'rubric-genre', 'sanitize_text_field' );
    gc_chant_save_meta( $post_id, $post, 'rubric_tone_nonce', 'rubric-tone', 'sanitize_text_field' );
    gc_chant_save_meta( $post_id, $post, 'specific_rubric_nonce', 'specific-rubric', 'sanitize_text_field_retain_line_breaks' );
    gc_chant_save_meta( $post_id, $post, 'rubric_notes_nonce', 'rubric-notes', 'sanitize_text_field_retain_line_breaks' );

    // Chant Text Meta
    gc_chant_save_meta( $post_id, $post, 'georgian_text_nonce', 'georgian-text', 'sanitize_text_field_retain_line_breaks' );
    gc_chant_save_meta( $post_id, $post, 'text_author_nonce', 'text-author', 'sanitize_text_field' );
    gc_chant_save_meta( $post_id, $post, 'text_date_nonce', 'text-date', 'sanitize_text_field' );
    gc_chant_save_meta( $post_id, $post, 'latin_transliteration_nonce', 'latin-transliteration', 'sanitize_text_field_retain_line_breaks' );
    gc_chant_save_meta( $post_id, $post, 'english_translation_nonce', 'english-translation', 'sanitize_text_field_retain_line_breaks' );
    gc_chant_save_meta( $post_id, $post, 'english_translation_author_nonce', 'english-translation-author', 'sanitize_text_field');
    gc_chant_save_meta( $post_id, $post, 'english_translation_source_nonce', 'english-translation-source', 'sanitize_text_field');
    gc_chant_save_meta( $post_id, $post, 'text_notes_nonce', 'text-notes', 'sanitize_text_field_retain_line_breaks' );

    // History Meta
    gc_chant_save_meta( $post_id, $post, 'history_nonce', 'history', 'sanitize_text_field_retain_line_breaks' );

    // Liturgy and Culture Meta
    gc_chant_save_meta( $post_id, $post, 'liturgy_culture_nonce', 'liturgy-culture', 'sanitize_text_field_retain_line_breaks' );
}

function gc_chant_post_meta_boxes_setup() {
    add_action( 'add_meta_boxes', 'gc_chant_add_post_meta_boxes' );
    add_action( 'save_post', 'gc_chant_save_all_meta', 10, 2 );
}

add_action( 'load-post.php', 'gc_chant_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'gc_chant_post_meta_boxes_setup' );