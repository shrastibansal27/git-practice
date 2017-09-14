<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: ticketlist.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.controlleradmin' );

//require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'category.php');

class jspticketsControllerticketlist extends JControllerAdmin {
	
	function display($cachable = false, $urlparams = Array()){
	
		$model	=$this->getModel( 'tickets' );
		$view =$this->getView( 'tickets' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("list");
		$view->display();	
	}
	
	function add(){
		$model	=$this->getModel( 'tickets' );
		$view =$this->getView( 'tickets' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("form");
		$view->form();	
	}
	
	function edit(){
	
			
		$model	=$this->getModel( 'tickets' );
		$view =$this->getView( 'tickets' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("form");
		$view->form();	
	}
	
	function remove()
	{
		$model	=$this->getModel( 'tickets' );
		$view =$this->getView( 'tickets' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("list");
		$view->remove();	
	}
	
	function follow()
	{
		$model	=$this->getModel( 'tickets' );
		$view =$this->getView( 'tickets' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("list");
		$view->follow();
	}
	
	function unfollow()
	{
		$model	=$this->getModel( 'tickets' );
		$view =$this->getView( 'tickets' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("list");
		$view->unfollow();
	}
	
	/*function checkin()
	{
		$mainframe = Jfactory::GetApplication();
		$cid = JRequest::getVar('cid',  0, '', 'array');
		$model	=$this->getModel( 'tickets' );
		$config = $model->getConfig();
		foreach($cid as $item)
		{
			$model->unlockticket($item);
		}
		
		$msg = JText::_("ITEM_CHECKEDIN_SUCCESSFULLY");
		$mainframe->redirect('index.php?option=com_jsptickets&task=ticketlist', $msg, 'message');
	}*/
	
	function cancel(){
		$session = JFactory::getSession();
		$user = JFactory::getUser();
		$mainframe = Jfactory::GetApplication();
		
		$ItemId = $session->get( 'Itemid' );
		$session->set( 'guestname', '' );
		$session->set( 'guestemail', '' );
		$session->set( 'ticketid', '' );

		$msg = '';
		
		if($user->id == 0)
		{
			$mainframe->redirect(JRoute::_('index.php?option=com_jsptickets&Itemid='.$ItemId), $msg);
		} else {
			$mainframe->redirect(JURI::Base(), $msg);
		}
	}
	
}