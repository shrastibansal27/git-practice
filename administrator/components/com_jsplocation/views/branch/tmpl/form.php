<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: form.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.html.pane');
include JPATH_COMPONENT_ADMINISTRATOR.'/'.'helpers'.'/'.'helper.php';
JHtml::_('behavior.framework', true);

JHTML::_('script','system/modal.js', false, true);
JHTML::_('stylesheet','system/modal.css', array(), true);
 

$pointer=pointerHelper::readImages();


$infoarray = $this->infoarray;

$directoryPath = $infoarray['path'];
$branchname = $this->branchname;

$path = $directoryPath.$branchname;

if(file_exists($path)){
// Do Nothing
}
else{

$path = JPATH_SITE.'/'.$directoryPath.$branchname;
$path = str_replace('\\',"/",$path);	


}


$branchimages=pointerHelper::readBranchImages($path);


$document = JFactory::getDocument();
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
$document->addCustomTag('<script language="javascript" type="text/javascript" src="components/com_jsplocation/js/jsplocation.js"></script>');
$document->addCustomTag('<script language="javascript" type="text/javascript" src="components/com_jsplocation/js/branch.js"></script>');
//$document->addScript(JURI::base()."components/com_jsplocation/js/jsplocation.js");
$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/jsplocation.css");

$livepath=JURI::root();
$zoom_level		=($this->row->lat_ovr=="" && $this->row->long_ovr=="") ? $zoom_level = "1" : $zoom_level = "14";
$lat			=($this->row->lat_ovr=="") 	? $lat="48" 	: 	$lat = $this->row->lat_ovr;
$long			=($this->row->long_ovr=="") ? $long="14" : 	$long = $this->row->long_ovr;
$configParams   = $this->configParams;

$min_zip		= $configParams['min_zip'];
$max_zip		= $configParams['max_zip'];




	jimport('joomla.environment.browser');
    $doc = JFactory::getDocument();
    $browser = JBrowser::getInstance();
    $browserType = $browser->getBrowser();
    $browserVersion = $browser->getMajor();
    if(($browserType == 'msie') && ($browserVersion = 7))
    {
    	$document->addScript(JURI::base()."components/com_jsplocation/js/tabs.js");
    }
	if(($browserType == 'safari') && ($browserVersion = 3))
    {
    	$document->addScript(JURI::base()."components/com_jsplocation/js/tabs.js");
    }
?>
<form action="index.php?option=com_jsplocation" method="post" name="adminForm" id="adminForm" onsubmit="btnUploadImage.disabled = true;btnDeleteImage.disabled = true;return submitbutton();" class="form-validate" enctype="multipart/form-data">

		<!-- Begin Content -->

        
<ul class="nav nav-tabs">
  <li class="active"><a href="#basic-information" data-toggle="tab"><?php echo JText::_('BASIC_INFORMATION'); ?></a></li>
  <li><a href="#additional-information" data-toggle="tab"><?php echo JText::_('ADDITIONAL_INFORMATION'); ?></a></li>
  <li><a href="#custom-feilds" data-toggle="tab"><?php echo JText::_('CUSTOM_FEILDS'); ?></a></li>
  <li><a href="#location-images" data-toggle="tab"><?php echo JText::_('UPLOAD_LOCATION_IMAGES'); ?></a></li>
  <li><a href="#stored-videos" data-toggle="tab"><?php echo JText::_('MEDIA'); ?></a></li>
</ul>

<div class="tab-content">
      <div class="tab-pane active" id="basic-information">
	  <?php

	 
	if($this->row->id==''){
		?>
        <div align="left"><b><?php echo JText::_( 'LOCA_ADD_INFO' ); ?></b></div> 
        <?php
		}
