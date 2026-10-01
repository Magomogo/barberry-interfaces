<?php

namespace Barberry;

use Barberry\ContentType\GuesserInterface;
use PHPUnit\Framework\TestCase;

class TypeDetectorTest extends TestCase
{
    public function testDefaultDetectorRecognizesKnownContent(): void
    {
        self::assertSame('image/gif', (string) TypeDetector::create()->detect(file_get_contents(__DIR__ . '/data/1x1.gif')));
    }

    public function testDefaultDetectorDoesNotRecognizeBinary(): void
    {
        self::assertNull(TypeDetector::create()->detect(str_repeat("\0\x01", 100)));
    }

    public function testUsesFirstSuccessfulGuesser(): void
    {
        $first = $this->createMock(GuesserInterface::class);
        $first->expects(self::once())->method('guess')->with('sample')->willReturn(null);
        $second = $this->createMock(GuesserInterface::class);
        $second->expects(self::once())->method('guess')->with('sample')->willReturn(ContentType::csv());
        $third = $this->createMock(GuesserInterface::class);
        $third->expects(self::never())->method('guess');
        self::assertSame('text/csv', (string) (new TypeDetector([$first, $second, $third]))->detect('sample'));
    }

    public function testReturnsNullWhenNothingMatches(): void
    {
        $guesser = $this->createMock(GuesserInterface::class);
        $guesser->method('guess')->willReturn(null);
        self::assertNull((new TypeDetector([$guesser]))->detect('sample'));
    }
}
