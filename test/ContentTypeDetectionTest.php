<?php

namespace Barberry;

use PHPUnit\Framework\TestCase;

class ContentTypeDetectionTest extends TestCase
{
    public function testDetectsUtf16CsvByFilenameAndString(): void
    {
        $content = iconv('UTF-8', 'UTF-16LE', "article;quantity\nTomato;2\nGarlic;4\n");
        $path = tempnam(sys_get_temp_dir(), 'content-type-');
        file_put_contents($path, $content);

        try {
            self::assertSame('text/csv', (string) ContentType::byFilename($path));
            self::assertSame('text/csv', (string) ContentType::byString($content));
        } finally {
            unlink($path);
        }
    }

    public function testUnknownBinaryKeepsItsOriginalType(): void
    {
        self::assertSame('application/octet-stream', (string) ContentType::byString(str_repeat("\0\x01", 100)));
    }
}
