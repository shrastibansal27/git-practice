<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: jsplocation.php  $
 */
 
// no direct access
//ini_set('display_errors', '0');
defined('_JEXEC') or die('Restricted access');
require_once( JPATH_COMPONENT.'/'.'controller.php' );
// echo JPATH_COMPONENT.'/'.'controller.php';
// die;
//$task	= JRequest::getCmd('task');

$task = JFactory::getApplication()->input->get('task');

$controller = new jsplocationController();
$controller->execute($task);
?>