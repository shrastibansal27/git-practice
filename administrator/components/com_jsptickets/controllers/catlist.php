<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: catlist.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.controlleradmin' );

//require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'category.php');
class jspticketsControllercatlist extends JControllerAdmin {
	
	function display($cachable = false, $urlparams = Array()){
		$model	=$this->getModel( 'category' );
		$view =$this->getView( 'category' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("list");
		$view->display();	
	}
	
	function add(){
		$model	=$this->getModel( 'category' );
		$view =$this->getView( 'category' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("form");
		$view->form();	
	}
	
	function edit(){
		$model	=$this->getModel( 'category' );
		$view =$this->getView( 'category' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("form");
		$view->form();	
	}
	
	function cancel(){
		$mainframe = Jfactory::GetApplication();
		$msg = '';
		$mainframe->redirect('index.php?option=com_jsptickets&task=jsptickets', $msg);
	}
	
	function publish()
	{
		if(JRequest::getCmd( 'task' ) == 'unpublish')
		{
			$this->unpublish();
		}
		$model	=$this->getModel( 'category' );
		$view =$this->getView( 'category' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("list");
		$view->state('publish');	
	}
	
	function unpublish()
	{
		if(JRequest::getCmd( 'task' ) == 'publish')
		{
			$this->publish();
		}
		$model	=$this->getModel( 'category' );
		$view =$this->getView( 'category' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("list");
		$view->state('unpublish');	
	}
	
	function remove()
	{
		$model	=$this->getModel( 'category' );
		$view =$this->getView( 'category' , 'html' );
		$view->setModel( $model, true);
		$view->setLayout("list");
		$view->remove();	
	}
	
	function saveorder()
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		// Get the arrays from the Request
		$order	= JRequest::getVar('order',	null, 'post', 'array');
		$originalOrder = explode(',', JRequest::getString('original_order_values'));

		// Make sure something has changed
		if (!($order === $originalOrder)) {
			$this->saveorder2();
		} else {
			// Nothing to reorder
			$this->setRedirect(JRoute::_('index.php?option=com_jsptickets&task=catlist', false));
			return true;
		}
	}
	
	function orderup()
	{
			$this->reorder();
	}
	
	function orderdown()
	{
			$this->reorder();
	}
		
	public function saveorder2()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Get the input
		$pks = JRequest::getVar('cid', null, 'post', 'array');
		$order = JRequest::getVar('order', null, 'post', 'array');

		// Sanitize the input
		JArrayHelper::toInteger($pks);
		JArrayHelper::toInteger($order);

		// Get the model of joomla com_categories
		//$model = $this->getModel();
		$jcat_basePath = JPATH_ADMINISTRATOR.'/components/com_categories';
		require_once $jcat_basePath.'/models/category.php';
		$config  = array('table_path' => $jcat_basePath.'/tables');
		$catmodel = new CategoriesModelCategory($config);
		
		// Save the ordering
		$return = $catmodel->saveorder($pks, $order);

		if ($return === false)
		{
			// Reorder failed
			$message = JText::sprintf('JLIB_APPLICATION_ERROR_REORDER_FAILED', $model->getError());
			$this->setRedirect(JRoute::_('index.php?option=com_jsptickets&task=catlist', false), $message, 'error');
			return false;
		}
		else
		{
			// Reorder succeeded.
			$this->setMessage(JText::_('JLIB_APPLICATION_SUCCESS_ORDERING_SAVED'));
			$this->setRedirect(JRoute::_('index.php?option=com_jsptickets&task=catlist', false));
			return true;
		}
	}
	
	public function reorder()
	{
		// Check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$ids = JRequest::getVar('cid', null, 'post', 'array');
		$inc = ($this->getTask() == 'orderup') ? -1 : +1;

		//$model = $this->getModel();
		$jcat_basePath = JPATH_ADMINISTRATOR.'/components/com_categories';
		require_once $jcat_basePath.'/models/category.php';
		$config  = array('table_path' => $jcat_basePath.'/tables');
		$catmodel = new CategoriesModelCategory($config);
		$return = $catmodel->reorder($ids, $inc);
		if ($return === false)
		{
			// Reorder failed.
			$message = JText::sprintf('JLIB_APPLICATION_ERROR_REORDER_FAILED', $model->getError());
			$this->setRedirect(JRoute::_('index.php?option=com_jsptickets&task=catlist', false));
			return false;
		}
		else
		{
			// Reorder succeeded.
			$message = JText::_('JLIB_APPLICATION_SUCCESS_ITEM_REORDERED');
			$this->setRedirect(JRoute::_('index.php?option=com_jsptickets&task=catlist', false));
			return true;
		}
	}
	
	
}