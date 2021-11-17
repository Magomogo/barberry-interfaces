<?php

namespace Barberry;

class ContentTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testThrowsWhenExceptionIsNotKnown()
    {
        $this->setExpectedException('Barberry\ContentType\Exception');
        ContentType::byExtension('boo');
    }

    public function testIsJpegCreatedByExtension()
    {
        $this->assertEquals(
            'jpg',
            ContentType::byExtension('jpg')->standardExtension()
        );
    }

    public function testContentTypeHasStandardExtension()
    {
        ContentType::byExtension('jpg')->standardExtension();
    }

    public function testIsPhpCreatedByContentTypeString()
    {
        $this->assertEquals(
            'php',
            ContentType::byString(file_get_contents(__FILE__))->standardExtension()
        );
    }

    public function testMagicallyBecomesAString()
    {
        $this->assertEquals('image/jpeg', (string) ContentType::jpeg());
    }

    public function testConcreteMime()
    {
        $this->assertEquals('audio/x-wav', (string) ContentType::byString(file_get_contents(__DIR__ . '/data/sample.MP3')));
    }

    public function testTakesFirstWhenThereAreSeveralContentTypesPossible()
    {
        $this->assertSame('image/x-icon', (string) ContentType::ico());
    }

    public function testSpecialContentTypeIsPossible()
    {
        $this->assertSame('image/vnd.microsoft.icon', (string) ContentType::ico('image/vnd.microsoft.icon'));
    }

    public function testAcceptContentConsideredAsMessageNews()
    {
        $this->assertEquals(
            'nws',
            ContentType::byString("Article_Number\tPrice\n1000.1\t99.90")->standardExtension()
        );
    }

    /**
     * @dataProvider contentTypeByFilenames
     */
    public function testContentTypeByFilename($filename, $type)
    {
        $this->assertEquals($type, (string) ContentType::byFilename(__DIR__ . '/data/' . $filename));
    }

    public static function contentTypeByFilenames()
    {
        return [
            ['1x1.bmp', 'image/x-ms-bmp'],
            ['107650.png', 'image/png'],
            ['document1.doc', 'application/msword'],
            ['document1.ott', 'application/vnd.oasis.opendocument.text-template'],
            ['m1.mp3', 'audio/mpeg'],
            ['sample.pdf', 'application/pdf'],
            ['page.html', 'text/html'],
            ['spreadsheet1.ods', 'application/vnd.oasis.opendocument.spreadsheet'],
            ['spreadsheet1.xls', 'application/vnd.ms-excel'],
            ['styles.css', 'text/css']
        ];
    }
}