?>
	<fieldset class="adminform">
		<table class="table table-striped">
		<tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'BRANCH_NAME' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'BRANCH_NAME' ); ?>:
				</label>
                </span>
				
				
				
			</td>
			<td class="paramlist_value"><input type="text" name="branch_name" value="<?php echo preg_replace('/[[:^print:]]/','',$this->row->branch_name); ?>" class="inputbox" size="50"></td>
            <td></td>
            <td></td>
		</tr>

        <tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'LOC_COUNTRY_DESC' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'COUNTRY' ); ?>:
				</label>
                </span>
			</td>
			<td><?php echo $this->list['country']; ?></td>
            <td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_(''); ?>">
					
				</label>
			</span>		
			</td>
            <td align="right" width="80%">
            
            </td>
		</tr>
        
        <tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'LOC_STATE_DESC' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'STATE' ); ?>:
				</label>
                </span>
			</td>
			<td><?php echo $this->list['state']; ?></td>
            <td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_(''); ?>">
					
				</label>
			</span>		
			</td>
            <td></td>
		</tr>
        
        <tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'LOC_CITY_DESC' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'CITY' ); ?>:
				</label>
                </span>
			</td>
			<td><?php echo $this->list['city']; ?></td>
            <td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_(''); ?>">
					
				</label>
			</span>		
			</td>
            <td></td>            
		</tr>
        
         <tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'LOC_AREA_DESC' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'AREA' ); ?>:
				</label>
                </span>
			</td>
			<td><?php echo $this->list['area']; ?></td>
            <td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_(''); ?>">
					
				</label>
			</span>		
			</td>
            <td>
            <div class="mapContainer" style="position:relative;">
            <div id="show_map" style="position:absolute; left:0 ; top:0;">
            <div style="float:right; width:16px;">
            <span class="editlinktip">
        	<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('LAT_LONG_MAP_DESC'); ?>">
           </label>
        	</span>
            </div>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script type="text/javascript">
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
		 console.log(latLng);
        }
        
        function updateMarkerAddress(str) {
          document.getElementById('address').innerHTML = str;
        }
        
        function initialize() {
          var latLng = new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $long; ?>);
		  
		 
          var map = new google.maps.Map(document.getElementById('mapCanvas'), {
            zoom: <?php echo $zoom_level; ?>,
            center: latLng,
			disableDefaultUI: true,
			zoomControl: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
          });
		  
		  
		  var image = '<?php echo $livepath; ?>components/com_jsplocation/images/locator.png';
          var marker = new google.maps.Marker({
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
          
          google.maps.event.addListener(marker, 'dragend', function() {
            updateMarkerStatus('Drag ended');
            geocodePosition(marker.getPosition());
          });
        
        }
        </script>
         <div id="mapCanvas">
		 </div>
          <div id="infoPanel">
            <div id="markerStatus" style="display:none;"><i>Click and drag the marker.</i></div>
            <div id="address" style="display:none;"></div>
          </div>
        </div>
        </div>
            </td>            
		</tr>


		<tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'LOC_CATEGORY_DESC' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'CATEGORY' ); ?>:
				</label>
                </span>
			</td>
			<td><?php echo $this->list['category']; ?></td>
            <td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_(''); ?>">
					
				</label>
			</span>		
			</td>
            <td></td>            
		</tr>

        
        <tr>
			<td class="paramlist_key" valign="top">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'LOC_ADDRESS_DESC' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'ADDRESS' ); ?>:
				</label>
                </span>
			</td>
			<td><textarea name="address1" id="address1" class="inputbox" rows="3" cols="28"><?php echo $this->row->address1; ?></textarea></td>
            <td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_(''); ?>">
					
				</label>
			</span>		
			</td>
            <td></td>           
		</tr>
		
        <tr>
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('USE_LATITUDE_LONGITUDE_OVERRIDE_DESC'); ?>">
			<?php echo JText::_('USE_LATITUDE_LONGITUDE_OVERRIDE'); ?>
		</span>
		</td>
		<td class="paramlist_value">
            <select name="lat_long_override" id="lat_long_override" style="width:150px" onchange="javascript: hideLatLongParams(this);">
				<option value="0" <?php echo ($this->row->lat_long_override== '0')?"selected":''; ?>><?php echo JText::_('No'); ?></option>
                <option value="1" <?php echo ($this->row->lat_long_override== '1')?"selected":''; ?>><?php echo JText::_('Yes'); ?></option>
			</select>
		</td>
        <td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('LOC_LAT_LONG_OVR_DESC'); ?>">
					
				</label>
			</span>		
		</td>
            <td></td>       	
		</tr>
        
        <tr id="lat_ovr">
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'LAT_LONG_MAP_DESC' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'LATITUDE_OVERRIDE' ); ?>:
				</label>
                </span>
			</td>
			<td><input onkeypress="return isNumberKey(event)" type="text" name="lat_ovr" value="<?php echo $this->row->lat_ovr; ?>" class="inputbox" size="50" id="info_lat"></td>
            <td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('LATITUDE_OVERRIDE_CONF_DESCRIPTION'); ?>">
					
				</label>
			</span>		
		</td>
            <td></td>        
		</tr>
        
        <tr id="long_ovr">
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'LONGITUDE_OVERRIDE_DESC' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'LONGITUDE_OVERRIDE' ); ?>:
				</label>
                </span>
			</td>
			<td><input type="text" onkeypress="return isNumberKey(event)" name="long_ovr" value="<?php echo $this->row->long_ovr; ?>" class="inputbox" size="50" id="info_lng"></td>
            <td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('LONGITUDE_OVERRIDE_CONF_DESCRIPTION'); ?>">
					
				</label>
			</span>
		</td>
            <td></td>        
        </tr>
        <tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'ZIP_CODE' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'ZIP_CODE' ); ?>:
				</label>
                </span>
			</td>
			<td><input type="text" name="zip" value="<?php echo preg_replace('/[[:^print:]]/','',$this->row->zip); ?>"></td>
            <td class="paramlist_description">
			<span class="editlinktip">
				<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('LOC_ZIP_DESC'); ?>">
					
				</label>
			</span>		
		</td>
            <td></td>    
		</tr>
       	<tr>
			<td class="key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'PUBLISH' ); ?>">
				<label for="name">
					<?php echo JText::_( 'PUBLISH' ); ?>:
				</label>
                </span>
			</td>
			<td class="paramlist_value" width="60%"><fieldset id="published" class="radio btn-group">
            <input type="radio" name="published" value="0" <?php echo ($this->row->published ==0)? 'checked="checked"':''; ?> id="published0" />
            <label class="btn" for="published0"><?php echo JText::_('No'); ?></label>
            <input type="radio" name="published" value="1" <?php echo ($this->row->published == 1)? 'checked="checked"':''; ?> id="published1" />
            <label class="btn" for="published1"><?php echo JText::_('Yes'); ?></label>
            </fieldset></td>
		</tr>		
		</table>
        
	</fieldset>
    </div>

