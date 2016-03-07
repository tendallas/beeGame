<?php

namespace Test\Unit\Entities;

use application\entities\Drone;
use application\helpers\PositiveInteger;

class DroneTest extends \PHPUnit_Framework_TestCase
{
    public function testGetIsQueen()
    {
        $bee = new Drone(new PositiveInteger(50), new PositiveInteger(12));
        static::assertFalse($bee->getIsQueen());
    }
}
