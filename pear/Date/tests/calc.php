<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Tests for the Date_Calc class
 *
 * Any individual tests that fail will have their name, expected result
 * and actual result printed out.  So seeing no output when executing
 * this file is a good thing.
 *
 * Can be run via CLI or a web server.
 *
 * This test senses whether it is from an installation of PEAR::Date or if
 * it's from CVS or a .tar file.  If it's an installed version, use the
 * installed version of Date_Calc.  Otherwise, use the local development
 * copy of Date_Calc.
 *
 * PHP versions 4 and 5
 *
 * LICENSE:
 *
 * Copyright (c) 1997-2005 Daniel Convissor <danielc@php.net>
 * All rights reserved.
 *
 * This source file is subject to the New BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.opensource.org/licenses/bsd-license.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to pear-dev@lists.php.net so we can send you a copy immediately.
 *
 * @category   Date and Time
 * @package    Date
 * @author     Daniel Convissor <danielc@php.net>
 * @copyright  Copyright (c) 1997-2005 Daniel Convissor <danielc@php.net>
 * @license    http://www.opensource.org/licenses/bsd-license.php
 *             BSD License
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/Date
 * @since      File available since Release 1.5
 */

if ('@include_path@' != '@' . 'include_path' . '@') {
    ini_set(
        'include_path',
        ini_get('include_path')
            . PATH_SEPARATOR . '.'
    );
} else {
    ini_set(
        'include_path',
        realpath(__DIR__ . '/../')
            . PATH_SEPARATOR . '.' . PATH_SEPARATOR
            . ini_get('include_path')
    );
}

/**
 * Get the needed class
 */
require_once 'Date/Calc.php';

/**
 * Compare the test result to the expected result
 *
 * If the test fails, echo out the results.
 *
 * @param mixed  $expect     the scalar or array you expect from the test
 * @param mixed  $actual     the scalar or array results from the test
 * @param string $test_name  the name of the test
 *
 * @return void
 */
function compare($expect, $actual, $test_name)
{
    if (is_array($expect)) {
        //if (count(array_diff($actual, $expect))) {
        if (json_encode($expect) != json_encode($actual)) {
            echo "$test_name failed.  Expect:\n";
            print_r($expect);
            echo "Actual:\n";
            print_r($actual);
        }
    } else {
        if ($expect != $actual) {
            echo "$test_name failed.  Expect: $expect.  Actual: $actual\n";
        }
    }
}

if (php_sapi_name() != 'cli') {
    echo "<pre>\n";
}


compare('20001122', (new Date_Calc())->dateFormat(22, 11, 2000, '%Y%m%d'), 'dateFormat');
compare('20001122', (new Date_Calc())->dateFormat('22', '11', '2000', '%Y%m%d'), 'dateFormat str');

compare('2001', (new Date_Calc())->defaultCentury('1'), 'defaultCentury 1 str');
compare('2001', (new Date_Calc())->defaultCentury(1), 'defaultCentury 1');
compare('1960', (new Date_Calc())->defaultCentury(60), 'defaultCentury 2');
compare('2010', (new Date_Calc())->defaultCentury(10), 'defaultCentury 3');

compare(2451871, (new Date_Calc())->dateToDays('22', '11', '2000'), 'dateToDays str');
compare(2451871, (new Date_Calc())->dateToDays(22, 11, 2000), 'dateToDays');
compare('20001122', (new Date_Calc())->daysToDate(2451871), 'daysToDate');

compare('2000-47-3', (new Date_Calc())->gregorianToISO('22', '11', '2000'), 'gregorianToISO str');
compare('2000-47-3', (new Date_Calc())->gregorianToISO(22, 11, 2000), 'gregorianToISO');
compare(2451716.56767, (new Date_Calc())->dateSeason('SUMMERSOLSTICE', 2000), 'dateSeason');

compare(date('Ymd'), (new Date_Calc())->dateNow(), 'dateNow');
compare(date('Y'), (new Date_Calc())->getYear(), 'getYear');
compare(date('m'), (new Date_Calc())->getMonth(), 'getMonth');
compare(date('d'), (new Date_Calc())->getDay(), 'getDay');

