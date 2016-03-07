<?php

namespace application\ClientInterface;

use application\Interfaces\ClientInterface;
use application\Interfaces\StateInterface;

/**
 * Cli.
 *
 * This class provides ability to play game in CLI environment (console/terminal).
 */
class Cli implements ClientInterface
{
    /**
     * {@inheritdoc}
     */
    public function getCommand(StateInterface $state)
    {
        echo "\n".$state->getPromptMessage();
        $confirmation = trim(fgets(STDIN));
        if ($confirmation === 'y') {
            return $state->getPromptedCommand();
        } else {
            return $state->getNotPromptedCommand();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function outputStatistics(array $statistics)
    {
        foreach ($statistics as $beeType => $points) {
            echo "\n$beeType: ".implode(' ', $points);
        }
    }
}