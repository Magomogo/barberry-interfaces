<?php
namespace Barberry;

use PHPUnit\Framework\TestCase;

class MagicContentTypeDetectionTest extends TestCase
{
    /**
     * @param string $expectedContentType
     * @param string $fileName
     * @dataProvider filesAndItsContentTypes
     */
    public function testPortableDocumentFormat($expectedContentType, $fileName): void
    {
        self::assertEquals(
            $expectedContentType,
            ContentType::byString(file_get_contents(__DIR__ . '/data/' . $fileName))
        );
    }

    public static function filesAndItsContentTypes() {
        return [
            [ContentType::gif(), '1x1.gif'],
            [ContentType::bmp(), '1x1.bmp'],
            [ContentType::ott(), 'document1.ott'],
            [ContentType::ots(), 'spreadsheet1.ots'],
            [ContentType::xls(), 'spreadsheet1.xls'],
            [ContentType::ods(), 'spreadsheet1.ods'],
            [ContentType::odt(), 'document1.odt'],
            [ContentType::pdf(), 'sample.pdf'],
            [ContentType::url(), 'xiag.url'],
            [ContentType::webm(), 'test.webm'],
            [ContentType::mkv(), 'test.mkv'],
            [ContentType::mp3(), 'm1.mp3'],
            [ContentType::mp3(), 'm2.mp3'],
            [ContentType::mp3(), 'm2_5.mp3'],
            [ContentType::mp3('audio/x-wav'), 'sample.MP3'],
            [ContentType::tiff(), '1x1.tiff'],
            [ContentType::jpeg(), '536208.gif'],
            [ContentType::png(), '107650.png'],
            [ContentType::doc('application/msword'), 'chips.doc'],
            [ContentType::css(), 'styles.css'],
            [ContentType::html(), 'page.html'],
            [ContentType::xlsx(), 'spreadsheet1.xlsx'],
        ];
    }

    public function testOgvFormat(): void
    {
        $contentType = ContentType::byString(file_get_contents(__DIR__ . '/data/test.ogv'));

        $this->assertThat(
            $contentType,
            $this->logicalOr(
                $this->equalTo(ContentType::ogv('application/ogg')),
                $this->equalTo(ContentType::ogv('video/ogg'))
            )
        );
    }

    public function testDocxFormat(): void
    {
        $contentType = ContentType::byString(file_get_contents(__DIR__ . '/data/9011.docx'));

        $this->assertThat(
            $contentType,
            $this->logicalOr(
                $this->equalTo(ContentType::docx('application/vnd.openxmlformats-officedocument.wordprocessingml.document')),
                $this->equalTo(ContentType::docx('application/vnd.openxmlformats.wordprocessingml.document'))
            )
        );
    }

    public function testDocFormat(): void
    {
        $contentType = ContentType::byString(file_get_contents(__DIR__ . '/data/document1.doc'));

        $this->assertThat(
            $contentType,
            $this->logicalOr(
                $this->equalTo(ContentType::doc('application/vnd.ms-word')),
                $this->equalTo(ContentType::doc('application/msword'))
            )
        );
    }

    public function testIconFormat(): void
    {
        $contentType = ContentType::byString(file_get_contents(__DIR__ . '/data/favicon.ico'));

        $this->assertThat(
            $contentType,
            $this->logicalOr(
                $this->equalTo(ContentType::ico('image/x-icon')),
                $this->equalTo(ContentType::ico('image/vnd.microsoft.icon'))
            )
        );
    }

    public function testCDFV2Format(): void
    {
        $contentType = ContentType::byFilename(__DIR__ . '/data/excel97.xls');

        $this->assertThat(
            $contentType,
            $this->logicalOr(
                $this->equalTo(ContentType::xls('application/vnd.ms-excel')),
                $this->equalTo(ContentType::xls('application/vnd.ms-office')),
                $this->equalTo(ContentType::xls('application/CDFV2'))
            )
        );
    }
}
