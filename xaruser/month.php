<?php
/**
 * Calendar Module
 *
 * @package modules
 * @subpackage calendar module
 * @category Third Party Xaraya Module
 * @version 1.0.0
 * @copyright (C) copyright-placeholder
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @author Marc Lutolf <mfl@netspan.ch>
 */

include_once(CALENDAR_ROOT . 'Month/Weekdays.php');
sys::import('xaraya.structures.query');

function calendar_user_month(array $args = [], $context = null)
{
    $data = xarMod::apiFunc('calendar', 'user', 'getUserDateTimeInfo');

    $MonthEvents = new Calendar_Month_Weekdays(
        $data['cal_year'],
        $data['cal_month'] + 1,
        xarModVars::get('calendar', 'cal_sdow')
    );
    $end_time = $MonthEvents->getTimestamp();
    $MonthEvents = new Calendar_Month_Weekdays(
        $data['cal_year'],
        $data['cal_month'],
        xarModVars::get('calendar', 'cal_sdow')
    );
    $start_time = $MonthEvents->getTimestamp();

    $q = new Query('SELECT');
    $a[] = $q->plt('start_time', $start_time);
    $a[] = $q->pge('start_time + duration', $start_time);
    $b[] = $q->plt('start_time', $end_time);
    $b[] = $q->pge('start_time + duration', $end_time);
    $c[] = $q->pgt('start_time', $start_time);
    $c[] = $q->ple('start_time + duration', $end_time);

    $d[] = $q->pqand($a);
    $d[] = $q->pqand($b);
    $d[] = $q->pqand($c);
    $q->qor($d);

    $q->eq('role_id', xarSession::getVar('role_id'));
    $data['conditions'] = $q;

    return $data;
}
