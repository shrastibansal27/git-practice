
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
$document->addCustomTag('<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>');
$document->addCustomTag('<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">');
$document->addCustomTag('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>');


$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/style.css" />');



//$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/custom-scroll.css" />');
//checking extension version
$document->addScript('components/com_jsptickets/js/jquery-1.10.1.min.js'); //Only needed in joomla 2.5
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
<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
</script>





<div class="row">
  <div class="col-sm-3">
					<!--For Total New Tickets count-->
  <a href="index.php?option=com_jsptickets&task=ticketlist&dash_ticstat=1">
									<div class="new-tickets-wrap dashboard-stat stat-new">
										<div class="visual">
											<i class="new-tickets-icon"></i>
										</div>
										<div class="details">
											<div class="number">
												<?php echo $this->countnewtickets();?>
											</div>
											<div class="desc">
												<?php echo JText::_('NUMBER_OF_NEWTICKETS');?>
											</div>
										</div>
									</div>
								</a>
  
  </div>
  <div class="col-sm-3">
  
							<!--For Total Facebook Tickets count-->
								<a href="index.php?option=com_jsptickets&task=ticketlist&dash_tictype=2">
									<div class="fb-tickets-wrap dashboard-stat stat-fb">
										<div class="visual">
											<i class="fb-tickets-icon"></i>
										</div>
										<div class="details">
											<div class="number">
												<?php echo $this->countfacebooktickets();?>
											</div>
											<div class="desc">
												<?php echo JText::_('NUMBER_OF_FBTICKETS');?>
											</div>
										</div>
									</div>
								</a>
  
  </div>
  <div class="col-sm-3">
  
							<!--For Total Twitter Tickets count-->
								<a href="index.php?option=com_jsptickets&task=ticketlist&dash_tictype=3">
									<div class="twitter-tickets-wrap dashboard-stat stat-tw">
										<div class="visual">
											<i class="twitter-tickets-icon"></i>
										</div>
										<div class="details">
											<div class="number">
												<?php echo $this->counttwittertickets();?>
											</div>
											<div class="desc">
												<?php echo JText::_('NUMBER_OF_TWITTERTICKETS');?>
											</div>
										</div>
									</div>
								</a>
  
  
  </div>
  <div class="col-sm-3">
  
								<!--For Total Tickets count-->
								<a href="index.php?option=com_jsptickets&task=ticketlist&dash_list=1">
									<div class="total-tickets-wrap dashboard-stat stat-tot">
										<div class="visual">
											<i class="total-tickets-icon"></i>
										</div>
										<div class="details">
											<div class="number">
												<?php echo $this->counttotaltickets();?>
											</div>
											<div class="desc">
												<?php echo JText::_('NUMBER_OF_TOTALTICKETS');?>
											</div>
										</div>
									</div>
								</a>
  
  
  </div>
</div>

<script src="components/com_jsptickets/js/highcharts.js"></script>
<script src="components/com_jsptickets/js/highcharts-3d.js"></script>
<script src="components/com_jsptickets/js/drilldown.js"></script>
<script src="components/com_jsptickets/js/data.js"></script>



<div class="row">
  <div class="col-md-12">
  
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


<div id="containerColumn" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
  
  
  <!-------  High Charts  -------->  
  
  
  </div>
