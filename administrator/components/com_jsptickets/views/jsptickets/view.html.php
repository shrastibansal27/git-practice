<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: view.html.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the JSP Tickets Component
 */
class jspticketsViewjsptickets extends JViewLegacy
{
        // Overwriting JView display method
        function display($tpl = null) 
        {
		 JToolBarHelper::title( JText::_('JSP_TICKETS') ,'jsptickets');
		 JToolBarHelper::preferences('com_jsptickets');
		 parent::display($tpl);
		}
		
		function about($tpl = null) 
        {
		 JToolBarHelper::title( JText::_('JSP_TICKETS') ,'jsptickets');
		 parent::display($tpl);
		}
		function countnewtickets()
		{
			$db = JFactory::getDBO();
			$query = "select count(*) AS `count` from `#__jsptickets_ticket` where `status_id` = 1 ";
			$db->setQuery($query);	
			$data = $db->loadObject();
			if(isset($data->count))
				return $data->count;
			else
				return 0;
		}
		
		function countopentickets()
		{
			$db = JFactory::getDBO();
			$query = "select count(*) AS `count` from `#__jsptickets_ticket` where `status_id` = 3 ";
			$db->setQuery($query);	
			$data = $db->loadObject();
			if(isset($data->count))
				return $data->count;
			else
				return 0;
		}
		
		function countfacebooktickets()
		{
			$db = JFactory::getDBO();
			$query = 'SELECT count(*) AS `count` FROM `#__jsptickets_ticket` WHERE `guestemail` LIKE "%@facebook.com%";';
			$db->setQuery($query);	
			$data = $db->loadObject();
			if(isset($data->count))
				return $data->count;
			else
				return 0;
		}
		
		function counttwittertickets()
		{
			$db = JFactory::getDBO();
			$query = 'SELECT count(*) AS `count` FROM `#__jsptickets_ticket` WHERE `guestemail` LIKE "%@twitter.com%";';
			$db->setQuery($query);	
			$data = $db->loadObject();
			if(isset($data->count))
				return $data->count;
			else
				return 0;
		}
		
		function counttotaltickets()
		{
			$db = JFactory::getDBO();
			$query = "select count(*) AS `count` from `#__jsptickets_ticket` ";
			$db->setQuery($query);	
			$data = $db->loadObject();
			if(isset($data->count))
				return $data->count;
			else
				return 0;
		}
		
