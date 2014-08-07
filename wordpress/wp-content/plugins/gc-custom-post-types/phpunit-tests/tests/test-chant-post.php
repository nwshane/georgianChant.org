<?php

class ChantPost extends WP_UnitTestCase {

    function test_save_all_meta() {
        // Setup: Create user
        $current_user = $this->factory->user->create(array(
            'role' => 'administrator'
        ));
        wp_set_current_user( $current_user );

        // Setup: Create user
        $chant_post_id = $this->factory->post->create(array( 'post_type' => 'gc_chant' ));

        function test_setup_POST_var( $field_id, $nonce, $action, $input ) {
            $_POST[$nonce] = wp_create_nonce( $action );
            $_POST[$field_id] = $input;
        }

        $inputGeorgianText = 'ქართული ტექსტი';
        test_setup_POST_var( 'georgian-text', 'georgian_text_nonce', 'georgian-text-action', $inputGeorgianText );

        $inputFeastDayService = 'September 1st';
        test_setup_POST_var( 'feast-day-service', 'feast_day_service_nonce', 'feast-day-service-action', $inputFeastDayService );

        // Save to database
        gc_save_all_meta( $chant_post_id, get_post( $chant_post_id ));

        // Tests
        $this->assertEquals(
            $inputGeorgianText,
            get_post_meta( $chant_post_id, 'georgian-text', true ),
            'Tests that georgian-text field is saving properly to database.'
        );

        $this->assertEquals(
            $inputFeastDayService,
            get_post_meta( $chant_post_id, 'feast-day-service', true ),
            'Tests that feast-day-service is saving properly to database'
        );
    }
}

