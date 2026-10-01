<?php

namespace Barberry;

use Barberry\ContentType\Utf16CsvGuesser;
use Barberry\ContentType\FileReaderInterface;
use PHPUnit\Framework\TestCase;

class ContentTypeDetectorTest extends TestCase
{
    public function testUsesGuesserForGenericFile(): void
    {
        $reader = $this->createMock(FileReaderInterface::class);
        $reader
            ->method('read')
            ->willReturn(iconv('UTF-8', 'UTF-16LE', "article;quantity\nTomato;2\nGarlic;4\n"));

        $detector = new ContentTypeDetector([new Utf16CsvGuesser($reader)]);

        self::assertSame(
            'text/csv',
            (string) $detector->detect('/tmp/upload')
        );
    }
}