compare(327, (new Date_Calc())->dayOfYear(22, 11, 2000), 'dayOfYear');
compare('November', (new Date_Calc())->getMonthFullname(11), 'getMonthFullname');
compare('Nov', (new Date_Calc())->getMonthAbbrname(11), 'getMonthAbbrname');
compare('Saturday', (new Date_Calc())->getWeekdayFullname(1, 1, 2005), 'getWeekdayFullname');
compare('Sat', (new Date_Calc())->getWeekdayAbbrname(1, 1, 2005), 'getWeekdayAbbrname');
compare(11, (new Date_Calc())->getMonthFromFullName('November'), 'getMonthFromFullName');

compare(327, (new Date_Calc())->dayOfYear('22', '11', '2000'), 'dayOfYear str');
compare('November', (new Date_Calc())->getMonthFullname('11'), 'getMonthFullname str');
compare('Nov', (new Date_Calc())->getMonthAbbrname('11'), 'getMonthAbbrname str');
compare('Saturday', (new Date_Calc())->getWeekdayFullname('01', '01', '2005'), 'getWeekdayFullname str');
compare('Sat', (new Date_Calc())->getWeekdayAbbrname('01', '01', '2005'), 'getWeekdayAbbrname str');

$exp = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December',
];
compare($exp, (new Date_Calc())->getMonthNames(), 'getMonthNames');

$exp = [
    'Monday',
    'Tuesday',
    'Wednesday',
    'Thursday',
    'Friday',
    'Saturday',
    'Sunday',
];
compare($exp, (new Date_Calc())->getWeekDays(), 'getWeekDays');

compare(3, (new Date_Calc())->dayOfWeek(22, 11, 2000), 'dayOfWeek');
compare(47, (new Date_Calc())->weekOfYear(22, 11, 2000), 'weekOfYear');
compare(4, (new Date_Calc())->quarterOfYear(22, 11, 2000), 'quarterOfYear');

compare(3, (new Date_Calc())->dayOfWeek('22', '11', '2000'), 'dayOfWeek str');
compare(47, (new Date_Calc())->weekOfYear('22', '11', '2000'), 'weekOfYear str');
compare(4, (new Date_Calc())->quarterOfYear('22', '11', '2000'), 'quarterOfYear str');

compare(28, (new Date_Calc())->daysInMonth(2, 1900), 'daysInMonth 1');
compare(29, (new Date_Calc())->daysInMonth(2, 1996), 'daysInMonth 2');
compare(29, (new Date_Calc())->daysInMonth(2, 2000), 'daysInMonth 3');
compare(28, (new Date_Calc())->daysInMonth(2, 2001), 'daysInMonth 4');
compare(30, (new Date_Calc())->daysInMonth(11, 2000), 'daysInMonth 5');

compare(28, (new Date_Calc())->daysInMonth('02', 1900), 'daysInMonth 1 str');
compare(29, (new Date_Calc())->daysInMonth('02', 1996), 'daysInMonth 2 str');
compare(29, (new Date_Calc())->daysInMonth('02', 2000), 'daysInMonth 3 str');
compare(28, (new Date_Calc())->daysInMonth('02', 2001), 'daysInMonth 4 str');
compare(30, (new Date_Calc())->daysInMonth('11', '2000'), 'daysInMonth 5 str');

compare(5, (new Date_Calc())->weeksInMonth(11, 2000), 'weeksInMonth');
compare(5, (new Date_Calc())->weeksInMonth('11', '2000'), 'weeksInMonth str');


$exp = [
    '19000226',
    '19000227',
    '19000228',
    '19000301',
    '19000302',
    '19000303',
    '19000304',
];
compare($exp, (new Date_Calc())->getCalendarWeek(27, 2, 1900), 'getCalendarWeek 1');

$exp = [
    '20000228',
    '20000229',
    '20000301',
    '20000302',
    '20000303',
    '20000304',
    '20000305',
];
compare($exp, (new Date_Calc())->getCalendarWeek(28, 2, 2000), 'getCalendarWeek 2');

$exp = [
    '20001127',
    '20001128',
    '20001129',
    '20001130',
    '20001201',
    '20001202',
    '20001203',
];
compare($exp, (new Date_Calc())->getCalendarWeek(27, 11, 2000), 'getCalendarWeek 3');
compare($exp, (new Date_Calc())->getCalendarWeek('27', '11', '2000'), 'getCalendarWeek 3 str');

