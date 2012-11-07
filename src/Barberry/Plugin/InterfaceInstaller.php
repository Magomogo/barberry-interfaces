<?php
namespace Barberry\Plugin;
use Barberry\Direction;
use Barberry\Monitor;

interface InterfaceInstaller
{
    /**
     * @param Direction\ComposerInterface $directionComposer
     * @param Monitor\ComposerInterface $monitorComposer
     * @param array $pluginParams
     * @return void
     */
    public function install(Direction\ComposerInterface $directionComposer, Monitor\ComposerInterface $monitorComposer,
        $pluginParams = array());
}
