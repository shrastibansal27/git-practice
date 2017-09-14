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

//JHTML::_('behavior.modal');
jimport('joomla.environment.browser');
include JPATH_COMPONENT.'/'.'helpers'.'/'.'helper.php';

// $myabsoluteurl=&JURI::getInstance()->toString(array('path','query'));
$document = & JFactory::getDocument();


$sef 				= JFactory::getConfig()->get('sef', false);
$sef 				= ($sef == 0) ? $sef="&" : $sef="?";
$tmpl 				= JRequest::getVar( 'tmpl','','get' );
$tmpl 				= ($tmpl == 'component') ? $tmpl=$sef."tmpl=component" : $tmpl="";

// $document->addScript(JURI::base() . 	"components/com_jsplocation/scripts/jQuery.js");
// $document->addScript(JURI::base() . 	"components/com_jsplocation/scripts/jQuery.equalHeights.js");
// $document->addScript(JURI::base() . 	"components/com_jsplocation/scripts/validation.js");
// $document->addScript(JURI::base() . 	"components/com_jsplocation/scripts/jquery.mCustomScrollbar.concat.min.js");
// $document->addScript(JURI::base() . 	"components/com_jsplocation/scripts/jquery.jpop.js");

$document->addScript(JURI::base() . "components/com_jsplocation/scripts/swiper.min.js");

$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/swiper.min.css");

$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/bootstrap.min.css");
$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/font-awesome.min.css");
$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/jquery.mCustomScrollbar.css");
$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/style_mobile.css");
$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/responsive.css");
$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/jquery.jpop.css");

$store_id=JRequest::getVar('id');
$directory_path = $this->directory_path;
$branch_images = imageHelper::readBranchImages($directory_path);
$branchname = $this->branchdetails[0]->branch_name;
$configParams = $this->configParams;
$params = $this->params;
$latlng = $this->latlng;
$lat = $latlng[0]->latitude;
$long = $latlng[0]->longitude;

$direction_range	= (($this->params->get('direction_range') == 2 && $configParams[0]->direction_range=='Yes')  || $this->params->get('direction_range') == '' && $configParams[0]->direction_range=='Yes' || ($this->params->get('direction_range') == 1)) ? $direction_range = 1 : $direction_range = 0;

$zoomlevel = $configParams[0]->zoomlevel;
$dir_apiKey = $configParams[0]->GoogleMap_DIR_key;
$app = JFactory::getApplication(); 
$menu = $app->getMenu();
$menuItem = $menu->getItems( 'link', 'index.php?option=com_jsplocation&view=classic', true );
?>


<!-- <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>  -->
<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false&libraries=places&key=<?php echo $dir_apiKey;?>"></script>
<script type="text/javascript">
    (function($){
        $(window).load(function(){
            //$(".info_left").mCustomScrollbar();
            //$(".directions").mCustomScrollbar();
			var swiper = new Swiper('.swiper-container');
			
        });
    })(jQuery);
    </script>
</head>

<body>

