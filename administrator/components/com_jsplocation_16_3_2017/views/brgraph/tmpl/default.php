<style>
.notification {
font-size:18px;
color:blue;
display:block;
line-height:300px;
}
</style>

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		if($("#visualization").text() == 0) {
			$("#visualization").html("<span class='notification'>No Hits Found Today</span>");
		}
	});
	$(document).ready(function() {
		if($("#chartdiv2").text() == 0) {
			$("#chartdiv2").html("<span class='notification'>No Hits Found This Month</span>");
		}
	});
	$(document).ready(function() {
		if($("#chartdiv3").text() == 0) {
			$("#chartdiv3").html("<span class='notification'>No Hits Found</span>");
		}
	});
</script>
<?php 
/**
 * JSP Location components for Joomla!
 * JSP Location extention  
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default.php  $
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$document =  JFactory::getDocument();
$todaydate = date("Y-m-d");
 $date=date("Y-m-d",strtotime("-1 week"));
 $dayhits[0][0] = "'".'Branch hits'."'";
 $dayhits[1][0] = "'".''."'";
 $db = JFactory::getDbO();
$values =  "SELECT `branch`,sum(hits) as `sum`,`date` FROM `#__jsplocation_branchhits` WHERE `date` >=  '$date' GROUP BY `branch` ORDER BY `branch` desc";
$db->setQuery($values);
$results = $db->loadObjectList();
 $i=0;
foreach($results as $items){
   $rd[$i] = $items ;
   $i++;
   }

   $bridqry = "SELECT `branch`,sum(hits) as `sum`,`date` FROM `#__jsplocation_branchhits` WHERE `date` >=  '$date' GROUP BY `branch` ORDER BY `branch` desc";
$db->setQuery($bridqry);
$brids = $db->loadObjectList();
$j=1;
//$week[0][0] = "'".'Zip hits'."'";
foreach($brids as $bid){
$id = $bid->branch;
$bnqry=  "SELECT `branch_name` FROM `#__jsplocation_branch` WHERE `id` =  '$id' ";
$db->setQuery($bnqry);
$brname = $db->loadObjectlist();
    $dayhits[0][$j] = "'".$brname[0]->branch_name."'";
	$dayhits[1][$j] = $bid->sum;
	$j++;
}
   if( isset($rd) == true)
   {
 ?>
 <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['imagechart']});
    </script>
   
<?php
          echo "<script type='text/javascript'>";
		echo " function drawVisualization() {
	 var data = google.visualization.arrayToDataTable([";
      for($i=0;$i<=1;$i++)
       {
          echo "[";
          for($j=0;$j<=count($brids);$j++)
		   {
			  
              $value = $dayhits[$i][$j];
              echo "$value".",";
			 
		   }
           echo "],";
	   }
	    echo "]);
      w = document.documentElement.clientWidth;
      h = document.documentElement.clientHeight;
      var nw = (0.72 * w);
      var nh = (0.65 *h);
       // Create and draw the visualization.
        new google.visualization.ColumnChart(document.getElementById('visualization')).
            draw(data,
                 {title:'Daily Graph',
                   width:nw, height:nh,
                  hAxis: {title: 'From:$date - To:$todaydate'},
                  vAxis: {title: 'Hits', titleTextStyle: {color: 'red'}}
                 }
            );
      }
      

      google.setOnLoadCallback(drawVisualization);
    </script>";
  }
  else
  { 
  } 
?>

<script type="text/javascript" src="https://www.google.com/jsapi">
</script>

<form action="index.php?option=com_jsplocation" method="post" name="adminForm" id="adminForm">
<!-- start for today -->
 
	  <!--<div id="chartdiv1"> </div>  the daily graph container-->
	  <div id="infodiv1" ><?php echo JText::_('DAILY_BRANCH_DESC'); ?></div>
	   <div id="visualization" style="width: 1000px; height: 500px;"></div>

<!-- end for today -->






<!-- start for for weekly  -->
<?php
$hits = -1;
$date_week = date("Y-m-d",strtotime("-1 week"));
$cur_month = date('m');
$cur_year = date('Y');
$qry2 = "SELECT date,SUM(hits) as total_hits,
            DATE_ADD(date, INTERVAL(1-DAYOFWEEK(date)) DAY) as startdate,
            DATE_ADD(date, INTERVAL(7-DAYOFWEEK(date)) DAY) as enddate
            FROM `#__jsplocation_branchhits`  
			WHERE MONTH(date) = '$cur_month' AND YEAR(date) = '$cur_year' 
			GROUP BY WEEK(date) "; 
$db->setQuery($qry2);
$results2 = $db->loadObjectList();
$bridqry = "SELECT id,branch_name FROM `#__jsplocation_branch` WHERE `published` = 1";
$db->setQuery($bridqry);
$brids = $db->loadObjectList();
$j=1;
$week[0][0] = "'".'Date'."'";
foreach($brids as $bid){
    $week[0][$j] = "'".$bid->branch_name."'";
	$j++;
}
$i=0;
foreach($brids as $bid){
	$cur_id = $bid->id; 
	$bhqry = "SELECT date,SUM(hits) as total_hits,
            DATE_ADD(date, INTERVAL(1-DAYOFWEEK(date)) DAY) as startdate,
            DATE_ADD(date, INTERVAL(7-DAYOFWEEK(date)) DAY) as enddate
            FROM `#__jsplocation_branchhits`  
			WHERE MONTH(date) = '$cur_month' AND YEAR(date) = '$cur_year' AND branch = '$cur_id'
			GROUP BY WEEK(date) "; 
    $db->setQuery($bhqry);
    $bhhits[$cur_id] = $db->loadObjectList();

   $i++;
   }

   $i=0;
   
foreach($results2 as $items){
	$k=0;
   $rd2[$i+1] = $items ;
   $ldate=date('d',strtotime($rd2[$i+1]->enddate));
   $sdate=date('d',strtotime($rd2[$i+1]->startdate));
   $num = $i+1;
   $week[$i+1] [$k]= "'".'Week:'.$num.'-From:'.$sdate.' To '.$ldate."'";
   foreach($brids as $bid){
	   $br_id = $bid->id;
	   foreach($bhhits[$br_id] as $bhits)
	   {
		   if($rd2[$i+1]->startdate == $bhits->startdate)
		   {
		   $hits = $bhits->total_hits;
           $k++;
		   }
	  }
	  if($hits == -1)
	   {
       $hits = 0;
	   $k++;
	   }
	  $week[$i+1] [$k]= $hits;
      $hits = -1;

	  
   }
   $i++;
   }
   if(isset($rd2) == true)
   { 
      $first_day_this_month = date('Y-m-01'); 
      $last_day_this_month = date('Y-m-t');
	  ?>

	  <script type="text/javascript" src="http://www.google.com/jsapi"></script>
	  <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
	<?php
      echo "<script type='text/javascript' >";
      echo " function drawchart2(){
	   var data = google.visualization.arrayToDataTable([" ;
	  for($i=0;$i<=count($rd2);$i++)
       {
          echo "[";
          for($j=0;$j<=count($brids);$j++)
		   {
			  
              $value = $week[$i][$j];
              echo "$value".",";
			 
		   }
           echo "],";
	   }
	   $vp='Weekly Graph for '.date('M-Y');
      echo "]);
	  w = document.documentElement.clientWidth;
      h = document.documentElement.clientHeight;
      var nw = (0.72 * w);
      var nh = (0.65 *h);
	  
	 new google.visualization.ColumnChart(document.getElementById('chartdiv2')).
            draw(data,
                 {title:'$vp',
                  'isStacked': true,
                  width:nw, height:nh,
                  vAxis: {title: 'Hits'}}
            );
      }
	  google.setOnLoadCallback(drawchart2);
		</script>";     //options2 to set chart properties eg: isStacked to adjust the labels to multiline
  }
  else
  {
   //echo "Sorry no Hits for this week";
  } 
?>
 <script type="text/javascript">
         //google.setOnLoadCallback(drawChart2);
 </script>
    <div id="infodiv2"><?php echo JText::_('WEEKLY_BRANCH_DESC'); ?></div>
    <div id="chartdiv2" style="width: 1000px; height: 500px;"> </div>  <!-- the weekly graph container-->

<!-- end for for weekly  -->











<!-- start for for monthly -->
<?php
$hits=-1;
$date_week = date("Y-m-d",strtotime("-1 week"));
$cur_month = date('m');
$cur_year = date('Y');
$qry2 = "SELECT `date`,SUM(hits) as total_hits  
            FROM `#__jsplocation_branchhits` 
			GROUP BY MONTH(date),YEAR(date) 
			ORDER BY date desc LIMIT 0,12 "; 
$db->setQuery($qry2);
$results2 = $db->loadObjectList();
$bridqry = "SELECT id,branch_name FROM `#__jsplocation_branch` WHERE `published` = 1";
$db->setQuery($bridqry);
$brids = $db->loadObjectList();
$j=1;
$monthlyhits[0][0] = "'".'Date'."'";
foreach($brids as $bid){
    $monthlyhits[0][$j] = "'".$bid->branch_name."'";
	$j++;
}
$i=0;
foreach($brids as $bid){
	$cur_id = $bid->id; 
	$bhqry = "SELECT `date`,SUM(hits) as total_hits  
            FROM `#__jsplocation_branchhits` 
			WHERE branch = '$cur_id' 
			GROUP BY MONTH(date),YEAR(date) 
			ORDER BY date desc LIMIT 0,12"; 
    $db->setQuery($bhqry);
	$test = $db->loadObjectList();
    $bhhits[$cur_id] = $db->loadObjectList();

   $i++;
   }

   $i=0;
   
foreach($results2 as $items){
	$k=0;
   $rd3[$i+1] = $items ;
   $d=$rd3[$i+1]->date;
          $month = date('M',strtotime($d));
		  $year = date('Y',strtotime($d));
		  $dat = $year.'-'.$month;
   $num = $i+1;
   $monthlyhits[$i+1] [$k]= "'".$dat."'";
   foreach($brids as $bid){
	   $br_id = $bid->id;
	   foreach($bhhits[$br_id] as $bhits)
	   {
		  $f=$bhits->date;
          $monthf = date('M',strtotime($f));
		  $yearf = date('Y',strtotime($f));
		  $datf = $yearf.'-'.$monthf;
		   if($dat == $datf)
		   {
		   $hits = $bhits->total_hits;
           $k++;
		   }
	  }
	  if($hits == -1)
	   {
       $hits = 0;
	   $k++;
	   }
	  $monthlyhits[$i+1] [$k]= $hits;
      $hits = -1;

	  
   }
   $i++;
   }

   if(isset($rd3) == true)
   { 
      $first_day_this_month = date('Y-m-01'); 
      $last_day_this_month = date('Y-m-t');
	  ?>

	  <script type="text/javascript" src="http://www.google.com/jsapi"></script>
	  <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
	<?php
      echo "<script type='text/javascript' >";
      echo " function drawchart2(){
	   var data = google.visualization.arrayToDataTable([" ;
	  for($i=0;$i<=count($rd3);$i++)
       {
          echo "[";
          for($j=0;$j<=count($brids);$j++)
		   {
			  $value = $monthlyhits[$i][$j];
              echo "$value".",";
			 
		   }
           echo "],";
	   }
      echo "]);

	  w = document.documentElement.clientWidth;
      h = document.documentElement.clientHeight;
      var nw = (0.72 * w);
      var nh = (0.65 *h);
	  
	 new google.visualization.ColumnChart(document.getElementById('chartdiv3')).
            draw(data,
                 {title:'Monthly Graph',
                  'isStacked': true,
                  width:nw, height:nh,
                  vAxis: {title: 'Hits'}}
            );
      }
	  google.setOnLoadCallback(drawchart2);
		</script>";     //options2 to set chart properties eg: isStacked to adjust the labels to multiline
  }
  else
  {
  } 
?>
	<form action="index.php?option=com_jsplocation&task=brgraph" method="post" name="adminForm">
	 <div id="infodiv3"><?php echo JText::_('MONTHLY_BRANCH_DESC'); ?></div>
     <div id="chartdiv3" style="width: 600px; height: 500px;"> </div>  <!-- the monthly graph container-->
		 

<input type="hidden" name="option" value="com_jsplocation" />
<input type="hidden" name="task" value="" />

 </form>
 
<!-- display button -->
   
   <div id="button">
   Records In Time Period :
         <button class="btn1 btn1mini gray" name="btdaily" value="Daily" onclick="showDaily();">Daily</button>
		 <button class="btn1 btn1mini gray" name="btweekly" value="Weekly" onclick="showWeekly();">Weekly</button>
		 <button class="btn1 btn1mini gray" name="btmonthly" value="Monthly" onclick="showMonthly();">Monthly</button>
   
   
   <?php if(isset($_GET['tmpl']) && $_GET['tmpl']=="component") { ?>
   <button class="btn1 btn1mini gray" name="fscr" value="fscr" onclick="fullscreen();" style="display:none">Fullscreen</button>
   <button class="btn1 btn1mini gray" name="ret" value="ret" onclick="ret();">Return</button>
   <?php } else {?>
   <button class="btn1 btn1mini gray" name="fscr" value="fscr" onclick="fullscreen();">Fullscreen</button>
   <button class="btn1 btn1mini gray" name="ret" value="ret" onclick="ret();" style="display:none">Return</button>
   <?php } ?>
   </div>
   <script type="text/javascript">
   function showDaily()
		  {
		    document.getElementById("visualization").style.display="block";
			document.getElementById("chartdiv2").style.display="none";
			document.getElementById("chartdiv3").style.display="none";
			document.getElementById("infodiv1").style.display="block";
			document.getElementById("infodiv2").style.display="none";
			document.getElementById("infodiv3").style.display="none";
		  }
		  function showWeekly()
		  {
		    document.getElementById("visualization").style.display="none";
			document.getElementById("chartdiv2").style.display="block";
			document.getElementById("chartdiv3").style.display="none";
			document.getElementById("infodiv1").style.display="none";
			document.getElementById("infodiv2").style.display="block";
			document.getElementById("infodiv3").style.display="none";
		  }
		  function showMonthly()
		  {
		    document.getElementById("visualization").style.display="none";
			document.getElementById("chartdiv2").style.display="none";
			document.getElementById("chartdiv3").style.display="block";
			document.getElementById("infodiv1").style.display="none";
			document.getElementById("infodiv2").style.display="none";
			document.getElementById("infodiv3").style.display="block";
		  }
		  function fullscreen()
		  { 
		     window.location="index.php?option=com_jsplocation&task=brgraph&tmpl=component";
		}
		  function ret()
		  {
		     window.location="index.php?option=com_jsplocation&task=brgraph";
		}
 showMonthly();
 </script>

