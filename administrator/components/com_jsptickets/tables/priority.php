<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: priority.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

class Tablepriority extends JTable
{
	
	var $id= null;
	var $name= null;
	var $description= null;
	var $publish= 0;
	
	function __construct(&$db)
	{
		parent::__construct( '#__jsptickets_priorities', 'id', $db );
	}

	
}
