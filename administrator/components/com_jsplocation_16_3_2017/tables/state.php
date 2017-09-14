<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: state.php  $
 */
 
// no direct access
defined('_JEXEC') or die( 'Restricted access' );

class JTableState extends JTable {
	
	var $id 			= null;
	
	var $country_id 	= null;
	
	var $title 			= null;
	
	var $description	= null;
	
	var $published 	    = null;

	function __construct(&$db) {
		parent::__construct( '#__jsplocation_state', 'id', $db );
	}
}