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

/**
 * Delete an item
 * @package modules
 * @copyright (C) copyright-placeholder
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link http://www.xaraya.com
 *
 * @subpackage Dynamic Data module
 * @link http://xaraya.com/index.php/release/182.html
 * @author mikespub <mikespub@xaraya.com>
 */
/**
 * delete item
 * @param 'itemid' the id of the item to be deleted
 * @param 'confirm' confirm that this item can be deleted
 */

sys::import('modules.dynamicdata.class.objects.master');

function calendar_user_delete($args)
{
    extract($args);

    if (!xarVarFetch('objectid', 'isset', $objectid, null, XARVAR_DONT_SET)) {
        return;
    }
    if (!xarVarFetch('name', 'isset', $name, null, XARVAR_DONT_SET)) {
        return;
    }
    if (!xarVarFetch('itemid', 'id', $itemid)) {
        return;
    }
    if (!xarVarFetch('confirm', 'isset', $confirm, null, XARVAR_DONT_SET)) {
        return;
    }
    if (!xarVarFetch('noconfirm', 'isset', $noconfirm, null, XARVAR_DONT_SET)) {
        return;
    }
    if (!xarVarFetch('join', 'isset', $join, null, XARVAR_DONT_SET)) {
        return;
    }
    if (!xarVarFetch('table', 'isset', $table, null, XARVAR_DONT_SET)) {
        return;
    }
    if (!xarVarFetch('tplmodule', 'isset', $tplmodule, null, XARVAR_DONT_SET)) {
        return;
    }
    if (!xarVarFetch('template', 'isset', $template, null, XARVAR_DONT_SET)) {
        return;
    }
    if (!xarVarFetch('return_url', 'isset', $return_url, null, XARVAR_DONT_SET)) {
        return;
    }

    $myobject = DataObjectMaster::getObject(array('objectid' => $objectid,
                                         'name'       => $name,
                                         'join'       => $join,
                                         'table'      => $table,
                                         'itemid'     => $itemid,
                                         'tplmodule'  => $tplmodule,
                                         'template'   => $template,
                                         'extend'     => false));  //Note: this means we only delete this extension, not the parent
    if (empty($myobject)) {
        return;
    }
    $data = $myobject->toArray();

    // Security check
    if (!xarSecurityCheck('DeleteDynamicDataItem', 1, 'Item', $data['moduleid'].":".$data['itemtype'].":".$data['itemid'])) {
        return;
    }

    // recover any session var information and remove it from the var
    $data = array_merge($data, xarMod::apiFunc('dynamicdata', 'user', 'getcontext', array('module' => $tplmodule)));
    //xarSession::setVar('ddcontext.' . $tplmodule, array('tplmodule' => $tplmodule));
    extract($data);

    $myobject->getItem();

    if (empty($confirm)) {
        $data['authid'] = xarSecGenAuthKey();
        $data['object'] = $myobject;

        if (file_exists('code/modules/' . $data['tplmodule'] . '/xartemplates/user-delete.xd') ||
            file_exists('code/modules/' . $data['tplmodule'] . '/xartemplates/admin-delete-' . $data['template'] . '.xd')) {
            return xarTplModule($data['tplmodule'], 'user', 'delete', $data, $data['template']);
        } else {
            return xarTplModule('calendar', 'user', 'delete', $data, $data['template']);
        }
    }

    // If we get here it means that the user has confirmed the action

    if (!xarSecConfirmAuthKey()) {
        return;
    }

    $itemid = $myobject->deleteItem();
    if (!empty($return_url)) {
        xarController::redirect($return_url);
    } else {
        $default = xarModVars::get('calendar', 'default_view');
        xarController::redirect(xarModURL(
            'calendar',
            'user',
            $default,
            array(
                                      'page' => $default
                                      )
        ));
    }
    return true;
}
