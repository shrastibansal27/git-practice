<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: tickets.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

class Tabletickets extends JTable
{
	
	var $id= null;
	var $ticketcode = null;
	var $title= null;
	var $subject= null;
	var $description= null;
	var $category_id= null;
	var $priority_id= null;
	var $status_id= null;
	var $attachment_id= null;
	var $feedback_id= null;
	var $comment_id= null;
	var $created= null;
	var $created_by= null;
	var $created_for= null;
	var $modified= null;
	var $assigned_by= null;
	var $assigned_to= null;
	var $closed= null;
	var $closed_by= null;
	var $checked_out= null;
	var $checked_out_time= null;
	var $email_comment= null;
	var $follow_up = null;
	var $guestname = null;
	var $guestemail = null;
	
	function __construct(&$db)
	{
		parent::__construct( '#__jsptickets_ticket', 'id', $db );
	}

	
}
