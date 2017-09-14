<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: jsptickets.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.controller' );

class jspticketsControllerjsptickets extends JControllerLegacy {

	function display($cachable = false, $urlparams = Array()){
		$model = $this->getModel( 'jsptickets' );
		$view = $this->getView( 'jsptickets' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("default");
		$view->display();	
	}
}