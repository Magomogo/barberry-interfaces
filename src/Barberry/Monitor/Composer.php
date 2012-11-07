<?php
namespace Barberry\Monitor;

class Composer implements ComposerInterface
{
    private $monitorDirectory;
    private $tempWritableDirectory;

    public function __construct($monitorDirectory, $tempWritableDirectory)
    {
        $this->monitorDirectory = $monitorDirectory;
        $this->tempWritableDirectory = $tempWritableDirectory;
    }

    public function writeClassDeclaration($pluginName, $constructorPhpCode)
    {
        file_put_contents(
            $this->monitorDirectory . $pluginName . '.php',
            self::classCode($pluginName, $constructorPhpCode, $this->tempWritableDirectory)
        );
    }

    private static function classCode($pluginName, $constructorPhpCode, $tempDir)
    {
        return <<<PHP
<?php
namespace Barberry\\Monitor;
use Barberry\\Plugin\\{$pluginName}\\Monitor;

class {$pluginName}Monitor extends Monitor {
    public function __construct() {
        $constructorPhpCode;
        \$this->configure($tempDir)
    }
}
PHP;
    }
}
