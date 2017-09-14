<?php

/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2015
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: admin.jsplocation.php  $
 */
 
// no direct access
ini_set('display_errors', '0');
defined( '_JEXEC' ) or die( 'Restricted access' );
JSubMenuHelper::addEntry(JText::_('BRANCH_LIST'), 'index.php?option=com_jsplocation&task=branch',false);
JSubMenuHelper::addEntry(JText::_('FIELDS_LIST'), 'index.php?option=com_jsplocation&task=fields',false);
JSubMenuHelper::addEntry(JText::_('COUNTRY_LIST'), 'index.php?option=com_jsplocation&task=country',false);
JSubMenuHelper::addEntry(JText::_('STATE_LIST'), 'index.php?option=com_jsplocation&task=state',false);
JSubMenuHelper::addEntry(JText::_('CITY_LIST'), 'index.php?option=com_jsplocation&task=city',false);
JSubMenuHelper::addEntry(JText::_('AREA_LIST'), 'index.php?option=com_jsplocation&task=area',false);
JSubMenuHelper::addEntry(JText::_('CATEGORY_LIST'), 'index.php?option=com_jsplocation&task=category',false);
JSubMenuHelper::addEntry(JText::_('GOOGLE_PLACES'), 'index.php?option=com_jsplocation&task=googleplaces',false);
JSubMenuHelper::addEntry(JText::_('CONFIGURATION'), 'index.php?option=com_jsplocation&task=configuration',false);
JSubMenuHelper::addEntry(JText::_('BRANCHHIT_GRAPHS'), 'index.php?option=com_jsplocation&task=brgraph',false);
JSubMenuHelper::addEntry(JText::_('ZIPHIT_GRAPHS'), 'index.php?option=com_jsplocation&task=zipgraph',false);

require_once (JPATH_COMPONENT.'/'.'controller.php');
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base()."components/com_jsplocation/css/jsplocation.css");
//$task	= JRequest::getCmd('task');

$input=JFactory::getApplication()->input;

$task= $input->get('task');

$controller = $input->get('controller', $task);



if($controller) {
	
	$path = JPATH_COMPONENT.'/'.'controllers'.'/'.$controller.'.php';

	if (file_exists($path)) {
		require_once $path;
		
	} else {
		$controller = '';
	}
}
JTable::addIncludePath(JPATH_ADMINISTRATOR.'/'.'components'.'/'.'com_jsplocation'.'/'.'tables');


$id 	= $input->post->get('id',0,'get','int');

$cid 	= $input->post->get('cid', array(0), 'post', 'array');

JArrayHelper::toInteger($cid, array(0));

$classname	= 'jspLocationController'.ucfirst($controller);
$cont= new $classname();

$cont->execute($input->get('task'));

$cont->redirect();



?>