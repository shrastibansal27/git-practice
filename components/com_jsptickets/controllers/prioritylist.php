<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: prioritylist.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.controlleradmin' );

class jspticketsControllerprioritylist extends JControllerAdmin {
	
	function display($cachable = false, $urlparams = Array()){
		$model	=$this->getModel( 'priority' );
		$view =$this->getView( 'priority' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("list");
		$view->display();	
	}
	
	function publish(){
		if( JRequest::getVar('task') == 'unpublish' )
		{
			$this->unpublish();
		}
		$model	=$this->getModel( 'priority' );
		$view =$this->getView( 'priority' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("list");
		$view->state('publish');	
	}
	
	function unpublish(){
		if( JRequest::getVar('task') == 'publish' )
		{
			$this->publish();
		}
		$model	=$this->getModel( 'priority' );
		$view =$this->getView( 'priority' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("list");
		$view->state('unpublish');	
	}
	
	function add(){
		$model	=$this->getModel( 'priority' );
		$view =$this->getView( 'priority' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("form");
		$view->form();	
	}
	
	function edit(){
		$model	=$this->getModel( 'priority' );
		$view =$this->getView( 'priority' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("form");
		$view->form();	
	}
		
	function cancel(){
		$mainframe = Jfactory::GetApplication();
		$msg = '';
		$mainframe->redirect('index.php?option=com_jsptickets&task=jsptickets', $msg);
	}
	
	function remove()
	{
		$model	=$this->getModel( 'priority' );
		$view =$this->getView( 'priority' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("list");
		$view->remove();	
	}
}