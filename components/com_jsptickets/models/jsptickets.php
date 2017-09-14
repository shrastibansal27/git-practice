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

jimport('joomla.application.component.modelform');

class jspticketsModeljsptickets extends JModelForm {

	public function getConfig()
	{
			$db = JFactory::getDBO();
			$query = 'SELECT * FROM `#__jsptickets_configuration` WHERE `id` LIKE '. 1 ;
			$db->setQuery($query);
			$data = $db->loadObjectList();
			return $data;
	} 
	
	public function getForm($data = array(), $loadData = true)
        {
 
			$app = JFactory::getApplication();
 
			// Get the form.
            $form = $this->loadForm('com_jsptickets.jsptickets', 'jsptickets', array('control' => 'jform', 'load_data' => true));
            if (empty($form)) {
                return false;
            }
            return $form;
 
        }

}