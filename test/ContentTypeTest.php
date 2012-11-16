<?php
namespace Barberry;

class ContentTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testIsJpegCreatedByExtension()
    {
        $this->assertEquals(
            'jpg',
            ContentType::byExtention('jpg')->standartExtention()
        );
    }

    public function testContentTypeHasStandardExtension()
    {
        ContentType::byExtention('jpg')->standartExtention();
    }

    public function testIsPhpCreatedByContentTypeString()
    {
        $this->assertEquals(
            'php',
            ContentType::byString(file_get_contents(__FILE__))->standartExtention()
        );
    }

    public function testMagicallyBecomesAString()
    {
        $this->assertEquals('image/jpeg', strval(ContentType::jpeg()));
    }

    public function testContentIsImage()
    {
        $this->assertTrue(ContentType::isImage(file_get_contents(__DIR__ . '/data/1x1.gif')));
    }

    public function testContentIsDocument()
    {
        $this->assertTrue(ContentType::isDocument(file_get_contents(__DIR__ . '/data/sample.pdf')));
    }

    public function testContentIsVideo()
    {
        $this->assertTrue(ContentType::isVideo(file_get_contents(__DIR__ . '/data/video.flv')));
    }
}
