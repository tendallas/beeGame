<?php

namespace Test\Unit\Builder;

use application\Builder\Main as Builder;
use application\helpers\NotEmptyString;

class MainTest extends \PHPUnit_Framework_TestCase
{
    public function testLevelOne()
    {
        $builder = new Builder(new NotEmptyString('LevelOne'));
        $builder->buildLevel();
        $beeGang = $builder->getBeeGang();

        static::assertSame(14, $beeGang->getCount());
        static::assertTrue($beeGang->getIsQueenAlive());
    }
}
