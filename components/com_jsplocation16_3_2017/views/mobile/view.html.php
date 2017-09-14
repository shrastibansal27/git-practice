<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: view.html.php  $
 */

// no direct access
defined('_JEXEC') or die('Restricted Access');

jimport('joomla.application.component.view');
jimport('joomla.application.application');
class jsplocationViewmobile extends JViewLegacy {
	
	function display($tpl=null)
	{ 	
		
		$session 	= JFactory::getSession();
		$mainframe 	= Jfactory::GetApplication();
		$sef 		= JFactory::getConfig()->get('sef', false);

		$context 	= JRequest::getVar('option');
		$params 	= &$mainframe->getParams(); 
		$this->params=$params;
		$model 		= $this->getModel('jspLocation');
		
		$get_limitstart = JRequest::getVar('limitstart','','GET');
		$get_start = JRequest::getVar('start','','GET');
		$current_sess_limit = $session->get('limitstart');
		
		if(!isset($get_start) || $get_start=="")
		{
			$get_start = 0;
		}
		
		if(!isset($get_limitstart) || $get_limitstart=="")
		{
			$get_limitstart = 0;
		}
		
		
		$menu_cat_default = $mainframe->getUserStateFromRequest($context.'mod_category_id','mod_category_id','','post');
		if($menu_cat_default != '')
		{
           $menu_cat_default = $mainframe->getUserStateFromRequest($context.'mod_category_id','mod_category_id','','post');
		}
		else
		{
           $menu_cat_default = $this->params->get('cat_default');
		}
		
		$category_id 	= $mainframe->getUserStateFromRequest( $context.'category_id','category_id',	$menu_cat_default,	'post');
		
		$country_id			= $mainframe->getUserStateFromRequest( $context.'mod_country_id', 'mod_country_id','','post');
		if($country_id!='')
		{
			$country_id=$mainframe->getUserStateFromRequest( $context.'mod_country_id', 'mod_country_id','','post');
		}
		else
		{
			$country_id 	= $mainframe->getUserStateFromRequest( $context.'country_id',	'country_id',		'',	'post');
		}
		
		$state_id			= $mainframe->getUserStateFromRequest( $context.'mod_state_id', 'mod_state_id','','post');
		if($state_id!='')
		{	
			$state_id		= $mainframe->getUserStateFromRequest( $context.'mod_state_id', 'mod_state_id','','post');
		}
		else
		{
			$state_id 		= $mainframe->getUserStateFromRequest( $context.'state_id',		'state_id',			'',	'post');
		}
		
		$city_id			= $mainframe->getUserStateFromRequest( $context.'mod_city_id', 'mod_city_id','','post');
		if($city_id!='')
		{	
			$city_id		= $mainframe->getUserStateFromRequest( $context.'mod_city_id', 'mod_city_id','','post');
		}
		else
		{
			$city_id 		= $mainframe->getUserStateFromRequest( $context.'city_id',		'city_id',			'',	'post');
		}
		
		$area_id			= $mainframe->getUserStateFromRequest( $context.'mod_area_id', 'mod_area_id','','post');
		if(JRequest::getVar( 'mod_area_id','','post')!='')
		{	
			$area_id		= $mainframe->getUserStateFromRequest( $context.'mod_area_id', 'mod_area_id','','post');
		}
		else
		{
			$area_id 		= $mainframe->getUserStateFromRequest( $context.'area_id',		'area_id',			'',	'post');
		}
		
		$zipsearch	 	= $mainframe->getUserStateFromRequest( $context.'zipsearch',	'zipsearch',		'',	'post');
		$radius 		= $mainframe->getUserStateFromRequest( $context.'radius',		'radius',			'',	'post');
		$locateme 		= $mainframe->getUserStateFromRequest( $context.'locateme',		'locateme',			'',	'post');
		$task 			= $mainframe->getUserStateFromRequest( $context.'task', 		'task',				'',	'post' );   	
		
		if(JRequest::getVar('limitstart')!='' || JRequest::getVar('start')!='' || $task=='search')
		{
			$this->showimage = 0;
		}
		
		else
		{
			$this->showimage = 1;
		}
		
		if($task=='' || $task=='default' || $task == 'resetvalue')
		{
			$task='default';
		}
		
		else
		{
			$task='search';
		}
		
		if(JRequest::getVar('task') == 'resetvalue' || $task == 'resetvalue')							//To check the reset button is triggered 
		{	
			$task='default';
			$this->showimage = 1;
			JRequest::setVar('loc','');																	//To set loc variable in url as blank when "Unique Url" for locations is working 
			if(isset($_POST))
			{
				unset($_POST);
			}
			$menu_cat_default2 = $this->params->get('cat_default');
			$category_id	= $mainframe->setUserState( $context.'category_id' 	, $menu_cat_default2); 	//to give value from params
			$country_id 	= $mainframe->setUserState( $context.'country_id' 	, 0 );
			$state_id		= $mainframe->setUserState( $context.'state_id' 	, 0 );
			$city_id		= $mainframe->setUserState( $context.'city_id' 		, 0 );
			$area_id		= $mainframe->setUserState( $context.'area_id' 		, 0 );
			$zipsearch		= $mainframe->setUserState( $context.'zipsearch' 	, null );
			$radius			= $mainframe->setUserState( $context.'radius' 		, 0 );
			$locateme		= $mainframe->setUserState( $context.'locateme' 	, null );
			
			/*Condition To Reset Module Values Start Here*/
			if($mainframe->getUserStateFromRequest( $context.'mod_category_id', 'mod_category_id','','post')!=0)
			{
				$category_id	= $mainframe->setUserState( $context.'mod_category_id' 	, $menu_cat_default2);
			}
			if($mainframe->getUserStateFromRequest( $context.'mod_country_id', 'mod_country_id','','post')!=0)
			{
				$country_id 	= $mainframe->setUserState( $context.'mod_country_id' 	, 0 );
			}
			if($mainframe->getUserStateFromRequest( $context.'mod_state_id', 'mod_state_id','','post')!=0)
			{
				$state_id		= $mainframe->setUserState( $context.'mod_state_id' 	, 0 );
			}
			if($mainframe->getUserStateFromRequest( $context.'mod_city_id', 'mod_city_id','','post')!=0)
			{
				$city_id		= $mainframe->setUserState( $context.'mod_city_id' 		, 0 );
			}
			if($mainframe->getUserStateFromRequest( $context.'mod_area_id', 'mod_area_id','','post')!=0)
			{
				$area_id		= $mainframe->setUserState( $context.'mod_area_id' 		, 0 );
			}
			/*Condition To Reset Module Values Ends Here*/
		}
		
		$radius 	= ( ($country_id > 0) || ($state_id > 0) || ($city_id > 0) || ($area_id >0) ) ? $radius = "" : $radius = $radius;

	$categoryList = array();
       	$categoryList[]		= JHTML::_('select.option',  '0', JText::_( 'SELECT_CATEGORY' ));
		$categoryList[0]->id = null;
		$categoryList[0]->title = null;
		if($model->categoryList()){
		$categoryList        = array_merge( $categoryList, $model->categoryList());
		}
        $list['category']    = JHTML::_('select.genericlist',$categoryList, 'category_id', 'class="jsp_droplist" onchange="return submitform1()" size="1" title="'.JText::_('CATEGORY_TITLE').'"','id', 'title', $category_id);

		$countryList[]		= JHTML::_('select.option',  '', JText::_( 'SELECT_COUNTRY' ));
		$countryList[0]->id = null;
		$countryList[0]->title = null;
		if($model->countryList()){
		$countryList        = array_merge( $countryList, $model->countryList());
		}
		$list['country']    = JHTML::_('select.genericlist',$countryList, 'country_id', 'class="jsp_droplist" style="display: none;" onchange="return submitform1()"','id', 'title', $country_id );
				
		$stateList[]		= JHTML::_('select.option',  '', JText::_( 'Select State' ));	
		$stateList[0]->id = null;
		$stateList[0]->title = null;
		if($model->stateList($country_id)){
		$stateList          = array_merge( $stateList, $model->stateList($country_id));
		}
		$list['state']      = JHTML::_('select.genericlist',$stateList, 'state_id', 'class="jsp_droplist" style="display: none;" onchange="return submitform1()"','id', 'title', $state_id );
				
		$cityList[]		    = JHTML::_('select.option',  '', JText::_( 'Select City' ));
                 $cityList[0]->id = null;
		$cityList[0]->title = null;
		if($model->cityList($state_id)){
		$cityList           = array_merge( $cityList, $model->cityList($state_id));
		}
		$list['city']       = JHTML::_('select.genericlist',$cityList, 'city_id', 'class="jsp_droplist" style="display: none;" onchange="return submitform1()"','id', 'title', $city_id );
				
		$areaList[]		    = JHTML::_('select.option',  '', JText::_( 'Select Area' ));
		$areaList[0]->id = null;
		$areaList[0]->title = null;
		if($model->areaList($city_id)){
		$areaList           = array_merge( $areaList, $model->areaList($city_id));
		}
		$list['area']       = JHTML::_('select.genericlist',$areaList, 'area_id', 'class="jsp_droplist" style="display: none;" onchange="return submitform1()"','id', 'title', $area_id );
		$configParams=$model->getParams();
		$a = $configParams[0]->locateme_radius;
		
		if($configParams[0]->branch_id!=0 and $this->params->get('map_location')==0)
		{
			$limit = 0;
			$limitstart	= 0;
		}
		
		elseif($this->params->get('map_location')!=0)
		{
			$limit = 0;
			$limitstart	= 0;
		}
		
		else
		{
			$limit = $configParams[0]->page_limit;
			if($sef==0)
			{
				if((JRequest::getVar('limitstart','','GET')=='') || (JRequest::getVar('limitstart','','GET')=='0'))
				{
					$limitstart	= ($session->set('limitstart', '0'));
				}
				
				if($session->get('limitstart')<JRequest::getVar('limitstart'))
				{
					$limitstart	= ($session->set('limitstart', $get_limitstart)) + ($get_limitstart - $current_sess_limit);
				}
				
				else
				{
					$limitstart	= ($session->set('limitstart', $get_limitstart)) - ($current_sess_limit - $get_limitstart);
				}
			}
			else
			{
				if((JRequest::getVar('start','','GET')=='') || (JRequest::getVar('start','','GET')=='0'))
				{
					$limitstart	= ($session->set('limitstart', '0'));
				}
				
				if($session->get('limitstart')<JRequest::getVar('start'))
				{
				
					// Pagination Old condition - Was working till joomla 3.4.5
					
					//$limitstart	= ($session->set('limitstart', $get_start)) + ($get_start - $current_sess_limit);
					
					// Pagination New Condition works in all joomla 3 versions
					
					$limitstart	= $get_start - $current_sess_limit;
				}
				
				else
				{
					$limitstart	= ($session->set('limitstart', $get_start)) - ($current_sess_limit - $get_start);
				}
			}
			if($limitstart < 0)
			{
				$limitstart	 = 0;
			}
		}
				
		if(JRequest::getVar('task') == 'resetvalue')
		{
			$limitstart	= $session->set('limitstart', 0);
			$actual_url = JRoute::_($_SERVER['REQUEST_URI']);
			if($sef==0)
			{
					if(JRequest::getVar('limitstart','','GET')!='')
					{
						$reset_url = explode('&',$actual_url);
						$limitstart_index = count($reset_url)-1;
						$reset_url[$limitstart_index] = '';
						$reset_url = implode('&',$reset_url);
						$mainframe->redirect($reset_url, '');
					}	
			}
			else
			{
					if((JRequest::getVar('start','','GET')!='') and JRequest::getVar('tmpl','','GET')!='component')
					{
						$reset_url = explode('?',$actual_url);
						$limitstart_index = count($reset_url)-1;
						$reset_url[$limitstart_index] = '';
						$reset_url = implode('?',$reset_url);
						$mainframe->redirect($reset_url, '');
					}
					
					if(JRequest::getVar('limitstart','','GET')!='' and JRequest::getVar('tmpl','','GET')=='component')
					{
						$reset_url = explode('&',$actual_url);
						$limitstart_index = count($reset_url)-1;
						$reset_url[$limitstart_index] = '';
						$reset_url = implode('&',$reset_url);
						$mainframe->redirect($reset_url, '');
					}	
			}	
		}

        if(isset($locateme) and $locateme == 'true' )
		{	
			 $geolat  = $mainframe->getUserStateFromRequest( $context.'geolat',			'geolat',			'',	'post');
	         $geolong = $mainframe->getUserStateFromRequest( $context.'geolong',		'geolong',			'',	'post');
			 $radius =$this->params->get('locateme_radius')== 0 ?$a:$this->params->get('locateme_radius');
			 $searchresult=$model->locateMe($task,$geolat,$geolong,$radius,$limit,$limitstart);
		}
		
		else
		{
			$searchresult=$model->displayJsearch($task,$category_id,$country_id,$state_id,$city_id,$area_id,$zipsearch,$radius,$limit,$limitstart);
		}
		
		$total = 0;
		
		if($searchresult!='' && isset($searchresult[0]->totalresult))
		{
			$total = $searchresult[0]->totalresult;
		}
		
		jimport('joomla.html.pagination');
		$pagination = new JPagination($total, $limitstart, $limit);

		$fieldDetails=$model->fieldDetails();
		$defaultAddress=$model->defaultAddress();
		$customfeildsinfo =  $model->getcustomFeilds();
		$manfeildsinfo =  $model->getManFeilds();
		
		if($this->params->get('map_location') != '' && $this->params->get('map_location') != 0)
		{
			$configParams[0]->branch_id=$this->params->get('map_location');
		}
		
		if($configParams[0]->branch_img_id != 0 and $configParams[0]->branch_img_id != '' )
        {
          $db = JFactory::getDBO();
          $query = "SELECT b.imagename as `imagename` from `#__jsplocation_branch` b,`#__jsplocation_configuration` a where a.branch_img_id = b.id";
          $db->setQuery($query);
          $imgdata = $db->loadObject();
          $configParams[0]->imagename = $imgdata->imagename;
        }

		if($searchresult!='')
		{
			foreach($searchresult as $result)
			{ 
			 $branch_name = str_replace("'","\'",$result->branch_name); 
			 $result->branch_name = $branch_name;
			 $address1 = str_replace("'","\'",$result->address1); 
			 $result->address1 = $address1;
			 $contact_person = str_replace("'","\'",$result->contact_person);
			 $result->contact_person = $contact_person;
			}
		}
		$units		= ($this->params->get('radius_range') == 1 || ($this->params->get('radius_range') == 2 && $configParams[0]->radius_range == 'Yes') || ($this->params->get('radius_range') == ''  && $configParams[0]->radius_range == 'Yes')) ? $units = JText::_('MILES') : $units = JText::_('KILOMETERS');
		
		$radiusList = array();
		
		if($radius==""){
			$radiusList[] = JHTML::_( 'select.option', '0', JText::_( 'RADIUS' ));
		}
		else{
			$radiusValue = $radius;
			$radius = ($radius > 0) ? $radius = "$radius $units" : $radius = JText::_( 'RADIUS' );
			$radiusList[] = JHTML::_( 'select.option', $radiusValue, $radius);
		}
		
		if($radius != 5){
		$radiusList[] = JHTML::_( 'select.option', '5', "5 $units" );}
		if($radius != 10){
		$radiusList[] = JHTML::_( 'select.option', '10', "10 $units" );}
		if($radius != 15){
		$radiusList[] = JHTML::_( 'select.option', '15', "15 $units" );}
		if($radius != 25){
		$radiusList[] = JHTML::_( 'select.option', '25', "25 $units" );}
		if($radius != 50){
		$radiusList[] = JHTML::_( 'select.option', '50', "50 $units" );}
		if($radius != 100){
		$radiusList[] = JHTML::_( 'select.option', '100', "100 $units" );}
		if($radius != 500){
		$radiusList[] = JHTML::_( 'select.option', '500', "500 $units" );}
		if($radius != 1000){
		$radiusList[] = JHTML::_( 'select.option', '1000', "1000 $units" );}
		if($radius != 2000){
		$radiusList[] = JHTML::_( 'select.option', '2000', "2000 $units" );}
		
		/*--- Radius Dropdown ---*/
		
		//$list['radius']  = JHTML::_( 'select.genericlist', $radiusList, 'radius','class="jsp_radius" title="'.JText::_('RADIUS_TITLE').'"');
		
		/*--- Radius Dropdown ---*/
		
		$this->assignRef('category_id',$category_id);
		$this->assignRef('country_id',$country_id);
		$this->assignRef('state_id',$state_id);
		$this->assignRef('city_id',$city_id);
		$this->assignRef('area_id',$area_id);
		$this->assignRef('zipsearch',$zipsearch);
		$this->assignRef('radius',$radius);
		$this->assignRef('locateme',$locateme);
		$this->assignRef('task',$task);             //get taskname
		$this->assignRef('pagination',$pagination);
		$this->assignRef('JspLocationConfig',$JspLocationConfig);
		$this->assignRef('row',$rows);
		$this->assignRef('list',$list);
		$this->assignRef('params',$params);
		$this->assignRef('searchresult',$searchresult);
		$this->assignRef('fieldDetails',$fieldDetails);
		$this->assignRef('configParams',$configParams);
		$this->assignRef('defaultAddress',$defaultAddress);
		$this->assignRef('customfeildsinfo',$customfeildsinfo);
		$this->assignRef('manfeildsinfo',$manfeildsinfo);
		$this->assignRef('apiOutput',$apiOutput);
		
				
		
		parent::display($tpl);
	}
	

