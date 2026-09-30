<?php

namespace Barberry\ContentType;

interface FileReaderInterface
{
    public function read(string $path, int $length): ?string;
}
