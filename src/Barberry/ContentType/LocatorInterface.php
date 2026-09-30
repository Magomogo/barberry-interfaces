<?php

namespace Barberry\ContentType;

use Barberry\ContentType;

interface LocatorInterface
{
    public function locate(string $path): ?ContentType;
}
