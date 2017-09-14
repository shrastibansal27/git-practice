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

JToolBarHelper::title(JText::_('BRANCH_LIST'), 'branch_article.png');
jimport( 'joomla.application.component.view');
require_once(JPATH_COMPONENT_ADMINISTRATOR.'/'.'tables'.'/'.'branch.php');
jimport('joomla.html.pane');
class JspLocationViewBranch extends JViewLegacy {

	protected $categories;
	protected $items;
	protected $pagination;
	protected $state;

	function display($tpl = null) {

		$this->categories	= $this->get('CategoryOrders');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		$mainframe = Jfactory::GetApplication();
		$context = JRequest::getVar('option');
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ( $limit != 0 ? (floor($limitstart / $limit) * $limit) : 0 );
		
		$model = $this->getModel('branch');
		
		$total = $model->getTotalList();
		
		$search				= $mainframe->getUserStateFromRequest( $context.'branch'.'search',			'search',			'',	'string' );
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
		$configModel = $this->getModel('configuration');
        $configParams = $configModel->getParams();
	
		$fieldsModel = $this->getModel('fields');
		$customfieldsList  = $fieldsModel->getCustomfeilds();
		$fieldsList  = $fieldsModel->getList();
	
		$areaModel = $this->getModel('branch');
		$data = '';

		if($id!=0)
		{
			$branchModel = $this->getModel('branch');
			$branchModel->id = $id;
			$data = $branchModel->getList();
			$selectCategoryid   = $data[0]->category_id;
			$selectCategoryid   = explode( ",", $selectCategoryid );
			$selectAreaid 		= $data[0]->area_id;
			$selectCountryid 	= $data[0]->country_id;	 
			
			$row = $data[0];
			
	
			$customfeildsData = $branchModel->getcustomfeildsData($id);
	
	
		}
		else
		{
			$areaModel = $this->getModel('branch');
			$data = $areaModel->getListArea();
			$selectCategoryid   = "0";
			$selectAreaid 		= "0";
			$selectCountryid 	= "0";
			$row = JTable::getInstance('branch');
			$customfeildsData = '';
		}
		
		
		
		$imageDirectoryModel = $this->getModel('branch');
		$infoarray = $imageDirectoryModel->getDirectoryPath();
		$branchname = $imageDirectoryModel->getBranch($cid);


		$categoryList[]		= JHTML::_('select.option',  '0', JText::_( 'Select Category' ), 'id', 'title' );
		$categoryList        = array_merge( $categoryList, $areaModel->categoryList());
        $list['category']    = JHTML::_('select.genericlist',$categoryList, 'category_id[]', 'class="inputbox"  multiple="multiple"','id', 'title', $selectCategoryid );

		$countryList[]		= JHTML::_('select.option',  '0', JText::_( 'Select Country' ), 'id', 'title' );
		$countryList        = array_merge( $countryList, $areaModel->countryList());
        $list['country']    = JHTML::_('select.genericlist',$countryList, 'country_id', 'class="inputbox chzn-done" onchange="return showStatesBranchAdmin()" size="1"','id', 'title', $selectCountryid );
									  
        $stateList[]		= JHTML::_('select.option',  '0', JText::_( 'Select State' ), 'id', 'title' );
		$stateList          = array_merge( $stateList, $areaModel->stateList());
        $list['state']      = JHTML::_('select.genericlist',$stateList, 'state_id', 'class="inputbox chzn-done" onchange="return showCitiesBranchAdmin()" size="1"','id', 'title', $data[0]->state_id );
		
		$cityList[]		    = JHTML::_('select.option',  '0', JText::_( 'Select City' ), 'id', 'title' );
		$cityList           = array_merge( $cityList, $areaModel->cityList());
        $list['city']       = JHTML::_('select.genericlist',$cityList, 'city_id', 'class="inputbox chzn-done" onchange="return showAreas2()" size="1"','id', 'title', $data[0]->city_id );
		
		$areaList[]		    = JHTML::_('select.option','0', JText::_( 'Select Area'), 'id', 'title' );
		$areaList           = array_merge( $areaList, $areaModel->areaList());
        $list['area']       = JHTML::_('select.genericlist',$areaList, 'area_id', 'class="inputbox chzn-done" size="1"','id', 'title', $selectAreaid );

		$this->addToolbarform();
		$HTMLfields = $this->form_HTML($fieldsList,$data[0]);
		$this->assignRef("customfieldsList",$customfieldsList);
		$this->assignRef("htmlFields",$HTMLfields);
	    $this->assignRef("customfeildsData",$customfeildsData);
		$this->assignRef("configParams",$configParams);
		$this->assignRef("data",$data);
		$this->assignRef('list',$list);
		$this->assignRef('row',$row);
		$this->assignRef('infoarray',$infoarray);
		$this->assignRef('branchname',$branchname);
		
		parent::display($tpl);
	}
	

