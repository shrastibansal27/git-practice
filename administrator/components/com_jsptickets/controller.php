<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: controller.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
jimport('joomla.application.component.controller');
 
/**
 * JSP Tickets Component Controller
*/
//echo JRequest::getVar('task');
class jspticketsController extends JControllerLegacy
{
	function display($cachable = false, $urlparams = Array())
	{   
		parent::display();
	}
	function getVersion()
	{
		$params = &JComponentHelper::getParams( 'com_jsptickets' );
		$versionPresent = $params->get( 'version' );
		echo $versionPresent;
		exit;
 	}
}