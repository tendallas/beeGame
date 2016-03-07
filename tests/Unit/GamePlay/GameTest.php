<?php

namespace Test\Unit\GamePlay;

use application\ClientInterface\Cli;
use application\Command\Start as CommandStart;
use application\entities\Gang;
use application\GamePlay\Game;
use application\Interfaces\ClientInterface;
use application\State\Begin as StateBegin;

class StartTest extends \PHPUnit_Framework_TestCase
{
    public function testPlay()
    {
        $command = $this->getMock(CommandStart::class);
        $command
            ->expects(static::once())
            ->method('execute')
            ->will(static::returnValue(null))
        ;
        $interface = $this->getMock(Cli::class);
        $interface
            ->method('getCommand')
            ->will(static::onConsecutiveCalls($command, null))
        ;
        /** @var ClientInterface $interface */
        $game = new Game($interface);
        $beeGang = new Gang();
        $game->setBeeGang($beeGang);
        $game->play();
    }

    public function testGetLevel()
    {
        $game = new Game(new Cli());
        static::assertSame('LevelOne', $game->getLevel()->get());
    }

    public function testSetState()
    {
        $game = new Game(new Cli());
        $state = new StateBegin();
        $game->setState($state);
        // One available way to break encapsulation.
        $reflection = new \ReflectionObject($game);
        $property = $reflection->getProperty('state');
        $property->setAccessible(true);
        static::assertSame($state, $property->getValue($game));
    }

    public function testSetAndGetBeeGang()
    {
        $game = new Game(new Cli());
        $beeGang = new Gang();
        $game->setBeeGang($beeGang);
        static::assertSame($beeGang, $game->getBeeGang());
    }
}
