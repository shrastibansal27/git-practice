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
class jspticketsViewconfig extends JViewLegacy
{
        // Overwriting JView display method
        function display($tpl = null) 
        {
			//$pane =& JPane::getInstance('Tabs', array(), true);
			//$this->assignRef('pane',$pane);
			$model = $this->getModel();
			$data = $model->getFormData();
			$this->configid = $data[0]->id;
			$this->configfile_upload = $data[0]->file_upload;
			$this->configfile_types = $data[0]->file_types;
			$this->configload_jquery = $data[0]->load_jquery;
			$this->configaccess_control = $data[0]->access_control;
			$this->configfilter_option_access = json_decode($data[0]->filter_option_access);
			$this->configselect_category = $data[0]->select_category;
			$this->configemail_notification = $data[0]->email_notification;
			$this->configadmin_email_id = $data[0]->admin_email_id;
			$this->configgen_fb_tickets = $data[0]->gen_fb_tickets;
			$this->configfb_app_id = $data[0]->fb_app_id;
			$this->configfb_app_secret = $data[0]->fb_app_secret;
			$this->configfb_page_url = $data[0]->fb_page_url;
			$this->configfb_filter_words = $data[0]->fb_filter_words;
			$this->configfb_send_mail = $data[0]->fb_send_mail;
			$this->configfb_ticket_title = $data[0]->fb_ticket_title;
			$this->configfb_ticket_subject = $data[0]->fb_ticket_subject;
			$this->configgen_twitter_tickets = $data[0]->gen_twitter_tickets;
			$this->configcustom_twitter_consumerkey = $data[0]->custom_twitter_consumerkey;
			$this->configcustom_twitter_consumersecret = $data[0]->custom_twitter_consumersecret;
			$this->configcustom_twitter_accesstoken = $data[0]->custom_twitter_accesstoken;
			$this->configcustom_twitter_accesstoken_secret = $data[0]->custom_twitter_accesstoken_secret;
			$this->configtwitter_screenname = $data[0]->twitter_screenname;
			$this->configtwitter_filter_words = $data[0]->twitter_filter_words;
			$this->configtwitter_send_mail = $data[0]->twitter_send_mail;
			$this->configtwitter_ticket_title = $data[0]->twitter_ticket_title;
			$this->configtwitter_ticket_subject = $data[0]->twitter_ticket_subject;
			$this->configsocialticket_gen_timeinterval =  $data[0]->socialticket_gen_timeinterval;
			$this->configcategory_extension = json_decode($data[0]->category_extension);
			$this->configstatus = json_decode($data[0]->status);
			$this->configticket_saved_msg = $data[0]->ticket_saved_msg;
			$this->configticket_removed_msg = $data[0]->ticket_removed_msg;
			$this->configticket_followup_msg = $data[0]->ticket_followup_msg;
			$this->configticket_removefollow_msg = $data[0]->ticket_removefollow_msg;
			
			$this->addToolBarForm();
			$this->form	= $this->get('Form');          //loads jform from model
			parent::display($tpl);
		}
		
		function addToolBarForm()
		{
			JToolBarHelper::title( JText::_('CONFIGURATION') ,'ticket-config');
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
			$filter_option_access = json_encode($post['jform']['filter_option_access']);
			
			$query = 'UPDATE `#__jsptickets_configuration` SET `file_upload` = '. $post['jform']['file_upload'] 
			. ', `file_types` = "'. $this->escape_string($post['jform']['file_types']) .'", `access_control` = '. $post['jform']['access_control']
			. ', `load_jquery` = '. $post['jform']['load_jquery'] . ", `filter_option_access` = '". $filter_option_access . "'" 
			. ', `select_category` = '. $post['jform']['select_category'] . ', `gen_fb_tickets` = ' . $post['jform']['gen_fb_tickets'] 
			. ', `fb_app_id` = "' . $this->escape_string($post['jform']['fb_app_id']) . '", `fb_app_secret` = "' . $this->escape_string($post['jform']['fb_app_secret']) . '", `fb_page_url` = "' . $this->escape_string($post['jform']['fb_page_url']) . '", `socialticket_gen_timeinterval` = ' .  $post['jform']['socialticket_gen_timeinterval'] 
			. ', `fb_filter_words` = "' . $this->escape_string($post['jform']['fb_filter_words']) . '", `fb_send_mail` = ' . $post['jform']['fb_send_mail'] 
			. ', `fb_ticket_title` = "' . $this->escape_string($post['jform']['fb_ticket_title']) . '", `fb_ticket_subject` = "'. $this->escape_string($post['jform']['fb_ticket_subject']) . '"' 
			. ", `gen_twitter_tickets` = " . $post['jform']['gen_twitter_tickets'] . ", `custom_twitter_consumerkey` = '" . $this->escape_string($post['jform']['custom_twitter_consumerkey']) . "', `custom_twitter_consumersecret` = '" . $this->escape_string($post['jform']['custom_twitter_consumersecret']) 
			. "', `custom_twitter_accesstoken` = '" . $this->escape_string($post['jform']['custom_twitter_accesstoken']) . "', `custom_twitter_accesstoken_secret` = '" . $this->escape_string($post['jform']['custom_twitter_accesstoken_secret']) 
			. "', `twitter_screenname` = '" . $this->escape_string($post['jform']['twitter_screenname']) . "', `twitter_filter_words` = '" . $this->escape_string($post['jform']['twitter_filter_words']) . "', `twitter_send_mail` = "  . $post['jform']['twitter_send_mail'] . ", `twitter_ticket_title` = '" . $this->escape_string($post['jform']['twitter_ticket_title']) 
			. "', `twitter_ticket_subject` = '" . $this->escape_string($post['jform']['twitter_ticket_subject']) . "', `category_extension` = '" . $category_extension . "', `status` = '" . $status . "'"
			. ', `ticket_saved_msg` = "' . $this->escape_string($post['jform']['ticket_saved_msg']) . '", `ticket_removed_msg` = "' . $this->escape_string($post['jform']['ticket_removed_msg']) 
			. '", `ticket_followup_msg` = "' . $this->escape_string($post['jform']['ticket_followup_msg']) . '", `ticket_removefollow_msg` = "' . $this->escape_string($post['jform']['ticket_removefollow_msg']) 
			. '" WHERE `id` = 1;';
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
					$mainframe->redirect('index.php?option=com_jsptickets&controller=config&task=config', $msg, "message");
				break;
		    
			}
		}
}