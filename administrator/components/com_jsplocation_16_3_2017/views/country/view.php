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
JToolBarHelper::title(JText::_('COUNTRY_LIST'), 'country_article.png');
jimport( 'joomla.application.component.view');
require_once(JPATH_COMPONENT_ADMINISTRATOR.'/'.'tables'.'/'.'country.php');
class JspLocationViewCountry extends JViewLegacy {
	
	function display($tpl = null) {
		$mainframe = Jfactory::GetApplication();
		$context = JRequest::getVar('option');
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ( $limit != 0 ? (floor($limitstart / $limit) * $limit) : 0 );
		
		$model = $this->getModel('country');
		
		$total = $model->getTotalList();
		
		$search				= $mainframe->getUserStateFromRequest( $context.'country'.'search',			'search',			'',	'post' );
		$search				= JString::strtolower($search);
				
		// Create the pagination object
		jimport('joomla.html.pagination');
		$pagination = new JPagination($total, $limitstart, $limit);
		
		$session = JFactory::getSession();
		$menuName = $session->get('menuName');
		
		if((!empty($menuName)) && (!empty($_REQUEST['task'])))
		{ 
			if($menuName != $_REQUEST['task'])
			{ 
				$session->set('menuName',$_REQUEST['task']);
				$menuName = $session->get('menuName');
				$data = $model->getList('start', $search);
				$pagination->pagesStart = 1;
				$pagination->pagesCurrent = 1;
				$pagination->limitstart = 0;
			}
			else
			{ 
				$session->set('menuName',$_REQUEST['task']);
				$data = $model->getList('', $search);
			}
		}
		else
		{ 
			if(!empty($_REQUEST['task']))
			$session->set('menuName',$_REQUEST['task']);
			$data = $model->getList('', $search);
		}
		
		$this->addToolbar();
		$this->assignRef('data',$data);
		$this->assignRef('pagination',$pagination);
		$this->assignRef('search',$search);		
		parent::display($tpl);
	}
	



	 protected function addToolbar()
	{
		  JToolBarHelper::addNew('add');
		 JToolBarHelper::editList('edit');
		 JToolBarHelper::publish('publish', 'JTOOLBAR_PUBLISH', true);
		 JToolBarHelper::unpublish('unpublish', 'JTOOLBAR_UNPUBLISH', true);
		 JToolBarHelper::deleteList('Are you sure you want to delete this record?');
	}


	function form($tpl = null){
	
		
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		$id = JRequest::getVar( 'id', $cid[0], '', 'int' );
		
		$countryModel =& $this->getModel('country');
		$fieldsList  = $countryModel->getList();
		
		$data = '';
		
		if($id!=0){
			$countryModel =& $this->getModel('country');
			$countryModel->id = $id;
			$data = $countryModel->getList();
			$this->assignRef("data",$data[0]);
		}
       	
		else
		{
			$data =& JTable::getInstance('country');
			$this->assignRef("data",$data);
		}

		$this->addToolbarform();
		parent::display($tpl);
	}

	protected function addToolbarform()
	{
		JToolBarHelper::apply('apply');
		JToolBarHelper::save('save');
		JToolBarHelper::cancel('cancel');
	}
	// newly added
function formadd($tpl = null){
		    $data = '';
			$data =& JTable::getInstance('country');
			$this->assignRef("data",$data);	
			$this->addToolbarform();
		parent::display($tpl);
	}


	function saveData($tpl = null){
		
		$mainframe = Jfactory::GetApplication();
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		$id = JRequest::getVar( 'id', $cid[0], '', 'int' );
		
    	$task = JRequest::getCmd('task');

    	$db = & JFactory::getDBO();
        $tableClassName = 'JTableCountry' ;
		$row = new $tableClassName($db);

    	$post = JRequest::get( 'post' );
	

	

    	if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
	
		
		
		$row->title = JRequest::getVar('country','');

	 	// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
	    
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}



		switch($task){
			case 'save':
			default:
				$link = "index.php?option=com_jsplocation&controller=country&task=country";
				$msg	= JText::_( 'Country saved successfully' );
			break;
			
			case 'apply':
				if($id=='0')
				{
					$id=$db->insertid();
				}
				$link = "index.php?option=com_jsplocation&controller=country&task=edit&cid[]=".$id;
				$msg	= JText::_( 'Changes saved' );
		}

		$mainframe->redirect( $link, $msg, 'MESSAGE' );
    	
	}
	
	function deleteData($tpl = null){
		$mainframe = Jfactory::GetApplication();
        $master_name = JRequest::getVar("master_name");

    	$db	= & JFactory::getDBO();

		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));

		if (count( $cid )) {
			$cids = implode( ',', $cid );
		}
		
		$model = $this->getModel('country');
		$model->deleteData($cids);
		
		$link = "index.php?option=com_jsplocation&controller=country";
		$msg	= JText::sprintf( 'Deleted Successfully');

		$mainframe->redirect( $link, $msg, 'MESSAGE' );
	}
	
	// function publishdata($tpl = null) {
		// $mainframe = Jfactory::GetApplication();
		// $search				= $mainframe->getUserStateFromRequest( $context.'search',			'search',			'',	'string' );
		// $search				= JString::strtolower($search);
		// echo $search;die;
	// }
}	
