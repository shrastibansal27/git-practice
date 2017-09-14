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
$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/responsive.css");?>
<!--Joomla 3.0-JSP Location Extension Version 1.6-Classic View-->
<script type="text/javascript">



//<![CDATA[
var tabLinks = new Array();
var contentDivs = new Array();

var autocomplete;
           function initialize() {
                        
             autocomplete = new google.maps.places.Autocomplete(
                 /** @type {HTMLInputElement} */(document.getElementById('zipsearch')),
                 { types: ['geocode'] });
             google.maps.event.addListener(autocomplete, 'place_changed', function() {
             });
			 
			 autocomplete.addListener('place_changed', onPlaceChanged);
           }
		   
		   function onPlaceChanged() {
				document.forms["adminForm"].submit();
			}

function init()
{
	var tabListItems = document.getElementById('tabs').childNodes;
	
	for ( var it = 0; it < tabListItems.length; it++ )
	{
		if ( tabListItems[it].nodeName == "LI" )
		{
			var tabLink = getFirstChildWithTagName( tabListItems[it], 'A' );
			var id = getHash( tabLink.getAttribute('href') );
			tabLinks[id] = tabLink;
			contentDivs[id] = document.getElementById( id );
		}
	}

	var it = 0;

	for ( var id in tabLinks )
	{
		tabLinks[id].onclick = showTab;
		tabLinks[id].onfocus = function() { this.blur() };
		if ( it == 0 ) tabLinks[id].className = 'selected';
		it++;
	}

	var it = 0;

	for ( var id in contentDivs )
	{
		if ( it != 0 ) contentDivs[id].className = 'tabContent hide';
		it++;
	}
}

function showTab()
{
	var selectedId = getHash( this.getAttribute('href') );

	for ( var id in contentDivs )
	{
		if ( id == selectedId )
		{
			tabLinks[id].className = 'selected';
			contentDivs[id].className = 'tabContent';
		}
		else
		{
			tabLinks[id].className = '';
			contentDivs[id].className = 'tabContent hide';
		}
	}
return false;
}

function getFirstChildWithTagName( element, tagName )
{
	for ( var it = 0; it < element.childNodes.length; it++ )
	{
		if ( element.childNodes[it].nodeName == tagName ) return element.childNodes[it];
	}
}

function getHash( url )
{
	var hashPos = url.lastIndexOf ( '#' );
	return url.substring( hashPos + 1 );
}
//]]>
</script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places"></script>
<?php
if(isset($_GET['loc']))
{
$str=$_GET['loc'];
$br_name=str_replace("-", ' ', $str);
$db =& JFactory::getDBO();
$sql="SELECT `id` from `#__jsplocation_branch` WHERE `branch_name` = '$br_name'";
$db->setQuery($sql);
		$items=$db->loadObjectList();
		foreach($items as $i)
		{
		$value=$i->id;
		}
$expire=time()+60*60*24;
setcookie("br_id", $value, $expire);
setcookie("br_reload", "refresh", $expire);
}

$livepath=JURI::root();
$iconpath = $livepath .'components/com_jsplocation/images/';

$url = JFactory::getURI()->toString(array('path', 'query', 'fragment'));
$urlLoc = JRequest::getVar('loc');

	if($urlLoc=='')
	{
		$default_image_unique_url = 1;						//To set default load image to Yes on Unique URL Location
	}
	else
	{
		$default_image_unique_url = 0;						//To set default load image to No on Unique URL Location
	}

$url =& JURI::getInstance( $url );
$url->delVar( 'loc' );
$url =$url->toString();

$path=JPATH_SITE.'/'.'\images\jsplocationimages\jsplocationPointers';
$imgFiles=JFolder::files($path, "", "");

$rows 				= $this->row;
$list 				= $this->list;
$params 			= $this->params;
$searchresult 		= $this->searchresult;





//echo"<pre>";print_r($searchresult);die;
/* php array to javascript array - searchresult */
$str = 'A'; 
if(!empty($searchresult)){
$searchresultArray = array();
for($i=0;$i<count($searchresult);$i++){

$searchresultArray[$i]['branch_name'] = $searchresult[$i]->branch_name;
$searchresultArray[$i]['latitude'] = $searchresult[$i]->latitude;
$searchresultArray[$i]['longitude'] = $searchresult[$i]->longitude;
$searchresultArray[$i]['contact_person'] = $searchresult[$i]->contact_person;				  
$searchresultArray[$i]['gender'] = $searchresult[$i]->gender;				  
$searchresultArray[$i]['contact_number'] = $searchresult[$i]->contact_number;				  
$searchresultArray[$i]['email'] = $searchresult[$i]->email;	
$searchresultArray[$i]['website'] = $searchresult[$i]->website;	
$searchresultArray[$i]['address1'] = $searchresult[$i]->address1;	
$searchresultArray[$i]['area_name'] = $searchresult[$i]->area_name;	
$searchresultArray[$i]['city_name'] = $searchresult[$i]->city_name;	
$searchresultArray[$i]['zip'] = $searchresult[$i]->zip;	
$searchresultArray[$i]['country_name'] = $searchresult[$i]->country_name;
$searchresultArray[$i]['imagename'] = $searchresult[$i]->imagename;
$searchresultArray[$i]['id'] = $searchresult[$i]->id;


$branchimage = $searchresult[$i]->imagename;

$branchname = $searchresult[$i]->branch_name;

$filename = 'images/jsplocationimages/jsplocationImages/'.$branchname.'/'.$branchimage;

						if (file_exists($filename)) {
							//echo "The file $filename exists";
						
							$style = 'display:block';
						
						} else {
							//echo "The file $filename does not exist";
							$path = 'images/jsplocationimages/jsplocationImages/'.$branchname;
							
							$filepath = 'images/jsplocationimages/jsplocationImages/'.$branchname.'/*';
							
							//echo $filepath;
							
							if (count(glob($filepath)) === 0 ){
								$style = 'display:none';
							}
							else{
							
							$fileArray = array();
							
							foreach(glob($filepath) as $file) 
								{
									$fileArray[] =  basename($file);
									
								}
								
													
								$searchresultArray[$i]['imagename'] = $fileArray[0];
								
								$style = 'display:block';
							}
													
							
						}


$searchresultArray[$i]['style'] = $style;


$searchresultArray[$i]['dynamic_pointer'] = $str++;
			  
}

$js_array = json_encode($searchresultArray);
}
else{
$js_array ='';
}
/* php array to javascript array - searchresult */

$fieldDetails 		= $this->fieldDetails;
$configParams 		= $this->configParams;
//echo"<pre>";print_r($configParams);
$defaultAddress 	= $this->defaultAddress;
$apiOutput			= $this->apiOutput;



$customfeildsinfo 	= $this->customfeildsinfo;
//echo"<pre>";print_r($customfeildsinfo);die;
/* php array to javascript array - customfeildsinfo */

$customfeildsinfoArray = array();
for($i=0;$i<count($customfeildsinfo);$i++){

$customfeildsinfoArray[$i]['branch_name'] = $customfeildsinfo[$i]->branch_name;
$customfeildsinfoArray[$i]['feild_name'] = $customfeildsinfo[$i]->feild_name;
$customfeildsinfoArray[$i]['map_display'] = $customfeildsinfo[$i]->map_display;
$customfeildsinfoArray[$i]['sidebar_display'] = $customfeildsinfo[$i]->sidebar_display;
$customfeildsinfoArray[$i]['id'] = $customfeildsinfo[$i]->id;
$customfeildsinfoArray[$i]['branch_id'] = $customfeildsinfo[$i]->branch_id;
$customfeildsinfoArray[$i]['feild_id'] = $customfeildsinfo[$i]->feild_id;
$customfeildsinfoArray[$i]['value'] = $customfeildsinfo[$i]->value;
}

$js_array_customfields = json_encode($customfeildsinfoArray);

/* php array to javascript array - customfeildsinfo */

$manfeildsinfo 		= $this->manfeildsinfo;
//echo"<pre>";print_r($manfeildsinfo);die;

/* php array to javascript array - manfeildsinfo */

$manfeildsinfoArray = array();
for($i=0;$i<count($manfeildsinfo);$i++){

$manfeildsinfoArray[$i]['field_name'] = $manfeildsinfo[$i]->field_name;
$manfeildsinfoArray[$i]['map_display'] = $manfeildsinfo[$i]->map_display;
$manfeildsinfoArray[$i]['sidebar_display'] = $manfeildsinfo[$i]->sidebar_display;
$manfeildsinfoArray[$i]['published'] = $manfeildsinfo[$i]->published;
}

$js_array_manfeilds = json_encode($manfeildsinfoArray);

/* php array to javascript array - manfeildsinfo */

$country_id			= JRequest::getVar( 'country_id',		'',			'post' );
$state_id			= JRequest::getVar( 'state_id',			'',			'post' );
$city_id			= JRequest::getVar( 'city_id',			'',			'post' );
$area_id			= JRequest::getVar( 'area_id',			'',			'post' );
$radius				= JRequest::getVar( 'radius',			'',			'post' );
$itemid				= JRequest::getVar( 'Itemid',			'',				'' );
$zipsearch			= JRequest::getVar( 'zipsearch',		'',			'post' );

