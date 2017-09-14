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
$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/style.css");
$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/responsive.css");

$sef 				= JFactory::getConfig()->get('sef', false);
$sef 				= ($sef == 0) ? $sef="&" : $sef="?";
$tmpl 				= JRequest::getVar( 'tmpl','','get' );
$tmpl 				= ($tmpl == 'component') ? $tmpl=$sef."tmpl=component" : $tmpl="";

$params = $this->params;

$latlng = $this->latlng;

$store_id=JRequest::getVar('id');

$lat = $latlng[0]->latitude;
$long = $latlng[0]->longitude;

$app = JFactory::getApplication(); 
$menu = $app->getMenu();
$menuItem = $menu->getItems( 'link', 'index.php?option=com_jsplocation&view=classic', true );

$configParams = $this->configParams;

$direction_range	= (($this->params->get('direction_range') == 2 && $configParams[0]->direction_range=='Yes')  || $this->params->get('direction_range') == '' && $configParams[0]->direction_range=='Yes' || ($this->params->get('direction_range') == 1)) ? $direction_range = 1 : $direction_range = 0;
$zoomlevel = 1;
// $zoomlevel = $configParams[0]->zoomlevel;
$dir_apiKey = $configParams[0]->GoogleMap_DIR_key;

?>
<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false&libraries=places&key=<?php echo $dir_apiKey;?>"></script>
<script type="text/javascript">
    (function($){
        $(window).load(function(){
            $(".directions").mCustomScrollbar();
        });
    })(jQuery);
	
	
</script>
</head>

<body class="jspaddress_body">

