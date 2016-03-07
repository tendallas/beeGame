<?php

namespace application\entities;

/**
 * Class Drone.
 */
class Drone extends Bee
{
    /**
     * {@inheritdoc}
     */
    public function getIsQueen()
    {
        return false;
    }
}