<div class="jsp_main">
	<div class="jsp_wrap">
    
        <div class="info_body">
        	<div class="info_wrap">
            	<!--<div class="info_left mCustomScrollbar">

					
          
               // </div>-->
                <div class="info_right">
				
				
				<?php
				
				
				$branch_image_count = count($branch_images);
				
				if(empty($branch_images)){
				
				?>
				
				<!-- <div style="text-align:center;width:417px;height:417px;"><h2>No Store Images to Display</h2></div> -->
				<div style="text-align:center;"><h2>No Store Images to Display</h2></div>
				
				<?php
				
				}
				
								
				else if($branch_image_count == 1){
				
				?>
				
				<a href="images/jsplocationimages/jsplocationImages/<?php echo $branchname.'/'.$branch_images[0];?>"><img width="100%" height="100%" src="images/jsplocationimages/jsplocationImages/<?php echo $branchname.'/'.$branch_images[0];?>"/></a>
				
				<?php
				
				
				}
				else{
				
								
				?>
				
                	<div id="slider" class="info_right_wrap swiper-container">
					
						<span class="control_next"/><img src="<?php echo JURI::base() . 	"components/com_jsplocation"; ?>/images/right.png"/></span>
						<span class="control_prev"/><img src="<?php echo JURI::base() . 	"components/com_jsplocation"; ?>/images/left.png"/></span>
						
					  <ul class="swiper-wrapper">
					  
						<?php
						
						foreach ($branch_images as $brimg)
						{
						
						?>
						<li class="swiper-slide text-center"><img src="images/jsplocationimages/jsplocationImages/<?php echo $branchname.'/'.$brimg;?>" width = "417px" height="417px"/></li>
						<?php
						} 
						?>
					  
					  </ul> 
					
					<!-- <div class="slider_option">
					  <input type="checkbox" id="checkbox"/>
					  <label for="checkbox">Autoplay Slider</label>
					</div>  -->
					
                    	<!--  <div class="view">
                        	<div><img src="images/camera.png">View more photos</div>
                        </div>  -->
                    </div>
					
					
					
					<?php
					
					}
					
					?>
					
					
                </div>

            </div>
			<div class="clearfix"></div>
           
        </div>

            

                    	<div class="address">
						
						<p class="heading">Address:</p>
                            <p style="color:#000;font-size: 17px !important;"><?php echo $this->branchdetails[0]->address1; ?></p>
							<p style="color:#000;font-size: 17px !important;"><?php echo $this->getCityName[0]->title; ?> - <?php echo $this->branchdetails[0]->zip; ?></p>
							<div class="accordion">
							<p class="heading">More Info:</p>
							</div>
						
							
							<div class="panel">
                        <?php if($this->branchdetails[0]->contact_number != ''){ ?>
                       <div class="phn_no">
                        
                         <?php    echo "<p>Call - ".$this->branchdetails[0]->contact_number."</p>"; ?>
                           
                       </div>
                        <?php } ?>
                	
	 
                        <!--<p class="branch_hrs">Additional Information</p></br>-->
                       <?php if($this->branchdetails[0]->contact_person != '' && $this->getDefaultFieldStatus[0]->published != 0){ if($this->branchdetails[0]->gender == 0){ $gender = "Male"; } else{  $gender = "Female"; } echo "<p>Contact Person - ".$this->branchdetails[0]->contact_person."</p>"; if($this->getDefaultFieldStatus[1]->published != 0) echo"<p>Gender - ".$gender."</p>"; } ?>
                       <?php if($this->branchdetails[0]->email != '' && $this->getDefaultFieldStatus[2]->published != 0){ echo "<p>E-Mail - <a href='mailto:".$this->branchdetails[0]->email ."' target='_top'>".$this->branchdetails[0]->email."</a></p>"; } ?>
					   <?php if($this->branchdetails[0]->website != '' && $this->getDefaultFieldStatus[3]->published != 0){ echo "<p>Website - <a target='_blank' href='".$this->branchdetails[0]->website ."'>".$this->branchdetails[0]->website."</a></p>"; } ?> 
					   
					   <?php if($this->branchdetails[0]->facebook != ''){ echo "<p>Facebook - <a target='_blank' href='".$this->branchdetails[0]->facebook ."'>".$this->branchdetails[0]->facebook."</a></p>"; } ?> 
					   <?php if($this->branchdetails[0]->twitter != ''){ echo "<p>Twitter - <a target='_blank' href='".$this->branchdetails[0]->twitter ."'>".$this->branchdetails[0]->twitter."</a></p>"; } ?> 
					   <?php if($this->branchdetails[0]->additional_link != ''){ echo "<p>Additional link - <a target='_blank' href='".$this->branchdetails[0]->additional_link ."'>".$this->branchdetails[0]->additional_link."</a></p>"; } ?> 
					   <?php if($this->branchdetails[0]->description != '' && $this->getDefaultFieldStatus[4]->published != 0){ echo "<p>Description - ".$this->branchdetails[0]->description ."</p>"; } ?> 
					   
					   <?php if($this->customNames != '' && $this->customValues !=''){
							$i=0;
							 foreach ($this->customNames as $key => $value) { 	
							 
							 echo"<p>".$this->customNames[$i] ." - ".$this->customValues[$i] ."</p></br>";
							
							 $i++;
							 }
							 
					   }
					   ?>
					   </div>
					  </div>
                    				
            
              <script>
			  
			  var acc = document.getElementsByClassName("accordion");
              var i;
			  for (i = 0; i < acc.length; i++) {
    acc[i].onclick = function(){
        this.classList.toggle("active");
        this.nextElementSibling.classList.toggle("show");
  }
}
			  
			  
			  
			  </script>        
            			
            
                      
            
                          <!--      <div class="link">
						
						 <?php if (strpos($_SERVER['QUERY_STRING'],'tmpl=component') !== false) 
                        {
                        ?>
                <p><a href="<?php echo JURI::base().'index.php?option=com_jsplocation&task=directionview_mobile&id='.$store_id; ?>&tmpl=component">Driving directions and map</a> <i class="fa fa-angle-right"></i></p>
                <?php    }
                      else
                        {
                        ?>
                <p><a href="<?php echo JURI::base().'index.php?option=com_jsplocation&task=directionview_mobile&id='.$store_id; ?>">Driving directions and map</a> <i class="fa fa-angle-right"></i></p>
                <?php     } ?>
						 </div>  -->  
            
               		<div class="address_div">
               			<p class="heading">Direction:</p>
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
                            
                        <div class="direction_div" style='<?php echo $style;?>'>
						
						  <form action="javascript:getDirections(<?php echo $direction_div; ?>)">	
						
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
						  <div class="direction_description" id="direction_description" style="display:none;" > 
						  <div class="directions mCustomScrollbar" style="height: 276px; margin-bottom:20px;">
						  <!-- <div class="directions">-->
                           <div id="directions" style="display:none;">
                        
							</div> 
						  </div>
						  
                          </div>
						  
                    </div>
					
					</div>
              <div class="map dir_map">
            	<div class="map_inner">
                	<!--<img src="images/map.jpg" alt="map">-->
                    <div class="img_map" id="img_map"></div>
                    
                </div>
            </div>
            
		<!--starts code for video gallery-->
		
		
