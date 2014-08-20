<?php

class SeleniumChantPost extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp() {
        $this->setBrowser( 'firefox' );
        $this->setBrowserUrl( 'http://localhost/wp-admin' );
    }

    public function testTitle() {
        // Test title of wp-admin login
        $this->url( 'http://localhost/wp-admin' );
        $this->assertEquals( 'Georgian Chant › Log In', $this->title() );

        // Retrieve user and password from database (manually)
        $user = 'django09';
        $password = 'Fanibel2Georgianchant';

        // Enter user and password into inputs
        $this->byID( 'user_login' )->value( $user );
        $this->byID( 'user_pass' )->value( $password );

        // Click the login button
        $this->byID( 'wp-submit' )->submit();

        // Check title
        $this->assertEquals( 'Dashboard ‹ Georgian Chant — WordPress', $this->title() );
    }
}
