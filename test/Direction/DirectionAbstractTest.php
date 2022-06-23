<?php

namespace Barberry\Direction;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Barberry\Plugin\InterfaceConverter;
use Barberry\Plugin\InterfaceCommand;

class DirectionAbstractTest extends TestCase
{

    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    public function testTransfersStringCommandToConverter(): void
    {
        $direction = new TestDirection('string_command');
        $direction->getConverter()
            ->shouldReceive('convert')
            ->with('010101', m::type(InterfaceCommand::class)
        );

        $direction->convert('010101');
    }
}

class TestDirection extends DirectionAbstract
{
    public function init($commandString = null): void
    {
        $this->converter = m::mock(InterfaceConverter::class);
        $this->command = m::mock(InterfaceCommand::class);
    }

    /**
     * @return m\MockInterface
     */
    public function getConverter()
    {
        return $this->converter;
    }
}
