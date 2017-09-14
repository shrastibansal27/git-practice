<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: tickets.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
jimport( 'joomla.application.component.modelform' );
jimport( 'joomla.user.user' ); // for retrieving users info
jimport( 'joomla.filesystem.file' );

class jspticketsModeltickets extends JModelForm {
	
	public function __construct($config = array()) 
	 { 
		 if (empty($config['filter_fields'])) { 
		 $config['filter_fields'] = array( 
		 'id', 'a.id',
		 'ticketcode', 'a.ticketcode',
		 'title', 'a.title', 
		 'subject', 'a.subject', 
		 'description', 'a.description',
		 'category_extension', 'a.category_extension',
		 'category_id', 'a.category_id',
		 'priority_id', 'a.priority_id',
		 'status_id', 'a.status_id',
		 'attachment_id', 'a.attachment_id',
		 'feedback_id', 'a.feedback_id',
		 'comment_id', 'a.comment_id',
		 'created', 'a.created',
		 'created_by', 'a.created_by',
		 'created_for', 'a.created_for',
		 'modified', 'a.modified',
		 'assigned_by', 'a.assigned_by',
		 'assigned_to', 'a.assigned_to',
		 'closed', 'a.closed',
		 'closed_by', 'a.closed_by',
		 'checked_out', 'a.checked_out',
		 'checked_out_time', 'a.checked_out_time',
		 'email_comment','a.email_comment',
		 'follow_up', 'a.follow_up',
		 'guestname', 'a.guestname',
		 'guestemail', 'a.guestemail'
		 );
		}
	 parent::__construct($config);
	 }
	 
	 
	public function getForm($data = array(), $loadData = true)
        {
 
			$app = JFactory::getApplication();
 
			// Get the form.
            $form = $this->loadForm('com_jsptickets.tickets', 'tickets', array('control' => 'jform', 'load_data' => true));
            if (empty($form)) {
                return false;
            }
            return $form;
 
        }
		
	public function getCount()
	{
		$db = JFactory::getDBO();
		$query = 'SELECT count(*) AS `count` FROM `#__jsptickets_ticket`';
		$db->setQuery($query);
		$data = $db->loadObject();
		return $data->count;
	}
	
