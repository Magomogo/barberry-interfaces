<?php
namespace Barberry\Direction;

use Barberry\ContentType;

class Composer implements ComposerInterface
{
    private $directionDirectory;
    private $tempWritableDirectory;

    public function __construct($directionDirectory, $tempWritableDirectory)
    {
        $this->directionDirectory = $directionDirectory;
        $this->tempWritableDirectory = $tempWritableDirectory;
    }

    public function writeClassDeclaration(ContentType $source, ContentType $destination, $newConverterPhp,
        $newCommandPhp = null)
    {
        file_put_contents(
            $this->directionDirectory . self::directionName($source, $destination) . '.php',
            self::classCode(
                self::directionName($source, $destination),
                $newConverterPhp,
                $destination,
                $this->tempWritableDirectory,
                $newCommandPhp
            )
        );
    }

    private static function directionName(ContentType $source, ContentType $destination)
    {
        return ucfirst($source->standardExtension())
            . 'To' . ucfirst($destination->standardExtension());
    }

    private static function classCode($className, $newConverterPhp, ContentType $destinationContentType, $tempDirectory,
        $newCommandPhp = null)
    {
        $commandInitialization = null;
        if (!is_null($newCommandPhp)) {
            $newCommandPhp = rtrim($newCommandPhp, ';') . ';';
            $commandInitialization = <<<PHP
\$this->command = $newCommandPhp
        \$this->command->configure(\$commandString);
        if (!\$this->command->conforms(\$commandString)) {
            throw new Exception\AmbiguousPluginCommand(\$commandString);
        }
PHP;
        }

        $converterInitialization = rtrim($newConverterPhp, ';');
        $contentTypeConstructor = "ContentType::byExtention('{$destinationContentType->standardExtension()}')";

        return <<<PHP
<?php
namespace Barberry\Direction;
use Barberry;
use Barberry\Exception;
use Barberry\Plugin;
use Barberry\ContentType;

class Direction{$className} extends DirectionAbstract {
    protected function init(\$commandString = null) {
        \$this->converter = $converterInitialization;
        \$this->converter->configure($contentTypeConstructor, '$tempDirectory');
        $commandInitialization
    }
}
PHP;
    }
}
