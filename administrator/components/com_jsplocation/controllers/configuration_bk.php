<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: configuration.php  $
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.controller' );
jimport('joomla.filesystem.file');

class jspLocationControllerConfiguration extends JControllerLegacy {
	
	function display($cachable = false, $urlparams=false){
	
		
		$model	= $this->getModel( 'configuration' );
		$view = $this->getView('configuration');
		$params=$model-> getParams();
		$view->setModel( $model, true );
		$view->setLayout("default");
		$view->display();	
	}
	
	function save($tpl = null){
	
		$mainframe = Jfactory::GetApplication();
		$db		=  JFactory::getDBO();
		$model	= $this->getModel( 'configuration' );
		$params=$model-> getParams();
		$view = $this->getView('configuration');
		$view->setModel( $model, true );
        $maptitle =		JRequest::getVar('maptitle', '', 'post');
		$map_type =     JRequest::getVar('map_type', '','post');
						
		if($map_type==0)
		 { $bingMap_key = $params['BingMap_key'];
		 }
		else
		   { $bingMap_key =  ltrim(JRequest::getVar('bing_key', '','post'));
		   }
		$bingMap_key =  ltrim(JRequest::getVar('bing_key', '','post'));
		$jquery =		JRequest::getVar('jquery', '', 'post');
		$height = 		JRequest::getVar('height', '', 'post');
		$zoomlevel = 	JRequest::getVar('zoomlevel', '', 'post');
		$lat_ovr_conf = JRequest::getVar('lat_ovr_conf', '', 'post');
		$long_ovr_conf =JRequest::getVar('long_ovr_conf', '', 'post');
		$branch_id = 	JRequest::getVar('branch_id', '', 'post');	
		$branch_url = 	JRequest::getVar('branch_url', '', 'post');
		$search = 		JRequest::getVar('search', '', 'post');
		$directions = 	JRequest::getVar('directions', '', 'post');
		$branchlist = 	JRequest::getVar('branchlist', '', 'post');
		$country = 		JRequest::getVar('country', '', 'post');
		$state = 		JRequest::getVar('state', '', 'post');
		$city = 		JRequest::getVar('city', '', 'post');
		$area = 		JRequest::getVar('area', '', 'post');
		$displaytitle = JRequest::getVar('displaytitle', '', 'post');
		$zip_search = 	JRequest::getVar('zip_search', '', 'post');
		$category_search = JRequest::getVar('category_search', '', 'post');
		$country_search = JRequest::getVar('country_search', '', 'post');
		$state_search = JRequest::getVar('state_search', '', 'post');
		$city_search = 	JRequest::getVar('city_search', '', 'post');
		$area_search = 	JRequest::getVar('area_search', '', 'post');
		$google_autocomplete_address = JRequest::getVar('google_autocomplete_address', '', 'post');
		$radius_range = JRequest::getVar('radius_range', '', 'post');
		$template	  = JRequest::getVar('template', '', 'post');
		$min_zip	  = JRequest::getVar('min_zip', '', 'post');
		$max_zip	  = JRequest::getVar('max_zip', '', 'post');
		$locateme	  = JRequest::getVar('locateme', '', 'post');
		$locateme_radius	  = JRequest::getVar('locateme_radius', '', 'post');
		$branch_img_id	  = JRequest::getVar('branch_img_id', '', 'post');
		$image_display 	  = JRequest::getVar('image_display', '', 'post');
		$direction_range = JRequest::getVar('direction_range', '', 'post');
		$show_pointer_type = JRequest::getVar('show_pointer_type', '', 'post');
		$page_limit = JRequest::getVar('page_limit', '', 'post');
		$pointertype = JRequest::getVar('pointertype', '','post');
		$fillcolor = JRequest::getVar('fillcolor', '', 'post');
		$fontsize = JRequest::getVar('fontsize', '', 'post');
		$locationstatus = JRequest::getVar('locationstatus', '', 'post');

		$query = "UPDATE #__jsplocation_configuration SET 
		maptitle = 			'".$maptitle."',
		map_type =          '".$map_type."',
		BingMap_key =      '".$bingMap_key."',
		jquery = 			'".$jquery."',
		height = 			'".$height."',
		zoomlevel = 		'".$zoomlevel."',
		lat_ovr_conf = 		'".$lat_ovr_conf."',
		long_ovr_conf = 	'".$long_ovr_conf."',
		branch_id = 		'".$branch_id."',
		branch_url = 		'".$branch_url."',
		search = 			'".$search."',
		directions = 		'".$directions."',
		branchlist = 		'".$branchlist."',
		country = 			'".$country."',
		state = 			'".$state."',
		city = 				'".$city."',
		area = 				'".$area."',
		displaytitle = 		'".$displaytitle."',
		zip_search = 		'".$zip_search."',
		category_search = 	'".$category_search."',
		country_search = 	'".$country_search."',
		state_search = 		'".$state_search."',
		city_search = 		'".$city_search."',
		area_search = 		'".$area_search."',		
		google_autocomplete_address = '".$google_autocomplete_address."',
		radius_range = 		'".$radius_range."',
		template  = 		'".$template."',
		min_zip = 			'".$min_zip."',
		max_zip = 			'".$max_zip."',
		locateme = 			'".$locateme."',
		locateme_radius = 	'".$locateme_radius."',
		branch_img_id   =   '".$branch_img_id."',
		image_display   =   '".$image_display."',
		direction_range =   '".$direction_range."',
		show_pointer_type = '".$show_pointer_type."',
		page_limit = '".$page_limit."',
		pointertype = '".$pointertype."',
		fillcolor = '".$fillcolor."',
		fontsize = '".$fontsize."',
		location_status ='".$locationstatus."'
		where id =1";
		
		$db->setQuery($query);
		if (!$db->query()) {
			JError::raiseError( 500, $db->getErrorMsg() );
			return false;
		}
		else{
		$link = 'index.php?option=com_jsplocation';
 		$msg  = 'Details Has Been Saved';
 		$mainframe->redirect($link,$msg, 'MESSAGE');
		}
    }
	
