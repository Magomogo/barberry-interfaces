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

    public function writeClassDeclaration($pluginName, $constructorPhpCode = null)
    {
        file_put_contents(
            $this->monitorDirectory . $pluginName . '.php',
            self::classCode($pluginName, $this->tempWritableDirectory, $constructorPhpCode)
        );
    }

    private static function classCode($pluginName, $tempDir, $constructorPhpCode)
    {
        $constructorPhpCode = $constructorPhpCode ? rtrim($constructorPhpCode, ';') . ';' : '';

        return <<<PHP
<?php
namespace Barberry\\Monitor;
use Barberry\\Plugin\\{$pluginName}\\Monitor;

class {$pluginName}Monitor extends Monitor {
    public function __construct() {
        $constructorPhpCode
        \$this->configure('$tempDir')
    }
}
PHP;
    }
}
