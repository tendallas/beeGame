<?php

namespace application\Command;

use application\GamePlay\Game;
use application\Interfaces\CommandInterface;
use application\State\End as StateEnd;

/**
 * Escape command.
 *
 * Command that allow to user leave the game.
 */
class Escape implements CommandInterface
{
    /**
     * {@inheritdoc}
     */
    public function execute(Game $game)
    {
        $game->setState(new StateEnd());
    }
}
