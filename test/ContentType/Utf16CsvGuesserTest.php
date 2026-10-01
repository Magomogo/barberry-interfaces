<?php

namespace Barberry\ContentType;

use PHPUnit\Framework\TestCase;

class Utf16CsvGuesserTest extends TestCase
{
    public function testGuessesUtf16Csv(): void
    {
        $reader = $this->createMock(FileReaderInterface::class);
        $reader
            ->expects(self::once())
            ->method('read')
            ->with('/tmp/upload', 65536)
            ->willReturn(iconv('UTF-8', 'UTF-16LE', "article;quantity\nTomato;2\nGarlic;4\n"));

        self::assertSame('text/csv', (string) (new Utf16CsvGuesser($reader))->guess('/tmp/upload'));
    }
}
