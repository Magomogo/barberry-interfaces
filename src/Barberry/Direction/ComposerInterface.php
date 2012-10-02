<?php
namespace Barberry\Direction;
use Barberry\ContentType;

interface ComposerInterface
{
    public function writeClassDeclaration(ContentType $source, ContentType $destination, $newConverterPhp,
        $newCommandPhp = null);
}
