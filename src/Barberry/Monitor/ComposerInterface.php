<?php
namespace Barberry\Monitor;

interface ComposerInterface
{
    public function writeClassDeclaration($className, $newMonitorPhp);
}