	function locationDesc($tpl=null)
	{ 
		$id = JRequest::getVar('id','1');
		$model = $this->getModel('jspLocation');
		$desc =  $model->getdescfields($id);
		
		$brname = $desc[0]->branch_name;
		$brdesc = $desc[0]->description;
        $brimg = $desc[0]->imagename;
		$showimg = $desc[0]->image_display;
		
		$this->assignref('brname',$brname);
		$this->assignref('brdesc',$brdesc);
		$this->assignref('brimg',$brimg);
		$this->assignref('showimg',$showimg);
		
		parent::display($tpl);
	}
	
	function locationImg($imgparam,$tpl=null)
	{   
		$id = JRequest::getVar('id','1');
		$model = $this->getModel('jspLocation');
		$desc =  $model->getdescfields($id);
		
		$brname = $desc[0]->branch_name;
		$brdesc = $desc[0]->description;
        $brimg = $desc[0]->imagename;
		$showimg = $desc[0]->image_display;
		
		$this->assignref('brname',$brname);
		$this->assignref('brdesc',$brdesc);
		$this->assignref('brimg',$brimg);
		$this->assignref('showimg',$showimg);
		$this->assignref('imgparam',$imgparam);                //assigning reference to image param
		
		parent::display($tpl);
	}
	
