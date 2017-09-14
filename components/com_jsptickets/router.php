<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: router.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

function jspticketsBuildRoute( &$query )
{	
	$segments = array();
	
	if(isset($query['view']))
	{	
		$segments[] = $query['view'];
		unset( $query['view'] );
	}
	
	if(isset($query['controller']))
	{	
		$segments[] = $query['controller'];
		unset( $query['controller'] );
	}
	
	if(isset($query['task']))
	{
		$segments[] = $query['task'];
		unset( $query['task'] );
	}
	
	return $segments;
}

function jspticketsParseRoute( $segments )
{
	$vars = array();
	$count = count($segments);
	if($count == 3)
	{
		$vars['view'] = $segments[0];
		$vars['controller'] = $segments[1];
		$vars['task'] = $segments[2];
	}
	if($count == 2)
	{
		$vars['view'] = $segments[0];
		$vars['task'] = $segments[1];
	}
	if($count == 1)
	{
		$vars['view'] = $segments[0];
	}
	return $vars;
}

?>