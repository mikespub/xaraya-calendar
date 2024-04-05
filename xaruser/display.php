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

sys::import('modules.dynamicdata.class.objects.factory');

/**
 * Display an item of the event object
 *
 */
function calendar_user_display(array $args = [], $context = null)
{
    if (!xarSecurity::check('ReadCalendar')) {
        return;
    }

    if (!xarVar::fetch('itemid', 'int', $data['itemid'], 0, xarVar::NOT_REQUIRED)) {
        return;
    }
    if (!xarVar::fetch('page', 'str:1', $data['page'], 'week', xarVar::NOT_REQUIRED)) {
        return;
    }
    $data['object'] = DataObjectFactory::getObject(['name' => 'calendar_event']);
    $data['object']->getItem(['itemid' => $data['itemid']]);
    $data['tplmodule'] = 'calendar';
    $data['authid'] = xarSec::genAuthKey();
    return $data;
}
