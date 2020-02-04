<?php

namespace Test\Util;

use PHPUnit\Framework\TestCase;
use App\Util\DateUtil;

class DateUtilTest extends TestCase
{
    /** @var DateUtil $dateUtil */
    private $dateUtil;

    public function setUp(): void
    {
        $this->dateUtil = $this->createDateUtil('2019-01-01');
    }

    public function testInvalidArgumentException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $dateUtil = $this->createDateUtil('TEST');
    }

    public function testGetDateTime()
    {
        $this->assertEquals((new \DateTime('2019-01-01'))->format('Y-m-d'), $this->dateUtil->getDateTime());
    }

    public function testSetMonth()
    {
        $this->assertEquals(1, $this->dateUtil->setMonth(1)->getDateTime('m'));
        $this->assertEquals(5, $this->dateUtil->setMonth(5)->getDateTime('m'));
    }

    public function testSetDay()
    {
        $this->assertEquals(1, $this->dateUtil->setDay(1)->getDateTime('d'));
        $this->assertEquals(5, $this->dateUtil->setDay(5)->getDateTime('d'));
    }

    public function testGetNameOfMonth()
    {
        $this->assertEquals('January', $this->dateUtil->setMonth(1)->getNameOfMonth());
    }

    public function testGetLastWeekDayOfMonth()
    {
        $dateUtil = $this->createDateUtil('2019-01-31');
        $this->assertEquals('2019-01-31', $dateUtil->getLastWeekDayOfMonth()->getDateTime('Y-m-d'));
    }

    public function testGetLastFridayOfMonth()
    {
        $dateUtil = $this->createDateUtil('2019-03-01');
        $this->assertEquals('2019-03-29', $dateUtil->getLastFridayOfMonth()->getDateTime('Y-m-d'));
    }

    public function testGet15thOfMonth()
    {
        $dateUtil = $this->createDateUtil('2019-01-15');
        $this->assertEquals('2019-01-15', $dateUtil->get15thOfMonth()->getDateTime('Y-m-d'));
    }

    public function testGetWednesdayAfter15thOfMonth()
    {
        $dateUtil = $this->createDateUtil('2019-06-15');
        $this->assertGreaterThan(15, $dateUtil->getWednesdayAfter15thOfMonth()->getDateTime('d'));
        $this->assertEquals(3, $dateUtil->getWednesdayAfter15thOfMonth()->getDateTime('N'));
    }

    public function testIsWeekend()
    {
        $dateUtil = $this->createDateUtil('2019-01-04');
        $this->assertFalse($dateUtil->isWeekend());
        $dateUtil->setDay(6);
        $this->assertTrue($dateUtil->isWeekend());
    }

    /**
     * @param string $time
     * @return DateUtil
     */
    private function createDateUtil(string $time): DateUtil
    {
        return new DateUtil($time);
    }
}