<?php    

	
     if($this->branchdetails[0]->youtube_url=="") {
	 $youtube ='display:none';
	 }else{
	 $youtube ='display:block';
	 $xml = simplexml_load_file("https://www.youtube.com/oembed?url=".$this->branchdetails[0]->youtube_url."&format=xml");
	 
	}
	
	
	 if($this->branchdetails[0]->vimeo_url=="") {
	 $vimeo ='display:none';
	 }else{
	 $vimeo ='display:block';
	$xml1 = simplexml_load_file("https://vimeo.com/api/oembed.xml?url=".$this->branchdetails[0]->vimeo_url);
	}
	if($this->branchdetails[0]->dailymotion_url=="") {
	 $dailymotion ='display:none';
	 }else{
	 $dailymotion ='display:block';
	$xml2 = simplexml_load_file("https://www.dailymotion.com/services/oembed?url=".$this->branchdetails[0]->dailymotion_url."&format=xml");
	}
	if($this->branchdetails[0]->flickr_url=="") {
	 $flickr ='display:none';
	 }else{
	 $flickr ='display:block';
	$xml3 = simplexml_load_file("https://www.flickr.com/services/oembed/?url=".$this->branchdetails[0]->flickr_url."&format=xml");
			
	}
	if($this->branchdetails[0]->slideshare_url=="") {
	 $slideshare ='display:none';
	 }else{
	 $slideshare ='display:block';
	$xml4 = simplexml_load_file("https://www.slideshare.net/api/oembed/2?url=".$this->branchdetails[0]->slideshare_url."&format=xml");
		}	
    if($this->branchdetails[0]->speakerdeck_url=="") {
	 $speakerdeck='display:none';
	 }else{
	 $speakerdeck ='display:block';
	$xml5 = file_get_contents("https://speakerdeck.com/oembed.json?url=".$this->branchdetails[0]->speakerdeck_url);
	
	$data = json_decode($xml5);
	}			
