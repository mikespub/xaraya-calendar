<?php

// $Id: week_firstday_0_test.php 198885 2005-10-20 18:57:52Z quipo $
define('CALENDAR_FIRST_DAY_OF_WEEK', 0); //force firstDay = Sunday

require_once('simple_include.php');
require_once('calendar_include.php');

require_once('./calendar_test.php');

class TestOfWeek_firstday_0 extends TestOfCalendar
{
    public function __construct()
    {
        $this->UnitTestCase('Test of Week - Week Starting on Sunday');
    }
    public function setUp()
    {
        $this->cal = Calendar_Factory::create('Week', 2003, 10, 9);
        //print_r($this->cal);
    }
    public function testPrevDay()
    {
        $this->assertEqual(8, $this->cal->prevDay());
    }
    public function testPrevDay_Array()
    {
        $this->assertEqual(
            [
                'year'   => 2003,
                'month'  => 10,
                'day'    => 8,
                'hour'   => 0,
                'minute' => 0,
                'second' => 0, ],
            $this->cal->prevDay('array')
        );
    }
    public function testThisDay()
    {
        $this->assertEqual(9, $this->cal->thisDay());
    }
    public function testNextDay()
    {
        $this->assertEqual(10, $this->cal->nextDay());
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
        $stamp = mktime(0, 0, 0, 10, 9, 2003);
        $this->assertEqual($stamp, $this->cal->getTimeStamp());
    }
    public function testNewTimeStamp()
    {
        $stamp = mktime(0, 0, 0, 7, 28, 2004);
        $this->cal->setTimestamp($stamp);
        $this->assertEqual('29 2004', date('W Y', $this->cal->prevWeek(true)));
        $this->assertEqual('30 2004', date('W Y', $this->cal->thisWeek(true)));
        $this->assertEqual('31 2004', date('W Y', $this->cal->nextWeek(true)));
    }
    public function testPrevWeekInMonth()
    {
        $this->assertEqual(1, $this->cal->prevWeek());
        $stamp = mktime(0, 0, 0, 2, 3, 2005);
        $this->cal->setTimestamp($stamp);
        $this->assertEqual(0, $this->cal->prevWeek());
    }
    public function testThisWeekInMonth()
    {
        $this->assertEqual(2, $this->cal->thisWeek());
        $stamp = mktime(0, 0, 0, 2, 3, 2005);
        $this->cal->setTimestamp($stamp);
        $this->assertEqual(1, $this->cal->thisWeek());
        $stamp = mktime(0, 0, 0, 1, 1, 2005);
        $this->cal->setTimestamp($stamp);
        $this->assertEqual(1, $this->cal->thisWeek());
        $stamp = mktime(0, 0, 0, 1, 3, 2005);
        $this->cal->setTimestamp($stamp);
        $this->assertEqual(2, $this->cal->thisWeek());
    }
    public function testNextWeekInMonth()
    {
        $this->assertEqual(3, $this->cal->nextWeek());
        $stamp = mktime(0, 0, 0, 2, 3, 2005);
        $this->cal->setTimestamp($stamp);
        $this->assertEqual(2, $this->cal->nextWeek());
    }
    public function testPrevWeekInYear()
    {
        $this->assertEqual(date('W', $this->cal->prevWeek('timestamp')), $this->cal->prevWeek('n_in_year'));
        $stamp = mktime(0, 0, 0, 1, 1, 2004);
        $this->cal->setTimestamp($stamp);
        $this->assertEqual(date('W', $this->cal->nextWeek('timestamp')), $this->cal->nextWeek('n_in_year'));
    }
    public function testThisWeekInYear()
    {
        $this->assertEqual(date('W', $this->cal->thisWeek('timestamp')), $this->cal->thisWeek('n_in_year'));
        $stamp = mktime(0, 0, 0, 1, 1, 2004);
        $this->cal->setTimestamp($stamp);
        $this->assertEqual(date('W', $this->cal->thisWeek('timestamp')), $this->cal->thisWeek('n_in_year'));
    }
    public function testFirstWeekInYear()
    {
        $stamp = mktime(0, 0, 0, 1, 4, 2004);
        $this->cal->setTimestamp($stamp);
        $this->assertEqual(1, $this->cal->thisWeek('n_in_year'));
    }
    public function testNextWeekInYear()
    {
        $this->assertEqual(date('W', $this->cal->nextWeek('timestamp')), $this->cal->nextWeek('n_in_year'));
    }
    public function testPrevWeekArray()
    {
        $testArray = [
            'year' => 2003,
            'month' => 9,
            'day' => 28,
            'hour' => 0,
            'minute' => 0,
            'second' => 0,
            ];
        $this->assertEqual($testArray, $this->cal->prevWeek('array'));
    }
    public function testThisWeekArray()
    {
        $testArray = [
            'year' => 2003,
            'month' => 10,
            'day' => 5,
            'hour' => 0,
            'minute' => 0,
            'second' => 0,
            ];
        $this->assertEqual($testArray, $this->cal->thisWeek('array'));
    }
    public function testNextWeekArray()
    {
        $testArray = [
            'year' => 2003,
            'month' => 10,
            'day' => 12,
            'hour' => 0,
            'minute' => 0,
            'second' => 0,
            ];
        $this->assertEqual($testArray, $this->cal->nextWeek('array'));
    }
    public function testPrevWeekObject()
    {
        $testWeek = Calendar_Factory::create('Week', 2003, 9, 28);
        $Week = $this->cal->prevWeek('object');
        $this->assertEqual($testWeek->getTimeStamp(), $Week->getTimeStamp());
    }
    public function testThisWeekObject()
    {
        $testWeek = Calendar_Factory::create('Week', 2003, 10, 5);
        $Week = $this->cal->thisWeek('object');
        $this->assertEqual($testWeek->getTimeStamp(), $Week->getTimeStamp());
    }
    public function testNextWeekObject()
    {
        $testWeek = Calendar_Factory::create('Week', 2003, 10, 12);
        $Week = $this->cal->nextWeek('object');
        $this->assertEqual($testWeek->getTimeStamp(), $Week->getTimeStamp());
    }
}

