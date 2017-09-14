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

class Tablemail extends JTable
{
	
	var $id= null;
	var $file_upload= null;
	var $file_types= null;
	var $access_control= null;
	var $select_category= null;
	var $email_notification= null;
	var $admin_email_id= null;
	var $gen_fb_tickets= null;
	var $fb_page_url= null;
	var $socialticket_gen_timeinterval= null;
	var $fb_filter_words= null;
	var $fb_send_mail= null;
	var $fb_ticket_title= null;
	var $fb_ticket_subject= null;
	var $category_extension= null;
	
	function __construct(&$db)
	{
		parent::__construct( '#__jsptickets_configuration', 'id', $db );
	}

}
