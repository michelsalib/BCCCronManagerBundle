<?php

namespace BCC\CronManagerBundle\Tests\Manager;

use \BCC\CronManagerBundle\Manager\Cron;

class CronTest extends \PHPUnit_Framework_TestCase
{
    public function testToString() {
        // ARRANGE

        // ACT
        $cron = new Cron();
        $cron->setCommand('ls');
        $cron->setComment('comment');
        $cron->setErrorFile('error.log');
        $cron->setLogFile('output.log');
        $cron->setMinute(1);
        $cron->setHour(2);
        $cron->setDayOfMonth(3);
        $cron->setMonth(4);
        $cron->setDayOfWeek(5);

        // ASSERT
        $this->assertSame('1 2 3 4 5 ls > output.log 2> error.log #comment', (string)$cron);

        // SUSPENDED
        $cron->setSuspended(true);
        $this->assertSame('#suspended: 1 2 3 4 5 ls > output.log 2> error.log #comment', (string)$cron);
    }

    public function testParse(){
        // ARRANGE

        // ACT
        $cron = Cron::parse('1 2 3 4 5 ls > output.log 2> error.log #comment');

        // ASSERT
        $this->assertSame('ls', $cron->getCommand());
        $this->assertSame('comment', $cron->getComment());
        $this->assertSame('error.log', $cron->getErrorFile());
        $this->assertSame('output.log', $cron->getLogFile());
        $this->assertEquals(1, $cron->getMinute());
        $this->assertEquals(2, $cron->getHour());
        $this->assertEquals(3, $cron->getDayOfMonth());
        $this->assertEquals(4, $cron->getMonth());
        $this->assertEquals(5, $cron->getDayOfWeek());
        $this->assertEquals(false, $cron->isSuspended());
    }

    public function testParseSuspended(){
        // ARRANGE

        $cron = Cron::parse('#suspended: 1 2 3 4 5 ls > output.log 2> error.log #comment');
        $this->assertEquals(true, $cron->isSuspended());
    }
}
