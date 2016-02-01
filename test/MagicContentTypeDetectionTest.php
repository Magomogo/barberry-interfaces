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

    /**
     * @param string $expectedContentType
     * @param string $fileName
     * @dataProvider filesAndItsContentTypes
     */
    public function testPortableDocumentFormatByFile($expectedContentType, $fileName) {
        $this->assertEquals($expectedContentType, ContentType::byFile(__DIR__ . '/data/' . $fileName));
    }

    public static function filesAndItsContentTypes() {
        return array(
            array(ContentType::gif(), '1x1.gif'),
            array(ContentType::ott(), 'document1.ott'),
            array(ContentType::ots(), 'spreadsheet1.ots'),
            array(ContentType::xls(), 'spreadsheet1.xls'),
            array(ContentType::ods(), 'spreadsheet1.ods'),
            array(ContentType::doc(), 'document1.doc'),
            array(ContentType::odt(), 'document1.odt'),
            array(ContentType::pdf(), 'sample.pdf'),
            array(ContentType::url(), 'xiag.url'),
            array(ContentType::ogv(), 'test.ogv'),
            array(ContentType::webm(), 'test.webm'),
            array(ContentType::mkv(), 'test.mkv'),
            array(ContentType::mp3(), 'm1.mp3'),
            array(ContentType::mp3(), 'm2.mp3'),
            array(ContentType::mp3(), 'm2_5.mp3'),
        );
    }
}
