<?php

class SeleniumChantPost extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp() {
        $this->setBrowser( 'chrome' );
        $this->setBrowserUrl( 'http://localhost/wp-admin' );
    }

    public function login() {
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
    }

    public function navigateToPostMenuOption( $postTypeID, $menuOptionText, $targetWebPageTitle ) {
        // Click the Chants link in the left column navigation
        $this->byXPath( '//li[@id="menu-posts-' . $postTypeID . '"]/descendant::a[1]' )->click();

        // Click the Add New Chant button
        $this->byXPath( '//li[@id="menu-posts-' . $postTypeID . '"]/descendant::a[.="' . $menuOptionText . '"]' )->click();

        // Test correct web page
        $this->assertEquals( $targetWebPageTitle, $this->title() );
    }

    public function fillOutForm( $chantTitle ) {
        $this->byID( 'title' )->value( $chantTitle );

        // Rubric
        $this->select( $this->byID( 'feast-day-service' ))->selectOptionByLabel( 'October 8th' );
        $this->select( $this->byID( 'rubric-genre' ))->selectOptionByLabel( 'Troparion' );
        $this->select( $this->byID( 'rubric-tone' ))->selectOptionByLabel( '1' );
        $this->byID( 'specific-rubric' )->value( '3rd Heirmoi of the Nativity<script>' );
        $this->byID( 'rubric-notes' )->value( 'The rubric notes' );

        // Text
        $this->byID( 'georgian-text' )->value( 'ეს ჩემი გალობაა' );
        $this->byID( 'text-author' )->value( 'The greatest author who ever did live' );
        $this->byID( 'text-date' )->value( 'January 1st, 1733' );
        $this->byID( 'latin-transliterate-button' )->click();
        $this->byID( 'english-translation' )->value( 'This is the English translation' );
        $this->byID( 'english-translation-author' )->value( 'The translation author' );
        $this->byID( 'english-translation-source' )->value( 'The translation source' );
        $this->byID( 'text-notes' )->value( 'Notes on the text' );

        // Further
        $this->byID( 'history' )->value( 'The history of the chant' );
        $this->byID( 'liturgy-culture' )->value( 'The historical and liturgical significance of the chant' );
    }

    public function checkFormValues( $chantTitle ) {
        $this->assertEquals( $chantTitle, $this->byID( 'title' )->attribute( 'value' ) );

        // Rubric
        $this->assertEquals( 'October 8th', $this->byID( 'feast-day-service' )->attribute( 'value' ));
        $this->assertEquals( 'Troparion', $this->byID( 'rubric-genre' )->attribute( 'value' ));
        $this->assertEquals( '1', $this->byID( 'rubric-tone' )->attribute( 'value' ));
        $this->assertEquals( '3rd Heirmoi of the Nativity', $this->byID( 'specific-rubric' )->attribute( 'value' ));
        $this->assertEquals( 'The rubric notes', $this->byID( 'rubric-notes' )->attribute( 'value' ));

        // Text
        $this->assertEquals( 'ეს ჩემი გალობაა', $this->byID( 'georgian-text' )->attribute( 'value' ));
        $this->assertEquals( 'The greatest author who ever did live', $this->byID( 'text-author' )->attribute( 'value' ));
        $this->assertEquals( 'January 1st, 1733', $this->byID( 'text-date' )->attribute( 'value' ));
        $this->assertEquals( 'Es chemi galobaa', $this->byID( 'latin-transliteration' )->attribute( 'value' ));
        $this->assertEquals( 'This is the English translation', $this->byID( 'english-translation' )->attribute( 'value' ));
        $this->assertEquals( 'The translation author', $this->byID( 'english-translation-author' )->attribute( 'value' ));
        $this->assertEquals( 'The translation source', $this->byID( 'english-translation-source' )->attribute( 'value' ));
        $this->assertEquals( 'Notes on the text', $this->byID( 'text-notes' )->attribute( 'value' ));

        // Further
        $this->assertEquals( 'The history of the chant', $this->byID( 'history' )->attribute( 'value' ));
        $this->assertEquals( 'The historical and liturgical significance of the chant', $this->byID( 'liturgy-culture' )->attribute( 'value' ));
    }

    public function deleteChantPost( $chantTitle ) {
        // Trash test chant
        $this->byXPath( '//div[@id="delete-action"]/descendant::a[1]' )->click();

        // Check correct web page
        $this->assertEquals( 'Chants ‹ Georgian Chant — WordPress', $this->title() );

        // Navigate to trash
        $this->byXPath( '//div[@id="wpbody-content"]/descendant::li[@class="trash"]/descendant::a[1]' )->click();

        // Make Delete Permanently visible
        $this->execute(array(
            'script' => "jQuery('.row-actions').css('visibility', 'visible');",
            'args'   => array()
        ));

        // Click Delete Permanently link
        $deleteLink = $this->byXPath( '//tbody[@id="the-list"]/descendant::strong[.="' . $chantTitle . '"]/following-sibling::div[@class="row-actions"]/descendant::a[.="Delete Permanently"]' );
        $deleteLink->click();

        // Check that no Test Chant exists
        try {
            $chantElement = $this->byXPath( '//tbody[@id="the-list"]/descendant::strong[.="' . $chantTitle . '"]' );
        } catch( PHPUnit_Extensions_Selenium2TestCase_WebDriverException $e ) {
            $this->assertEquals( PHPUnit_Extensions_Selenium2TestCase_WebDriverException::NoSuchElement, $e->getCode() );
            return;
        }

        $this->fail( 'Chant was not deleted.' );
    }

    public function testPublishChantPost() {
        $this->url( 'http://localhost/wp-admin' );

        // Check correct web page
        $this->assertEquals( 'Georgian Chant › Log In', $this->title() );

        $this->login();

        $this->navigateToPostMenuOption( 'gc_chant', 'Add New', 'Add New Chant ‹ Georgian Chant — WordPress' );

        $chantTitle = 'Test Chant ' . date( 'Y-m-d h:i:sa' );
        $this->fillOutForm( $chantTitle );

        // Scroll to top of page
        $this->execute(array(
            'script' => 'window.scrollTo(0, 0)',
            'args'   => array()
        ));

        // Publish chant post
        $this->byID( 'publish' )->click();

        $this->checkFormValues( $chantTitle );

        $this->deleteChantPost( $chantTitle );
    }
}