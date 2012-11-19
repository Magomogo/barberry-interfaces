<?php
namespace Barberry;

class ContentTypeTest extends \PHPUnit_Framework_TestCase {

    public function testIsJpegCreatedByExtension() {
        $this->assertEquals(
            'jpg',
            ContentType::byExtention('jpg')->standardExtension()
        );
    }

    public function testContentTypeHasStandardExtension() {
        ContentType::byExtention('jpg')->standardExtension();
    }

    public function testIsPhpCreatedByContentTypeString() {
        $this->assertEquals(
            'php',
            ContentType::byString(file_get_contents(__FILE__))->standardExtension()
        );
    }

    public function testMagicallyBecomesAString() {
        $this->assertEquals('image/jpeg', strval(ContentType::jpeg()));
    }
}