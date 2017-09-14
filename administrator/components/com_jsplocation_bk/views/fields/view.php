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
JToolBarHelper::title(JText::_('FIELDS_LIST'), 'fields_article.png');
jimport( 'joomla.application.component.view');
require_once(JPATH_COMPONENT_ADMINISTRATOR.'/'.'tables'.'/'.'fields.php');
class JspLocationViewFields extends JViewLegacy {
	
	function display($tpl = null) {
		$mainframe = Jfactory::GetApplication();
		$context = JRequest::getVar('option');
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ( $limit != 0 ? (floor($limitstart / $limit) * $limit) : 0 );
		
		$model = $this->getModel('fields');
				
		$total = $model->getTotalList();

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
				$data = $model->getList('start');
				$pagination->pagesStart = 1;
				$pagination->pagesCurrent = 1;
				$pagination->limitstart = 0;
			}
			else
			{
				$session->set('menuName',$_REQUEST['task']);
				$data = $model->getList();
			}
		}
		else
		{
			if(!empty($_REQUEST['task']))
			$session->set('menuName',$_REQUEST['task']);
			$data = $model->getList();
		}
		
        $this->addToolbar();
		$this->assignRef('data',$data);
		$this->assignRef('datavalues',$datavalues);

		$this->assignRef('pagination',$pagination);
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
		
		$fieldsModel =& $this->getModel('fields');
		$fieldsList  = $fieldsModel->getList();		
                $this->assignRef('fieldsList',$fieldsList);
		$data = '';
		if($id)
		{
			$fieldsModel->id = $id;
			$data = $fieldsModel->getList();
			$this->assignRef('data',$data[0]);	
		}
		
		else
		{
			$data =& JTable::getInstance('fields');
			$this->assignRef("data",$data);
            $field_type = 'Text Field';
			$this->assignRef("field_type",$field_type);
		}
		
		
		
        $this->addToolbarform();
	
		$this->assignRef('fieldsListvalue',$fieldsListvalue);	

		parent::display($tpl);
	}

	  protected function addToolbarform()
	{
		JToolBarHelper::apply('apply');
		JToolBarHelper::save('save');
		JToolBarHelper::cancel('cancel');
	}
 function formadd($tpl = null){
		$fieldsModel =& $this->getModel('fields');
		$fieldsList  = $fieldsModel->getList();
		$this->assignRef('fieldsList',$fieldsList);		
		$data = '';
		$data =& JTable::getInstance('fields');
		$this->assignRef("data",$data);
        $field_type = 'Text Field';
	    $this->assignRef("field_type",$field_type);
		$this->assignRef('fieldsListvalue',$fieldsListvalue);
			$this->addToolbarform();
		parent::display($tpl);
	}
	
	function saveData($tpl = null){
		$mainframe = Jfactory::GetApplication();

		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		$id = JRequest::getVar( 'id', $cid[0], '', 'int' );
        $rid = $id;
    	$task = JRequest::getCmd('task');
		
		$db = & JFactory::getDBO();
		
        $tableClassName = 'JTableFields' ;
		$row = new $tableClassName($db);

    	$post = JRequest::get( 'post' );

    	if (!$row->bind( $post )) {
			JError::raiseError(500, $row->getError() );
		}
		
	 	// pre-save checks
		if (!$row->check()) {
			JError::raiseError(500, $row->getError() );
		}
		// save the changes
		if (!$row->store()) {
			JError::raiseError(500, $row->getError() );
		}
		$lastId = $row->id;
		$field_value = $post['field_value'];
		$field_value_label = $post['field_value_label'];
		$count_no_of_fields = JRequest::getVar('field_value_label','','int');
		
		for ( $i=1;$i<= $count_no_of_fields ;$i++)
		{
		$current_radioname = 'radioname'.$i;
		$current_radiolabel = 'radiolabel'.$i;
		$radioname = JRequest::getVar($current_radioname,'','string');
        $radiolabel = JRequest::getVar($current_radiolabel,'','string');
		$checkboxname = JRequest::getVar('checkboxname'.$i,'','string');
        $checkboxlabel = JRequest::getVar('checkboxlabel'.$i,'','string');
		$selectname = JRequest::getVar('selectname'.$i,'','string');
		$selectlabel = JRequest::getVar('selectlabel'.$i,'','string');
		
		$field_type = JRequest::getVar(field_type);
		
		if($field_type == radio ){
		$inputvalue .= ($inputvalue=="") ? "('','$lastId','".$radioname."','".$radiolabel."')" : ",('','$lastId','".$radioname."','".$radiolabel."')";
		}
		
		if($field_type == check ){
		$inputvalue .= ($inputvalue=="") ? "('','$lastId','".$checkboxname."','".$checkboxlabel."')" : ",('','$lastId','".$checkboxname."','".$checkboxlabel."')";
		}
		
		if($field_type == select ){
		$inputvalue .= ($inputvalue=="") ? "('','$lastId','".$selectname."','".$selectlabel."')" : ",('','$lastId','".$selectname."','".$selectlabel."')";
		}
		}

		// Check the results
		if ($db->getErrorNum()) {
		$this->setError($db->getErrorMsg());
		$return = false;
		}

    	switch($task){
			case 'save':
			default:
				$link = "index.php?option=com_jsplocation&controller=fields&task=fields";
				$msg	= JText::_( 'Fields data saved successfully' );
			break;
			
			case 'apply':
				$id=$db->insertid();
				if($id == 0)
        {
                 $id = $rid;
        }
				$link = "index.php?option=com_jsplocation&controller=fields&task=edit&cid[]=".$id;
				$msg	= JText::_( 'Changes saved' );
			break;
		}

		$mainframe->redirect( $link, $msg, 'MESSAGE' );
	}
	
	function deleteData($tpl = null){
		$mainframe = Jfactory::GetApplication();
        $master_name = JRequest::getVar("master_name");

    	$db				= & JFactory::getDBO();
		$cid			= JRequest::getVar( 'cid', array(0), '', 'array' );
         
		 $ciid = array();
			foreach($cid as $catid)
				{
				if($catid >7){
                 $ciid[] = $catid;
				}
		   }
		JArrayHelper::toInteger($ciid, array(0));

		if (count( $ciid )) {
			$cids = implode( ',', $ciid );

            $model = $this->getModel('fields');
		$model->deleteData($cids);
		
		$link = "index.php?option=com_jsplocation&controller=fields";
		$msg	= JText::sprintf( 'Deleted Successfully');

		$mainframe->redirect( $link, $msg, 'MESSAGE' );

		}
		else
		{
		
		$link = "index.php?option=com_jsplocation&task=fields";
		$msg	= JText::sprintf( 'Cannot Delete the Default fields.');
         JError::raiseWarning('401', $msg, 'Warning');
		$mainframe->redirect( $link );

		}
	
		
		
	}
}	