<?php
namespace Barberry\Plugin;
use Barberry\Direction;
use Barberry\Monitor;

interface InterfaceInstaller {
    public function install(Direction\ComposerInterface $directionComposer, Monitor\ComposerInterface $monitorComposer,
        $pluginParams = array());
}