<div class="tab-pane" id="additional-information">
<?php
if($this->row->id=='')
{
?>
	<div align="left"><b><?php echo JText::_( 'LOC_ADD_INFO_DESC' ); ?></b></div>
<?php
}
?>	
<fieldset class="adminform">        
		<table class="table table-striped" >
		<tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'CONTACT_PERSON' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'CONTACT_PERSON' ); ?>:
				</label>
                </span>
			</td>
			<td colspan="3"><input type="text" name="contact_person" value="<?php echo preg_replace('/[[:^print:]]/','',$this->row->contact_person); ?>" class="inputbox" size="50"></td>
		</tr>
		
        <tr>
			<td class="key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'GENDER' ); ?>">
				<label for="name">
					<?php echo JText::_( 'GENDER' ); ?>:
				</label>
                </span>
			</td>
			<td class="paramlist_value" width="60%"><fieldset id="gender" class="radio btn-group">
            <input type="radio" name="gender" value="0" <?php echo ($this->row->gender ==0)? 'checked="checked"':''; ?> id="gender0" />
            <label class="btn" for="gender0"><?php echo JText::_('Male'); ?></label>
            <input type="radio" name="gender" value="1" <?php echo ($this->row->gender == 1)? 'checked="checked"':''; ?> id="gender1" />
            <label class="btn" for="gender1"><?php echo JText::_('Female'); ?></label>
            </fieldset></td>
		</tr>
        
        <tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'EMAIL' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'EMAIL' ); ?>:
				</label>
                </span>
			</td>
			<td colspan="3"><input type="text" name="email" value="<?php echo $this->row->email; ?>" class="inputbox" size="50"></td>
		</tr>
        
         <tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'WEBSITE' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'WEBSITE' ); ?>:
				</label>
                </span>
			</td>
			<td colspan="3"><input type="text" name="website" value="<?php echo preg_replace('/[[:^print:]]/','',$this->row->website); ?>" class="inputbox" size="50"></td>
		</tr>
        
        <tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'CONTACT_NUMBER' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'CONTACT_NUMBER' ); ?>:
				</label>
                </span>
			</td>
			<td colspan="3"><input type="text" name="contact_number" value="<?php echo $this->row->contact_number; ?>" class="inputbox" size="50" onKeyPress="return checkIt(event)" maxlength="12"></td>
		</tr>
        
        <tr>
			<td class="paramlist_key" valign="top">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'DESCRIPTION' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'DESCRIPTION' ); ?>:
				</label>
                </span>
			</td>
			<td colspan="3"><textarea name="description" id="description" class="inputbox" rows="3" cols="70"><?php echo $this->row->description; ?></textarea></td>
		</tr>
        
        <tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'FACEBOOK' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'FACEBOOK' ); ?>:
				</label>
                </span>
			</td>
			<td colspan="3"><input type="text" name="facebook" value="<?php echo preg_replace('/[[:^print:]]/','',$this->row->facebook); ?>" class="inputbox" size="50"></td>
		</tr>
        
         <tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'TWITTER' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'TWITTER' ); ?>:
				</label>
                </span>
			</td>
			<td colspan="3"><input type="text" name="twitter" value="<?php echo preg_replace('/[[:^print:]]/','',$this->row->twitter); ?>" class="inputbox" size="50"></td>
		</tr>
		<tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'POINTER_IMAGE' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'POINTER_IMAGE' ); ?>:
				</label>
                </span>
			</td>
			
			<td style="width:125px;">
			<?php if(!in_array($this->row->pointerImage,$pointer) )
        			{
        				$this->row->pointerImage="jsplocation_icon.png";
        			}
        	?>						
			<select  name="pointerImage" class="inputbox"  onchange ="return loadImage();">					
        			<?php foreach($pointer as $p) { ?>			
					<option	
					<?php 
					if ($p=="jsplocation_icon.png" && $this->row->pointerImage=='' ){echo " selected";}
					elseif($p==$this->row->pointerImage){echo " selected";}
					?>
					>
					<?php echo $p;?></option>					
				<?php } ?>
			</select>
			</td>
			<td valign="top">
				<span id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title="<?php echo JText::_('POINTER_DESC'); ?>">
									
				</span>
			</td>
			<td> <img name="imgPreview" src="../images/jsplocationimages/jsplocationPointers/<?php if ($this->row->pointerImage==''){echo "jsplocation_icon.png";}else {echo $this->row->pointerImage;} ?>"></img></td>			
			
		
		</tr>
        
		</table>
	</fieldset>
    </div>
