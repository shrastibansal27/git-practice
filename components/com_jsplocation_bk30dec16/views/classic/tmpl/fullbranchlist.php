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
$myabsoluteurl=&JURI::getInstance()->toString(array('path','query'));
$document = & JFactory::getDocument();
$document->addScript(JURI::base() . 	"components/com_jsplocation/scripts/jQuery.js");
$document->addScript(JURI::base() . 	"components/com_jsplocation/scripts/jQuery.equalHeights.js");
$document->addScript(JURI::base() . 	"components/com_jsplocation/scripts/validation.js");
$document->addScript(JURI::base() . 	"components/com_jsplocation/scripts/jquery.mCustomScrollbar.concat.min.js");
$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/style.css");
$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/bootstrap.min.css");
$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/font-awesome.min.css");
$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/jquery.mCustomScrollbar.css");

$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/responsive.css");

//$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/classic.css");
//$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/classic_jquery.mCustomScrollbar.css");
//$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/select2.css");

$sef 				= JFactory::getConfig()->get('sef', false);
$sef 				= ($sef == 0) ? $sef="&" : $sef="?";
$tmpl 				= JRequest::getVar( 'tmpl','','get' );
$tmpl 				= ($tmpl == 'component') ? $tmpl=$sef."tmpl=component" : $tmpl="";

$branchlist = $this->branchlist;

if($this->selectedcategorybranchlist == ""){

$branchlist = $this->branchlist;

}
else{

$branchlist = $this->selectedcategorybranchlist;
}


$app = JFactory::getApplication(); 
$menu = $app->getMenu();
$menuItem = $menu->getItems( 'link', 'index.php?option=com_jsplocation&view=classic', true );
//echo JRoute::_('index.php?Itemid='.$menuItem->id);


$categorylist = $this->categorylist;


?>

<script type="text/javascript">


function formsubmitfunction(){

document.getElementById("category_form").submit();

}


  (function($){
        $(window).load(function(){
           // $(".info_wrap1").mCustomScrollbar();
        });
    })(jQuery);
</script>

</head>

<body>

<div class="jsp_main">
	<div class="jsp_wrap">
    	<div class="jsp_head">
        	<div class="jsp_info_titlewrap">
        		<div class="list_title" style="font-weight:500;">
                    Complete Branch List 
                </div>
                <div class="country">
				
				
				
				
				
				
				
				
				<?php if (strpos($_SERVER['QUERY_STRING'],'tmpl=component') !== false) 
                        {
                        
                $submitUrl = JURI::base().'index.php?option=com_jsplocation&view=classic&task=redirectviewbranchlist&tmpl=component';
                    }
                      else
                        {
                        
               $submitUrl = JURI::base().'index.php?option=com_jsplocation&view=classic&task=redirectviewbranchlist';
                    } 
				?>
				
				
				
				
				<form action="<?php echo $submitUrl;?>" method="post" name="category_form" id="category_form" onchange="return formsubmitfunction();">
				
                    <select name="category" id="category" class="selectpicker form-control">
                       
                        <option value="CAT">Choose a category</option>
                        <?php
                         
                        
                        
                        for($i=0;$i<count($categorylist);$i++){
                        if($categorylist[$i]->title == $this->Category_Selected){
                        ?>
                        
                        <option selected>
                        <?php
                        echo $categorylist[$i]->title;
                        ?>
                         </option>
                        <?php
                        }
                        else{
                        ?>
                        
            
                        <option>
                        <?php
                        echo $categorylist[$i]->title;
                        ?>
                         </option>
                        
                        <?php
                        }
                        }
                        ?>
                        
                      
                       
                   </select>
					<input type="hidden" name="option" value="com_jsplocation" />
					<input type="hidden" name="task" value="redirectviewbranchlist" />
				</form>	
					
                </div>    
            </div>
        </div>
        
        <div class="info_body">
        	<div class="info_wrap">
            <div class="info_wrap1 mCustomScrollbar">
            	<div class="list_left">
                	<div class="list_info">
                       <p class="list_info_title">Branch List</p>
                        
                        <?php 
						
						echo '<div class="row">';
						
                        for($i=0,$k=1;$k<=count($branchlist);$i++,$k++){
						
						echo '<div class="col-md-3">';
                        
                        $branchid = $branchlist[$i]['id'];
                        $branchname = $branchlist[$i]['branchname'];
                        $cityname = $branchlist[$i]['cityname'][0]->title;
                        $countryname = $branchlist[$i]['countryname'][0]->title;
						
						
						
						
						if($branchid == ""){
						
						break;
						
						}
                        
                         if (strpos($_SERVER['QUERY_STRING'],'tmpl=component') !== false) 
                        {
                        ?>
                
                        <a href="<?php echo JURI::base().'index.php?option=com_jsplocation&view=classic&task=redirectviewinfo&id='.$branchid;?>&tmpl=component"><?php echo $branchname;?></a><?php echo ' - '.$cityname.', '.$countryname; ?> 
                        <?php    }
                      else
                        {
                        ?>
                         <a href="<?php echo JURI::base().'index.php?option=com_jsplocation&view=classic&task=redirectviewinfo&id='.$branchid;?>"><?php echo $branchname;?></a><?php echo ' - '.$cityname.', '.$countryname; ?> 
                        <?php     }
						
						echo '</div>';
						
						if($k%4 == 0){                        
						echo '</div></br><div class="row">';
						}
						
                        }
                        
                        ?>
                        
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
                <div class="prev full_right_lastpage"><a target="_blank" href="<?php echo JRoute::_('index.php?option=com_jsplocation&view=classic&task=redirectviewbranchlist&tmpl=component');?>">Fullscreen<img src="images/jsplocationimages/fullscr.png"></a></div>
                <?php     } ?>
           </div>
         </div>  
        </div>
        
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		var alert_h = $('.info_right').height();
		var rbl = $('.info_right').css('padding-left').replace(/[^-\d\.]/g, '');
		$('.info_left').height(alert_h-(Math.round(rbl)*2));
		
		$('.view').click(function(){
			$('.info_pop').fadeIn(300);
		});
		
		$('.info_pop_close').click(function(){
			$('.info_pop').fadeOut(300);
		});
	});
</script>

</body>
</html>
