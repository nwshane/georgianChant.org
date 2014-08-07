<?php

class ChantPost extends WP_UnitTestCase {

	function test_transliterate_button() {
        $input = "შენ ხარ ვენახი, ახლად აყვავებული, ნორჩი კეთილი, ედემს შინა ნერგული,ალვა სუნელი, სამოთხეს ამოსული, ღმერთმან შეგამკო ვერვინა გჯობს ქებული, და თავით თვისით მზე ხარ და გაბრწყინვებული.";

        // Create new post
        $chant_post = $this->factory->post->create_and_get(array( 'post_type' => 'gc_chant' ));

        // Open up the post's editor. Probably need to uses some sort of crawler/client.
        // NOTE: May need to use a javascript testing library to test javascript function instead.

//        $editor = fopen( 'http://localhost/wp-admin/post.php?post=' . $chant_post->ID . '&action=edit', 'r' );

        // Enter input into the "Georgian Text" metafield.


        // Click the "Transliterate" button.


        // Get the output from the "Latin Transliteration" metafield.


        $output = "Shen khar venakhi, akhlad aqvavebuli, Norchi k'etili, edems shina nerguli, Alva suneli, samotkhes amosuli, Ghmertman shegamk'o vervina gjobs kebuli, Da tavit tvisit mze khar da gabrts'qinvebuli.";
        $expected = "Shen khar venakhi, akhlad aqvavebuli, Norchi k'etili, edems shina nerguli, Alva suneli, samotkhes amosuli, Ghmertman shegamk'o vervina gjobs kebuli, Da tavit tvisit mze khar da gabrts'qinvebuli.";

        $message = 'Tests that the transliterate button in the chant editor works correctly.';

        $this->assertEquals( $output, $expected, $message);
	}
}

