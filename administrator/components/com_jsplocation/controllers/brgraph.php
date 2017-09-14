<?php
	/**
		* JSP Location components for Joomla!
		* JSP Location is an interactive store locator
		*
		* @author      $Author: Ajay Lulia $
		* @copyright   Joomla Service Provider - 2016
		* @package     JSP Store Locator 2.2
		* @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
		* @version     $Id: brgraph.php  $
	*/
	// no direct access
	defined('_JEXEC') or die('Restricted access');
	jimport( 'joomla.application.component.controller' );
	jimport('joomla.filesystem.file');
	class jspLocationControllerBrgraph extends JControllerLegacy {
		function display($cachable = false, $urlparams=false){
			$view = $this->getView('brgraph','html');
			$view->setLayout("default");
			JToolBarHelper::Cancel('cancel','Close');
			$view->display();
		}
		function cancel(){
			$mainframe = JFactory::getApplication();    
			$mainframe->redirect('index.php?option=com_jsplocation','');
		}
		function closebrgraph(){
			$mainframe = JFactory::getApplication();    
			$mainframe->redirect('index.php?option=com_jsplocation&task=brgraph','');
		}
		function brtoday()
		{
			$view = $this->getView('brgraph','html');
			$view->setLayout("branchtoday");
			JToolBarHelper::Cancel('closebrgraph','Close');
			$view->display();
		}
		function brweek()
		{
			$view = $this->getView('brgraph','html');
			$view->setLayout("branchweek");
			JToolBarHelper::Cancel('closebrgraph','Close');
			$view->display();
		}
		function brmonth()
		{
			$view = $this->getView('brgraph','html');
			$view->setLayout("branchmonth");
			JToolBarHelper::Cancel('closebrgraph','Close');
			$view->display();
		}
	}
?>