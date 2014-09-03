<?php

class SaveAllMeta extends WP_UnitTestCase {

    private $_chant_test_objects = array();
    private $_chant_id;

    public function get_chant_test_objects() {
        return $this->_chant_test_objects;
    }

    public function get_chant_id() {
        return $this->_chant_id;
    }

    public function add_test_object( $field_name, $nonce, $action, $input, $expected = null ) {
        if ( !isset( $expected )) {
            $expected = $input;
        }

        array_push( $this->_chant_test_objects, array(
                'field_name' => $field_name,
                'nonce' => $nonce,
                'action' => $action,
                'input' => $input,
                'expected' => $expected
            )
        );

        $_POST[$nonce] = wp_create_nonce( $action );
        $_POST[$field_name] = $input;
    }

    public function add_chant_objects() {
        // Chant Rubric Meta
        $this->add_test_object( 'feast-day-service', 'feast_day_service_nonce', 'feast-day-service-action', 'September 1st' );
        $this->add_test_object( 'rubric-genre', 'rubric_genre_nonce', 'rubric-genre-action', 'Troparion' );
        $this->add_test_object( 'rubric-tone', 'rubric_tone_nonce', 'rubric-tone-action', '7' );
        $this->add_test_object( 'specific-rubric', 'specific_rubric_nonce', 'specific-rubric-action', '3rd Heirmoi of the Nativity' );
        $this->add_test_object( 'rubric-notes', 'rubric_notes_nonce', 'rubric-notes-action', 'Unsure of tone' );

        // Chant Text Meta
        $this->add_test_object( 'georgian-text', 'georgian_text_nonce', 'georgian-text-action', 'ქართული ტექსტი' );
        $this->add_test_object( 'text-author', 'text_author_nonce', 'text-author-action', 'King Demetre II' );
        $this->add_test_object( 'text-date', 'text_date_nonce', 'text-date-action', '12th century' );
        $this->add_test_object( 'latin-transliteration', 'latin_transliteration_nonce', 'latin-transliteration-action', 'Kartuli T\'ekst\'i' );
        $this->add_test_object( 'english-translation', 'english_translation_nonce', 'english-translation-action', 'You are a vineyard newly blossomed. Young, beautiful, growing in Eden, A fragrant poplar sapling in Paradise. May God adorn you. No one is more worthy of praise. You yourself are the sun, shining brilliantly.' );
        $this->add_test_object( 'english-translation-author', 'english_translation_author_nonce', 'english-translation-author-action', 'Unknown' );
        $this->add_test_object( 'english-translation-source', 'english_translation_source_nonce', 'english-translation-source-action', 'http://en.wikipedia.org/wiki/Shen_Khar_Venakhi' );
        $this->add_test_object( 'text-notes', 'text_notes_nonce', 'text-notes-action', 'This text was dedicated to the Holy Theotokos (Mother of God).' );

        // Other Meta
        $this->add_test_object( 'history', 'history_nonce', 'history-action', 'This is the history of Shen Khar Venakhi' );
        $this->add_test_object( 'liturgy-culture', 'liturgy_culture_nonce', 'liturgy-culture-action', 'This is the liturical and cultural role of Shen Khar Venakhi in society.' );
    }

    public function add_objects() {
        $this->add_chant_objects();
    }


    public function set_up_tests() {
        // Create and set current user
        $current_user = $this->factory->user->create(array( 'role' => 'administrator' ));
        wp_set_current_user( $current_user );

        // Setup: Create post and setup post variable
        $this->_chant_id = $this->factory->post->create(array( 'post_type' => 'gc_chant' ));

        // Add objects
        $this->add_objects();

        // Save to DB
        gc_save_all_meta( $this->get_chant_id(), get_post( $this->get_chant_id() ));
    }

    public function test_get_and_check_meta() {
        $this->set_up_tests();

        foreach( $this->get_chant_test_objects() as $obj ) {
            $this->assertEquals(
                $obj['expected'],
                get_post_meta( $this->get_chant_id(), $obj['field_name'], true ),
                'Tests that ' . $obj['field_name'] . ' field is saving properly to database.'
            );
        }
    }
}

