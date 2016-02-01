<?php
namespace Barberry;

use Barberry\ContentType\Exception;
use Barberry\ContentType\GetMimeInfoException;
use finfo;

/**
 * Class ContentType
 *
 * @method string gif() static
 * @method string json() static
 * @method string mkv() static
 * @method string mp3() static
 * @method string ogv() static
 * @method string ots() static
 * @method string ott() static
 * @method string ods() static
 * @method string doc() static
 * @method string odt() static
 * @method string pdf() static
 * @method string url() static
 * @method string webm() static
 * @method string xls() static
 *
 * @package Barberry
 */
class ContentType
{
    private static $extensionMap = array(
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
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
        'ogv' => 'application/ogg',
        '3gp' => 'video/3gpp',
        '_3gp' => 'video/3gpp',
        'json' => 'application/json',
        'php' => 'text/x-php',
        'ott' => 'application/vnd.oasis.opendocument.text-template',
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ots' => 'application/vnd.oasis.opendocument.spreadsheet-template',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        'txt' => 'text/plain',
        'xls' => 'application/vnd.ms-excel',
        'doc' => 'application/vnd.ms-word',
        'pdf' => 'application/pdf',
        'url' => 'text/url',
        'mp3' => 'audio/mpeg',
    );

    private $contentTypeString;

    public static function __callStatic($method, $args)
    {
        if (isset(self::$extensionMap[$method])) {
            return self::byExtension($method);
        }

        throw new \Exception("Undefined method " . get_called_class() . "::{$method}() called.");
    }

    public static function byExtension($ext)
    {
        if (isset(self::$extensionMap[$ext])) {
            return new self(self::$extensionMap[$ext]);
        }
        throw new ContentType\Exception($ext);
    }

    public static function byExtention($ext)
    {
        return self::byExtension($ext);
    }

    /**
     * @param $content
     * @return ContentType
     * @throws ContentType\Exception
     */
    public static function byString($content)
    {
        $contentTypeString = self::contentTypeString($content);
        $ext = array_search($contentTypeString, self::$extensionMap);

        if (false !== $ext) {
            return self::byExtension($ext);
        }
        throw new ContentType\Exception($contentTypeString);
    }

    /**
     * @param string $file file path
     * @return string
     * @throws GetMimeInfoException
     * @throws Exception
     */
    public static function byFile($file)
    {
        $contentType = self::contentTypeFile($file);
        if ($contentType === false) {
            $error = error_get_last();
            throw new GetMimeInfoException($error['message']);
        }

        $ext = array_search($contentType, self::$extensionMap);
        if (false !== $ext) {
            return self::byExtension($ext);
        }
        throw new Exception($contentType);
    }

    private function __construct($contentTypeString)
    {
        $this->contentTypeString = $contentTypeString;
    }

    public function standardExtension()
    {
        foreach (self::$extensionMap as $ext => $contentTypeStringArray) {
            if ($this->contentTypeString === $contentTypeStringArray) {
                return $ext;
            }
        }
        throw new ContentType\Exception($this->contentTypeString);
    }

    public function __toString()
    {
        return $this->contentTypeString;
    }

    private static function contentTypeString($content)
    {
        return self::finfo()->buffer($content);
    }

    private static function contentTypeFile($file)
    {
         return self::finfo()->file($file);
    }

    private static function finfo()
    {
        return new finfo(FILEINFO_MIME_TYPE, self::magic());
    }

    private static function magic()
    {
        if (version_compare(PHP_VERSION, '5.6.0') >= 0) {
            $magicMimePath = __DIR__ . '/ContentType/v4-magic.mime.mgc';
        } elseif (version_compare(PHP_VERSION, '5.4.15') >= 0) {
            $magicMimePath = __DIR__ . '/ContentType/v3-magic.mime.mgc';
        } elseif (version_compare(PHP_VERSION, '5.3.11') >= 0) {
            $magicMimePath = __DIR__ . '/ContentType/v2-magic.mime.mgc';
        } else {
            $magicMimePath = __DIR__ . '/ContentType/magic.mime.mgc';
        }
        return $magicMimePath;
    }
}