	function apply($tpl = null){
		$mainframe = Jfactory::GetApplication();
		$db		=  JFactory::getDBO();
		$model	= $this->getModel( 'configuration' );
		$params=$model->getParams();
		$view = $this->getView('configuration');
		$view->setModel( $model, true );

		$maptitle =		JRequest::getVar('maptitle', '', 'post');
		$map_type =     JRequest::getVar('map_type', '', 'post');
		if($map_type==0)
		 { 
		     $bingMap_key = $params['BingMap_key'];;
		 }
		else
		   { $bingMap_key =  ltrim(JRequest::getVar('bing_key', '','post'));
		   }
		$jquery =		JRequest::getVar('jquery', '', 'post');
		$height = 		JRequest::getVar('height', '', 'post');
		$zoomlevel = 	JRequest::getVar('zoomlevel', '', 'post');
		$lat_ovr_conf = JRequest::getVar('lat_ovr_conf', '', 'post');
		$long_ovr_conf =JRequest::getVar('long_ovr_conf', '', 'post');
		$branch_id = 	JRequest::getVar('branch_id', '', 'post');	
		$branch_url = 	JRequest::getVar('branch_url', '', 'post');
		$search = 		JRequest::getVar('search', '', 'post');
		$directions = 	JRequest::getVar('directions', '', 'post');
		$branchlist = 	JRequest::getVar('branchlist', '', 'post');
		$country = 		JRequest::getVar('country', '', 'post');
		$state = 		JRequest::getVar('state', '', 'post');
		$city = 		JRequest::getVar('city', '', 'post');
		$area = 		JRequest::getVar('area', '', 'post');
		$displaytitle = JRequest::getVar('displaytitle', '', 'post');
		$zip_search = 	JRequest::getVar('zip_search', '', 'post');
		$category_search = JRequest::getVar('category_search', '', 'post');
		$country_search = JRequest::getVar('country_search', '', 'post');
		$state_search = JRequest::getVar('state_search', '', 'post');
		$city_search = 	JRequest::getVar('city_search', '', 'post');
		$area_search = 	JRequest::getVar('area_search', '', 'post');
		$google_autocomplete_address = JRequest::getVar('google_autocomplete_address', '', 'post');
		$radius_range = JRequest::getVar('radius_range', '', 'post');
		$template	  = JRequest::getVar('template', '', 'post');
		$min_zip	  = JRequest::getVar('min_zip', '', 'post');
		$max_zip	  = JRequest::getVar('max_zip', '', 'post');
		$locateme	  = JRequest::getVar('locateme', '', 'post');
		$locateme_radius	= JRequest::getVar('locateme_radius', '', 'post');
		$branch_img_id	  = JRequest::getVar('branch_img_id', '', 'post');
		$image_display 	  = JRequest::getVar('image_display', '', 'post');
		$direction_range = JRequest::getVar('direction_range', '', 'post');
		$show_pointer_type = JRequest::getVar('show_pointer_type', '', 'post');
		$page_limit = JRequest::getVar('page_limit', '', 'post');
		$pointertype = JRequest::getVar('pointertype', '','post');
		$fillcolor = JRequest::getVar('fillcolor', '', 'post');
		$fontsize = JRequest::getVar('fontsize', '', 'post');
	    $locationstatus = JRequest::getVar('locationstatus', '', 'post');


		$query = "UPDATE #__jsplocation_configuration SET 
		maptitle = 			'".$maptitle."',
		map_type =          '".$map_type."',
		BingMap_key =      '".$bingMap_key."',
		jquery = 			'".$jquery."',
		height = 			'".$height."',
		zoomlevel = 		'".$zoomlevel."',
		lat_ovr_conf = 		'".$lat_ovr_conf."',
		long_ovr_conf = 	'".$long_ovr_conf."',
		branch_id = 		'".$branch_id."',
		branch_url = 		'".$branch_url."',
		search = 			'".$search."',
		directions = 		'".$directions."',
		branchlist = 		'".$branchlist."',
		country = 			'".$country."',
		state = 			'".$state."',
		city = 				'".$city."',
		area = 				'".$area."',
		displaytitle = 		'".$displaytitle."',
		zip_search = 		'".$zip_search."',
		category_search = 	'".$category_search."',
		country_search = 	'".$country_search."',
		state_search = 		'".$state_search."',
		city_search = 		'".$city_search."',
		area_search = 		'".$area_search."',
		google_autocomplete_address = '".$google_autocomplete_address."',
		radius_range = 		'".$radius_range."',
		template  = 		'".$template."',
		min_zip = 			'".$min_zip."',
		max_zip = 			'".$max_zip."',
		locateme = 			'".$locateme."',
		locateme_radius = 	'".$locateme_radius."',
		branch_img_id   =   '".$branch_img_id."',
		image_display   =   '".$image_display."',
		direction_range =   '".$direction_range."',
		show_pointer_type = '".$show_pointer_type."',
		page_limit = '".$page_limit."',
		pointertype = '".$pointertype."',
		fillcolor = '".$fillcolor."',
		fontsize = '".$fontsize."',
		location_status ='".$locationstatus."'
		
		
		where id =1";
		
		$rows =$db->setQuery($query);
		
		if (!$db->query()) {
			JError::raiseError( 500, $db->getErrorMsg() );
			return false;
		}
		else{
		$link = 'index.php?option=com_jsplocation&controller=configuration&task=configuration';
 		$msg  = 'Details Has Been Saved';
 		$mainframe->redirect($link,$msg, 'MESSAGE');
		}
    }
    function upload($tpl = null)
    	{
    		$mainframe = Jfactory::GetApplication();
    		$upload=0;
    		
    		$file=JRequest::getVar('txtImagepath', '', 'files', 'array');			  		
    		$serverpath=JPATH_SITE.'/images/jsplocationimages/jsplocationPointers/';   		
    		
    		// Make the file name safe.			
			$filename = JFile::makeSafe($file['name']);
			
			$ext = strtolower(substr(strrchr($file['name'], "."), 1));
			$image_extensions_allowed = array('jpg', 'jpeg', 'png', 'gif','bmp');
			$src=$file['tmp_name'];
			$dest=$serverpath;
			
			// Move the uploaded file into a permanent location.
			if (isset( $file['name'] )) 
			{
				if(!in_array($ext, $image_extensions_allowed))
				{
	 				$upload=1;
					$msg  = 'Invalid Image type';
	 				JError::raiseWarning(0,$msg, 'Warning');
				}
				if ($_FILES['txtImagepath']['size']>524288)
	    		{	
	 				$upload=1;
	    			$msg  = 'File size too large. Size limit is 512KB';
	 				JError::raiseWarning(0,$msg, 'Warning');
	    		}	    		
	    		$imageinfo = getimagesize($src);	    		
	    		if ($imageinfo[0]>22 || $imageinfo[1]>32)
	    		{
	 				$upload=1;
	    			$msg  = 'File size too large. Maximum file dimension is 22 x 32';
	 				JError::raiseWarning(0,$msg, 'Warning');
	    		}
	    		if ($upload==1)
	    		{
	    			$link = 'index.php?option=com_jsplocation&controller=configuration&task=configuration';
	    			$mainframe->redirect($link);	
	    		}
	    		
			    // Make sure that the full file path is safe.
			    $filepath = JPath::clean( $serverpath.'/'.strtolower( $file['name'] ) );
			    			    
			    // Move the uploaded file.			   
			    JFile::upload( $src, $filepath );
			    
			    $link = 'index.php?option=com_jsplocation&controller=configuration&task=configuration';
 				$msg  = 'Details Has Been Saved';
 				$mainframe->redirect($link,$msg, 'MESSAGE');
			}
    	}
		function defaultimageupload($tpl = null)
    	{
    		$mainframe = Jfactory::GetApplication();
    		$upload=0;
    		
    		$file=JRequest::getVar('defaultImagepath', '', 'files', 'array');			  		
    		$serverpath=JPATH_SITE.'/images/jsplocationimages/jsplocationImages/';   		
    		
    		// Make the file name safe.			
			$filename = JFile::makeSafe($file['name']);
			
			$ext = strtolower(substr(strrchr($file['name'], "."), 1));
			$image_extensions_allowed = array('jpg', 'jpeg', 'png', 'gif','bmp');
			$src=$file['tmp_name'];
			$dest=$serverpath;
	
			$newfilename = "default.".$ext;
		    $newfilename = JFile::makeSafe($newfilename);
			$newfilename = strtolower($newfilename);
			
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
	    			$link = 'index.php?option=com_jsplocation&controller=configuration&task=configuration';
	    			$mainframe->redirect($link);	
	    		}
	    		
