<?php

namespace application\GamePlay;

use application\ClientInterface\CGI;
use application\entities\Gang;
use application\Interfaces\ClientInterface;
use application\Interfaces\CommandInterface;
use application\Interfaces\StateInterface;
use application\State\Begin;
use application\helpers\NotEmptyString;
use application\State\End;
use framework\helpers\Request;

/**
 * Game.
 *
 * This class encapsulates all game logic, and have access to all game objects.
 * Through commands game goes from one state to another, and maintain state of all necessary objects.
 */
class Game
{
    /** @var NotEmptyString Particular game level. */
    private $level;

    /** @var StateInterface State of game. */
    private $state;

    /** @var ClientInterface Interface of interaction between client (gamer) and game. */
    private $interface;

    /** @var Gang Aggregate of bees. */
    private $beeGang;

    /**
     * Game constructor.
     *
     * Initialize game.
     *
     * @param ClientInterface $clientInterface Client interface.
     *
     * @throws \InvalidArgumentException In case when level is not valid string.
     */
    public function __construct(ClientInterface $clientInterface)
    {
        $this->interface = $clientInterface;
        // Initialize game.
        $this->level = new NotEmptyString('LevelOne');
        $state = isset($this->interface->state) ? $this->interface->state : new Begin();
        $this->setState($state);
    }

    /**
     * This method provides game interaction.
     */
    public function play()
    {
        if ($this->interface instanceof CGI) {
            $this->playCGI();
            return true;
        }
        /** @var CommandInterface $command */
        while ($command = $this->interface->getCommand($this->state)) {
            $command->execute($this);
            if ($this->beeGang !== null) {
                $this->interface->outputStatistics($this->beeGang->getStatistics());
            }
        }
    }

    /**
     * @inheritdoc
     */
    private function playCGI()
    {
        $command = $this->interface->getCommand($this->state);
        if (Request::isAJAX()) {
            $command->execute($this);
        }
        if ($this->state instanceof End) {
            unset($_SESSION['in_game']);
            $_SESSION['out_game'] = true;
        }
        if ($this->beeGang !== null) {
            $_SESSION['beeGang'] = $this->beeGang;
            $this->interface->outputStatistics($this->beeGang->getStatistics());
        }
    }

    /**
     * Gets current level.
     *
     * @return NotEmptyString Level.
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Sets new state of game.
     *
     * By this method commands can move game to the new state.
     *
     * @param StateInterface $state State of game.
     */
    public function setState(StateInterface $state)
    {
        $this->state = $state;
    }

    /**
     * Gets aggregate of bees.
     *
     * @return Gang Bee gang.
     */
    public function getBeeGang()
    {
        if ($this->beeGang === null) {
            $this->setBeeGang($_SESSION['beeGang']);
        }
        return $this->beeGang;
    }

    /**
     * Sets updated aggregate of bees.
     *
     * This method provides to commands ability to impact on bee aggregate.
     *
     * @param Gang $beeGang Bee gang.
     */
    public function setBeeGang(Gang $beeGang)
    {
        $this->beeGang = $beeGang;
    }
}
