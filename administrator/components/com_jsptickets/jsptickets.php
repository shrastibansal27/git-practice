<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: jsptickets.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
require_once (JPATH_COMPONENT.'/'.'controller.php');
$task	= JRequest::getCmd('task');
$controller_1 = JRequest::getCmd('controller');

if($task == 'catlist' || $controller_1 == 'catlist')
{
	JSubMenuHelper::addEntry(JText::_('DASHBOARD'), 'index.php?option=com_jsptickets',false);
	JSubMenuHelper::addEntry(JText::_('LICENSE'), 'index.php?option=com_jsptickets&task=license',false);
	JSubMenuHelper::addEntry(JText::_('CATEGORY_MANAGEMENT'), 'index.php?option=com_jsptickets&task=catlist',true);
	JSubMenuHelper::addEntry(JText::_('TICKETS_MANAGEMENT'), 'index.php?option=com_jsptickets&task=ticketlist',false);
	JSubMenuHelper::addEntry(JText::_('STATUS_MANAGEMENT'), 'index.php?option=com_jsptickets&task=statuslist',false);
	JSubMenuHelper::addEntry(JText::_('PRIORITY_MANAGEMENT'), 'index.php?option=com_jsptickets&task=prioritylist',false);
	JSubMenuHelper::addEntry(JText::_('CONFIGURATION'), 'index.php?option=com_jsptickets&task=config',false);
	JSubMenuHelper::addEntry(JText::_('MAIL_SETTINGS'), 'index.php?option=com_jsptickets&task=mail',false);
	JSubMenuHelper::addEntry(JText::_('ABOUT'), 'index.php?option=com_jsptickets&controller=jsptickets&task=about',false);
} else if($task == 'ticketlist' || $controller_1 == 'ticketlist')
{
	JSubMenuHelper::addEntry(JText::_('DASHBOARD'), 'index.php?option=com_jsptickets',false);
	JSubMenuHelper::addEntry(JText::_('LICENSE'), 'index.php?option=com_jsptickets&task=license',false);
	JSubMenuHelper::addEntry(JText::_('CATEGORY_MANAGEMENT'), 'index.php?option=com_jsptickets&task=catlist',false);
	JSubMenuHelper::addEntry(JText::_('TICKETS_MANAGEMENT'), 'index.php?option=com_jsptickets&task=ticketlist',true);
	JSubMenuHelper::addEntry(JText::_('STATUS_MANAGEMENT'), 'index.php?option=com_jsptickets&task=statuslist',false);
	JSubMenuHelper::addEntry(JText::_('PRIORITY_MANAGEMENT'), 'index.php?option=com_jsptickets&task=prioritylist',false);
	JSubMenuHelper::addEntry(JText::_('CONFIGURATION'), 'index.php?option=com_jsptickets&task=config',false);
	JSubMenuHelper::addEntry(JText::_('MAIL_SETTINGS'), 'index.php?option=com_jsptickets&task=mail',false);
	JSubMenuHelper::addEntry(JText::_('ABOUT'), 'index.php?option=com_jsptickets&controller=jsptickets&task=about',false);
} else if($task == 'statuslist' || $controller_1 == 'statuslist')
{
	JSubMenuHelper::addEntry(JText::_('DASHBOARD'), 'index.php?option=com_jsptickets',false);
	JSubMenuHelper::addEntry(JText::_('LICENSE'), 'index.php?option=com_jsptickets&task=license',false);
	JSubMenuHelper::addEntry(JText::_('CATEGORY_MANAGEMENT'), 'index.php?option=com_jsptickets&task=catlist',false);
	JSubMenuHelper::addEntry(JText::_('TICKETS_MANAGEMENT'), 'index.php?option=com_jsptickets&task=ticketlist',false);
	JSubMenuHelper::addEntry(JText::_('STATUS_MANAGEMENT'), 'index.php?option=com_jsptickets&task=statuslist',true);
	JSubMenuHelper::addEntry(JText::_('PRIORITY_MANAGEMENT'), 'index.php?option=com_jsptickets&task=prioritylist',false);
	JSubMenuHelper::addEntry(JText::_('CONFIGURATION'), 'index.php?option=com_jsptickets&task=config',false);
	JSubMenuHelper::addEntry(JText::_('MAIL_SETTINGS'), 'index.php?option=com_jsptickets&task=mail',false);
	JSubMenuHelper::addEntry(JText::_('ABOUT'), 'index.php?option=com_jsptickets&controller=jsptickets&task=about',false);
}
else if($task == 'license' || $controller_1 == 'license')
{
	JSubMenuHelper::addEntry(JText::_('DASHBOARD'), 'index.php?option=com_jsptickets',false);
	JSubMenuHelper::addEntry(JText::_('LICENSE'), 'index.php?option=com_jsptickets&task=license',true);
	JSubMenuHelper::addEntry(JText::_('CATEGORY_MANAGEMENT'), 'index.php?option=com_jsptickets&task=catlist',false);
	JSubMenuHelper::addEntry(JText::_('TICKETS_MANAGEMENT'), 'index.php?option=com_jsptickets&task=ticketlist',false);
	JSubMenuHelper::addEntry(JText::_('STATUS_MANAGEMENT'), 'index.php?option=com_jsptickets&task=statuslist',false);
	JSubMenuHelper::addEntry(JText::_('PRIORITY_MANAGEMENT'), 'index.php?option=com_jsptickets&task=prioritylist',false);
	JSubMenuHelper::addEntry(JText::_('CONFIGURATION'), 'index.php?option=com_jsptickets&task=config',false);
	JSubMenuHelper::addEntry(JText::_('MAIL_SETTINGS'), 'index.php?option=com_jsptickets&task=mail',false);
	JSubMenuHelper::addEntry(JText::_('ABOUT'), 'index.php?option=com_jsptickets&controller=jsptickets&task=about',false);
} else if($task == 'prioritylist' || $controller_1 == 'prioritylist')
{
	JSubMenuHelper::addEntry(JText::_('DASHBOARD'), 'index.php?option=com_jsptickets',false);
	JSubMenuHelper::addEntry(JText::_('LICENSE'), 'index.php?option=com_jsptickets&task=license',false);
	JSubMenuHelper::addEntry(JText::_('CATEGORY_MANAGEMENT'), 'index.php?option=com_jsptickets&task=catlist',false);
	JSubMenuHelper::addEntry(JText::_('TICKETS_MANAGEMENT'), 'index.php?option=com_jsptickets&task=ticketlist',false);
	JSubMenuHelper::addEntry(JText::_('STATUS_MANAGEMENT'), 'index.php?option=com_jsptickets&task=statuslist',false);
	JSubMenuHelper::addEntry(JText::_('PRIORITY_MANAGEMENT'), 'index.php?option=com_jsptickets&task=prioritylist',true);
	JSubMenuHelper::addEntry(JText::_('CONFIGURATION'), 'index.php?option=com_jsptickets&task=config',false);
	JSubMenuHelper::addEntry(JText::_('MAIL_SETTINGS'), 'index.php?option=com_jsptickets&task=mail',false);
	JSubMenuHelper::addEntry(JText::_('ABOUT'), 'index.php?option=com_jsptickets&controller=jsptickets&task=about',false);
} else if($task == 'config' || $controller_1 == 'config')
{
	JSubMenuHelper::addEntry(JText::_('DASHBOARD'), 'index.php?option=com_jsptickets',false);
	JSubMenuHelper::addEntry(JText::_('LICENSE'), 'index.php?option=com_jsptickets&task=license',false);
	JSubMenuHelper::addEntry(JText::_('CATEGORY_MANAGEMENT'), 'index.php?option=com_jsptickets&task=catlist',false);
	JSubMenuHelper::addEntry(JText::_('TICKETS_MANAGEMENT'), 'index.php?option=com_jsptickets&task=ticketlist',false);
	JSubMenuHelper::addEntry(JText::_('STATUS_MANAGEMENT'), 'index.php?option=com_jsptickets&task=statuslist',false);
	JSubMenuHelper::addEntry(JText::_('PRIORITY_MANAGEMENT'), 'index.php?option=com_jsptickets&task=prioritylist',false);
	JSubMenuHelper::addEntry(JText::_('CONFIGURATION'), 'index.php?option=com_jsptickets&task=config',true);
	JSubMenuHelper::addEntry(JText::_('MAIL_SETTINGS'), 'index.php?option=com_jsptickets&task=mail',false);
	JSubMenuHelper::addEntry(JText::_('ABOUT'), 'index.php?option=com_jsptickets&controller=jsptickets&task=about',false);
} else if($task == 'mail' || $controller_1 == 'mail')
{
	JSubMenuHelper::addEntry(JText::_('DASHBOARD'), 'index.php?option=com_jsptickets',false);
	JSubMenuHelper::addEntry(JText::_('LICENSE'), 'index.php?option=com_jsptickets&task=license',false);
	JSubMenuHelper::addEntry(JText::_('CATEGORY_MANAGEMENT'), 'index.php?option=com_jsptickets&task=catlist',false);
	JSubMenuHelper::addEntry(JText::_('TICKETS_MANAGEMENT'), 'index.php?option=com_jsptickets&task=ticketlist',false);
	JSubMenuHelper::addEntry(JText::_('STATUS_MANAGEMENT'), 'index.php?option=com_jsptickets&task=statuslist',false);
	JSubMenuHelper::addEntry(JText::_('PRIORITY_MANAGEMENT'), 'index.php?option=com_jsptickets&task=prioritylist',false);
	JSubMenuHelper::addEntry(JText::_('CONFIGURATION'), 'index.php?option=com_jsptickets&task=config',false);
	JSubMenuHelper::addEntry(JText::_('MAIL_SETTINGS'), 'index.php?option=com_jsptickets&task=mail',true);
	JSubMenuHelper::addEntry(JText::_('ABOUT'), 'index.php?option=com_jsptickets&controller=jsptickets&task=about',false);
} else if($task == 'about' && $controller_1 == 'jsptickets')
{
	JSubMenuHelper::addEntry(JText::_('DASHBOARD'), 'index.php?option=com_jsptickets',false);
	JSubMenuHelper::addEntry(JText::_('LICENSE'), 'index.php?option=com_jsptickets&task=license',false);
	JSubMenuHelper::addEntry(JText::_('CATEGORY_MANAGEMENT'), 'index.php?option=com_jsptickets&task=catlist',false);
	JSubMenuHelper::addEntry(JText::_('TICKETS_MANAGEMENT'), 'index.php?option=com_jsptickets&task=ticketlist',false);
	JSubMenuHelper::addEntry(JText::_('STATUS_MANAGEMENT'), 'index.php?option=com_jsptickets&task=statuslist',false);
	JSubMenuHelper::addEntry(JText::_('PRIORITY_MANAGEMENT'), 'index.php?option=com_jsptickets&task=prioritylist',false);
	JSubMenuHelper::addEntry(JText::_('CONFIGURATION'), 'index.php?option=com_jsptickets&task=config',false);
	JSubMenuHelper::addEntry(JText::_('MAIL_SETTINGS'), 'index.php?option=com_jsptickets&task=mail',false);
	JSubMenuHelper::addEntry(JText::_('ABOUT'), 'index.php?option=com_jsptickets&controller=jsptickets&task=about',true);
} else {
	JSubMenuHelper::addEntry(JText::_('DASHBOARD'), 'index.php?option=com_jsptickets',true);
	JSubMenuHelper::addEntry(JText::_('LICENSE'), 'index.php?option=com_jsptickets&task=license',false);
	JSubMenuHelper::addEntry(JText::_('CATEGORY_MANAGEMENT'), 'index.php?option=com_jsptickets&task=catlist',false);
	JSubMenuHelper::addEntry(JText::_('TICKETS_MANAGEMENT'), 'index.php?option=com_jsptickets&task=ticketlist',false);
	JSubMenuHelper::addEntry(JText::_('STATUS_MANAGEMENT'), 'index.php?option=com_jsptickets&task=statuslist',false);
	JSubMenuHelper::addEntry(JText::_('PRIORITY_MANAGEMENT'), 'index.php?option=com_jsptickets&task=prioritylist',false);
	JSubMenuHelper::addEntry(JText::_('CONFIGURATION'), 'index.php?option=com_jsptickets&task=config',false);
	JSubMenuHelper::addEntry(JText::_('MAIL_SETTINGS'), 'index.php?option=com_jsptickets&task=mail',false);
	JSubMenuHelper::addEntry(JText::_('ABOUT'), 'index.php?option=com_jsptickets&controller=jsptickets&task=about',false);
}

require_once (JPATH_COMPONENT.'/'.'controller.php');
$task	= JRequest::getCmd('task');

if($controller = JRequest::getWord('controller', $task)) {
	
	$path = JPATH_COMPONENT.'/'.'controllers'.'/'.$controller.'.php';

	if (file_exists($path)) {
		require_once $path;
		
	} else {
		$controller = '';
	}
}
JTable::addIncludePath(JPATH_ADMINISTRATOR.'/'.'components'.'/'.'com_jsptickets'.'/'.'tables');

$task	= JRequest::getCmd('task');
$id 	= JRequest::getVar('id', 0, 'get', 'int');
$cid 	= JRequest::getVar('cid', array(0), 'post', 'array');
JArrayHelper::toInteger($cid, array(0));

$classname	= 'jspticketsController'.ucfirst($controller);
$controller	= new $classname( );

$controller->execute(JRequest::getCmd( 'task' ));

$controller->redirect();

?>