		function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) 
		{
			$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
			return $connection;
		}
		
		function countguesttickets()
		{
			$db = JFactory::getDBO();
			$query = "select count(*) AS `count` from `#__jsptickets_ticket` where `created_by` = 0 ";
			$db->setQuery($query);	
			$data = $db->loadObject();
			if(isset($data->count))
				return $data->count;
			else
				return 0;
		}
		
		function getrecentactivities()
		{
			$date = JFactory::getDate();
			$currtimestamp = $date->Format("Y-m-d");
			$db = JFactory::getDBO();
			$query = 'select `a`.*, `t`.* from `#__jsptickets_audit` `a` LEFT JOIN `#__jsptickets_ticket` `t` ON `a`.`ticket_id` = `t`.`id` WHERE DATE(`a`.`created`) LIKE "' . $currtimestamp . '" ORDER BY `a`.`created` DESC' ;
			$db->setQuery($query);	
			$rows = $db->loadObjectList();
			return $rows;
		}
		
		function getfeeds_pendingtickets()
		{
			$db = JFactory::getDBO();
			$query = 'select count(*) AS `count` from `#__jsptickets_ticket` WHERE `assigned_to` = 0' ;
			$db->setQuery($query);	
			$rows = $db->loadObject();
			if(isset($rows->count))
				return $rows->count;
			else
				return 0;
		}	
		
		function getfeeds_commentedtickets()
		{
			$date = JFactory::getDate();
			$currtimestamp = $date->Format("Y-m-d");
			$db = JFactory::getDBO();
			//$query = 'select count(*) AS `count` from `#__jsptickets_comments` WHERE DATE(`created`) LIKE "' . $currtimestamp . '" GROUP BY `ticket_id`' ;
			
			$query = 'SELECT COUNT( * ) AS count FROM #__jsptickets_comments WHERE DATE(created) =  "'.$currtimestamp.'"';
			
							
			$db->setQuery($query);	
			$rows = $db->loadObject();
			
			if(isset($rows->count))
				return $rows->count;
			else
				return 0;
		}
		
		function getfeeds_feedbacktickets()
		{
			$date = JFactory::getDate();
			$currtimestamp = $date->Format("Y-m-d");
			$db = JFactory::getDBO();
			//$query = 'select count(*) AS `count` from `#__jsptickets_feedbacks` WHERE DATE(`created`) LIKE "' . $currtimestamp . '" GROUP BY `ticket_id`' ;
			
			
			$query = 'SELECT COUNT( * ) AS count FROM #__jsptickets_feedbacks WHERE DATE(created) =  "'.$currtimestamp.'"';
			
			$db->setQuery($query);	
			$rows = $db->loadObject();
			if(isset($rows->count))
				return $rows->count;
			else
				return 0;
		}
		
		function getfeeds_comments()
		{
			$date = JFactory::getDate();
			$currtimestamp = $date->Format("Y-m-d");
			$db = JFactory::getDBO();
			//$query = 'select count(*) AS `count` from `#__jsptickets_comments` WHERE DATE(`created`) LIKE "' . $currtimestamp . '"' ;
			
			$query = 'SELECT COUNT( * ) AS count FROM #__jsptickets_comments WHERE DATE(created) =  "'.$currtimestamp.'"';
			
			
			$db->setQuery($query);	
			$rows = $db->loadObject();
			if(isset($rows->count))
				return $rows->count;
			else
				return 0;
		}
		
		function getfeeds_feedbacks()
		{
			$date = JFactory::getDate();
			$currtimestamp = $date->Format("Y-m-d");
			$db = JFactory::getDBO();
			//$query = 'select count(*) AS `count` from `#__jsptickets_feedbacks` WHERE DATE(`created`) LIKE "' . $currtimestamp . '"' ;
			
			$query = 'SELECT COUNT( * ) AS count FROM #__jsptickets_feedbacks WHERE DATE(created) =  "'.$currtimestamp.'"';
			
			
			
			$db->setQuery($query);	
			$rows = $db->loadObject();
			if(isset($rows->count))
				return $rows->count;
			else
				return 0;
		}
		
		function getComments()
		{
			$arr = null;
			$db = JFactory::getDBO();
			$query = 'SELECT DISTINCT `ticket_id` FROM `#__jsptickets_comments` ORDER BY `created` DESC LIMIT 0 , 5';
			$db->setQuery($query);	
			$rows = $db->loadObjectList();
					
			foreach($rows AS $item)
			{
				$ticket_id = $item->ticket_id;
				$sql = 'SELECT `c`.`comments`, `c`.`created_by` AS `comment_created_by`, `c`.`created` AS `comment_date` , `t`.* FROM `#__jsptickets_comments` `c` LEFT JOIN `#__jsptickets_ticket` `t` ON `c`.`ticket_id` = `t`.`id` WHERE `c`.`ticket_id` = '.$ticket_id .' ORDER BY `c`.`created` ASC' ;
				$db->setQuery($sql);	
				$data = $db->loadObjectList();
				
				$arr = array_merge((array)$arr, (array)$data);
			}
			return $arr;
		}
		
		function getTCFromTId($id = null)
		{
			$db = JFactory::getDBO();
			$query = 'SELECT `ticketcode` FROM `#__jsptickets_ticket` WHERE `id` LIKE '. $id ;
			$db->setQuery($query);
			$data = $db->loadObject();
			if(isset($data->ticketcode))
			{
				return $data->ticketcode;
			} else {
				return 0;
			}
		}
		
		function ticketexists($id = null)
		{
			$db = JFactory::getDBO();
			$query = 'SELECT `id` FROM `#__jsptickets_ticket` WHERE `id` LIKE '. $id ;
			$db->setQuery($query);
			$data = $db->loadObject();
			if(isset($data->id))
			{
				return 1;
			} else {
				return 0;
			}
		}
		
		function getUserById($id = null)
		{
			$db = JFactory::getDBO();
			$query = 'SELECT `username` AS `un` FROM `#__users` WHERE `id` LIKE '. $id ;
			$db->setQuery($query);
			$data = $db->loadObject();
			return $data->un;
		}
}