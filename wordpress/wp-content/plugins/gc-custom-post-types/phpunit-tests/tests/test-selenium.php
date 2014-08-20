<?php
class WebTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp()
    {
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://wikipedia.org');
    }

    public function testTitle()
    {
//        // Go to wikipedia main page and test the title
//        $this->url('http://wikipedia.org/');
//        $this->assertEquals('Wikipedia', $this->title());
//
//        // Click on English encyclopedia link and wait for load
//        $link = $this->byCssSelector('a.link-box[href="//en.wikipedia.org/"]');
//        $this->assertEquals( 'English — Wikipedia — The Free Encyclopedia', $link->attribute( 'title' ));
//
//        $link->click();
//
//        // Test title again
//        $this->assertEquals('Wikipedia, the free encyclopedia', $this->title());
    }
}
