<?php
	/**
		* JSP Location components for Joomla!
		* JSP Location is an interactive store locator
		*
		* @author      $Author: Ajay Lulia $
		* @copyright   Joomla Service Provider - 2016
		* @package     JSP Store Locator 2.2
		* @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
		* @version     $Id: city.php  $
	*/
	// no direct access
	defined( '_JEXEC' ) or die( 'Restricted access' );
	jimport( 'joomla.application.component.model' );
	class jspLocationModelCity extends JModelLegacy {
		var $id = '';
		function getList($limitstart='') {	
			$mainframe = Jfactory::GetApplication();
			$context = JRequest::getVar('option');
			$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
			$search     = JRequest::getVar('search','');
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
			$query = "SELECT * from #__jsplocation_city";
			$where = array();
			if($this->id)
			$where[] = " id=".$this->id;
			if($search){
				$where[] = " (title like '%".$search."%' OR description like '%".$search."%')";
			}
			$query .= (count($where)>0)? " where ". implode("AND",$where) :"";
			$query .= " ORDER BY title asc";
			if($this->id){
				$db->setQuery( $query );
				$rows = $db->loadObject();
				} else {
				$db->setQuery( $query,$limitstart,$limit );
				$rows = $db->loadObjectList();
			}
			return $rows;
		}
		function getTotalList(){
			$db = $this->getDBO();
			$query = "SELECT * from #__jsplocation_city";
			$search     = JRequest::getVar('search','');
			if($search){
				$where[] = " (title like '%".$search."%' OR description like '%".$search."%')";
				$query .= (count($where)>0)? " where ". implode("AND",$where) :"";
			}
			$query .= " ORDER BY title asc";
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			return count($rows);
		}
		function saveData(){
			$db = $this->getDBO();
			$query  = "INSERT INTO #__jsplocation_city";
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
				$query   = "DELETE from #__jsplocation_city";
				$query  .= " where id IN(".$cids.")";			
				$db->setQuery($query);
				$db->query();	
			}	
			return true;
		}
		function countryList() {
			$db = $this->getDBO();
			$query = "SELECT id,title from #__jsplocation_country where published = 1";
			$query .= " ORDER BY title asc";
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			return $rows;
		}
		function stateList() {
			$cid		= JRequest::getVar( 'cid',		'',			'get' );
			$db = $this->getDBO();
			if(!$cid){
				$query = "SELECT id,title from #__jsplocation_state where published = 1";
				$query .= " ORDER BY title asc";
			}
			else{
				$query = "SELECT * FROM #__jsplocation_city c 
				LEFT JOIN #__jsplocation_state state on c.state_id=state.id WHERE c.id=".$cid[0];
				$query .= " ORDER BY state.title asc";
			}
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			return $rows;
		}
		function cityList() {
			$db = $this->getDBO();
			$query = "SELECT id,title from #__jsplocation_city where published = 1";
			$query .= " ORDER BY title asc";
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			return $rows;
		}
		function loadCityList($stateId = null,$countryId){
			$db = $this->getDBO();
			$query = "select id,title from #__jsplocation_city where published =1";
			if ($stateId != null){
				$query = "select id,title from #__jsplocation_city where state_id = ".$stateId." and country_id = ".$countryId." and published =1"; 
			}
			$query .= " ORDER BY title asc";
			$db->setQuery($query);    
			$rows = $db->loadObjectList();
			return $rows;
		}
		function getCityEditData($cityid){
			$db = $this->getDBO();
			$query = "select state_id,title from #__jsplocation_city where id = $cityid";
			$query .= " ORDER BY title asc";
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			return $rows;
		}
		function getCity($city_id){
			$db = $this->getDBO();
			$query = "select title from #__jsplocation_city where id = $city_id";
			$query .= " ORDER BY title asc";
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			return $rows;
		}
	}	