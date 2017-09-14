<!doctype html>
<html>
<head>
<meta charset="utf-8">

<?php

/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator - Modern Theme
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default.php  $
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.filesystem.folder');
JHTML::_('behavior.modal');
jimport('joomla.environment.browser');
include JPATH_COMPONENT.'/'.'helpers'.'/'.'helper.php';

$myabsoluteurl=&JURI::getInstance()->toString(array('path','query'));
$document = & JFactory::getDocument();
$document->addScript(JURI::base() . 	"components/com_jsplocation/scripts/jQuery.js");
$document->addScript(JURI::base() . 	"components/com_jsplocation/scripts/jQuery.equalHeights.js");
$document->addScript(JURI::base() . 	"components/com_jsplocation/scripts/validation.js");
$document->addScript(JURI::base() . 	"components/com_jsplocation/scripts/jquery.mCustomScrollbar.concat.min.js");

$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/bootstrap.min.css");
$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/font-awesome.min.css");
$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/jquery.mCustomScrollbar.css");
$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/style_bing.css");
$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/responsive.css");

$sef 				= JFactory::getConfig()->get('sef', false);
$sef 				= ($sef == 0) ? $sef="&" : $sef="?";
$tmpl 				= JRequest::getVar( 'tmpl','','get' );
$tmpl 				= ($tmpl == 'component') ? $tmpl=$sef."tmpl=component" : $tmpl="";

$app = JFactory::getApplication(); 
$menu = $app->getMenu();
$menuItem = $menu->getItems( 'link', 'index.php?option=com_jsplocation&view=classic', true );

$store_id=JRequest::getVar('id');

$params = $this->params;

$configParams = $this->configParams;
$latlng 		= $this->latlng[0];

