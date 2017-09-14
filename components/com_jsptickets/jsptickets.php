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
 
require_once( JPATH_COMPONENT.'/'.'controller.php' );
$task = JRequest::getCmd('task');
if($controller = JRequest::getWord('controller', $task)) {
	
	$path = JPATH_COMPONENT.'/'.'controllers'.'/'.$controller.'.php';

	if (file_exists($path)) {
		require_once $path;
		
	} else {
		$controller = '';
	}
}
JTable::addIncludePath(JPATH_COMPONENT.'/'.'components'.'/'.'com_jsptickets'.'/'.'tables');

$task	= JRequest::getCmd('task');
$id 	= JRequest::getVar('id', 0, 'get', 'int');
$cid 	= JRequest::getVar('cid', array(0), 'post', 'array');
JArrayHelper::toInteger($cid, array(0));

$classname	= 'jspticketsController'.ucfirst($controller);
$controller	= new $classname( );

$controller->execute(JRequest::getCmd( 'task' ));

$controller->redirect();
?>