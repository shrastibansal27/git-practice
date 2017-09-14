<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: fieldvalues.php  $
 */
 
// no direct access
defined('_JEXEC') or die( 'Restricted access' );

class JTableFieldvalues extends JTable
{
	
	var $id 		 		= null;
	
	var $field_id			= null;
	
	var $field_value		= null;

	var $field_value_label	= null;

	function __construct(&$db)
	{
		parent::__construct( '#__jsplocation_field_values', 'id', $db );
	}
}