<?php 
/**
 * jSecure Authentication components for Joomla!
 * jSecure Authentication extention prevents access to administration (back end)
 * login page without appropriate access key.
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     jSecure3.5
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default.php  $
 */
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
include JPATH_COMPONENT_ADMINISTRATOR.'/'.'helpers'.'/'.'jsecureadminmenu.php';
JHtml::_('behavior.framework', true);
JHTML::_('script','system/modal.js', false, true);
JHTML::_('stylesheet','system/modal.css', array(), true);
//JsecureAdminMenuHelper::addSubmenu('auth');
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
		window.onload = function(){showUpdates();}
");
$document->addCustomTag('<script language="javascript" type="text/javascript" src="components/com_jsecure/js/auth.js"></script>');
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsecure/css/styles.css" />');
$JSecureConfig = $this->JSecureConfig;
?>
<script type="text/javascript">
function show_confirm()
{
<?php
if(!($JSecureConfig->enableMasterPassword == '1' and !jsecureControllerjsecure::isMasterLogged() and $JSecureConfig->include_purgesessions == '1'))
{
?>
  if(confirm("<?php echo JText::_('CONFIRM_PURGE_SESSION'); ?>"))
	  return true;
  else
	  return false;
<?php
}
else
	{?>
	alert("Please enter master password");
	return false;
<?php }
?>	  
}
</script>
<?php
if($JSecureConfig->enableMasterPassword == '1' and !jsecureControllerjsecure::isMasterLogged())
{
?>
<form action="index.php" method="post" name="adminForm" autocomplete="off" class="masterpassfrm">
	<table class="adminlist" cellspacing="0" style="border-spacing:0">
		<tr>
			<td width="105"><?php echo JText::_('MASTER_PASSWORD'); ?></td>
			<td><input type="password" name="master_password" class="textarea" value="" size="50" /></td>
		</tr>
		<tr>
        	<td></td>
			<td><input type="submit" name="" value="<?php echo JText::_('JSECURE_LOGIN'); ?>" /></td>
		</tr>
	</table>
	
	<?php echo JHTML::_( 'form.token' ); ?>
	<input type="hidden" name="option" value="com_jsecure" />
	<input type="hidden" name="task" value="login" />
	<input type="hidden" name="view" value="auth" />
</form>
<?php
}
?>
<div class="row-fluid" style="margin-top:20px">
<div class=""><?php JsecureAdminMenuHelper::addSubmenu(''); ?></div>
<div class="span4">
<table class="adminform" style="width:100%">
  <tbody>
    <tr>
     <td>
     <div class="row-fluid">
    
		<div class="well well-small">
		<div class="module-title nav-header"><?php echo JText::_('SECURITY'); ?></div>
			<div class="row-striped">
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=basic" title="<?php echo JText::_('BASIC_DESCRIPTION'); ?>"><img src="components/com_jsecure/images/bc-icon.png" border="0" />&nbsp;<span><?php echo JText::_( 'COM_JSECURE_BASIC' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=whois" title="<?php echo JText::_('WHOIS'); ?>"><img src="components/com_jsecure/images/email-scan.png" border="0" />&nbsp;<span><?php echo JText::_( 'COM_JSECURE_WHOIS' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=emailcheck" title="<?php echo JText::_('EMAIL_CHECK'); ?>"><img src="components/com_jsecure/images/email-scan.png" border="0" />&nbsp;<span><?php echo JText::_( 'COM_JSECURE_EMAIL_CHECK' ); ?></span></a></div></div>				
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=imageSecure" title="<?php echo JText::_('IMAGE_SECURE_DESCRIPTION'); ?>"><img src="components/com_jsecure/images/image_secure.png" border="0" />&nbsp;<span><?php echo JText::_( 'COM_JSECURE_IMAGE_SECURE' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=userkey" title="<?php echo JText::_('USERKEY_DESCRIPTION'); ?>"><img src="components/com_jsecure/images/user_key.png" border="0" />&nbsp;<span><?php echo JText::_( 'COM_JSECURE_USERKEY' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=countryblock" title="<?php echo JText::_('COUNTRY_BLOCK_DESCRIPTION'); ?>"><img src="components/com_jsecure/images/country_block.png" border="0" />&nbsp;<span><?php echo JText::_( 'COM_JSECURE_COUNTRY_BLOCK' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=ip" title="<?php echo JText::_('IP_DESC'); ?>"><img src="components/com_jsecure/images/ip-icon.png" border="0"/>&nbsp;<span><?php echo JText::_( 'IP_CONFIG' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=masterpwd" title="<?php echo JText::_('MP_DESC'); ?>"><img src="components/com_jsecure/images/mp-icon.png" border="0"/>&nbsp;<span><?php echo JText::_( 'MASTER_PASSWORD' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=logincontrol" title="<?php echo JText::_('MLC_DESC'); ?>"><img src="components/com_jsecure/images/mlc-icon.png" border="0"/>&nbsp;<span><?php echo JText::_( 'LOGIN_CONTROL' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=pwdprotect" title="<?php echo JText::_('PPWD_DESC'); ?>"><img src="components/com_jsecure/images/app-icon.png" border="0"/>&nbsp;<span><?php echo JText::_( 'ADMIN_PASSWORD_PROT' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=directory" title="<?php echo JText::_('DIR_DESC'); ?>"><img src="components/com_jsecure/images/dl-icon.png" border="0"/>&nbsp;<span><?php echo JText::_( 'COM_JSECURE_DIRECTORIES' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=comprotect" title="<?php echo JText::_('COMP_PROTECT'); ?>"><img src="components/com_jsecure/images/cp-icon.png" border="0"/>&nbsp;<span><?php echo JText::_( 'COM_JSECURE_PROTECT' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=autoban" title="<?php echo JText::_('COM_JSECURE_AUTOBAN_DESC'); ?>"><img src="components/com_jsecure/images/mp-icon.png" border="0"/>&nbsp;<span><?php echo JText::_( 'COM_JSECURE_AUTOBAN' ); ?></span></a></div></div>
			</div>	
	</div>
	
    </div>
    <div class="row-fluid">
		
			<div class="well well-small">
		<div class="module-title nav-header"><?php echo JText::_('TOOLS'); ?></div>
			<div class="row-striped">
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=mail" title="<?php echo JText::_('MAIL_DESC'); ?>"><img src="components/com_jsecure/images/m-icon.png" border="0" />&nbsp;<span><?php echo JText::_( 'MAIL_CONFIG' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=mastermail" title="<?php echo JText::_('MMAIL_DESC'); ?>"><img src="components/com_jsecure/images/mm-icon.png" border="0"/>&nbsp;<span><?php echo JText::_( 'EMAIL_MASTER' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=keeplog" title="<?php echo JText::_('KLOG_DESC'); ?>"><img src="components/com_jsecure/images/l-icon.png" border="0"/>&nbsp;<span><?php echo JText::_( 'LOG' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=log" title="<?php echo JText::_('LOG_DESC'); ?>"><img src="components/com_jsecure/images/vl-icon.png" border="0"/>&nbsp;<span><?php echo JText::_( 'COM_JSECURE_LOG' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=metatags" title="<?php echo JText::_('MT_DESC'); ?>"><img src="components/com_jsecure/images/mtc-icon.png" border="0"/>&nbsp;<span><?php echo JText::_( 'META_TAG_CONTROL' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=purgesessions" onclick="return show_confirm();" title="<?php echo JText::_('PS_DESC'); ?>"><img src="components/com_jsecure/images/ps-icon.png" border="0"/>&nbsp;<span><?php echo JText::_( 'PURGE_SESSION' ); ?></span></a></div></div>
				<div class="row-striped">
                    <div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=graph" title="<?php echo JText::_('HIT_GRAPH_DESC'); ?>"><img src="components/com_jsecure/images/hg-icon.png" border="0" />&nbsp;<span><?php echo JText::_( 'HIT_GRAPH' ); ?></span></a></div></div>
                </div>
			</div>	
	</div>
		
	</div>
    <div class="row-fluid">
   	 
        <div class="well well-small">
            <div class="module-title nav-header"><?php echo JText::_('HELP'); ?></div>
                <div class="row-striped">
                    <div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsecure&task=help" title="<?php echo JText::_('HELP'); ?>"><img src="components/com_jsecure/images/h-icon.png" border="0" />&nbsp;<span><?php echo JText::_( 'COM_JSECURE_HELP' ); ?></span></a></div></div>
                </div>	
				
        </div>
		 

     </div>

</td>
         
          
          </tr>
        </table>
</div>
<div class="span4">
<table cellpadding="4" cellspacing="0" border="1" class="adminform">
			
			<tr class="row0">
				<th colspan="2"  style="background-color:#FFF;">
						<div style="float:left;">
						<a href="http://www.joomlaserviceprovider.com" title="Joomla Service Provider" target="_blank"><img src="components/com_jsecure/images/logo.jpg" alt="Joomla Service Provider" border="none"/></a></div>
						<div style="text-align:center;margin-top:25px;"><h3><?php echo JText::_( 'jSecure Authentication' ); ?></h3></div>
						
				</th>
			</tr>
			<tr class="row1">
				<td width="100"><?php echo JText::_( 'VERSION_TEXT' ); ?></td>
				<td><?php echo JText::_( 'VERSION_DESCRIPTION' ); ?></td>
			</tr>
			<tr class="row2">
				<td><?php echo JText::_( 'SUPPORT' ); ?></td>
				<td><a href="http://www.joomlaserviceprovider.com/component/kunena/5-jsecure-authentication.html" target="_blank"><?php echo JText::_( 'JSECURE_AUTHENTICATION_FORUM' ); ?></a></td>
			</tr>
			<tr>
          <td><?php echo JText::_( 'UPDATES' ); ?></td>
         <td>
		 	<div id="image" name="image"><img src="components/com_jsecure/images/sh-ajax-loader-wide.gif" /></div>
		 	<div id="version"></div>
		  	<button id="chkupdates" class="btn btn-small" onclick="showUpdates();" href="#">Check For Update</button>	 
		</td>
        </tr>
		
		<tr id="show_notes">
          <td><?php echo JText::_( 'NOTES' ); ?></td>
          <td><div id="notes"></div></td>
        </tr>
		</table>
</div>



<!-- Test Graph on component's landing page-->
<script type="text/javascript" src="https://www.google.com/jsapi">
</script>
<?php

$document = & JFactory::getDocument();
$date_week = date ( "Y-m-d", strtotime ( '-6 day') ); 
$db = JFactory::getDbO();
//print_r($db);die;
$qry1 =  "SELECT `date`,`incorrect_hits`,`correct_hits`  FROM `#__jsecure_hits`  where `date` >= '$date_week' GROUP BY `date` order by date desc ";
$db->setQuery($qry1);
$db->query();
$num_rows1 = $db->getNumRows();

$results1 = $db->loadObjectList();
$i=0;
foreach($results1 as $items){
   $rd1[$i] = $items ;
   $i++;
   }
  
   if(isset($rd1) == true)
   { 
      echo "<SCRIPT type='text/javascript' >";
        echo " function drawChart() {
	  var data = google.visualization.arrayToDataTable([	  ['Date', 'Correct Hits','Wrong Hits']" ;
      for($i=0; $i<count($rd1); $i++)
       {
          $wh=$rd1[$i]->incorrect_hits;
		  $ch=$rd1[$i]->correct_hits;
		  $d=$rd1[$i]->date;
          echo ",[ '$d' , $ch , $wh]";
       }
      echo "]);
	  w = document.documentElement.clientWidth;
      h = document.documentElement.clientHeight;
      var nw = (0.38 * w);
      var nh = (0.65 *h);
	  var options = {
	  align: 'center',
          title: 'Daily Graph',
		  vAxis: {title: 'Hits',  titleTextStyle: {color: 'red'}},
          hAxis: {title: 'Last Seven Days',  titleTextStyle: {color: 'red'}},
		  'width':nw,
         'height':nh,
		 isHtml:true
        };
		 new google.visualization.ColumnChart(document.getElementById('chartdiv1')).
          draw(data, options);
      }
      

      google.setOnLoadCallback(drawChart);

		</SCRIPT>";
  }
?>

<div style="border: 1px solid #cccccc;
    display: block;
    float: left;
   /* height: 396px; */
	height:auto;
    margin: 17px 0 0 15px;
    padding: 12px;
    position: relative;
    width: 503px;">

<form action="index.php?option=com_jsecure" method="post" name="adminForm" id="adminForm">
<!-- start for today -->
 
    <script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});  //atleast required once to load google chart packages
		  //calling chart function to build the graph
	</script>
	
		<div id="infodiv1"><?php //echo JText::_('DAILY_DESC'); ?></div>
	  <div id="chartdiv1">
	  	<?php if($num_rows1 < 1)
		{
				echo '<div class="notification">'.JText::_("NO_HITS").'</div>';
		}
		?>
	  </div> <!--the daily graph container-->

<!-- end for today -->

<!-- start for for weekly  -->
<?php
$date_week = date("Y-m-d",strtotime("-1 week"));
$cur_month = date('m');
$cur_year = date('Y');
$qry2 = "SELECT date,SUM(incorrect_hits) as incorrect_hits,SUM(correct_hits) as correct_hits,
            DATE_ADD(date, INTERVAL(1-DAYOFWEEK(date)) DAY) as startdate,
            DATE_ADD(date, INTERVAL(7-DAYOFWEEK(date)) DAY) as enddate
            FROM `#__jsecure_hits`  
			WHERE MONTH(date) = '$cur_month' AND YEAR(date) = '$cur_year' 
			GROUP BY WEEK(date) "; 
$db->setQuery($qry2);
$db->query();
$num_rows2 = $db->getNumRows();

$results2 = $db->loadObjectList();
$i=0;
foreach($results2 as $items){
   $rd2[$i] = $items ;
   $i++;
   }
   if(isset($rd2) == true)
   { 
      $first_day_this_month = date('Y-m-01'); 
      $last_day_this_month = date('Y-m-t');
      echo "<SCRIPT type='text/javascript' >";
      echo " function drawChart2() {
	  var data2 = google.visualization.arrayToDataTable([	  ['Date', 'Correct Hits','Wrong Hits']" ;
	  for($i=0;$i<count($rd2);$i++)
       {
          $wh=$rd2[$i]->incorrect_hits;
		  $ch=$rd2[$i]->correct_hits;
		  $d = $rd2[$i]->date;
		  $ldate=$rd2[$i]->enddate;
		  $sdate=$rd2[$i]->startdate;

		  $l=date('d',strtotime($ldate));
		  $s=date('d',strtotime($sdate));

		  if($first_day_this_month>$sdate)
		   {
             $sdate = $first_day_this_month;
		   }
          	   
	
	   echo ",[ 'Week:".($i+1).'\n'."-  From: ".$s.'\n To: '.$l."' , $ch , $wh ]";
	   }
	   $vp='Weekly Graph for '.date('M-Y');
      echo "]);
	  w = document.documentElement.clientWidth;
      h = document.documentElement.clientHeight;
      var nw = (0.38 * w);
      var nh = (0.65 *h);
	     var options2 = {
          title: '$vp',
		  vAxis: {title: 'Hits',  titleTextStyle: {color: 'red'}},
          hAxis: {title: 'Weeks this Month',  titleTextStyle: {color: 'red'}},
		  'width':nw,
          'height':nh
        };
        var chart2 = new google.visualization.ColumnChart(document.getElementById('chartdiv2'));
        chart2.draw(data2, options2); }
		google.setOnLoadCallback(drawChart2);
		</SCRIPT>";     //options2 to set chart properties eg: isStacked to adjust the labels to multiline
  }
?>
    <div id="infodiv2"><?php //echo JText::_('WEEKLY_DESC'); ?></div>
    <div id="chartdiv2"
	>
		<?php if($num_rows2 < 1)
		{
				echo '<div class="notification">'.JText::_("NO_HITS").'</div>';
		}
		?>
	</div>  <!-- the weekly graph container-->

<!-- end for for weekly  -->

<!-- start for for monthly -->
<?php
$qry3 =  "SELECT `date`,SUM(incorrect_hits) as incorrect_hits, SUM(correct_hits) as correct_hits  
            FROM `#__jsecure_hits` 
			GROUP BY MONTH(date),YEAR(date) 
			ORDER BY date desc LIMIT 0,12";
$db->setQuery($qry3);
$db->query();
$num_rows3 = $db->getNumRows();

$results3 = $db->loadObjectList();
$i=0;
foreach($results3 as $items){
   $rd3[$i] = $items ;
   $i++;
   }
   if(isset($rd3) == true)
   { 
      echo "<SCRIPT type='text/javascript' >";
      echo " function drawChart3() {
	  var data3 = google.visualization.arrayToDataTable([	  ['Date', 'Correct Hits','Wrong Hits']" ;
	  for($i=0; $i<count($rd3); $i++)
       {
          $wh=$rd3[$i]->incorrect_hits;
		  $ch=$rd3[$i]->correct_hits;
		  $d=$rd3[$i]->date;
          $month = date('M',strtotime($d));
		  $year = date('Y',strtotime($d));
		  $dat = $year.'-'.$month;
          echo ",[  '$dat' , $ch , $wh]";
       }
      echo "]);
	  w = document.documentElement.clientWidth;
      h = document.documentElement.clientHeight;
      var nw = (0.38 * w);
      var nh = (0.65 *h);
	  var options3 = {
          title: 'Monthly Graph',
		  vAxis: {title: 'Hits',  titleTextStyle: {color: 'red'}},
          hAxis: {title: 'Last Twelve Months',  titleTextStyle: {color: 'red'}},
		  'width':nw,
          'height':nh,
		  isHtml:true
		};

        var chart3 = new google.visualization.ColumnChart(document.getElementById('chartdiv3'));
        chart3.draw(data3, options3); }
		google.setOnLoadCallback(drawChart3);
		</SCRIPT>";      // chartName eg:chart3 to set the graph container
  }
  else
  {
  }
?>
    <div id="infodiv3"><?php //echo JText::_('MONTHLY_DESC'); ?></div>
	<div id="chartdiv3" 
	>
		<?php if($num_rows3 < 1)
		{
				echo '<div class="notification">'.JText::_("NO_HITS").'</div>';
		}
		?>
	</div>   <!-- the monthly graph container-->
		 

<input type="hidden" name="option" value="com_jsecure" />
<input type="hidden" name="task" value="" />
</form>
  <div id="button" style="float: right;margin-right: 153px;">
   <!--Records In Time Period : -->
         <button class="btn btn-small" name="btdaily" value="Daily" onclick="showDaily();">Daily</button>
		 <button class="btn btn-small" name="btweekly" value="Weekly" onclick="showWeekly();">Weekly</button>
		 <button class="btn btn-small" name="btmonthly" value="Monthly" onclick="showMonthly();">Monthly</button>
   </div>
 
 
<!-- display button -->
   </div>
 
   
 </div>
   <script type="text/javascript">
   function showDaily()
		  { 
		    document.getElementById("chartdiv1").style.display="block";
			document.getElementById("chartdiv2").style.display="none";
			document.getElementById("chartdiv3").style.display="none";
			document.getElementById("infodiv1").style.display="block";
			document.getElementById("infodiv2").style.display="none";
			document.getElementById("infodiv3").style.display="none";
		  }
		  function showWeekly()
		  {
		    document.getElementById("chartdiv1").style.display="none";
			document.getElementById("chartdiv2").style.display="block";
			document.getElementById("chartdiv3").style.display="none";
			document.getElementById("infodiv1").style.display="none";
			document.getElementById("infodiv2").style.display="block";
			document.getElementById("infodiv3").style.display="none";
		  }
		  function showMonthly()
		  {
		    document.getElementById("chartdiv1").style.display="none";
			document.getElementById("chartdiv2").style.display="none";
			document.getElementById("chartdiv3").style.display="block";
			document.getElementById("infodiv1").style.display="none";
			document.getElementById("infodiv2").style.display="none";
			document.getElementById("infodiv3").style.display="block";
		  }		  
 showMonthly();
 </script>
 