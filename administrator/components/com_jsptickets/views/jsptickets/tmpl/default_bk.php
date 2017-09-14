
<?php
header("Content-type: text/json");

/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
JHTML::_('behavior.tooltip');
$document = JFactory::getDocument();


// $document->addCustomTag('<meta name="viewport" content="width=device-width, initial-scale=1">');
//$document->addCustomTag('<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>');
//$document->addCustomTag('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">');
$document->addCustomTag('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>');


$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/style.css" />');



//$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/custom-scroll.css" />');
//checking extension version
//$document->addScript('components/com_jsptickets/js/jquery-1.10.1.min.js'); //Only needed in joomla 2.5
JHtml::_('behavior.framework', true);
JHTML::_('script','system/modal.js', false, true);
JHTML::_('stylesheet','system/modal.css', array(), true);
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
$document->addCustomTag('<script language="javascript" type="text/javascript" src="components/com_jsptickets/js/ticket.js"></script>');
//$document->addCustomTag('<script language="javascript" type="text/javascript" src="components/com_jsptickets/js/jquery.mCustomScrollbar.min.js"></script>');

//components/com_jsptickets/js/jquery.mCustomScrollbar.min.js

$db = JFactory::getDBO();
$query = "SELECT * FROM #__jsptickets_configuration WHERE `id` = '1'";
$db->setQuery($query);
$config = $db->loadobjectlist();
?>

<!--- <link rel="stylesheet" href="<?php echo JURI::root();?>media/jui/css/bootstrap.css" type="text/css" />   --->




<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<!--<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
</script>-->



<form id="adminForm" name="adminForm" action="index.php?option=com_jsptickets" method="post">

<div class="row">
  <div class="col-sm-3">
  
  <div class="dropdown">
  <button class="btn btn-default dropdown-toggle col-dropdown" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    <?php  
	
	$newTickets = $this->countnewtickets();
	$openTickets = $this->countopentickets();
	
	$totalSystemTickets = $newTickets + $openTickets;
	
	echo $totalSystemTickets;
	
	?> System Tickets
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu dropdown_new" aria-labelledby="dropdownMenu1">
    <li> <a href="index.php?option=com_jsptickets&task=ticketlist&dash_ticstat=1">
									<div class="new-tickets-wrap dashboard-stat stat-new">
										<div class="visual">
											<i class="new-tickets-icon"></i>
										</div>
										<div class="details">
											
											<div class="desc number">
												<?php echo $this->countnewtickets();?> <?php echo JText::_('New Tickets');?>
											</div>
										</div>
									</div>
								</a></li>
    <li><a href="index.php?option=com_jsptickets&task=ticketlist&dash_ticstat=3">
									<div class="new-tickets-wrap dashboard-stat stat-new">
										<div class="visual">
											<i class="new-tickets-icon"></i>
										</div>
										<div class="details">
											
											<div class="desc number">
												<?php echo $this->countopentickets();?> <?php echo JText::_('Open Tickets');?>
											</div>
										</div>
									</div>
								</a></li>
    
  </ul>
</div>
  
  
  
  
  
  
  
  
  
  
  
  
					<!--For Total New Tickets count-->
 
  
  </div>
  <div class="col-sm-3">
  
  
				<div class="dropdown">
  <button class="btn btn-default dropdown-toggle col-dropdown" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
  
  <?php
  $facebookTickets = $this->countfacebooktickets();
  $twitterTickets =  $this->counttwittertickets();
  
  $totalSocialMediaTickets = $facebookTickets + $twitterTickets;
  
  echo $totalSocialMediaTickets;
  
  ?>
  
    Social Media Tickets
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu dropdown_new" aria-labelledby="dropdownMenu1">
    <li><a href="index.php?option=com_jsptickets&task=ticketlist&dash_tictype=2">
									<div class="fb-tickets-wrap dashboard-stat stat-fb">
										<div class="visual">
											<i class="fb-tickets-icon"></i>
										</div>
										<div class="details">
											
											<div class="desc number">
												<?php echo $this->countfacebooktickets();?> <?php echo JText::_('NUMBER_OF_FBTICKETS');?>
											</div>
										</div>
									</div>
								</a></li>
    <li><a href="index.php?option=com_jsptickets&task=ticketlist&dash_tictype=3">
									<div class="twitter-tickets-wrap dashboard-stat stat-tw">
										<div class="visual">
											<i class="twitter-tickets-icon"></i>
										</div>
										<div class="details">
											
											<div class="desc number">
												<?php echo $this->counttwittertickets();?> <?php echo JText::_('NUMBER_OF_TWITTERTICKETS');?>
											</div>
										</div>
									</div>
								</a></li>
    
  </ul>
