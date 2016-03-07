<?php

namespace application\entities;

/**
 * Class Worker.
 */
class Worker extends Bee
{
    /**
     * {@inheritdoc}
     */
    public function getIsQueen()
    {
        return false;
    }
}
