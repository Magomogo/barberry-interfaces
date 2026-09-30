<?php

namespace Barberry;

use Barberry\ContentType\FileReader;
use Barberry\ContentType\LocatorInterface;
use Barberry\ContentType\Utf16CsvLocator;

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

    public static function detectFile(ContentType $contentType, string $path): ContentType
    {
        return (new self([
            new Utf16CsvLocator(new FileReader()),
        ]))->detect($contentType, $path);
    }

    public function detect(ContentType $contentType, string $path): ContentType
    {
        if ((string) $contentType !== 'application/octet-stream') {
            return $contentType;
        }

        foreach ($this->locators as $locator) {
            $detectedContentType = $locator->locate($path);
            if ($detectedContentType !== null) {
                return $detectedContentType;
            }
        }

        return $contentType;
    }
}