</div>
  

  
							<!--For Total Facebook Tickets count-->
								
  
  </div>
  
  <div class="col-sm-3">
  
								<!--For Total Tickets count-->
								<a href="index.php?option=com_jsptickets&task=ticketlist&dash_list=1">
									<div class="total-tickets-wrap dashboard-stat stat-tot">
										<div class="visual">
											<i class="total-tickets-icon"></i>
										</div>
										<div class="details">
											
											<div class="desc number">
												<?php echo $this->counttotaltickets();?> <?php echo JText::_('NUMBER_OF_TOTALTICKETS');?>
											</div>
										</div>
									</div>
								</a>
  
  
  </div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<!--<script src="components/com_jsptickets/js/highcharts.js"></script>-->
<script src="components/com_jsptickets/js/highcharts-3d.js"></script>
<script src="components/com_jsptickets/js/drilldown.js"></script>
<script src="components/com_jsptickets/js/data.js"></script>



<div class="row">
  <div class="col-md-12">
  
 <?php
   
   $priorityquery = 'SELECT id,title FROM #__categories where extension = "com_jsptickets" ORDER BY id';
$db->setQuery($priorityquery);    
$priority_result = $db->loadObjectList();



$prioritycount = count($priority_result);



										
										
										
										
										
										// for($i=0; $i< $arr_len; $i++)
										// {
											// $query = 'SELECT `id`,`category_id` FROM `#__jsptickets_ticket` WHERE `category_id` LIKE "%'. $arr[$i] .'%" AND `category_extension` LIKE "%com_jsptickets%"';
											
											// $db->setQuery($query);	
											// $similar_tickets = $db->loadObjectList();
											//$z=0;
											
																						
											// foreach($similar_tickets AS $is) // for each ticket check their categories if there is required category or not
											// {
												
												// $category_grp = json_decode($is->category_id);
											// }
										// }
										
										


  
   ?>
  
  <!-------  High Charts category graph  -------->  
 
 
  <script type="text/javascript">