</div>
<div class="row">
  <div class="col-md-6">
  
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
                text: 'Months in a year'
            },
            categories: ['1', '2', '3', '3', '4', '5',
                '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30']
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
        series: [{
            name: 'Number of Tickets',
            data: [10, 20, 30, 40, 50, 60, 50, 40, 30, 20, 10, 0, 10, 20, 30, 40, 50, 60, 20, 70, 30, 10, 50, 10, 10, 35, 20, 45, 40, 50, 90]
        }, /*{
            name: 'New York',
            data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
        }, {
            name: 'Berlin',
            data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
        }, {
            name: 'London',
            data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
        }*/]
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
  <div class="col-md-6">
  
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
                text: 'Date of month'
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
		
		
		// $query = 'SELECT count(id) as countno FROM #__jsptickets_ticket where priority_id='.$priority_id.'where created_by >= '.$month_ini;
		
		$singleelement = array();
		
		for($i=0;$i<$prioritycount;$i++){ 
		
        
        $priority_id = $priority_result[$i]->id;
        $priority_name = $priority_result[$i]->name;
		
		$month_ini = date('Y-m-01');
		$month_end = date('Y-m-d H:i:s');
		
				
		
      //  $query = 'SELECT count(id) as countno FROM #__jsptickets_ticket where priority_id='.$priority_id.'where created_by >= '.$month_ini;
		
		
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
		foreach($status_count as $elements){        
		
					$trimdate = substr($elements[created],0,10);
					
	
					while (strtotime($date) <= strtotime($end_date)) {
						//echo "date-->$date\n";
						//echo "trimdate-->$trimdate\n";
						if($date == $trimdate){
						
						$singleelement[] = $elements[countno];
						$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
						break;
						
						}
						else{
						
						$singleelement[] = 0;
						$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
						}
						
										
						
						
						
						
					}
		
		
		}
		
		
		
		
		
		
		
		
		//print_r($singleelement);
		
		//die;
		
				
			
		
		$stringele = "";
		
		$stringele = implode(',',$singleelement);
		
		
				
        
        ?>
			
        {
           name: '<?php echo $priority_name; ?>',
           data: [<?php echo $stringele;  ?>]

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
  <div class="col-md-6 stat-ana">
	
	
		<div class="desc">
						<?php echo JText::_('TICKET_ANALYSIS');?>
		</div>
		<div class="col-md-12">  <?php echo JText::_('JSPTICKETS_FEEDS_PENDING_TICKETS')." ".$this->getfeeds_pendingtickets(); ?> </div>
		<div class="col-md-12">  <?php echo JText::_('JSPTICKETS_FEEDS_NEW_TICKETS')." ".$this->countnewtickets(); ?> </div>
		<div class="col-md-12">  <?php echo JText::_('JSPTICKETS_FEEDS_COMMENTED_TICKETS')." ".$this->getfeeds_commentedtickets(); ?> </div>
		<div class="col-md-12">  <?php echo JText::_('JSPTICKETS_FEEDS_FEEDBACKS_TICKETS')." ".$this->getfeeds_feedbacktickets(); ?> </div>
		<div class="col-md-12">  <?php echo JText::_('JSPTICKETS_FEEDS_COMMENTS')." ".$this->getfeeds_comments(); ?> </div>
		<div class="col-md-12">  <?php echo JText::_('JSPTICKETS_FEEDS_FEEDBACKS')." ".$this->getfeeds_feedbacks(); ?> </div>
		<div class="col-md-12">  <?php echo JText::_('JSPTICKETS_FEEDS_GUEST_TICKETS')." ".$this->countguesttickets(); ?> </div>
		

 
  </div>
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
            text: 'Browser market shares at a specific website, 2014'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
            name: 'Browser share',
            data: [
                ['Firefox',   45.0],
                ['IE',       26.8],
                {
                    name: 'Chrome',
                    y: 12.8,
                    sliced: true,
                    selected: true
                },
                ['Safari',    8.5],
                ['Opera',     6.2],
                ['Others',   0.7]
            ]
        }]
    });
});
		</script>
		
		<div id="container4" style="height: 400px"></div>
   
   
   <!-- High Charts 3D Pie --->
   
   </div>
</div>
<div class="row">
  <div class="col-md-1">
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  </div>
</div>

