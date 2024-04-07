<?php

// $Id: month_test.php 159563 2004-05-24 22:25:43Z quipo $

require_once('simple_include.php');
require_once('calendar_include.php');

require_once('./calendar_test.php');

class TestOfMonth extends TestOfCalendar
{
    public function __construct()
    {
        $this->UnitTestCase('Test of Month');
    }
    public function setUp()
    {
        $this->cal = new Calendar_Month(2003, 10);
    }
    public function testPrevMonth_Object()
    {
        $this->assertEqual(new Calendar_Month(2003, 9), $this->cal->prevMonth('object'));
    }
    public function testPrevDay()
    {
        $this->assertEqual(30, $this->cal->prevDay());
    }
    public function testPrevDay_Array()
    {
        $this->assertEqual(
            [
                'year'   => 2003,
                'month'  => 9,
                'day'    => 30,
                'hour'   => 0,
                'minute' => 0,
                'second' => 0, ],
            $this->cal->prevDay('array')
        );
    }
    public function testThisDay()
    {
        $this->assertEqual(1, $this->cal->thisDay());
    }
    public function testNextDay()
    {
        $this->assertEqual(2, $this->cal->nextDay());
    }
    public function testPrevHour()
    {
        $this->assertEqual(23, $this->cal->prevHour());
    }
    public function testThisHour()
    {
        $this->assertEqual(0, $this->cal->thisHour());
    }
    public function testNextHour()
    {
        $this->assertEqual(1, $this->cal->nextHour());
    }
    public function testPrevMinute()
    {
        $this->assertEqual(59, $this->cal->prevMinute());
    }
    public function testThisMinute()
    {
        $this->assertEqual(0, $this->cal->thisMinute());
    }
    public function testNextMinute()
    {
        $this->assertEqual(1, $this->cal->nextMinute());
    }
    public function testPrevSecond()
    {
        $this->assertEqual(59, $this->cal->prevSecond());
    }
    public function testThisSecond()
    {
        $this->assertEqual(0, $this->cal->thisSecond());
    }
    public function testNextSecond()
    {
        $this->assertEqual(1, $this->cal->nextSecond());
    }
    public function testGetTimeStamp()
    {
        $stamp = mktime(0, 0, 0, 10, 1, 2003);
        $this->assertEqual($stamp, $this->cal->getTimeStamp());
    }
}

class TestOfMonthBuild extends TestOfMonth
{
    public function __construct()
    {
        $this->UnitTestCase('Test of Month::build()');
    }
    public function testSize()
    {
        $this->cal->build();
        $this->assertEqual(31, $this->cal->size());
    }
    public function testFetch()
    {
        $this->cal->build();
        $i = 0;
        while ($Child = $this->cal->fetch()) {
            $i++;
        }
        $this->assertEqual(31, $i);
    }
    public function testFetchAll()
    {
        $this->cal->build();
        $children = [];
        $i = 1;
        while ($Child = $this->cal->fetch()) {
            $children[$i] = $Child;
            $i++;
        }
        $this->assertEqual($children, $this->cal->fetchAll());
    }
    public function testSelection()
    {
        require_once(CALENDAR_ROOT . 'Day.php');
        $selection = [new Calendar_Day(2003, 10, 25)];
        $this->cal->build($selection);
        $i = 1;
        while ($Child = $this->cal->fetch()) {
            if ($i == 25) {
                break;
            }
            $i++;
        }
        $this->assertTrue($Child->isSelected());
    }
}

if (!defined('TEST_RUNNING')) {
    define('TEST_RUNNING', true);
    $test = new TestOfMonth();
    $test->run(new HtmlReporter());
    $test = new TestOfMonthBuild();
    $test->run(new HtmlReporter());
}
