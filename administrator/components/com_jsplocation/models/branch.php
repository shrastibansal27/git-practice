<?php
	/**
		* JSP Location components for Joomla!
		* JSP Location is an interactive store locator
		*
		* @author      $Author: Ajay Lulia $
		* @copyright   Joomla Service Provider - 2016
		* @package     JSP Store Locator 2.2
		* @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
		* @version     $Id: branch.php  $
	*/
	// no direct access
	defined( '_JEXEC' ) or die( 'Restricted access' );
	jimport( 'joomla.application.component.model' );
	class jspLocationModelBranch extends JModelLegacy {
		var $id = '';
		function getList($limitstart='', $search=null) {
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
			$query = "SELECT * from #__jsplocation_branch";
			//$search     = JRequest::getVar('search','');
			if($search){
				$where[] = " (branch_name like '%".$search."%' OR zip like '%".$search."%')";
				$query .= (count($where)>0)? " where ". implode("AND",$where) :"";
			}
			if($this->id)
			$query .= " Where id=".$this->id;
			$query .= " ORDER BY branch_name asc";
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
			$query = "SELECT * from #__jsplocation_branch";
			$search     = JRequest::getVar('search','');
			if($search){
				$where[] = " (branch_name like '%".$search."%' OR zip like '%".$search."%')";
				$query .= (count($where)>0)? " where ". implode("AND",$where) :"";
			}
			$query .= " ORDER BY branch_name asc";
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			return count($rows);
		}
		function deleteData($cids){
			$db = $this->getDBO();
			/**-- Code to delete image folder when location is deleted --**/
			$data = $this->getDirectoryPath();
			$branchname = $this->getBranchName($cids);
			foreach($branchname as $branch){
				$locationImagespath =  $data['path'].$branch->branch_name;
				rename($locationImagespath,$locationImagespath.'test');
				// $filesinfolder = glob($locationImagespath);	
				// if(file_exists($locationImagespath)){
				//rmdir($locationImagespath);
				// unlink($locationImagespath);
				//}
			}
			// foreach(glob($locationImagespath.'*.*') as $file){
			// echo $file;
			// die;
			// if(is_file($file))
            // {
			// unlink($file);
            // }
			// }
			/**-- Code to delete image folder when location is deleted --**/
			if($cids){
				$query   = "DELETE from #__jsplocation_branch ";
				$query  .= " where id IN(".$cids.")";
				$db->setQuery($query);
				$db->query();
			}	
			return true;
		}
		function getListArea() {
			$mainframe = Jfactory::GetApplication();
			$context = JRequest::getVar('option');
			$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
			$limitstart	= $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');
			// In case limit has been changed, adjust limitstart accordingly
			$limitstart = ( $limit != 0 ? (floor($limitstart / $limit) * $limit) : 0 );
			$search     = JRequest::getVar('search','');
			$db = $this->getDBO();
			$query = "SELECT * from #__jsplocation_area";
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
		function categoryList()
		{
			$db = $this->getDBO();
			$query = "SELECT id,title from #__jsplocation_category where published = 1";
			$query .= " ORDER BY title asc";
			$db->setQuery($query);
			
			$rows = $db->loadObjectList();
			
			return $rows;
		}
		function countryList()
		{
			$db = $this->getDBO();
			$query = "SELECT id,title from #__jsplocation_country where published = 1";
			$query .= " ORDER BY title asc";
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			return $rows;
		}
		function stateList()
		{
			$cid		= JRequest::getVar( 'cid',		'',			'get' );
			$db = $this->getDBO();
			if(!$cid){
				$query = "SELECT id,title from #__jsplocation_state where published = 1";
				$query .= " ORDER BY title asc";
			}
			else{
				$query = "SELECT * FROM #__jsplocation_branch b 
				LEFT JOIN #__jsplocation_state state on b.state_id=state.id WHERE b.id=".$cid[0];
				$query .= " ORDER BY state.title asc";
			}
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			return $rows;
		}
		function cityList()
		{
			$cid		= JRequest::getVar( 'cid',		'',			'get' );
			$db = $this->getDBO();
			if(!$cid){
				$query = "SELECT id,title from #__jsplocation_city where published = 1";
				$query .= " ORDER BY title asc";
			}
			else{
				$query = "SELECT * FROM #__jsplocation_branch b 
				LEFT JOIN #__jsplocation_city city on b.city_id=city.id WHERE b.id=".$cid[0];
				$query .= " ORDER BY city.title asc";
			}
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			return $rows;
		} 
		function areaList()
		{
			$cid		= JRequest::getVar( 'cid',		'',			'get' );
			$db = $this->getDBO();
			if(!$cid){
				$query = "SELECT id,title from #__jsplocation_area";
				$query .= " ORDER BY title asc";
			}
			else{
				$query = "SELECT * FROM #__jsplocation_branch b 
				LEFT JOIN #__jsplocation_area area on b.city_id=area.city_id WHERE b.id=".$cid[0]." AND area.title!=''";
				$query .= " ORDER BY area.title asc";
			}
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			return $rows;
		} 
		function loadAreaList($cityId) {
			$db = $this->getDBO();
			$query = "select * from #__jsplocation_area AND published=1";
			if ($cityId != null){
				$query = "select id,title from #__jsplocation_area where city_id = ".$cityId." AND published=1"; 
			}
			$query .= " ORDER BY title asc";
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			return $rows;
		}
		function getcountryName($id)
		{
			$db = $this->getDBO();
			$query = "SELECT title from #__jsplocation_country where id = ".$id."";
			$query .= " ORDER BY title asc";
			$db->setQuery($query);
			$rows = $db->loadResult();
			return $rows;
		}
		function getstateName($id)
		{
			$db = $this->getDBO();
			$query = "SELECT title from #__jsplocation_state where id = ".$id."";
			$query .= " ORDER BY title asc";
			$db->setQuery($query);
			$rows = $db->loadResult();
			return $rows;
		}
		function getcityName($id)
		{
			$db = $this->getDBO();
			$query = "SELECT title from #__jsplocation_city where id = ".$id."";
			$query .= " ORDER BY title asc";
			$db->setQuery($query);
			$rows = $db->loadResult();
			return $rows;
		}
		function getareaName($id)
		{
			$db = $this->getDBO();
			$query = "SELECT title from #__jsplocation_area where id = ".$id."";
			$query .= " ORDER BY title asc";
			$db->setQuery($query);
			$rows = $db->loadResult();
			return $rows;
		}
		function getcustomfeildsData($id)
		{
			$db = $this->getDBO();
			$query = "SELECT * from #__jsplocation_customfields  where branch_id = ".$id."";
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			return $rows;
		}
		function enterImagename($id,$newfilename)
		{
			$db = $this->getDBO();
			$query = "UPDATE #__jsplocation_branch SET
			`imagename`= '".$newfilename."',
			`image_display`= '".$_POST['image_display']."'
			WHERE id= ".$id;
			$db->setQuery($query);
			$db->query();
			return;
		}
		function savedirectorypath($bname,$actualdirpath){
			$db = $this->getDBO();
			$query = "SELECT * from #__jsplocation_directory_path";
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			if($rows){
				$query = "UPDATE #__jsplocation_directory_path SET
				`directorypath`= '".$actualdirpath."',`branch`= '".$bname."'
				WHERE id= 0";
				$db->setQuery($query);
				$db->query();
			}
			else{
				$query = "INSERT INTO #__jsplocation_directory_path (directorypath,branch) VALUES('$actualdirpath','$bname');";
				$db->setQuery($query);
				$db->query();
				
			}
			return;
		}
		function getDirectoryPath(){
			$db = $this->getDBO();
			$query = "SELECT * from #__jsplocation_directory_path";
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			$path = $rows[0]->directorypath;
			$branchname = $rows[0]->branch;
			$infoarray = array();
			$infoarray['path'] = $path;
			$infoarray['branch'] = $branchname;
			return $infoarray;
		}
		
		function getBranchName($cid){
			$id=$cid;
			$db = $this->getDBO();
			$query = "SELECT branch_name from #__jsplocation_branch where id IN (".$id.")";
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			return $rows;
			}
		
		function getBranch($cid){
			$id=$cid[0];
			$db = $this->getDBO();
			$query = "SELECT branch_name from #__jsplocation_branch where id=".$id;
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			$branchname = $rows[0]->branch_name;
			return $branchname;
			}
		
	}	
?>