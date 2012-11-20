<?php
namespace Barberry\Exception;

class ConversionNotPossible extends \Exception
{
    public function __construct($reason)
    {
        parent::__construct("Conversion is not possible: " . $reason);
    }

}
