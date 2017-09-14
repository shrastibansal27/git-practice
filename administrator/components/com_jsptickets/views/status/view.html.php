<?php
/**
* JSP Tickets components for Joomla!
* JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
* developed by Joomla Service Provider Team.
* @author      $Author: Ajay Lulia $
* @copyright   Joomla Service Provider - 2013
* @package     JSP Tickets 1.0
* @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @version     $Id: view.html.php  $
*/

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
jimport('joomla.application.component.view');
jimport('joomla.filesystem.file');
jimport('joomla.html.pagination');
 
/**
 * HTML View class for the JSP Tickets Component
 */
class jspticketsViewstatus extends JViewLegacy
{
	// Overwriting JView display method
        function display($tpl = null) 
        {
			$mainframe = Jfactory::GetApplication();
			$context = JRequest::getVar('option');
			$model = $this->getModel();
			
			$this->search = $mainframe->getUserStateFromRequest($context.'status_filter_search', 'filter_search', '', 'post');
			$this->filter_published = JRequest::getVar('filter_published');
			$this->listOrder = JRequest::getVar('filter_order');
			$this->listDirn = JRequest::getVar('filter_order_Dir');
			
			//call your model here
			$this->count = $model->getCount($this->filter_published, $this->search);
			$this->data = $model->getList( $this->listOrder, $this->listDirn, $this->filter_published, $this->search, $this->count );
			
			$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
			$limitstart	= $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');
			
			// if( ($this->search or $this->filter_published) and ($this->filter_published != "*") )
				// $total = count($this->data);
			// else $total = $this->count;
			$total = $this->count;
			
			$this->addToolBarList();
			if($total <= $limit || $total <= $limitstart || $limit==0)
			{
				$limitstart = 0;
			}
			$this->pagination = new JPagination($total, $limitstart, $limit);
			parent::display($tpl);
		}
		
		
		function form($tpl = null)
		{
			if(JRequest::getVar('task') != 'add')
			{
				$id = JRequest::getVar('id');
				$rowid = JRequest::getVar('cid',  0, '', 'array');
				if($id == null and $rowid != null)
				{
					$id = $rowid[0];
				}
			} else $id = null;
			$model = $this->getModel();
		
			$this->statusid = '';
			$this->statusname = '';
			$this->statuspublish = '';
			$this->statusdescription = '';
			if( $id != 0 and $id != null)
			{
				
				$data = $model->getFormData($id);
				
				$this->statusid = $data[0]->id;
				$this->statusname = $data[0]->name;
				$this->statuspublish = $data[0]->publish;
				$this->statusdescription = $data[0]->description;
			}
			
			$this->addToolBarForm();
			$this->form	= $this->get('Form');          //loads jform from model
			parent::display($tpl);
		}
		
		function addToolBarList()
		{
			JToolBarHelper::title( JText::_('STATUSLIST') ,'statuslist');
			JToolBarHelper::editList();
			JToolBarHelper::addNew();
			JToolBarHelper::publishList();
			JToolBarHelper::unpublishList();
			JToolBarHelper::deleteList();
			JToolBarHelper::cancel('cancel', 'Close');
		}
		
		function addToolBarForm()
		{
			$edit = (JRequest::getVar('task') == 'edit');
			//JToolBarHelper::title( JText::_('STATUSLIST') ,'generic.png');
			$cid =  JRequest::getVar( 'cid', array(0), '', 'array' );
			$controller = JRequest::getVar('controller');
			$controller =ucfirst($controller);
			$text = ( $edit ? JText::_( 'EDIT' ) : JText::_( 'NEW' ) );
			JToolBarHelper::title( JText::_( $controller .'   '.'Details') .': <small><small>[ '. $text .' ]</small></small>', 'generic.png' );
			JToolBarHelper::save();
			JToolBarHelper::apply();
			if ( $edit ) {
			// for existing items the button is renamed `close`
				JToolBarHelper::cancel( 'cancel', 'Close' );
				} else {
				JToolBarHelper::cancel();
				}
		}
		
		function escape_string($query_input = null)
		{
			$search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
			$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
			return str_replace($search, $replace, $query_input);
		}
		
		function saveData()
		{
			$mainframe = JFactory::GetApplication();
			$db = JFactory::getDBO();
			$option = JRequest::getVar('option');
			$task= JRequest::getVar('task');
			$post = JRequest::get('post');
			$desc = $this->escape_string( JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW) );
			$id = $post['jform']['id'];
	
