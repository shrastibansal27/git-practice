<?php
	/**
		* JSP Location components for Joomla!
		* JSP Location is an interactive store locator
		*
		* @author      $Author: Ajay Lulia $
		* @copyright   Joomla Service Provider - 2016
		* @package     JSP Store Locator 2.2
		* @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
		* @version     $Id: zipgraph.php  $
	*/
	// no direct access
	defined('_JEXEC') or die('Restricted access');
	jimport( 'joomla.application.component.controller' );
	jimport('joomla.filesystem.file');
	class jspLocationControllerZipgraph extends JControllerLegacy {
		function display($cachable = false,$urlparams=false){
			$view = $this->getView('zipgraph','html');
			$view->setLayout("default");
			JToolBarHelper::Cancel('cancel','Close');
			$view->display();
		}
		function cancel(){
			$mainframe = JFactory::getApplication();    
			$mainframe->redirect('index.php?option=com_jsplocation','');
		}
		function closezipgraph(){
			$mainframe = JFactory::getApplication();    
			$mainframe->redirect('index.php?option=com_jsplocation&task=zipgraph','');
		}
		function ziptoday()
		{
			$view = $this->getView('zipgraph','html');
			$view->setLayout("ziptoday");
			JToolBarHelper::Cancel('closezipgraph','Close');
			$view->display();
		}
		function zipweek()
		{
			$view = $this->getView('zipgraph','html');
			$view->setLayout("zipweek");
			JToolBarHelper::Cancel('closezipgraph','Close');
			$view->display();
		}
		function zipmonth()
		{
			$view = $this->getView('zipgraph','html');
			$view->setLayout("zipmonth");
			JToolBarHelper::Cancel('closezipgraph','Close');
			$view->display();
		}
	}
?>