<?php

namespace Barberry;

use Barberry\ContentType\GuesserInterface;
use Barberry\ContentType\Utf16CsvGuesser;
use PHPUnit\Framework\TestCase;

class ContentTypeDetectionTest extends TestCase
{
    public function testDetectsUtf16CsvByFilenameAndString(): void
    {
        $content = iconv('UTF-8', 'UTF-16LE', "article;quantity\nTomato;2\nGarlic;4\n");
        $detector = new ContentTypeDetector([new Utf16CsvGuesser()]);
        $path = tempnam(sys_get_temp_dir(), 'content-type-');
        file_put_contents($path, $content);

        try {
            self::assertSame('text/csv', (string) ContentType::byFilename($path, $detector));
            self::assertSame('text/csv', (string) ContentType::byString($content, $detector));
        } finally {
            unlink($path);
        }
    }

    public function testKnownTypeDoesNotInvokeGuessers(): void
    {
        $guesser = $this->createMock(GuesserInterface::class);
        $guesser->expects(self::never())->method('guess');
        self::assertSame('php', ContentType::byFilename(__FILE__, new ContentTypeDetector([$guesser]))->standardExtension());
        self::assertSame('php', ContentType::byString(file_get_contents(__FILE__), new ContentTypeDetector([$guesser]))->standardExtension());
    }

    public function testUnknownBinaryKeepsItsOriginalType(): void
    {
        self::assertSame('application/octet-stream', (string) ContentType::byString(str_repeat("\0\x01", 100), new ContentTypeDetector([])));
    }
}
