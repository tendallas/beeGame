<?php

namespace Test\Unit\Command;

use application\ClientInterface\Cli;
use application\Command\Hit;
use application\entities\Gang;
use application\GamePlay\Game;
use application\State\End as StateEnd;
use application\State\InProgress as StateInProgress;

class HitTest extends \PHPUnit_Framework_TestCase
{
    public function testExecuteQueenAlive()
    {
        $game = $this->getMock(Game::class, ['setState'], [new Cli()]);
        $game
            ->expects(static::once())
            ->method('setState')
            ->with(static::equalTo(new StateInProgress()))
            ->will(static::returnValue('OK'));
        $beeGang = $this->getMock(Gang::class);
        $beeGang
            ->expects(static::once())
            ->method('randomHit')
            ->will(static::returnValue(null));
        $beeGang
            ->expects(static::once())
            ->method('getIsQueenAlive')
            ->will(static::returnValue(true));
        $game->setBeeGang($beeGang);
        $command = new Hit();
        $command->execute($game);
    }

    public function testExecuteNotQueenAlive()
    {
        $game = $this->getMock(Game::class, ['setState'], [new Cli()]);
        $game
            ->expects(static::once())
            ->method('setState')
            ->with(static::equalTo(new StateEnd()))
            ->will(static::returnValue('OK'))
        ;
        $beeGang = $this->getMock(Gang::class);
        $beeGang
            ->expects(static::once())
            ->method('randomHit')
            ->will(static::returnValue(null))
        ;
        $beeGang
            ->expects(static::once())
            ->method('getIsQueenAlive')
            ->will(static::returnValue(false));
        $game->setBeeGang($beeGang);
        $command = new Hit();
        $command->execute($game);
    }
}