	// newly added
function formadd($tpl = null){
		$configModel = $this->getModel('configuration');
        $configParams = $configModel->getParams();
	
		$fieldsModel = $this->getModel('fields');
		$customfieldsList  = $fieldsModel->getCustomfeilds();
		$fieldsList  = $fieldsModel->getList();
	
		$areaModel = $this->getModel('branch');
		$data = '';
			$areaModel = $this->getModel('branch');
			$data = $areaModel->getListArea();
			$selectCategoryid   = "0";
			$selectAreaid 		= "0";
			$selectCountryid 	= "0";
			$row = JTable::getInstance('branch');
			
			$customfeildsData = '';
		$categoryList[]		= JHTML::_('select.option',  '0', JText::_( 'Select Category' ), 'id', 'title' );
		$categoryList        = array_merge( $categoryList, $areaModel->categoryList());
        $list['category']    = JHTML::_('select.genericlist',$categoryList, 'category_id[]', 'class="inputbox"  multiple="multiple"','id', 'title', $selectCategoryid );

		$countryList[]		= JHTML::_('select.option',  '0', JText::_( 'Select Country' ), 'id', 'title' );
		$countryList        = array_merge( $countryList, $areaModel->countryList());
        $list['country']    = JHTML::_('select.genericlist',$countryList, 'country_id', 'class="inputbox" onchange="return showStatesBranchAdmin()" size="1"','id', 'title', $selectCountryid );
									  
        $stateList[]		= JHTML::_('select.option',  '0', JText::_( 'Select State' ), 'id', 'title' );
		
		
		$stateList          = array_merge( $stateList, $areaModel->stateList());
        $list['state']      = JHTML::_('select.genericlist',$stateList, 'state_id', 'class="inputbox" onchange="return showCitiesBranchAdmin()" size="1"','id', 'title', $data[0]->state_id );
		
		$cityList[]		    = JHTML::_('select.option',  '0', JText::_( 'Select City' ), 'id', 'title' );
		$cityList           = array_merge( $cityList, $areaModel->cityList());
        $list['city']       = JHTML::_('select.genericlist',$cityList, 'city_id', 'class="inputbox" onchange="return showAreas2()" size="1"','id', 'title', $data[0]->city_id );
		
		$areaList[]		    = JHTML::_('select.option',  '0', JText::_( 'Select Area' ), 'id', 'title' );
		$areaList           = array_merge( $areaList, $areaModel->areaList());
        $list['area']       = JHTML::_('select.genericlist',$areaList, 'area_id', 'class="inputbox" size="1"','id', 'title', $selectAreaid );
		
		$this->addToolbarform();

		$HTMLfields = $this->form_HTML($fieldsList,$data[0]);
		$this->assignRef("customfieldsList",$customfieldsList);
		$this->assignRef("htmlFields",$HTMLfields);
	    $this->assignRef("customfeildsData",$customfeildsData);
		$this->assignRef("configParams",$configParams);
		$this->assignRef("data",$data);
		$this->assignRef('list',$list);
		$this->assignRef('row',$row);
		
		
		parent::display($tpl);
	}


