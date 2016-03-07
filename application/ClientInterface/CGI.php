<?php

namespace application\ClientInterface;

use application\Interfaces\ClientInterface;
use application\Interfaces\StateInterface;
use application\State\Begin;
use application\State\End;
use application\State\InProgress;
use framework\Core\Route;

/**
 * CGI.
 *
 * This class provides ability to play game through CGI (rather HTTP).
 */
class CGI implements ClientInterface
{
    /**
     * @var StateInterface
     */
    public $state;

    /**
     * Constructor.
     */
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['out_game'])) {
            $this->state = new End();
        } else {
            $this->state = isset($_SESSION['in_game']) ? new InProgress() : new Begin();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCommand(StateInterface $state)
    {
        return $state->getPromptedCommand();
    }

    /**
     * {@inheritdoc}
     */
    public function outputStatistics(array $statistics)
    {
        $_SESSION['stats'] = $statistics;
    }
}
