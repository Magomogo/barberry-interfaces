<?php
namespace Barberry\Plugin;
use Barberry\Plugin\InterfaceCommand;
use Barberry\ContentType;
use Barberry\Exception\ConversionNotPossible;

interface InterfaceConverter
{
    /**
     * @param ContentType $targetContentType
     * @param string $tempPath
     * @return self
     */
    public function configure(ContentType $targetContentType, $tempPath);

    /**
     * @param string $bin
     * @param InterfaceCommand $command
     * @return string
     * @throws ConversionNotPossible
     */
    public function convert($bin, InterfaceCommand $command = null);
}
