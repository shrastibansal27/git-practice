<?php 

/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.tooltip');

include JPATH_COMPONENT_ADMINISTRATOR.'/'.'helpers'.'/'.'helper.php';

$excelfile = JUri::root().'/'.'administrator'.'/'.'components'.'/'.'com_jsplocation'.'/'.'samplefiles'.'/'.'places.xls';

$locationexcelfile = JUri::root().'/'.'administrator'.'/'.'components'.'/'.'com_jsplocation'.'/'.'samplefiles'.'/'.'locations.xls';
$data=TemplatesHelper::parseXMLTemplateFile();
$pointer=pointerHelper::readImages();

$params = $this->params;

JHtml::_('behavior.framework', true);
JHTML::_('script','system/modal.js', false, true);
JHTML::_('stylesheet','system/modal.css', array(), true);
$document =& JFactory::getDocument();
$document->addScriptDeclaration("window.addEvent('domready', function() {
			$$('.hasTip').each(function(el) {
				var title = el.get('title');
				if (title) {
					var parts = title.split('::', 2);
					el.store('tip:title', parts[0]);
					el.store('tip:text', parts[1]);
				}
			});
			var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false});
		});
		window.addEvent('domready', function() {

			SqueezeBox.initialize({});
			SqueezeBox.assign($$('a.modal'), {
				parse: 'rel'
			});
		});
");

$document->addScript(JURI::base()."components/com_jsplocation/js/jsplocation.js");
$document->addScript(JURI::base()."components/com_jsplocation/js/jscolor.js");
$document->addCustomTag('<script language="javascript" type="text/javascript" src="components/com_jsplocation/js/configuration.js"></script>');   

$livepath=JURI::root();	
$zoom_level		=($params['lat_ovr_conf']=="" && $params['long_ovr_conf']=="") ? $zoom_level = "1" : $zoom_level = "14";
$lat			=($params['lat_ovr_conf']=="") 		? $lat="48" 	: 	$lat = $params['lat_ovr_conf'];
$long			=($params['long_ovr_conf']=="") 	? $long="14" 	: 	$long = $params['long_ovr_conf'];


?>
 <h3><?php echo JText::_('CONFIGURATION');?></h3>
<form action="index.php?option=com_jsplocation" method="post" name="adminForm" onsubmit="return submitbutton();" enctype="multipart/form-data" id="adminForm" class="form-validate">
<ul class="nav nav-tabs">
   <li class="active"><a href="#googlemap" data-toggle="tab"><?php echo JText::_('MAP_TAB'); ?></a></li>
  <li class=""><a href="#displayfields" data-toggle="tab"><?php echo JText::_('DISPLAY_DEFAULT_FIELDS'); ?></a></li>
  <li class=""><a href="#searchoptions" data-toggle="tab"><?php echo JText::_('SEARCH_PARAMETERS'); ?></a></li>
  <li class=""><a href="#templatesettings" data-toggle="tab"><?php echo JText::_('TEMPLATE_SETTINGS'); ?></a></li>
  <li class=""><a href="#mappointer" data-toggle="tab"><?php echo JText::_('POINTER_SETTINGS'); ?></a></li>
   <li class=""><a href="#importdata" data-toggle="tab"><?php echo JText::_('IMPORT_LOCATIONS'); ?></a></li>
  
 </ul>