$exp = [
    [
        '20001030',
        '20001031',
        '20001101',
        '20001102',
        '20001103',
        '20001104',
    ],
    [
        '20001105',
        '20001106',
        '20001107',
        '20001108',
        '20001109',
        '20001110',
        '20001111',
    ],
    [
        '20001112',
        '20001113',
        '20001114',
        '20001115',
        '20001116',
        '20001117',
        '20001118',
    ],
    [
        '20001119',
        '20001121',
        '20001122',
        '20001123',
        '20001124',
        '20001125',
        '20001126',
    ],
    [
        '20001127',
        '20001128',
        '20001129',
        '20001130',
        '20001201',
        '20001202',
        '20001203',
    ],
];
compare($exp, (new Date_Calc())->getCalendarMonth(11, 2000), 'getCalendarMonth');
compare($exp, (new Date_Calc())->getCalendarMonth('11', '2000'), 'getCalendarMonth str');

// I don't feel like dealing with this right now...
//compare('', Date_Calc::getCalendarYear(2000), 'getCalendarYear');

compare('20001121', (new Date_Calc())->prevDay(22, 11, 2000), 'prevDay');
compare('20001123', (new Date_Calc())->nextDay(22, 11, 2000), 'nextDay');
compare('20001121', (new Date_Calc())->prevDay(22, 11, 2000), 'prevDay str');
compare('20001123', (new Date_Calc())->nextDay('22', '11', '2000'), 'nextDay str');

compare('20001117', (new Date_Calc())->prevWeekday('19', '11', '2000'), 'prevWeekday 1 str');
compare('20001117', (new Date_Calc())->prevWeekday(19, 11, 2000), 'prevWeekday 1');
compare('20001121', (new Date_Calc())->prevWeekday(22, 11, 2000), 'prevWeekday 2');
compare('20001123', (new Date_Calc())->nextWeekday(22, 11, 2000), 'nextWeekday 1');
compare('20001127', (new Date_Calc())->nextWeekday(24, 11, 2000), 'nextWeekday 2');
compare('20001127', (new Date_Calc())->nextWeekday('24', '11', '2000'), 'nextWeekday 2 str');

compare('20001121', (new Date_Calc())->prevDayOfWeek('2', '22', '11', '2000'), 'prevDayOfWeek 1 str');
compare('20001121', (new Date_Calc())->prevDayOfWeek(2, 22, 11, 2000), 'prevDayOfWeek 1');
compare('20001115', (new Date_Calc())->prevDayOfWeek(3, 22, 11, 2000), 'prevDayOfWeek 2');
compare('20001122', (new Date_Calc())->prevDayOfWeek(3, 22, 11, 2000, '%Y%m%d', true), 'prevDayOfWeek 3');
compare('20001122', (new Date_Calc())->nextDayOfWeek(3, 22, 11, 2000, '%Y%m%d', true), 'nextDayOfWeek 1');
compare('20001129', (new Date_Calc())->nextDayOfWeek(3, 22, 11, 2000), 'nextDayOfWeek 2');
compare('20001123', (new Date_Calc())->nextDayOfWeek(4, 22, 11, 2000), 'nextDayOfWeek 3');
compare('20001123', (new Date_Calc())->nextDayOfWeek('4', '22', '11', '2000'), 'nextDayOfWeek 3 str');

compare('20001121', (new Date_Calc())->prevDayOfWeekOnOrBefore('2', '22', '11', '2000'), 'prevDayOfWeekOnOrBefore 1 str');
compare('20001121', (new Date_Calc())->prevDayOfWeekOnOrBefore(2, 22, 11, 2000), 'prevDayOfWeekOnOrBefore 1');
compare('20001122', (new Date_Calc())->prevDayOfWeekOnOrBefore(3, 22, 11, 2000), 'prevDayOfWeekOnOrBefore 2');
compare('20001122', (new Date_Calc())->nextDayOfWeekOnOrAfter(3, 22, 11, 2000), 'nextDayOfWeekOnOrAfter 1');
compare('20001123', (new Date_Calc())->nextDayOfWeekOnOrAfter(4, 22, 11, 2000), 'nextDayOfWeekOnOrAfter 2');
compare('20001123', (new Date_Calc())->nextDayOfWeekOnOrAfter('4', '22', '11', '2000'), 'nextDayOfWeekOnOrAfter 2 str');

