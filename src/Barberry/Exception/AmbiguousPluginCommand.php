<?php
namespace Barberry\Exception;

class AmbiguousPluginCommand extends \Exception {
    public function __construct($commandString) {
        parent::__construct("Malformed command string: " . $commandString);
    }
}