class TestOfWeek_firstday_0_Build extends TestOfWeek_firstday_0
{
    public function __construct()
    {
        $this->UnitTestCase('Test of Week::build() - FirstDay = Sunday');
    }
    public function testSize()
    {
        $this->cal->build();
        $this->assertEqual(7, $this->cal->size());
    }

    public function testFetch()
    {
        $this->cal->build();
        $i = 0;
        while ($Child = $this->cal->fetch()) {
            $i++;
        }
        $this->assertEqual(7, $i);
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
        $selection = [Calendar_Factory::create('Day', 2003, 10, 6)];
        $this->cal->build($selection);
        $i = 1;
        while ($Child = $this->cal->fetch()) {
            if ($i == 2) {
                break; //06-10-2003 is the 2nd day of the week
            }
            $i++;
        }
        $this->assertTrue($Child->isSelected());
    }
    public function testSelectionCornerCase()
    {
        require_once(CALENDAR_ROOT . 'Day.php');
        $selectedDays = [
            Calendar_Factory::create('Day', 2003, 12, 28),
            Calendar_Factory::create('Day', 2003, 12, 29),
            Calendar_Factory::create('Day', 2003, 12, 30),
            Calendar_Factory::create('Day', 2003, 12, 31),
            Calendar_Factory::create('Day', 2004, 1, 1),
            Calendar_Factory::create('Day', 2004, 1, 2),
            Calendar_Factory::create('Day', 2004, 1, 3),
        ];
        $this->cal = Calendar_Factory::create('Week', 2003, 12, 31, 0);
        $this->cal->build($selectedDays);
        while ($Day = $this->cal->fetch()) {
            $this->assertTrue($Day->isSelected());
        }
        $this->cal = Calendar_Factory::create('Week', 2004, 1, 1, 0);
        $this->cal->build($selectedDays);
        while ($Day = $this->cal->fetch()) {
            $this->assertTrue($Day->isSelected());
        }
    }
}
if (!defined('TEST_RUNNING')) {
    define('TEST_RUNNING', true);
    $test = new TestOfWeek_firstday_0();
    $test->run(new HtmlReporter());
    $test = new TestOfWeek_firstday_0_Build();
    $test->run(new HtmlReporter());
}
