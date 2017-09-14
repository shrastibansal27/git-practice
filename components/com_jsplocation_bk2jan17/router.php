<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: router.php  $
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

function jsplocationBuildRoute( &$query )
{	
	$segments = array();
	
	if(isset($query['view']))
	{		
		$query['view'] = "";
		$segments[] = $query['view'];
		unset( $query['view'] );
	}
	
	if(isset($query['loc']))
	{
		$segments[] = $query['loc'];
		unset( $query['loc'] );
	}
	
	return $segments;
}

function jsplocationParseRoute( $segments )
{
	$vars = array();
	$vars['loc'] = $segments[0];
	$vars['loc'] = str_replace(':', '-', $segments[0]);
	return $vars;
}

?>