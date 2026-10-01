<?php

namespace Barberry;

use Barberry\ContentType\GuesserInterface;

class ContentTypeDetector
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
