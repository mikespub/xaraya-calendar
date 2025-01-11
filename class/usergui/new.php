<?php

/**
 * @package modules\calendar
 * @category Xaraya Web Applications Framework
 * @version 2.5.7
 * @copyright see the html/credits.html file in this release
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link https://github.com/mikespub/xaraya-modules
**/

namespace Xaraya\Modules\Calendar\UserGui;


use Xaraya\Modules\Calendar\UserGui;
use Xaraya\Modules\MethodClass;
use xarSecurity;
use xarVar;
use xarSession;
use xarSec;
use DataObjectFactory;
use sys;
use BadParameterException;

sys::import('xaraya.modules.method');

/**
 * calendar user new function
 * @extends MethodClass<UserGui>
 */
class NewMethod extends MethodClass
{
    /** functions imported by bermuda_cleanup */

    /**
     * Create a new item of the event object
     */
    public function __invoke(array $args = [])
    {
        if (!xarSecurity::check('AddCalendar')) {
            return;
        }

        if (!xarVar::fetch('page', 'str:1', $data['page'], 'week', xarVar::NOT_REQUIRED)) {
            return;
        }
        xarSession::setVar('ddcontext.calendar', ['page' => $data['page'],
        ]);
        $data['object'] = DataObjectFactory::getObject(['name' => 'calendar_event']);
        $data['tplmodule'] = 'calendar';
        $data['authid'] = xarSec::genAuthKey();
        return $data;
    }
}
