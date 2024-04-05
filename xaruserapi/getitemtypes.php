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

function calendar_userapi_getitemtypes(array $args = [], $context = null)
{
    $itemtypes = [];

    $itemtypes[1] = ['label' => xarML('Event'),
                          'title' => xarML('View Event'),
                          'url'   => xarController::URL('calendar', 'user', 'view'),
                         ];
    $itemtypes[2] = ['label' => xarML('ToDo'),
                          'title' => xarML('View ToDo'),
                          'url'   => xarController::URL('calendar', 'user', 'view'),
                         ];
    $itemtypes[3] = ['label' => xarML('Alarm'),
                          'title' => xarML('View Alarm'),
                          'url'   => xarController::URL('calendar', 'user', 'view'),
                         ];
    $itemtypes[4] = ['label' => xarML('FreeBusy'),
                          'title' => xarML('View FreeBusy'),
                          'url'   => xarController::URL('calendar', 'user', 'view'),
                         ];
    // @todo let's use DataObjectFactory::getModuleItemType here, but not until roles brings in dd automatically
    $extensionitemtypes = xarMod::apiFunc('dynamicdata', 'user', 'getmoduleitemtypes', ['moduleid' => 7, 'native' => false]);

    $keys = array_merge(array_keys($itemtypes), array_keys($extensionitemtypes));
    $values = array_merge(array_values($itemtypes), array_values($extensionitemtypes));
    return array_combine($keys, $values);
}