?>
<?php $video_url=0;
 if($this->branchdetails[0]->youtube_url!=""||$this->branchdetails[0]->vimeo_url!=""||$this->branchdetails[0]->dailymotion_url!=""||$this->branchdetails[0]->flickr_url!=""||$this->branchdetails[0]->slideshare_url!=""||$this->branchdetails[0]->speakerdeck_url!=""){
 $video_url=1;
 }
 ?>
		<?php if($this->branchdetails[0]->store_videos == 1 && $video_url==1){?>
		<div class="jsp_videogal">
	<div class="jsp_wrap">
		<div style="font-weight:500" class="jsp_head">
        	
        </div>
	
<div class="container-ctn">
    
    <div class="row padd-10">
        <div class="col-sm-6 col-md-6" style="<?php echo $youtube; ?>">
             <div class="embed-responsive embed-responsive-16by9">
				 <!--<img src="<?php echo $xml->thumbnail_url;?>" alt="image"/>-->
                 
               
                 <a class="popup-iframe" href="<?php echo $this->branchdetails[0]->youtube_url;?>">
            		<img src="<?php echo $xml->thumbnail_url;?>" alt="image" />
					<span class="play"></span>
            	</a>
				
            </div>
            
        </div>
        
        <div class="col-sm-6 col-md-6" style="<?php echo $vimeo; ?>">
              <div class="embed-responsive embed-responsive-16by9">
                 
                 <a class="popup-iframe" href="<?php echo $this->branchdetails[0]->vimeo_url;?>">
                 	<img src="<?php echo $xml1->thumbnail_url;?>" alt="image" />
					<span class="play"></span>
                 </a>
            </div>
        </div>

        <div class="col-sm-6 col-md-6" style="<?php echo $dailymotion; ?>">
            <div class="embed-responsive embed-responsive-16by9">
                 <!--<?php echo $xml2->html;?>-->
                 <a class="popup-iframe" href="<?php echo $this->branchdetails[0]->dailymotion_url;?>">
                 	<img src="<?php echo $xml2->thumbnail_url;?>" alt="image" />
					<span class="play"></span>
                 </a>
            </div>
        </div>
    
        <div class="col-sm-6 col-md-6" style="<?php echo $slideshare; ?>">
            <div class="embed-responsive embed-responsive-16by9">
                 <?php echo $xml4->html;?>
                 <!-- <a class="popup-iframe" href="<?php echo $this->branchdetails[0]->slideshare_url;?>">
                 	<img src="<?php echo $xml4->thumbnail;?>" alt="image" />
                 </a>  -->
            </div>
        </div>
        <div class="col-sm-6 col-md-6" style="<?php echo $speakerdeck; ?>">
              <div class="embed-responsive embed-responsive-16by9">
              
                 <?php echo $data->html;?>
            </div>
        </div>
		<div class="col-sm-6 col-md-6" style="<?php echo $flickr; ?>">
              <div class="embed-responsive embed-responsive-16by9">
                 
			<!--	 <iframe src='<?php echo $this->branchdetails[0]->flickr_url;?>' frameborder='0' allowfullscreen webkitallowfullscreen mozallowfullscreen oallowfullscreen msallowfullscreen></iframe>  -->
                
				 
				 <?php echo $xml3->html;?>
            </div>
        </div>
    </div>
	
	<!--<div class="rows-container">
		<div class="cols">
			<?php echo $xml->html;?>
		</div>
		<div class="cols">
			<?php echo $xml1->html;?>
		</div>
		<div class="cols">
			<?php echo $xml2->html;?>
		</div>
	</div>-->
	
           </div>
		</div>
	</div>
</div>
<?php }?>
		<!--ends code for video gallery-->
		
        <!--starts code for home icon-->
		<div class="jsp_videogal">
	<div class="jsp_wrap">
	<div class="jsp_fullscr" style="border-top: 2px solid #d4d7d8;">
               <div class="full_left" style="margin-top:15px;">
                
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
				<div class="full_branch_list">
				   <div>
					<?php if (strpos($_SERVER['QUERY_STRING'],'tmpl=component') !== false) 
							{
							?>
					<a href="<?php echo JURI::base().'index.php?option=com_jsplocation&view=mobile&task=redirectviewbranchlist_mobile';?>&tmpl=component">Click here for full branch list</a>
					<?php    }
						  else
							{
							?>
					<a href="<?php echo JURI::base().'index.php?option=com_jsplocation&view=mobile&task=redirectviewbranchlist_mobile';?>">Click here for full branch list</a>
					<?php     } ?>    
					</div>
				</div>
                <?php if (strpos($_SERVER['QUERY_STRING'],'tmpl=component') === false) 
                        {
						
                        ?>
               <!-- <div class="prev full_right new_icon"><a target="_blank" href="<?php echo JURI::base().'index.php?option=com_jsplocation&task=videodata&id='.$store_id.'&tmpl=component'; ?>" title="<?php echo JText::_('FULLSCREEN_TITLE'); ?>" target="_blank"><?php echo JText::_('FULLSCREEN'); ?><img src="<?php echo JURI::base();?>components/com_jsplocation/images/fullscr.png"></a></div>-->
                <?php } ?>
            </div>
           
	
	</div>
		<!---->
        <div class="info_pop">
            <div class="info_pop_wrap">
                	<div class="info_pop_close"><img src="images/info_close.png"></div>
                	<div class="info_pop_title">Synergy Technology Services</div>
                    <div class="info_pop_imgs"><img src="images/1.jpg"></div>
                    <div class="info_pop_page">
                    	<div class="info_pop_pagewrap">
                        	<div class="prev"><i class="fa fa-angle-left"></i> <a href="">Previous</a></div>
                    		<div class="next active"><a href="#">Next</a><i class="fa fa-angle-right"></i></div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
.info_right_wrap { height: auto !important;}
#slider {
  position: relative;
  overflow: hidden;
  margin: 20px auto 0 auto;
  border-radius: 4px;
}

#slider ul {
  position: relative;
  margin: 0;
  padding: 0;
  /*height: 330px;*/
  list-style: none;
}

