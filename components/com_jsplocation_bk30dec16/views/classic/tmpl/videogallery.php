<!doctype html>
<html>
<head>
<meta charset="utf-8">
<?php

header('Access-Control-Allow-Origin: *');

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

$myabsoluteurl=JURI::getInstance()->toString(array('path','query'));
$document =  JFactory::getDocument();
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


$store_id=JRequest::getVar('id');



$branchdetails = $this->branchdetails;

$branchname = $this->branchdetails[0]->branch_name;
$app = JFactory::getApplication(); 
$menu = $app->getMenu();
$menuItem = $menu->getItems( 'link', 'index.php?option=com_jsplocation&view=classic', true );

?>


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
</head>
<body>
<div class="jsp_main videogal">
	<div class="jsp_wrap">
		<div style="font-weight:500" class="jsp_head">
        	<div class="info_title"><?php echo $branchname;?> Videos</div>
        </div>
	
<div class="container">
    
    <div class="row padd-10">
        <div class="col-sm-4 col-md-4" style="<?php echo $youtube; ?>">
             <div class="embed-responsive embed-responsive-16by9">
                 <?php echo $xml->html;?>
				 <span class="play"></span>
            </div>
        </div>
        <div class="col-sm-4 col-md-4" style="<?php echo $vimeo; ?>">
              <div class="embed-responsive embed-responsive-16by9">
                 <?php echo $xml1->html;?>
				 <span class="play"></span>
            </div>
        </div>
        <div class="col-sm-4 col-md-4" style="<?php echo $dailymotion; ?>">
            <div class="embed-responsive embed-responsive-16by9">
                 <?php echo $xml2->html;?>
				 <span class="play"></span>
            </div>
        </div>
    
        
        <div class="col-sm-4 col-md-4" style="<?php echo $slideshare; ?>">
            <div class="embed-responsive embed-responsive-16by9">
                 <?php echo $xml4->html;?>
            </div>
        </div>
        <div class="col-sm-4 col-md-4" style="<?php echo $speakerdeck; ?>">
              <div class="embed-responsive embed-responsive-16by9">
                 <?php echo $data->html;?>
            </div>
        </div>
		<div class="col-sm-4 col-md-4" style="<?php echo $flickr; ?>">
              <div class="embed-responsive embed-responsive-16by9">
                 
				 <iframe src='<?php echo $this->branchdetails[0]->flickr_url;?>' frameborder='0' allowfullscreen webkitallowfullscreen mozallowfullscreen oallowfullscreen msallowfullscreen></iframe>
				 
				 <?php //echo $xml3->html;?>
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
	
	
   
	<div class="jsp_fullscr" style="border-top: 2px solid #d4d7d8;">
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
                <div class="prev full_right new_icon"><a target="_blank" href="<?php echo JURI::base().'index.php?option=com_jsplocation&task=videodata&id='.$store_id.'&tmpl=component'; ?>" title="<?php echo JText::_('FULLSCREEN_TITLE'); ?>" target="_blank"><?php echo JText::_('FULLSCREEN'); ?><img src="<?php echo JURI::base();?>components/com_jsplocation/images/fullscr.png"></a></div>
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
</div>

</body>
</html>