	  protected function addToolbarform()
	{
		JToolBarHelper::apply('apply');
		JToolBarHelper::save('save');
		JToolBarHelper::cancel('cancel');
	}

	 
	function form_HTML($fieldsList,$data){
		$model = $this->getModel('fields');
		foreach($fieldsList as $field){
		$htmlVar[] = $field->field_name;
		
		}
		return $htmlVar;
	}
	
	function saveData($tpl = null){
	
		$mainframe = Jfactory::GetApplication();
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		$id = JRequest::getVar( 'id', $cid[0], '', 'int' );
    	$task = JRequest::getCmd('task');        
		$latitude = '';
    	$longitude= '';
		$fieldsModel = $this->getModel('fields');
		$customfieldsList  = $fieldsModel->getCustomfeilds();
    	$post = JRequest::get( 'post' );



        $model = $this->getModel('branch');
    
		
		$cid  =  $post['country_id'];
		$sid  =  $post['state_id'];
		$ctid =  $post['city_id'];
		$aid  =  $post['area_id'];
	 

		
		
           $cntryname = $model->getcountryName($cid);
		   $stname = $model->getstateName($sid);
		   $cityname = $model->getcityName($ctid);
		   $areaname = $model->getareaName($aid);

				$address = $post['zip']. ' ' .$post['address1'] . ' ' . $areaname . ' ' . $cityname . ' ' . $stname . ' ' . $cntryname;				
				$symbol = array(" ", ",", "_");
				$keyword = str_replace($symbol, "+", $address);				 
				//$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $keyword . '&sensor=false');
				$geocode 	= $this->file_get_contents_curls('https://maps.google.com/maps/api/geocode/json?key=AIzaSyDpUWJ2rSVftTmINhmGshe0r9V8SNxvKzU&address=' . $keyword . '&sensor=false');
																
				$output = json_decode($geocode);
				if(isset($output->results[0]->geometry->location->lat) or isset($output->results[0]->geometry->location->lng))
					{
			$latitude = $post['latitude'] = $output->results[0]->geometry->location->lat;
			$longitude = $post['longitude'] = $output->results[0]->geometry->location->lng;	
					}
			
		
               if(($output->status == 'ZERO_RESULTS') or (($latitude=='' || $longitude=='') && ($post['lat_long_override']=='0')))
				{
					$link = "index.php?option=com_jsplocation&controller=branch&task=edit&cid[]=".$id;
					JError::raiseWarning('401', JText::_('LAT_LONG_NOT_DEFINED'));
					$mainframe->redirect( $link, $msg, 'MESSAGE' );
					
				}

				else
					{

       $db =  JFactory::getDBO();
        $tableClassName = 'JTableBranch' ;
		$row = new $tableClassName($db);
    
	

		
		$branch_name = str_replace('"',"&quot;",$post['branch_name']);
        $post['branch_name'] = $branch_name;
		$contact_person = str_replace('"',"&quot;",$post['contact_person']);
        $post['contact_person'] = $contact_person;

		$post['category_id'] = implode( ",", $post['category_id'] );
		
		$address = str_replace(chr(13),"\n",$post['address1']);
        $post['address1'] = $address;
		
		$post['additional_link'] = $addlink;
		
		
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
		
        if($id=='0') // for new location/branch
			{
				$id=$db->insertid();
				foreach($customfieldsList as $cfeild)
				{
				

					$feildname = $cfeild->field_name;
					$feildname =str_replace(" ","_",$feildname);
					$feildid = $cfeild->id;
					$query = "INSERT INTO `#__jsplocation_customfields` (branch_id,feild_id,value) values ('$id','$feildid','$post[$feildname]')";
					$db->setQuery($query);
					
					if (!$db->query())
					{
						JError::raiseError( 500, $db->getErrorMsg() );
						return false;
					}
				}
			
			}
			
			else //for existing locations/branchs
			{
				 $id=$_POST['id'];
				
				foreach($customfieldsList as $cfeild)
				{
			
				    $feildname = $cfeild->field_name;
					$feildname =str_replace(" ","_",$feildname);
					$feildid = $cfeild->id;
					
					$query_select = "SELECT * FROM `#__jsplocation_customfields` WHERE branch_id = ".$id." AND feild_id = ".$feildid;
					$db->setQuery($query_select);
					$result = $db->loadObjectList();
						
						if(empty($result))
						{
							$query = "INSERT INTO `#__jsplocation_customfields` (branch_id,feild_id,value) values ('$id','$feildid','$post[$feildname]')";
						}
						
						else
						{
							 $query = "UPDATE `#__jsplocation_customfields` SET 
							 value  = 		'".$post[$feildname]."'
							 where branch_id = ".$id." AND feild_id = ".$feildid;
						 }
						
						$db->setQuery($query);
						
						if (!$db->query())
						{
							JError::raiseError( 500, $db->getErrorMsg() );
							return false;
						}
		            } //end for-each
					
					
			}

		switch($task){
			case 'save':
			default:
			
				$link 	= "index.php?option=com_jsplocation&controller=branch&task=branch";
				$msg	= JText::_( 'Location saved successfully' );
				break;
			
			case 'apply':
				
				$link = "index.php?option=com_jsplocation&controller=branch&task=edit&cid[]=".$id;
				$msg	= JText::_( 'Changes saved' );
				break;
		}

     }//end else

		$mainframe->redirect( $link, $msg, 'MESSAGE' );
	} //end save function
	