<?php

      //echo JHtmlTabs::panel('Custom Feilds', 'custom-feilds'); 
	$customfieldsList  = $this->customfieldsList;
    $customfeildsData  = $this->customfeildsData;
	?> 
    
    <div class="tab-pane" id="custom-feilds">
	<fieldset class="adminform">        
		<table class="table table-striped">
		<?php
		
	foreach($customfieldsList as $feild)
	{
	

        $value ="";
          if(is_array($customfeildsData))
		{
		foreach($customfeildsData as $data)
		{
			if($feild->id == $data->feild_id)
			{
				$value = $data->value;
			}
		}
		}
		
		?>
         <tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo $feild->field_name; ?>">
				<label for="name">
        			<?php echo $feild->field_name; ?>:
				</label>
                </span>
			</td>
			<td><input type="text" name="<?php echo $feild->field_name;?>" value="<?php echo $value; ?>" class="inputbox inputbox_vald_spec" size="50"></td>
		</tr>
    <?php
	}
	?>
	</table>
	</fieldset>
    </div>
	
	<div class="tab-pane" id="location-images">
		<?php 
		if($this->row->id=='')
		{
		?>
			<div><b><?php echo JText::_('NEW_BRANCH_IMAGE_MSG');?></b></div>
		<?php	
		}
		else
		{
		?>
		<fieldset class="adminform">        
			<table class="table table-striped">
				<tr style="display:none;">
					<td class="key">
						<span class="editlinktip hasTip" title="<?php echo JText::_( 'SHOW_BR_IMAGE_DESC' ); ?>">
							<label for="name">
							   <?php echo JText::_( 'SHOW_BR_IMAGE' ); ?>:
							</label>
						</span>
					</td>
					<td class="paramlist_value">
							
							<select name="image_display" id="image_display1" onchange="" title="<?php echo JText::_('LOCATION_IMAGE_DESC'); ?>">
								<option value="0" <?php echo (isset($this->row->image_display) && $this->row->image_display == 0) ?"selected":''; ?>><?php echo JText::_('LOCATION_IMAGE_HIDE'); ?></option>
								<option value="1" <?php echo (isset($this->row->image_display) && $this->row->image_display == 1) ?"selected":''; ?>><?php echo JText::_('LOCATION_IMAGE_SHOW'); ?></option>
							</select>
							
					</td>
				</tr>
			</table>
		</fieldset>
	
	<fieldset class="adminform" id="loc_img_descs">
		<table class="table table-striped">
			<thead>
				<tr>
					<th><?php echo JText::_('LOCATION_IMAGE_IMG'); ?> </th>
					<th><?php echo JText::_('LOCATION_IMAGE_NAME'); ?></th>
					<th><?php echo JText::_('Select Images'); ?></th>
				</tr>
			</thead>
	
			<tbody>
				<?php $tmp=0; $k=0;
				foreach ($branchimages as $brimg)
				{   
					// if($this->row->imagename == $brimg)
					// {
															
					
					?>
				<tr>	
					<td align="center"><img src="../images/jsplocationimages/jsplocationImages/<?php echo $branchname.'/'.$brimg;?>" width = "206px" height="150px"/></td>
					<td> <?php echo $brimg;?></td>
					<td><input type="checkbox" id="checkbox_<?php echo $tmp;?>" name="checkbox_<?php echo $tmp;?>" value="<?php echo $brimg;?>"></td>
					<td></td>
				</tr>
				<?php $tmp=$tmp+1; 
				
				//} 
				}?>			
			</tbody> 
		</table>
	</fieldset>
	
	<table id="loc_img_upld" class="table table-striped">
	<tbody>			
		<tr> <!-- file upload form -->				
				<td align="center"> <label>Upload Image</label></td>
				<td> <input type="file" name="txtImagepath" id="txtImagepath"></input></td>	
				<?php
				if(!empty($branchimages)){
				?>		
					 <td><input class="btn btn-primary" type="submit" id="btnDeleteImage" name="btnDeleteImage" value="Delete" onclick ="return ImgDelete(this.value)"></input></td>
				<?php
				}
				
				?>
				<td> <input class="btn btn-primary" type="submit" name="btnUploadImage" id="btnUploadImage" value="Upload" onclick ="return ImgUpload(this.value)"></input></td>	

				
		</tr>					
	</tbody>
	</table>
		<?php
		}
		?>
	</div>
	
	