?>
<script type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=7.0"></script>
<script type="text/javascript">
    (function($){
        $(window).load(function(){
           // $("").mCustomScrollbar();
			
			getMap();
        });
    })(jQuery);
	
				  var map = null;
				  var defaultInfobox=null;
				  var image = null;
				  var pushpinOptions = null;
				  var pushpin = null;
				  var pushpinClick = null;
				  var directionsManager;
				  var directionsErrorEventObj;
				  var directionsUpdatedEventObj; 
				  var postAddress;
				  var currentLatitude = <?php echo $latlng->latitude;  ?>;
				  var currentLongitude = <?php echo $latlng->longitude;  ?>;
				  var tohereClicked = 1;
				  var fromhereClicked;		
				  var fullscreen;
	
				         <?php if (strpos($_SERVER['QUERY_STRING'],'tmpl=component') !== false) 
								{
						  ?> 		
								fullscreen = 1; 
						  <?php
								}
						  ?>		
						
						function ToHERE(){
                        $j("#adress_label").empty();
                        $j("#adress_label").append("Start Address");
                        $j("#tohere-link").css({'font-weight':'bold'});
                        $j("#fromhere-link").css({'font-weight':'normal'});
                        if(tohereClicked != 1){
                        $j('#address').val('');
                        }
                        tohereClicked = 1;
                        fromhereClicked = 0;
                        }
                        
                        function FromHERE(){
                        $j("#adress_label").empty();
                        $j("#adress_label").append("End Address");
                        $j("#fromhere-link").css({'font-weight':'bold'});
                        $j("#tohere-link").css({'font-weight':'normal'});
                        if(fromhereClicked != 1){
                        $j('#address').val('');
                        }
                        fromhereClicked = 1;
                        tohereClicked = 0;
                        }
						
						function goBack(){
						$j('#jsp_title').empty();
						$j('#jsp_title').append('Locations');
						$j('#address').val('');
						$j(".side_bar").css('display','block');
						$j("#jsp_pagination").css('display','block');
						$j("#direct").css('display','none');
						if(directionsManager){
						directionsManager.resetDirections();
						}
						}
						
						function searchAnotherLocation(){
						// $j("#directions").css('display','none');
						// $j("#direct").css('display','block');
						// $j('#address').val('');
						if(directionsManager){
						directionsManager.resetDirections();
						}
						if(document.getElementById('walk')){
						document.getElementById('walk').checked = false; 
						}
						}
						
						function findROUTE(){
						
						//postAddress = $j('#formRoute').serializeArray();
						postAddress = $j('#address').val();
						
						if($j('#address').val().trim() == 0){
							$j('#address').focus();
							alert('Enter address to find a route');
							
							return;
						}
						else{
						//$j('#find').val('Finding Route...');
						}
						//console.log(postAddress);
						
							if (!directionsManager)
							{
							Microsoft.Maps.loadModule('Microsoft.Maps.Directions', { callback: createDrivingRoute });
							}
							else
							{
							createDrivingRoute();
							}
						}
						
						
						 function createDirectionsManager()
						{
						   var displayMessage;
						   if (!directionsManager) 
						   {
							  directionsManager = new Microsoft.Maps.Directions.DirectionsManager(map);
							  displayMessage = 'Directions Module loaded\n';
							  displayMessage += 'Directions Manager loaded';
						   }
						   
						  // alert(displayMessage);
						   directionsManager.resetDirections();
						   directionsErrorEventObj = Microsoft.Maps.Events.addHandler(directionsManager, 'directionsError', function(arg)  { alert(arg.message); });
						   directionsUpdatedEventObj = Microsoft.Maps.Events.addHandler(directionsManager, 'directionsUpdated', function() { alert('Directions updated'); });
							
						}
						
						function createDrivingRoute()
						{	
							
						
							if (!directionsManager) { createDirectionsManager(); }
							directionsManager.resetDirections();
							// Set Route Mode to driving 
							
							if(document.getElementById("walk").checked == true){
							directionsManager.setRequestOptions({ routeMode: Microsoft.Maps.Directions.RouteMode.walking });
							}
							else{
							directionsManager.setRequestOptions({ routeMode: Microsoft.Maps.Directions.RouteMode.driving });
							}
							if(tohereClicked == 1)
							{
							var seattleWaypoint = new Microsoft.Maps.Directions.Waypoint({ address: postAddress });
							directionsManager.addWaypoint(seattleWaypoint);
							var tacomaWaypoint = new Microsoft.Maps.Directions.Waypoint({ location: new Microsoft.Maps.Location(currentLatitude , currentLongitude) });
							directionsManager.addWaypoint(tacomaWaypoint);
							}
							else if(fromhereClicked == 1)
							{
							var seattleWaypoint = new Microsoft.Maps.Directions.Waypoint({ location: new Microsoft.Maps.Location(currentLatitude , currentLongitude) });
							directionsManager.addWaypoint(seattleWaypoint);
							var tacomaWaypoint = new Microsoft.Maps.Directions.Waypoint({ address: postAddress });
							directionsManager.addWaypoint(tacomaWaypoint);
							}
							// Set the element in which the itinerary will be rendered
							directionsManager.setRenderOptions({ itineraryContainer: document.getElementById('directions') });
							
							alert('Calculating directions...');
							directionsManager.calculateDirections();
							
							
							
							setTimeout(function() {   //calls click event after a certain time
								if($j('#directions1_DisambiguationContainer').length){
								if ($j('#directions1_DisambiguationContainer').html().indexOf("did you mean:") > -1 || $j('#directions1_DisambiguationContainer').html().indexOf("We didn't find results for your search.") > -1){
								// $j("#directions").css('display','block');     
								// $j("#direct").css('display','none');     
								}
								}
							}, 1000);
							
							
							
						}
						
						function getMap()
				  {	
					
					
					map = new Microsoft.Maps.Map(document.getElementById('img_map'), {credentials: '<?php print_r($configParams[0]->BingMap_key); ?>'  , showMapTypeSelector:false , center: new Microsoft.Maps.Location(<?php echo $latlng->latitude; ?>,<?php echo $latlng->longitude; ?>) , zoom: 12 , showBreadcrumb: true ,  width: 438, height: 546 });
					
						if(fullscreen == 1){
					map.setView({ width:630 });
					
					}
				  }
				
				
	
</script>
</head>

<body class="jspaddress_body">

