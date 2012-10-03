<?php
namespace Barberry\Direction;
use Barberry\Plugin;

abstract class DirectionAbstract {
    /**
     * @var null|Plugin\InterfaceCommand
     */
    protected $command;

    /**
     * @var Plugin\InterfaceConverter
     */
    protected $converter;

    public function __construct($commandString = null) {
        $this->init($commandString);
    }

    abstract protected function init($commandString = null);

    public function convert($bin) {
        return $this->converter->convert($bin, $this->command);
    }
}
