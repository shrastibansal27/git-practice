<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: ticketform.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.controllerform' );

//require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'category.php');

class jspticketsControllerticketform extends JControllerForm {
	
	function display($cachable = false, $urlparams = Array()){
		$model	=$this->getModel( 'tickets' );
		$view =$this->getView( 'tickets' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("form");
		$view->display();	
	}
	
	function save(){
		$model	=$this->getModel( 'tickets' );
		$view =$this->getView( 'tickets' , 'html' );
		$view->setModel( $model, true);		
		$view->saveData();	
	}
	
	function apply(){
		$model	=$this->getModel( 'tickets' );
		$view =$this->getView( 'tickets' , 'html' );
		$view->setModel( $model, true);		
		$view->saveData();	
	}
	
	function cancel(){
		$mainframe = Jfactory::GetApplication();
		$model = $this->getModel("tickets");
		$post = JRequest::get('post');
		$session = JFactory::getSession(); // needed for guest user
		if($session->get("Itemid") != "")
		{
			$ItemId = $session->get("Itemid");
		}
		
		if(isset($post['ticketcode']) and $post['ticketcode'] != null)
		{
			$ticketcode = $post['ticketcode'];
			$model->unlockticket($ticketcode);//unlock to the ticket
		}
		
		$msg = '';
		$mainframe->redirect(JRoute::_('index.php?option=com_jsptickets&view=tickets&task=ticketlist&Itemid='.$ItemId), $msg);
	}
	
	function getCategory(){
	
	
		$postextId = JRequest::getVar('extension');
		$extarr = explode(",", $postextId);
		$model = $this->getModel("tickets");
		$str =null;
		foreach($extarr AS $extId)
		{
			if($extId != ''){
				$stateData = $model->loadCategoryList($extId);
				
				if(is_array($stateData)){
					foreach ($stateData as $k => $v){
						$str .= $v->id."|".$v->title."-";
					}
				}
			}
		}
		$str = substr($str,0,-1);		
		echo $str;
		exit;
	}
	
	function download()
	{
		$fullpath = JRequest::getVar('fullpath');
		$filename = JRequest::getVar('filename');
		
		$imageName = $fullpath;
		header("Content-Type: application/force-download");
		header("Content-Disposition: attachment; filename=$filename");
		header("Content-Length: " . filesize("$imageName"));
		$contents = fread(fopen($imageName, "rb"), filesize($imageName));
		echo $contents;
        exit;
	}
	
	function attachdelete()
	{
		$db = JFactory::getDBO();
		$attachid = JRequest::getVar('attachid');
		$ticketcode = JRequest::getVar('ticketcode');
		
		$query = "Select `id` from `#__jsptickets_ticket` where `ticketcode` LIKE '" . $ticketcode ."'";
		$db->setQuery($query);	
		$data = $db->loadObject();
		$ticketid = $data->id;
		
		$model = $this->getModel("tickets");
		$model->removeattachment($attachid);
		$logid = $model->createLog($ticketid , 'attachment_delete', '');
		
		$session = JFactory::getSession(); // needed for guest user
		if($session->get("Itemid") != "")
		{
			$ItemId = $session->get("Itemid");
		}
		$mainframe = JFactory::GetApplication();
		$user = JFactory::getUser();
		if($user->id!=0)
		{
			$mainframe->redirect(JRoute::_("index.php?option=com_jsptickets&view=tickets&controller=ticketlist&task=edit&ticketcode=".$ticketcode."&key=authorise&Itemid=".$ItemId) , JText::_("ATTACHMENT_DELETED_SUCCESSFULLY"), 'MESSAGE'); // only registered user are allowed
		} else {
			$mainframe->redirect(JRoute::_("index.php?option=com_jsptickets&view=tickets&controller=ticketlist&task=edit&ticketcode=".$ticketcode."&Itemid=".$ItemId) , JText::_("ATTACHMENT_DELETED_SUCCESSFULLY"), 'MESSAGE'); // only guest user are allowed
		}
	}
	
	function feedbackdelete()
	{
		$db = JFactory::getDBO();
		$feedid = JRequest::getVar('feedid');
		$ticketcode = JRequest::getVar('ticketcode');
		
		$query = "Select `id` from `#__jsptickets_ticket` where `ticketcode` LIKE '" . $ticketcode ."'";
		$db->setQuery($query);	
		$data = $db->loadObject();
		$ticketid = $data->id;
		
		$model = $this->getModel("tickets");
		$model->removefeedback($feedid);
		$logid = $model->createLog($ticketid , 'feedback_delete', '');
		
		$session = JFactory::getSession(); // needed for guest user
		if($session->get("Itemid") != "")
		{
			$ItemId = $session->get("Itemid");
		}
		$mainframe = JFactory::GetApplication();
		$user = JFactory::getUser();
		if($user->id!=0)
		{
			$mainframe->redirect(JRoute::_("index.php?option=com_jsptickets&view=tickets&controller=ticketlist&task=edit&ticketcode=".$ticketcode."&key=authorise&Itemid=".$ItemId) , ''); // only registered user are allowed
		} else {
			$mainframe->redirect(JRoute::_("index.php?option=com_jsptickets&view=tickets&controller=ticketlist&task=edit&ticketcode=".$ticketcode."&Itemid=".$ItemId) , ''); // only guest user are allowed
		}
	}
	
	function commentdelete()
	{
		$db = JFactory::getDBO();
		$commentid = JRequest::getVar('commentid');
		$ticketcode = JRequest::getVar('ticketcode');
		
		$query = "Select `id` from `#__jsptickets_ticket` where `ticketcode` LIKE '" . $ticketcode ."'";
		$db->setQuery($query);	
		$data = $db->loadObject();
		$ticketid = $data->id;
		
		$session = JFactory::getSession(); // needed for guest user
		if($session->get("Itemid") != "")
		{
			$ItemId = $session->get("Itemid");
		}
		$model = $this->getModel("tickets");
		$model->removecomment($commentid);
		$logid = $model->createLog($ticketid , 'comment_delete', '');
		
		$mainframe = JFactory::GetApplication();
		$user = JFactory::getUser();
		if($user->id!=0)
		{
			$mainframe->redirect(JRoute::_("index.php?option=com_jsptickets&view=tickets&controller=ticketlist&task=edit&ticketcode=".$ticketcode."&key=authorise&Itemid=".$ItemId) , ''); // only registered user are allowed
		} else {
			$mainframe->redirect(JRoute::_("index.php?option=com_jsptickets&view=tickets&controller=ticketlist&task=edit&ticketcode=".$ticketcode."&Itemid=".$ItemId) , ''); // only registered user are allowed
		}
	}
}