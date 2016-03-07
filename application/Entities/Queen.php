<?php

namespace application\entities;

/**
 * Class Queen.
 *
 * This is the most important bee.
 */
class Queen extends Bee
{
    /**
     * {@inheritdoc}
     */
    public function getIsQueen()
    {
        return true;
    }
}
