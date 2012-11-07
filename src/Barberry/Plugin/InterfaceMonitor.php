<?php
namespace Barberry\Plugin;

interface InterfaceMonitor
{
    /**
     * @param string $tempDirectory
     * @return void
     */
    public function configure($tempDirectory);

    /**
     * @return array of error messages
     */
    public function reportUnmetDependencies();

    /**
     * @return array of error messages
     */
    public function reportMalfunction();
}
