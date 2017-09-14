<?php
	/**
		* JSP Location components for Joomla!
		* JSP Location is an interactive store locator
		*
		* @author      $Author: Ajay Lulia $
		* @copyright   Joomla Service Provider - 2016
		* @package     JSP Store Locator 2.2
		* @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
		* @version     $Id: branch.php  $
	*/
	
	// no direct access
	defined('_JEXEC') or die('Restricted access');
	jimport( 'joomla.application.component.controller' );
	jimport('joomla.filesystem.file');
    header('Access-Control-Allow-Origin: *');
	require_once(JPATH_COMPONENT_ADMINISTRATOR.'/'.'models'.'/'.'license.php');
	class jspTicketsControllerLicense extends JControllerLegacy {
        function license(){
    jimport('joomla.filesystem.file');
	$view = $this->getView('license','html');
	$model = $this->getModel('license');
	$view->setModel($model);
	$view->setLayout('default');
	$view->display();
	}
	function savelicense(){
	    $view = $this->getView('license','html');
		$model 	= $this->getModel( 'license' );
		$view->setModel($model);
	 	$view->save(); 	
	}
	function applylicense(){
	   $view = $this->getView('license','html');
		$model 	= $this->getModel( 'license' );
		$view->setModel($model);
	 	$view->apply(); 	
	
	}
	function cancellicense(){
	
	$mainframe = Jfactory::GetApplication();
	jimport('joomla.filesystem.file');    
	$mainframe->redirect('index.php?option=com_jsplocation&task=license');
	
	}		








}
?>		