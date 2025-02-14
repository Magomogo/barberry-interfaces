<?php

namespace Barberry;

use PHPUnit\Framework\TestCase;

class ContentTypeTest extends TestCase
{
    public function testThrowsWhenExceptionIsNotKnown(): void
    {
        $this->expectException(ContentType\Exception::class);
        ContentType::byExtension('boo');
    }

    public function testIsJpegCreatedByExtension(): void
    {
        self::assertEquals(
            'jpg',
            ContentType::byExtension('jpg')->standardExtension()
        );
    }

    public function testContentTypeHasStandardExtension(): void
    {
        self::assertEquals('jpg', ContentType::byExtension('jpg')->standardExtension());
    }

    public function testIsPhpCreatedByContentTypeString(): void
    {
        self::assertEquals(
            'php',
            ContentType::byString(file_get_contents(__FILE__))->standardExtension()
        );
    }

    public function testMagicallyBecomesAString(): void
    {
        self::assertEquals('image/jpeg', (string) ContentType::jpeg());
    }

    public function testConcreteMime(): void
    {
        self::assertEquals('audio/x-wav', (string) ContentType::byString(file_get_contents(__DIR__ . '/data/sample.MP3')));
    }

    public function testTakesFirstWhenThereAreSeveralContentTypesPossible(): void
    {
        self::assertSame('image/x-icon', (string) ContentType::ico());
    }

    public function testSpecialContentTypeIsPossible(): void
    {
        self::assertSame('image/vnd.microsoft.icon', (string) ContentType::ico('image/vnd.microsoft.icon'));
    }

    public function testAcceptContentConsideredAsMessageNews(): void
    {
        self::assertEquals(
            'nws',
            ContentType::byString("Article_Number\tPrice\n1000.1\t99.90")->standardExtension()
        );
    }

    /**
     * @dataProvider contentTypeByFilenames
     */
    public function testContentTypeByFilename($filename, $type): void
    {
        if (is_array($type)) {
            self::assertContains((string)ContentType::byFilename(__DIR__ . '/data/' . $filename), $type);
            return;
        }
        self::assertEquals($type, (string) ContentType::byFilename(__DIR__ . '/data/' . $filename));
    }

    public static function contentTypeByFilenames(): array
    {
        return [
            ['1x1.bmp', ['image/x-ms-bmp','image/bmp']],
            ['107650.png', 'image/png'],
            ['document1.doc', 'application/msword'],
            ['document1.ott', 'application/vnd.oasis.opendocument.text-template'],
            ['m1.mp3', 'audio/mpeg'],
            ['sample.pdf', 'application/pdf'],
            ['page.html', 'text/html'],
            ['spreadsheet1.ods', 'application/vnd.oasis.opendocument.spreadsheet'],
            ['styles.css', ['text/css', 'text/plain']],
            ['sample.bin', 'application/octet-stream']
        ];
    }

    public function testCDFV2FilesGetsRecognisedAsExcel(): void
    {
        self::assertEquals('xls', ContentType::byFilename(__DIR__ . '/data/excel97.xls')->standardExtension());
    }

}
