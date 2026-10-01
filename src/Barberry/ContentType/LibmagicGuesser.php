<?php

namespace Barberry\ContentType;

use Barberry\ContentType;

class LibmagicGuesser implements GuesserInterface
{
    public function guess(string $content): ?ContentType
    {
        $mime = self::fileinfo()->buffer($content);
        if ($mime === false || $mime === 'application/octet-stream') {
            return null;
        }

        $contentType = ContentType::byMime($mime);
        try {
            $contentType->standardExtension();
        } catch (Exception $e) {
            return null;
        }

        return $contentType;
    }

    private static function fileinfo()
    {
        if (version_compare(PHP_VERSION, '8.3.0') >= 0) {
            $magic_mime_path = __DIR__ . '/magic-5.43.mime.mgc'; // https://github.com/Magomogo/barberry-magic-build
        } elseif (version_compare(PHP_VERSION, '8.1.0') >= 0) {
            $magic_mime_path = __DIR__ . '/magic-5.40.mime.mgc';
        } elseif (version_compare(PHP_VERSION, '8.0.0') >= 0) {
            $magic_mime_path = __DIR__ . '/magic-5.39.mime.mgc';
        } elseif (version_compare(PHP_VERSION, '7.4.0') >= 0) {
            $magic_mime_path = __DIR__ . '/magic-5.37.mime.mgc';
        } elseif (version_compare(PHP_VERSION, '7.3.0') >= 0) {
            $magic_mime_path = __DIR__ . '/magic-5.33.mime.mgc';
        } elseif (version_compare(PHP_VERSION, '7.2.0') >= 0) {
            $magic_mime_path = __DIR__ . '/magic-5.31.mime.mgc';
        } elseif (version_compare(PHP_VERSION, '7.0.0') >= 0) {
            $magic_mime_path = __DIR__ . '/magic-5.22.mime.mgc';
        } else {
            $magic_mime_path = __DIR__ . '/magic-5.17.mime.mgc';
        }

        return new \finfo(
            FILEINFO_MIME ^ FILEINFO_MIME_ENCODING,
            $magic_mime_path
        );
    }
}
