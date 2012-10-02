<?php
namespace Barberry\Plugin;
use Barberry\Direction\ComposerInterface;

interface InterfaceInstaller {
    public function install(ComposerInterface $composer);
}
