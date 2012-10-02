<?php
namespace Barberry\Plugin;

interface InterfaceCommand {
    /**
     * @param string $commandString
     * @return InterfaceCommand
     */
    public function configure($commandString);

    /**
     * Command should have only one string representation
     *
     * @param string $commandString
     * @return boolean
     */
    public function conforms($commandString);
}
