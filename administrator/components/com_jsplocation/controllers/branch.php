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
	defined('_JEXEC') or die('Restricted access');
	jimport( 'joomla.application.component.controller' );
	jimport('joomla.filesystem.file');
	require_once(JPATH_COMPONENT_ADMINISTRATOR.'/'.'models'.'/'.'branch.php');
	require_once(JPATH_COMPONENT_ADMINISTRATOR.'/'.'models'.'/'.'fields.php');
	class jspLocationControllerBranch extends JControllerLegacy {
		function display($cachable = false, $urlparams=false){
			$model	= $this->getModel('branch');	
			$view = $this->getView('branch');
			$view->setModel( $model, true );
			$view->setLayout("list");
			$view->display();	
		}
		function fields(){
			$model = $this->getModel('fields');
			$view= $this->getView('fields');
			$view->setModel($model,true);
			$view->setLayout('list');
			$view->display();
		}
		function add(){
			$branchmodel=$this->getModel('branch');
			$configmodel=$this->getModel( 'configuration' );
			$model=$this->getModel( 'fields' );
			$view=$this->getView('branch');
			$view->setModel( $branchmodel, true );
			$view->setModel( $configmodel, true );
			$view->setModel( $model, true );
			$view->setLayout("form");
			$view->formadd();     // newly added
		}	
		function edit(){
			$model	= $this->getModel( 'fields' );
			$branchModel	= $this->getModel( 'branch' );
			$configmodel	= $this->getModel( 'configuration' );
			$view = $this->getView('branch');
			$view->setModel( $model, true );
			$view->setModel( $branchModel, true );
			$view->setModel( $configmodel, true );
			$view->setLayout("form");
			$view->form();
		}
		function save($tpl = null){
			$fieldsModel = $this->getModel('fields');
			$model	= $this->getModel( 'branch' );
			$view = $this->getView('branch');
			$view->setModel( $fieldsModel, true );
			$view->setModel( $model, true );
			$view->saveData();
		}
		function apply($tpl = null){
			$fieldsModel = $this->getModel('fields');
			$model	= $this->getModel( 'branch' );
			$view = $this->getView('branch');
			$view->setModel( $model, true );
			$view->setModel( $fieldsModel, true );
			$view->saveData();
		}
		function remove(){		
			$model	= $this->getModel( 'branch' );
			$view = $this->getView('branch');
			$view->setModel( $model, true );
			$view->deleteData();
		}
		function publish($state = 1){
			$mainframe = Jfactory::GetApplication();
			// Initialize variables
			$db		=  JFactory::getDBO();
			$user	=  JFactory::getUser();
			$cid	= JRequest::getVar( 'cid', array(), 'post', 'array' );
			JArrayHelper::toInteger($cid);
			$option	= JRequest::getCmd( 'option' );
			$task	= JRequest::getCmd( 'task' );
			$rtask	= JRequest::getCmd( 'returntask', '', 'post' );
			if ($rtask) {
				$rtask = '&task='.$rtask;
			}
			if (count($cid) < 1) {
				$redirect	= JRequest::getVar( 'redirect', '', 'post', 'int' );
				$action		= ($state == 1) ? 'publish' : ($state == -1 ? 'archive' : 'unpublish');
				$msg		= JText::_('Select an item to') . ' ' . JText::_($action);
				$mainframe->redirect('index.php?option='.$option.$rtask.'&sectionid='.$redirect, $msg, 'error');
			}
			// Get some variables for the query
			$uid	= $user->get('id');
			$total	= count($cid);
			$cids	= implode(',', $cid);
			$query = 'UPDATE #__jsplocation_branch' .
			' SET published = '. (int) $state .
			' WHERE id IN ( '. $cids .' ) ';
			$db->setQuery($query);		
			if (!$db->query()) {
				JError::raiseError( 500, $db->getErrorMsg() );
				return false;
			}
			switch ($state)
			{
				case -1 :
				$msg = JText::sprintf('Item(s) successfully Archived', $total);
				break;
				case 1 :
				$msg = JText::sprintf('Item(s) successfully Published', $total);
				break;
				case 0 :
				default :
				if ($task == 'unarchive') {
					$msg = JText::sprintf('Item(s) successfully Unarchived', $total);
					} else {
					$msg = JText::sprintf('Item(s) successfully Unpublished', $total);
				}
				break;
			}
			$cache =  JFactory::getCache('com_jsplocation');
			$cache->clean();
			$mainframe->redirect('index.php?option='.$option.$rtask.'&controller=branch&task=branch', $msg, 'MESSAGE');
		}
		function unpublish($state = 0){
			$this->publish($state);
		}
		function getArea(){
			$cityId = JRequest::getVar('city');
			if($cityId != ''){
				$model = $this->getModel("branch");
				$areaData = $model->loadAreaList($cityId);
				$str ='';
				if(is_array($areaData)){
					foreach ($areaData as $k => $v){
						$str .= $v->id."|".$v->title."*";
					}
					$str = substr($str,0,-1);		
				}
				echo $str;
			}
			exit;
		}
		function upload($tpl = null)
    	{
			$mainframe = Jfactory::GetApplication();
    		$upload=0;
    		$file=JRequest::getVar('txtImagepath', '', 'files', 'array');			  		
    		$serverpath=JPATH_SITE.'/images/jsplocationimages/jsplocationImages/';   		
    		// Make the file name safe.			
			$filename = JFile::makeSafe($file['name']);
			$ext = strtolower(substr(strrchr($file['name'], "."), 1));
			$image_extensions_allowed = array('jpg', 'jpeg', 'png', 'gif','bmp');
			$src=$file['tmp_name'];
			$dest=$serverpath;
			$id = JRequest::getVar('id');
			$bname = JRequest::getVar('branch_name');
			/*-- Create Store Directory for image upload --*/			
			$directory_path = $serverpath.$bname;
			$result = mkdir($directory_path, 0755);
			if ($result == 1) {
				echo $directory_path . " has been created";
				} else {
				echo $directory_path . " has NOT been created";
			}
			$newfilename = $id."_".$bname.".".$ext;
		    $newfilename = JFile::makeSafe($newfilename);
			$newfilename = strtolower($newfilename);
			$randomnumber = rand(1,100000);
			$filename = $directory_path.'/'.$newfilename;
			if (file_exists($filename)) {
				$newfilename = $id."_".$bname."_".$randomnumber.".".$ext;
				$newfilename = JFile::makeSafe($newfilename);
				$newfilename = strtolower($newfilename);
			} 		
			// Move the uploaded file into a permanent location.
			if (isset( $file['name'] )) 
			{
				if(!in_array($ext, $image_extensions_allowed))
				{
	 				$upload=1;
					$msg  = 'Invalid Image type';
	 				JError::raiseWarning(0,$msg, 'Warning');
				}
				if ($_FILES['txtImagepath']['size']>2097152)
	    		{	
	 				$upload=1;
	    			$msg  = 'File size too large. Size limit is 2MB';
	 				JError::raiseWarning(0,$msg, 'Warning');
				}	    		
	    		$imageinfo = getimagesize($src);	    		
	    		if ($imageinfo[0]>2000 || $imageinfo[1]>2000)
	    		{
	 				$upload=1;
	    			$msg  = 'File size too large. Maximum file dimension is 2000 x 2000px';
	 				JError::raiseWarning(0,$msg, 'Warning');
				}
				if ($upload==1)
	    		{
	    			$link = 'index.php?option=com_jsplocation&controller=branch&task=edit&cid[]='.$id;
	    			$mainframe->redirect($link);	
				}
	    		// Make sure that the full file path is safe.
			    //$filepath = JPath::clean( $serverpath.'/'. $newfilename);
			    $filepath = JPath::clean($directory_path.'/'. $newfilename);
				$name = JFile::stripExt($newfilename); // cleans up all files having same name
      			$files = glob($serverpath.$name.".*"); // get all file names
				//foreach($files as $file) { // iterate files
                //if(is_file($file))
				//unlink($file); } // delete file
                // Move the uploaded file.			   
			    JFile::upload( $src, $filepath );
				//$actualdirpath = JURI::root().'images/jsplocationimages/jsplocationImages/'.$bname;
				$model = $this->getModel( 'branch' );
				$view = $this->getView('branch');
				$view->setModel( $model, true );
				$view->setLayout("form");
				$directory_path =  str_replace('\\',"/",$serverpath);
				$view->updateImgname($bname,$directory_path,$newfilename);
				}
		}
		function delete($tpl=null){
			$view = $this->getView('branch');
			$serverpath=JPATH_SITE.'/images/jsplocationimages/jsplocationImages/'; 
			$branchid = JRequest::getVar('id');
			$branch = JRequest::getVar('branch_name');
			$msg = 'No Images to Delete';	
			foreach($_POST as $key => $value){
				$exp_key = explode('_', $key);
				if($exp_key[0] == 'checkbox'){
					// $arr_result[] = $value;
					$image_path = $serverpath.$branch.'/'.$value;
					$directory_path =  str_replace('\\',"/",$image_path);	
					$msg  = 'Images Deleted Successfully';
					unlink($directory_path);
				}
			}
			$view->setLayout("form");
			$view->updateImages($branchid,$msg);	 
			// if(isset($arr_result)){
			// print_r($arr_result);
			// }
			// $image_path = $serverpath.$branch.'/'.$image;
			// $directory_path =  str_replace('\\',"/",$image_path);
			// unlink($directory_path);
			// $view->setLayout("form");
			// $view->updateImages($branchid);
			//echo $image_path;
			}
	}
?>