<div class="tab-content">
<div class="tab-pane active" id="googlemap">
   <fieldset class="adminform">
	<table class="table table-striped">
    <tr style="display:none;">
		<td class="paramlist_key">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('MAP_TITLE'); ?>">
					<?php echo JText::_('MAP_TITLE'); ?>
				</label>
			</span>		
		</td>
		<td class="paramlist_value">
			<input type="text" name="maptitle" id="maptitle" value="<?php echo $params['maptitle']; ?>" size="100" class="inputbox"/>
		</td>
		<td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('MAP_TITLE'); ?>">
		
				</label>
			</span>		
		</td>
		
        <td align="right"></td>
	</tr>
	
	<tr id="paramlist_url" nowrap="nowrap">
		<td class="paramlist_key">
		<span class="editlinktip hasTip" title="<?php echo JText::_('SELECT_MAP_TYPE_DESC'); ?>">
			<?php echo JText::_('SELECT_MAP_TYPE'); ?>
		</span>
		</td>
		<td class="paramlist_value">
              <fieldset id="jform_home" class="radio btn-group">
				 <input onclick="switchmap()" type="radio" name="map_type" value="0" <?php echo ($params['map_type']== '0') ? 'checked="checked"' : ""; ?> id="map_type0" /><label class="btn" for="map_type0"><?php echo JText::_('GOOGLE_MAP'); ?></label>
				<input onclick="switchmap()" type="radio" name="map_type" value="1" <?php echo ($params['map_type']== '1') ? 'checked="checked"' : ""; ?> id="map_type1" /><label class="btn" for="map_type1"><?php echo JText::_('BING_MAP'); ?></label>
				</fieldset>
		</td>
		<td></td>
		<td></td>
	</tr>
	
	<tr id="google_tr">
	  <td class="paramlist_key" >
	      <span class="editlinktip hasTip" title="<?php echo JText::_('GOOGLE_MAP_KEY'); ?>" id="google_keylabel" >
		     <?php echo JText::_('GOOGLE_MAP_KEY'); ?>
		  </span>
	   </td>
	   <td class="paramlist_value" >
	      <input name="google_key" id = "google_key" type="text" value="<?php echo $params['GoogleMap_key']; ?>"  size="20" />&nbsp;&nbsp;<a href="https://console.developers.google.com/apis/credentials" target="_blank">Generate Google Map API Key</a>
	   </td>
	   <td></td>
	   <td></td>
	</tr>
	<tr id="bing_tr">
	<td class="paramlist_key" >
	      <span class="editlinktip hasTip" title="<?php echo JText::_('BING_MAP_KEY'); ?>" id="bing_keylabel" >
		     <?php echo JText::_('BING_MAP_KEY'); ?>
		  </span>
	   </td>
	   <td class="paramlist_value" >
	      <input name="bing_key" id = "bing_key" type="text" value="<?php echo $params['BingMap_key']; ?>"  size="20" />
		  &nbsp;&nbsp;<a href="https://www.bingmapsportal.com/" target="_blank">Generate Bing Map API Key</a>
	   </td>
	   <td></td>
	   <td></td>
	</tr>
	<tr>
		<td class="paramlist_key">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('LOAD_JQUERY_DESC'); ?>">
					<?php echo JText::_('LOAD_JQUERY'); ?>
				</label>
			</span>		
		</td>
		<td class="paramlist_value">
			<select name="jquery" id="jquery">
				<option value="Auto" <?php echo ($params['jquery']== 'Auto')?"selected":''; ?>><?php echo JText::_('Auto'); ?></option>
				<option value="Yes" <?php echo ($params['jquery']== 'Yes')?"selected":''; ?>><?php echo JText::_('Yes'); ?></option>
				<option value="No" <?php echo ($params['jquery']== 'No')?"selected":''; ?>><?php echo JText::_('No'); ?></option>
			</select>
		</td>
		<td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('WIDTH_DESCRIPTION'); ?>">

				</label>
			</span>		
		</td>	
      	<td></td>		
	</tr>
	<tr>
		<td class="paramlist_key">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('HEIGHT_DESCRIPTION'); ?>">
					<?php echo JText::_('HEIGHT'); ?>
				</label>
			</span>		
		</td>
		<td class="paramlist_value">
			<input name="height" type="text" value="<?php echo $params['height']; ?>" size="20" />
		</td>
		
		<td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('HEIGHT_DESCRIPTION'); ?>">

				</label>
			</span>		
		</td>
        <td rowspan="4">
		
        <div id="show_map" style="display:none;position:relative; left:-58px;">
	
        <div style="float:right; width:16px;">
	     	    
            <span class="editlinktip">
        	<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('LAT_LONG_MAP_DESC'); ?>"></label>
       
        	</span>
            </div>
			 
       <?php $lang_code_data = $this->map_lang_code;?>
       <script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false&libraries=places&key=<?php echo $params['GoogleMap_key'];?>&language=<?php echo $lang_code_data;?>"></script>
		<script type="text/javascript">
		
		
		function switchmap() {
         //var mapTypeGoogle = '';
		//var mapTypeBing = '';
		 var mapTypeGoogle = document.getElementById('map_type0').checked;
		 //var map_type = document.getElementById('map_type').value;
         var mapTypeBing = document.getElementById('map_type1').checked;
		 var abc = <?php echo($params['map_type']); ?>;
		
		 if( mapTypeGoogle == true ) 	// if selected map is google 
			{   document.getElementById("branch_urllabel").style.display='block';
			    document.getElementById("branch_url").style.display='block';
			    //document.getElementById("google_keylabel").style.display='block';
				//document.getElementById("google_key").style.display = 'block';
				//document.getElementById("bing_keylabel").style.display='none';
			    //document.getElementById("bing_key").style.display = 'none';
		        document.getElementById("mapCanvas").style.display = 'block';
				document.getElementById("myMap").style.display = 'none';
				document.getElementById("google_tr").style.display = 'table-row';
				document.getElementById("bing_tr").style.display = 'none';
				
			}
			
		else if( mapTypeBing == true ) 	// if selected map is bing
			{  document.getElementById("branch_urllabel").style.display='none';
			    document.getElementById("branch_url").style.display='none';
			    //document.getElementById("bing_keylabel").style.display='block';
			    //document.getElementById("bing_key").style.display = 'block';
				//document.getElementById("google_keylabel").style.display='none';
				//document.getElementById("google_key").style.display = 'none';
				document.getElementById("mapCanvas").style.display = 'none';
				document.getElementById("myMap").style.display = 'block';
				document.getElementById("google_tr").style.display = 'none';
				document.getElementById("bing_tr").style.display = 'table-row';
			}
		
		}
		
        var geocoder = new google.maps.Geocoder();
       
        function geocodePosition(pos) {
          geocoder.geocode({
            latLng: pos
          }, function(responses) {
            if (responses && responses.length > 0) {
              updateMarkerAddress(responses[0].formatted_address);
            } else {
              updateMarkerAddress('Cannot determine address at this location.');
            }
          });
        }
        
        function updateMarkerStatus(str) {
          document.getElementById('markerStatus').innerHTML = str;
        }
        
        function updateMarkerPosition(latLng) {
		  document.getElementById('info_lat').value = latLng.lat();
		  document.getElementById('info_lng').value = latLng.lng();
		  
        }
        
        function updateMarkerAddress(str) {
          document.getElementById('address').innerHTML = str;
        }
        
        function initialize() 
		{
          var latLng = new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $long; ?>);
          var map = new google.maps.Map(document.getElementById('mapCanvas'), 
		  {
		
            zoom: <?php echo $zoom_level; ?>,
            center: latLng,
			disableDefaultUI: true,
			zoomControl: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
          });
		  
		  
		  var image = '<?php echo $livepath; ?>components/com_jsplocation/images/locator.png';
          var marker = new google.maps.Marker
		  ({
           position: latLng,
           title: 'Drag and drop marker to get latitude and longitude',
           map: map,
		   icon: image,
            draggable: true
          });
          
          // Update current position info.
           updateMarkerPosition(latLng);
           geocodePosition(latLng);
          
          // Add dragging event listeners.
          google.maps.event.addListener(marker, 'dragstart', function() {
            updateMarkerAddress('Dragging...');
          });
          
          google.maps.event.addListener(marker, 'drag', function() {
            updateMarkerStatus('Dragging...');
            updateMarkerPosition(marker.getPosition());
          });
          
          google.maps.event.addListener(marker, 'dragend', function() 
		  {
            updateMarkerStatus('Drag ended');
            geocodePosition(marker.getPosition());
			
          });
        
        }
		
        </script>
			 <div id="mapCanvas" style="display:none;"></div>
		
		 <div id='myMap' style="display:none; position:relative; width:280px; height:280px; float: right;  border: 3px solid #D8D8D8;bottom:-100px;"></div> 
         
       	
       
		 
          <div id="infoPanel">
            <div id="markerStatus" style="display:none;"><i>Click and drag the marker.</i></div>
            <div id="address" style="display:none;"></div>
          </div>
        </div>
	
        </td>			
	</tr>
	
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	
		<html>
   <head>
    
      <title>Pushpin attach drag event</title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      <script type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=7.0"></script>
      <script type="text/javascript">
	
      var map = null;

      function getMap()
      {
	    //AqxlyhUl3yFEeZoJlzY5YExqlSfD84cvdORfC8J6w7eNqZrcRum3vy-SrDuTOsVw
        map = new Microsoft.Maps.Map(document.getElementById('myMap'), {credentials: '<?php  echo $params['BingMap_key'];  ?>',showMapTypeSelector:false});
        
		 var pushpinOptions =  {icon:'<?php echo $livepath; ?>components/com_jsplocation/images/locator.png', width: 30, height: 30,draggable:true}; 
         var pushpin= new Microsoft.Maps.Pushpin(map.getCenter(), pushpinOptions); 
		 pushpin.setLocation(new Microsoft.Maps.Location(<?php echo $lat; ?>, <?php echo $long; ?>)); 
         var pushpindrag= Microsoft.Maps.Events.addHandler(pushpin, 'drag', onDragDetails);  
	     map.setView( {center: new Microsoft.Maps.Location(<?php echo $lat;?>, <?php echo $long; ?>), zoom: 6}); 
         map.entities.push(pushpin); 
		 var ptrtype = '<?php echo($params['pointertype']); ?>';
		 if(ptrtype=='Yes')
		   { document.getElementById("pointeroptions").style.display = "none";
		     document.getElementById("pointeroptions2").style.display = "none";
		     document.getElementById("pointer_delete_btn").style.display = "none";
		     document.getElementById("custom_pointer_list").style.display = "none";
		     document.getElementById("pointer_upload_block").style.display = "none";
		   }
		   else
		    { document.getElementById("pointeroptions").style.display = "none";
		       document.getElementById("pointeroptions2").style.display = "none";
		       document.getElementById("pointer_delete_btn").style.display = "";
		       document.getElementById("custom_pointer_list").style.display = "";
		       document.getElementById("pointer_upload_block").style.display = "";
			}
		 
		 var mapType = <?php echo($params['map_type']); ?>;//getting the map_type value from database
		if(mapType==1)
		 {    document.getElementById("branch_urllabel").style.display='none';
			    document.getElementById("branch_url").style.display='none';
		  //document.getElementById("bing_keylabel").style.display='';
		   //     document.getElementById("bing_key").style.display = '';
			//	 document.getElementById("google_keylabel").style.display='none';
		   //     document.getElementById("google_key").style.display = 'none';
		 document.getElementById("myMap").style.display = 'block';
		 document.getElementById("mapCanvas").style.display = 'none';
		 document.getElementById("bing_tr").style.display = 'table-row';
		 document.getElementById("google_tr").style.display = 'none';
		}
		else if(mapType==0)
		 {   document.getElementById("branch_urllabel").style.display='block';
			    document.getElementById("branch_url").style.display='block';
		  //document.getElementById("google_keylabel").style.display='';
		   //     document.getElementById("google_key").style.display = '';
			//	 document.getElementById("bing_keylabel").style.display='none';
		     //   document.getElementById("bing_key").style.display = 'none';
		  document.getElementById("mapCanvas").style.display = 'block';
		  document.getElementById("myMap").style.display = 'none';
		  document.getElementById("bing_tr").style.display = 'none';
		 document.getElementById("google_tr").style.display = 'table-row';
		  
		 }
		}
	
	  
     
      function attachPushpinDragEvent()
      {
        var pushpinOptions = {draggable:true}; 
		
        var pushpin= new Microsoft.Maps.Pushpin(map.getCenter(), pushpinOptions); 
		
       var pushpindrag= Microsoft.Maps.Events.addHandler(pushpin, 'drag', onDragDetails);  
       map.entities.push(pushpin); 
      // alert('drag newly added pushpin to raise event');
      }
      
      onDragDetails = function (e) 
      {
       //console.log(e.entity.getLocation() ); 
	   var location= e.entity.getLocation();
	  // alert(location.latitude);
	    document.getElementById('info_lat').value = location.latitude;
		  document.getElementById('info_lng').value = location.longitude;
      
	 
	 }        
      
    </script>
	 
          
      </head>
 <body onload="getMap();">

       </div>
       <div>
         
   </body>