compare('20001120', (new Date_Calc())->beginOfWeek('22', '11', '2000'), 'beginOfWeek str');
compare('20001120', (new Date_Calc())->beginOfWeek(22, 11, 2000), 'beginOfWeek');
compare('20001126', (new Date_Calc())->endOfWeek(22, 11, 2000), 'endOfWeek');
compare('20001126', (new Date_Calc())->endOfWeek('22', '11', '2000'), 'endOfWeek str');

compare('20001113', (new Date_Calc())->beginOfPrevWeek(22, 11, 2000), 'beginOfPrevWeek');
compare('20001127', (new Date_Calc())->beginOfNextWeek(22, 11, 2000), 'beginOfNextWeek');
compare('20001113', (new Date_Calc())->beginOfPrevWeek('22', '11', '2000'), 'beginOfPrevWeek str');
compare('20001127', (new Date_Calc())->beginOfNextWeek('22', '11', '2000'), 'beginOfNextWeek str');

compare('20001101', (new Date_Calc())->beginOfMonth(11, 2000), 'beginOfMonth');
compare('20001101', (new Date_Calc())->beginOfMonth('11', '2000'), 'beginOfMonth str');

compare('20001001', (new Date_Calc())->beginOfPrevMonth(22, 11, 2000), 'beginOfPrevMonth');
compare('20001031', (new Date_Calc())->endOfPrevMonth(22, 11, 2000), 'endOfPrevMonth');
compare('20001001', (new Date_Calc())->beginOfPrevMonth('22', '11', '2000'), 'beginOfPrevMonth str');
compare('20001031', (new Date_Calc())->endOfPrevMonth('22', '11', '2000'), 'endOfPrevMonth str');

compare('20001201', (new Date_Calc())->beginOfNextMonth(22, 11, 2000), 'beginOfNextMonth');
compare('20001231', (new Date_Calc())->endOfNextMonth(22, 11, 2000), 'endOfNextMonth');
compare('20001201', (new Date_Calc())->beginOfNextMonth('22', '11', '2000'), 'beginOfNextMonth str');
compare('20001231', (new Date_Calc())->endOfNextMonth('22', '11', '2000'), 'endOfNextMonth str');

compare('19991001', (new Date_Calc())->beginOfMonthBySpan(-13, 11, 2000), 'beginOfMonthBySpan 1');
compare('20001001', (new Date_Calc())->beginOfMonthBySpan(-1, 11, 2000), 'beginOfMonthBySpan 2');
compare('20001101', (new Date_Calc())->beginOfMonthBySpan(0, 11, 2000), 'beginOfMonthBySpan 3');
compare('20001201', (new Date_Calc())->beginOfMonthBySpan(1, 11, 2000), 'beginOfMonthBySpan 4');
compare('20011201', (new Date_Calc())->beginOfMonthBySpan(13, 11, 2000), 'beginOfMonthBySpan 5');

compare('19990101', (new Date_Calc())->beginOfMonthBySpan('-13', '02', '2000'), 'beginOfMonthBySpan 6 str');
compare('19990101', (new Date_Calc())->beginOfMonthBySpan(-13, 2, 2000), 'beginOfMonthBySpan 6');
compare('20000101', (new Date_Calc())->beginOfMonthBySpan(-1, 2, 2000), 'beginOfMonthBySpan 7');
compare('20000201', (new Date_Calc())->beginOfMonthBySpan(0, 2, 2000), 'beginOfMonthBySpan 8');
compare('20000301', (new Date_Calc())->beginOfMonthBySpan(1, 2, 2000), 'beginOfMonthBySpan 9');
compare('20010301', (new Date_Calc())->beginOfMonthBySpan(13, 2, 2000), 'beginOfMonthBySpan 10');
compare('20010301', (new Date_Calc())->beginOfMonthBySpan('13', '02', '2000'), 'beginOfMonthBySpan 10 str');

