<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: fields.php  $
 */
 
// no direct access
defined('_JEXEC') or die( 'Restricted access' );

class JTableFields extends JTable
{
	
	var $id 		 	    = null;
	
	var $field_name		    = null;
	
	var $field_type		    = null;

	var	$published		    = null;

	var	$map_display		= null;

	var	$sidebar_display	= null;

	var	$predefined		    = null;
	
	function __construct(&$db)
	{
		parent::__construct( '#__jsplocation_fields', 'id', $db );
	}
}