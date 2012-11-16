<?php
namespace Barberry;

class ContentType
{
    private $contentTypeString;

    private static $imageExtensions = array(
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'png' => 'image/png'
    );

    private static $videoExtensions = array(
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
        '3gp' => 'video/3gpp'
    );

    private static $documentExtensions = array(
        'ott' => 'application/vnd.oasis.opendocument.text-template',
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ots' => 'application/vnd.oasis.opendocument.spreadsheet-template',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        'xls' => 'application/vnd.ms-excel',
        'doc' => 'application/vnd.ms-word',
        'pdf' => 'application/pdf'
    );

    private static $textExtensions = array(
        'json' => 'application/json',
        'php' => 'text/x-php',
        'txt' => 'text/plain',
        'url' => 'text/url'
    );

    private function __construct($contentTypeString)
    {
        $this->contentTypeString = $contentTypeString;
    }

    public function __toString()
    {
        return $this->contentTypeString;
    }

    public static function __callStatic($method, $args)
    {
        if (self::getContentTypeByExtension($method)) {
            return self::byExtention($method);
        }
        throw new \Exception("Undefined method " . get_called_class() . "->{$method}() called.");
    }

    public static function availableExtensions()
    {
        return array_merge(
            self::$imageExtensions, self::$videoExtensions, self::$documentExtensions, self::$textExtensions
        );
    }

    public static function getContentTypeByExtension($ext)
    {
        $extensions = self::availableExtensions();
        return isset($extensions[$ext]) ? $extensions[$ext] : null;
    }

    public static function byExtention($ext)
    {
        if (self::getContentTypeByExtension($ext)) {
            return new self(self::getContentTypeByExtension($ext));
        }
        throw new ContentType\Exception($ext);
    }

    public static function byString($content)
    {
        $contentTypeString = self::contentTypeString($content);

        $ext = array_search($contentTypeString, self::availableExtensions());
        if ($ext) {
            return self::byExtention($ext);
        }
        throw new ContentType\Exception($contentTypeString);
    }

    public function standartExtention()
    {
        foreach (self::availableExtensions() as $ext => $contentTypeStringArray) {
            if ($this->contentTypeString === $contentTypeStringArray) {
                return $ext;
            }
        }
        throw new ContentType\Exception($this->contentTypeString);
    }

    public static function isImage($fileContent)
    {
        $contentMatch = array_search(
            self::contentTypeString($fileContent), self::$imageExtensions
        );
        return $contentMatch ? true : false;
    }

    public static function isVideo($fileContent)
    {
        $contentMatch = array_search(
            self::contentTypeString($fileContent), self::$videoExtensions
        );
        return $contentMatch ? true : false;
    }

    public static function isDocument($fileContent)
    {
        $contentMatch = array_search(
            self::contentTypeString($fileContent), self::$documentExtensions
        );
        return $contentMatch ? true : false;
    }

    public static function isText($fileContent)
    {
        $contentMatch = array_search(
            self::contentTypeString($fileContent), self::$textExtensions
        );
        return $contentMatch ? true : false;
    }

    private static function contentTypeString($content)
    {
        if (version_compare(PHP_VERSION, '5.3.11') >= 0) {
            $magic_mime_path = __DIR__ . '/ContentType/v2-magic.mime.mgc';
        } else {
            $magic_mime_path = __DIR__ . '/ContentType/magic.mime.mgc';
        }
        $finfo = new \finfo(
            FILEINFO_MIME ^ FILEINFO_MIME_ENCODING,
            $magic_mime_path
        );
        return $finfo->buffer($content);
    }
}
