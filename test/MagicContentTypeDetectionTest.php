<?php
namespace Barberry;

class MagicContentTypeDetectionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @param string $expectedContentType
     * @param string $fileName
     * @dataProvider filesAndItsContentTypes
     */
    public function testPortableDocumentFormat($expectedContentType, $fileName) {
        $this->assertEquals(
            $expectedContentType,
            ContentType::byString(file_get_contents(__DIR__ . '/data/' . $fileName))
        );
    }

    public static function filesAndItsContentTypes() {
        return array(
            array(ContentType::gif(), '1x1.gif'),
            array(ContentType::bmp(), '1x1.bmp'),
            array(ContentType::ott(), 'document1.ott'),
            array(ContentType::ots(), 'spreadsheet1.ots'),
            array(ContentType::xls(), 'spreadsheet1.xls'),
            array(ContentType::ods(), 'spreadsheet1.ods'),
            array(ContentType::doc(), 'document1.doc'),
            array(ContentType::odt(), 'document1.odt'),
            array(ContentType::pdf(), 'sample.pdf'),
            array(ContentType::url(), 'xiag.url'),
            array(ContentType::webm(), 'test.webm'),
            array(ContentType::mkv(), 'test.mkv'),
            array(ContentType::mp3(), 'm1.mp3'),
            array(ContentType::mp3(), 'm2.mp3'),
            array(ContentType::mp3(), 'm2_5.mp3'),
            array(ContentType::mp3('audio/x-wav'), 'sample.MP3'),
            array(ContentType::tiff(), '1x1.tiff'),
            array(ContentType::jpeg(), '536208.gif'),
            array(ContentType::png(), '107650.png'),
        );
    }

    public function testOgvFormat()
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

    public function testDocxFormat()
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

    public function testMsWordFormat()
    {
        if (version_compare(PHP_VERSION, '5.4.15') < 0) {
            $this->markTestSkipped('Not supported by libmagic 5.11');
        }

        $this->assertEquals(
            ContentType::doc('application/msword'),
            ContentType::byString(file_get_contents(__DIR__ . '/data/chips.doc'))
        );
    }
}
