<?php

namespace Barberry;

use Barberry\ContentType\Utf16CsvLocator;
use Barberry\ContentType\FileReaderInterface;
use PHPUnit\Framework\TestCase;

class ContentTypeDetectorTest extends TestCase
{
    public function testUsesLocatorForGenericFile(): void
    {
        $reader = $this->createMock(FileReaderInterface::class);
        $reader
            ->method('read')
            ->willReturn(iconv('UTF-8', 'UTF-16LE', "article;quantity\nTomato;2\nGarlic;4\n"));

        $detector = new ContentTypeDetector([new Utf16CsvLocator($reader)]);

        self::assertSame(
            'text/csv',
            (string) $detector->detect(ContentType::bin(), '/tmp/upload')
        );
    }
}
