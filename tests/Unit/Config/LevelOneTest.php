<?php

namespace Test\Unit\Config;

use application\Config\LevelOne;
use application\helpers\NotEmptyString;

class StartTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $config = new LevelOne();
        static::assertSame(100, $config->get(new NotEmptyString('lifespanQueen')));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFail()
    {
        $config = new LevelOne();
        $config->get(new NotEmptyString('lifespanBumblebee'));
    }
}
