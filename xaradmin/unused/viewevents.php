<?php
    function calendar_admin_viewevents($args)
    {
        if (!xarSecurityCheck('EditCalendar')) {
            return;
        }
        $data['object'] = xarMod::apiFunc('dynamicdata', 'user', 'getobjectlist', array('name' => 'calendar_event'));
        $data['object']->getItems();
        return xarTplModule('calendar', 'admin', 'view', $data);
    }