</html>
	
	<tr>
		<td class="paramlist_key">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('ZOOM_LEVEL_DESCRIPTION'); ?>">
					<?php echo JText::_('ZOOM_LEVEL'); ?>
				</label>
			</span>		
		</td>
		<td class="paramlist_value">
			<input id="zoomlevel" name="zoomlevel" type="text" value="<?php echo $params['zoomlevel']; ?>" size="20" />
		</td>
		<td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('ZOOM_LEVEL_DESCRIPTION'); ?>">

				</label>
			</span>		
		</td>			
	</tr>
	    <tr>
		<td class="paramlist_key" nowrap="nowrap">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('DEFAULT_MAP_LOCATION_DESCRIPTION'); ?>">
					<?php echo JText::_('DEFAULT_MAP_LOCATION'); ?>
				</label>
			</span>		
		</td>
		<td class="paramlist_value">
			<?php echo $this->list['branch']; ?>
		</td>
		<td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('DEFAULT_MAP_LOCATION_DESCRIPTION'); ?>">
               </label>
			</span>		
		</td>			
	</tr>
    
    <tr id="Loclat_ovr">
		<td class="paramlist_key" nowrap="nowrap">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('LATITUDE_OVERRIDE_CONF_DESCRIPTION'); ?>">
					<?php echo JText::_('LATITUDE_OVERRIDE_CONF'); ?>
				</label>
			</span>		
		</td>
		<td class="paramlist_value">
			<input name="lat_ovr_conf" onkeypress="return isNumberKey(event)" type="text" value="<?php echo $params['lat_ovr_conf']; ?>" size="50" id="info_lat"/>
		</td>
		<td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('LATITUDE_OVERRIDE_CONF_DESCRIPTION'); ?>">

				</label>
			</span>		
		</td>			
	</tr>    
        
       <tr>
	<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('DISPLAY_LANGUAGE_FIELDS_DESCRIPTION'); ?>">
			<?php echo JText::_('DISPLAY_LANGUAGE_FIELDS'); ?>
		</span>
		</td>
               <td class="paramlist_value">
                    <select name="language_local" id="language_local" style="width:150px">
                          <option value="Select Language" <?php echo ($params['language_local']== 'Select Language')?"selected":''; ?>title="<?php echo JText::_('POINTERTYPE_DYNAMIC_DESCRIPTION'); ?>"><?php echo JText::_('Select Language'); ?></option>   
                                <?php foreach($this->map_lang as $map_lang){ ?>
                               <option value="<?php echo $map_lang->map_language; ?>" <?php echo ($params['language_local']== $map_lang->map_language)?"selected":''; ?>><?php echo JText::_($map_lang->map_language); ?></option></option>
                                <?php }?>
			</select>
		</td>
	</tr> 
        
        
    
    <tr id="Loclong_ovr">
		<td class="paramlist_key" nowrap="nowrap">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('LONGITUDE_OVERRIDE_CONF_DESCRIPTION'); ?>">
					<?php echo JText::_('LONGITUDE_OVERRIDE_CONF'); ?>
				</label>
			</span>		
		</td>
		<td class="paramlist_value">
			<input name="long_ovr_conf" onkeypress="return isNumberKey(event)" type="text" value="<?php echo $params['long_ovr_conf']; ?>" size="50" id="info_lng"/>
		</td>
		<td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('LONGITUDE_OVERRIDE_CONF_DESCRIPTION'); ?>">

				</label>
			</span>		
		</td>			
	</tr>
	
	<tr id="loc_limit">
		<td class="paramlist_key">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('LOCATION_LIMIT_DESC'); ?>">
					<?php echo JText::_('LOCATION_LIMIT'); ?>
				</label>
			</span>		
		</td>
		<td class="paramlist_value">
			<input type="text" onkeypress="return isNumberKey(event)" name="page_limit" id="page_limit" value="<?php echo $params['page_limit']; ?>"/><br/>
		</td>
		<td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('LOCATION_LIMIT_DESC'); ?>">
				</label>
			</span>		
		</td>
	</tr>
	
	<tr style="display:none;" id="paramlist_url" nowrap="nowrap">
		<td class="paramlist_key">
		<span class="editlinktip hasTip" title="<?php echo JText::_('BRANCH_LOCATION_URL_TYPE_DESCRIPTION'); ?>" style="display:none;" id="branch_urllabel">
			<?php echo JText::_('BRANCH_LOCATION_URL_TYPE'); ?>
		</span>
		</td>
		<td class="paramlist_value">
              <fieldset id="branch_url" class="radio btn-group" style = "display:none;" >
				<input type="radio" name="branch_url" value="Yes" <?php echo ($params['branch_url']== 'Yes') ? 'checked="checked"' : ""; ?> id="branch_url1" /><label class="btn" for="branch_url1"><?php echo JText::_('AJAX_BASED_LOCATIONS'); ?></label>
				<input type="radio" name="branch_url" value="No" <?php echo ($params['branch_url']== 'No') ? 'checked="checked"' : ""; ?> id="branch_url0" /><label class="btn" for="branch_url0"><?php echo JText::_('UNIQUE_URL_LOCATIONS'); ?></label>
				</fieldset>
		</td>
	</tr>
    <tr style="display:none;">
		<td class="paramlist_key">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('ZIP_CODE_MIN_VALUE'); ?>">
					<?php echo JText::_('ZIP_CODE_MIN_VALUE'); ?>
				</label>
			</span>		
		</td>
		<td class="paramlist_value">
			<input type="text" name="min_zip" id="min_zip" value="<?php echo $params['min_zip']; ?>"/><br/>
		</td>
		<td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('ZIP_CODE_MIN_VALUE'); ?>">
	
				</label>
			</span>		
		</td>
	</tr>
	<tr style="display:none;">
		<td class="paramlist_key">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('ZIP_CODE_MAX_VALUE'); ?>">
					<?php echo JText::_('ZIP_CODE_MAX_VALUE'); ?>
				</label>
			</span>		
		</td>
		<td class="paramlist_value">
			<input type="text" name="max_zip" id="max_zip" value="<?php echo $params['max_zip']; ?>"/><br/>
		</td>
		<td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('ZIP_CODE_MAX_VALUE'); ?>">
	
				</label>
			</span>		
		</td>
	</tr>
	</table>