<div class="tab-pane" id="stored-videos">
       <fieldset class="adminform">        
		<table class="table table-striped">
		
		
		<tr id="paramlist_url">
		<td class="paramlist_key" nowrap="nowrap">
		<span class="editlinktip hasTip" title="<?php echo JText::_('DISPLAY_STORE_VIDEOS'); ?>">
			<?php echo JText::_('STORE_VIDEOS'); ?>
		</span>
		</td>
		<td class="paramlist_value">
			<fieldset id="jform_home" class="radio btn-group">
				 <input type="radio" name="store_videos" value="0" <?php echo ($this->row->store_videos ==0)? 'checked="checked"':''; ?> id="store_videos0" />
            <label class="btn" for="store_videos0"><?php echo JText::_('DISABLE'); ?></label>
            <input type="radio" name="store_videos" value="1" <?php echo ($this->row->store_videos == 1)? 'checked="checked"':''; ?> id="store_videos1" />
            <label class="btn" for="store_videos1"><?php echo JText::_('ENABLE'); ?></label>
			</fieldset>	
		</td>
	</tr>
		<tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'YOUTUBE_VIDEO_URL' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'YOUTUBE_VIDEO_URL' ); ?>:   <a href="http://www.youtube.com" target='_blank'>www.youtube.com</a>
				</label>
                </span>
			</td>
			<td colspan="3"><input type="text" name="youtube_url" value="<?php echo $this->row->youtube_url; ?>" class="inputbox" size="50"></td>
			</tr>
			<tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'VIMEO_VIDEO_URL' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'VIMEO_VIDEO_URL' ); ?>:   <a href="http://www.vimeo.com" target='_blank'>www.vimeo.com</a>
				</label>
                </span>
			</td>
			<td colspan="3"><input type="text" name="vimeo_url" value="<?php echo $this->row->vimeo_url; ?>" class="inputbox" size="50"></td>
		</tr>
			
		<tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'DAILY_MOTION_VIDEO_URL' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'DAILY_MOTION_VIDEO_URL' ); ?>:    <a href="http://www.dailymotion.com" target='_blank'>www.dailymotion.com</a>
				</label>
                </span>
			</td>
			<td colspan="3"><input type="text" name="dailymotion_url" value="<?php echo $this->row->dailymotion_url; ?>" class="inputbox" size="50"></td>
		</tr>
		
		<tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'FICKR_VIDEO_URL' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'FLICKR_VIDEO_URL' ); ?>:      <a href="https://www.flickr.com" target='_blank'>www.flickr.com</a>
				</label>
                </span>
			</td>
			<td colspan="3"><input type="text" name="flickr_url" value="<?php echo $this->row->flickr_url; ?>" class="inputbox" size="50"></td>
		</tr>
		
		<tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'SLIDE_SHARE_VIDEO_URL' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'SLIDE_SHARE_VIDEO_URL' ); ?>:    <a href="https://www.slideshare.net" target='_blank'>www.slideshare.net</a>
				</label>
                </span>
			</td>
			<td colspan="3"><input type="text" name="slideshare_url" value="<?php echo $this->row->slideshare_url; ?>" class="inputbox" size="50"></td>
		</tr>
		
		<tr>
			<td class="paramlist_key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'SPEAKER_DECK_VIDEO_URL' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'SPEAKER_DECK_VIDEO_URL' ); ?>:    <a href="https://www.speakerdeck.com" target='_blank'>www.speakerdeck.com</a>
				</label>
                </span>
			</td>
			<td colspan="3"><input type="text" name="speakerdeck_url" value="<?php echo $this->row->speakerdeck_url; ?>" class="inputbox" size="50"></td>
		</tr>
		
	    </table>
		</fieldset>
    </div>
	
</div>


  

<input type="hidden" name="option" value="com_jsplocation" />
<input type="hidden" id="task" name="task" value="" />
<input type="hidden" name="controller" value="branch" />
<input type="hidden" name="id" value="<?php echo $this->row->id; ?>" />
<input type="hidden" name="edit" value="" />
<?php echo JHtml::_('form.token'); ?>
</form>

<script language="javascript" type="text/javascript">
hideLatLongParams(document.getElementById('lat_long_override'));
</script>


<?php 
if($this->row->id==''){
?>
<script language="javascript" type="text/javascript">
blankList();
</script>
<?php } ?>