<?php

namespace Barberry\ContentType;

use Barberry\ContentType;
use Barberry\ContentTypeDetector;

class Factory
{
    /** @var ContentTypeDetector */
    private $detector;

    public function __construct(ContentTypeDetector $detector)
    {
        $this->detector = $detector;
    }

    public function byFilename(string $filename): ContentType
    {
        $contentType = ContentType::byFilename($filename);
        if ((string) $contentType !== 'application/octet-stream') {
            return $contentType;
        }

        return $this->detector->detect($filename) ?? $contentType;
    }
}