</fieldset>
  </div>
<div class="tab-pane" id="displayfields">
   <fieldset class="uploadform">
	<table class="table table-striped">
     <tr style="display:none;">
		<td class="paramlist_key">
		<span class="editlinktip hasTip" title="<?php echo JText::_('DISPLAY_MAP_TITLE'); ?>">
			<?php echo JText::_('DISPLAY_MAP_TITLE'); ?>
		</span>
		</td>
        	<td class="paramlist_value">
              <fieldset id="jform_home" class="radio btn-group">
				<input type="radio" name="displaytitle" value="Yes" <?php echo ($params['displaytitle']== 'Yes') ? 'checked="checked"' : ""; ?> id="displaytitle1" /><label class="btn" for="displaytitle1"><?php echo JText::_('Yes'); ?></label>
				<input type="radio" name="displaytitle" value="No" <?php echo ($params['displaytitle']== 'No') ? 'checked="checked"' : ""; ?> id="displaytitle0" /><label class="btn" for="displaytitle0">No</label>
				</fieldset>
               
		</td>	
	</tr>
     <tr style="display:none;"> <!-- Used to enable disable directions & routes -->
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('DISPLAY_DIRECTIONS'); ?>">
			<?php echo JText::_('DISPLAY_DIRECTIONS'); ?>
		</span>
		</td>
		<td class="paramlist_value">
              <fieldset id="jform_home" class="radio btn-group">
				<input type="radio" name="directions" value="Yes" <?php echo ($params['directions']== 'Yes') ? 'checked="checked"' : ""; ?> id="directions1" /><label class="btn" for="directions1">Yes</label>
				<input type="radio" name="directions" value="No" <?php echo ($params['directions']== 'No') ? 'checked="checked"' : ""; ?> id="directions0" /><label class="btn" for="directions0">No</label>
				</fieldset>
               
		</td>
		
	</tr>
	
	<tr id="search_params_direction">      <!-- GOOGLE DIRECTION KEY -->
        <td class="paramlist_key">
            <span class="editlinktip">
                <label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('GOOGLE_DIRECTION_KEY'); ?>">
                    <?php echo JText::_('GOOGLE_DIRECTION_KEY_DESC'); ?>
                </label>
            </span>        
        </td>
        <td class="paramlist_value">
          <input name="google_dir_key" id = "google_dir_key" type="text" value="<?php echo $params['GoogleMap_DIR_key']; ?>"  size="20" />&nbsp;&nbsp;<a href="https://console.developers.google.com/apis/api/directions_backend/overview" target="_blank">Generate Google Map Direction API Key</a>
       </td>    
    </tr>
	
	<tr id="search_params_direction">      <!-- DIRECTION_RANGE -->
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('DIRECTION_RANGE_DESCRIPTION'); ?>">
			<?php echo JText::_('DIRECTION_RANGE'); ?>
		</span>
		</td>
		<td class="paramlist_value">
			<fieldset id="jform_home" class="radio btn-group">	        	
				<input type="radio" name="direction_range" value="Yes" <?php echo ($params['direction_range']== 'Yes') ? 'checked="checked"' : ""; ?> id="direction_range_miles"/><label class="btn" for="direction_range_miles"><?php echo JText::_('MILES'); ?></label>
            	<input type="radio" name="direction_range" value="No" <?php echo ($params['direction_range']== 'No') ? 'checked="checked"' : ""; ?> id="direction_range_kms"/><label class="btn" for="direction_range_kms"><?php echo JText::_('KMS'); ?></label>
			</fieldset>
		</td>	
	</tr>
	
    <tr style="display:none;"> <!-- Used to enable disable left side branch list -->
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('DISPLAY_BRANCH_LIST_DESCRIPTION'); ?>">
			<?php echo JText::_('DISPLAY_BRANCH_LIST'); ?>
		</span>
		</td>
		<td class="paramlist_value">
              <fieldset id="jform_home" class="radio btn-group">
				<input type="radio" name="branchlist" value="Yes" <?php echo ($params['branchlist']== 'Yes') ? 'checked="checked"' : ""; ?> id="branchlist1" /><label class="btn" for="branchlist1">Yes</label>
				<input type="radio" name="branchlist" value="No" <?php echo ($params['branchlist']== 'No') ? 'checked="checked"' : ""; ?> id="branchlist0" /><label class="btn" for="branchlist0">No</label>
				</fieldset>
               
		</td>		
	</tr> 
	<tr>
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('DISPLAY_COUNTRY_DESCRIPTION'); ?>">
			<?php echo JText::_('DISPLAY_COUNTRY'); ?>
		</span>
		</td>
		<td class="paramlist_value">
              <fieldset id="jform_home" class="radio btn-group">
				<input type="radio" name="country" value="Yes" <?php echo ($params['country']== 'Yes') ? 'checked="checked"' : ""; ?> id="country1" /><label class="btn" for="country1">Yes</label>
				<input type="radio" name="country" value="No" <?php echo ($params['country']== 'No') ? 'checked="checked"' : ""; ?> id="country0" /><label class="btn" for="country0">No</label>
				</fieldset>
               
		</td>				
	</tr>	
	<tr>
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('DISPLAY_STATE_DESCRIPTION'); ?>">
			<?php echo JText::_('DISPLAY_STATE'); ?>
		</span>
		</td>
		<td class="paramlist_value">
              <fieldset id="jform_home" class="radio btn-group">
				<input type="radio" name="state" value="Yes" <?php echo ($params['state']== 'Yes') ? 'checked="checked"' : ""; ?> id="state1" /><label class="btn" for="state1">Yes</label>
				<input type="radio" name="state" value="No" <?php echo ($params['state']== 'No') ? 'checked="checked"' : ""; ?> id="state0" /><label class="btn" for="state0">No</label>
				</fieldset>
               
		</td>					
	</tr>	
	<tr>
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('DISPLAY_CITY_DESCRIPTION'); ?>">
			<?php echo JText::_('DISPLAY_CITY'); ?>
		</span>
		</td>
		<td class="paramlist_value">
              <fieldset id="jform_home" class="radio btn-group">
				<input type="radio" name="city" value="Yes" <?php echo ($params['city']== 'Yes') ? 'checked="checked"' : ""; ?> id="city1" /><label class="btn" for="city1">Yes</label>
				<input type="radio" name="city" value="No" <?php echo ($params['city']== 'No') ? 'checked="checked"' : ""; ?> id="city0" /><label class="btn" for="city0">No</label>
				</fieldset>
               
		</td>		
	</tr>	
	<tr>
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('DISPLAY_AREA_DESCRIPTION'); ?>">
			<?php echo JText::_('DISPLAY_AREA'); ?>
		</span>
		</td>
		<td class="paramlist_value">
              <fieldset id="jform_home" class="radio btn-group">
				<input type="radio" name="area" value="Yes" <?php echo ($params['area']== 'Yes') ? 'checked="checked"' : ""; ?> id="area1" /><label class="btn" for="area1">Yes</label>
				<input type="radio" name="area" value="No" <?php echo ($params['area']== 'No') ? 'checked="checked"' : ""; ?> id="area0" /><label class="btn" for="area0">No</label>
				</fieldset>
               
		</td>
	</tr>
	<tr style="display:none;">
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('SHOW_POINTER_TYPE_DESC'); ?>">
			<?php echo JText::_('SHOW_POINTER_TYPE'); ?>
		</span>
		</td>
		<td class="paramlist_value">
			<fieldset id="jform_home" class="radio btn-group">
				<input type="radio" name="show_pointer_type" value="Yes" <?php echo ($params['show_pointer_type']== 'Yes') ? 'checked="checked"' : ""; ?> id="show_pointer_type_yes"/><label class="btn" for="show_pointer_type_yes">Yes</label>
				<input type="radio" name="show_pointer_type" value="No" <?php echo ($params['show_pointer_type']== 'No') ? 'checked="checked"' : ""; ?> id="show_pointer_type_no"/><label class="btn" for="show_pointer_type_no">No</label>
			</fieldset>	
		</td>			
	</tr>
	</table>