compare('19991031', (new Date_Calc())->endOfMonthBySpan(-13, 11, 2000), 'endOfMonthBySpan 1');
compare('20001031', (new Date_Calc())->endOfMonthBySpan(-1, 11, 2000), 'endOfMonthBySpan 2');
compare('20001130', (new Date_Calc())->endOfMonthBySpan(0, 11, 2000), 'endOfMonthBySpan 3');
compare('20001231', (new Date_Calc())->endOfMonthBySpan(1, 11, 2000), 'endOfMonthBySpan 4');
compare('20011231', (new Date_Calc())->endOfMonthBySpan(13, 11, 2000), 'endOfMonthBySpan 5');

compare('19990131', (new Date_Calc())->endOfMonthBySpan('-13', '02', '2000'), 'endOfMonthBySpan 6 str');
compare('19990131', (new Date_Calc())->endOfMonthBySpan(-13, 2, 2000), 'endOfMonthBySpan 6');
compare('20000131', (new Date_Calc())->endOfMonthBySpan(-1, 2, 2000), 'endOfMonthBySpan 7');
compare('20000229', (new Date_Calc())->endOfMonthBySpan(0, 2, 2000), 'endOfMonthBySpan 8');
compare('20000331', (new Date_Calc())->endOfMonthBySpan(1, 2, 2000), 'endOfMonthBySpan 9');
compare('20010331', (new Date_Calc())->endOfMonthBySpan(13, 2, 2000), 'endOfMonthBySpan 10');
compare('20010331', (new Date_Calc())->endOfMonthBySpan('13', '02', '2000'), 'endOfMonthBySpan 10 str');

compare(3, (new Date_Calc())->firstOfMonthWeekday(11, 2000), 'firstOfMonthWeekday');
compare(3, (new Date_Calc())->firstOfMonthWeekday('11', '2000'), 'firstOfMonthWeekday str');

compare('20050101', (new Date_Calc())->NWeekdayOfMonth(1, 6, 1, 2005), 'NWeekdayOfMonth 161');
compare('20050102', (new Date_Calc())->NWeekdayOfMonth(1, 0, 1, 2005), 'NWeekdayOfMonth 101');
compare('20050103', (new Date_Calc())->NWeekdayOfMonth(1, 1, 1, 2005), 'NWeekdayOfMonth 111');
compare('20050104', (new Date_Calc())->NWeekdayOfMonth(1, 2, 1, 2005), 'NWeekdayOfMonth 121');
compare('20050105', (new Date_Calc())->NWeekdayOfMonth(1, 3, 1, 2005), 'NWeekdayOfMonth 131');
compare('20050106', (new Date_Calc())->NWeekdayOfMonth(1, 4, 1, 2005), 'NWeekdayOfMonth 141');
compare('20050107', (new Date_Calc())->NWeekdayOfMonth(1, 5, 1, 2005), 'NWeekdayOfMonth 151');

compare('20050108', (new Date_Calc())->NWeekdayOfMonth('2', '6', '01', '2005'), 'NWeekdayOfMonth 261');
compare('20050109', (new Date_Calc())->NWeekdayOfMonth('2', '0', '01', '2005'), 'NWeekdayOfMonth 201');
compare('20050110', (new Date_Calc())->NWeekdayOfMonth('2', '1', '01', '2005'), 'NWeekdayOfMonth 211');
compare('20050111', (new Date_Calc())->NWeekdayOfMonth('2', '2', '01', '2005'), 'NWeekdayOfMonth 221');
compare('20050112', (new Date_Calc())->NWeekdayOfMonth('2', '3', '01', '2005'), 'NWeekdayOfMonth 231');
compare('20050113', (new Date_Calc())->NWeekdayOfMonth('2', '4', '01', '2005'), 'NWeekdayOfMonth 241');
compare('20050114', (new Date_Calc())->NWeekdayOfMonth('2', '5', '01', '2005'), 'NWeekdayOfMonth 251');

