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
jimport('joomla.filesystem.folder');
jimport('joomla.environment.browser');
$document = JFactory::getDocument();
$document->addScript(JURI::base()."components/com_jsplocation/scripts/jQuery.js");
	// $task = JRequest::getCmd('task');
	// echo $task;
	// exit();
class jsplocationController extends JControllerLegacy
{
	function display($cachable = false, $urlparams = Array())
	{
        // $document = JFactory::getDocument();
		// $document->addScript(JURI::base()."components/com_jsplocation/scripts/jQuery.js");
				
		// Make sure we have a default view
		$mainframe = Jfactory::GetApplication();
		$params = $mainframe->getParams();
		$this->params=$params;
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
		$useragent=$_SERVER['HTTP_USER_AGENT'];
		
$tablet_browser = 0;
$mobile_browser = 0;
 
if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $tablet_browser++;
}
 
if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $mobile_browser++;
}
 
if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
    $mobile_browser++;
}
 
$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
$mobile_agents = array(
    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
    'newt','noki','palm','pana','pant','phil','play','port','prox',
    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
    'wapr','webc','winw','winw','xda ','xda-');
 
if (in_array($mobile_ua,$mobile_agents)) {
    $mobile_browser++;
}
 
if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
    $mobile_browser++;
    //Check for tablets on opera mini alternative headers
    $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
      $tablet_browser++;
    }
}
 
if ($tablet_browser > 0) {
   // do something for tablet devices
   $tmp = 'mobile';
}
else if ($mobile_browser > 0) {
   // do something for mobile devices
  $tmp = 'mobile';
}
else {
   // do something for everything else
   print 'is desktop';
}   
		
		// if(Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
// $tmp = 'mobile';
// }

// if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){

// $tmp = 'mobile';

// }	
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
		
		if($tmp == 'mobile'){
			$layout = 'mobile';	
		}
		
		// $tmp = 'mobile';
		// $layout = 'mobile';
		
		
		JRequest::setVar('view',$tmp);
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
		$mainframe = Jfactory::GetApplication();
		$params = $mainframe->getParams();
		$this->params=$params;
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
	
	function redirectviewinfo_mobile(){
	
	$storeid=JRequest::getVar('id');
	$serverpath=JPATH_SITE.'/images/jsplocationimages/jsplocationImages/';
	$jsplocationmodel=$this->getModel('jspLocation');		
	$view=$this->getView('mobile','html');
	$view->setModel($jsplocationmodel);
	$view->setLayout('info_mobile');
		
	$view->redirectviewinfo_mobile($serverpath,$storeid);
	}
	
	function redirectviewbranchlist(){
		$selectedCategory = JRequest::getVar('category');
		$view=$this->getView('classic','html');
		$jsplocationmodel=$this->getModel('jspLocation');
		$view->setModel($jsplocationmodel);
		$view->setLayout('fullbranchlist');
		$view->redirectviewbranchlist($selectedCategory);
    }
	function redirectviewbranchlist_mobile(){
		$selectedCategory = JRequest::getVar('category');
		$storeid = JRequest::getVar('id');
		$view=$this->getView('mobile','html');
		$jsplocationmodel=$this->getModel('jspLocation');
		$view->setModel($jsplocationmodel);
		$view->setLayout('fullbranchlist_mobile');
		$view->redirectviewbranchlist_mobile($selectedCategory);
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
	
	function directionview_mobile(){
    $storeid = JRequest::getVar('id');
    $view=$this->getView('mobile','html');
    $jsplocationmodel=$this->getModel('jspLocation');
    $view->setModel($jsplocationmodel);
    $db = JFactory::getDBO();
    $sql="SELECT `map_type` from `#__jsplocation_configuration`";
    $db->setQuery($sql);
    $map_type=$db->loadObject();
    // if($map_type->map_type == 1){
    // $view->setLayout('bingdirections');
    // }
    // else{
    // $view->setLayout('googledirections');
    // }
	
	$view->setLayout('googledirections_mobile');
   
   $view->directionview_mobile($storeid);
   
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
