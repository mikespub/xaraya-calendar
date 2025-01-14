<?php

/**
 * @package modules\calendar
 * @category Xaraya Web Applications Framework
 * @version 2.5.7
 * @copyright see the html/credits.html file in this release
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link https://github.com/mikespub/xaraya-modules
**/

namespace Xaraya\Modules\Calendar\AdminApi;


use Xaraya\Modules\Calendar\AdminApi;
use Xaraya\Modules\MethodClass;
use xarMod;
use xarModHooks;
use xarDB;
use sys;
use Exception;

sys::import('xaraya.modules.method');

/**
 * calendar adminapi delete_calendar function
 * @extends MethodClass<AdminApi>
 */
class DeleteCalendarMethod extends MethodClass
{
    /** functions imported by bermuda_cleanup */

    /**
     * Delete a calendar from database
     * Usage : if (xarMod::apiFunc('calendar', 'admin', 'delete', $calendar)) {...}
     * @param array<mixed> $args
     * @var mixed $calid ID of the calendar
     * @return bool|null true on success, false on failure
     */
    public function __invoke(array $args = [])
    {
        // Get arguments from argument array
        extract($args);

        // Argument check
        if (!isset($calid)) {
            $msg = $this->translate(
                'Invalid #(1) for #(2) function #(3)() in module #(4)',
                'calendar ID',
                'admin',
                'delete',
                'Calendar'
            );
            throw new Exception($msg);
        }

        // TODO: Security check
        /*
            if (!xarMod::apiLoad('calendar', 'user')) return;

            $args['mask'] = 'DeleteCalendars';
            if (!xarMod::apiFunc('calendar','user','checksecurity',$args)) {
                $msg = $this->translate('Not authorized to delete #(1) items',
                            'Calendar');
                throw new Exception($msg);
            }
        */
        // Call delete hooks for categories, hitcount etc.
        $args['module'] = 'calendar';
        $args['itemid'] = $calid;
        xarModHooks::call('item', 'delete', $calid, $args);

        // Get database setup
        $dbconn = xarDB::getConn();
        $xartable = & xarDB::getTables();
        $calendarstable = $xartable['calendars'];
        $cal_filestable = $xartable['calendars_files'];
        $calfiles = $xartable['calfiles'];

        // Get files associated with that calendar
        $query = "SELECT xar_files_id FROM $cal_filestable
                 WHERE xar_calendars_id = ? LIMIT 1 ";
        $result = $dbconn->Execute($query, [$calid]);
        if (!$result) {
            return;
        }

        for (; !$result->EOF; $result->MoveNext()) {
            // there should be only one result
            [$file_id] = $result -> fields;
        }

        if (isset($file_id) || !empty($file_id)) {
            $query = "DELETE FROM $calfiles
                      WHERE xar_id = ?";
            $result = $dbconn->Execute($query, [$file_id]);
            if (!$result) {
                return;
            }
        }

        // Delete item
        $query = "DELETE FROM $calendarstable
                  WHERE xar_id = ?";
        $result = $dbconn->Execute($query, [$calid]);
        if (!$result) {
            return;
        }

        $query = "DELETE FROM $cal_filestable
                  WHERE xar_calendars_id = ?";
        $result = $dbconn->Execute($query, [$calid]);
        if (!$result) {
            return;
        }

        $result -> Close();

        return true;
    }
}
