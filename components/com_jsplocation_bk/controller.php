<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: controller.php  $
 */
 
// no direct access
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');
	// $task = JRequest::getCmd('task');
	// echo $task;
	// exit();
class jsplocationController extends JControllerLegacy
{
	function display($cachable = false, $urlparams = Array())
	{
        
				
		// Make sure we have a default view
		$mainframe = Jfactory::GetApplication();
		$params = $mainframe->getParams();
		$this->params=$params;
		// echo "<pre>";
		// print_r($params);
		// exit();
		$model = $this->getModel("jspLocation");
		$data = $model->getParams();
	    if($this->params->get('menu_templates') != "default" && $this->params->get('menu_templates') != -1)
		{
			$tmp = $this->params->get('menu_templates');
		}
		else
		{
		
		$tmp = $data[0]->template;
		}
		
		$db = JFactory::getDBO();
		$sql="SELECT `map_type` from `#__jsplocation_configuration`";
		$db->setQuery($sql);
		$map_type=$db->loadObject();
		
		if($map_type->map_type == 1 && $tmp == 'advanced'){
		$layout = 'advancedbing';
		}
		if($map_type->map_type == 1 && $tmp == 'classic'){
		$layout = 'classicbing';
		}
		else if($map_type->map_type == 1 && $tmp == 'modern'){
		$layout = 'modernbing';
		}
		
		JRequest::setVar('view', $tmp );
		$jsplocationmodel=$this->getModel('jspLocation');
		$view=$this->getview($tmp,'html');
		if(isset($layout)){
		$view->setLayout($layout);
		}
		$view->setModel($jsplocationmodel);
		parent::display();
	}
	
	function getState()
	{        
		$countryId = JRequest::getVar('country');
		
		if($countryId != ''){
			$model = $this->getModel("jspLocation");
			$stateData = $model->stateList($countryId);
			
			$str ='';
			if(is_array($stateData)){
				foreach ($stateData as $k => $v){
					$str .= $v->id."|".$v->title."-";
				}
				$str = substr($str,0,-1);
			}
			echo $str;
		}
		exit;
	}
	
	function getCity()
	{
		$stateId = JRequest::getVar('state');
		if($stateId != ''){
			$model = $this->getModel("jspLocation");
			$cityData = $model->cityList($stateId);
			$str ='';
			if(is_array($cityData)){
				foreach ($cityData as $k => $v){
					$str .= $v->id."|".$v->title."-";
				}
				$str = substr($str,0,-1);
			}
			echo $str;
		}
		exit;
	}

	function getArea()
	{
		$areaId = JRequest::getVar('city');
		if($areaId != ''){
			$model = $this->getModel("jspLocation");
			$areaData = $model->areaList($areaId);
			$str ='';
			if(is_array($areaData)){
				foreach ($areaData as $k => $v){
					$str .= $v->id."|".$v->title."-";
				}
				$str = substr($str,0,-1);		
			}
			echo $str;
		}
		exit;
	}
	
	function search()
	{
	
			
	
		//$mainframe = Jfactory::GetApplication();
		
		   // Make sure we have a default view
		$mainframe = Jfactory::GetApplication();
		$params = $mainframe->getParams();
		$this->params=$params;
		// echo "<pre>";
		// print_r($params);
		// exit();
		$model = $this->getModel("jspLocation");
		$data = $model->getParams();
	    if($this->params->get('menu_templates') != "default" && $this->params->get('menu_templates') != -1)
		{
			$tmp = $this->params->get('menu_templates');
		}
		else
		{
		
		$tmp = $data[0]->template;
		}
		
		
		$db = JFactory::getDBO();
		$sql="SELECT `map_type` from `#__jsplocation_configuration`";
		$db->setQuery($sql);
		$map_type=$db->loadObject();
		
		if($map_type->map_type == 1 && $tmp == 'advanced'){
		
				
		$layout = 'advancedbing';
		}		
		else if($map_type->map_type == 1 && $tmp == 'classic'){
		$layout = 'classicbing';
		}
		else if($map_type->map_type == 1 && $tmp == 'modern'){
		$layout = 'modernbing';
		}
		
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$jsplocationmodel=$this->getModel('jspLocation');
		$view=$this->getview(JRequest::getCmd('view'),'html');
		
		
		
		if(isset($layout)){
						
		$view->setLayout($layout);
		}
		$view->setModel($jsplocationmodel);
		$view->display();
	}
	
   	function showBranchImg()
	{  
	    $imgparam = JRequest::getVar('img');                 //getting branch image parameter
		$jsplocationmodel=$this->getModel('jspLocation');
		$view=$this->getview(JRequest::getCmd('view'),'html');
		
		$view->setModel($jsplocationmodel);
		$view->setLayout('brdesc');
		
		$view->locationImg($imgparam);     //view function called
	}
	