$map_width 			= (($this->params->get('location_list') == '' && $configParams[0]->branchlist == 'Yes') || $this->params->get('location_list') == 1 || ($this->params->get('location_list') == 2 && $configParams[0]->branchlist == 'Yes')) ? $map_width = "66%" : $map_width = "100%";
$range 				= (($this->params->get('radius_range') == ''  && $configParams[0]->radius_range == 'Yes') || $this->params->get('radius_range') == 1 || ($this->params->get('radius_range') == 2 && $configParams[0]->radius_range == 'Yes')) ? $range = "1609.34" : $range = "1000";
$direction_range	= (($this->params->get('direction_range') == 2 && $configParams[0]->direction_range=='Yes')  || $this->params->get('direction_range') == '' && $configParams[0]->direction_range=='Yes' || ($this->params->get('direction_range') == 1)) ? $direction_range = 1 : $direction_range = 0;
$unit				= (($this->params->get('radius_range') == ''  && $configParams[0]->radius_range == 'Yes') || $this->params->get('radius_range') == 1 || ($this->params->get('radius_range') == 2 && $configParams[0]->radius_range == 'Yes')) ? $unit = "Miles" : $unit = "KM";
$zipsearch 			= ($zipsearch == "") ? $text = JText::_( 'POSTAL_CODE' ) : $text = $zipsearch;
$radius 			= (($country_id > 0) || ($state_id > 0) || ($city_id > 0) || ($area_id >0) ) ? $radius = "" : $radius = $radius;
$zipsearch 			= (($country_id > 0) || ($state_id > 0) || ($city_id > 0) || ($area_id >0) ) ? $text = JText::_( 'POSTAL_CODE' ) : $text = $zipsearch;
$zipvalue			= ($this->zipsearch != null) ? $zipvalue = $this->zipsearch : $zipvalue = '';

$show_category		= (($this->params->get('category_dropdown') == 2 and $configParams[0]->category_search == 'Yes') ||($this->params->get('category_dropdown') == 1)) ? $show_category = $list['category'] : $show_category = "";
$show_country		= (($this->params->get('country_dropdown') == 2 and $configParams[0]->country_search == 'Yes') ||($this->params->get('country_dropdown') == 1)) ? $show_country = $list['country'] : $show_country="";
$show_state			= (($this->params->get('state_dropdown') == 2 and $configParams[0]->state_search == 'Yes') ||($this->params->get('state_dropdown') == 1)) ? $show_state = $list['state'] : $show_state="";
$show_city			= (($this->params->get('city_dropdown') == 2 and $configParams[0]->city_search == 'Yes') ||($this->params->get('city_dropdown') == 1)) ? $show_city = $list['city'] : $show_city="";
$show_area			= (($this->params->get('area_dropdown') == 2 and $configParams[0]->area_search == 'Yes') ||($this->params->get('area_dropdown') == 1)) ? $show_area = $list['area'] : $show_area="";

$image_name			= ($configParams[0]->imagename == '') ? $image_name = 'noimage.jpg' : $image_name = $configParams[0]->imagename;

$leftColumn 		= (($this->params->get('location_list') == '' && $configParams[0]->branchlist == 'Yes') || $this->params->get('location_list') == 1 || ($this->params->get('location_list') == 2 && $configParams[0]->branchlist == 'Yes')) ? $leftColumn = "" : $leftColumn = "display:none;";
$hide_class 		= (($this->params->get('location_list') == '' && $configParams[0]->branchlist == 'Yes') || $this->params->get('location_list') == 1 || ($this->params->get('location_list') == 2 && $configParams[0]->branchlist == 'Yes')) ? $hide_class = "" : $hide_class = "jsp_list_hidden";
$sef 				= JFactory::getConfig()->get('sef', false);
$sef 				= ($sef == 0) ? $sef="&" : $sef="?";
$tmpl 				= JRequest::getVar( 'tmpl','','get' );
$tmpl 				= ($tmpl == 'component') ? $tmpl=$sef."tmpl=component" : $tmpl="";
?>
<?php 
if($tmpl=='')
{
	$jsp_map_block="100%;";
}
else
{
	$jsp_map_block="1000px;";
	
}

?>

<?php if ($params->get('show_page_heading', 1)) : ?>
  <h1 class="<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"> <?php echo $this->params->get('page_title'); ?> </h1>
<?php endif; ?>


<style type="text/css">
.jsp_map_block{
	width: <?php echo $jsp_map_block; ?>;
	margin:auto;	
}
.jsp_map_block #imgdiv img{
height: <?php echo $configParams[0]->height; ?>px !important;
}

