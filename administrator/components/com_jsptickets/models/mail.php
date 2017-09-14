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

jimport('joomla.application.component.modeladmin');

class jspticketsModelmail extends JModelAdmin {
	
	public function __construct($config = array()) 
	 { 
		 if (empty($config['filter_fields'])) { 
		 $config['filter_fields'] = array( 
		 'id', 'a.id', 
		 'file_upload', 'a.file_upload', 
		 'file_types', 'a.file_types',
		 'access_control', 'a.access_control',
		  'select_category', 'a.select_category',
		   'email_notification', 'a.email_notification',
		   'admin_email_id', 'a.admin_email_id',
		   'gen_fb_tickets', 'a.gen_fb_tickets',
		   'fb_page_url', 'a.fb_page_url',
		   'socialticket_gen_timeinterval', 'a.socialticket_gen_timeinterval',
		   'fb_filter_words', 'a.fb_filter_words',
		   'fb_send_mail', 'a.fb_send_mail',
		   'fb_ticket_title', 'a.fb_ticket_title',
		   'fb_ticket_subject', 'a.fb_ticket_subject',
		   'category_extension', 'a.category_extension'
		 );
		}
		parent::__construct($config);
	 }
	 
	public function getForm($data = array(), $loadData = true)
        {
 
			$app = JFactory::getApplication();
 
			// Get the form.
            $form = $this->loadForm('com_jsptickets.mail', 'mail', array('control' => 'jform', 'load_data' => true));
            if (empty($form)) {
                return false;
            }
            return $form;
        }
		
	public function getFormData()
		{
			$db = JFactory::getDBO();
			$query = 'SELECT * FROM `#__jsptickets_configuration` WHERE `id` LIKE '. 1 ;
			$db->setQuery($query);
			$data = $db->loadObjectList();
			return $data;
		}
}