</fieldset>
</div>

<div class="tab-pane" id="searchoptions">
   <fieldset class="uploadform">
	<table class="table table-striped">
    <tr>
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('DISPLAY_SEARCH_FIELDS_DESCRIPTION'); ?>">
			<?php echo JText::_('DISPLAY_SEARCH_FIELDS'); ?>
		</span>
		</td>
		<td class="paramlist_value">
            <select name="search" id="search" style="width:150px" onchange="javascript: hideSearchParams(this);">
				<option value="Yes" <?php echo ($params['search']== 'Yes')?"selected":''; ?>><?php echo JText::_('Yes'); ?></option>
				<option value="No" <?php echo ($params['search']== 'No')?"selected":''; ?>><?php echo JText::_('No'); ?></option>
			</select>
		</td>
	</tr>
	
	<tr id="search_params_zip">
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('Display search box on frontend'); ?>">
			<?php echo JText::_('Show Search Box'); ?>
		</span>
		</td>
		<td class="paramlist_value">
			<fieldset id="jform_home" class="radio btn-group">
				<input type="radio" name="zip_search" value="Yes" <?php echo ($params['zip_search']== 'Yes') ? 'checked="checked"' : ""; ?> id="zip_search_yes"/><label class="btn" for="zip_search_yes">Yes</label>
				<input type="radio" name="zip_search" value="No" <?php echo ($params['zip_search']== 'No') ? 'checked="checked"' : ""; ?> id="zip_search_no"/><label class="btn" for="zip_search_no">No</label>
			</fieldset>	
		</td>
	</tr>
	<tr style='display:none;' id="search_params_range">
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('RADIUS_RANGE_DESCRIPTION'); ?>">
			<?php echo JText::_('RADIUS_RANGE'); ?>
		</span>
		</td>
		<td class="paramlist_value">
			<fieldset id="jform_home" class="radio btn-group">
				<input type="radio" name="radius_range" value="Yes" <?php echo ($params['radius_range']== 'Yes') ? 'checked="checked"' : ""; ?> id="radius_range_yes"/><label class="btn" for="radius_range_yes"><?php echo JText::_('MILES'); ?></label>
            	<input type="radio" name="radius_range" value="No" <?php echo ($params['radius_range']== 'No') ? 'checked="checked"' : ""; ?> id="radius_range_no"/><label class="btn" for="radius_range_no"><?php echo JText::_('KMS'); ?></label>
			</fieldset>	
		</td>
	</tr style="display:none;">
      <tr id="search_params_category">
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('SHOW_CATEGORY_FIELD_DESCRIPTION'); ?>">
			<?php echo JText::_('SHOW_CATEGORY_FIELD'); ?>
		</span>
		</td>
		<td class="paramlist_value">
              <fieldset id="jform_home" class="radio btn-group">
				<input type="radio" name="category_search" value="Yes" <?php echo ($params['category_search']== 'Yes') ? 'checked="checked"' : ""; ?> id="category_search1" /><label class="btn" for="category_search1">Yes</label>
				<input type="radio" name="category_search" value="No" <?php echo ($params['category_search']== 'No') ? 'checked="checked"' : ""; ?> id="category_search0" /><label class="btn" for="category_search0">No</label>
				</fieldset>
               
		</td>					
	</tr>

    <tr style="display:none;" id="search_params_country">
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('SHOW_COUNTRY_FIELD_DESCRIPTION'); ?>">
			<?php echo JText::_('SHOW_COUNTRY_FIELD'); ?>
		</span>
		</td>
		<td class="paramlist_value">
              <fieldset id="jform_home" class="radio btn-group">
				<input type="radio" name="country_search" value="Yes" <?php echo ($params['country_search']== 'Yes') ? 'checked="checked"' : ""; ?> id="country_search1" /><label class="btn" for="country_search1">Yes</label>
				<input type="radio" name="country_search" value="No" <?php echo ($params['country_search']== 'No') ? 'checked="checked"' : ""; ?> id="country_search0" /><label class="btn" for="country_search0">No</label>
				</fieldset>
               
		</td>				
	</tr>
    <tr style="display:none;" id="search_params_state">
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('SHOW_STATE_FIELD_DESCRIPTION'); ?>">
			<?php echo JText::_('SHOW_STATE_FIELD'); ?>
		</span>
		</td>
		<td class="paramlist_value">
              <fieldset id="jform_home" class="radio btn-group">
				<input type="radio" name="state_search" value="Yes" <?php echo ($params['state_search']== 'Yes') ? 'checked="checked"' : ""; ?> id="state_search1" /><label class="btn" for="state_search1">Yes</label>
				<input type="radio" name="state_search" value="No" <?php echo ($params['state_search']== 'No') ? 'checked="checked"' : ""; ?> id="state_search0" /><label class="btn" for="state_search0">No</label>
				</fieldset>
               
		</td>		
	</tr>
    <tr style="display:none;" id="search_params_city">
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('SHOW_CITY_FIELD_DESCRIPTION'); ?>">
			<?php echo JText::_('SHOW_CITY_FIELD'); ?>
		</span>
		</td>
		<td class="paramlist_value">
              <fieldset id="jform_home" class="radio btn-group">
				<input type="radio" name="city_search" value="Yes" <?php echo ($params['city_search']== 'Yes') ? 'checked="checked"' : ""; ?> id="city_search1" /><label class="btn" for="city_search1">Yes</label>
				<input type="radio" name="city_search" value="No" <?php echo ($params['city_search']== 'No') ? 'checked="checked"' : ""; ?> id="city_search0" /><label class="btn" for="city_search0">No</label>
				</fieldset>
               
		</td>		
	</tr>
    <tr style="display:none;" id="search_params_area">
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('SHOW_AREA_FIELD_DESCRIPTION'); ?>">
			<?php echo JText::_('SHOW_AREA_FIELD'); ?>
		</span>
		</td>
		<td class="paramlist_value">
              <fieldset id="jform_home" class="radio btn-group">
				<input type="radio" name="area_search" value="Yes" <?php echo ($params['area_search']== 'Yes') ? 'checked="checked"' : ""; ?> id="area_search1" /><label class="btn" for="area_search1">Yes</label>
				<input type="radio" name="area_search" value="No" <?php echo ($params['area_search']== 'No') ? 'checked="checked"' : ""; ?> id="area_search0" /><label class="btn" for="area_search0">No</label>
				</fieldset>
		</td>	
	</tr>
	
	<tr id="search_params_auto">
        <td class="paramlist_key" nowrap="nowrap">
        <span class="editlinktip hasTip" title="<?php echo JText::_('Display autocomplete address on frontend'); ?>">
            <?php echo JText::_('Google Autocomplete Address'); ?>
        </span>
        </td>
        <td class="paramlist_value">
            <fieldset id="jform_home" class="radio btn-group">
                <input type="radio" name="google_autocomplete_address" value="Yes" <?php echo ($params['google_autocomplete_address']== 'Yes') ? 'checked="checked"' : ""; ?> id="google_autocomplete_address1"/><label class="btn" for="google_autocomplete_address1">Yes</label>
                <input type="radio" name="google_autocomplete_address" value="No" <?php echo ($params['google_autocomplete_address']== 'No') ? 'checked="checked"' : ""; ?> id="google_autocomplete_address0"/><label class="btn" for="google_autocomplete_address0">No</label>
            </fieldset>    
        </td>
    </tr>
	
	
    <tr id="search_params_locateme">
	<td class="paramlist_key" nowrap="nowrap">
	<span class="editlinktip hasTip" title="<?php echo JText::_('DISPLAY_LOCATE_ME_DESC'); ?>">
	<?php echo JText::_('DISPLAY_LOCATE_ME'); ?>
	</span>
	</td>
	<td class="paramlist_value">
	<fieldset id="jform_home" class="radio btn-group">
	<input type="radio" name="locateme" value="Yes" <?php echo ($params['locateme']== 'Yes') ? 'checked="checked"' : ""; ?> id="locateme1" /><label class="btn" for="locateme1">Yes</label>
	<input type="radio" name="locateme" value="No" <?php echo ($params['locateme']== 'No') ? 'checked="checked"' : ""; ?> id="locateme0" /><label class="btn" for="locateme0">No</label>
	</fieldset>
	</td>				
	</tr>
	
	<tr id="search_params_locateme_range">
	<td class="paramlist_key" nowrap="nowrap">
	<span class="editlinktip hasTip" title="<?php echo JText::_('RADIUS_FOR_LOCATE_ME'); ?>">
	<?php echo JText::_('LOCATE_ME_RADIUS'); ?>
	</span>
	</td>
	<td class="paramlist_value">
	<?php echo $this->list['radius']; ?>
	</td>				
	</tr>	
	 	    <tr id="search_radius_description">
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('SEARCH_RADIUS_DESCRIPTION'); ?>">
			<?php echo JText::_('SEARCH_RADIUS'); ?>
		</span>
		</td>
		<td class="paramlist_value">
            <select name="searchradiusloc" id="searchradiusloc" style="width:220px" onchange="javascript: SearchRadiusField(this.value);">
				<option value="Yes" <?php echo ($params['search_radius_status']== 'Yes')?"selected":''; ?>><?php echo JText::_('Yes'); ?></option>
				<option value="No" <?php echo ($params['search_radius_status']== 'No')?"selected":''; ?>><?php echo JText::_('No'); ?></option>
			</select>
		</td>
	</tr>
	
	<tr id="search_radius_location">
	<td class="paramlist_key" nowrap="nowrap">
	<span class="editlinktip hasTip" title="<?php echo JText::_('RADIUS_FOR_SEARCH'); ?>">
	<?php echo JText::_('RADIUS_FOR_SEARCH_FIELD'); ?>
	</span>
	</td>
	<td class="paramlist_value">
	<?php echo $this->list['searchradius']; ?>
	</td>	
	</tr>
	
    </table>