	public function getCheckEmptyList( $guestname, $guestemail, $ticketid  )
	{
		$mainframe = Jfactory::GetApplication();
		$context = JRequest::getVar('option');
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.id, a.ticketcode,
				 a.title, a.subject,
				 a.description, a.category_extension, a.category_id,
				 a.priority_id, a.status_id,
				 a.attachment_id, a.feedback_id,
				 a.comment_id, a.created,
				 a.created_by, a.created_for, a.modified,
				 a.assigned_by, a.assigned_to,
				 a.closed, a.closed_by,
				 a.checked_out, a.checked_out_time,
				 a.email_comment, a.follow_up,
				 a.guestname,a.guestemail'
			)
		);
		$query->from('#__jsptickets_ticket AS a');
								
		$db->setQuery( $query );
		$data = $db->loadObjectList();// Ticket list without user filtering
		
		/* filtering ticket list by users */
		$user = JFactory::getUser();
		if($user->id != 0)
		{
			$usergrp = $this->getUserGroupByUid($user->id);
		} else {
		$usergrp = "";
		}
		$assemble_ui="";
		$result="";
		//foreach ticket starts here
		foreach($data as $i=>$item)
		{ 
			if(isset($assemble_ui))
			{
				$assemble_ui = "";
			}
			if(!($usergrp == "Administrator" || $usergrp == "Super Users" || $user->id == 0)) //if nor the user is Admin or Super User or any Guest then apply the filtering
				{
					$categories = json_decode($item->category_id);
					foreach($categories AS $c=>$cat) //foreach category here you get the assigned groups
					{
						$category[$c] = $this->category_assigned_to($cat);
						$params = json_decode( $category[$c] );
						if(isset($params->assigned_to))
						{
							$str = json_decode($params->assigned_to);
							$assign_to_grp = $str[0];
							$uids = JAccess::getUsersByGroup($assign_to_grp); // gets array of user ids according to group mentioned
							foreach($uids as $ui)
							{
								if(!in_array( $ui, (array)$assemble_ui))
								{
									$assemble_ui[] = $ui;
								}
							}
						}
					}
					
					if( ($item->created_by == $user->id) || ($item->created_for == $user->id) || ($item->assigned_to == $user->id) || (in_array($user->id,(array)$assemble_ui) == 1))
					{
						$result[] = $item;
					}				
				} else if( ($usergrp == "Administrator" || $usergrp == "Super Users") ) { // show all if user is Super User or Admin
					$result[] = $item;
				} else { // if the user is Guest
										
					if( $ticketid != "" ) // Not to display list to guest b4 save widout ticketid
					{
						$vtid = $this->TicketidValidity($guestname, $guestemail, $ticketid);
						if($item->guestname == $guestname && $item->guestemail == $guestemail && $vtid != "") // show the tickets if both guest name and guest email are correct
						{
							$result[] = $item;
						}
					} else {
						if($item->guestname == $guestname && $item->guestemail == $guestemail) // return the empty result if both guest name and guest email are correct
						{
							$result = "";
						}
					}
				}
				//print_R($assemble_ui);
		}
		//foreach ticket ends here
		/* filtering ticket list by users */
		return $result; // Ticket list after user filtering
	}
	
	public function TicketidValidity($guestname = null, $guestemail = null, $ticketid = null)
	{
		$db		= $this->getDbo();
		$query = "SELECT `id` FROM `#__jsptickets_ticket` WHERE `ticketcode` = '". $ticketid ."' AND `guestname` = '". $guestname ."' AND `guestemail` = '". $guestemail ."';";
		$db->setQuery( $query );
		$data = $db->loadObject();
		if(isset($data->id))
		{
			return $data->id;
		} else {
			return "";
		}
	}
	
	function escape_string($query_input = null)
	{
		$search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
		$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
		return str_replace($search, $replace, $query_input);
	}
	
	public function getList($listOrder=null, $listDirn=null, $search, $typefilter, $catfilter, $filterFollow_up, $priorityfilter, $statusfilter, $assignedtofilter, $guestname, $guestemail, $total )
	{
		$mainframe = Jfactory::GetApplication();
		$context = JRequest::getVar('option');
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.id, a.ticketcode,
				 a.title, a.subject,
				 a.description, a.category_extension, a.category_id,
				 a.priority_id, a.status_id,
				 a.attachment_id, a.feedback_id,
				 a.comment_id, a.created,
				 a.created_by, a.created_for, a.modified,
				 a.assigned_by, a.assigned_to,
				 a.closed, a.closed_by,
				 a.checked_out, a.checked_out_time,
				 a.email_comment, a.follow_up,
				 a.guestname,a.guestemail'
			)
		);
		$query->from('#__jsptickets_ticket AS a');
		
		//Add the list filtering clause
		if( $this->escape_string($search) != null )
		{
			//$query->leftJoin( '#__categories AS c ON c.id IN a.category_id' );
			//$query->where( 'a.title LIKE "%'. $search . '%" OR a.subject LIKE "%'. $search . '%" OR c.title LIKE "%'. $search .'%"');
			$query->where( 'a.ticketcode LIKE "%'. $this->escape_string($search) . '%" OR a.title LIKE "%'. $this->escape_string($search) . '%" OR a.subject LIKE "%'. $this->escape_string($search) .'%"');
		}
		if( $typefilter != null )
		{
			if($typefilter == 1)
			{
				$query->where( 'a.guestemail NOT LIKE "%@facebook.com%" AND a.guestemail NOT LIKE "%@twitter.com%"' );
			}
			if($typefilter == 2)
			{
				$query->where( 'a.guestemail LIKE "%@facebook.com%"' );
			}
			if($typefilter == 3)
			{
				$query->where( 'a.guestemail LIKE "%@twitter.com%"' );
			}
		}
		if( $catfilter != null )
		{
		 $query->where( 'a.category_extension LIKE "%' . $catfilter . '%"' );
		}
		if( $filterFollow_up != null )
		{
			$query->where( 'a.follow_up LIKE ' . $filterFollow_up );
		}
		if( $priorityfilter != null )
		{
			$query->where( 'a.priority_id LIKE ' . $priorityfilter );
		}
		if( $statusfilter != null )
		{
		 $query->where( 'a.status_id LIKE ' . $statusfilter );
		}
		if( $assignedtofilter != null )
		{
		 $query->where( 'a.assigned_to LIKE ' . $assignedtofilter );
		}
				
		// Add the list ordering clause
		if($listOrder != null && $listDirn != null)
		{
			$query->order( $listOrder.' '.$listDirn );
		} else {
			$query->order( 'a.ticketcode desc' );
		}
		
				
		$db->setQuery( $query );		
		$data = $db->loadObjectList();// Ticket list without user filtering
		
		/* filtering ticket list by users */
		$user = JFactory::getUser();
		if($user->id != 0)
		{
			$usergrp = $this->getUserGroupByUid($user->id);
		} else {
		$usergrp = "";
		}
		$assemble_ui="";
		$result="";
		//foreach ticket starts here
		foreach($data as $i=>$item)
		{ 
			if(isset($assemble_ui))
			{
				$assemble_ui = "";
			}
			if(!($usergrp == "Administrator" || $usergrp == "Super Users" || $user->id == 0)) //if nor the user is Admin or Super User or any Guest then apply the filtering
				{
					$categories = json_decode($item->category_id);
					foreach($categories AS $c=>$cat) //foreach category here you get the assigned groups
					{
						$category[$c] = $this->category_assigned_to($cat);
						$params = json_decode( $category[$c] );
						if(isset($params->assigned_to))
						{
							$str = json_decode($params->assigned_to);
							$assign_to_grp = $str[0];
							$uids = JAccess::getUsersByGroup($assign_to_grp); // gets array of user ids according to group mentioned
							foreach($uids as $ui)
							{
								if(!in_array( $ui, (array)$assemble_ui))
								{
									$assemble_ui[] = $ui;
								}
							}
						}
					}
					
					/*echo '<pre>';
					echo "created_by ".$item->created_by.'<br/>';
					echo "created_for ".$item->created_for.'<br/>';
					echo "assigned_to ".$item->assigned_to.'<br/>';
					echo "condn. ". in_array($user->id,(array)$assemble_ui);
					echo '</pre>';*/
					if( ($item->created_by == $user->id) || ($item->created_for == $user->id) || ($item->assigned_to == $user->id) || (in_array($user->id,(array)$assemble_ui) == 1))
					{
						$result[] = $item;
					}				
				} else if( ($usergrp == "Administrator" || $usergrp == "Super Users") ) { // show all user is Super User or Admin
					$result[] = $item;
				} else { // if the user is Guest
					if($item->guestname == $guestname && $item->guestemail == $guestemail) // show the tickets if both guest name and guest email are correct
					{
						$result[] = $item;
					}
				}
				//print_R($assemble_ui);
		}
		//foreach ticket ends here
		if($total <= $limit || $total <= $limitstart || $limit==0)
		{
			$limitstart = 0;
		}
		
		/* filtering ticket list by users */
		if($result != "" && $limit!=0)
		{
			$result = array_splice($result, $limitstart, $limit);   // sets pagination to the filtered array
		}
		return $result; // Ticket list after user filtering
	}
	
	public function fltrCount($listOrder=null, $listDirn=null, $search, $typefilter, $catfilter, $filterFollow_up, $priorityfilter, $statusfilter, $assignedtofilter, $guestname, $guestemail )
	{
		$mainframe = Jfactory::GetApplication();
		$context = JRequest::getVar('option');
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.id, a.ticketcode,
				 a.title, a.subject,
				 a.description, a.category_extension, a.category_id,
				 a.priority_id, a.status_id,
				 a.attachment_id, a.feedback_id,
				 a.comment_id, a.created,
				 a.created_by, a.created_for, a.modified,
				 a.assigned_by, a.assigned_to,
				 a.closed, a.closed_by,
				 a.checked_out, a.checked_out_time,
				 a.email_comment, a.follow_up,
				 a.guestname,a.guestemail'
			)
		);
		$query->from('#__jsptickets_ticket AS a');
		
		//Add the list filtering clause
		if( $this->escape_string($search) != null )
		{
			$query->where( 'a.ticketcode LIKE "%'. $this->escape_string($search) . '%" OR a.title LIKE "%'. $this->escape_string($search) . '%" OR a.subject LIKE "%'. $this->escape_string($search) .'%"');
		}
		if( $typefilter != null )
		{
			if($typefilter == 1)
			{
				$query->where( 'a.guestemail NOT LIKE "%@facebook.com%" AND a.guestemail NOT LIKE "%@twitter.com%"' );
			}
			if($typefilter == 2)
			{
				$query->where( 'a.guestemail LIKE "%@facebook.com%"' );
			}
			if($typefilter == 3)
			{
				$query->where( 'a.guestemail LIKE "%@twitter.com%"' );
			}
		}
		if( $catfilter != null )
		{
		 $query->where( 'a.category_extension LIKE "%' . $catfilter . '%"' );
		}
		if( $filterFollow_up != null )
		{
			$query->where( 'a.follow_up LIKE ' . $filterFollow_up );
		}
		if( $priorityfilter != null )
		{
			$query->where( 'a.priority_id LIKE ' . $priorityfilter );
		}
		if( $statusfilter != null )
		{
		 $query->where( 'a.status_id LIKE ' . $statusfilter );
		}
		if( $assignedtofilter != null )
		{
		 $query->where( 'a.assigned_to LIKE ' . $assignedtofilter );
		}
				
		// Add the list ordering clause
		if($listOrder != null && $listDirn != null)
		$query->order( $listOrder.' '.$listDirn );
		
		$db->setQuery( $query );		
		$data = $db->loadObjectList();// Ticket list without user filtering
		
		/* filtering ticket list by users */
		$user = JFactory::getUser();
		if($user->id != 0)
		{
			$usergrp = $this->getUserGroupByUid($user->id);
		} else {
		$usergrp = "";
		}
		$assemble_ui="";
		$result="";
		//foreach ticket starts here
		foreach($data as $i=>$item)
		{ 
			if(isset($assemble_ui))
			{
				$assemble_ui = "";
			}
			if(!($usergrp == "Administrator" || $usergrp == "Super Users" || $user->id == 0)) //if nor the user is Admin or Super User or any Guest then apply the filtering
				{
					$categories = json_decode($item->category_id);
					foreach($categories AS $c=>$cat) //foreach category here you get the assigned groups
					{
						$category[$c] = $this->category_assigned_to($cat);
						$params = json_decode( $category[$c] );
						if(isset($params->assigned_to))
						{
							$str = json_decode($params->assigned_to);
							$assign_to_grp = $str[0];
							$uids = JAccess::getUsersByGroup($assign_to_grp); // gets array of user ids according to group mentioned
							foreach($uids as $ui)
							{
								if(!in_array( $ui, (array)$assemble_ui))
								{
									$assemble_ui[] = $ui;
								}
							}
						}
					}
					
					if( ($item->created_by == $user->id) || ($item->created_for == $user->id) || ($item->assigned_to == $user->id) || (in_array($user->id,(array)$assemble_ui) == 1))
					{
						$result[] = $item;
					}				
				} else if( ($usergrp == "Administrator" || $usergrp == "Super Users") ) { // show all user is Super User or Admin
					$result[] = $item;
				} else { // if the user is Guest
					if($item->guestname == $guestname && $item->guestemail == $guestemail) // show the tickets if both guest name and guest email are correct
					{
						$result[] = $item;
					}
				}
		}
		//foreach ticket ends here
		/* filtering ticket list by users */
		if($result != "")
		{
		// no pagination or array_splice() required as used for total count purpose
		}
		return $result; // Ticket list after user filtering
	}
	
	public function gettotaltickets( $guestname, $guestemail, $ticketid  )
	{
		$mainframe = Jfactory::GetApplication();
		$context = JRequest::getVar('option');
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.id, a.ticketcode,
				 a.title, a.subject,
				 a.description, a.category_extension, a.category_id,
				 a.priority_id, a.status_id,
				 a.attachment_id, a.feedback_id,
				 a.comment_id, a.created,
				 a.created_by, a.created_for, a.modified,
				 a.assigned_by, a.assigned_to,
				 a.closed, a.closed_by,
				 a.checked_out, a.checked_out_time,
				 a.email_comment, a.follow_up,
				 a.guestname,a.guestemail'
			)
		);
		$query->from('#__jsptickets_ticket AS a');
								
		$db->setQuery( $query );
		$data = $db->loadObjectList();// Ticket list without user filtering
		
		/* filtering ticket list by users */
		$user = JFactory::getUser();
		if($user->id != 0)
		{
			$usergrp = $this->getUserGroupByUid($user->id);
		} else {
		$usergrp = "";
		}
		$assemble_ui="";
		$result="";
		//foreach ticket starts here
		foreach($data as $i=>$item)
		{ 
			if(isset($assemble_ui))
			{
				$assemble_ui = "";
			}
			if(!($usergrp == "Administrator" || $usergrp == "Super Users" || $user->id == 0)) //if nor the user is Admin or Super User or any Guest then apply the filtering
				{
					$categories = json_decode($item->category_id);
					foreach($categories AS $c=>$cat) //foreach category here you get the assigned groups
					{
						$category[$c] = $this->category_assigned_to($cat);
						$params = json_decode( $category[$c] );
						if(isset($params->assigned_to))
						{
							$str = json_decode($params->assigned_to);
							$assign_to_grp = $str[0];
							$uids = JAccess::getUsersByGroup($assign_to_grp); // gets array of user ids according to group mentioned
							foreach($uids as $ui)
							{
								if(!in_array( $ui, (array)$assemble_ui))
								{
									$assemble_ui[] = $ui;
								}
							}
						}
					}
					
					if( ($item->created_by == $user->id) || ($item->created_for == $user->id) || ($item->assigned_to == $user->id) || (in_array($user->id,(array)$assemble_ui) == 1))
					{
						$result[] = $item;
					}				
				} else if( ($usergrp == "Administrator" || $usergrp == "Super Users") ) { // show all user is Super User or Admin
					$result[] = $item;
				} else { // if the user is Guest
					if($item->guestname == $guestname && $item->guestemail == $guestemail) // show the tickets if both guest name and guest email are correct
					{
						$result[] = $item;
					}
				}
		}
		//foreach ticket ends here
		/* filtering ticket list by users */
		return $result; // Ticket list after user filtering
	}
	
	
	function loadCategoryList($extId = null){
		$db = $this->getDBO();
		$query = "select id,title from #__categories WHERE published =1";
		if ($extId != null){
				$query = 'select id, 
				CONCAT(UPPER(SUBSTRING(replace(CONCAT(`extension`, " - ", `title`), "com_", ""), 1, 1)),LOWER(SUBSTRING(replace(CONCAT(`extension`, " - ", `title`), "com_", ""), 2))) as `title` 
				from #__categories where extension = "'.$extId.'" and published =1';
			}
		$query .= " ORDER BY title asc";
		$db->setQuery($query);	
		$rows = $db->loadObjectList();
		return $rows;
	}
	
	function getFormData($ticketcode = null)
	{
		$db = $this->getDBO();
		$query = "select * from `#__jsptickets_ticket` where `ticketcode` LIKE '" . $ticketcode. "'";
		$db->setQuery($query);	
		$rows = $db->loadObjectList();
		return $rows;
	}
	
	function getConfig()
	{
		$db = $this->getDBO();
		$query = "select * from `#__jsptickets_configuration` where `id` LIKE 1";
		$db->setQuery($query);	
		$rows = $db->loadObjectList();
		return $rows;
	}
	
	function selectedcategoryList($extensionlist = null, $selecteditems = null)
	{
		$extensionlist = json_decode($extensionlist);
		$arr = null;
		foreach($extensionlist AS $extension)
		{
			$db = $this->getDBO();
			$query = 'SELECT id, 
			CONCAT(UPPER(SUBSTRING(replace(CONCAT(`extension`, " - ", `title`), "com_", ""), 1, 1)),LOWER(SUBSTRING(replace(CONCAT(`extension`, " - ", `title`), "com_", ""), 2))) as `title` 
			from #__categories where extension = "'. $extension .'" AND `published` = 1';
			$query .= " ORDER BY title asc";
			$db->setQuery($query);	
			$rows = $db->loadObjectList();
			$arr = array_merge((array)$arr, (array)$rows);
		}
		if(isset($selecteditems) && $selecteditems != null && $selecteditems == '')
		{
			foreach($selecteditems AS $selecteditem)
			{
				if($selecteditem != null)
				{
					$query = 'SELECT id, 
					CONCAT(UPPER(SUBSTRING(replace(CONCAT(`extension`, " - ", `title`), "com_", ""), 1, 1)),LOWER(SUBSTRING(replace(CONCAT(`extension`, " - ", `title`), "com_", ""), 2))) as `title` 
					from #__categories where `id` = "'. $selecteditem .'"';
					$db->setQuery($query);	
					$selectedrow = $db->loadObjectList();
					foreach($arr AS $i)
					{
						if( $selectedrow[0]->id == $i->id)
						{
							$present = 1;
							break;
						} else {
							$present = -1;
						}
					}
				
					if($present == -1)
					{
						$arr = array_merge((array)$selectedrow, (array)$arr);
					}
				}
			}
		}
		return $arr;
	}
	
	
	function selectedstatusList($statuslist = null, $selecteditem = null)
	{
		$statuslist = json_decode($statuslist);
		$arr = null;
		$db = $this->getDBO();
		foreach($statuslist AS $sid)
		{
			$query = 'SELECT `id`, `name` from `#__jsptickets_status` where `id` = "'. $sid .'" AND `publish` = 1';
			$db->setQuery($query);	
			$rows = $db->loadObjectList();
			$arr = array_merge((array)$arr, (array)$rows);
		}
		if($selecteditem != null)
		{
			$query = 'SELECT `id`, `name` from `#__jsptickets_status` where `id` = "'. $selecteditem .'" AND `publish` = 1';
			$db->setQuery($query);	
			$selectedrow = $db->loadObjectList();
			foreach($arr AS $i)
			{
				if( $selectedrow[0]->id == $i->id)
				{
					$present = 1;
					break;
				} else {
					$present = -1;
				}
			}
		
			if($present == -1)
			{
				$arr = array_merge((array)$selectedrow, (array)$arr);
			}
		}
		return $arr;
	}	
	
	
	function createLog($id=null , $task=null, $uid=null)
	{
		$date = JFactory::getDate();
		$currtimestamp = $date->Format("Y-m-d H:i:s");
		switch($task)
			{
				case 'new': $narration = JText::_('LOG_NEW_TICKET_CREATED'); //--new
				break;
				case 'close': $narration = JText::_('LOG_TICKET_CLOSED'); //--both
				break;
				case 'reopen': $narration = JText::_('LOG_TICKET_REOPEN'); //1
				break;
				case 'edit': $narration = JText::_('LOG_TICKET_EDITED'); //--0
				break;
				case 'assigned': $narration = JText::_('LOG_TICKET_ASSIGNED_TO') . ' : ' . $this->getUserById($uid); //--new
				break;
				case 'assigned_changed': $narration = JText::_('LOG_TICKET_ASSIGNED_TO_CHANGED') . ' : ' . $this->getUserById($uid); //2
				break;
				case 'attachment': $narration = JText::_('LOG_ATTACHMENT_ADDED'); //--new
				break;
				case 'attachment_delete': $narration = JText::_('LOG_ATTACHMENT_DELETED'); //--5
				break;
				case 'feedback': $narration = JText::_('LOG_FEEDBACK_ADDED'); //--new
				break;
				case 'feedback_edit': $narration = JText::_('LOG_FEEDBACK_EDITED'); //3 
				break;
				case 'feedback_delete': $narration = JText::_('LOG_FEEDBACK_DELETED'); //6 
				break;
				case 'comment': $narration = JText::_('LOG_COMMENT_ADDED'); //--new
				break;
				case 'comment_edit': $narration = JText::_('LOG_COMMENT_EDITED'); //4
				break;
				case 'comment_delete': $narration = JText::_('LOG_COMMENT_DELETED'); //7
				break;
				default: $narration = '';
				break;
			}
		$db = JFactory::getDBO();
		$query = 'INSERT INTO `#__jsptickets_audit` (`ticket_id`, `narration`, `created`) VALUES (' . $id . ', "' . $narration . '", "' . $currtimestamp. '");';
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
		$logid = $db->insertid();
		return $logid;
	}
	
	function getFormAttachments($tid = null)
	{
		$mainframe = Jfactory::GetApplication();
		$context = JRequest::getVar('option');
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');
		$db = $this->getDBO();
		$query = "select * from `#__jsptickets_attachements` where `ticket_id` LIKE " . $tid . " ORDER BY `created` DESC" ;
		$total = $this->getAttachmentTotal($tid);
		if($total <= $limit || $total <= $limitstart || $limit==0)
		{
			$limitstart = 0;
		}
		$db->setQuery($query, $limitstart, $limit);	
		$rows = $db->loadObjectList();
		return $rows;
	}
	
	function getAttachmentTotal($tid = null)
	{
		$db = $this->getDBO();
		$query = "select count(*) AS `count` from `#__jsptickets_attachements` where `ticket_id` LIKE " . $tid . " GROUP BY `ticket_id`" ;
		$db->setQuery($query);	
		$rows = $db->loadObject();
		if(isset($rows->count))
		{
			return $rows->count;
		} else {
			return 0;
		}
	}
	
	function getFormFeedbacks($tid = null)
	{
		$mainframe = Jfactory::GetApplication();
		$context = JRequest::getVar('option');
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');
		$db = $this->getDBO();
		$query = "select * from `#__jsptickets_feedbacks` where `ticket_id` LIKE " . $tid . " ORDER BY `created` DESC" ;
		$total = $this->getFeedbacksTotal($tid);
		if($total <= $limit || $total <= $limitstart || $limit==0)
		{
			$limitstart = 0;
		}
		$db->setQuery($query, $limitstart, $limit);	
		$rows = $db->loadObjectList();
		return $rows;
	}
	
	function getFeedbacksTotal($tid = null)
	{
		$db = $this->getDBO();
		$query = "select count(*) AS `count` from `#__jsptickets_feedbacks` where `ticket_id` LIKE " . $tid . " GROUP BY `ticket_id`" ;
		$db->setQuery($query);	
		$rows = $db->loadObject();
		if(isset($rows->count))
		{
			return $rows->count;
		} else {
			return 0;
		}
	}
	
	function getFormComments($tid = null)
	{
		$mainframe = Jfactory::GetApplication();
		$context = JRequest::getVar('option');
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');
		$db = $this->getDBO();
		$query = "select * from `#__jsptickets_comments` where `ticket_id` LIKE " . $tid . " ORDER BY `created` DESC" ;
		$total = $this->getCommentsTotal($tid);
		if($total <= $limit || $total <= $limitstart || $limit==0)
		{
			$limitstart = 0;
		}
		$db->setQuery($query, $limitstart, $limit);	
		$rows = $db->loadObjectList();
		return $rows;
	}
	
	function getCommentsTotal($tid = null)
	{
		$db = $this->getDBO();
		$query = "select count(*) AS `count` from `#__jsptickets_comments` where `ticket_id` LIKE " . $tid . " GROUP BY `ticket_id`" ;
		$db->setQuery($query);	
		$rows = $db->loadObject();
		if(isset($rows->count))
		{
			return $rows->count;
		} else {
			return 0;
		}
	}
	
	function getLogTotal($tid = null)
	{
		$db = $this->getDBO();
		$query = "select count(*) AS `count` from `#__jsptickets_audit` where `ticket_id` LIKE " . $tid . " GROUP BY `ticket_id`" ;
		$db->setQuery($query);	
		$rows = $db->loadObject();
		if(isset($rows->count))
		{
			return $rows->count;
		} else {
			return 0;
		}
	}
	
	function getFormLog($tid = null,$total = null)
	{
		$db = $this->getDBO();
		$mainframe = JFactory::GetApplication();
		$context = JRequest::getVar('option');
		$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart	= $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');
		
		$query = "select * from `#__jsptickets_audit` where `ticket_id` LIKE " . $tid . " ORDER BY `id` DESC" ;
		//$db->setQuery($query);
		$total =  $this->getLogTotal($tid);
		
		if($total <= $limit || $total <= $limitstart || $limit==0)
			{
				$limitstart = 0;
			}
		$db->setQuery($query,$limitstart,$limit);	
		$rows = $db->loadObjectList();
		return $rows;
	}
	
	function getUserById($id = null)
	{
		$db = JFactory::getDBO();
		$query = 'SELECT `username` AS `un` FROM `#__users` WHERE `id` LIKE '. $id ;
		$db->setQuery($query);
		$data = $db->loadObject();
		if(isset($data->un) && $data->un != "")
		{
			return $data->un;
		} else {
			return "None";
		}
	}
	
	function removeattachment($id = null)
	{
		$db = JFactory::getDBO();
		
		$query = "SELECT `attachement_name` FROM `#__jsptickets_attachements` WHERE `id` = " . $id ;
		$db->setQuery($query);
		$data = $db->loadObject();
		$this->removeattachfiles($data->attachement_name);
		
		$query = 'DELETE FROM `#__jsptickets_attachements` WHERE `id` LIKE '. $id ;
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
	}
	
	function removeattachfiles($name = null)
	{
		$dest= JPATH_ROOT . '/images/jsp_tickets/attachments/' . $name;
		JFile::delete($dest);
		return;
	}
	
	function getFeedbackData($id = null)
	{
		$db = $this->getDBO();
		$query = "select * from `#__jsptickets_feedbacks` where `id` LIKE " . $id;
		$db->setQuery($query);	
		$rows = $db->loadObjectList();
		return $rows;
	}
	
	function getCommentData($id = null)
	{
		$db = $this->getDBO();
		$query = "select * from `#__jsptickets_comments` where `id` LIKE " . $id;
		$db->setQuery($query);	
		$rows = $db->loadObjectList();
		return $rows;
	}
	
	function removefeedback($id = null)
	{
		$db = $this->getDBO();
		$query = 'DELETE FROM `#__jsptickets_feedbacks` WHERE `id` LIKE '. $id ;
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
	}
	
	function removecomment($id = null)
	{
		$db = $this->getDBO();
		$query = 'DELETE FROM `#__jsptickets_comments` WHERE `id` LIKE '. $id ;
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
	}
	
	function lockticket($ticketcode = null)
	{
		$db = $this->getDBO();
		$date = JFactory::getDate();
		$user = JFactory::getUser();
		
		$currtimestamp = $date->Format("Y-m-d H:i:s");
		$uid = $user->id;
		
		$query = 'UPDATE `#__jsptickets_ticket` SET `checked_out` = ' . $uid . ', `checked_out_time` = "' . $currtimestamp .'" WHERE ticketcode ="' . $ticketcode . '";';
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
		return;
	}
	
	function unlockticket($ticketcode = null)
	{
		$db = $this->getDBO();
				
		$query = "UPDATE `#__jsptickets_ticket` SET `checked_out` ='', `checked_out_time` ='' WHERE ticketcode = '". $ticketcode ."';";
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
		return;
	}
	
	public function follow($id)
	{
		$db = JFactory::getDBO();
		$query = "UPDATE `#__jsptickets_ticket` SET `follow_up` = '1' WHERE `ticketcode` = '". $id . "'";
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
	}
	
	public function unfollow($id)
	{
		$db = JFactory::getDBO();
		$query = "UPDATE `#__jsptickets_ticket` SET `follow_up` = '0' WHERE `ticketcode` = '". $id . "'";
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
	}
	
	public function remove($ticketcode)
	{
		$db = JFactory::getDBO();
		
		$query = "Select `id` from `#__jsptickets_ticket` where `ticketcode` LIKE '" . $ticketcode ."'";
		$db->setQuery($query);	
		$data = $db->loadObject();
		$id = $data->id;
		
		$this->removeticketfiles($id);
		$query = "DELETE FROM `#__jsptickets_ticket` WHERE `id` = " . $id ;
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
		
		$query = 'DELETE FROM `#__jsptickets_attachements` WHERE `ticket_id` LIKE '. $id ;
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
		
		$query = 'DELETE FROM `#__jsptickets_feedbacks` WHERE `ticket_id` LIKE '. $id ;
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
		
		$query = 'DELETE FROM `#__jsptickets_comments` WHERE `ticket_id` LIKE '. $id ;
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
		
		$query = 'DELETE FROM `#__jsptickets_audit` WHERE `ticket_id` LIKE '. $id ;
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
	}
	
	public function removeticketfiles($ticket_id = null)
	{
		$db = JFactory::getDBO();
		
		$query = "SELECT `attachement_name` FROM `#__jsptickets_attachements` WHERE `ticket_id` = " . $ticket_id ;
		$db->setQuery($query);
		$data = $db->loadObjectlist();
		foreach($data as $item)
		{
			$this->removeattachfiles($item->attachement_name);
		}
		return;
	}
	
	public function getCategoryById($catid = null)
	{
		$db = JFactory::getDBO();
		
		$query = 'SELECT * FROM `#__categories` WHERE `id` = ' . $catid;
		$db->setQuery($query);
		$data2 = $db->loadObject();
		return $data2;
	}
	
	public function getGuestName($guestemail = null, $ticketcode = null)
	{
		$db = JFactory::getDBO();
		
		$query = "Select `guestname` from `#__jsptickets_ticket` where `guestemail` LIKE '" . $guestemail . "' AND `ticketcode` LIKE '" . $ticketcode ."'";
		$db->setQuery($query);	
		$data = $db->loadObject();
		$guestname = $data->guestname;
		return $guestname;
	}
	
	public function getUserGroupIdByUid($UserId = null)
	{
		$db = JFactory::getDBO();
		
		$query = 'SELECT g.id AS `id` from `#__usergroups` `g` JOIN `#__user_usergroup_map` `m` ON g.id = m.group_id WHERE m.user_id = ' . $UserId;
		$db->setQuery($query);
		$data = $db->loadObject();
		if(isset($data->id))
		{
			return $data->id;
		} else {
			return 0;
		}
	}
	
	public function getUserGroupByUid($UserId = null)
	{
		$db = JFactory::getDBO();
		
		$query = 'SELECT g.title AS `title` from `#__usergroups` `g` JOIN `#__user_usergroup_map` `m` ON g.id = m.group_id WHERE m.user_id = ' . $UserId;
		$db->setQuery($query);
		$data = $db->loadObject();
		return $data->title;
	}
	
	public function category_assigned_to($catid = null)
	{
		$db = JFactory::getDBO();
		$query = 'SELECT `params` FROM `#__categories` WHERE `id` LIKE '. $catid ;
		$db->setQuery($query);
		$data = $db->loadObject();
		return $data->params;
	}
	public function get_Ticketid_from_coded($ticketcode = null)
	{
		$db = JFactory::getDBO();
		$query = "Select `id` from `#__jsptickets_ticket` where `ticketcode` LIKE '" . $ticketcode ."'";
		$db->setQuery($query);	
		$data = $db->loadObject();
		return $data->id;
	}
}