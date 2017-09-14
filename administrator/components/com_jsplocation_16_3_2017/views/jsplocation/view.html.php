<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: view.html.php  $
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
JToolBarHelper::title(JText::_('JSP_LOCATION'), 'jlocator_article.png');
jimport( 'joomla.application.component.view');

class JspLocationViewjsplocation extends JViewLegacy {
	function display($tpl=null)
	{
		$this->addToolbar();
		parent::display($tpl);
	}
	
	protected function addToolbar()
	{
		if (JFactory::getUser()->authorise('core.admin', 'com_jsplocation'))
		{
			JToolBarHelper::preferences('com_jsplocation');
		}
	}
}