#slider ul li {
  position: relative;
  display: block;
  float: left;
  margin: 0;
  padding: 0;
  width: 500px;
  height: 417px;
  background: #fff;
  text-align: center;
  
}

span.control_prev, span.control_next {
  position: absolute;
  top: 42%;
  z-index: 999;
  display: block;
  padding: 4% 3%;
  width: auto;
  height: auto;
 /* background: #2a2a2a;*/
  color: #fff;
  text-decoration: none;
  font-weight: 600;
  font-size: 18px;
  opacity: 0.8;
  cursor: pointer;
}

span.control_prev:hover, span.control_next:hover {
  opacity: 1;
  -webkit-transition: all 0.2s ease;
}

span.control_prev {
  border-radius: 0 2px 2px 0;
}

span.control_next {
  right: 65px;
  border-radius: 2px 0 0 2px;
}

.slider_option {
  position: relative;
  margin: 10px auto;
  width: 160px;
  font-size: 18px;
}

@media screen and (max-width:768px){
	#popup-modal #content {transform:none; width: 100%; top: 15%; left: 0%; height: auto; min-height:auto; }
}

</style>
<!--<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_jsplocation/scripts/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_jsplocation/scripts/jquery.mobile-1.4.5.min.js"></script>
-->
<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_jsplocation/scripts/jQuery.js"></script>
<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_jsplocation/scripts/jQuery.equalHeights.js"></script>
<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_jsplocation/scripts/validation.js"></script>
<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_jsplocation/scripts/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_jsplocation/scripts/jquery.jpop.js"></script>



<script type="text/javascript">

	var $j = jQuery.noConflict();

	$j(document).ready(function() {
		
		$j('.popup-iframe').jPop({
				type: "iframe",
				gallery: false
			});
		
		$j(".directions").mCustomScrollbar();
		
		var alert_h = $j('.info_right').height();
		var rbl = $j('.info_right').css('padding-left').replace(/[^-\d\.]/g, '');
		$j('.info_left').height(alert_h-(Math.round(rbl)*2));
		
		$j('.view').click(function(){
			$j('.info_pop').fadeIn(300);
		});
		
		$j('.info_pop_close').click(function(){
			$j('.info_pop').fadeOut(300);
		});
		
		
		
		
		/*-----------Slider Code ----------*/
		
		
		/*-----------Swiper Code ----------*/
		$("div.info_right").on("swipeleft",function(){
		$( event.target ).addClass( "swipeleft" );
        //alert("You swiped left!");
		moveRight();
        }); 
		
		$("div.info_right").on("swiperight",function(){
		$( event.target ).addClass( "swiperight" );
        //alert("You swiped left!");
		moveLeft();
        }); 
		/*-----------Swiper Code ----------*/
		
		
	$j('#checkbox').change(function(){
    setInterval(function () {
        moveRight();
    }, 3000);
  });
  
	var slideCount = $j('#slider ul li').length;
	var slideWidth = $j('#slider ul li').width();
	
	var slideHeight = $j('#slider ul li').height();
	
	var sliderUlWidth = slideCount * slideWidth;
	
	$j('#slider').css({ width: slideWidth, height: slideHeight });
	
	$j('#slider ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });
	
    $j('#slider ul li:last-child').prependTo('#slider ul');

    function moveLeft() {
        $j('#slider ul').animate({
            left: + slideWidth
        }, 200, function () {
            $j('#slider ul li:last-child').prependTo('#slider ul');
            $j('#slider ul').css('left', '');
        });
    };

    function moveRight() {
        $j('#slider ul').animate({
            left: - slideWidth
        }, 200, function () {
            $j('#slider ul li:first-child').appendTo('#slider ul');
            $j('#slider ul').css('left', '');
        });
    };

    $j('span.control_prev').click(function () {
        moveLeft();
    });

    $j('span.control_next').click(function () {
		
        moveRight();
    });

		
		/*-----------Slider Code ----------*/
		
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
	console.log(unit);
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
							  document.getElementById('direction_description').style.display = "block";
                           // document.getElementById('side_bar').style.display = "none";
						   
						   directionsDisplay.setPanel(document.getElementById('directions'));
						   
                        }
						
						
						
		var mapOptions = {
          center: { lat: <?php echo $lat;?>, lng: <?php echo $long;?>},
          zoom: 8
        };
        var map = new google.maps.Map(document.getElementById("img_map"),mapOptions);
		var firstLatLng = new google.maps.LatLng(<?php echo $lat . ',' . $long; ?>);
		var marker = new google.maps.Marker({
			position: firstLatLng,
            map: map,
          
        });
</script>

</body>
</html>
