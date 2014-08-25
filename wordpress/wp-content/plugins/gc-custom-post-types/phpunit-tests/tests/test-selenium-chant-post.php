<?php

class SeleniumChantPost extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp() {
        $this->setBrowser( '*chrome' );
        $this->setBrowserUrl( 'http://localhost/wp-admin' );
    }

    public function testTitle() {
        $this->url( 'http://localhost/wp-admin' );

        // Check correct web page
        $this->assertEquals( 'Georgian Chant › Log In', $this->title() );

        // Set user and password
        $user = 'testUser';
        $password = 'testPassword';

        // Enter user and password into inputs
        $this->byID( 'user_login' )->value( $user );
        $this->byID( 'user_pass' )->value( $password );

        // Click the login button
        $this->byID( 'wp-submit' )->submit();

        // Check correct web page
        $this->assertEquals( 'Dashboard ‹ Georgian Chant — WordPress', $this->title() );

        // Click the Chants link in the left column navigation
        $this->byXPath( '//li[@id="menu-posts-gc_chant"]/descendant::a[1]' )->click();

        // Click the Add New Chant button
        $this->byXPath( '//li[@id="menu-posts-gc_chant"]/descendant::a[.="Add New"]' )->click();

        // Test correct web page
        $this->assertEquals( 'Add New Chant ‹ Georgian Chant — WordPress', $this->title() );

        // Fill out form
        $chantNumber = substr( str_shuffle( '0123456789' ), 5 );
        $chantTitle = 'Test Chant #' . $chantNumber;
        $this->byID( 'title' )->value( $chantTitle );

        // Submit form -- CHANGE THIS TO CLICK ON PUBLISH BUTTON
        $this->byID( 'publish' )->click();

        // Check form values
        $this->assertEquals( $chantTitle, $this->byID( 'title' )->attribute( 'value' ) );

        // Trash test chant
        $this->byXPath( '//div[@id="delete-action"]/descendant::a[1]' )->click();

        // Check correct web page
        $this->assertEquals( 'Chants ‹ Georgian Chant — WordPress', $this->title() );

        // Navigate to trash
        $this->byXPath( '//div[@id="wpbody-content"]/descendant::li[@class="trash"]/descendant::a[1]' )->click();

        // Make Delete Permanently visible
//        $script = 'document.getElementsByClassName("row-actions").style.visibility = "visible";';
        $script = "jQuery('.row-actions').css('visibility', 'visible');";
        $this->execute(array(
            'script' => $script,
            'args'   => array()
        ));

        // Click Delete Permanently link
        $deleteLink = $this->byXPath( '//tbody[@id="the-list"]/descendant::strong[.="' . $chantTitle . '"]/following-sibling::div[@class="row-actions"]/descendant::a[.="Delete Permanently"]' );
        $deleteLink->click();

        // Check that no Test Chant#<number> exists
        try {
            $chantElement = $this->byXPath( '//tbody[@id="the-list"]/descendant::strong[.="' . $chantTitle . '"]' );
        } catch( PHPUnit_Extensions_Selenium2TestCase_WebDriverException $e ) {
            $this->assertEquals( PHPUnit_Extensions_Selenium2TestCase_WebDriverException::NoSuchElement, $e->getCode() );
            return;
        }

        $this->fail( 'Chant was not deleted.' );
    }
}
