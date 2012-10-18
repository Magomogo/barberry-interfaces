<?php
namespace Barberry\Monitor;

interface ComposerInterface
{
    public function writeClassDeclaration($pluginName, $constructorPhpCode);
}