<form id="adminForm" name="adminForm" action="index.php?option=com_jsptickets" method="post">
<table class="adminform" width="100%">
  <tbody>
    <tr>
      <td width="100%" valign="top">
			<?php /* ?>
			
			<table class="adminform">
				<tbody>
					<tr>
						<td>
							<div style="float:left;">
							  <div class="icon"> <a href="index.php?option=com_jsptickets&task=catlist"><img src="components/com_jsptickets/images/main_page_icons/category.png" border="0" /><span style="font-size:11px;"><?php echo JText::_( 'CATEGORY_MANAGEMENT' ); ?></span></a> </div>
							</div>
							
							<div style="float:left;">
							  <div class="icon"> <a href="index.php?option=com_jsptickets&task=ticketlist"><img src="components/com_jsptickets/images/main_page_icons/ticket.png" border="0" /><span style="font-size:11px;"><?php echo JText::_( 'TICKETS_MANAGEMENT' ); ?></span></a> </div>
							</div>
							
							<div style="float:left;">
							  <div class="icon"> <a href="index.php?option=com_jsptickets&task=statuslist"><img src="components/com_jsptickets/images/main_page_icons/jl_marker1.png" border="0" /><span style="font-size:11px;"><?php echo JText::_( 'STATUS_MANAGEMENT' ); ?></span></a> </div>
							</div>
							
							<div style="float:left;">
							  <div class="icon"> <a href="index.php?option=com_jsptickets&task=prioritylist"><img src="components/com_jsptickets/images/main_page_icons/jl_marker1.png" border="0" /><span style="font-size:11px;"><?php echo JText::_( 'PRIORITY_MANAGEMENT' ); ?></span></a> </div>
							</div>
							
							<div style="float:left;">
							  <div class="icon"> <a href="index.php?option=com_jsptickets&task=config"><img src="components/com_jsptickets/images/main_page_icons/config.png" border="0" /><span style="font-size:11px;"><?php echo JText::_( 'CONFIGURATION' ); ?></span></a> </div>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			
			<?php */ ?>
			
			<!-- STATISTICS CONTENT -->
			
			
			
			
			
			
			<div class="statistics-container">
				<table class="adminform" width="100%" style="border-collapse:separate;>
					<thead>
						<tr>
							<td colspan="4">
								<?php echo '<h3>'.JText::_('DASHBOARD_HEADING').'<h3/>'; ?>
							</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="4">  <!--For Total New Tickets count-->
								<a href="index.php?option=com_jsptickets&task=ticketlist&dash_ticstat=1">
									<div class="new-tickets-wrap dashboard-stat">
										<div class="visual">
											<i class="new-tickets-icon"></i>
										</div>
										<div class="details">
											<div class="number">
												<?php echo $this->countnewtickets();?>
											</div>
											<div class="desc">
												<?php echo JText::_('NUMBER_OF_NEWTICKETS');?>
											</div>
										</div>
									</div>
								</a>
								<!--For Total Facebook Tickets count-->
								<a href="index.php?option=com_jsptickets&task=ticketlist&dash_tictype=2">
									<div class="fb-tickets-wrap dashboard-stat">
										<div class="visual">
											<i class="fb-tickets-icon"></i>
										</div>
										<div class="details">
											<div class="number">
												<?php echo $this->countfacebooktickets();?>
											</div>
											<div class="desc">
												<?php echo JText::_('NUMBER_OF_FBTICKETS');?>
											</div>
										</div>
									</div>
								</a>
								<!--For Total Twitter Tickets count-->
								<a href="index.php?option=com_jsptickets&task=ticketlist&dash_tictype=3">
									<div class="twitter-tickets-wrap dashboard-stat">
										<div class="visual">
											<i class="twitter-tickets-icon"></i>
										</div>
										<div class="details">
											<div class="number">
												<?php echo $this->counttwittertickets();?>
											</div>
											<div class="desc">
												<?php echo JText::_('NUMBER_OF_TWITTERTICKETS');?>
											</div>
										</div>
									</div>
								</a>
								<!--For Total Tickets count-->
								<a href="index.php?option=com_jsptickets&task=ticketlist&dash_list=1">
									<div class="total-tickets-wrap dashboard-stat">
										<div class="visual">
											<i class="total-tickets-icon"></i>
										</div>
										<div class="details">
											<div class="number">
												<?php echo $this->counttotaltickets();?>
											</div>
											<div class="desc">
												<?php echo JText::_('NUMBER_OF_TOTALTICKETS');?>
											</div>
										</div>
									</div>
								</a>
							</td>
						</tr>
						
						<tr>
							<td colspan="2" width="50%">
							<?php 
							$query = 'SELECT * FROM `#__jsptickets_ticket` WHERE `category_extension` LIKE "%com_jsptickets%"';
							$db->setQuery($query);	
							$decide1 = $db->loadObjectlist();
							if(isset($decide1) && $decide1 != null)
							{
							?>
								<div>
									<?php 
										echo "<script type='text/javascript'>";
										echo "google.setOnLoadCallback(drawpieChart);
												function drawpieChart() {
										var data = google.visualization.arrayToDataTable([";
										echo "  ['Category', 'Tickets'], " ;
										
										$arr = null;
										$query = 'SELECT `id` FROM `#__categories` WHERE `extension` LIKE "com_jsptickets" ';
										$db->setQuery($query);	
										$all_categories = $db->loadObjectList();

										foreach($all_categories AS $item)
										{
											$arr = array_merge((array)$arr, (array)$item->id);
										}
										$arr_len = sizeof($arr);
										for($i=0; $i< $arr_len; $i++)
										{
											$query = 'SELECT `id`,`category_id` FROM `#__jsptickets_ticket` WHERE `category_id` LIKE "%'. $arr[$i] .'%" AND `category_extension` LIKE "%com_jsptickets%"';
											$db->setQuery($query);	
											$similar_tickets = $db->loadObjectList();
											$z=0;
											foreach($similar_tickets AS $is) // for each ticket check their categories if there is required category or not
											{
												$category_grp = json_decode($is->category_id);
												$cat_grp_len = sizeof($category_grp);
												for($j=0; $j<$cat_grp_len; $j++)
												{
													if($arr[$i] == $category_grp[$j])
													{
														$z++;
													}
												}
											}
											$query = 'SELECT `title` FROM `#__categories` WHERE `id` LIKE '. $arr[$i] .' AND `extension` LIKE "com_jsptickets"';
											$db->setQuery($query);	
											$similar_tickets = $db->loadObject();
											echo "  ['". $similar_tickets->title ."',     ". $z . "], ";
										}
										echo " ]); ";
										
										echo "
											w = document.documentElement.clientWidth;
											h = document.documentElement.clientHeight;
											var nw = (0.40 * w);
											var nh = (0.40 * h);
											
										var options = {
										  title: '". JText::_("NUMBER_OF_TICKETS_ACCCORDING_TO_CATEGORIES") ."',
										  width:nw, height:nh
										}; " ;

										echo "var chart = new google.visualization.PieChart(document.getElementById('piechart'));
										chart.draw(data, options);
									  }
									</script> " ; ?>
									<div id="piechart" style="width: 400px; height: 250px;"></div>
								</div>
							<?php } else { ?>
								<div id="pie_chart_msg">
									<span class='notification'>
										<b><?php echo JText::_("NO_DATA_FOUND_NOTIFICATION"); ?></b>
									</span>
								<div>
							<?php } ?>
							</td>
							
							<td colspan="2" width="50%">
							<?php
							$curr_mon = date("m");
							$curr_year = date("Y");
							$query = "SELECT DATE(`modified`) AS `Date` FROM `#__jsptickets_ticket` WHERE MONTH(`modified`) = ". $curr_mon ." AND YEAR(`modified`) = ". $curr_year ." GROUP BY DATE(`modified`) ORDER BY DATE(`modified`) ASC" ;
							$db->setQuery($query);	
							$decide2 = $db->loadObjectList();
							if(isset($decide2) && $decide2 != null)
							{
							?>
								<div>
									<?php  echo "<script type='text/javascript'> " ;
									 echo "google.setOnLoadCallback(drawlineChart);
									  function drawlineChart() {
										var data = google.visualization.arrayToDataTable([ ";
										
										$presentmonth = date("m");
										$presentyear = date("Y");
										$arr2 = null;
										$query = 'SELECT `id` , `name` FROM `#__jsptickets_status` ORDER BY `id` ASC';
										$db->setQuery($query);	
										$status_result = $db->loadObjectList();
										

										
										echo " ['Date', " ;									
										foreach($status_result AS $status)
										{
											echo "'".$status->name."', ";
										}
										echo "]," ;									
																				
										$query = "SELECT `status_id`, count(`id`) AS `count`, DATE(`modified`) AS `Date` FROM `#__jsptickets_ticket` WHERE MONTH(`modified`) = ". $presentmonth ." AND YEAR(`modified`) = ". $presentyear ." GROUP BY `status_id`, DATE(`modified`) ORDER BY DATE(`modified`) ASC ";
										$db->setQuery($query);	
										$hit_result = $db->loadObjectList();
										
										$query = "SELECT DATE(`modified`) AS `Date` FROM `#__jsptickets_ticket` WHERE MONTH(`modified`) = ". $presentmonth ." AND YEAR(`modified`) = ". $presentyear ." GROUP BY DATE(`modified`) ORDER BY DATE(`modified`) ASC" ;
										$db->setQuery($query);	
										$date_result = $db->loadObjectList();
										
										foreach($date_result AS $date)
										{
											$hitarr = null;
											$monthdate = new DateTime($date->Date);
											
											echo "['" . $monthdate->format('d') ."',";
											
											
											foreach($hit_result AS $hits)
											{
												
												if($date->Date == $hits->Date)
												{
													foreach($status_result AS $status)
													{
															if($hits->status_id == $status->id)
															{
																	$hitarr[$status->id] = $hits->count;
															}
													}
												}
											}
											
											
											
											
											
											
											foreach($status_result AS $status)
											{
												if( isset($hitarr[$status->id]) )
												{
													// Do whatever you want
												}
												else {
													$hitarr[$status->id] = 0;;
												}
												echo " ". $hitarr[$status->id] .",";
											}
											echo "],";
										}
										
										
										echo "]); " ;

										echo "
											w = document.documentElement.clientWidth;
											h = document.documentElement.clientHeight;
											var nw = (0.40 * w);
											var nh = (0.40 *h);
											
										var options = {
										  title: '".JText::_('MONTHLY_TICKET_STATUS')."',
										   width:nw, height:nh
										}; " ;

										echo "var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
										chart.draw(data, options);
									  }
									</script>"; ?>
									<div id="chart_div" style="width: 400px; height: 250px;"></div>
								</div>
							<?php } else { ?>
								<div id="line_chart_msg">
									<span class='notification'>
										<b><?php echo JText::_("NO_DATA_FOUND_NOTIFICATION"); ?></b>
									</span>
								<div>
							<?php } ?>
							</td>
						</tr>
						
						<tr>
						<?php if($config[0]->gen_fb_tickets) {?>
							<td colspan="2" width="50%">
									<table style="width:100%;" class="table-head facebook">
										<thead>
												<tr><th colspan="2"><?php echo JText::_('JSPTICKETS_FACEBOOK');?></th></tr>
										</thead>
									</table>
									<div class="fb-feeds custom-scroll-1">
										<table style="width:100%;">
											<tbody>
												<?php
													if($config[0]->fb_page_url != "" && $config[0]->fb_app_id != "" && $config[0]->fb_app_secret != "")
													{
														$arg = $config[0]->fb_page_url; //get the fb page link
														$arg = str_replace( array('https://','http://','www.','facebook.com/','pages/','?ref=ts&fref=ts','?fref=ts','?ref=ts'),
														'',
														$arg ); //add problematic params to the array
														$arg_array = explode('/',$arg);
														if(count($arg_array) > 1)
														{
															$arg = $arg_array[count($arg_array)-1];
														}
														$elseID = file_get_contents('https://graph.facebook.com/?ids='.$arg.'&fields=id');
														$elseID = json_decode($elseID,true);
														$FBid = $elseID[$arg]['id'];
														$app_id = $config[0]->fb_app_id;
														$app_secret = $config[0]->fb_app_secret;
														
														$access = file_get_contents('https://graph.facebook.com/oauth/access_token?client_id='.$app_id.'&client_secret='.$app_secret.'&grant_type=client_credentials');
														$access_token = explode("=",$access);
														$FBpage = file_get_contents('https://graph.facebook.com/' . $FBid . '/feed?access_token=' . $access_token[1] . '&limit=20');
														$FBdata = json_decode($FBpage);
														if($FBdata == null)
														{
															//echo '<tr><td>Sorry!</td></tr>';
														} else {						
															foreach($FBdata AS $row)
															{
																foreach($row AS $i)
																{
																	if(isset($i->id))
																	{
																		$fbpostid = $i->id;
																		$query = 'SELECT EXISTS(SELECT * FROM `#__jsptickets_ticket` WHERE `fb_post_id` = "' . $fbpostid . '") AS `exists`';
																		$db->setQuery($query);
																		$ticketexists = $db->loadobjectlist();
																		$tc_exists = $ticketexists[0]->exists;
																	}

																	if($tc_exists)
																	{
																		if(isset($i->message))
																		{
																			$text = $i->message;
																			if(strlen($i->message) > 500) {
																				$text = substr($text, 0, strpos($i->message, ' ', 500)).".....";
																			}
																			echo '<tr><td>'.$text.'</td><td><div class="created-ticket-btn whatever_u_like">'.JTEXT::_('TICKET_CREATED').'</div></td></tr>';
																		}
																	} else {
																		if(isset($i->message))
																		{
																			$text = $i->message;
																			if(strlen($i->message) > 500) {
																				$text = substr($text, 0, strpos($i->message, ' ', 500)).".....";
																			}
																			echo '<tr><td>'.$text.'</td><td><a class="create-ticket-btn" href="index.php?option=com_jsptickets&views=jsptickets&controller=jsptickets&task=dashboard_fb_ticket&postid='.$i->id.'">'.JText::_('CREATE_TICKET').'</a>'.'</td></tr>';
																		}
																	}
																}
															}
														}
													}//if context ends here
													?>
											</tbody>
										</table>
									</div>
							</td>
							<?php } ?>
							<?php if($config[0]->gen_twitter_tickets) {?>
							<td colspan="2" width="50%">
									<table style="width:100%;"class="table-head twitter">
										<thead>
												<tr><th><?php echo JText::_('JSPTICKETS_TWITTER');?></th></tr>
										</thead>
									</table>
									<div class="twitter-feeds custom-scroll-1">
										<table style="width:100%;">
											<tbody>
												<?php
												if($config[0]->twitter_screenname != "" && $config[0]->custom_twitter_consumerkey != "" && $config[0]->custom_twitter_consumersecret != "" && $config[0]->custom_twitter_accesstoken != "" && $config[0]->custom_twitter_accesstoken_secret != "")
												{
														require_once(JPATH_PLUGINS."/system/jsptickets/twitteroauth-libs/twitteroauth.php"); //Path to twitteroauth library
														$config_array = array();
														$config_array['twitter_screenname'] = $config[0]->twitter_screenname;
														$notweets = 20;
														
														$consumerkey = $config[0]->custom_twitter_consumerkey;
														$consumersecret = $config[0]->custom_twitter_consumersecret;
														$accesstoken = $config[0]->custom_twitter_accesstoken;
														$accesstokensecret = $config[0]->custom_twitter_accesstoken_secret;	
																										
														$connection = $this->getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
														$tweets = $connection->get("https://api.twitter.com/1.1/search/tweets.json?q=%40".$config_array['twitter_screenname']."&count=".$notweets."&result_type=mixed");
														
														if(isset($tweets->statuses))
														{
															foreach($tweets->statuses AS $tweet)
															{
																$tweetid = $tweet->id_str;         // tweet id
																
																$query = 'SELECT EXISTS(SELECT * FROM `#__jsptickets_ticket` WHERE `tweet_id` = "' . $tweetid . '") AS `exists`';
																$db->setQuery($query);
																$ticketexists = $db->loadobjectlist();
																$tc_exists = $ticketexists[0]->exists;
															
																if($tc_exists)
																{
																	if($tweet->text == null)
																	{
																		//echo '<tr><td>Sorry!</td></tr>';
																	} else {
																		echo '<tr><td>'.$tweet->text.'</td><td><div class="created-ticket-btn whatever_u_like">'.JTEXT::_('TICKET_CREATED').'</div></td><tr>';												
																	}
																} else {
																	if($tweet->text == null)
																	{
																		//echo '<tr><td>Sorry!</td></tr>';
																	} else { 	
																		echo '<tr><td>'.$tweet->text.'</td><td><a class="create-ticket-btn" href="index.php?option=com_jsptickets&controller=jsptickets&task=dashboard_twitter_ticket&twitter_acc='.$config_array['twitter_screenname'].'&tweetid='.$tweet->id_str.'">'.JText::_('CREATE_TICKET').'</a></td><tr>';
																	}
																}
															}
														} else {
															//echo "Sorry!";
														}
												}//if context ends here	
												 ?>
											</tbody>
										</table>
									</div>
							</td>
							<?php } ?>
						</tr>
						
						<tr><td colspan="4"><!--BLANK SPACE--></td></tr>
						
						<tr>
							<td colspan="2" width="50%">
									<table style="width:100%;" class="table-head recent-activities">
										<thead>
												<tr><th colspan="2"><?php echo JText::_('RECENT_ACTIVITIES');?></th></tr>
										</thead>
									</table>
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
												echo  '<tr><td><div id="recent-activities-msg"><span class="notification"><b>'. JText::_("NO_DATA_FOUND_NOTIFICATION") .'</b></span><div></td></tr>';
												}?>
											</tbody>
										</table>
									</div>
							</td>
							
							<td colspan="2" width="50%">
									<table style="width:100%;"class="table-head nrml-feeds">
										<thead>
												<tr><th><?php echo JText::_('JSPTICKETS_FEEDS');?></th></tr>
										</thead>
									</table>
									<div class="feeds-data custom-scroll-1">
										<table style="width:100%;">
											<tbody>
												<?php
													echo '<tr><td>'.JText::_('JSPTICKETS_FEEDS_PENDING_TICKETS')." ".$this->getfeeds_pendingtickets().'</td></tr>';
													echo '<tr><td>'.JText::_('JSPTICKETS_FEEDS_NEW_TICKETS')." ".$this->countnewtickets().'</td></tr>';
													echo '<tr><td>'.JText::_('JSPTICKETS_FEEDS_GUEST_TICKETS')." ".$this->countguesttickets().'</td></tr>';
													echo '<tr><td>'.JText::_('JSPTICKETS_FEEDS_COMMENTED_TICKETS')." ".$this->getfeeds_commentedtickets().'</td></tr>';
													echo '<tr><td>'.JText::_('JSPTICKETS_FEEDS_FEEDBACKS_TICKETS')." ".$this->getfeeds_feedbacktickets().'</td></tr>';
													echo '<tr><td>'.JText::_('JSPTICKETS_FEEDS_COMMENTS')." ".$this->getfeeds_comments().'</td></tr>';
													echo '<tr><td>'.JText::_('JSPTICKETS_FEEDS_FEEDBACKS')." ".$this->getfeeds_feedbacks().'</td></tr>';
												?>
											</tbody>
										</table>
									</div>
							</td>
						</tr>
						
						<tr><td colspan="4"><!--BLANK SPACE--></td></tr>
						<!--
						<tr>
							<td colspan="4">
								<table class="table-head comments" style="width:100%;">
										<thead>
												<tr><th><i class="icon-comments"></i><?php echo JText::_('JSPTICKETS_RECENTCOMMENTS');?></th></tr>
										</thead>
								</table>
								<div class="comments-grid custom-scroll-1">
									<?php /*
									$arr = $this->getComments();
									if($arr != null)
									{
										foreach($arr AS $i)
											{
												if(isset($last_ticketid) && $last_ticketid != $i->id) // horizontal row appears whenever comments on new ticket starts 
												{
													echo '<div class="ticket-comment-break"></div>';
												}
												if($i->id != "")
												{
														$date = date("d-M-Y H:i:s", strtotime($i->comment_date));
														
														if( $i->comment_created_by != $i->created_for && $i->comment_created_by != 0) // differnt div style for user and administrator comments
														{
															echo '<div class="admin_comments">';
														} else {
															echo '<div class="user_comments">';
														}
														if( $i->comment_created_by == 0)
														{
															echo '<b>'.$i->guestname ." (Guest)</b> at ".$date .'<br/><br/>'.$i->comments .'<a href="index.php?option=com_jsptickets&controller=ticketlist&task=edit&ticketcode='.$this->getTCFromTId($i->id).'">'.JText::_("READ_MORE").'</a><br/>'; 
														}
														else {
															echo '<b>'.$this->getUserById( $i->comment_created_by ) ."</b> at ".$date .'<br/><br/>'.$i->comments .'<a href="index.php?option=com_jsptickets&controller=ticketlist&task=edit&ticketcode='.$this->getTCFromTId($i->id).'">'.JText::_("READ_MORE").'</a>'; 
														}
														echo '</div>';
												}
												$last_ticketid = $i->id;
											}
										}
									*/ ?>
								</div>
							</td>
						</tr>
						-->
					</tbody>
				</table>
			</div>
			<!-- STATISTICS CONTENT ENDS HERE -->
		</td>
	</tr>
</tbody>
</table>
<div>
<input type="hidden" name="option" value="com_jsptickets" />
<input type="hidden" name="controller" value="jsptickets" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHtml::_('form.token'); ?>
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