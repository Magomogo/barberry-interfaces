<?php

namespace Barberry;

/**
 * Class ContentType
 *
 * @method string gif($mime = '') static
 * @method string bmp($mime = '') static
 * @method string json($mime = '') static
 * @method string mkv($mime = '') static
 * @method string mp3($mime = '') static
 * @method string ogv($mime = '') static
 * @method string ots($mime = '') static
 * @method string ott($mime = '') static
 * @method string ods($mime = '') static
 * @method string doc($mime = '') static
 * @method string docx($mime = '') static
 * @method string odt($mime = '') static
 * @method string pdf($mime = '') static
 * @method string url($mime = '') static
 * @method string webm($mime = '') static
 * @method string xls($mime = '') static
 * @method string xlsx($mime = '') static
 * @method string tiff($mime = '') static
 * @method string jpeg($mime = '') static
 * @method string png($mime = '') static
 * @method string ico($mime = '') static
 * @method string css($mime = '') static
 * @method string html($mime = '') static
 *
 * @package Barberry
 */
class ContentType
{
    private static $extensionMap = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'tiff' => 'image/tiff',
        'png' => 'image/png',
        'flv' => 'video/x-flv',
        'webm' => 'video/webm',
        'wmv' => 'video/x-ms-wmv',
        'mpg' => 'video/mpeg',
        'mpeg' => 'video/mpeg',
        'avi' => 'video/x-msvideo',
        'mkv' => 'video/x-matroska',
        'mp4' => 'video/mp4',
        'mov' => 'video/quicktime',
        'qt' => 'video/quicktime',
        'ogv' => ['application/ogg', 'video/ogg'],
        '3gp' => 'video/3gpp',
        '_3gp' => 'video/3gpp',
        'json' => 'application/json',
        'php' => 'text/x-php',
        'ott' => 'application/vnd.oasis.opendocument.text-template',
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ots' => 'application/vnd.oasis.opendocument.spreadsheet-template',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        'txt' => 'text/plain',
        'xls' => ['application/vnd.ms-excel', 'application/vnd.ms-office', 'application/CDFV2'],
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'doc' => ['application/vnd.ms-word', 'application/msword'],
        'docx' => [
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats.wordprocessingml.document'
        ],
        'pdf' => 'application/pdf',
        'url' => 'text/url',
        'mp3' => ['audio/mpeg', 'audio/x-mpeg', 'audio/mpeg3', 'audio/x-mpeg-3', 'audio/wav', 'audio/x-wav'],
        'bmp' => ['image/bmp', 'image/x-ms-bmp'],
        'ico' => ['image/x-icon', 'image/vnd.microsoft.icon'],
        'css' => 'text/css',
        'html' => 'text/html',
        'nws' => 'message/news',
        'bin' => 'application/octet-stream'
    ];

    private $contentTypeString;

    public static function __callStatic($method, $args)
    {
        $mime = self::$extensionMap[$method];
        if (isset($mime)) {
            if (!empty($args) && is_array($mime)) {
                return self::byExtension($method, (string) array_shift($args));
            }
            return self::byExtension($method);
        }

        throw new \Exception("Undefined method " . static::class . "::{$method}() called.");
    }

    public static function byExtension($ext, $mime = '')
    {
        if (isset(self::$extensionMap[$ext])) {
            $map = (array) self::$extensionMap[$ext];
            if (empty($mime)) {
                $mime = array_shift($map);
            } elseif (!in_array($mime, $map)) {
                throw new ContentType\Exception($ext);
            }
            return new self($mime);
        }
        throw new ContentType\Exception($ext);
    }

    public static function byExtention($ext, $mime = '')
    {
        return self::byExtension($ext, $mime);
    }

    /**
     * @param string $content
     * @return ContentType
     * @throws ContentType\Exception
     */
    public static function byString($content)
    {
        return self::buildForType(
            self::contentTypeByString($content)
        );
    }

    /**
     * @param string $filename
     * @return ContentType
     * @throws ContentType\Exception
     */
    public static function byFilename($filename)
    {
        return self::buildForType(
            self::contentTypeByFilename($filename)
        );
    }

    /**
     * @param string $contentType
     * @return ContentType
     * @throws ContentType\Exception
     */
    private static function buildForType($contentType)
    {
        $ext = self::getExtensionByContentType($contentType);

        if ($ext !== false) {
            return new self($contentType);
        }
        throw new ContentType\Exception($contentType);
    }

    private static function getExtensionByContentType($contentType)
    {
        foreach (self::$extensionMap as $ext => $mime) {
            if (in_array($contentType, (array) $mime)) {
                return $ext;
            }
        }
        return false;
    }

    private function __construct($contentTypeString)
    {
        $this->contentTypeString = $contentTypeString;
    }

    public function standardExtension()
    {
        foreach (self::$extensionMap as $ext => $contentTypeStringArray) {
            if (in_array($this->contentTypeString, (array) $contentTypeStringArray)) {
                return $ext;
            }
        }
        throw new ContentType\Exception($this->contentTypeString);
    }

    public function __toString()
    {
        return $this->contentTypeString;
    }

    private static function contentTypeByString($content)
    {
        return self::fileinfo()->buffer($content);
    }

    private static function contentTypeByFilename($filename)
    {
        return self::fileinfo()->file($filename);
    }

    private static function fileinfo()
    {
        if (version_compare(PHP_VERSION, '8.3.0') >= 0) {
            $magic_mime_path = __DIR__ . '/ContentType/magic-5.43.mime.mgc'; // https://github.com/Magomogo/barberry-magic-build
        } elseif (version_compare(PHP_VERSION, '8.1.0') >= 0) {
            $magic_mime_path = __DIR__ . '/ContentType/magic-5.40.mime.mgc';
        } elseif (version_compare(PHP_VERSION, '8.0.0') >= 0) {
            $magic_mime_path = __DIR__ . '/ContentType/magic-5.39.mime.mgc';
        } elseif (version_compare(PHP_VERSION, '7.4.0') >= 0) {
            $magic_mime_path = __DIR__ . '/ContentType/magic-5.37.mime.mgc';
        } elseif (version_compare(PHP_VERSION, '7.3.0') >= 0) {
            $magic_mime_path = __DIR__ . '/ContentType/magic-5.33.mime.mgc';
        } elseif (version_compare(PHP_VERSION, '7.2.0') >= 0) {
            $magic_mime_path = __DIR__ . '/ContentType/magic-5.31.mime.mgc';
        } elseif (version_compare(PHP_VERSION, '7.0.0') >= 0) {
            $magic_mime_path = __DIR__ . '/ContentType/magic-5.22.mime.mgc';
        } else {
            $magic_mime_path = __DIR__ . '/ContentType/magic-5.17.mime.mgc';
        }

        return new \finfo(
            FILEINFO_MIME ^ FILEINFO_MIME_ENCODING,
            $magic_mime_path
        );
    }

    public static function byMime(string $mime): self
    {
        return new self($mime);
    }
}
