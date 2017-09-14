<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: view.html.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
jimport('joomla.application.component.view');
jimport('joomla.html.pane');
 
/**
 * HTML View class for the JSP Tickets Component
 */
class jspticketsViewmail extends JViewLegacy
{
        // Overwriting JView display method
        function display($tpl = null) 
        {
			//$pane =& JPane::getInstance('Tabs', array(), true);
			//$this->assignRef('pane',$pane);
			$model = $this->getModel();
			$data = $model->getFormData();
			
			$this->configid = $data[0]->id;
			$this->configemail_notification = $data[0]->email_notification;
			$this->configadmin_email_id = $data[0]->admin_email_id;
			$this->confignew_mail_subject = $data[0]->new_mail_subject;
			$this->confignew_mail_body = $data[0]->new_mail_body;
			$this->configcomment_mail_subject = $data[0]->comment_mail_subject;
			$this->configcomment_mail_body = $data[0]->comment_mail_body;
			$this->configassignee_changed_mail_subject = $data[0]->assignee_changed_mail_subject;
			$this->configassignee_changed_mail_body = $data[0]->assignee_changed_mail_body;
			
			$this->addToolBarForm();
			$this->form	= $this->get('Form');          //loads jform from model
			parent::display($tpl);
		}
		
		function addToolBarForm()
		{
			JToolBarHelper::title( JText::_('MAIL') ,'ticket-mail');
			JToolBarHelper::save();
			JToolBarHelper::apply();
			JToolBarHelper::cancel('cancel', 'Close');
		}
		
		function escape_string($query_input = null)
		{
			$search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
			$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
			return str_replace($search, $replace, $query_input);
		}
		
		function saveData()
		{
			$mainframe = JFactory::GetApplication();
			$db = JFactory::getDBO();
			$task= JRequest::getVar('task');
			$post = JRequest::get('post');	
			$category_extension = json_encode($post['jform']['category_extension']);
			$status = json_encode($post['jform']['status']);
			$query = 'UPDATE `#__jsptickets_configuration` SET `email_notification` = '. $post['jform']['email_notification'] . ', `admin_email_id` = "' . $this->escape_string($post['jform']['admin_email_id']) . '", `new_mail_subject` = "' . $this->escape_string($post['jform']['new_mail_subject']) . '", `new_mail_body` = "' . $this->escape_string($post['jform']['new_mail_body']) .'", `comment_mail_subject` = "' . $this->escape_string($post['jform']['comment_mail_subject']) . '", `comment_mail_body` = "' . $this->escape_string($post['jform']['comment_mail_body']) .'", `assignee_changed_mail_subject` = "' . $this->escape_string($post['jform']['assignee_changed_mail_subject']) . '", `assignee_changed_mail_body` = "' . $this->escape_string($post['jform']['assignee_changed_mail_body']) .'" WHERE `id` = 1;';
			$db->setQuery($query);
			if (!$db->query()) 
			{
				JError::raiseError( 500, $db->getErrorMsg() );
			}
				
			switch($task){
				case 'save':
				case 'default':
					$msg = JText::_("ITEM_SAVED_SUCCESSFULLY") ;
					$mainframe->redirect('index.php?option=com_jsptickets&task=jsptickets', $msg, "message");
				break;
				
				case 'apply':
					$msg = JText::_("ITEM_SAVED_SUCCESSFULLY") ;
					$mainframe->redirect('index.php?option=com_jsptickets&controller=mail&task=mail', $msg, "message");
				break;
		    
			}
		}
}