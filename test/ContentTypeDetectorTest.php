<?php

namespace Barberry;

use Barberry\ContentType\GuesserInterface;
use PHPUnit\Framework\TestCase;

class ContentTypeDetectorTest extends TestCase
{
    public function testUsesFirstSuccessfulGuesser(): void
    {
        $first = $this->createMock(GuesserInterface::class);
        $first->expects(self::once())->method('guess')->with('sample')->willReturn(null);
        $second = $this->createMock(GuesserInterface::class);
        $second->expects(self::once())->method('guess')->with('sample')->willReturn(ContentType::csv());
        $third = $this->createMock(GuesserInterface::class);
        $third->expects(self::never())->method('guess');
        self::assertSame('text/csv', (string) (new ContentTypeDetector([$first, $second, $third]))->detect('sample'));
    }

    public function testReturnsNullWhenNothingMatches(): void
    {
        $guesser = $this->createMock(GuesserInterface::class);
        $guesser->method('guess')->willReturn(null);
        self::assertNull((new ContentTypeDetector([$guesser]))->detect('sample'));
    }
}
