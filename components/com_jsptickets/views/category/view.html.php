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
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
jimport('joomla.application.component.view');
jimport('joomla.filesystem.file');
jimport('joomla.html.pagination');
 
/**
 * HTML View class for the JSP Tickets Component
 */
class jspticketsViewcategory extends JViewLegacy
{
	protected $form;
	protected $item;
	protected $state;
	
        // Overwriting JView display method
        function display($tpl = null) 
        {
			$mainframe = JFactory::GetApplication();      //needed for search
			$context = JRequest::getVar('option');
			$search	= $mainframe->getUserStateFromRequest( $context.'category_filter_search', 'filter_search',	'',	'string' );
			$search	= JString::strtolower($search);
			$filter_level = $mainframe->getUserStateFromRequest( $context.'filter_level', 'filter_level',	'',	'string' );
			$filter_published = $mainframe->getUserStateFromRequest( $context.'filter_published', 'filter_published',	'',	'string' );
			$filter_access = $mainframe->getUserStateFromRequest( $context.'filter_access', 'filter_access',	'',	'string' );
			$filter_language = $mainframe->getUserStateFromRequest( $context.'filter_language', 'filter_language',	'',	'string' );
			$model = $this->getModel();
			$total = $model->getCategoryCount($context,$search,$filter_level,$filter_published,$filter_access,$filter_language);
			
			
			$jcat_basePath = JPATH_ADMINISTRATOR.'/components/com_categories';
			require_once $jcat_basePath.'/models/categories.php';
			$config  = array('table_path' => $jcat_basePath.'/tables');
			$catmodel = new CategoriesModelCategories($config);
			jRequest::setVar('extension','com_jsptickets');
			$this->state= $catmodel->getState();
			$this->items = $catmodel->getItems();
			foreach ($this->items as &$item) {
			$this->ordering[$item->parent_id][] = $item->id;
			}
			$options	= array();
			$options[]	= JHtml::_('select.option', '1', JText::_('J1'));
			$options[]	= JHtml::_('select.option', '2', JText::_('J2'));
			$options[]	= JHtml::_('select.option', '3', JText::_('J3'));
			$options[]	= JHtml::_('select.option', '4', JText::_('J4'));
			$options[]	= JHtml::_('select.option', '5', JText::_('J5'));
			$options[]	= JHtml::_('select.option', '6', JText::_('J6'));
			$options[]	= JHtml::_('select.option', '7', JText::_('J7'));
			$options[]	= JHtml::_('select.option', '8', JText::_('J8'));
			$options[]	= JHtml::_('select.option', '9', JText::_('J9'));
			$options[]	= JHtml::_('select.option', '10', JText::_('J10'));

			$this->f_levels = $options;
			
			$context = JRequest::getVar('option');
			$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
			$limitstart	= $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');
			// In case limit has been changed, adjust limitstart accordingly
			$limitstart = ( $limit != 0 ? (floor($limitstart / $limit) * $limit) : 0 );
			$this->addToolBarList();
			$this->pagination = new JPagination($total, $limitstart, $limit);
			//$this->search = $search;                    //defining $this->search
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
			$option = JRequest::getVar('option');
			$model = $this->getModel();
			
			$this->catid = '';
			$this->cattitle = '';
			$this->catalias = '';
			$this->catpublished = '';
			$this->catparent_id = '';
			$this->catdescription = '';
			$this->catimage = '';
			$this->catassigned_to = '';
			if( $id != 0 and $id != null)
			{
				
				$data = $model->getFormData($id, $option);
				
				$params = json_decode($data[0]->params);
				$this->catid = $data[0]->id;
				$this->cattitle = $data[0]->title;
				$this->catalias = $data[0]->alias;
				$this->catpath = $data[0]->path;
				$this->catpublished = $data[0]->published;
				$this->catparent_id = $data[0]->parent_id;
				$this->catdescription = $data[0]->description;
				if(isset($params->image))
					$this->catimage = $params->image;
				if(isset($params->assigned_to))
					$this->catassigned_to = json_decode($params->assigned_to);
			}
			
			$this->addToolBarForm();
			$this->form	= $this->get('Form');          //loads jform from model
			parent::display($tpl);
		}
		