</style>
<form method="post" name="adminForm" id="adminForm" class="form-validate">
	<!--Condition to check and load jQuery starts here-->
	<?php
	$load_jquery = $configParams[0]->jquery;
	if($load_jquery=="Auto")
	{
	?>
	<script type="text/javascript">
		if (typeof jQuery === "undefined") {
		document.write('\x3Cscript type="text/javascript" src="<?php echo JURI::base(); ?>components/com_jsplocation/scripts/jquery-1.10.1.min.js">\x3C/script>');
		}
	</script>
	<?php
	}
	
	else if($load_jquery=="Yes")
	{
	?>
		<script src="<?php echo JURI::base(); ?>components/com_jsplocation/scripts/jquery-1.10.1.min.js" type="text/javascript"></script>
	<?php
	}
	
	?>
	<!--Condition to check and load jQuery ends here-->
	
	<!--Scripts needed for nice-scroller should be loaded after jQuery starts here-->
	<script src="<?php echo JURI::base(); ?>components/com_jsplocation/scripts/classic_jquery.mCustomScrollbar.js" type="text/javascript"></script>
	<script src="<?php echo JURI::base(); ?>components/com_jsplocation/scripts/jquery.mousewheel.min.js" type="text/javascript"></script>
	<script src="<?php echo JURI::base(); ?>components/com_jsplocation/scripts/select2.js" type="text/javascript"></script>
	<!--Scripts needed for nice-scroller should be loaded after jQuery ends here-->
	
  <div class="jsp_map_block">
    <div class="jsp_wrap">
     
      <!--Search panel start here-->
      <?php
			if(($this->params->get('enable_search') == 2 && $configParams[0]->search=='Yes') || $this->params->get('enable_search') == 1  || ($this->params->get('enable_search') == '' && $configParams[0]->search=='Yes'))
			{
			?>
      <div class="jsp_main">
        <div class="jsp_wrap">
          <div class="jsp_head">
		  <div class="jsp_search">
            <!--Zip/Postal search start here-->
            <div class="form-inline">
              <?php
						if(($this->params->get('zip_search') == 2 && $configParams[0]->zip_search=='Yes') || $this->params->get('zip_search') == 1  || ($this->params->get('zip_search') == '' && $configParams[0]->zip_search=='Yes'))
						{
						?>
							<?php echo '<p class="branchclass form-inline">Find a Store</p><div class="brnch_inp">
<span onclick=\'javascript:funcreset( "resetvalue" );\' title="Click to Reset" class="srch_close"></span><input name="zipsearch" id="zipsearch" maxlength="" alt="" class="input_search form-control" type="text" size="" title="'.JText::_('POSTAL_CODE_TITLE').'" value="'. $zipvalue .'" placeholder="Enter city, state, country or zip code" /></div>'; ?> <?php //echo $list['radius']; ?>

			<!--Locate Me button start here-->
          <?php if(($this->params->get('locateme') == 2 and $configParams[0]->locateme == 'Yes') ||($this->params->get('locateme') == 1))
						{
						?>
         <div class="locate">
            	<div class="loc">				
		<a href="#" style="color:#686868 !important;" onclick="return getGeoloc();" title="<?php echo JText::_('LOCATE_ME_DESC'); ?>">Locate me</a><img class="locate_not" src="<?php echo JURI::base();?>components/com_jsplocation/images/locate.png"><span><i class="fa fa-angle-right"></i></span>				
				</div>
		</div>	          <?php
						}
						?>
          <!--Locate Me button ends here-->



							<?php	
						}
						?>
             
            </div>
            <!--Zip/Postal search ends here-->
          </div>
          
        </div>
        <!--Category, Country, State, City, Area drop-down start here-->
        <?php
				 if($show_category!="" || $show_country!="" || $show_state!="" || $show_city!="" || $show_area!="")
				 {
				 ?>
        <div class="jsp_add_info">
          <?php
							// echo $show_category;
							// echo $show_country;
							// echo $show_state;
							// echo $show_city;
							// echo $show_area;
						?>
        </div>
        <?php
				}				
				?>
        <!--Category, Country, State, City, Area drop-down ends here-->
      </div>
	  </div>	
      <?php 
			}
			?>
      <!--Search panel ends here-->
	  
	  
		
		<?php
		if(!$searchresult)
		{
		?>
				<div style="display:table; width:100%; height:<?php echo $configParams[0]->height?>px; text-align:center;">
					<span style="display:table-cell; vertical-align:middle;"><b><?php echo JText::_("NO_DATA_FOUND") ?></b></span>
	  			</div>
		<?php 
		}
		
		else
		{	
		?>
			<div class="jsp_body" id="jsp_wrap_body">
				<!--Location list start Here-->
				
					<div class="branch">
					<div class="branch_wrap" style="height: <?php echo $configParams[0]->height - 0; ?>px;">
					<?php
					foreach ($fieldDetails as $getFields)
					{
                    	$Fields[] = $getFields['field_name'];
                    }
					
					// print_r($Fields);
					
					
					$bln=false;
					
					foreach ($searchresult as $s) 
					{
						if($this->params->get('map_location') != "" && $this->params->get('map_location') != 0)
						{
							if ($s->id==$this->params->get('map_location'))
							{
								$bln=true;
							}
						}
						else 
						{
							if ($s->id==$configParams[0]->branch_id)
							{
								$bln=true;
							}
						}
						$a = $s->id;
                    }
					
					if(!$bln & $configParams[0]->branch_id!=0)
                    {
						$configParams[0]->branch_id=$a;
						$defaultLocation_lat =$s->lat_long_override==0 ? $s->latitude : $s->lat_ovr;
						$defaultLocation_long=$s->lat_long_override==0 ? $s->longitude : $s->long_ovr;
                    }                        
					elseif($configParams[0]->branch_id=='0' and $configParams[0]->lat_ovr_conf!='' and $configParams[0]->long_ovr_conf!='0')
					{	
						$defaultLocation_lat  = $configParams[0]->lat_ovr_conf;
						$defaultLocation_long = $configParams[0]->long_ovr_conf;
					}	
					elseif($defaultAddress[0]->lat_long_override=='0')
					{
						$defaultLocation_lat  = $defaultAddress[0]->latitude;
						$defaultLocation_long = $defaultAddress[0]->longitude;
					}
					else
					{
						$defaultLocation_lat  =	$defaultAddress[0]->lat_ovr;
						$defaultLocation_long = $defaultAddress[0]->long_ovr;
					}
					
					$numbering=$this->pagination->limitstart;
					$CountryCount="";
					
					foreach ($searchresult as $brachresult)
					{
						$CountryCount .=$brachresult->country_name.',';
						$numbering = $numbering + 1;
						
						if($brachresult->lat_long_override=='0')
						{
							$lat = $brachresult->latitude;
							$long = $brachresult->longitude;
							$points = $lat . ',' . $long;
						}
						
						else
						{
							$points = $brachresult->lat_ovr . ',' . $brachresult->long_ovr;
							$lat = $brachresult->lat_ovr;
							$long = $brachresult->long_ovr;
						}
						
						$Area 			= 	(($this->params->get('area_name') == '' && $configParams[0]->area == 'Yes') || $this->params->get('area_name') == 1 || ($this->params->get('area_name') == 2 && $configParams[0]->area == 'Yes')) ? $Area = ", " . $brachresult->area_name : $Area = "";
						$City 			= 	(($this->params->get('city_name') == '' && $configParams[0]->city == 'Yes') || $this->params->get('city_name') == 1 || ($this->params->get('city_name') == 2 && $configParams[0]->city == 'Yes')) ? $City = $brachresult->city_name . " - " : $City = "";
						$State 			= 	(($this->params->get('state_name') == '' && $configParams[0]->state == 'Yes') || $this->params->get('state_name') == 1 || ($this->params->get('state_name') == 2 && $configParams[0]->state == 'Yes')) ? $State = $brachresult->state_name . ", " : $State = "";
						$Country 		= 	(($this->params->get('country_name') == '' && $configParams[0]->country == 'Yes') || $this->params->get('country_name') == 1 || ($this->params->get('country_name') == 2 && $configParams[0]->country == 'Yes')) ? $Country = $brachresult->country_name : $Country = "";
						
				if(empty($Fields))		
				{
					$BranchName = "";				
				}
				else{		
					$BranchName 	= 	(in_array("Location Name", $Fields)) ? $BranchName = $brachresult->branch_name : $BranchName = "";
				}	
						
				if(empty($Fields)){
					$ContactPerson = "";
				}
				else{
					$ContactPerson 	= 	((in_array("Contact Person", $Fields)) and ($brachresult->contact_person != '')) ? $ContactPerson = JText::_('CONTACT_PERSON').' '.$brachresult->contact_person.'<br/>' : $ContactPerson = "";					
				}

				if(empty($Fields)){
					$ContactNumber = "";
				}
				else{
				$ContactNumber 	= 	((in_array("Contact Number", $Fields)) and ($brachresult->contact_number != '')) ? $ContactNumber = JText::_('CONTACT_NUMBER').' '.$brachresult->contact_number.'<br/>' : $ContactNumber = "";
				
				
				}

								
						
						
						$gender 		= 	($brachresult->gender == '1') ? $gender = "<div class=\"jsp_loc_marker_fields\"><span>".JText::_('GENDER_MARKER')."&nbsp;</span>".JText::_('MALE')."</div>" : $gender = "<div class=\"jsp_loc_marker_fields\"><span>".JText::_('GENDER_MARKER')."&nbsp;</span>".JText::_('FEMALE')."</div>";
						
						
						
				if(empty($Fields)){
				$mail = "";
				}
				else{
					$mail 			= 	((in_array("E-mail Id", $Fields)) and ($brachresult->email != '')) ? $mail = "<div class=\"jsp_loc_marker_fields\"><span>".JText::_('EMAIL_MARKER')."&nbsp;</span><a href=mailto:".$brachresult->email." class=\"jsp_floatNone\">".$brachresult->email."</a></div>" : $mail = "";

				}		
						
						
				if(empty($Fields)){
				$site = "";
				}
				else{
				$site 			= 	((in_array("Website", $Fields)) and ($brachresult->website != '')) ? $site = "<div class=\"jsp_loc_marker_fields\"><span>".JText::_('WEBSITE_MARKER')."&nbsp;</span><a href=".$brachresult->website." target=\"_blank\" class=\"jsp_floatNone\">".$brachresult->website."</a></div>": $site = "";
				
				}		
						
						
						
						$Facebook		= 	($brachresult->facebook != '') ? $Facebook ="<li><a href=".$brachresult->facebook." target=\"_blank\" title=\"".JText::_('FACEBOOK').$brachresult->facebook."\"><i class=\"cust-icon-fb\"></i></a></li>" : $Facebook = "";
						$Twitter		=  	($brachresult->twitter != '')  ? $Twitter  ="<li><a href=".$brachresult->twitter." target=\"_blank\" title=\"".JText::_('TWITTER').$brachresult->twitter."\"><i class=\"cust-icon-twitter\"></i></a></li>" : $Twitter = "";
						$branch_id		=	$brachresult->id;
						$branch_id_disp = 	$branch_id;
						$Description	=	"";
						
						$directionHtml = 
                                    '<!--<div class=\"jsp_loc_marker_fields\"><a href=\"javascript:tohere(0)\" id=\"toLink\" style=\"font-weight:bold;\" title="'.JText::_('TO_HERE_DESCRIPTION').'">'.JText::_('TO_HERE').'<\/a> - <a href=\"javascript:fromhere(0)\" id=\"fromLink\" title="'.JText::_('FROM_HERE_DESCRIPTION').'">'.JText::_('FROM_HERE').'<\/a>' .
                                    '<span id=\"startTxt\" style=\"font-weight:bold;\"><br>'.JText::_('START_ADDRESS').'<\/span>' .
                                    '<span id=\"endTxt\" style=\"display:none; font-weight:bold;\"><br>'.JText::_('END_ADDRESS').'<\/span>' .
                                    '<form action=\"javascript:getDirections('. $direction_range .')\">' .
                                    '<span id=\"startTxtFld\"><input type=\"text\" SIZE=40 MAXLENGTH=40 name=\"start\" id=\"start\" value=\"\"/><\/span>' .
                                    '<span id=\"endTxtFld\"  style=\"display:none;\"><input type=\"text\" SIZE=40 MAXLENGTH=40 name=\"end\" id=\"end\" value=\"\"/><\/span>' .
                                    '<INPUT value=\"'.JText::_('GET_DIRECTIONS').'\" TYPE=\"SUBMIT\" class=\"jsp_tab_get_direction\" title="'.JText::_('GET_DIRECTIONS_DESCRIPTION').'"><br>' .
                                    '<span title=\"'.JText::_('WALK_DESCRIPTION').'\">'.JText::_('WALK').' <input type=\"checkbox\" title=\"'.JText::_('WALK_DESCRIPTION').'\" name=\"walk\" id=\"walk\" \/><\/span>&nbsp; <span title=\"'.JText::_('AVOID_HIGHWAYS_DESCRIPTION').'\">'.JText::_('AVOID_HIGHWAYS').' <input type=\"checkbox\" title=\"'.JText::_('AVOID_HIGHWAYS_DESCRIPTION').'\" name=\"highways\" id=\"highways\" \/><\/span>' .
                                    '<input type=\"hidden\" id=\"sourceDetails\" value=\"' . $lat . ',' . $long . '\"\/>' .
                                    '<\/form><\/div>--><a class="branch_view1" href="'.JURI::base().'index.php?option=com_jsplocation&view=classic&task=redirectviewinfo&id='.$brachresult->id.'">View branch details<i class="fa fa-angle-right"></i></a>';
						
						$address = str_replace("\n"," ",$brachresult->address1);		
						$direction = (($this->params->get('directions') == '' && $configParams[0]->directions == 'Yes') || $this->params->get('directions') == 1 || ($this->params->get('directions') == 2 && $configParams[0]->directions == 'Yes')) ? $direction = $directionHtml : $direction = "";
						
						$contactDetails = '';
						$branchDetails ='';
						$branchDetails_marker  = '';
						
						$pointertype 	= $configParams[0]->pointertype;
						$fillcolor 		= $configParams[0]->fillcolor;
						$fontsize 		= $configParams[0]->fontsize;
						
						for($z=1;$z<30;$z++)         //can accomodate maximum 780 locations with dynamic pins
						{
							$count2 = 1;
							for($y = 'A'; $y <= 'Z'; $y++)
							{
								if($count2<=26)
								$pointerstr[] = $y.$z;
								$count2++;
							}
						}
									
						if(($this->params->get('show_pointer_type') == '' && $configParams[0]->show_pointer_type == 'Yes') || $this->params->get('show_pointer_type') == 1 || ($this->params->get('show_pointer_type') == 2 && $configParams[0]->show_pointer_type == 'Yes'))
						{
							if($pointertype == 'Yes')    // on default alphabetic icon
							{
								$branchDetails .='<div class="branch_number"><div class="pointer">'.$numbering.'</div></div>';
								$branchDetails .='<div class="branch_del">';
								if(isset($manfeildsinfo[0]->sidebar_display) and $manfeildsinfo[0]->published == 1 and $manfeildsinfo[0]->sidebar_display == 1)
								{
									$branchDetails .='<p class="branch_del_head">'.preg_replace('/[[:^print:]]/','',$BranchName).'</p>';
								}	
							}
							else
							{	
								$branchDetails .='<div class="branch_number"><div class="pointer">'.$numbering.'</div></div>';
								$branchDetails .='<div class="branch_del">';
								if(isset($manfeildsinfo[0]->sidebar_display) and $manfeildsinfo[0]->published == 1 and $manfeildsinfo[0]->sidebar_display == 1)
								{
									$branchDetails .='<p class="branch_del_head">'.$BranchName.'</p>';
								}	
							}
						}
						
						else
						{
							$branchDetails .='<div class="branch_del">';
							if(isset($manfeildsinfo[0]->sidebar_display) and $manfeildsinfo[0]->published == 1 and $manfeildsinfo[0]->sidebar_display == 1)
							{
								$branchDetails .='<p class="branch_del_head">'.$BranchName.'</p>';
							}	
						}	
						
						
						$branchDetails .='<p>'.preg_replace('/[[:^print:]]/','',$address.$Area.$City.$brachresult->zip.$State.$Country).'</p>';//sidebar display
						if(isset($manfeildsinfo[0]->map_display) and $manfeildsinfo[0]->published == 1 and $manfeildsinfo[0]->map_display == 1)
						{
						
							$branchDetails_marker .="<p class=\"map_smallcnt_title\">".preg_replace('/[[:^print:]]/','',$BranchName)."</p>";
							//$branchname_details_tab = "<div class=\"branch_del_head\">".$BranchName."</div>";
						}
						$branchDetails_marker .="<div class=\"jsp_loc_marker_fields\">".preg_replace('/[[:^print:]]/','',$address.$Area.'<br/>'.$City.$brachresult->zip.'<br/>'.$State.$Country)."</div>";//marker display
						
						
						//$branchDetails .='<span class="jsp_loc_list_branch_contact">';
						
						if(isset($manfeildsinfo[1]->sidebar_display) and $manfeildsinfo[1]->published == 1 and $manfeildsinfo[1]->sidebar_display == 1)
						//$branchDetails .=$ContactPerson;
						
						if(isset($manfeildsinfo[1]->map_display) and $manfeildsinfo[1]->published == 1 and $manfeildsinfo[1]->map_display == 1 and $brachresult->contact_person !='')
						$contactDetails .="<div class=\"jsp_loc_marker_fields\"><span>".JText::_('CONTACT_PERSON')."&nbsp;</span>".$brachresult->contact_person."</div>";
						
						if(isset($manfeildsinfo[3]->map_display) and $manfeildsinfo[3]->published == 1 and $manfeildsinfo[3]->map_display == 1 and $brachresult->contact_person !='')
						$contactDetails .=$gender;
						
						if(isset($manfeildsinfo[2]->sidebar_display) and $manfeildsinfo[2]->published == 1 and $manfeildsinfo[2]->sidebar_display == 1)
						//$branchDetails .=$ContactNumber;
						
						if(isset($manfeildsinfo[2]->map_display) and $manfeildsinfo[2]->published == 1 and $manfeildsinfo[2]->map_display == 1 and $brachresult->contact_number != '')
						$contactDetails .="<div class=\"jsp_loc_marker_fields\"><span>".JText::_('CONTACT_NUMBER')."&nbsp;</span>".$brachresult->contact_number."</div>";
						
						
						$branchcustom = array();
						foreach($customfeildsinfo as $feild)
						{
							if($feild->branch_id == $brachresult->id and $feild->value!="")
							{
								$branchcustom[$feild->feild_name] = $feild->value;
								if($feild->sidebar_display == 1)
								{
									//$branchDetails.= $feild->feild_name.': '.$feild->value.'<br/>';
								}
								if($feild->map_display == 1)
								{
									$contactDetails.= '<div class="jsp_loc_marker_fields"><span>'.$feild->feild_name.':&nbsp;</span>';
									$contactDetails.= $feild->value.'</div>';
								}
							}
						}
						
						
						if (strpos($_SERVER['QUERY_STRING'],'tmpl=component') !== false) 
                      {
                      $branchDetails .='<a href="index.php?option=com_jsplocation&view=classic&task=redirectviewinfo&id='.$brachresult->id.'&tmpl=component" class="branch_view">View branch details <i class="fa fa-angle-right"></i></a></div>';
                      }
                      else
                      {
                      $branchDetails .='<a href="index.php?option=com_jsplocation&view=classic&task=redirectviewinfo&id='.$brachresult->id.'" class="branch_view">View branch details <i class="fa fa-angle-right"></a></i></div>';
                        }
						
						
						if(isset($manfeildsinfo[4]->map_display) and $manfeildsinfo[4]->published == 1 and $manfeildsinfo[4]->map_display == 1)
						{
							$safemail = '';
							if(strstr($mail,'@') || strstr($mail,'.'))
							{
								$safemail = str_replace('@',' at ',$mail);
								$safemail = str_replace('.',' dot ',$safemail);
							}
						
						$contactDetails .=$mail;
						}
						
						if(isset($manfeildsinfo[5]->map_display) and $manfeildsinfo[5]->published == 1 and $manfeildsinfo[5]->map_display == 1)
                        $contactDetails .=  $site;
						
						$pointerImage=$brachresult->pointerImage;
						$imagepath =  $livepath."images/jsplocationimages/jsplocationPointers/".$pointerImage;
						
						$sidegender=$sidemail=$sidewebsite=$BRIMG='';
						
						$sidedescription = "";
						if(empty($Fields)){
						
						$sidedescription = "";
						}
						else if((in_array("Description", $Fields)) and ($brachresult->description != '') and $manfeildsinfo[6]->published == 1 and $manfeildsinfo[6]->sidebar_display == 1)
						{
							$sidedescription  =  "<li><a onclick=\"SqueezeBox.fromElement(\'index.php?option=com_jsplocation&view=classic&task=showBranchDesc&id=".$brachresult->id."&img=".$this->params->get('dispbrimg')."&tmpl=component\', {size:{x:900,y:500}, handler:\'iframe\'});\" title=\"".JText::_('DESCRIPTION')."\">".'<i class="cust-icon-description"></i>'."</a></li>";
						}
						
						$Description = $Description.$sidedescription;
												
						if(($brachresult->gender == '1') and ($brachresult->contact_person !='') and $manfeildsinfo[3]->sidebar_display !='0')
						{
							$sidegender = '<li title="'.JText::_('CONTACT_PERSON').$brachresult->contact_person.'"><a><i class="cust-icon-men"></i></a></li>';
						}
						if(($brachresult->gender == '0') and ($brachresult->contact_person !='') and $manfeildsinfo[3]->sidebar_display !='0')
						{
							$sidegender = '<li title="'.JText::_('CONTACT_PERSON').$brachresult->contact_person.'"><a><i class="cust-icon-women"></i></a></li>';
						}
						
						// if(in_array("Gender", $Fields))
						// $Description = $Description.$sidegender;
						
						if(empty($Fields)){
							$Description = "";
						}
						else if(in_array("Gender", $Fields)){
							$Description = $Description.$sidegender;
						}
						
						

						$sidemail = '<li><a href=mailto:'.$brachresult->email.' title=\"'.JText::_('EMAIL').$brachresult->email.'\"><i class="cust-icon-message"></i></a></li>';

						
						
						
						if(empty($Fields)){
						$Description = "";
						}
						else if((in_array("E-mail Id", $Fields)) and ($brachresult->email != ''))
							if(isset($manfeildsinfo[4]->sidebar_display) and $manfeildsinfo[4]->published == 1 and $manfeildsinfo[4]->sidebar_display == 1)
				        	$Description = $Description.$sidemail;

						$sidewebsite = '<li><a href='.$brachresult->website.' target="_blank" title=\"'.JText::_('WEBSITE').$brachresult->website.'\"><i class="cust-icon-link"></i></a></li>';
						
						
						if(empty($Fields)){
						$Description = "";
						}
						else if((in_array("Website", $Fields)) and ($brachresult->website != ''))
							if(isset($manfeildsinfo[5]->sidebar_display) and $manfeildsinfo[5]->published == 1 and $manfeildsinfo[5]->sidebar_display == 1)
				            $Description =  $Description.$sidewebsite;
							
						if($brachresult->image_display)
							$BRIMG  =  "<li><a onclick=\"SqueezeBox.fromElement(\'index.php?option=com_jsplocation&view=classic&task=showBranchImg&id=".$brachresult->id."&img=".$this->params->get('dispbrimg')."&tmpl=component\', {size:{x:900,y:500}, handler:\'iframe\'});\" title=\"".JText::_('LOCATION_IMAGE')."\">".'<i class="cust-icon-picture"></i>'."</a></li>";
						else $BRIMG = '';
						
						$Description =  $Description.$BRIMG ;
						
						$Description = '<div class=\"branch-list-footer\"><ul class=\"unstyled list-1\">' . $Description . $Facebook . $Twitter . '</ul></div>';
						if(!in_array($pointerImage,$imgFiles))
		        		{
		        			$pointerImage="jsplocation_icon.png";
		        		}
						$branchDetails .='</div>';
						$Description_null ='';    // no description required in jsplocation 2.2
						
						$pinstr = $pointerstr[$count-1];   //value of the pin
						$createMarker[] = "var marker = createTabbedMarker(
						'$pinstr',
						'$pointertype',
						'$fillcolor',
						'$fontsize',
						'$branch_id_disp',
						new google.maps.LatLng($points),
						'$branchname_details_tab',
						'$branchDetails_marker$direction',
						'$branchDetails',
						'$brachresult->branch_name',
						'$Description_null',
						'$pointerImage',
						'Details',
						'Directions');";
					}
					
				
					
					$str  			= $CountryCount.'**';
					$CountryCount 	= str_replace(",**","",$str);
					$CountryCount 	= explode(",",$CountryCount);
					$CountryName 	= array_unique($CountryCount);
					
					$uniqueCountrynames = $CountryName;  // for polygon usage 
					$serialized_array = array();
					$serialized_array = array_values($uniqueCountrynames);
					$js_array_uniqueCountrynames = json_encode($serialized_array);
					
					$CountryCount 	= count($CountryName);
					$zoomlevel 		= ($radius >0) ? ($CountryCount > 1) ? $zoomlevel = "1" : $zoomlevel = "10" : $zoomlevel = $configParams[0]->zoomlevel;
					
					
					/* Condition to check pagination is set or not and to center 1st location with in the pagination limit on map starts here*/
					
					if($this->pagination->limitstart==0)
					{
						$displayLat  	= ($this->task == 'default' ) ? $displayLat  =  $defaultLocation_lat   : $displayLat = $lat;
						$displayLong 	= ($this->task == 'default' ) ? $displayLong =  $defaultLocation_long  : $displayLong = $long;
					}
					else
					{
						if($searchresult[0]->lat_long_override=='0')
						{
							$displayLat = $searchresult[0]->latitude;
							$displayLong = $searchresult[0]->longitude;
						}
						
						else
						{
							$displayLat = $searchresult[0]->lat_ovr;	// check 
							$displayLong = $searchresult[0]->long_ovr;  // check
						}
					}
					
					
					/* Condition to check pagination is set or not and to center 1st location with in the pagination limit on map ends here*/
				?>
						<div id="side_bar"></div>  <!-- Location Listing goes in here -->
						<div id="directions" style="display:none;" ><input style='margin-left:38px;' type='button' class='jsp_mod_button' onclick='javascript:searchAnotherLocation()' name='search-another-location' id='search-another-location' value='Search Another Location'/></div>  
				
				<div class="back-to-result"><a id="backToResult" style="display:none;" href="<?php echo $myabsoluteurl;?>#" onclick="showElement('side_bar');hideElement('directions');hideElement('backToResult');" title="<?php echo JText::_('BACK_TO_RESULTS_DESCRIPTION'); ?>"><?php echo JText::_('BACK_TO_RESULTS'); ?></a></div>
					</div>
					<!--Location list ends Here-->
					
					<!--Pagination starts Here-->
					<div class="jsp_pagination" id="jsp_pagination">
						<div class="jsp_pagination_bar">
						<?php
							 $pagination_html    = $this->pagination->getPagesLinks();
                            $find                 = array("<ul");
                            $replace               = array("<ul id='jsp_pagination_ul'");    
                            $new_pagination     = str_replace($find, $replace, $pagination_html);
                            echo $new_pagination;
						?>
						</div>
					</div>
					<!--Pagination ends Here-->
					
				</div>
				<script>
                var $j = jQuery.noConflict();
                
                $j( "#jsp_pagination_ul" ).find( "li" ).css( "display", "none" );
                $j( ".pagination-prev" ).css( "display", "block" );
				$j( ".pagination-prev" ).before("<i class='fa fa-angle-left arrrow'></i>");
                $j( ".pagination-next" ).css( "display", "block" );
				$j( ".pagination-next" ).after( "<i class='fa fa-angle-right arrow_r'></i>" );
                </script>
				
				<!-- BING -->
				<?php  //echo"<pre>"; print_r($searchresult);die; ?>
				 <script type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=7.0"></script>
				 <script type="text/javascript">
				 

				  var searchresult = new Array();   // global scope for list of locations
				  searchresult = <?php print_r($js_array); ?>;
				  
				  var customfields = new Array();   // global scope for custom fields
			      customfields = <?php print_r($js_array_customfields); ?>;
				  
				  var manfields = new Array();   // global scope for man fields
			      manfields = <?php print_r($js_array_manfeilds); ?>;
				  
				  var uniqueCountrynames = new Array();
				  uniqueCountrynames = <?php print_r($js_array_uniqueCountrynames); ?>;
				  
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
				  var currentLatitude;
				  var currentLongitude;
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
						$j("#adress_label").append("<b>Start Address</b>");
						$j("#tohere-link").css({'font-weight':'bold','font-size' : '125%'});
						$j("#fromhere-link").css({'font-weight':'normal','font-size' : '100%'});
						tohereClicked = 1;
						fromhereClicked = 0;
						}
						
						function FromHERE(){
						$j("#adress_label").empty();
						$j("#adress_label").append("<b>End Address</b>");
						$j("#fromhere-link").css({'font-weight':'bold','font-size' : '125%'});
						$j("#tohere-link").css({'font-weight':'normal','font-size' : '100%'});
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
						$j("#directions").css('display','none');
						$j("#direct").css('display','block');
						$j('#address').val('');
						if(directionsManager){
						directionsManager.resetDirections();
						}
						if(document.getElementById('walk')){
						document.getElementById('walk').checked = false; 
						}
						}
						
						function findROUTE(){
						
						postAddress = $j('#formRoute').serializeArray();
						
						if($j('#address').val().trim() == 0){
							$j('#address').focus();
							alert('Enter address to find a route');
							$j('#find').val('Find Route');
							return;
						}
						else{
						$j('#find').val('Finding Route...');
						}
						//console.log(post[0].value);
						
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
						   directionsErrorEventObj = Microsoft.Maps.Events.addHandler(directionsManager, 'directionsError', function(arg)  { alert(arg.message);$j('#find').val('Find Route'); $j("#directions").css('display','block'); });
						   directionsUpdatedEventObj = Microsoft.Maps.Events.addHandler(directionsManager, 'directionsUpdated', function() { alert('Directions updated');$j('#find').val('Find Route'); $j("#directions").css('display','block'); });
							
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
							var seattleWaypoint = new Microsoft.Maps.Directions.Waypoint({ address: postAddress[0].value });
							directionsManager.addWaypoint(seattleWaypoint);
							var tacomaWaypoint = new Microsoft.Maps.Directions.Waypoint({ location: new Microsoft.Maps.Location(currentLatitude , currentLongitude) });
							directionsManager.addWaypoint(tacomaWaypoint);
							}
							else if(fromhereClicked == 1)
							{
							var seattleWaypoint = new Microsoft.Maps.Directions.Waypoint({ location: new Microsoft.Maps.Location(currentLatitude , currentLongitude) });
							directionsManager.addWaypoint(seattleWaypoint);
							var tacomaWaypoint = new Microsoft.Maps.Directions.Waypoint({ address: postAddress[0].value });
							directionsManager.addWaypoint(tacomaWaypoint);
							}
							// Set the element in which the itinerary will be rendered
							directionsManager.setRenderOptions({ itineraryContainer: document.getElementById('directions') });
							
							alert('Calculating directions...');
							directionsManager.calculateDirections();
							$j('#find').val('Find Route');
							
							
							setTimeout(function() {   //calls click event after a certain time
								if($j('#directions1_DisambiguationContainer').length){
								if ($j('#directions1_DisambiguationContainer').html().indexOf("did you mean:") > -1 || $j('#directions1_DisambiguationContainer').html().indexOf("We didn't find results for your search.") > -1){
								$j("#directions").css('display','block');     
								$j("#direct").css('display','none');     
								}
								}
							}, 1000);
							
							
							
						}
						
				  
				  function adjustMapWidth(open)
				  {
						
						if(open == 1 && fullscreen != 1)
						{
							map.setView({ width:667 });
						}
						
						else if( open == 1 && fullscreen == 1 )
						{
							map.setView({ width:968 });
						}
						
						else if(open == 0 && fullscreen == 1)
						{
							map.setView({ width:607 });
						}
						
						else if(open == 0 && fullscreen != 1)
						{
							map.setView({ width:416 });
						}
				  }
				  
				 
				  
				  function getMap()
				  {	
					
					
					// Microsoft.Maps.loadModule('Microsoft.Maps.Overlays.Style', 
                    // { callback: function() { 
                                   
									// map = new Microsoft.Maps.Map(document.getElementById('jsp_main_map'), {credentials: 'AqxlyhUl3yFEeZoJlzY5YExqlSfD84cvdORfC8J6w7eNqZrcRum3vy-SrDuTOsVw' , showMapTypeSelector:false , customizeOverlays: true , showBreadcrumb: true , center: new Microsoft.Maps.Location(<?php echo $defaultLocation_lat; ?>,<?php echo $defaultLocation_long; ?>) , zoom: <?php echo $zoomlevel; ?>});	
								// } 
                    // });
					
					map = new Microsoft.Maps.Map(document.getElementById('jsp_main_map'), {credentials: '<?php print_r($configParams[0]->BingMap_key); ?>'  , showMapTypeSelector:false , center: new Microsoft.Maps.Location(<?php echo $defaultLocation_lat; ?>,<?php echo $defaultLocation_long; ?>) , zoom: <?php echo $zoomlevel; ?> , showBreadcrumb: true ,  width: 438, height: <?php echo $configParams[0]->height -4 ;?> });
					
					<?php if( isset($_POST['zipsearch']) && $searchresult != '')
						{
					?>
					map.setView({ zoom: <?php echo $zoomlevel; ?>, center: new Microsoft.Maps.Location((<?php echo $searchresult[0]->latitude; ?>), (<?php echo $searchresult[0]->longitude; ?>)), animate: true});

					<?php }	?>
					
					if(fullscreen == 1){
					map.setView({ width:607 });
					$j("#search-another-location").css('margin-left','95px');
					}
					
					<?php for($i=0;$i<count($searchresult);$i++){  ?>
					var image = "<?php echo $livepath; ?>images/jsplocationimages/jsplocationPointers/<?php echo $searchresult[$i]->pointerImage; ?>";
					
					var pushpinOptions = {icon: image, visible: true}; 
                    
                    var increment = <?php echo $i + 1; ?>;
                    var pagination_order = <?php echo $this->pagination->limitstart; ?>;
                    var location_number = increment + pagination_order;
                    
                    
                    var pointerTYPE = '<?php echo $pointertype; ?>'; 
                    if(pointerTYPE == 'Yes'){
                    
                    var pushpinOptions = {width: null, height: null, htmlContent: "<div class='toll_pointer'><div class='pointer'>"+location_number+"</div></div>"}; 
                    }
					
					var pushpin= new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(<?php echo $searchresult[$i]->latitude; ?>,<?php echo $searchresult[$i]->longitude; ?>), pushpinOptions); 
					pushpinClick = Microsoft.Maps.Events.addHandler(pushpin, 'click', displayEventInfo);  
					map.entities.push(pushpin);
					
				   <?php } 
				   
				  if(isset($searchresult[0]->locateme) and $searchresult[0]->locateme == true)
						{	
				   ?> 
					locatemePolygon();
				   <?php } 
				   
				  if ($radius!='' and (!(isset($searchresult[0]->locateme))))
						{
				   ?> 
					locatemePolygon();
				   <?php } ?>
 				  }
					
				  
					displayEventInfo = function (e) {
					
					$j('#jsp_title').empty();
					$j('#jsp_title').append('Locations');
					$j(".side_bar").css('display','block');
					$j("#jsp_pagination").css('display','block');
					$j("#directions").css('display','none');
					$j("#direct").css('display','none');
					$j('#address').val('');
					if(directionsManager){
					directionsManager.resetDirections();
					}
					if(document.getElementById('walk')){
					document.getElementById('walk').checked = false; 
					}
					
					map.entities.remove(defaultInfobox);         
					var obj = e.target;
					var info = "Events info - " + e.eventName + "\n";
					info += "Target  : " + obj.toString();
					
					var loc=obj.getLocation(); 
					var title = '';
					var contact_person = '';
					var gender = '';
					var contact_number = '';
					var email = '';
					var website = '';
					var customfield = '';
					var address1='';
					var area_name='';
					var city_name='';
					var zip='';
					var imagename = '';
					var branchname = '';
					var style = '';
					
					
					for(i=0; i<searchresult.length; i++ ){
					var pushpinLatitude = searchresult[i].latitude;
					var pushpinLongitude = searchresult[i].longitude;

					
					//console.log(imagename);
					
					
						if( pushpinLatitude == loc.latitude && pushpinLongitude == loc.longitude)
						{
							title = "<p class='map_smallcnt_title' >"+searchresult[i].branch_name+"</p>";
							branchname = searchresult[i].branch_name;
							currentLatitude = loc.latitude;
							currentLongitude = loc.longitude;
							
							if(searchresult[i].contact_person !='' && manfields[1].published == 1 && manfields[1].map_display == 1){
							contact_person = "Contact Person: "+searchresult[i].contact_person;
							contact_person +="<br>";
							}
							if(searchresult[i].gender == 0 && searchresult[i].contact_person !='' && manfields[3].published == 1 && manfields[3].map_display == 1){
							gender = 'Gender: Male' ;
							gender +="<br>";
							}
							else if(searchresult[i].gender == 1 && searchresult[i].contact_person !='' && manfields[3].published == 1 && manfields[3].map_display == 1){
							gender = 'Gender: Female' ;
							gender +="<br>";
							}
							if(searchresult[i].contact_number !='' && manfields[2].published == 1 && manfields[2].map_display == 1){
							contact_number = "Contact Number: "+searchresult[i].contact_number;
							contact_number +="<br>";
							}
							if(searchresult[i].email !='' && manfields[4].published == 1 && manfields[4].map_display == 1){
							email = "Email:<br> <a href='mailto:"+searchresult[i].email+"?Subject=Enquiry%20Mail%20-%20Please%20edit%20the%20subject%20accordingly' style='margin-left: 48px;margin-top: -16px;' target='_top'>"+searchresult[i].email+"</a>";
							//email +="";
							}
							
							if(searchresult[i].website !='' && manfields[5].published == 1 && manfields[5].map_display == 1){
							website = "Website:<br> <a target='_blank' style='margin-left: 64px;margin-top: -16px;' href='"+searchresult[i].website+"'>"+searchresult[i].website+"</a>";
							//website +="";
							}
							
							if(searchresult[i].address1 != ''){
							address1 = "<div id='map_desc_div'>"+searchresult[i].address1;
							}
							
							if(searchresult[i].area_name != '' && searchresult[i].area_name != null){
							area_name = ", "+searchresult[i].area_name;
							}
							
							if(searchresult[i].city_name != ''){
							city_name = ", "+searchresult[i].city_name;
							}
							
							if(searchresult[i].zip != ''){
							if(fullscreen == 1){
							zip = " - "+searchresult[i].zip+"<br><a href='index.php?option=com_jsplocation&view=classic&task=redirectviewinfo&id="+ searchresult[i].id +"&tmpl=component' class='branch_view'>View branch details</a><i class='fa fa-angle-right'></i></div>";
							}
							else{
							zip = " - "+searchresult[i].zip+"<br><a href='index.php?option=com_jsplocation&view=classic&task=redirectviewinfo&id="+ searchresult[i].id +"' class='branch_view'>View branch details</a><i class='fa fa-angle-right'></i></div>";
							}
							}
							
							if(searchresult[i].style != ''){
							style = searchresult[i].style;
							}
							
							if(searchresult[i].imagename != ''){
							imagename = searchresult[i].imagename;
							}
							//Checking whether any custom fields have been added
							
							if(customfields != ''){
							
							for(var j=0; j < customfields.length; j++ )
								{
									if(customfields[j].branch_name == title && customfields[j].map_display == 1 && customfields[j].value !=''){
										
										customfield += customfields[j].feild_name+": "+customfields[j].value+"<br>";
									
									}
								}
							
							}
							
							
						}
					
					}
				
					setInfoBoxLocation(loc.latitude,loc.longitude,title,contact_person,gender,contact_number,email,website,customfield,address1,area_name,city_name,zip,imagename,branchname,style);
					}
				  
				  function setInfoBoxLocation(latitude,longitude,branchtitle,contactPerson,Gender,contactNumber,Email,Website,customField,Address,areaName,cityName,Zip,imagename,branchname,style)
				  { 
					var $j = jQuery.noConflict();
					latitudeMap = Number(latitude);
					longitudeMap = Number(longitude);
					
					Image = '<div style="'+style+'" class="map_smallimg img_popup" id="img_map"><img width="116px" height="118px" class="map_inner img" src="images/jsplocationimages/jsplocationImages/'+branchname+'/'+imagename+'"></div>';
					
					map.setView({ zoom: 8, center: new Microsoft.Maps.Location((latitudeMap+0.65), (longitudeMap+0.75)), animate: true});
					var infoboxOptions = {autoPan:true, width :346, height :173, showCloseButton: true, zIndex: 0, offset:new Microsoft.Maps.Point(-2,30), showPointer: true, title:branchtitle, description:Image+Address+areaName+cityName+Zip}; 
					defaultInfobox = new Microsoft.Maps.Infobox(map.getCenter(), infoboxOptions );    //global scope
					map.entities.push(defaultInfobox);
					defaultInfobox.setLocation(new Microsoft.Maps.Location(latitude, longitude));
					
				  }
				  
				  function leftbar(j)
				  {
				    if(document.getElementById('walk')){
					document.getElementById('walk').checked = false; 
					}
					map.entities.remove(defaultInfobox);
					
					var title = '';
					var contact_person = '';
					var gender = '';
					var contact_number = '';
					var email = '';
					var website = '';
					var customfield = '';
					var address1='';
					var area_name='';
					var city_name='';
					var zip='';
					var style='';
					
					var pushpinLatitude = searchresult[j].latitude;
					var pushpinLongitude = searchresult[j].longitude;
					var imagename = '';	
					var branchname = '';
					currentLatitude = searchresult[j].latitude;
					currentLongitude = searchresult[j].longitude;
						
							title = "<p class='map_smallcnt_title' >"+searchresult[j].branch_name+"</p>";
							branchname = searchresult[j].branch_name;
							if(searchresult[j].contact_person !=''  && manfields[1].published == 1 && manfields[1].map_display == 1){
							contact_person = "Contact Person: "+searchresult[j].contact_person;
							contact_person +="<br>";
							}
							if(searchresult[j].gender == 0 && searchresult[j].contact_person !='' && manfields[3].published == 1 && manfields[3].map_display == 1){
							gender = 'Gender: Male' ;
							gender +="<br>";
							}
							else if(searchresult[j].gender == 1 && searchresult[j].contact_person !='' && manfields[3].published == 1 && manfields[3].map_display == 1){
							gender = 'Gender: Female' ;
							gender +="<br>";
							}
							if(searchresult[j].contact_number !='' && manfields[2].published == 1 && manfields[2].map_display == 1){
							contact_number = "Contact Number: "+searchresult[j].contact_number;
							contact_number +="<br>";
							}
							if(searchresult[j].email !='' && manfields[4].published == 1 && manfields[4].map_display == 1){
							email = "Email:<br> <a href='mailto:"+searchresult[j].email+"?Subject=Enquiry%20Mail%20-%20Please%20edit%20the%20subject%20accordingly' style='margin-left: 48px;margin-top: -16px;' target='_top'>"+searchresult[j].email+"</a>";
							//email +="";
							}
							
							if(searchresult[j].website !='' && manfields[5].published == 1 && manfields[5].map_display == 1){
							website = "Website:<br> <a target='_blank' style='margin-left: 64px;margin-top: -16px;' href='"+searchresult[j].website+"'>"+searchresult[j].website+"</a>";
							//website +="";
							}
							
							if(searchresult[j].address1 != ''){
							address1 = "<div id='map_desc_div'>"+searchresult[j].address1;
							}
							
							if(searchresult[j].area_name != '' && searchresult[j].area_name != null){
							area_name = ", "+searchresult[j].area_name;
							}
							
							if(searchresult[j].city_name != ''){
							city_name = ", "+searchresult[j].city_name;
							}
							
							if(searchresult[j].zip != ''){
							if(fullscreen == 1){
							zip = " - "+searchresult[j].zip+"<br><a href='index.php?option=com_jsplocation&view=classic&task=redirectviewinfo&id="+ searchresult[j].id +"&tmpl=component' class='branch_view'>View branch details</a><i class='fa fa-angle-right'></i></div>";
							}
							else{
							zip = " - "+searchresult[j].zip+"<br><a href='index.php?option=com_jsplocation&view=classic&task=redirectviewinfo&id="+ searchresult[j].id +"' class='branch_view'>View branch details</a><i class='fa fa-angle-right'></i></div>";
							}
							}
							if(searchresult[j].style != ''){
							style = searchresult[j].style;
							}
							
							if(searchresult[j].imagename != ''){
							imagename = searchresult[j].imagename;
							}
							
							//Checking whether any custom fields have been added
							
							if(customfields != ''){
							
							for(var k=0; k < customfields.length; k++ )
								{
									if(customfields[k].branch_name == title && customfields[k].map_display == 1 && customfields[k].value !=''){
										
										customfield += customfields[k].feild_name+": "+customfields[k].value+"<br>";
									
									}
								}
							
							}
							
							

					
				   
					setInfoBoxLocation(pushpinLatitude,pushpinLongitude,title,contact_person,gender,contact_number,email,website,customfield,address1,area_name,city_name,zip,imagename,branchname,style);
				  }
				  
				  
				  
				  function locatemePolygon()
				  {	
					var countries='';
					var latTUDE = null;
					var longiTUDE = null;
					var countryCount = <?php echo $CountryCount; ?>;
			
					<?php 
					if(isset($searchresult[0]->locateme) and $searchresult[0]->locateme == true) 
					{ ?> latTUDE    = <?php echo $searchresult[0]->latnow;  ?>;
						 longiTUDE  = <?php echo $searchresult[0]->longnow;  ?>;
					     var radius = 0;
						 radius     = <?php echo $configParams[0]->locateme_radius; ?>;    //radius of the circle(locateme)
					
					/***********/
						//custom logic to draw a circle				
					var MM = Microsoft.Maps;
					var R = 6371; // earth's mean radius in km	  
					
					var backgroundColor = new Microsoft.Maps.Color(110, 75, 0, 0);
					var borderColor = new Microsoft.Maps.Color(150, 200, 0, 0);

					var lat = (latTUDE * Math.PI) / 180;     
					var lon = (longiTUDE * Math.PI) / 180;
					var d = parseFloat(radius) / R;
					var circlePoints = new Array();

					for (var x = 0; x <= 360; x += 5) {
						var p2 = new MM.Location(0, 0);
						var brng = x * Math.PI / 180;
						p2.latitude = Math.asin(Math.sin(lat) * Math.cos(d) + Math.cos(lat) * Math.sin(d) * Math.cos(brng));

						p2.longitude = ((lon + Math.atan2(Math.sin(brng) * Math.sin(d) * Math.cos(lat), 
										 Math.cos(d) - Math.sin(lat) * Math.sin(p2.latitude))) * 180) / Math.PI;
								p2.latitude = (p2.latitude * 180) / Math.PI;
								circlePoints.push(p2);
						}

					var polygon = new MM.Polygon(circlePoints, { fillColor: backgroundColor, strokeColor: borderColor, strokeThickness: 1 });
					map.setView({ zoom: <?php echo $zoomlevel; ?>, center: new Microsoft.Maps.Location((latTUDE), (longiTUDE)), animate: true});
						//custom logic to draw a circle
										
					map.entities.push(polygon);
				  
					/***********/
					
					<?php } ?>
					
					
					
					<?php
					if ($radius!='' and (!(isset($searchresult[0]->locateme))))
					{  
					
					?>  
	
					for(i=0; i<searchresult.length; i++ ){
					
					for(j=0; j < Object.keys(uniqueCountrynames).length; j++){
					
					if(searchresult[i].country_name == uniqueCountrynames[j]){
					
					
					
					
					if( countries.indexOf(uniqueCountrynames[j]) == -1){
					countries += uniqueCountrynames[j]+",";
					
					
					latTUDE    = searchresult[i].latitude;	
					longiTUDE  = searchresult[i].longitude;
					var radius = 0;	
					radius     = <?php echo $radius;  ?>;						         //radius of the circle(search)	
					
					
					
					
						//custom logic to draw a circle				
					var MM = Microsoft.Maps;
					var R = 6371; // earth's mean radius in km

					var backgroundColor = new Microsoft.Maps.Color(110, 50, 0, 0);
					var borderColor = new Microsoft.Maps.Color(150, 200, 0, 0);

					var lat = (latTUDE * Math.PI) / 180;     
					var lon = (longiTUDE * Math.PI) / 180;
					var d = parseFloat(radius) / R;
					var circlePoints = new Array();

					for (var x = 0; x <= 360; x += 5) {
						var p2 = new MM.Location(0, 0);
						var brng = x * Math.PI / 180;
						p2.latitude = Math.asin(Math.sin(lat) * Math.cos(d) + Math.cos(lat) * Math.sin(d) * Math.cos(brng));

						p2.longitude = ((lon + Math.atan2(Math.sin(brng) * Math.sin(d) * Math.cos(lat), 
										 Math.cos(d) - Math.sin(lat) * Math.sin(p2.latitude))) * 180) / Math.PI;
								p2.latitude = (p2.latitude * 180) / Math.PI;
								circlePoints.push(p2);
						}

					var polygon = new MM.Polygon(circlePoints, { fillColor: backgroundColor, strokeColor: borderColor, strokeThickness: 1 });
					map.setView({ zoom: <?php echo $zoomlevel; ?>, center: new Microsoft.Maps.Location((latTUDE), (longiTUDE)), animate: true});
						//custom logic to draw a circle
										
					map.entities.push(polygon);
				 }
				}
				}
				}
					<?php } ?>
				  }
				  
				 </script>
				
				<!-- BING -->
				
				
				<div class="map">
            	<div class="map_inner">
					<div class="img_map" style="height: <?php echo $configParams[0]->height - 2; ?>px" id="jsp_main_map">
						<script language="'Javascript'" type='text/javascript'>
                        window.onload = function ()
						{
							load();
							getMap();  //Bing
							
							<?php
							if($urlLoc!='')
							{
							?>
								getValue();
							<?php
							}
							?>	
								
                        }
						
						
						
						
						
						
						
						
						function DrawCircle()
						{	
							<?php
							if ($radius!='' and (!(isset($searchresult[0]->locateme))))
							{	
								for ($j=0; $j<$CountryCount; $j++)
								{
								?>
									var startPoint = new google.maps.LatLng(<?php echo $searchresult[$j]->latitude;?>,<?php echo $searchresult[$j]->longitude;?>);
									drawCircle(map, startPoint, <?php echo $radius; ?>, 80);
								<?php
								}
							}
							if(isset($searchresult[0]->locateme) and $searchresult[0]->locateme == true)
							{	
								$locatemeradius = $this->params->get('locateme_radius')==0 ? $searchresult[0]->locatemeradius :$this->params->get('locateme_radius');
							?>
								var startPoint = new google.maps.LatLng(<?php echo $searchresult[0]->latnow;?>,<?php echo $searchresult[0]->longnow;?>);
						  		drawCircle(map, startPoint, <?php echo $locatemeradius; ?>, 80);
							<?php
							}
							?>
						}     
						
						var poly = [] ;
						var line ;
						
						function drawCircle(map, center, radius, numPoints)
						{
                             var radius1 = radius*<?php echo $range;?>;
							 var populationOptions = 
							 	{
								  strokeColor: "#1795E7",
								  strokeOpacity: 0.4,
								  strokeWeight: 2,
								  fillColor: "#7CA4E6",
								  fillOpacity: 0.35,
								  map: map,
								  radius: radius1,
								  center: center,  
								};
							cityCircle = new google.maps.Circle(populationOptions);
						}						
                      
                        var map = null;
                        var gdir = null;
                        var geocoder = null;
						var overlays = [];
                        var htmls = [];
                        var html="";
                        var Lst;
						var visibleInfoWindow = null;
						var directionDisplay;
                        var directionsService = new google.maps.DirectionsService();
						
						function CngClass(obj)
						{
							if (Lst) Lst.className='';
						 	obj.className='selected';
						 	Lst=obj;
						}
						
						function getValue()
						{
							var z= "li_"+"<?php echo $urlLoc; ?>";
							document.getElementById(z).className='selected';
						}
						
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
					   
                       function showElement(elemId)
					   {
                           	document.getElementById(elemId).style.display = "block";
                       }
					   
                       function hideElement(elemId)
					   {
                        	document.getElementById(elemId).style.display = "none";
                       }
					   
                       function getDirections(unit)
					   {	
                            // ==== set the start and end locations ====
                            var sourceDetails = document.getElementById("sourceDetails").value;
							var start = document.getElementById("start").value;
                            var end = document.getElementById("end").value;
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
								
							var sampleRequest = {
							  origin: from,
							  destination: to,
							  travelMode: google.maps.TravelMode.DRIVING,
							  unitSystem: sys                               // METRIC/IMPRIAL
							}; 
							
							directionsService.route(sampleRequest, function(response, status)
							{
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
               
                            document.getElementById('backToResult').style.display = "block";
                            document.getElementById('directions').style.display = "block";
                            document.getElementById('side_bar').style.display = "none";
                        }
                        //<![CDATA[

                        function load()
						{	
							var target = '<?php echo $urlLoc; ?>';
							var firstLatLng = new google.maps.LatLng(<?php echo $displayLat . ',' . $displayLong; ?>);
							var zoom = <?php echo $zoomlevel; ?>;
							var myOptions =
							{
								zoom: zoom,
								center: firstLatLng,
								mapTypeControl: false,
								mapTypeId: google.maps.MapTypeId.ROADMAP
							};

							//map = new google.maps.Map(document.getElementById("map"),myOptions);

							var side_bar_html = "";
							
							directionsDisplay = new google.maps.DirectionsRenderer(
							{
								map: map,
								preserveViewport: true,
							}
							);

							directionsDisplay.setPanel(document.getElementById('directions'));
							
							function createTabbedMarker(pinstr, pointertype, fillcolor, fontsize, branch_id_disp, point, contactDetails, branchDirection, branchAddress, title, description, pointerImage ,label1, label2)
							{
								if(pointertype == 'Yes') //pointertype is dynamic type
								{
									var image = "https://chart.googleapis.com/chart?chst=d_map_spin&chld=0.6|0|"+fillcolor+"|"+fontsize+"||"+pinstr ;
								}
								else 
								{
									var image = "<?php echo $livepath; ?>images/jsplocationimages/jsplocationPointers/"+pointerImage;
								}
								
								var id = branch_id_disp; 
								
								var marker = new google.maps.Marker(
								{
									map: map,
									title: title,
									icon:image,
									position: point,
									id:id
								}
								);
								
								var contentString = [
								'<div class="marker_tab_content">',
								'<ul id="tabs">',
  									'<li><a class="selected" href="#tab_details"><?php echo JText::_('DETAILS');?></span></a></a></li>',
			 	 					'<li><a class="" href="#tab_directions"><?php echo JText::_('DIRECTIONS');?></a></li>',
								'</ul>',
								'<div class="tabContent" id="tab_details">',contactDetails,'</div>',
								'<div class="tabContent hide" id="tab_directions">',branchDirection,'</div>',
								'</div>'
								].join('');
								
								var infoWindow = new google.maps.InfoWindow(
								{
									content: contentString,
									maxWidth: 500
								}
								);

								google.maps.event.addListener(
								marker, "click", function()
								{
									var passed_id=marker.id;
									if (visibleInfoWindow)
									{
										visibleInfoWindow.close();
									}
									if (visibleInfoWindow)
									{
										infoWindow.open(map, marker);
									
									
									visibleInfoWindow = infoWindow;
									}
									if('<?php echo $configParams[0]->branch_url;?>'=='Yes')
									{
										branchhit(passed_id);
									}
									else
									{
										function setCookie(c_name,value,exdays)
										{
											var exdate=new Date();
											exdate.setDate(exdate.getDate() + exdays);
											var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
											document.cookie=c_name + "=" + c_value;
											return true;
										}
									
										function getCookie(c_name)
										{
											var i,x,y,ARRcookies=document.cookie.split(";");
											for (i=0;i<ARRcookies.length;i++)
											{
												x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
												y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
												x=x.replace(/^\s+|\s+$/g,"");
												if (x==c_name)
												{
													return unescape(y);
												}
											}
											return false;
										}
										
										var br_id = getCookie("br_id");
										var br_reload_hit = getCookie("br_reload_hit");
										var br_reload = getCookie("br_reload");

										if( br_id == passed_id && br_reload == "refresh" )
										{
											branchhit(passed_id);
											setCookie("br_reload", "refreshed", 30);
										}
										
										else if( br_id != passed_id )
										{
											branchhit(passed_id);
										}
									}
								
								}
								);
								
								google.maps.event.addListener(
								infoWindow, 'domready', function()
								{
									init();
								}
								);
								overlays.push(marker);
								
								var uniqueurl = '<?php echo $configParams[0]->branch_url; ?>';
								
								if (target!=="" && uniqueurl=='No')
								{
									newtarg=target.replace(/["-"]/g," ");
									for (var i = 0; i < overlays.length; i++)
									{
										if (newtarg==overlays[i].getTitle().replace(/[^0-9A-z_]/g,"-"))
										{	
											myclick(i);    
										}
									}
								}
								<?php 
								if($configParams[0]->branch_url=='Yes'){
								
								?>
								
								
								
							side_bar_html += '<li onclick="CngClass(this);"><a class="jsp_loc_branchdetails branch_notification" href="javascript:myclick(' + (overlays.length-1) + ');" id="'+title.replace(/[^\x00-\x7F]/g,"")+'" title="<?php echo JText::_('LOCATION_LIST_TITLE');?>">' + branchAddress + '<\/a>';
								
								<?php }
								if($configParams[0]->branch_url=='No'){ ?>
								
								//side_bar_html += '<li id="li_'+title.replace(/[^0-9A-z_]/g,"-")+'"><div class="branch-list-header"><a class="jsp_loc_branchdetails" href="<?php echo JRoute::_('index.php?option=com_jsplocation&view=classic&Itemid='.$itemid.'&loc='); ?>'+title.replace(/[^0-9A-z_]/g,"-")+'<?php echo $tmpl; ?>" id="'+title.replace(/[^0-9A-z_]/g,"-")+'" title="<?php echo JText::_('LOCATION_LIST_TITLE');?>">' + branchAddress + '<\/a><\/div>';
								side_bar_html += '<li onclick="CngClass(this);"><a class="jsp_loc_branchdetails branch_notification" href="javascript:myclick(' + (overlays.length-1) + ');" id="'+title.replace(/[" "]/g,"-")+'" title="<?php echo JText::_('LOCATION_LIST_TITLE');?>">' + branchAddress + '<\/a>';
								<?php } ?>
								
								side_bar_html += description + '<div style=\'clear:both; \'></div></li>';
								return marker;
							}
							DrawCircle();

							<?php
							foreach ($createMarker as $marker)
							{
								echo $marker;
							}
							?>
							
							document.getElementById("side_bar").innerHTML = "<ul>" + side_bar_html + "</ul>";
                        }
                        
						function myclick(i)
						{
							leftbar(i);					
								//ultimate javascript call for leftbar click event
							 google.maps.event.trigger(overlays[i], "click");
						}
                    </script>
						<div id="map" style="display:none;width:100%; height: <?php echo $configParams[0]->height; ?>px"></div>
					</div>
					
					<div class="jsp_fullscr">
						<?php 
						if($tmpl=='')
						{?>
					<div class="prev"><a href="<?php echo JRoute::_('index.php?option=com_jsplocation&view=classic').$sef; ?>tmpl=component" title="<?php echo JText::_('FULLSCREEN_TITLE'); ?>" target="_blank"><?php echo JText::_('FULLSCREEN'); ?><img src="<?php echo JURI::base();?>components/com_jsplocation/images/fullscr.png"></a></div>
						<?php
						}
						?>
					</div>
				</div>
				
				<?php
				}
				?>
				
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
	<input type="hidden" name="geolat" id="geolat"/>
	<input type="hidden" name="geolong" id="geolong"/>
	<input type="hidden" name="locateme" id="locateme"/>
	<input type="hidden" id="markerbox"/>
	<input type="hidden" name="option" value="com_jsplocation"/>
	<input type="hidden" name="view" value="classic"/>
	<input type="hidden" name="id" value=""/>
	<input type="hidden" name="task" value="search" id="task"/>
	<?php echo JHTML::_('form.token'); ?>
</form>
<?php 
$browser = &JBrowser::getInstance();
$browserType = $browser->getBrowser();
$browserVersion = $browser->getMajor();

if(($browserType == 'msie') && ($browserVersion < 9))
{
	//JS Will Not Work For Changing Classes Of Pagination
	$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/ie8-classic.css");
}

else
{
?>
<script type="text/javascript">
var elements = document.getElementsByClassName("pagination-list");
if(elements[0] !=undefined)
{
el_length = elements[0].childNodes.length;
elements[0].childNodes[0].className = "pag-start";
elements[0].childNodes[1].className = "pag-prev";
elements[0].childNodes[el_length-2].className = "pag-next";
elements[0].childNodes[el_length-1].className = "pag-end";
}
</script>
<?php
}
?>



<script type="text/javascript">

<?php
if($configParams[0]->google_autocomplete_address == 'Yes'){

?>
initialize();

<?php 

 }


?>


var $j = jQuery.noConflict();
$j(window).load(function()
{
	$j(".custom-scroll").mCustomScrollbar({
		autoHideScrollbar:true
	});
	$j(".jsp_seperator span").click(function()
	{
	
		if($j(".jsp_seperator").hasClass("expanded"))
		{
			adjustMapWidth(1);
			$j(".jsp_wrap_body .branch-panel").animate({opacity:0,width: "0%"}, { queue: false, duration: 400 } );	
			$j(".jsp_wrap_map").animate({"width":"100%"}, { queue: false, duration: 400 } );	
			$j(".jsp_seperator").removeClass("expanded");
			$j(".branch-panel").css('display','none');
			
			/*Condition to reeize map and setcenter start here on expand-collepse sidebar*/
			// var currCenter = map.getCenter();
			// document.getElementById("map").style.width = '150%';
			// google.maps.event.trigger(map, 'resize');
			// map.setCenter(currCenter);
			/*Condition to reeize map and setcenter ends here on expand-collepse sidebar*/
		}
		else
		{	
			adjustMapWidth(0);	
			$j_left = $j(".jsp_wrap_body .branch-panel").width();
			$j(".jsp_wrap_body .branch-panel").css("display","block"); 
			$j(".jsp_wrap_body .branch-panel").animate({opacity:1,width:"37%"}, { queue: false, duration: 400 } );	
			$j(".jsp_wrap_map").animate({"width":"63%"}, { queue: false, duration: 400 } );
			$j(".jsp_seperator").addClass("expanded");
			$j(".branch-panel").css('display','block');
			
			/*Condition to reeize map and setcenter start here on expand-collepse sidebar*/
			var currCenter = map.getCenter();
			map.setCenter(currCenter);
			document.getElementById("map").style.width = '100%';
			google.maps.event.trigger(map, 'resize');
			/*Condition to reeize map and setcenter ends here on expand-collepse sidebar*/
		}
	});

});
$j(document).ready(function()
{	
	if ( $j('#imgdiv').hasClass('imgplx') ) {
		$j('#jsp_wrap_body').css('visibility','hidden')
		$j('#jsp_pagination,.screen').css('display','none')
	};
	$j("#imgdiv").click(function() {
		$j('#imgdiv').css({'display':'none'})
		$j('#jsp_wrap_body,#jsp_pagination').css('visibility','visible');
		$j('#jsp_pagination,.screen').css('display','block')
	});
	if ( $j('.jsp_wrap_map').hasClass('jsp_list_hidden') ) {
		$j('.jsp_wrap_map').css('width','100%')
	};
	
	$j("#category_id").select2({
                placeholder: "<?php echo JText::_('SELECT_CATEGORY')?>",
                allowClear: true
	});
	$j("#category_id_2").select2({
		placeholder: "<?php echo JText::_('SELECT_CATEGORY')?>"
	});
	$j("#country_id").select2({
		placeholder: "<?php echo JText::_('SELECT_COUNTRY')?>",
		allowClear: true
	});
	$j("#country_id_2").select2({
		placeholder: "<?php echo JText::_('SELECT_COUNTRY')?>"
	});
	$j("#state_id").select2({
		placeholder: "<?php echo JText::_('SELECT_STATE')?>",
		allowClear: true
	});
	$j("#state_id_2").select2({
		placeholder: "<?php echo JText::_('SELECT_STATE')?>"
	});
	$j("#city_id").select2({
		placeholder: "<?php echo JText::_('SELECT_CITY')?>",
		allowClear: true
	});
	$j("#city_id_2").select2({
		placeholder: "<?php echo JText::_('SELECT_CITY')?>"
	});
	$j("#area_id").select2({
		placeholder: "<?php echo JText::_('SELECT_AREA')?>",
		allowClear: true
	});
	$j("#area_id_2").select2({
		placeholder: "<?php echo JText::_('SELECT_AREA')?>"
	});
	

		var alert_h = $j('.img_map').height();
		var rbl = $j('.img_map').css('padding-left').replace(/[^-\d\.]/g, '');
		$j('.branch_wrap').height(alert_h-(Math.round(rbl)*2));
	
	$j(".branch_wrap").mCustomScrollbar();
});
</script>
