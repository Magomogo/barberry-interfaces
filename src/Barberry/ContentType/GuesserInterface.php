<?php

namespace Barberry\ContentType;

use Barberry\ContentType;

interface GuesserInterface
{
    public function guess(string $content): ?ContentType;
}