<div class="jsp_main">
	<div class="jsp_wrap">
    	        
        <div class="jsp_body">
        	<div class="branch dir_branch branchdir_1">
            	<div class="branch_wrap1">
                	
                    <div class="jsp_address">
                       <div class="address_div">
                       <div class="top_add">
                          <ul>
                             <li><div class="from_add"><a title="<?php echo JText::_('FROM_HERE_DESCRIPTION');?>" id="fromLink" href="javascript:fromhere(0)"><?php echo JText::_('FROM_HERE');?></a></div></li>
                             <li><div class="to_add"><a title="<?php echo JText::_('TO_HERE_DESCRIPTION');?>" id="toLink" href="javascript:tohere(0)"><?php echo JText::_('TO_HERE');?></a></div></li>
                          </ul>
                        </div>
                        <div class="bottom_add">
                          <div id="startTxt" class="start_add"><?php echo JText::_('START_ADDRESS');?></div>
						  <div id="endTxt" style="display:none;" class="start_add"><?php echo JText::_('END_ADDRESS');?></div>
                          
                        </div>
                        </div>
						
						<?php
						
						$style = "";
						
						?>
						
						<?php if (strpos($_SERVER['QUERY_STRING'],'tmpl=component') !== false) 
                        {
                        
							$style = "height:417px !important;";
							
						}
							  
						?>
                        
                        <div class="direction_div" style='<?php echo $style;?>'>
						
						  <form action="javascript:getDirections(<?php echo $direction_range; ?>)">	
						
						  <span id="startTxtFld"><input SIZE=40 MAXLENGTH=40 name="start" id="start" value="" type="text" class="input_search form-control address_search"/></span>
						  <span id="endTxtFld"  style="display:none;"><input SIZE=40 MAXLENGTH=40 name="end" id="endaddress" value="" type="text" class="input_search form-control address_search"></span> 	
						  
                          <div class="getdir_add">
						  
						  <INPUT value="<?php echo JText::_('GET_DIRECTIONS');?>" TYPE="SUBMIT" class="btn-default jsp_tab_get_direction" title="<?php echo JText::_('GET_DIRECTIONS_DESCRIPTION');?>"/>
						  
						  </div>
                          
						  
						  <div class="check_path">
                             <div class="walk_path"><p>Walk</p> <input type="checkbox" title="<?php echo JText::_('WALK_DESCRIPTION');?>" name="walk" id="walk" style="margin-left: 10px;"/> </div>
                             <div class="highway_path"><p>Avoid Highways</p><input type="checkbox" title="<?php echo JText::_('AVOID_HIGHWAYS_DESCRIPTION');?>" name="highways" id="highways" style="margin-left: 10px;"/></div>
                          </div>
						  <input type="hidden" id="sourceDetails" value="<?php echo $lat . ',' . $long; ?>"/>
						  </form>
						  
						  
						  
						  
						  
						  <div class="directions mCustomScrollbar" style="height: 276px;">
                           <div id="directions" style="display:none;">
                        
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
            <div class="map dir_map">
            	<div class="map_inner">
                	<!--<img src="images/map.jpg" alt="map">-->
                    <div class="img_map" id="img_map"></div>
                    
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
	
	
	 var tohereClicked = 1;
    var fromhereClicked;    
    
     function tohere()
    {
       
       document.getElementById('toLink').style.fontWeight = 'bold';
       document.getElementById('fromLink').style.fontWeight = 'normal';
        document.getElementById('startTxt').style.display = "inline";
       document.getElementById('endTxt').style.display = "none";
        document.getElementById('endTxtFld').style.display = "none";
        document.getElementById('startTxtFld').style.display = "inline";
        
        if(tohereClicked != 1){
        $j('#start').val('');
        $j('#endaddress').val('');
        }
        tohereClicked = 1;
        fromhereClicked = 0;
        
   }
                       
                        function fromhere()
                        {
                           
                           document.getElementById('toLink').style.fontWeight = 'normal';
                           document.getElementById('fromLink').style.fontWeight = 'bold';
                            document.getElementById('startTxt').style.display = "none";
                            document.getElementById('endTxt').style.display = "inline";
                            document.getElementById('startTxtFld').style.display = "none";
                            document.getElementById('endTxtFld').style.display = "inline";
                            
                            if(fromhereClicked != 1){
                            $j('#start').val('');
                            $j('#endaddress').val('');
                            }
                            fromhereClicked = 1;
                            tohereClicked = 0;
                      }
					   
					   function getDirections(unit)
					   {
					   
					   var directionsService = new google.maps.DirectionsService();
	
						var firstLatLng = new google.maps.LatLng(<?php echo $lat . ',' . $long; ?>);
						var zoom = <?php echo $zoomlevel; ?>;
						var myOptions =
						{
							zoom: zoom,
							center: firstLatLng,
							mapTypeControl: false,
							mapTypeId: google.maps.MapTypeId.ROADMAP
						};

						map = new google.maps.Map(document.getElementById("img_map"),myOptions);
					   
					   
					   var directionsDisplay = new google.maps.DirectionsRenderer(
							{
								map: map,
								preserveViewport: true,
							}
							);
					   
                            // ==== set the start and end locations ====
                            var sourceDetails = document.getElementById("sourceDetails").value;
							
												
							//console.log(sourceDetails);
							
							var start = document.getElementById("start").value;
							
                            var end = document.getElementById("endaddress").value;
							
								
							
							document.getElementById("directions").innerHTML = "";
                            var from  = "";
                            var to = "";
                            if(start && start.length>0)
							{
                               to = sourceDetails;
                               from = start;
                            }
							else
							{
                               from = sourceDetails;
                               to = end;
                            }
							
							if(unit == 1)                            // condn for unitSystem in getDirection()
							{
								var sys = google.maps.UnitSystem.IMPERIAL;
							}
							else var sys = google.maps.UnitSystem.METRIC;
							
							var walking = document.getElementById("walk").checked;
							
							
							if(walking){
							
							var travel = google.maps.TravelMode.WALKING;
							
							}
							
							else{
							
							var travel = google.maps.TravelMode.DRIVING;
							}
							
							var highways = document.getElementById("highways").checked;
							
							if(highways){
							
							var showhighways = true;
							
							}
							else{
							var showhighways = false;
							}
							
								
							var sampleRequest = {
							  origin: from,
							  destination: to,
							  travelMode: travel,
							  avoidHighways: showhighways,
							  unitSystem: sys                               // METRIC/IMPRIAL
							}; 
							
													
							directionsService.route(sampleRequest, function(response, status)
							{
								
								//console.log(response);
								
								if (status == google.maps.DirectionsStatus.OK)
								{
								
									directionsDisplay.setDirections(response);
								}
								else if (status == google.maps.DirectionsStatus.NOT_FOUND)
								{
									document.getElementById("directions").innerHTML = "Please fill correct in Start Address. ";
								}
								else if(status == google.maps.DirectionsStatus.ZERO_RESULTS)
								{
									document.getElementById("directions").innerHTML = "Sorry, no Results found!. ";
								}
							}
							);
               
                           // document.getElementById('backToResult').style.display = "block";
                            document.getElementById('directions').style.display = "block";
                           // document.getElementById('side_bar').style.display = "none";
						   
						   directionsDisplay.setPanel(document.getElementById('directions'));
						   
                        }
						
						
						
		var mapOptions = {
          center: { lat: <?php echo $lat;?>, lng: <?php echo $long;?>},
          zoom: 50
        };
        var map = new google.maps.Map(document.getElementById("img_map"),mapOptions);
      
     // google.maps.event.addDomListener(window, 'load', initialize);
	
</script>

</body>
</html>
