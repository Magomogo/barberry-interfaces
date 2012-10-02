<?php
namespace Barberry\Plugin;
use Barberry\Plugin\InterfaceCommand;

interface InterfaceConverter {
    public function convert($bin, InterfaceCommand $command = null);
}
