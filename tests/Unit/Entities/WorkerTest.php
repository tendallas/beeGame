<?php

namespace Test\Unit\Bee;

use application\entities\Worker;
use application\helpers\PositiveInteger;

class WorkerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetIsQueen()
    {
        $bee = new Worker(new PositiveInteger(50), new PositiveInteger(12));
        static::assertFalse($bee->getIsQueen());
    }
}