	function showBranchDesc()
	{   
	    //$imgparam = JRequest::getVar('img');                 //getting branch image parameter
		$jsplocationmodel=$this->getModel('jspLocation');
		$view=$this->getview(JRequest::getCmd('view'),'html');
		
		$view->setModel($jsplocationmodel);
		$view->setLayout('brdesc');
		
		$view->locationDesc();     //view function called
	}
	
	// function branch_hit_storedetails(){
				
	// $branch_hit_storeid = JRequest::getVar('branch_hit_storeid');
	
	// $view=$this->getView('classic','html');
	
	// $view->setLayout('info');
	// $view->redirectviewinfo($branch_hit_storeid);
	
	
	// }
	
	function branch_hit()
	{
	
		$date=date("Y-m-d");
		$branch_hit_id = JRequest::getVar('branch_hit_id');
		
				
		$db =& JFactory::getDBO();
				
		if(isset($branch_hit_id))
		{
			$i=0;
			$sql="SELECT `hits` from `#__jsplocation_branchhits` WHERE `branch` = '$branch_hit_id' AND `date` = '$date'";
			$db->setQuery($sql);
			$hitsearch=$db->loadObjectList();
		
			if(isset($hitsearch) and $hitsearch != NULL)
			{
				foreach($hitsearch as $item)
				{
					$i=$item->hits;
					$i++;
				}
		
				$sql1="UPDATE `#__jsplocation_branchhits` SET `hits` = ".$i." WHERE `branch` = '$branch_hit_id' AND `date` = '$date'";
				$db->setQuery($sql1);
				$db->query();
			}
			
			else
			{
				$i++;
				$sql2 = "INSERT INTO `#__jsplocation_branchhits` ( `branch`, `hits`, `date`) VALUES ( '$branch_hit_id', '$i', '$date')";
				$db->setQuery($sql2);
				$db->query();
			}
		}
	}
	
	function plgdetail()
	{
		$jsplocationmodel=$this->getModel('jspLocation');
		$view=$this->getView('classic','html');
		$view->setModel($jsplocationmodel);
		$view->setLayout('brdesc');
		$view->plgDesc();
	}
	
	function plgimg()
	{
		$imgparam = JRequest::getVar('plgimg');
		$jsplocationmodel=$this->getModel('jspLocation');
		$view=$this->getView('classic','html');
		$view->setModel($jsplocationmodel);
		$view->setLayout('brdesc');
		$view->plgImg($imgparam);
	}
    
	function resetvalue()
	{	
			
		$this->display();
	}
	
	function redirectviewinfo(){

	$storeid = JRequest::getVar('id');
	
	$serverpath=JPATH_SITE.'/images/jsplocationimages/jsplocationImages/';
	
	
	
	$jsplocationmodel=$this->getModel('jspLocation');		
	$view=$this->getView('classic','html');
	$view->setModel($jsplocationmodel);
	$view->setLayout('info');
		
	$view->redirectviewinfo($serverpath,$storeid);
	
	}
	
	function redirectviewbranchlist(){
	
		
	$selectedCategory = JRequest::getVar('category');
    $view=$this->getView('classic','html');
    $jsplocationmodel=$this->getModel('jspLocation');
    $view->setModel($jsplocationmodel);
    $view->setLayout('fullbranchlist');
    $view->redirectviewbranchlist($selectedCategory);
    
    }
	
	function directionview(){
    $storeid = JRequest::getVar('id');
    $view=$this->getView('classic','html');
    $jsplocationmodel=$this->getModel('jspLocation');
    $view->setModel($jsplocationmodel);
    $db = JFactory::getDBO();
    $sql="SELECT `map_type` from `#__jsplocation_configuration`";
    $db->setQuery($sql);
    $map_type=$db->loadObject();
    if($map_type->map_type == 1){
    $view->setLayout('bingdirections');
    }
    else{
    $view->setLayout('googledirections');
    }
   
   $view->directionview($storeid);
   
   }
   
   function videodata(){
    
    $storeid = JRequest::getVar('id');
    $view=$this->getView('classic','html');
    $jsplocationmodel=$this->getModel('jspLocation');
	$serverpath=JPATH_SITE.'/images/jsplocationimages/jsplocationImages/';
    $view->setModel($jsplocationmodel);
    $view->setLayout('info');       
$view->videodata($serverpath,$storeid);
   
   }
	
	// function selectCategory(){
		// $selectedCategory = JRequest::getVar('category');
		// $view=$this->getView('classic','html');		
		// $jsplocationmodel=$this->getModel('jspLocation');
		// $view->setModel($jsplocationmodel);
		// $view->setLayout('fullbranchlist');
		
		// $view->selectedcategorybranchlist($selectedCategory);	
	// }
	
	
}