</fieldset>
</div>

<div class="tab-pane" id="templatesettings">
   <fieldset class="uploadform">
	<table class="table table-striped" cellspacing="1">
		<thead>
			<tr>
				<th width="5"><?php echo JText::_( '#' ); ?></th>
				<th width="5"></th>					
				<th><?php echo JText::_('TEMPLATE_PREVIEW'); ?> </th>
				<th><?php echo JText::_('TEMPLATE_NAME'); ?></th>
				<th><?php echo JText::_('DESCRIPTION'); ?></th>				
			</tr>
		</thead>

		<tbody>
			<?php $tmp=0; $k=0;
				 foreach ($data as $item) {			
					if(isset($item->name)) 
						{ $tmp=$tmp+1; ?> 
						<tr class="<?php echo "row".$k; $k = 1 - $k;  ?>">	
							<td><?php echo $tmp; ?> </td>
							<td> 
								<input type="radio" name="template" value= "<?php echo $item->name; ?>" <?php echo ($params['template']== $item->name) ? "checked" : ""; ?>/>
							</td>
							<td>

								<span class="bold hasTip" title="<?php echo JText::_('Template')."::".JText::_('Click here to view template');?>">
		<a class="modal" title="Preview Template"  href="../components/com_jsplocation/views/<?php echo $item->name;?>/preview.jpg" rel="{handler: 'iframe', size: {x: 750, y: 470}}">							
									<img src="../components/com_jsplocation/views/<?php echo $item->name;?>/thumb.jpg" border="0"></img> 
								</a>
								</span>	
								
							</td>												
							<td><?php echo $item->name; ?></td> 						
						<?php } 
				  		if(isset($item->description)) { ?><td><?php echo $item->description; ?></td> 
			  			</tr> <?php } ?>
			<?php } ?>
		</tbody>
	</table>
