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
 *  calendar_userapi_createUserDateTime
 *  return the date/time for a user based on timezone/locale
 *  @version $Id: createuserdatetime.php,v 1.1 2003/06/24 20:01:14 roger Exp $
 *  @author Roger Raymond
 *  @param string $format valid date/time format using php's date() function
 *  @return string valid date/time
 *  @todo user timezone modifications
 */
function &calendar_userapi_createUserDateTime($format='Ymd')
{
    return gmdate($format);

    /*
    if(xarUserLoggedIn()) {
        // $tzoffest = user's timezone offset
    } else {
        // $tzoffset = site's timezone offset
    }
    */
}
