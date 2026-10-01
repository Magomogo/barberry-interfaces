<?php

namespace Barberry;

use Barberry\ContentType\GuesserInterface;

class TypeDetector
{
    /** @var GuesserInterface[] */
    private $guessers;

    /**
     * @param GuesserInterface[] $guessers
     */
    public function __construct(array $guessers)
    {
        $this->guessers = $guessers;
    }

    public static function create(): self
    {
        return new self([
            new ContentType\LibmagicGuesser(),
            new ContentType\Utf16CsvGuesser(),
        ]);
    }

    public function detect(string $content): ?ContentType
    {
        foreach ($this->guessers as $guesser) {
            $guessedContentType = $guesser->guess($content);
            if ($guessedContentType !== null) {
                return $guessedContentType;
            }
        }

        return null;
    }
}
