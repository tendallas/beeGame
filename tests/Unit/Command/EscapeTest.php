<?php

namespace Test\Unit\Command;

use application\ClientInterface\Cli;
use application\Command\Escape;
use application\GamePlay\Game;
use application\State\End as StateEnd;

class EscapeTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $game = $this->getMock(Game::class, ['setState'], [new Cli()]);
        $game
            ->expects(static::once())
            ->method('setState')
            ->with(static::equalTo(new StateEnd()))
            ->will(static::returnValue('OK'))
        ;
        $command = new Escape();
        $command->execute($game);
    }
}
