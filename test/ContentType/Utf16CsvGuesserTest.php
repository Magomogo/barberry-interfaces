<?php

namespace Barberry\ContentType;

use PHPUnit\Framework\TestCase;

class Utf16CsvGuesserTest extends TestCase
{
    /** @dataProvider encodings */
    public function testGuessesUtf16Csv(string $encoding, string $bom): void
    {
        $content = $bom . iconv('UTF-8', $encoding, "article;quantity\nTomato;2\nGarlic;4\n");
        self::assertSame('text/csv', (string) (new Utf16CsvGuesser())->guess($content));
    }

    public function encodings(): array
    {
        return [['UTF-16LE', ''], ['UTF-16BE', ''], ['UTF-16LE', "\xFF\xFE"], ['UTF-16BE', "\xFE\xFF"]];
    }

    public function testDoesNotGuessNonCsv(): void
    {
        self::assertNull((new Utf16CsvGuesser())->guess(iconv('UTF-8', 'UTF-16LE', "just some text\nmore text\n")));
    }
}