		function addToolBarList()
		{
			JToolBarHelper::title( JText::_('CATLIST') ,'categorylist');
			JToolBarHelper::editList();
			JToolBarHelper::addNew();
			JToolBarHelper::publishList();
			JToolBarHelper::unpublishList();
			JToolBarHelper::deleteList();
			$bar = JToolBar::getInstance('toolbar');
			JHtml::_('bootstrap.modal', 'collapseModal');
			$title = JText::_('JTOOLBAR_BATCH');
			$dhtml = "<button data-toggle=\"modal\" data-target=\"#collapseModal\" class=\"btn btn-small\">
						<i class=\"icon-checkbox-partial\" title=\"$title\"></i>
						$title</button>";
			$bar->appendButton('Custom', $dhtml, 'batch');
			JToolBarHelper::cancel('cancel', 'Close');
		}
		
		function addToolBarForm()
		{
			$edit = (JRequest::getVar('task') == 'edit');
			//JToolBarHelper::title( JText::_('CATLIST') ,'generic.png');
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
			$option = JRequest::getVar('option');
			
			$jinput = JFactory::getApplication()->input;
			$model = $this->getModel('category');
			$db = JFactory::getDBO();
			
			$task= JRequest::getVar('task');
			$post= JRequest::get('post');
			$post['description']= JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
			$id = $post['jform']['id'];
			$files  = $jinput->files->get('jform');
			$file   = $files['image'];
			$filesize = $file['size'];
			
			if($id)
			{
				$categorydata = $model->getFormData($id, $option);
			}
			
			if( isset( $file['name'] ) && $file['name'] != null ){
						$safefilename = JFile::makeSafe($file['name']);
						$imageext =  JFile::getExt($safefilename);
						$name = JFile::stripExt($safefilename);
						$timestamp = strtotime(date('Y-m-d H:i:s'));
						$newname = JFile::makeSafe( $name . '_' . $timestamp . '.' . $imageext );
			} else {
				if(isset($post['post_image']) and $post['post_image'] != null)
					$newname = $post['post_image'];
			}
			
			$params['image'] = $newname;
			$params['assigned_to'] = json_encode($post['jform']['assigned_to']);
			$params = json_encode($params);
			

			if($post['jform']['alias'] == null)
			{
			$newalias = JFilterOutput::stringURLSafe($post['jform']['title']);
			}
			else
			{
			$newalias = $post['jform']['alias'];
			}
			$newalias = $this->escape_string($newalias);
			
			$query = 'SELECT `id`, count(`alias`) AS `count` FROM `#__categories` WHERE `extension` LIKE "' . $option . '" AND `alias` LIKE "' . $newalias . '"';
			$db->setQuery($query);
			$count = $db->loadObjectList();
						
			if( $count[0]->count >=1 and $count[0]->id != $id )
			{
			$mainframe->redirect( "index.php?option=com_jsptickets&controller=catlist&task=edit&id=".$id , JText::_("DUPLICATE_ALIAS_ALREADY_FOUND"), "ERROR" );
			}
			
			
			$src = $file['tmp_name'];
			
			$dest = JPATH_ROOT . '/' . "images" . '/' . "jsp_tickets" . '/' . "cat_images" . '/' . $newname;
			
			$allowedext= array("jpe", "jpg", "jpeg", "gif", "png", "bmp", "ico", "svg", "svgz", "tif", "tiff", "ai", "drw", "pct", "psp", "xcf", "psd", "raw");
			
			if( $safefilename != null )
			{   //check file extension for the uploaded file
				if (  in_array( strtolower($imageext), $allowedext ) ) {
					//check filesize not to be greater than 2 mb
					if( $filesize > 2000000 ){
						$mainframe->redirect( "index.php?option=com_jsptickets&controller=catlist&task=edit&id=".$id , JText::_("FILESIZE_GREATER_THAN_2MB"), "ERROR" );
					} else {
						if ( JFile::upload($src, $dest) ) {
							//Redirect to a page of your choice
						} else {
							//Redirect and throw an error message
							$mainframe->redirect( "index.php?option=com_jsptickets&controller=catlist&task=edit&id=".$id , JText::_("FILE_COUNDNOT_BE_UPLOADED"), "ERROR" );
						}
					}
				} else {
					$mainframe->redirect( "index.php?option=com_jsptickets&controller=catlist&task=edit&id=".$id , JText::_("FILE_EXTENSION_NOT_ALLOWED"), "ERROR" );
				}
			}
			
			$jcat_basePath = JPATH_ADMINISTRATOR.'/components/com_categories';
			require_once $jcat_basePath.'/models/category.php';
			$config  = array('table_path' => $jcat_basePath.'/tables');
			$catmodel = new CategoriesModelCategory($config);
			if(isset($categorydata[0]->path) && $categorydata[0]->path=="uncategorised" && $categorydata[0]->alias=="uncategorised")
			{
				$catData = array('id' => $id, 'extension' => 'com_jsptickets', 'title' => $post['jform']['title'], 
				'description' => $post['description'], 'params' => $params, 'language' => '*');
			} else {
				$catData = array('id' => $id, 'parent_id' => $post['jform']['parent_id'], 'extension' => 'com_jsptickets', 'title' => $post['jform']['title'], 
				'alias' => $newalias, 'description' => $post['description'], 'published' => $post['jform']['published'], 'params' => $params, 'language' => '*');
			}
			$catmodel->save($catData);
			if( $id )
			{
				//do whatever you want
			}
			else
			{
				$id = $catmodel->getItem()->id;	                //gets the latest id of the saved category
			}
			
			switch($task){
				case 'save':
				case 'default':
					$msg = JText::_("ITEM_SAVED_SUCCESSFULLY") ;
					$mainframe->redirect('index.php?option=com_jsptickets&task=catlist', $msg, "message");
				break;
				
				case 'apply':
					$msg = JText::_("ITEM_SAVED_SUCCESSFULLY") ;
					$mainframe->redirect('index.php?option=com_jsptickets&controller=catlist&task=edit&id='. $id, $msg, "message");
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
				$model->publish($id);
			}
			$mainframe->redirect( "index.php?option=com_jsptickets&task=catlist" , JText::_("PUBLISHED_SUCCESSFULLY"), "message" );
		}
		
