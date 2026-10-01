<?php

namespace Barberry\ContentType;

use PHPUnit\Framework\TestCase;

class LibmagicGuesserTest extends TestCase
{
    public function testRecognizesGif(): void
    {
        self::assertSame('image/gif', (string) (new LibmagicGuesser())->guess(file_get_contents(__DIR__ . '/../data/1x1.gif')));
    }

    public function testReturnsNullForUnsupportedMime(): void
    {
        self::assertNull((new LibmagicGuesser())->guess(''));
    }

    public function testReturnsNullForUnrecognizedContent(): void
    {
        self::assertNull((new LibmagicGuesser())->guess(str_repeat("\0\x01", 100)));
    }
}
