<?php

namespace Test\Unit\helpers;

use application\helpers\NotEmptyString;

class NotEmptyStringTest extends \PHPUnit_Framework_TestCase
{
    public function testOk()
    {
        $int = new NotEmptyString('OK');
        static::assertSame('OK', $int->get());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFail()
    {
        new NotEmptyString(200);
    }
}
