<?php
namespace Barberry\Monitor;

class Composer implements ComposerInterface
{
    private $monitorDirectory;

    public function __construct($monitorDirectory)
    {
        $this->monitorDirectory = $monitorDirectory;
    }

    public function writeClassDeclaration($pluginName, $constructorPhpCode) {
        file_put_contents(
            $this->monitorDirectory . $pluginName . '.php',
            self::classCode($pluginName, $constructorPhpCode)
        );
    }

//--------------------------------------------------------------------------------------------------

    private static function classCode($pluginName, $constructorPhpCode)
    {
        return <<<PHP
<?php
namespace Barberry\Monitor;
use Barberry\Plugin\{$pluginName}\Monitor;

class {$pluginName}Monitor extends Monitor {
    public function __construct() {
        $constructorPhpCode;
    }
}
PHP;
    }
}