</fieldset>
</div>
<div class="tab-pane" id="mappointer">

<fieldset class="uploadform">
<table class="table table-striped" cellspacing="1">
  <tr id="pointer_params_pointertype">
    <td class="paramlist_key"><span class="editlinktip hasTip" title="<?php echo JText::_('Select the type of pointer to be displayed on the map'); ?>"> <?php echo JText::_('POINTERTYPE'); ?> </span> </td>
    <td class="paramlist_value">
		<select name="pointertype" id="pointertype1" onchange="return callonload();" >
			<option value="Yes" <?php echo ($params['pointertype']== 'Yes')?"selected":''; ?> title="<?php echo JText::_('POINTERTYPE_DYNAMIC_DESCRIPTION'); ?>"><?php echo JText::_('POINTERTYPE_DYNAMIC'); ?></option>
			<option value="No" <?php echo ($params['pointertype']== 'No')?"selected":''; ?> title="<?php echo JText::_('POINTERTYPE_CUSTOMIZED_DESCRIPTION'); ?>"><?php echo JText::_('POINTERTYPE_CUSTOMIZED'); ?></option>
		</select>
	</td>
  	</tr>
  <tr style="display:none;" id="pointeroptions">
    <td class="paramlist_key"><span class="editlinktip hasTip" title="<?php echo JText::_('FILLCOLOR_DESCRIPTION'); ?>">
      <label><?php echo JText::_('FILLCOLOR'); ?></label>
      </span> </td>
    <td title="<?php echo JText::_('FILLCOLOR_DESCRIPTION'); ?>"><input type="text" class="color" name="fillcolor" id="fillcolor" value="<?php echo $params['fillcolor']; ?>" size="100"/></td>
  </tr>
  <tr style="display:none;" id="pointeroptions2">
    <td class="paramlist_key" nowrap="nowrap"><span class="editlinktip hasTip" title="<?php echo JText::_('FONTSIZE_DESCRIPTION'); ?>">
      <label><?php echo JText::_('FONTSIZE'); ?></label>
      </span> </td>
    <td title="<?php echo JText::_('FONTSIZE_DESCRIPTION'); ?>"><input type="text"name="fontsize" id="fontsize" value="<?php echo $params['fontsize']; ?>" size="100"/></td>
  </tr>
</table>
</fieldset>
	<div id="pointer_delete_btn">
	<table>
		<tbody>			
			<tr>
			<button class="btn btn-small"  type="submit" name="btnDelImage"  onclick ="if (document.adminForm.boxchecked.value==0){alert('Please first make a selection from the list'); return false;}else{ return ImgDelete()}">
				<i class="icon-trash "> </i>
				<?php echo JText::_('DELETE_POINTERS'); ?>
			</button>
			</tr>					
		</tbody>
	</table>
	</div>
<fieldset class="uploadform">
<table class="table table-striped" cellspacing="1" id="custom_pointer_list">
	<thead>
		<tr>
			<th width="5"><?php echo JText::_( '#' ); ?></th>
			<th width="5">
				<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
			</th>
			<th><?php echo JText::_('POINTER_IMAGE'); ?> </th>
			<th><?php echo JText::_('POINTER_NAME'); ?></th>
		</tr>
	</thead>

	<tbody>
		<?php $tmp=0; $k=0;
		foreach ($pointer as $p)
		{   ; ?>
			<tr class="<?php echo "row".$k; $k = 1 - $k;  ?>">
			<td> <?php echo $tmp+1; ?></td>
			<td align="center">
				<?php echo JHtml::_('grid.id',$tmp,$p); ?>
			</td>
			<td> <img src="../images/jsplocationimages/jsplocationPointers/<?php echo $p;?>"></img></td>
			<td> <?php echo $p;?></td>
		</tr>
		<?php $tmp=$tmp+1; } ?>			
	</tbody> 
</table>
</fieldset>

<table id="pointer_upload_block">
	<tbody>			
		<tr> <!-- file upload form -->				
				<td align="center"> <label><?php echo JText::_('UPLOAD_IMAGE'); ?></label></td>
				<td><input type="file" name="txtImagepath" id="txtImagepath"></input></td>					
				<td><input class="btn btn-primary" type="submit" name="btnUploadImage" value="Upload" onclick ="return ImgUpload(this.value)"></input></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr> 					
	</tbody>
</table>
</div>