$(function () {
    $('#container1').highcharts({
        title: {
            text: 'Monthly Categories Graph',
            x: -20 //center
        },
        subtitle: {
            text: 'Joomla Service Provider',
            x: -20
        },
        xAxis: {
		
		 title: {
                text: 'Day of month'
            },
         /*   categories: ['1', '2', '3', '3', '4', '5',
                '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30'] */
        },
        yAxis: {
            title: {
                text: 'Number of Tickets'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
		credits: {
		
		enabled:false
		
		},
        series: [<?php 
		
		$singleelement = array();
				
		$arr = null;
		$arr2 = null;
		$query = 'SELECT `id`,`title` FROM `#__categories` WHERE `extension` LIKE "com_jsptickets" ';
		$db->setQuery($query);	
		$all_categories = $db->loadObjectList();

		foreach($all_categories AS $item)
		{
			$arr = array_merge((array)$arr, (array)$item->id);
			$arr2 = array_merge((array)$arr2, (array)$item->title);
		}
								
		$arr_len = sizeof($arr);
		
		for($i=0; $i< $arr_len; $i++)
		{

		    $query = 'SELECT `id`,`category_id` FROM `#__jsptickets_ticket` WHERE `category_id` LIKE "%'. $arr[$i] .'%" AND `category_extension` LIKE "%com_jsptickets%"';								
			$db->setQuery($query);	
			$similar_tickets = $db->loadObjectList();
			
			
			
			if(!empty($similar_tickets)){
			
			
			foreach($similar_tickets AS $is)  //for each ticket check their categories if there is required category or not
			{
												
				 $category_grp = json_decode($is->category_id);
			}
			
		$priority_id = $category_grp[0];

		$month_ini = date('Y-m-01');
		$month_end = date('Y-m-d H:i:s');		
				
		$query = 'SELECT COUNT( id ) AS countno, created
FROM #__jsptickets_ticket
WHERE category_id LIKE "%'.$priority_id.'%"
AND created >=  "'.$month_ini.'"
GROUP BY DATE( created )';

		
        $db->setQuery($query);    
        $status_count = $db->loadAssocList();	
		
			
			
			}

			
		$date = date('Y-m-01');
		$end_date = date('Y-m-d');
		unset($singleelement);
		
		
		
		if(!empty($status_count)){
		
		// echo '----------------------------';
		
				// print_r($status_count);
		// echo '----------------------------';		
				foreach($status_count as $elements){        
		
					$trimdate = substr($elements['created'],0,10);
					
	
					while (strtotime($date) <= strtotime($end_date)) {
						
						if($date == $trimdate){
						//echo 'elecount-->'.$elements['countno'];
						$singleelement[] = $elements['countno'];
						$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
						break;
						
						}
						else{
						
						$singleelement[] = 0;
						$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
						}
						
					}
		
		}
		unset($status_count);
		}
else{


$singleelement[] = 0;

}
	
		$stringele = "";
		
		$stringele = implode(',',$singleelement);

        ?>
			
        {
           name: '<?php echo $arr2[$i]; ?>',
           data: [0,<?php echo $stringele; ?>]

       },
        <?php

		}	 ?>]
    });
});
		</script>
	</head>
	<body>



<div id="container1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div class="test"></div>
	</body>
  
  
  
   <!-------  High Charts category graph  -------->  
  
  
  
  </div>
</div>


<div class="row">
  <div class="col-md-12">
  
 <!-------  High Charts Monthly Priority Graph  -------->  
   
   <?php
   
$priorityquery = 'SELECT id,name FROM #__jsptickets_priorities ORDER BY id';
$db->setQuery($priorityquery);    
$priority_result = $db->loadObjectList();
$prioritycount = count($priority_result);

   ?>
 
 
  <script type="text/javascript">
$(function () {
    $('#container2').highcharts({
        title: {
            text: 'Monthly Priority Graph',
            x: -20 //center
        },
        subtitle: {
            text: 'Joomla Service Provider',
            x: -20
        },
        xAxis: {
		 title: {
                text: 'Days of month'
            },
           /* categories: ['1', '2', '3', '3', '4', '5',
                '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30'] */
        },
        yAxis: {
            title: {
                text: 'Number of Tickets'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
		credits: {
		
		enabled:false
		
		},
        series: [
        
        <?php 
		$singleelement = array();
		for($i=0;$i<$prioritycount;$i++){ 

       $priority_id = $priority_result[$i]->id;
        $priority_name = $priority_result[$i]->name;
		
		$month_ini = date('Y-m-01');
		$month_end = date('Y-m-d H:i:s');
	
		
		if(isset($priority_id) && isset($priority_name)){
		
		$query = 'SELECT COUNT( id ) AS countno, created
					FROM #__jsptickets_ticket
					WHERE priority_id = '.$priority_id.'
					AND created >=  "'.$month_ini.'"
					GROUP BY DATE( created )';	
        $db->setQuery($query);    
        $status_count = $db->loadAssocList();
		
		
		$date = date('Y-m-01');
		$end_date = date('Y-m-d');
		unset($singleelement);
		
		if(!empty($status_count)){
		
				foreach($status_count as $elements){        
					$trimdate = substr($elements['created'],0,10);
					$date;
	
					while (strtotime($date) <= strtotime($end_date)) {

						if($date == $trimdate){
						$singleelement[] = $elements['countno'];
						$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
						break;
						
						}
						else{
						$singleelement[] = 0;
						$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
						}
						
					}
		
		}

		}
	
	
	else{
		$singleelement[] = 0;
		}
	
	

		}
		else{
		$singleelement[] = 0;
		}

		$stringele = "";
		$stringele = implode(',',$singleelement);
		
        ?>
			
        {
           name: '<?php echo $priority_name; ?>',
           data: [0,<?php echo $stringele;  ?>]

       },
        <?php

		} ?>
        ]
    });
});
		</script>
	</head>
	<body>



<div id="container2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div class="test"></div>
	</body>
  
  
  
   <!-------  High Charts Monthly Priority Graph  -------->  
  
  
  </div>
</div>


<div class="row">
  <div class="col-md-6">
  
  
  
  
   <!-------  High Charts status graph  -------->  
  
  <script type="text/javascript">
$(function () {
   $('#containerColumn').highcharts({
       chart: {
           type: 'column'
       },
       title: {
           text: 'Ticket Status Graph'
       },
       subtitle: {
           text: 'No of Tickets vs Ticket Status'
       },
	   credits: {
		
		enabled:false
		
		},
       xAxis: {
           // categories: [
               // 'Jan',
               // 'Feb',
               // 'Mar',
               // 'Apr',
               // 'May',
               // 'Jun',
               // 'Jul',
               // 'Aug',
               // 'Sep',
               // 'Oct',
               // 'Nov',
               // 'Dec'
           // ],
		   
		   title: {
               text: 'Ticket Status'
           },
           crosshair: true
       },
       yAxis: {
           min: 0,
           title: {
               text: 'No of Tickets'
           }
       },
       tooltip: {
           headerFormat: '<span style="font-size:10px"></span><table>',
           pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
               '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
           footerFormat: '</table>',
           shared: true,
           useHTML: true
       },
       plotOptions: {
           column: {
               pointPadding: 0.2,
               borderWidth: 0
           }
       },
        
        
        <?php

$totalquery = 'SELECT count(id) as countnum FROM #__jsptickets_ticket';
$db->setQuery($totalquery);    
$total_count = $db->loadObject();

$totcount = $total_count->countnum;

$query = 'SELECT id,name FROM #__jsptickets_status ORDER BY id ASC';
$db->setQuery($query);    
$status_result = $db->loadObjectList();

$count = count($status_result);

?>
        
        
        
       series: [
        
        <?php for($i=0;$i<$count;$i++){ 
        
        $status_id = $status_result[$i]->id;
        $status_name = $status_result[$i]->name;

        $query = 'SELECT count(id) as countno FROM #__jsptickets_ticket where status_id='.$status_id;
        $db->setQuery($query);    
        $status_count = $db->loadObject();

        $statuscount = $status_count->countno;
        
        ?>
        
        {
           name: '<?php echo $status_name; ?>',
           data: [<?php echo $statuscount; ?>]

       },
        <?php } ?>
        ]
   });
});
        </script>
<style>
	/* #container .highcharts-container text{} */
		.test{width:200px;height:50px;position:absolute;bottom:0;}
		#container{/*min-width: 310px; height: 400px; margin: 0 auto*/}
		#containerColumn{width:50%;float:left;}
		#containerColumn1{width:50%;float:left;}
		
		#container1{/*min-width: 310px; height: 400px; margin: 0 auto
		width:50%;float:left;*/}
		.new_container{width:100%;height:auto;}
		.col-sm-3{width:32%;float:left;}
		.col-sm-3 a{text-decoration:none;}
		.col-new{width: 48%;  float: left;border: 1px solid rgb(223, 223, 223);padding: 5px;margin-left: 5px;background-color: rgb(238, 239, 239);  height: 200px;}
		.col-new1{width: 48%;  float: left;border: 1px solid rgb(223, 223, 223);padding: 5px;margin-left: 5px;background-color: rgb(238, 239, 239);  height: 200px;overflow-x:auto;}
	    .col-n{border: 1px solid rgb(223, 223, 223);background-color: rgb(238, 239, 239);font-weight:bold;font-size:11px;  padding-left: 5px;}
		.col-dropdown{ width:99%;float:left;height:70px; background-color:#08c !important;  background-image: none !important;color: white;}
  .col-dropdown:select, .col-dropdown:hover, .col-dropdown:focus, .col-dropdown:active, .col-dropdown.active, .col-dropdown.disabled, .col-dropdown[disabled]{color:white !important;}
  .dropdown_new{top: 67px;min-width: 349px;}
  .col-sm-3 .dropdown .btn:hover{color:white !important;}
  .col-sm-3 .dropdown .btn:focus{color:white !important;}
   .col-sm-3 .dropdown .dropdown-menu > li > a:hover,  .col-sm-3 .dropdown .dropdown-menu > li > a:focus, .col-sm-3 .dropdown .dropdown-submenu:hover > a, .col-sm-3 .dropdown .dropdown-submenu:focus > a {background:none !important;}
</style>

<div id="containerColumn" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
  
  
  <!-------  High Charts Status Graph  -------->  
  
  
  
  </div>
  <div class="col-md-6">
  
  
   <!-------  High Charts status graph  -------->  
  
  <script type="text/javascript">
$(function () {
   $('#containerColumn1').highcharts({
       chart: {
           type: 'column'
       },
       title: {
           text: 'Top 5 Users'
       },
       subtitle: {
           text: 'No of Tickets vs Users'
       },
	   credits: {
		
		enabled:false
		
		},
       xAxis: {
           // categories: [
               // 'Jan',
               // 'Feb',
               // 'Mar',
               // 'Apr',
               // 'May',
               // 'Jun',
               // 'Jul',
               // 'Aug',
               // 'Sep',
               // 'Oct',
               // 'Nov',
               // 'Dec'
           // ],
		   
		   title: {
               text: 'Users'
           },
           crosshair: true
       },
       yAxis: {
           min: 0,
           title: {
               text: 'No of Tickets'
           }
       },
       tooltip: {
           headerFormat: '<span style="font-size:10px"></span><table>',
           pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
               '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
           footerFormat: '</table>',
           shared: true,
           useHTML: true
       },
       plotOptions: {
           column: {
               pointPadding: 0.2,
               borderWidth: 0
           }
       },
        
        
        
        
       series: [
	   
        
        <?php 
		
				$query = 'SELECT COUNT( created_by ) as ticket , created_by
FROM  `#__jsptickets_ticket` 
GROUP BY created_by DESC
LIMIT 0 , 5';
	
        $db->setQuery($query);    
        $top_users = $db->loadAssocList();

		$counttopuser = count($top_users);
		
		
		if($counttopuser ==0){
		 ?>
        
        {
           name: '<?php echo '';?>',
		   data:[<?php echo ''; ?>]
		}   
		<?php
		}
		
		else{
		for($i=0;$i<$counttopuser;$i++){
		
		$user_ids = $top_users[$i]['created_by'];
		
			
		$usernamequery = 'SELECT username from #__users where id='.$user_ids;
        $db->setQuery($usernamequery);    
        
		$top_username = $db->loadAssocList();
        ?>
        
       {
           name: '<?php echo $top_username[$i]['username']; ?>',
           data: [<?php echo $top_users[$i]['ticket']; ?>]

       },
        <?php }

}
		;?>
        ]
   });
});
        </script>


<div id="containerColumn1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
  
  
  <!-------  High Charts  -------->  
  
  
  
  
  
   
  
  
  </div>
</div>


 <div class="row">
   <div class="col-md-12">
   </div>
  </div>
  
  <div class="row">
   <div class="col-md-6">
   
   <!-- High Charts 3D Pie --->
   
   
   <script type="text/javascript">
$(function () {
    $('#container4').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Tickets percentage'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
		credits: {
		
		enabled:false
		
		},
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Tickets share',
            data: [
                ['<?php echo JText::_('JSPTICKETS_FEEDS_PENDING_TICKETS');?>',<?php echo $this->getfeeds_pendingtickets();?>],
                ['<?php echo JText::_('JSPTICKETS_FEEDS_NEW_TICKETS');?>',<?php echo $this->countnewtickets();?>],
                
                ['<?php echo JText::_('JSPTICKETS_FEEDS_COMMENTED_TICKETS');?>',<?php echo $this->getfeeds_commentedtickets();?>],
                ['<?php echo JText::_('JSPTICKETS_FEEDS_FEEDBACKS_TICKETS');?>',<?php echo $this->getfeeds_feedbacktickets();?>],
                ['<?php echo JText::_('JSPTICKETS_FEEDS_COMMENTS');?>',<?php echo $this->getfeeds_comments();?>],
				['<?php echo JText::_('JSPTICKETS_FEEDS_FEEDBACKS');?>',<?php echo $this->getfeeds_feedbacks();?>],
				['<?php echo JText::_('JSPTICKETS_FEEDS_GUEST_TICKETS');?>',<?php echo $this->countguesttickets();?>]
            ]
        }]
    });
});
		</script>
		
		<div id="container4" style="height: 400px;width:50%;float:left;"></div>
   
   
   <!-- High Charts 3D Pie --->
   
   
   </div>
   
   
   <div class="col-md-6 new-row">
  
	
	
		<div class="desc col-n head-tickets">
						<b><?php echo JText::_('TICKET_ANALYSIS');?></b>
		</div>
		
		<div>
		
		<div id="heightdiv" style="height:20px;"></div>
		<div class="col-md-6 col-n">  <?php echo JText::_('JSPTICKETS_FEEDS_PENDING_TICKETS')." ".$this->getfeeds_pendingtickets(); ?> </div>
		<div id="heightdiv" style="height:20px;"></div>
		<div class="col-md-12 col-n">  <?php echo JText::_('JSPTICKETS_FEEDS_NEW_TICKETS')." ".$this->countnewtickets(); ?> </div>
		<div id="heightdiv" style="height:20px;"></div>
		<div class="col-md-12 col-n">  <?php echo JText::_('JSPTICKETS_FEEDS_COMMENTED_TICKETS')." ".$this->getfeeds_commentedtickets(); ?> </div>
		<div id="heightdiv" style="height:20px;"></div>
		<div class="col-md-12 col-n">  <?php echo JText::_('JSPTICKETS_FEEDS_FEEDBACKS_TICKETS')." ".$this->getfeeds_feedbacktickets(); ?> </div>
		<div id="heightdiv" style="height:20px;"></div>
		<div class="col-md-12 col-n">  <?php echo JText::_('JSPTICKETS_FEEDS_COMMENTS')." ".$this->getfeeds_comments(); ?> </div>
		<div id="heightdiv" style="height:20px;"></div>
		<div class="col-md-12 col-n">  <?php echo JText::_('JSPTICKETS_FEEDS_FEEDBACKS')." ".$this->getfeeds_feedbacks(); ?> </div>
		<div id="heightdiv" style="height:20px;"></div>
		<div class="col-md-12 col-n" style="border-bottom:none !important;">  <?php echo JText::_('JSPTICKETS_FEEDS_GUEST_TICKETS')." ".$this->countguesttickets(); ?> </div>
		
		
		</div>
		
	</div>	
   
   
