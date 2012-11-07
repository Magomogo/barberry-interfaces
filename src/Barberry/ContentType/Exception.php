<?php
namespace Barberry\ContentType;

class Exception extends \Exception
{

    public function __construct($contentType)
    {
        parent::__construct('Unknown content type ' . $contentType);
    }
}
