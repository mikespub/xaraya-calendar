<?php
/**
 * View items of the mailer object
 *
 */
    function mailer_admin_view($args)
    {
        if (!xarSecurityCheck('ManageMailer')) return;

        $modulename = 'mailer';

        // Define which object will be shown
        if (!xarVarFetch('objectname', 'str', $objectname, null, XARVAR_DONT_SET)) return;
        if (!empty($objectname)) xarModUserVars::set($modulename,'defaultmastertable', $objectname);

        // Set a return url
        xarSession::setVar('ddcontext.' . $modulename, array('return_url' => xarServer::getCurrentURL()));
        
        $userrealmid = 0;
        
        if (xarModIsAvailable('realms')) {
            $userrealmid = xarModAPIFunc('realms', 'admin', 'getrealmid');
        }

        sys::import('xaraya.structures.query');
        $q = new Query();
        $q->eq('module_id', xarMod::getID('newsletter'));
        if($userrealmid) $q->eq('realm_id', $userrealmid);

        $data['conditions'] = $q;

        // Get the available dropdown options
        $object = DataObjectMaster::getObjectList(array('objectid' => 1));
        $data['objectname'] = xarModUserVars::get($modulename,'defaultmastertable');
        $items = $object->getItems();
        $options = array();
        foreach ($items as $item)
            if (strpos($item['name'],$modulename) !== false)
                $options[] = array('id' => $item['name'], 'name' => $item['name']);
        $data['options'] = $options;
        return $data;
    }
?>