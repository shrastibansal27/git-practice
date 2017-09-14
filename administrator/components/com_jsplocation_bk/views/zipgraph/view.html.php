<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: view.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
JToolBarHelper::title(JText::_('ZIPHIT_GRAPHS'), 'article.png');
jimport( 'joomla.application.component.view');

class JspLocationViewZipgraph extends JViewLegacy {
	
	function display($tpl = null)
	{
	parent::display($tpl);
	}
}
?>	
	