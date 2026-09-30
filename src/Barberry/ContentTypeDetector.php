<?php

namespace Barberry;

use Barberry\ContentType\LocatorInterface;

class ContentTypeDetector
{
    /** @var LocatorInterface[] */
    private $locators;

    /**
     * @param LocatorInterface[] $locators
     */
    public function __construct(array $locators)
    {
        $this->locators = $locators;
    }

    public function detect(ContentType $contentType, string $path): ContentType
    {
        foreach ($this->locators as $locator) {
            $detectedContentType = $locator->locate($path);
            if ($detectedContentType !== null) {
                return $detectedContentType;
            }
        }

        return $contentType;
    }
}
