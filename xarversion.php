<?php
/**
 * Calendar Module
 *
 * @package modules
 * @subpackage calendar module
 * @category Third Party Xaraya Module
 * @version 1.0.0
 * @copyright (C) 2014 Netspan AG
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @author Marc Lutolf <mfl@netspan.ch>
 */


$modversion['name']           = 'calendar';
$modversion['id']             = '7';
$modversion['version']        = '1.0.0';
$modversion['displayname']    = xarML('Calendar');
$modversion['description']    = 'Calendar System';
$modversion['credits']        = 'credits.txt';
$modversion['help']           = 'help.txt';
$modversion['changelog']      = 'changelog.txt';
$modversion['license']        = 'license.txt';
$modversion['official']       = 0;
$modversion['author']         = 'Roger Raymond and Xaraya calendar team';
$modversion['contact']        = 'http://xaraya.simiansynapse.com/';
$modversion['admin']          = 1;
$modversion['user']           = 1;
$modversion['class']          = 'Complete';
$modversion['category']       = 'Content';
$modversion['dependency']     = array(
//                                        8,
                                     ); // we need the icalendar module installed
$modversion['dependencyinfo'] = array(
//                                    8 => 'icalendar',
                                     );
$modversion['securityschema'] = array('calendar::event'     => 'Event Title::Event ID',
                                      'calendar::category'  => 'Category Name::Category ID',
                                      'calendar::topic'     => 'Topic Name::Topic ID',
                                      'calendar::user'      => 'User Name::User ID',
                                      'calendar::sharing'   => 'User Name::User ID',
                                      'calendar::'          => '::');

?>