	function plgDesc($tpl=null)
	{
	    $id = JRequest::getVar('id','1');
		$model = $this->getModel('jspLocation');
		$desc =  $model->getdescfields($id);
		
		$brname = $desc[0]->branch_name;
		$brdesc = $desc[0]->description;
		
		$this->assignref('brname',$brname);
		$this->assignref('brdesc',$brdesc);
		
		parent::display($tpl);
	}
	
	function plgImg($plgimg,$tpl=null)
	{ 
	  	$id = JRequest::getVar('id','1');
		$model = $this->getModel('jspLocation');
		$desc =  $model->getdescfields($id);
		
		$brname = $desc[0]->branch_name;
		$brdesc = $desc[0]->description;
		$plgbrimg = $desc[0]->imagename;
		$plgshowimg = $desc[0]->image_display;
		
		$this->assignref('brname',$brname);
		$this->assignref('brdesc',$brdesc);
		$this->assignref('plgimg',$plgimg);           //to display image
		$this->assignref('plgshowimg',$plgshowimg);
		$this->assignref('plgbrimg',$plgbrimg);
		
		parent::display($tpl);
	}
	
	function redirectviewinfo_mobile($serverpath,$storeid,$tpl=null){

	    $mainframe 	= Jfactory::GetApplication();
		$model = $this->getModel('jspLocation');
		
		$params 	= &$mainframe->getParams(); 
		$this->params=$params;
		$configParams=$model->getParams();
		 $latlng = $model->getlatlng($storeid);
	 	 
	 $this->assignref('latlng',$latlng);
		$description =  $model->getdescfields($storeid);
		
		$this->assignref('description',$description);		
		
		$branchdetails=$model->branchdetails($storeid);
		$this->assignRef('params',$params);
		$this->assignref('branchdetails',$branchdetails);
		$this->assignRef('configParams',$configParams);
			
		$getCityName = $model->getCityName($branchdetails[0]->city_id);
		$this->assignref('getCityName',$getCityName);
		
				
		$getcustomFeilds = $model->getcustomFeilds();
		
		$customNames = array();
		$customValues = array();
		if(!empty($getcustomFeilds)) {
	     $i=0;
		 foreach ($getcustomFeilds as $key => $value) { 	
		 
		 if($getcustomFeilds[$i]->branch_id == $storeid){
		 if($getcustomFeilds[$i]->value !=''){
		 $customNames[$i] = $getcustomFeilds[$i]->feild_name;
		 $customValues[$i] = $getcustomFeilds[$i]->value;
		 }
		 }
		
		 $i++;
		 }
		 }
		 $customNames = array_values($customNames);
		 $customValues = array_values($customValues);
		
		 $this->assignref('customNames',$customNames);
		 $this->assignref('customValues',$customValues);
		 
		 $getDefaultFieldStatus = $model->getDefaultFieldStatus();
		 $this->assignref('getDefaultFieldStatus',$getDefaultFieldStatus);
		 
		 $branchname = $branchdetails[0]->branch_name;
		 
		$directory_path = $serverpath.$branchname;
		
		$directory_path =  str_replace('\\',"/",$directory_path);
		 
		 $this->assignref('directory_path',$directory_path);
		 
		
		parent::display($tpl);
	
	}
	
