<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: fields.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

class jspLocationModelFields extends JModelLegacy {

	var $id = '';

	function getList($limitstart='') {
		$mainframe = Jfactory::GetApplication();
		$context = JRequest::getVar('option');
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		
		if($limitstart!='start')
		{
			$limitstart	= $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');

			// In case limit has been changed, adjust limitstart accordingly
			$limitstart = ( $limit != 0 ? (floor($limitstart / $limit) * $limit) : 0 );
		}
		else
		{
			$limitstart	= $mainframe->setUserState( $context.'limitstart', 0 );
		}
		
		
		$db = $this->getDBO();

		$query = "SELECT * from #__jsplocation_fields";
		if($this->id)
		$query .= " Where id=".$this->id;
        $query .= " ORDER BY field_name asc";
		if($this->id){
			$db->setQuery( $query );
		} else {
			$db->setQuery( $query,$limitstart,$limit );
		}
        
		$rows = $db->loadObjectList();		
		return $rows;
	}

	function getTotalList(){
		$db = $this->getDBO();

		$query = "SELECT * from #__jsplocation_fields";
        $query .= " ORDER BY field_name asc";
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		return count($rows);
	}
	
	function saveData(){

		$db = $this->getDBO();
		
		$query  = "INSERT INTO #__jsplocation_fields";
		$fieldName = $fieldValues = '';

		foreach($_POST as $key => $value){	
			
			if($key != "task" && $key != "option"){
				$fieldName .= $key .",";
				$fieldValues .= "'" . $value ."',";
			}
		} 
		$query .= " (" . substr($fieldName,0,-1) .")";
		$query .= " VALUES (" . substr($fieldValues,0,-1) .")";

		$db->setQuery($query);
		$db->query();		
		return $db->insertid();
	}
	
	function deleteData($cids){
		$db = $this->getDBO();
		
		if($cids){
			$query   = "DELETE from #__jsplocation_fields";
			$query  .= " where id IN(".$cids.")";			
			$db->setQuery($query);
			$db->query();	
		}	
		return true;
	}


	function getCustomfeilds(){
		$db = $this->getDBO();
		
		
			$query   = "SELECT * FROM `#__jsplocation_fields`";
			$query  .= " WHERE `predefined` =0 and `published` =1";		
            $query .= " ORDER BY field_name asc";			
			$db->setQuery($query);
			$db->query();	

		$rows = $db->loadObjectList();
		return $rows;
	}
}
?>