</div>

<div id="heightdiv" style="height:20px;"></div>


<div class="row">

		<!--
		
		<div class="col-md-6 col-new1">
		
		
		
		
		<div class="desc" style="text-align: center;">
						<b><?php echo JText::_('Recent Activities');?></b>
						
		</div>
		<div id="heightdiv" style="height:20px;"></div>
   <div class="recent-activities-data custom-scroll-1">
										<table style="width:100%;">
											<tbody>
												<?php
												$result = $this->getrecentactivities();
												if(isset($result) && $result != null)
												{
													foreach($result as $i) { 
														if($this->ticketexists($i->ticket_id))
														{
															echo '<tr><td>'.$i->narration.'</td><td><a href="index.php?option=com_jsptickets&controller=ticketlist&task=edit&ticketcode='.$this->getTCFromTId($i->ticket_id).'">'.$i->subject.'</a></td></tr>';
														}
													} 
												} else {
												echo  '<tr><td><div id="recent-activities-msg"><span class="notification"><b>'. JText::_("NO_DATA_FOUND_NOTIFICATION") .'</b></span></div></td></tr>';
												}?>
											</tbody>
										</table>
									</div>
		
   
   </div>
		
		
		-->
		
		

 
  </div>
  </div>
  
  

<div class="row">
  <div class="col-md-1">
  
  
  
  
  </div>
</div>

</form>


<!-- <script>
(function($){
		$(window).load(function(){
			$(".custom-scroll-1").mCustomScrollbar({
				horizontalScroll:false,
				autoHideScrollbar: false,
				updateOnContentResize: true
			});
		});
	})(jQuery);
</script> -->