			if( $id )
			{
				//do whatever you want
				if($id == 1 || $id == 2) //new status or closed status cannot be modified not be deleted
					{
						$mainframe->redirect( "index.php?option=com_jsptickets&task=statuslist" , JText::_("ONLY_BE_MODIFIED"), "NOTICE" );
					}
				$query = 'UPDATE `#__jsptickets_status` SET `name` = "'. $this->escape_string($post['jform']['name']) .'", `description` = '. "'" . $desc . "'" .', `publish` = '. $post['jform']['publish'] .' WHERE `id` = ' . $id .';';
				$db->setQuery($query);
				if (!$db->query()) 
				{
					JError::raiseError( 500, $db->getErrorMsg() );
				}
			}
			else
			{
				$query = 'INSERT INTO `#__jsptickets_status` (`name`, `description`, `publish`) VALUES ("' . $this->escape_string($post['jform']['name']) . '", '. "'" . $desc . "'" .', '. $post['jform']['publish'] . ');';
				$db->setQuery($query);
				if (!$db->query()) 
				{
					JError::raiseError( 500, $db->getErrorMsg() );
				}
				$id = $db->insertid();	                //gets the latest id of the saved item
			}
			
			switch($task){
				case 'save':
				case 'default':
					$msg = JText::_("ITEM_SAVED_SUCCESSFULLY") ;
					$mainframe->redirect('index.php?option=com_jsptickets&task=statuslist', $msg, "message");
				break;
				
				case 'apply':
					$msg = JText::_("ITEM_SAVED_SUCCESSFULLY") ;
					$mainframe->redirect('index.php?option=com_jsptickets&controller=statuslist&task=edit&id='. $id, $msg, "message");
				break;
			}
		}

		function state($itemstate)
		{
			 $mainframe = JFactory::GetApplication();
			 $rowid = JRequest::getVar('cid',  0, '', 'array');
			 $model = $this->getModel();
			 
				if($itemstate == 'publish')
				{
					foreach($rowid as $id)
					{
						if($id == 1 || $id == 2) //closed status or new status cannot be modified not be deleted
						{
							$mainframe->redirect( "index.php?option=com_jsptickets&task=statuslist" , JText::_("ONLY_BE_MODIFIED"), "message" );
						} else {
							$model->publishstatus($id);
						}
					}
					$mainframe->redirect( "index.php?option=com_jsptickets&task=statuslist" , JText::_("PUBLISHED_SUCCESSFULLY"), "message" );
				}
				
				if( $itemstate == 'unpublish' )
				{
					foreach($rowid as $id)
					{
						if($id == 1 || $id == 2) //closed status or new status cannot be modified not be deleted
						{
							$mainframe->redirect( "index.php?option=com_jsptickets&task=statuslist" , JText::_("ONLY_BE_MODIFIED"), "message" );
						} else {
							$model->unpublish($id);
						}
					}
					$mainframe->redirect( "index.php?option=com_jsptickets&task=statuslist" , JText::_("UNPUBLISHED_SUCCESSFULLY"), "message" );
				}
		}
		
		function remove()
		{
			$mainframe = JFactory::GetApplication();
			$rowid = JRequest::getVar('cid',  0, '', 'array');
			$model = $this->getModel();
			foreach($rowid as $id)
				{
					if($id == 1 || $id == 2) //new and closed status can not only be modified not be deleted
					{
						$mainframe->redirect( "index.php?option=com_jsptickets&task=statuslist" , JText::_("ONLY_BE_MODIFIED"), "message" );
					}
					$subItemsCount = $this->checkSubItems($id);
					if($subItemsCount)
					{
						$record = $model->getFormData($id);
						$msg = JText::sprintf('STATUS_DELETE_NOT_ALLOWED', $record[0]->name) . JText::sprintf('STATUS_N_ITEMS_ASSIGNED', $subItemsCount);
						$mainframe->redirect("index.php?option=com_jsptickets&task=statuslist", $msg, "ERROR");
					} else {
						$model->remove($id);
					}
				}
			$mainframe->redirect( "index.php?option=com_jsptickets&task=statuslist" , JText::_("DELETED_SUCCESSFULLY"), "message" );
		}
		
		function checkSubItems($id)
		{
			$db = JFactory::getDBO();
			$query = "SELECT count(*) AS `count` FROM `#__jsptickets_ticket` WHERE `status_id` = " . $id;
			$db->setQuery($query);
			$data = $db->loadObject();
			return $data->count;
		}
}