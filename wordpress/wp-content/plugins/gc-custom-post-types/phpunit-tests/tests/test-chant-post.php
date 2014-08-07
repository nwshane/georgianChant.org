<?php

class ChantPost extends WP_UnitTestCase {

    function test_save_georgian_text() {
        $message = 'Tests gc_save_all_meta function.';
        $input = 'ქართული ტექსტი';
        $expected = $input;

        // Create new user and set to current user
        $current_user = $this->factory->user->create(array(
            'role' => 'administrator'
        ));
        wp_set_current_user( $current_user );

        // Create new chant post
        $chant_post_id = $this->factory->post->create(array( 'post_type' => 'gc_chant' ));

        // Create nonce
        $_POST['georgian_text_nonce'] = wp_create_nonce( 'georgian-text-action' );

        // Make $input the value of georgian-text post variable
        $_POST['georgian-text'] = $input;

        // Save to database
        gc_save_all_meta( $chant_post_id, get_post( $chant_post_id ));

        // Retrieve from database as $output
        $output = get_post_meta( $chant_post_id, 'georgian-text', true );
        $this->assertEquals( $expected, $output, $message );
    }
}

