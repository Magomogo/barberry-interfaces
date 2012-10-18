<?php
namespace Barberry\Monitor;

class Composer implements ComposerInterface
{
    private $monitorDirectory;

    public function __construct($monitorDirectory)
    {
        $this->monitorDirectory = $monitorDirectory;
    }

    public function writeClassDeclaration($className, $newMonitorPhp) {
        file_put_contents(
            $this->monitorDirectory . $className . '.php',
            self::classCode($className, $newMonitorPhp)
        );
    }

//--------------------------------------------------------------------------------------------------

    private static function classCode($className, $newMonitorPhp)
    {
        return <<<PHP
<?php
namespace Barberry\Monitor;
use Barberry\Plugin;

class {$className}Monitor {
    protected function __construct() {
        $newMonitorPhp;
    }
}
PHP;
    }
}