compare('20050131', (new Date_Calc())->NWeekdayOfMonth('last', 1, 1, 2005), 'NWeekdayOfMonth l11');
compare('20050130', (new Date_Calc())->NWeekdayOfMonth('last', 0, 1, 2005), 'NWeekdayOfMonth l01');
compare('20050129', (new Date_Calc())->NWeekdayOfMonth('last', 6, 1, 2005), 'NWeekdayOfMonth l61');
compare('20050128', (new Date_Calc())->NWeekdayOfMonth('last', 5, 1, 2005), 'NWeekdayOfMonth l51');
compare('20050127', (new Date_Calc())->NWeekdayOfMonth('last', 4, 1, 2005), 'NWeekdayOfMonth l41');
compare('20050126', (new Date_Calc())->NWeekdayOfMonth('last', 3, 1, 2005), 'NWeekdayOfMonth l31');
compare('20050125', (new Date_Calc())->NWeekdayOfMonth('last', 2, 1, 2005), 'NWeekdayOfMonth l21');

compare('20050331', (new Date_Calc())->NWeekdayOfMonth('last', 4, 3, 2005), 'NWeekdayOfMonth l43');
compare('20050330', (new Date_Calc())->NWeekdayOfMonth('last', 3, 3, 2005), 'NWeekdayOfMonth l33');
compare('20050329', (new Date_Calc())->NWeekdayOfMonth('last', 2, 3, 2005), 'NWeekdayOfMonth l23');
compare('20050328', (new Date_Calc())->NWeekdayOfMonth('last', 1, 3, 2005), 'NWeekdayOfMonth l13');
compare('20050327', (new Date_Calc())->NWeekdayOfMonth('last', 0, 3, 2005), 'NWeekdayOfMonth l03');
compare('20050326', (new Date_Calc())->NWeekdayOfMonth('last', 6, 3, 2005), 'NWeekdayOfMonth l63');
compare('20050325', (new Date_Calc())->NWeekdayOfMonth('last', 5, 3, 2005), 'NWeekdayOfMonth l53');


compare(false, (new Date_Calc())->isValidDate(29, 2, 1900), 'isValidDate 1');
compare(true, (new Date_Calc())->isValidDate(29, 2, 2000), 'isValidDate 2');
compare(true, (new Date_Calc())->isValidDate('29', '02', '2000'), 'isValidDate 2 str');

compare(false, (new Date_Calc())->isLeapYear(1900), 'isLeapYear 1');
compare(true, (new Date_Calc())->isLeapYear(1996), 'isLeapYear 2');
compare(true, (new Date_Calc())->isLeapYear(2000), 'isLeapYear 3');
compare(false, (new Date_Calc())->isLeapYear(2001), 'isLeapYear 4');
compare(false, (new Date_Calc())->isLeapYear('2001'), 'isLeapYear 4 str');

compare(false, (new Date_Calc())->isFutureDate('22', '11', '2000'), 'isFutureDate 1 str');
compare(false, (new Date_Calc())->isFutureDate(22, 11, 2000), 'isFutureDate 1');
compare(true, (new Date_Calc())->isFutureDate(22, 11, date('Y') + 1), 'isFutureDate 2');

compare(false, (new Date_Calc())->isPastDate(22, 11, date('Y') + 1), 'isPastDate 1');
compare(true, (new Date_Calc())->isPastDate(22, 11, 2000), 'isPastDate 2');
compare(true, (new Date_Calc())->isPastDate('22', '11', '2000'), 'isPastDate 2 str');

compare(10, (new Date_Calc())->dateDiff(22, 11, 2000, 12, 11, 2000), 'dateDiff 1');
compare(10, (new Date_Calc())->dateDiff(12, 11, 2000, 22, 11, 2000), 'dateDiff 2');
compare(61, (new Date_Calc())->dateDiff(22, 11, 2000, 22, 1, 2001), 'dateDiff 3');
compare(61, (new Date_Calc())->dateDiff('22', '11', '2000', '22', '01', '2001'), 'dateDiff 3 str');

compare(-1, (new Date_Calc())->compareDates(12, 11, 2000, 22, 11, 2000), 'compareDates 1');
compare(0, (new Date_Calc())->compareDates(22, 11, 2000, 22, 11, 2000), 'compareDates 2');
compare(1, (new Date_Calc())->compareDates(22, 11, 2000, 12, 11, 2000), 'compareDates 3');
compare(1, (new Date_Calc())->compareDates('22', '11', '2000', '12', '11', '2000'), 'compareDates 3 str');