	function deleteData($tpl = null){
		$mainframe = Jfactory::GetApplication();
        $master_name = JRequest::getVar("master_name");

    	$db				=  JFactory::getDBO();

		$cid			= JRequest::getVar( 'cid', array(0), '', 'array' );
		
		JArrayHelper::toInteger($cid, array(0));

		if (count( $cid )) {
			$cids = implode( ',', $cid );
		}
		
		$model = $this->getModel('branch');
		$model->deleteData($cids);
		
		//$link = "index.php?option=com_jsplocation&task=branch";
		$link = "index.php?option=com_jsplocation&controller=branch";
		$msg	= JText::sprintf( 'Deleted Successfully');		
		$mainframe->redirect( $link, $msg, 'MESSAGE' );
	}

	function updateImgname($bname,$actualdirpath,$newfilename){
		
		$mainframe = Jfactory::GetApplication();
        $master_name = JRequest::getVar("master_name");

    	$db				=  JFactory::getDBO();

		$cid			= JRequest::getVar( 'id');
		
		$model = $this->getModel('branch');
		$model->enterImagename($cid,$newfilename);
		
		$model->savedirectorypath($bname,$actualdirpath);
				
		
		
		        $link = 'index.php?option=com_jsplocation&controller=branch&task=edit&cid[]='.$cid;
 				$msg  = 'Details Has Been Saved';
 				$mainframe->redirect($link,$msg, 'MESSAGE');
				
				
				parent::display($tpl);
				
	}
	
	function updateImages($branchid,$msg,$tpl = null){
	
	
	$mainframe = Jfactory::GetApplication();			
	 $link = 'index.php?option=com_jsplocation&controller=branch&task=edit&cid[]='.$branchid;
 	//$msg  = 'Image Deleted Successfully';
 	$mainframe->redirect($link,$msg, 'MESSAGE');
	
	parent::display($tpl);
	
	}
	
	function file_get_contents_curls($url)
	{
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
		
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		
		$data = curl_exec($ch);	
		
		curl_close($ch);
		return $data;
	}
}