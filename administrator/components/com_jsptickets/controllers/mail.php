<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: mail.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.controller' );

class jspticketsControllermail extends JControllerLegacy {
	
	function display($cachable = false, $urlparams = Array()){
		$model	=$this->getModel( 'mail' );
		$view =$this->getView( 'mail' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("default");
		$view->display();	
	}
	
	function save(){
		$model	=$this->getModel( 'mail' );
		$view =$this->getView( 'mail' , 'html' );
		$view->setModel( $model, true);
		$view->saveData();	
	}
	
	function apply(){
		$model	=$this->getModel( 'mail' );
		$view =$this->getView( 'mail' , 'html' );
		$view->setModel( $model, true);
		$view->saveData();	
	}
	
	function cancel(){
		$mainframe = Jfactory::GetApplication();
		$msg = '';
		$mainframe->redirect('index.php?option=com_jsptickets&task=jsptickets', $msg);
	}
}