<div class="jsp_main">
	<div class="jsp_wrap">
    	        
        <div class="jsp_body">
        	<div class="branch">
            	<div class="branch_wrap1">
                	
                    <div class="jsp_address">
                       <div class="address_div">
                       <div class="top_add">
                          <ul>
                             <li><div id='fromhere-link' class="from_add"><a title="<?php echo JText::_('FROM_HERE_DESCRIPTION');?>"  href="javascript:FromHERE()">From Here</a></div></li>
                             <li><div id='tohere-link' class="to_add"><a title="<?php echo JText::_('FROM_HERE_DESCRIPTION');?>"  href="javascript:ToHERE()">To Here</a></div></li>
                          </ul>
                        </div>
						<form id='formRoute' action='javascript:findROUTE()'>
                        <div class="bottom_add">
						
                          <div id="adress_label" class="start_add">Start Address</div>
                          <input type="text" id="address" class="input_search form-control address_search"/>
                        </div>
                        </div>
						
						
						<?php
						
						$style = "";
						
						?>
						
						<?php if (strpos($_SERVER['QUERY_STRING'],'tmpl=component') !== false) 
                        {
                        
							$style = "height:424px !important;";
							
						}
							  
						?>
                        
                        <div class="direction_div dir_new" style='<?php echo $style;?>'>
                          <div class="getdir_add"><input type='submit' class='btn-default jsp_tab_get_direction' id='find' name='find' value='Get Directions'/></div>
                          <div class="check_path">
                             <div class="walk_path"><p>Walk</p> <input id="walk" type="checkbox" style="margin-top: 2px;margin-left: 4px;"> </div>
                             
                          </div>
						  
                          
						 
                         </form> 
                         <div class="direction_div">
						  <div class="dir_d">
						  <div class="directions directions_bing " id="directions"></div>
						  </div>
                          </div>
						</div> 
                    </div>
					
                </div>
                
               <!-- <div class="jsp_pagination">
                	<div class="prev"><a href=""><i class="fa fa-angle-left"></i> Previous</a></div>
                    <div class="next active"><a href="#">Next</a><i class="fa fa-angle-right"></i></div>
                </div>-->
                
            </div>
            <div class="map">
            	<div class="map_inner">
                	<!--<img src="images/map.jpg" alt="map">-->
                    <div class="img_map new_img" id="img_map" style="height: 548px;"></div>
                   
                </div>
                
                
               
                
            </div>
            
             
        </div>
		<div class="jsp_fullscr">
					<div class="full_left">
                
                <?php if (strpos($_SERVER['QUERY_STRING'],'tmpl=component') !== false) 
                        {
                        ?>
                <a href="<?php echo JURI::base().'index.php?option=com_jsplocation&view=classic&Itemid='.$menuItem->id;?>&tmpl=component"><i class="fa fa-home"></i></a>
                <?php    }
                      else
                        {
                        ?>
                <a href="<?php echo JURI::base().'index.php?option=com_jsplocation&view=classic&Itemid='.$menuItem->id;?>"><i class="fa fa-home"></i></a>
                <?php     } ?>
                </div>
                	<?php if (strpos($_SERVER['QUERY_STRING'],'tmpl=component') === false) 
                        {
                        ?>
                <div class="prev full_right new_icon"><a target="_blank" href="<?php echo JURI::base().'index.php?option=com_jsplocation&task=directionview&id='.$store_id.'&tmpl=component'; ?>" title="<?php echo JText::_('FULLSCREEN_TITLE'); ?>" target="_blank"><?php echo JText::_('FULLSCREEN'); ?><img src="<?php echo JURI::base();?>components/com_jsplocation/images/fullscr.png"></a></div>
                <?php     } ?>
                </div>
        <div class="full_branch_list">
        	<div>
                
                <?php if (strpos($_SERVER['QUERY_STRING'],'tmpl=component') !== false) 
                        {
                        ?>
                <a href="<?php echo JURI::base().'index.php?option=com_jsplocation&view=classic&task=redirectviewbranchlist';?>&tmpl=component">Click here for full branch list</a>
                <?php    }
                      else
                        {
                        ?>
                <a href="<?php echo JURI::base().'index.php?option=com_jsplocation&view=classic&task=redirectviewbranchlist';?>">Click here for full branch list</a>
                <?php     } ?>
                
                
                   
               </div>
        </div>
    </div>
</div>

<script type="text/javascript">

	var $j = jQuery.noConflict();

	$j(document).ready(function() {
		$j(".branch_wrap ul li").click(function(){
			/*$(".map_innerwrap").css("display","block");*/	
			$j(".map_innerwrap").fadeIn(300);
		});
        $j(".close").click(function(){
			$j(".map_innerwrap").fadeOut(300);
		});
		
		
		
		
		var alert_h = $j('.img_map').height();
		var rbl = $j('.img_map').css('padding-left').replace(/[^-\d\.]/g, '');
		$j('.branch_wrap').height(alert_h-(Math.round(rbl)*2));
		
    });
	
	
	 function tohere()
	{
        document.getElementById('endTxt').style.display = "none";
        document.getElementById('endTxtFld').style.display = "none";
        document.getElementById('end').value = "";
        document.getElementById('startTxt').style.display = "inline";
        document.getElementById('toLink').style.fontWeight = 'bold';
        document.getElementById('fromLink').style.fontWeight = 'normal';
        document.getElementById('startTxtFld').style.display = "inline";
    }
                        
						function fromhere()
						{
                            document.getElementById('startTxt').style.display = "none";
                            document.getElementById('startTxtFld').style.display = "none";
                            document.getElementById('start').value = "";
                            document.getElementById('endTxt').style.display = "inline";
                            document.getElementById('toLink').style.fontWeight = 'normal';
                            document.getElementById('fromLink').style.fontWeight = 'bold';
                            document.getElementById('endTxtFld').style.display = "inline";
                       }
	
</script>

</body>
</html>