		if( $itemstate == 'unpublish' )
		{
			foreach($rowid as $id)
			{
				$model->unpublish($id);
			}
			$mainframe->redirect( "index.php?option=com_jsptickets&task=catlist" , JText::_("UNPUBLISHED_SUCCESSFULLY"), "message" );
		}
	}
	
	function remove()
	{
		$mainframe = JFactory::GetApplication();
		$rowid = JRequest::getVar('cid',  0, '', 'array');
		$option = JRequest::getVar('option');
		$model = $this->getModel();
		foreach($rowid as $id)
			{
				$subItemsCount = $this->checkSubItems($id);
				if($subItemsCount)
				{
					$record = $model->getFormData($id, $option);
					$msg = JText::sprintf('COM_CATEGORIES_DELETE_NOT_ALLOWED', $record[0]->title) . JText::sprintf('COM_CATEGORIES_N_ITEMS_ASSIGNED', $subItemsCount);
					$mainframe->redirect("index.php?option=com_jsptickets&task=catlist", $msg, "ERROR");
				} else {
					$model->remove($id);
				}
			}
		$mainframe->redirect( "index.php?option=com_jsptickets&task=catlist" , JText::_("DELETED_SUCCESSFULLY"), "message" );
	}
	
	function checkSubItems($id)
	{
		$db = JFactory::getDBO();
		$query = "SELECT count(*) AS `count` FROM `#__jsptickets_ticket` WHERE `category_id` LIKE '%" .'"'.$id.'"'. "%'";
		$db->setQuery($query);
		$data = $db->loadObject();
		return $data->count;
	}
	
	public function getParentCategoryname($parentid)
	{
		$db = JFactory::getDBO();
		$query = 'SELECT `title` FROM `#__categories` WHERE `id` = '.$parentid;
		$db->setQuery($query);
		$data = $db->loadObject();
		return $data->title;
	}
	
	public function getCategoryPath($id)
	{
		$db = JFactory::getDBO();
		
		$query = "SELECT `path` FROM `#__categories` WHERE `id` = ".$id;
		$db->setQuery($query);
		$data = $db->loadObject();
		return $data->path;
	}
}