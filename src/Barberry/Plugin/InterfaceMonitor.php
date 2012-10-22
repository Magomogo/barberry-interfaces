<?php
namespace Barberry\Plugin;

interface InterfaceMonitor {
    /**
     * @return array of error messages
     */
    public function reportUnmetDependencies();

    /**
     * @return array of error messages
     */
    public function reportMalfunction();
}