<div class="tab-pane" id="imagesettings" >
	<fieldset class="uploadform">
	<table class="table table-striped" cellspacing="1">
	  <tr>
		<td class="paramlist_key"><span class="editlinktip hasTip" title="<?php echo JText::_('DISPLAY_IMAGE_DESC'); ?>"> <?php echo JText::_('DISPLAY_IMAGE'); ?> </span> </td>
		<td class="paramlist_value">
			<select name="image_display" id="image_display_yes" onchange="return callonload2();" title="<?php echo JText::_('DISPLAY_IMAGE_DESC'); ?>">
				<option value="Yes" <?php echo ($params['image_display']== 'Yes')?"selected":''; ?> title="<?php echo JText::_('POINTERTYPE_DYNAMIC_DESCRIPTION'); ?>"><?php echo JText::_('Yes'); ?></option>
				<option value="No" <?php echo ($params['image_display']== 'No')?"selected":''; ?> title="<?php echo JText::_('POINTERTYPE_CUSTOMIZED_DESCRIPTION'); ?>"><?php echo JText::_('No'); ?></option>
			</select>
			</td>
	  </tr>
	  <tr id="default_image_opt1">
		<td class="paramlist_key" nowrap="nowrap"><span class="editlinktip">
		  <label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('DEFAULT_IMAGE_DESC'); ?>"> <?php echo JText::_('DEFAULT_IMAGE'); ?> </label>
		  </span> </td>
		<td class="paramlist_value"><?php echo $this->list['branch_image']; ?> </td>
	  </tr>
	  <tr id="branch_image_upload">
		<!-- file upload form -->
		<td align="center"><label><?php echo JText::_('UPLOAD_IMAGE'); ?></label></td>
		<td><input type="file" name="defaultImagepath" id="defaultImagepath"></input></td>
		<td><input class="btn btn-primary" type="submit" name="btnUploadImage" value="Upload" onclick ="return defaultLocImg(this.value)"></input></td>
	  </tr>
	  <tr id="default_image_opt2">
		<td colspan="3"><div id="imagetest"><!--<img src="../images/jsplocationimages/jsplocationImages/noimage.jpg" name="image_preview" id="image_preview" width = "206px" height="150px"></img>--></div></td>
	  </tr>
	</table>
	</fieldset>
</div>

<div class="tab-pane" id="importdata">
<fieldset class="importdata">

	<table class="table table-striped">
	
	  
	<!--  <tr id="default_image_opt1">
		<td class="paramlist_key">
		<span class="editlinktip hasTip" title="<?php echo JText::_('FILE_PATH_DES'); ?>"> <?php echo JText::_('FILE_PATH'); ?> </span>
		</td>
		<td> <input type="file" name="placespath" id="placespath"></input></td>
	  </tr>
	  
	  
	  <tr id="branch_image_upload">
	   <td class="paramlist_key">
	   <span class="editlinktip hasTip" title="<?php echo JText::_('IMPORT_DATA_DES'); ?>"> <?php echo JText::_('IMPORT_DATA'); ?></span>
	   </td>
	   <td class="paramlist_value">
		<input class="btn btn-info"  onclick='return importData(this.value);' type="submit" class="btn btn-info"  name="importdata" id="importdata">
	   </td>
	  </tr>
	  
	  <tr id="sample_file">
		<td class="paramlist_key">
		<span class="editlinktip hasTip" title="<?php echo JText::_('SAMPLE_FILE_DES'); ?>"> <?php echo JText::_('SAMPLE_FILE'); ?>
		</span> 
		</td>
	    <td class="paramlist_value">
			<a target="_blank" href="<?php echo $excelfile;?>">Excel Sample file</a>
		</td>
	  </tr>
	  
	   <tr>-->                    <!-- added by me-->
	   <!--<td class="paramlist_key" nowrap="nowrap">
	   <span class="editlinktip hasTip" title=" <?php echo JText::_('IMPORT_BRANCH_DES'); ?>"><?php echo JText::_('IMPORT_BRANCH'); ?>
	   </span>
	   </td>
	   <td class="paramlist_value">
		<select name="locationstatus" id="locationstatus" style="width:150px" onchange="branchstatus(this.value);">
			<option value="0" <?php echo($params['location_status']== '0')?"selected":''; ?>> <?php echo JText::_('NO'); ?></option>
			<option value="1" <?php echo ($params['location_status']== '1')?"selected":''; ?>><?php echo JText::_('YES'); ?></option>
		</select>
	   </td>
	   </tr>-->
		
	   <tr id="locationfilepath1">
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('LOCATION_FILE_PATH_DES'); ?>"> <?php echo JText::_('LOCATION_FILE_PATH'); ?> </span>
		</td>
		<td> <input type="file" name="branchpath" id="branchpath"></input></td>
	  </tr>
	  
	  
	   <tr id="locationdetails1">
		<td class="paramlist_key">
		<span class="editlinktip hasTip" title="<?php echo JText::_('IMPORT_BRANCH_LOCATION_DES'); ?>"> <?php echo JText::_('IMPORT_BRANCH_LOCATION'); ?></span>
		</td> 
		<td class="paramlist_value">
			<input class="btn btn-info"  onclick='return locationDetails(this.value);' type="submit" value="IMPORT" class="btn btn-info"  name="locationdetails" id="locationdetails">
		</td>
	   </tr>
	  
	   <tr id="branchlocationsamplefile">
		<td class="paramlist_key">
		<span class="editlinktip hasTip" title="<?php echo JText::_('BRANCH_LOCATION_SAMPLE_FILE_DES'); ?>"> <?php echo JText::_('BRANCH_LOCATION_SAMPLE_FILE'); ?></span>
		</td>
		<td class="paramlist_value">
			<a target="_blank" href="<?php echo $locationexcelfile;?>">Excel Sample file</a>
	   </td>
	   </tr>
	   <tr id="export">
		<td class="paramlist_key">
		<span class="editlinktip hasTip" title="<?php echo JText::_('EXPORT_BRANCH_LOCATION_DES'); ?>"> <?php echo JText::_('EXPORT_BRANCH_LOCATION'); ?></span>
		</td> 
		<td class="paramlist_value">
			<input class="btn btn-info"  onclick='return exportData(this.value);' type="submit" value="EXPORT" class="btn btn-info"  name="exportlocation" id="exportlocation">
		</td>
	   </tr>
	   

	</table>
	</fieldset>
</div>
</div>

<input type="hidden" name="option" value="com_jsplocation"/>
<input type="hidden" name="controller" value="configuration" />
<input type="hidden" id="task" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
</form>

<script type="text/javascript">
	hideSearchParams(document.getElementById('search'));
	SearchRadiusField(document.getElementById('searchradiusloc').value);
	hideLocOvrParams(document.getElementById('branch_id'));
	PicsParam(document.getElementById('branch_img_id'));	
</script>