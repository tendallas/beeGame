<?php

namespace application\Command;

use application\Interfaces\CommandInterface;
use application\Builder\Main as Builder;
use application\GamePlay\Game;
use application\State\InProgress as StateInProgress;

/**
 * Start command.
 * This command initializes game, builds particular level and prepares all objects to start the game.
 */
class Start implements CommandInterface
{
    /**
     * {@inheritdoc}
     * @throws \InvalidArgumentException In case when factory cannot create bee.
     */
    public function execute(Game $game)
    {
        $builder = new Builder($game->getLevel());
        $builder->buildLevel();
        $game->setBeeGang($builder->getBeeGang());
        $game->setState(new StateInProgress());
    }
}
