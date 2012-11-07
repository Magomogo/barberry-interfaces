<?php
namespace Barberry\Plugin;
use Barberry\Plugin\InterfaceCommand;
use Barberry\ContentType;

interface InterfaceConverter
{
    /**
     * @param ContentType $targetContentType
     * @param string $tempPath
     * @return void
     */
    public function configure(ContentType $targetContentType, $tempPath);

    /**
     * @param string $bin
     * @param InterfaceCommand $command
     * @return string
     */
    public function convert($bin, InterfaceCommand $command = null);
}