	function redirectviewbranchlist_mobile($selectedCategory,$tpl=null){
	
       $model = $this->getModel('jspLocation');
               
       $branchlist=$model->branchlist();
                
       $this->assignref('branchlist',$branchlist);
       $this->assignref('Category_Selected',$selectedCategory);
        
        
        if($selectedCategory != "" && $selectedCategory != "CAT"){
        
        
         $selectedcategorybranchlist = $model->selectedcategorybranchlist($selectedCategory);
                 
         $this->assignref('selectedcategorybranchlist',$selectedcategorybranchlist);    
        
        }
        
        if($selectedCategory == "CAT"){
        $branchlist=$model->branchlist();
        }

     /* To fetch all categories in jsp location */
     
         $categorylist = $model->allcategory();
             
         $this->assignref('categorylist',$categorylist);
       
        
         parent::display($tpl);
   
   }
	
	function directionview_mobile($storeid,$tpl=null){
	
	$mainframe 	= Jfactory::GetApplication();
	$params 	= &$mainframe->getParams(); 
	
	 $model = $this->getModel('jspLocation');
	 $configParams=$model->getParams();
	 $latlng = $model->getlatlng($storeid);
	 	 
	 $this->assignref('latlng',$latlng);
	 $this->assignref('configParams',$configParams);
	 $this->assignRef('params',$params);
	 parent::display($tpl);
	
	
	}
	
	function videodata($serverpath,$storeid,$tpl=null){
	
		
	$mainframe 	= Jfactory::GetApplication();
	$params 	= &$mainframe->getParams(); 
	
	 $model = $this->getModel('jspLocation');
	 
	$branchdetails=$model->branchdetails($storeid);
	
	$description =  $model->getdescfields($storeid);
        
    $this->assignref('description',$description);
	
	$getDefaultFieldStatus = $model->getDefaultFieldStatus();
	
	$branchname = $branchdetails[0]->branch_name;
         
    $directory_path = $serverpath.$branchname;
        
    $directory_path =  str_replace('\\',"/",$directory_path);
			
	 $configParams=$model->getParams();
	 $this->assignref('directory_path',$directory_path);
	 $this->assignref('branchdetails',$branchdetails);
	 $this->assignref('configParams',$configParams);
	 $this->assignRef('params',$params);
	 $this->assignref('getDefaultFieldStatus',$getDefaultFieldStatus);
    
	 parent::display($tpl);
	
	
	
	}
	
	
}
