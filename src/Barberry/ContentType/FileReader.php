<?php

namespace Barberry\ContentType;

class FileReader implements FileReaderInterface
{
    public function read(string $path, int $length): ?string
    {
        $handle = fopen($path, 'rb');
        if ($handle === false) {
            return null;
        }

        try {
            $content = fread($handle, $length);
        } finally {
            fclose($handle);
        }

        return $content === false ? null : $content;
    }
}
