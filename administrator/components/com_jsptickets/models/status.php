<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: status.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
jimport('joomla.application.component.modeladmin');

class jspticketsModelstatus extends JModelAdmin {
	
	public function __construct($config = array()) 
	 { 
		 if (empty($config['filter_fields'])) { 
		 $config['filter_fields'] = array( 
		 'id', 'a.id', 
		 'name', 'a.name', 
		 'description', 'a.description',
		 'publish', 'a.publish'
		 );
		}
	 parent::__construct($config);
	 }
	
	
	public function getForm($data = array(), $loadData = true)
        {
 
			$app = JFactory::getApplication();
 
			// Get the form.
            $form = $this->loadForm('com_jsptickets.status', 'status', array('control' => 'jform', 'load_data' => true));
            if (empty($form)) {
                return false;
            }
            return $form;
 
        }
	public function getCount($filter_published=null, $search)
	{
		$db = JFactory::getDBO();
		$query = 'SELECT count(*) AS `count` FROM `#__jsptickets_status` AS a';
		if( ( $this->escape_string($search) != null ) || ( $filter_published != null && $filter_published != "*" ) )
		{
			$query.= " WHERE ";
		}
		if($this->escape_string($search) != null)
		{
			$query.='a.name LIKE "%'. $this->escape_string($search) . '%"';
		}
		if($filter_published != null && $filter_published != "*")
		{
			$query.='a.publish = '.(int) $filter_published;
		}
		$db->setQuery($query);
		$data = $db->loadObject();
		return $data->count;
	}
	
	function escape_string($query_input = null)
	{
		$search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
		$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
		return str_replace($search, $replace, $query_input);
	}
	
	public function getList($listOrder=null, $listDirn=null, $filter_published=null, $search, $total)
	{
		$mainframe = Jfactory::GetApplication();
		$context = JRequest::getVar('option');
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.id, a.name, a.publish'
			)
		);
		$query->from('#__jsptickets_status AS a');
		
		//Add the list filtering clause
		if( $this->escape_string($search) != null )
		$query->where('a.name LIKE "%'. $this->escape_string($search) . '%"');
		
		if( $filter_published != null && $filter_published != "*" )
		$query->where('a.publish = '.(int) $filter_published);
		
		// Add the list ordering clause
		if($listOrder != null && $listDirn != null)
		$query->order( $listOrder.' '.$listDirn );
		
		if($total <= $limit || $total <= $limitstart || $limit==0)
		{
			$limitstart = 0;
		}
		$db->setQuery( $query,$limitstart,$limit );
		$data = $db->loadObjectList();
		return $data;
	}
	
	public function getFormData($id = null)
	{
		$db = JFactory::getDBO();
		$query = 'SELECT * FROM `#__jsptickets_status` WHERE `id` LIKE '. $id ;
		$db->setQuery($query);
		$data = $db->loadObjectList();
		return $data;
	}
	
	public function publishstatus($id)
	{
		$db = JFactory::getDBO();
		$query = "UPDATE `#__jsptickets_status` SET `publish` = '1' WHERE `id` = " . $id ;
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
	}
	
	public function unpublish($id)
	{
		$db = JFactory::getDBO();
		$query = "UPDATE `#__jsptickets_status` SET `publish` = '0' WHERE `id` = " . $id ;
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
	}
	
	public function remove($id)
	{
		$db = JFactory::getDBO();
		$query = "DELETE FROM `#__jsptickets_status` WHERE `id` = " . $id ;
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
	}
}