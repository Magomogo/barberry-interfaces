<?php

namespace Barberry\ContentType;

class FileReader implements FileReaderInterface
{
    public function read(string $path, int $length): ?string
    {
        $content = file_get_contents($path, false, null, 0, $length);

        return $content === false ? null : $content;
    }
}
