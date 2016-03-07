<?php

namespace application\Command;

use application\Interfaces\CommandInterface;
use application\GamePlay\Game;
use application\State\End;
use application\State\InProgress;

/**
 * Hit command.
 *
 * This command hit bee (main command of game). Exactly this - is a gist of this game.
 * This command can bring game to different states accordingly to fact that Queen bee is alive.
 */
class Hit implements CommandInterface
{
    /**
     * {@inheritdoc}
     */
    public function execute(Game $game)
    {
        $beeGang = $game->getBeeGang();
        $beeGang->randomHit();
        if ($beeGang->getIsQueenAlive()) {
            $game->setState(new InProgress());
        } else {
            $game->setState(new End());
        }
    }
}
