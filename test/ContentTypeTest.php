<?php
namespace Barberry;

class ContentTypeTest extends \PHPUnit_Framework_TestCase {

    public function testIsJpegCreatedByExtension() {
        $this->assertEquals(
            'jpg',
            ContentType::byExtension('jpg')->standardExtension()
        );
    }

    public function testContentTypeHasStandardExtension() {
        ContentType::byExtension('jpg')->standardExtension();
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

    public function testConcreteMime()
    {
        $this->assertEquals('audio/x-wav', (string) ContentType::byString(file_get_contents(__DIR__ . '/data/sample.MP3')));
    }
}