			    // Make sure that the full file path is safe.
			    $filepath = JPath::clean( $serverpath.'/'. $newfilename);
			    
                $name = JFile::stripExt($newfilename);                   // cleans up all files having same name
      			$files = glob($serverpath.$name.".*"); // get all file names
                foreach($files as $file) { // iterate files
                if(is_file($file))
							
                 unlink($file); } // delete file
			    
			    // Move the uploaded file.			   
			    JFile::upload( $src, $filepath );

			  $model	= $this->getModel( 'configuration' );
		      $view = $this->getView('configuration');
		      $view->setModel( $model, true );
			  $view->updateImgname($newfilename);
			}
    	}
		function delete($tpl = null)
				{
					$mainframe = Jfactory::GetApplication();
					$ret = true;
    		$defImg=false;
    		$msg1="";
    		$msg="";
    		$link = 'index.php?option=com_jsplocation&controller=configuration&task=configuration';
    		$images	= JRequest::getVar( 'cid', 'array', 'post','array');    		
    		if ($images[0]!='array')
    			{
					foreach ($images as $image)
					{
						if ($image=='jsplocation_icon.png')
						{
							$msg="Cannot delete default image";
							JError::raiseWarning(0,$msg, 'Warning');
						}
						else
						{						
						$fullPath = JPATH_SITE.'/images/jsplocationimages/jsplocationPointers/'.$image;						
						if (is_file($fullPath))
							{							
							$ret |= !JFile::delete($fullPath);											
							$msg1  = 'Image deleted';			
							}
						}
					}
					if ($msg1=="")
					{			
 						$mainframe->redirect($link);	
					}
					else
					{
						$mainframe->redirect($link,$msg1, 'MESSAGE');
						
					}
					
    			}
    			else
    			{	
    				$msg  = 'Please select image to delete';
    				JError::raiseWarning(0,$msg, 'Warning');
    				$mainframe->redirect($link);
    				
    			}
    		
    	}
		function cancel(){
		$mainframe	 = JFactory::getApplication();
		$link = 'index.php?option=com_jsplocation';
 		$msg  = '';
 		$mainframe->redirect($link,$msg);
	}

	function getImgname(){
		$brId = JRequest::getVar('brid');
		$model = $this->getModel("configuration");
		$str = $model->getImagename($brId);
		echo $str[0]->imagename;
		exit;
	}
	
	function locationdetails(){
		$model	= $this->getModel( 'configuration' );
		$view = $this->getView('configuration');
		$view->setModel( $model, true );
		$view->setLayout("default");
		$view->locationdetails();
	}
	
	function exportdata(){
	
	    $model	= $this->getModel( 'configuration' );
		$view = $this->getView('configuration');
		$view->setModel( $model, true );
		$view->setLayout("default");
		$view->exportdata();
	
	
	}

	
}
?>