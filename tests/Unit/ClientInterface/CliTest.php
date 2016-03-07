<?php

namespace Test\Unit\ClientInterface;

use application\ClientInterface\Cli;

class CliTest extends \PHPUnit_Framework_TestCase
{
    public function testOutputStatistics()
    {
        $cli = new Cli();
        ob_start();
        $cli->outputStatistics(['Drone' => [50, 38]]);
        $output = ob_get_clean();
        static::assertContains('Drone: 50 38', $output);
    }
}
