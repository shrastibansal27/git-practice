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

require_once(JPATH_COMPONENT_ADMINISTRATOR.'/'.'models'.'/'.'googleplaces.php');
//require_once(JPATH_COMPONENT_ADMINISTRATOR.'/'.'models'.'/'.'fields.php');
	
class jspLocationControllerGoogleplaces extends JControllerLegacy {
function display($cachable = false, $urlparams=false){
		$model	= $this->getModel( 'googleplaces' );	
		$view = $this->getView('googleplaces');
		$view->setModel( $model, true );
		$view->setLayout("default");
		$view->display();
	}
	
	
	function SelectLocationid($tpl = null){
		$mainframe = Jfactory::GetApplication();
		$id =		JRequest::getVar('id');
		$model	= $this->getModel('googleplaces');
		$view = $this->getView('googleplaces');
		$view->setModel( $model, true );
		$view->setLayout("default");
		$view->selectionData();
	}
	
	function SearchGooglePlaces($tpl= null){
		$mainframe = Jfactory::GetApplication();
		$search = JRequest::getVar('search');
		$model	= $this->getModel('googleplaces');
		$view = $this->getView('googleplaces');
		$view->setModel( $model, true );
		$view->setLayout("default");
		$view->setGoogleData();
	}
	function save($tpl = null){
		$apikey = JRequest::getVar('apikey');
		$model	= $this->getModel('googleplaces');
		$view = $this->getView('googleplaces');
		$view->setModel( $model, true );
		$view->setLayout("default");
		$view->saveData();
    }
	
	function apply($tpl = null){
		$apikey = JRequest::getVar('apikey');
		//echo $apikey;die;
		$model	= $this->getModel('googleplaces');
		$view = $this->getView('googleplaces');
		$view->setModel( $model, true );
		$view->setLayout("default");
		$view->saveData();
    }
	
	function cancel($tpl = null){
    $view = $this->getView('googleplaces');
    $view->cancelData();
    }
}
?>