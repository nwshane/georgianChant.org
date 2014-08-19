<?php
class seleniumChantPost extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp() {
        $this->setBrowser( 'firefox' );
        $this->setBrowserUrl( 'http://localhost/wp-admin' );
        $this->setHost( 'localhost' );
    }

    public function testTitle() {
        // Test title of wp-admin login
        $this->url( 'http://localhost/wp-admin' );
        $this->assertEquals( 'Georgian Chant › Log In', $this->title() );

    }
}
