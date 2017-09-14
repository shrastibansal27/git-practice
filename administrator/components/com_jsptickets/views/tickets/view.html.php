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
jimport('joomla.html.pane');
jimport('joomla.filesystem.file');
jimport('joomla.html.pagination');
jimport( 'joomla.access.access' ); // for using JAccess finding users according to groups
jimport( 'joomla.user.user' ); // for retrieving users info
 
/**
 * HTML View class for the JSP Tickets Component
 */
class jspticketsViewtickets extends JViewLegacy
{
        // Overwriting JView display method
        function display($tpl = null) 
        {
			$session = JFactory::getSession(); // needed for guest user
			$mainframe = JFactory::GetApplication();      //needed for search
			$user = JFactory::getUser();
			$context = JRequest::getVar('option');
			$model = $this->getModel();
			$post = JRequest::get('post');
			
			$this->search = $mainframe->getUserStateFromRequest($context.'filter_search', 'filter_search', '', 'post');
			//$this->filterCat = $mainframe->getUserStateFromRequest($context.'fltr_category', 'fltr_category', '', 'post');
			
			if( $session->get("fltr_type") != "" )
			{
				$this->filterType= $session->get("fltr_type");
			} else {
				$this->filterType= "";
			}
			if( $session->get("fltr_category") != "" )
			{
				$this->filterCat= $session->get("fltr_category");
			} else {
				$this->filterCat= "";
			}
			if( $session->get("fltr_priority") != "" )
			{
				$this->filterPriority= $session->get("fltr_priority");
			} else {
				$this->filterPriority = "";
			}
			if( $session->get("fltr_status") != "" )
			{
				$this->filterStatus=$session->get("fltr_status");
			} else {
				$this->filterStatus = "";
			}
			if( $session->get("fltr_assigned_to") != "" )
			{
				$this->filterAssigned_to=$session->get("fltr_assigned_to");
			} else {
				$this->filterAssigned_to = "";
			}
			if($session->get("fltr_follow_up") != "")
			{
				$this->filterFollow_up=$session->get("fltr_follow_up");
			} else {
				$this->filterFollow_up="";
			}
			//$this->filterCat=$this->filterPriority=$this->filterStatus=$this->filterAssigned_to=$this->filterFollow_up="";
			
			/* if(isset($post['jform']['fltr_category']))
			$this->filterCat = $post['jform']['fltr_category'];
			if(isset($post['jform']['fltr_follow_up']))
			$this->filterFollow_up = $post['jform']['fltr_follow_up'];
			if(isset($post['jform']['fltr_priority']))
			$this->filterPriority = $post['jform']['fltr_priority'];
			if(isset($post['jform']['fltr_status']))
			$this->filterStatus = $post['jform']['fltr_status'];
			if(isset($post['jform']['fltr_assigned_to']))
			$this->filterAssigned_to = $post['jform']['fltr_assigned_to']; */
			
			/* Filter Value from dashboard */
			if(JRequest::getVar('dash_tictype') != null and JRequest::getVar('dash_tictype') != "")
			{
				$session->set( 'fltr_type', JRequest::getVar('dash_tictype') );
				$this->filterType = $session->get("fltr_type");
				$session->set( 'fltr_status', '' );
				$this->filterStatus = $session->get("fltr_status");
			}
			/* Filter Value from dashboard */
			if(isset($post['jform']['fltr_type']))
			{
				$session->set( 'fltr_type', $post['jform']['fltr_type'] );
				$this->filterType = $session->get("fltr_type");
			}
			if(isset($post['jform']['fltr_category']))
			{
				$session->set( 'fltr_category', $post['jform']['fltr_category'] );
				$this->filterCat = $session->get("fltr_category");
			}
			if(isset($post['jform']['fltr_follow_up']))
			{
				$session->set( 'fltr_follow_up', $post['jform']['fltr_follow_up'] );
				$this->filterFollow_up = $session->get("fltr_follow_up");
			}
			if(isset($post['jform']['fltr_priority']))
			{
				$session->set( 'fltr_priority', $post['jform']['fltr_priority'] );
				$this->filterPriority = $session->get("fltr_priority");
			}
			/* Filter Value from dashboard */
			if(JRequest::getVar('dash_ticstat') != null and JRequest::getVar('dash_ticstat') != "")
			{
											
				$session->set( 'fltr_type', '' );
				$this->filterType = $session->get("fltr_type");
							
				$session->set( 'fltr_status', JRequest::getVar('dash_ticstat') );
				$this->filterStatus = $session->get("fltr_status");
											
				
			}
			/* Filter Value from dashboard*/
			if(isset($post['jform']['fltr_status']))
			{
				$session->set( 'fltr_status', $post['jform']['fltr_status'] );
				$this->filterStatus = $session->get("fltr_status");
			}
			if(isset($post['jform']['fltr_assigned_to']))
			{
				$session->set( 'fltr_assigned_to', $post['jform']['fltr_assigned_to'] );
				$this->filterAssigned_to = $session->get("fltr_assigned_to");
			}
			/* Filter Value from dashboard */
			if(JRequest::getVar('dash_list') != null and JRequest::getVar('dash_list') != "")
			{
				$session->set( 'fltr_type', '' );
				$this->filterType = $session->get("fltr_type");
				$session->set( 'fltr_status', '' );
				$this->filterStatus = $session->get("fltr_status");
			}
			/* Filter Value from dashboard */
			
			$this->listOrder = JRequest::getVar('filter_order');
			$this->listDirn = JRequest::getVar('filter_order_Dir');
			
			$this->fltr_count = $model->fltrCount( $this->listOrder, $this->listDirn, $this->search, $this->filterType, $this->filterCat, $this->filterFollow_up, $this->filterPriority, $this->filterStatus, $this->filterAssigned_to );
			$this->count = $model->getCount();
			
			$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
			$limitstart	= $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');
			
			if( ($this->search) || ($this->filterType != "") || ($this->filterCat != "") || ($this->filterPriority != "") || ($this->filterStatus != "") || ($this->filterAssigned_to != "") || ($this->filterFollow_up != "") )
			{
				$total = count($this->fltr_count);
			} else { 
				$total = $this->count;
			}
			
			$this->data = $model->getList( $this->listOrder, $this->listDirn, $this->search, $this->filterType, $this->filterCat, $this->filterFollow_up, $this->filterPriority, $this->filterStatus, $this->filterAssigned_to, $total );
			
			if($total <= $limit || $total <= $limitstart || $limit==0)
			{
				$limitstart = 0;
			}
			$this->addToolBarList();
			$this->config = $model->getConfig(); // get extension configuration
			$this->pagination = new JPagination($total, $limitstart, $limit);
			$this->form	= $this->get('Form');          //loads jform from model
			parent::display($tpl);
		}
		
		function form($tpl = null)
		{
			$session = JFactory::getSession(); // needed for guest user
			$mainframe = JFactory::GetApplication();
			$context = JRequest::getVar('option');
			$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
			$limitstart	= $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');
			$attachmenttotal = $feedbacktotal = $commenttotal = $total = 0;
			$model = $this->getModel();
			$config = $model->getConfig(); // get extension configuration
			
			$user = JFactory::getUser();
			if(JRequest::getVar('task') != 'add')
			{
				$ticketcode = JRequest::getVar('ticketcode');
				$rowid = JRequest::getVar('cid',  0, '', 'array');
				if($ticketcode == null and $rowid != null)
				{
					$ticketcode = $rowid[0];
				}
			} else $ticketcode = null;
			
			$this->attach = '';
			$this->feed = '';
			$this->comments = '';
			$this->ticketid = '';
			$this->ticketcode = '';
			$this->tickettitle = '';
			$this->ticketsubject = '';
			$this->ticketcategory_extension = '';
			$this->ticketcategory_id = '';
			$this->ticketpriority_id = '';
			$this->ticketstatus_id = '';
			$this->ticketassigned_to = '';
			$this->ticketcreated = '';
			$this->ticketcreated_by = '';
			$this->ticketcreated_for = '';
			$this->ticketdescription = '';
			$this->ticketemail_comment = '';
			$this->tickettweet_id = '';
			$this->tickettwitter_username = '';
			
			if( $ticketcode != 0 and $ticketcode != null)
			{
				$data = $model->getFormData($ticketcode); // get data related to ticket
				$this->ticketid = $data[0]->id;				
				if( isset($data[0]->checked_out) && $data[0]->checked_out != 0 && $user->id != $data[0]->checked_out)
				{
					$msg = JText::_("TICKET_LOCKED");
					$mainframe->redirect("index.php?option=com_jsptickets&task=ticketlist" , $msg, "ERROR");
				}
				
				
				
				
				$model->lockticket($ticketcode);//set lock to the ticket if the ticket is not locked earlier				
				
				if($this->ticketid != ""){
				
				$this->attach = $model->getFormAttachments($this->ticketid); // get attachments related to that ticket 
				$this->feed = $model->getFormFeedbacks($this->ticketid); // get feedback related to that ticket
				$this->comments = $model->getFormComments($this->ticketid); // get  comments related to that ticket
				$total = $model->getLogTotal($this->ticketid);
				$commenttotal = $model->getCommentsTotal($this->ticketid);
				$feedbacktotal = $model->getFeedbacksTotal($this->ticketid);
				$attachmenttotal = $model->getAttachmentTotal($this->ticketid);
				
				$this->log = $model->getFormLog($this->ticketid,$total); // get audit related to that ticket
				}
				
				$this->ticketcode = $data[0]->ticketcode;
				$this->tickettitle = $data[0]->title;
				$this->ticketsubject = $data[0]->subject;
				$this->ticketcategory_extension = $data[0]->category_extension;
				$this->ticketcategory_id = json_decode($data[0]->category_id);
				$this->ticketpriority_id = $data[0]->priority_id;
				$this->ticketstatus_id = $data[0]->status_id;
				$this->ticketassigned_to =  $data[0]->assigned_to;
				$this->ticketcreated = $data[0]->created;
				$this->ticketcreated_by = $data[0]->created_by;
				$this->ticketcreated_for = $data[0]->created_for;
				if(($this->ticketcreated_for == "" || $this->ticketcreated_for == 0) && isset($data[0]->created_by))
				{
					$this->ticketcreated_for = $data[0]->created_by;
				}
				$this->ticketdescription = $data[0]->description;
				$this->ticketemail_comment = $data[0]->email_comment;
				$this->ticketguestname = $data[0]->guestname;
				$this->ticketguestemail = $data[0]->guestemail;
				$this->tickettweet_id = $data[0]->tweet_id;
				$this->tickettwitter_username = $data[0]->twitter_username;
				
				if( JRequest::getVar('editfeedbackid') != '' )
				{
					$this->editfeedbackid = JRequest::getVar('editfeedbackid');
					$this->feededit = $model->getFeedbackData($this->editfeedbackid);
				} else {
					$this->editfeedbackid = '';
				}
				
				if( JRequest::getVar('editcommentid') != '' )
				{
					$this->editcommentid = JRequest::getVar('editcommentid');
					$this->commentedit = $model->getCommentData($this->editcommentid);
				} else {
					$this->editcommentid = '';
				}
			}
			
			$statusList = null;
			$statusList = array_merge( (array)$statusList, (array)$model->selectedstatusList($config[0]->status, $this->ticketstatus_id));
			$this->list['status']    = JHTML::_('select.genericlist',$statusList, 'jform[status]', 'class="required" aria-required="true"','id', 'name', $this->ticketstatus_id, 'jform_status' );
			
			//$categoryList        = array_merge( $categoryList, $model->selectedcategoryList($this->ticketcategory_extension) );
			$categoryList = null;
			$categoryList = array_merge( (array)$categoryList, (array)$model->selectedcategoryList($config[0]->category_extension, $this->ticketcategory_id) );
			$this->list['category']    = JHTML::_('select.genericlist',$categoryList, 'category_id[]', 'class="required" aria-required="true" multiple="multiple"','id', 'title', $this->ticketcategory_id );
			
			$this->config = $config;
			$this->pagination = new JPagination($total, $limitstart, $limit);
			$this->commentpagination = new JPagination($commenttotal, $limitstart, $limit);
			$this->attachmentpagination = new JPagination($attachmenttotal, $limitstart, $limit);
			$this->feedbackpagination = new JPagination($feedbacktotal, $limitstart, $limit);
			//$pane = & JPane::getInstance('Tabs', array(), true);
			//$this->assignRef('pane',$pane);
			$this->addToolBarForm();
			$this->form	= $this->get('Form');          //loads jform from model
			parent::display($tpl);
		}
		
		function addToolBarList()
		{
			JToolBarHelper::title( JText::_('TICKETLIST') ,'ticketlist');
			JToolBarHelper::editList();
			JToolBarHelper::addNew();
			JToolBarHelper::checkin();
			JToolBarHelper::custom('follow', 'follow-big.png', '', 'Follow', true);
			JToolBarHelper::custom('unfollow', 'unfollow-big.png', '', 'Unfollow', true);
			JToolBarHelper::deleteList();
			JToolBarHelper::cancel('cancel', 'Close');
		}
		
		function addToolBarForm()
		{
			$edit = (JRequest::getVar('task') == 'edit');
			//JToolBarHelper::title( JText::_('TICKETLIST') ,'generic.png');
			$cid =  JRequest::getVar( 'cid', array(0), '', 'array' );
			$controller = JRequest::getVar('controller');
			$controller =ucfirst($controller);
			$text = ( $edit ? JText::_( 'EDIT' ) : JText::_( 'NEW' ) );
			JToolBarHelper::title( JText::_( $controller .'   '.'Details') .': <small><small>[ '. $text .' ]</small></small>', 'generic.png' );
			JToolBarHelper::save();
			JToolBarHelper::apply();
			if ( $edit ) {
			// for existing items the button is renamed `close`
				JToolBarHelper::cancel( 'cancel', 'Close' );
				} else {
				JToolBarHelper::cancel();
				}
		}
		
		function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) 
		{
			$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
			return $connection;
		}
		
		function escape_string($query_input = null)
		{
			$search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
			$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
			return str_replace($search, $replace, $query_input);
		}
		
		function saveData()
		{
			require_once(JPATH_PLUGINS."/system/jsptickets/twitteroauth-libs/twitteroauth.php"); //Path to twitteroauth library
			$model = $this->getModel();
			$config = $model->getConfig();
			
			$consumerkey = $config[0]->custom_twitter_consumerkey;
			$consumersecret = $config[0]->custom_twitter_consumersecret;
			$accesstoken = $config[0]->custom_twitter_accesstoken;
			$accesstokensecret = $config[0]->custom_twitter_accesstoken_secret;
			
			$connection = $this->getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
			
			$mainframe = JFactory::GetApplication();
			$date = JFactory::getDate();
			$user = JFactory::getUser();
			$db = JFactory::getDBO();
			
			$task= JRequest::getVar('task');
			$post = JRequest::get('post');
			$post['description'] = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
			$post['description'] = str_replace('"','\"', $post['description']);
			$post['feedback'] = JRequest::getVar('feedback', '', 'post', 'string', JREQUEST_ALLOWRAW);
			$post['comments'] = JRequest::getVar('comments', '', 'post', 'string', JREQUEST_ALLOWRAW);
			$id = $post['jform']['id'];
			$ticketcode = $post['ticketcode'];
			
			if(isset($post['jform']['created_for'][0]))
			{
				$created_for = $post['jform']['created_for'][0];
			} else {
				$created_for = 0;
			}
			if(isset($post['jform']['assigned_to'][0]))
			{
				$assigned_to = $post['jform']['assigned_to'][0];
			} else {
				$assigned_to = 0;
			}
			if( isset($post['jform']['email_comment']) and $post['jform']['email_comment'] != null and $post['jform']['email_comment'] != 0 )
			{
				$email_comment = $post['jform']['email_comment'];
			} else {
				$email_comment = 0;
			}
			
			$jinput = JFactory::getApplication()->input;
			$files  = $jinput->files->get('jform');
			$file   = $files['attachment'];
			$filesize = $file['size'];	
			
			$extarr = null;
			$f = 0;
			foreach($post['category_id'] AS $icat)
			{
				$ex = $this->getExtByCat($icat);
				if(!in_array($ex, (array)$extarr))
				{
					$extarr[$f++] = $ex;
				}
			}
			$extstr = json_encode($extarr);
			
			// for storing category in array format in table for joining during category search
			
			$category = json_encode($post['category_id']);
			
			$currtimestamp = $date->Format("Y-m-d H:i:s");
			
			$newname = '';
			if( isset( $file['name'] ) && $file['name'] != null ){
						$safefilename = JFile::makeSafe($file['name']);
						$imageext =  JFile::getExt($safefilename);
						$name = JFile::stripExt($safefilename);
						$timestamp = strtotime(date('Y-m-d H:i:s'));
						$newname = JFile::makeSafe( $name . '_' . $timestamp . '.' . $imageext );
				} else {
				if(isset($post['post_attachment']) and $post['post_attachment'] != null)
					$newname = $post['post_attachment'];
			}
			
			if($post['description'] == null)  //if ticket description is null
				$mainframe->redirect("index.php?option=com_jsptickets&controller=ticketlist&task=edit&ticketcode=".$ticketcode , JText::_("TICKET_DESCRIPTION_EMPTY"), "ERROR");
			
			
			// Uploading attachment file
			
			$src = $file['tmp_name'];
			
			$dest = JPATH_ROOT . '/' . "images" . '/' . "jsp_tickets" . '/' . "attachments" . '/' . $newname;
			
			$allowedext= explode(",", $config[0]->file_types);
			
			if( isset($safefilename) && $safefilename != null )
			{   //check file extension for the uploaded file
				if (  in_array( strtolower($imageext), $allowedext ) ) {
					//check filesize not to be greater than 25 mb
					if( $filesize > 25000000 ){
						$mainframe->redirect( "index.php?option=com_jsptickets&controller=ticketlist&task=edit&ticketcode=".$ticketcode , JText::_("FILESIZE_GREATER_THAN_25MB"), "ERROR" );
					} else {
						if ( JFile::upload($src, $dest) ) {
							//Redirect to a page of your choice
						} else {
							//Redirect and throw an error message
							$mainframe->redirect( "index.php?option=com_jsptickets&controller=ticketlist&task=edit&ticketcode=".$ticketcode , JText::_("FILE_COUNDNOT_BE_UPLOADED"), "ERROR" );
						}
					}
				} else {
					$mainframe->redirect( "index.php?option=com_jsptickets&controller=ticketlist&task=edit&ticketcode=".$ticketcode , JText::_("FILE_EXTENSION_NOT_ALLOWED"), "ERROR" );
				}
			}
			// condition for new or edit ticket starts here
			if( $id )            // if a ticket is being edited
			{	
				$aid0 = $this->getattachmentids($id);
				$fid0 = $this->getfeedbackids($id);
				$cid0 = $this->getcommentids($id);
				
				$aid=$fid=$coid='';
				// insert attachment details and use its attachment id below as $aid
				if( isset($newname) && $newname != null)
				{
					$query = 'INSERT INTO `#__jsptickets_attachements` (`ticket_id`, `attachement_name`, `created`, `created_by`) VALUES (' . $id . ', "' . $newname . '", "' . $currtimestamp. '", ' . $user->id. ');';
					$db->setQuery($query);
					if (!$db->query()) 
					{
						JError::raiseError( 500, $db->getErrorMsg() );
					}
					$aid = $db->insertid();
					
					//call log function to create log on attachment added
					$logid = $model->createLog($id , 'attachment', '');
				}
				
				//first check if feedback is open in edit mode or new entry is taking place
				if( isset($post['edit_feedbackid']) && $post['edit_feedbackid'] != null )
				{
					$post['feedback'] = str_replace('"','\"', $post['feedback']);
					$query = 'UPDATE `#__jsptickets_feedbacks` SET `feedbacks` = "'.$post['feedback'].'", `rating` = ' . $post['jform']['ratings'] . ' WHERE `id` = ' . $post['edit_feedbackid'] .';';
					$db->setQuery($query);
					if (!$db->query()) 
					{
						JError::raiseError( 500, $db->getErrorMsg() );
					}
					
					//call log function to create log on feedback update
					$logid = $model->createLog($id , 'feedback_edit', '');
				}
				else
				{
					// insert feedback details and use its feedback id below as $fid
					if( isset($post['feedback']) && $post['feedback'] != null  )
					{
						$post['feedback'] = str_replace('"','\"', $post['feedback']);
						$query = 'INSERT INTO `#__jsptickets_feedbacks` (`ticket_id`, `feedbacks`, `rating`, `created`, `created_by`) VALUES (' . $id . ', "' . $post['feedback'] . '", '. $post['jform']['ratings'] .', "' . $currtimestamp. '", ' . $user->id. ');';
						$db->setQuery($query);
						if (!$db->query()) 
						{
							JError::raiseError( 500, $db->getErrorMsg() );
						}
						$fid = $db->insertid();
						
						//call log function to create log on feedback added
						$logid = $model->createLog($id , 'feedback', '');
					}
				}
				
				//first check if comment is open in edit mode or new entry is taking place
				if( isset($post['edit_commentid']) && $post['edit_commentid'] != null )
				{
					$post['comments'] = str_replace('"','\"', $post['comments']);
					$query = 'UPDATE `#__jsptickets_comments` SET `comments` = "'.$post['comments'].'" WHERE `id` = ' . $post['edit_commentid'] .';';
					$db->setQuery($query);
					if (!$db->query()) 
					{
						JError::raiseError( 500, $db->getErrorMsg() );
					}
					
					//call log function to create log on comment update
					$logid = $model->createLog($id , 'comment_edit', '');
				} else	{
					// insert comment details and use its comment id below as $coid
					if( isset($post['comments']) && $post['comments'] != null  )
					{
						$post['comments'] = str_replace('"','\"', $post['comments']);
						$query = 'INSERT INTO `#__jsptickets_comments` (`ticket_id`, `comments`, `created`, `created_by`) VALUES (' . $id . ', "' . $post['comments'] . '", "' . $currtimestamp. '", ' . $user->id. ');';
						$db->setQuery($query);
						if (!$db->query()) 
						{
							JError::raiseError( 500, $db->getErrorMsg() );
						}
						$coid = $db->insertid();
						
						if(isset($post['twitter_username']) && ($post['twitter_username'] != null || $post['twitter_username'] != '')) // if the ticket is from twitter
						{
						$str = urlencode("@".$post['twitter_username'] ." ".$post['comments']);
						$updatetweet = $connection->post("https://api.twitter.com/1.1/statuses/update.json?status=".$str);	
						}
						
						//call log function to create log on comment added
						$logid = $model->createLog($id , 'comment', '');
					}
				}
				
				if( isset($newname) && $newname != null)
					$naid = array_merge((array)$aid0[0],(array)$aid);
				else $naid = $aid0[0];
				
				if( isset($post['feedback']) && $post['feedback'] != null  )
					$nfid = array_merge((array)$fid0[0],(array)$fid);
				else $nfid = $fid0[0];
				
				if( isset($post['comments']) && $post['comments'] != null  )
					$ncid = array_merge((array)$cid0[0],(array)$coid);
				else $ncid = $cid0[0];
				
				$naid = json_encode($naid);
				$nfid = json_encode($nfid);
				$ncid = json_encode($ncid);
				
				if( $post['jform']['status'] == 2 )			
					$query = 'UPDATE `#__jsptickets_ticket` SET `ticketcode` = "'. $post['ticketcode'] .'", `title` = "'. $this->escape_string($post['jform']['title']) . '", `subject` = "'. $this->escape_string($post['jform']['subject']) .'", `description` = "'. $post['description'] .'", `category_extension` = ' . "'" . $extstr . "'" .', `category_id` = '. "'" . $category . "'" . ', `priority_id` = '. $post['jform']['priority'] . ', `status_id` = '. $post['jform']['status'] . ', `attachment_id` = "'. $naid . '", `feedback_id` = "'. $nfid . '", `comment_id` = "'. $ncid . '", `created` = "'. $post['created'] . '", `created_by` = '. $post['created_by'] . ', `created_for` = ' . $created_for . ', `modified` = "'. $currtimestamp . '", `assigned_by` = '. $user->id . ', `assigned_to` = '. $assigned_to . ', `closed` = "'. $currtimestamp . '", `closed_by` = '. $user->id . ', `email_comment` = "' . $email_comment . '" WHERE `id` = ' . $id .';';
				else
					$query = 'UPDATE `#__jsptickets_ticket` SET `ticketcode` = "'. $post['ticketcode'] .'", `title` = "'. $this->escape_string($post['jform']['title']) . '", `subject` = "'. $this->escape_string($post['jform']['subject']) .'", `description` = "'. $post['description'] .'", `category_extension` = ' . "'" . $extstr . "'" .', `category_id` = '. "'" . $category . "'" . ', `priority_id` = '. $post['jform']['priority'] . ', `status_id` = '. $post['jform']['status'] . ', `attachment_id` = "'. $naid . '", `feedback_id` = "'. $nfid . '", `comment_id` = "'. $ncid . '", `created` = "'. $post['created'] . '", `created_by` = '. $post['created_by'] . ', `created_for` = ' . $created_for . ', `modified` = "'. $currtimestamp . '", `assigned_by` = '. $user->id . ', `assigned_to` = '. $assigned_to . ', `email_comment` = "' . $email_comment . '" WHERE `id` = ' . $id .';';
				$db->setQuery($query);
				if (!$db->query()) 
				{
					JError::raiseError( 500, $db->getErrorMsg() );
				}
				
				//call log function to create log on ticket reopen
				if($post['post_status'] == 2 and $post['post_status'] != $post['jform']['status'])
				{
					$logid = $model->createLog($id , 'reopen', '');
					$sql = "UPDATE `#__jsptickets_ticket` SET `closed` = '0000-00-00 00:00:00', `closed_by` = '0' WHERE `id` = " . $id;
					$db->setQuery($sql);
					if (!$db->query()) 
					{
						JError::raiseError( 500, $db->getErrorMsg() );
					}
				}
					
				//call log function to create log on ticket assignee change
				if($post['post_assigned_to'] != $assigned_to)
				{
					$logid = $model->createLog($id , 'assigned_changed', $assigned_to);
				}
				
				//call log function to create log on ticket edited
				$logid = $model->createLog($id , 'edit', '');
				
				// if new comment is added at any condition and comment is to be sent through mail
				if($config[0]->email_notification == 1) 
				{
					if($post['post_assigned_to'] != $assigned_to) // send mail if assigned manager changes
					{
						$assignedtomail = $this->SendMailFunction("assignedto_changed", $id, $post['ticketcode'], $category, $post['jform']['title'], $post['comments'], $post['jform']['subject'], $post['description'], $user->id, $created_for, $assigned_to, $config[0]->new_mail_subject, $config[0]->new_mail_body);
					}
					if($coid != '' and $email_comment != 0 )
					{
						$commentmail = $this->SendMailFunction("newcomment", $id, $post['ticketcode'], $category, $post['jform']['title'], $post['comments'], $post['jform']['subject'], $post['description'], $user->id, $created_for, $assigned_to, $config[0]->new_mail_subject, $config[0]->new_mail_body);
					}
				}
			} else { // if a new ticket is being added
				$aid=$fid=$coid='';
				// insert attachment details and use its attachment id below as $aid
				if( isset($newname) && $newname != null)
				{
					$query = 'INSERT INTO `#__jsptickets_attachements` (`attachement_name`, `created`, `created_by`) VALUES ("' . $newname . '", "' . $currtimestamp. '", ' . $user->id. ');';
					$db->setQuery($query);
					if (!$db->query()) 
					{
						JError::raiseError( 500, $db->getErrorMsg() );
					}
					$aid = $db->insertid();
				}
				// insert feedback details and use its feedback id below as $fid
				if( isset($post['feedback']) && $post['feedback'] != null  )
				{
					$post['feedback'] = str_replace('"','\"', $post['feedback']);
					$query = 'INSERT INTO `#__jsptickets_feedbacks` (`feedbacks`, `rating`, `created`, `created_by`) VALUES ("' . $post['feedback'] . '", '. $post['jform']['ratings'] .', "' . $currtimestamp. '", ' . $user->id. ');';
					$db->setQuery($query);
					if (!$db->query()) 
					{
						JError::raiseError( 500, $db->getErrorMsg() );
					}
					$fid = $db->insertid();
				}
				// insert comment details and use its comment id below as $coid
				if( isset($post['comments']) && $post['comments'] != null  )
				{
					$post['comments'] = str_replace('"','\"', $post['comments']);
					$query = 'INSERT INTO `#__jsptickets_comments` (`comments`, `created`, `created_by`) VALUES ("' . $post['comments'] .'", "' . $currtimestamp. '", ' . $user->id. ');';
					$db->setQuery($query);
					if (!$db->query()) 
					{
						JError::raiseError( 500, $db->getErrorMsg() );
					}
					$coid = $db->insertid();
				}
				
				$naid[] = (array)$aid;
				$nfid[] = (array)$fid;
				$ncid[] = (array)$coid;
				$naid = json_encode($naid);
				$nfid = json_encode($nfid);
				$ncid = json_encode($ncid);
				
				$ticketcodedid =  uniqid("", false);
				
				if( $post['jform']['status'] == 2 )
					$query = 'INSERT INTO `#__jsptickets_ticket` (`ticketcode`, `title`, `subject`, `description`, `category_extension`, `category_id`, `priority_id`, `status_id`, `attachment_id`, `feedback_id`, `comment_id`, `created`, `created_by`, `created_for`, `modified`, `assigned_by`, `assigned_to`, `closed`, `closed_by`, `email_comment`) VALUES ("'. $ticketcodedid .'", "' . $this->escape_string($post['jform']['title']) . '", "' . $this->escape_string($post['jform']['subject']). '", "' . $post['description']. '", ' . "'". $extstr . "', '" . $category . "'" . ', ' . $post['jform']['priority'] . ', ' . $post['jform']['status'] . ', "' . $naid . '", "' . $nfid . '", "' . $ncid . '", "' . $currtimestamp . '", ' . $user->id . ", " . $created_for . ', "' . $currtimestamp . '", ' . $user->id . ", " . $assigned_to . ", " . '"' . $currtimestamp . '", ' . $user->id . ', "' . $email_comment . '");';
				else
					$query = 'INSERT INTO `#__jsptickets_ticket` (`ticketcode`, `title`, `subject`, `description`, `category_extension`, `category_id`, `priority_id`, `status_id`, `attachment_id`, `feedback_id`, `comment_id`, `created`, `created_by`, `created_for`, `modified`, `assigned_by`, `assigned_to`, `email_comment`) VALUES ("'. $ticketcodedid .'", "' . $this->escape_string($post['jform']['title']) . '", "' . $this->escape_string($post['jform']['subject']). '", "' . $post['description'] . '", ' . "'". $extstr . "', '" . $category . "'" .', ' . $post['jform']['priority'] . ', ' . $post['jform']['status'] . ', "' . $naid . '", "' . $nfid . '", "' . $ncid . '", "' . $currtimestamp . '", ' . $user->id . ", " . $created_for .  ', "' . $currtimestamp . '", ' . $user->id . ", " . $assigned_to . ', "' . $email_comment . '");';
				$db->setQuery($query);
				if (!$db->query()) 
				{
					JError::raiseError( 500, $db->getErrorMsg() );
				}
				$id = $db->insertid();	                //gets the latest id of the ticket
				
				$query = "select `ticketcode` from `#__jsptickets_ticket` where `id` LIKE " . $id . " ORDER BY `created` DESC" ;
				$db->setQuery($query);	
				$data = $db->loadObject();
				
				$ticketcode = $data->ticketcode;
				
				//call log function to create log on new ticket
				$logid = $model->createLog($id , 'new', '');
				//call log function to create log on assignment of ticket
				$logid = $model->createLog($id , 'assigned', $assigned_to);
				
				if($aid != '')
				{
					$query = 'UPDATE `#__jsptickets_attachements` SET `ticket_id` = '. $id . ' WHERE `id` = ' . $aid .';';
					$db->setQuery($query);
					if (!$db->query()) 
					{
						JError::raiseError( 500, $db->getErrorMsg() );
					}
					
					//call log function to create log on attachment added
					$logid = $model->createLog($id , 'attachment', '');
				}
				
				if($fid != '')
				{
					$query = 'UPDATE `#__jsptickets_feedbacks` SET `ticket_id` = '. $id . ' WHERE `id` = ' . $fid .';';
					$db->setQuery($query);
					if (!$db->query()) 
					{
						JError::raiseError( 500, $db->getErrorMsg() );
					}
					
					//call log function to create log on feedback added
					$logid = $model->createLog($id , 'feedback', '');
				}
				
				if($coid != '')
				{
					$query = 'UPDATE `#__jsptickets_comments` SET `ticket_id` = '. $id . ' WHERE `id` = ' . $coid .';';
					$db->setQuery($query);
					if (!$db->query()) 
					{
						JError::raiseError( 500, $db->getErrorMsg() );
					}
					
					//call log function to create log on comment added
					$logid = $model->createLog($id , 'comment', '');
				}
				
				// send data to mailing function on creation of new ticket
				if( $config[0]->email_notification == 1 )
				{
					$sendmail = $this->SendMailFunction("new" , $id, $ticketcode, $category, '', '', $post['jform']['subject'], $post['description'], $user->id, $created_for, $assigned_to, $config[0]->new_mail_subject, $config[0]->new_mail_body);
					
					// if new comment is added at any condition and comment is to be sent through mail
					if($coid != '' and $email_comment != 0) 
					{
						$commentmail = $this->SendMailFunction("newcomment", $id, $ticketcode, $category, $post['jform']['title'], $post['comments'], $post['jform']['subject'], $post['description'], $user->id, $created_for, $assigned_to, $config[0]->new_mail_subject, $config[0]->new_mail_body);
					}
				}				
			}  // condition for new or edit ticket ends here
			
			if( $post['jform']['status'] == 2 )
			{ 
				//call log function to create log on ticket close
				$logid = $model->createLog($id , 'close', '');
			}
			
			switch($task)
			{
				case 'save':
				case 'default':
					$model->unlockticket($ticketcode); //unlock the ticket
					$msg = JText::_("TICKET_SAVED_SUCCESSFULLY");
					$mainframe->redirect('index.php?option=com_jsptickets&task=ticketlist', $msg, "message");
				break;
				
				case 'apply':
					$msg = JText::_("TICKET_SAVED_SUCCESSFULLY");
					$mainframe->redirect('index.php?option=com_jsptickets&controller=ticketlist&task=edit&ticketcode='. $ticketcode, $msg, "message");	
				break;
		    }
		}
		
		function getExtByCat($cat_id = null)
		{
			$db = JFactory::getDBO();
			$query = 'SELECT `extension` FROM `#__categories` WHERE `id` LIKE '. $cat_id ;
			$db->setQuery($query);
			$data = $db->loadObject();
			return $data->extension;
		}
		
		function ticketcategory($cat_id = null)
		{
			$db = JFactory::getDBO();
			$query = 'SELECT `title`, `extension` FROM `#__categories` WHERE `id` LIKE '. $cat_id ;
			$db->setQuery($query);
			$data = $db->loadObjectlist();
			//return $data[0]->title .' [' . ucfirst(str_replace('com_', '', $data[0]->extension)) . ']' ;
			return ucfirst(str_replace('com_', '', $data[0]->extension)) . " - " . $data[0]->title ;
		}
		
		function ticketpriority($priority_id = null)
		{
			$db = JFactory::getDBO();
			$query = 'SELECT `name` AS `priority` FROM `#__jsptickets_priorities` WHERE `id` LIKE '. $priority_id ;
			$db->setQuery($query);
			$data = $db->loadObject();
			return $data->priority;
		}
		
		function ticketstatus($status_id = null)
		{
			$db = JFactory::getDBO();
			$query = 'SELECT `name` AS `status` FROM `#__jsptickets_status` WHERE `id` LIKE '. $status_id ;
			$db->setQuery($query);
			$data = $db->loadObject();
			return $data->status;
		}
		
		function getUserById($id = null)
		{
			$db = JFactory::getDBO();
			$query = 'SELECT `username` AS `un` FROM `#__users` WHERE `id` LIKE '. $id ;
			$db->setQuery($query);
			$data = $db->loadObject();
			return $data->un;
		}
		
		function getRatingById($id = null)
		{
			switch($id)
			{
				case 1: $rating = JText::_('RATING1');
				break;
				case 2: $rating = JText::_('RATING2');
				break;
				case 3: $rating = JText::_('RATING3');
				break;
				case 4: $rating = JText::_('RATING4');
				break;
				case 5: $rating = JText::_('RATING5');
				break;
				default: $rating = JText::_('RATING3');
				break;
			}
			return $rating;
		}	

		function getattachmentids($id = null)
		{
			$db = JFactory::getDBO();
			$query = 'SELECT `attachment_id` FROM `#__jsptickets_ticket` WHERE `id` LIKE '. $id ;
			$db->setQuery($query);
			$data = $db->loadObject();
			return json_decode($data->attachment_id);
		}
		
		function getfeedbackids($id = null)
		{
			$db = JFactory::getDBO();
			$query = 'SELECT `feedback_id` FROM `#__jsptickets_ticket` WHERE `id` LIKE '. $id ;
			$db->setQuery($query);
			$data = $db->loadObject();
			return json_decode($data->feedback_id);
		}
		
		function getcommentids($id = null)
		{
			$db = JFactory::getDBO();
			$query = 'SELECT `comment_id` FROM `#__jsptickets_ticket` WHERE `id` LIKE '. $id ;
			$db->setQuery($query);
			$data = $db->loadObject();
			return json_decode($data->comment_id);
		}
		
		function follow()
		{
			$mainframe = JFactory::GetApplication();
			$rowid = JRequest::getVar('cid',  0, '', 'array');
			$model = $this->getModel();
			$config = $model->getConfig();
			foreach($rowid as $id)
			{
				$model->follow($id);
			}
			$msg = JText::_("FOLLOWED_SUCCESSFULLY");
			$mainframe->redirect( "index.php?option=com_jsptickets&task=ticketlist" , $msg, "message" );
		}		
		
		function unfollow()
		{ 
			$mainframe = JFactory::GetApplication();
			$rowid = JRequest::getVar('cid',  0, '', 'array');
			$model = $this->getModel();
			$config = $model->getConfig();
			foreach($rowid as $id)
			{
				$model->unfollow($id);
			}
			$msg = JText::_("UNFOLLOWED_SUCCESSFULLY");
			$mainframe->redirect( "index.php?option=com_jsptickets&task=ticketlist" , $msg, "message" );
		}		
		
		function remove()
		{
			$mainframe = JFactory::GetApplication();
			$rowid = JRequest::getVar('cid',  0, '', 'array');
			$model = $this->getModel();
			$config = $model->getConfig();
			foreach($rowid as $id)
			{
				$model->remove($id);
			}
			$msg = JText::_("DELETED_SUCCESSFULLY");
			$mainframe->redirect( "index.php?option=com_jsptickets&task=ticketlist" , $msg, "message" );
		}
		
		function SendMailFunction($mtask = null, $id = null, $ticketcode = null, $category = null, $ticket_title = null, $comment = null, $ticket_sub = null, $ticket_desc = null, $created_by = 0, $created_for = 0, $assigned_to = 0, $configuser_mail_subject = null, $configuser_mail_body = null) 
		{
			$config = JFactory::getConfig();
			$db = JFactory::getDBO();
			$model = $this->getModel();
			
			$ticketconfig = $model->getConfig(); // getting extensions configuration
			
			$sendemail = $ticketconfig[0]->email_notification;
			$emailids = $ticketconfig[0]->admin_email_id;
			$Email = explode(",",$emailids); // admin emails in array form
			$catstring = '';
						
			$catids = json_decode($category);   // catids stores the categories ids of the ticket in decoded form
			    foreach($catids as $cid)  // foreach category
				{
					$data2 = $model->getCategoryById($cid); 
					$catstring.= $data2->title . ',';
				}
				
			if($mtask == "assignedto_changed")  // if this function is called in assigned to change
			{
				if( $catstring != '')	// if category string is not empty
				{
					$mod_mail_sub = $ticketconfig[0]->assignee_changed_mail_subject . ' of  Ticket Id :- ' . $ticketcode .'  for [ Category/s :- ' . $catstring . " ]";
					$mod_mail_body = $ticketconfig[0]->assignee_changed_mail_body . "<br/>" . '<b>Subject</b> :- ' . $ticket_sub . "<br/>" . '<b>Message</b> :- ' . $ticket_desc ;
				} else {
					$mod_mail_sub = $ticketconfig[0]->assignee_changed_mail_subject . ' of  Ticket Id :- ' . $ticketcode . '  for ' . $config->get( 'config.sitename' );
					$mod_mail_body = $ticketconfig[0]->assignee_changed_mail_body . "<br/>" . '<b>Subject</b> :- ' . $ticket_sub . "<br/>" . '<b>Message</b> :- ' . $ticket_desc ;
				}
				if($assigned_to != 0)
				{
					$mto = JFactory::getUser($assigned_to)->email; // email of direct moderator of the ticket to whom the ticket is assigned to
				} else {
					$mto = "";
				}
				if($mto != "")
				{
					$this->Send_Mail($mto, $mod_mail_sub, $mod_mail_body); // only to assigned to Moderators email addresses
				}
				return ; // no need to proceed further return control
			} else if($mtask == "new")	{ // check mail task for "new ticket" or "new comment" 
				if( $catstring != '')	// if category string is not empty
				{
					$admin_mail_sub = JText::_('ADMIN_MAIL_SUBJECT') . " [ Category/s :- " . $catstring . " ]" . '  Ticket Id :- ' . $ticketcode;
					$admin_mail_body = '<b>Subject</b> :- ' . $ticket_sub . "<br/>" . '<b>Message</b> :- ' . $ticket_desc ;
					$mod_mail_sub = JText::_('MOD_MAIL_SUBJECT') . ' of  Ticket Id :- ' . $ticketcode ."  for [ Category/s :- " . $catstring . " ]";
					$mod_mail_body = '<b>Subject</b> :- ' . $ticket_sub . "<br/>" . '<b>Message</b> :- ' . $ticket_desc ;
				} else {
					$admin_mail_sub = JText::_('ADMIN_MAIL_SUBJECT') . ' ' . $config->get( 'config.sitename' ) . '  Ticket Id :- ' . $ticketcode;
					$admin_mail_body = '<b>Subject</b> :- ' . $ticket_sub . "<br/>" . '<b>Message</b> :- ' . $ticket_desc ;
					$mod_mail_sub = JText::_('MOD_MAIL_SUBJECT') . ' of  Ticket Id :- ' . $ticketcode . '  for ' . $config->get( 'config.sitename' );
					$mod_mail_body = '<b>Subject</b> :- ' . $ticket_sub . "<br/>" . '<b>Message</b> :- ' . $ticket_desc ;
				}
			} else if($mtask == "newcomment") {
				$admin_mail_sub = $ticketconfig[0]->comment_mail_subject . ' Ticket Id :- ' . $ticketcode;
				$admin_mail_body = $ticketconfig[0]->comment_mail_body . "<br/>" . '<b> Ticket Title </b> :- ' . $ticket_title . "<br/>" . '<b> Comment </b> :- ' . $comment ;
				$mod_mail_sub = $ticketconfig[0]->comment_mail_subject . ' Ticket Id :- ' . $ticketcode;
				$mod_mail_body = $ticketconfig[0]->comment_mail_body . "<br/>" . '<b> Ticket Title </b> :- ' . $ticket_title . "<br/>" . '<b> Comment </b> :- ' . $comment ;
			}
			
			if($assigned_to != 0)
			{
				$mto = JFactory::getUser($assigned_to)->email; // email of direct moderator of the ticket to whom the ticket is assigned to
			} else {
				$mto = "";
			}
			
			//if(isset($category_ext) and $category_ext == "com_jsptickets") // if a category is from "com_jsptickets" or not
			//{
				$categoryids = $catids; // transferring json decoded category ids to categoryids
				$ToEmail = null;
				foreach($categoryids as $cid)  // foreach category search usergroups assigned
				{
					
					$data4 = $model->getCategoryById($cid); // gets category details from each category id
					$params = json_decode($data4->params);
					
					if(isset($params->assigned_to) && ($params->assigned_to != null || $params->assigned_to != "")) {
						$ugids = json_decode($params->assigned_to); // Array of usergroups assigned
					
						foreach($ugids as $ugid) // foreach usergroup search users assigned
						{
							$uids = JAccess::getUsersByGroup($ugid);
							if(isset($uids) and $uids != null) // check if any user is present in that group or not
							{
								foreach($uids as $uid) // foreach user put its email in an array
								{
									$ToEmail[$uid] = JFactory::getUser($uid)->email;
								}
							}
						}
					}
				}
				
				if($mto != "")
				{
					$ToEmail = array_merge((array)$ToEmail,(array)$mto); // merge emails of the category moderators with the assigned to mail id
				}
				
				$adminto = (array)$Email; // only to administrators email addresses
				$this->Send_Mail($adminto, $admin_mail_sub, $admin_mail_body);
				
				$modto = (array)$ToEmail; // only to Moderators email addresses
				$this->Send_Mail($modto, $mod_mail_sub, $mod_mail_body);
			/*}
			else
			{
				$adminto = (array)$Email ; // only to administrators email addresses
				$this->Send_Mail($adminto, $admin_mail_sub, $admin_mail_body);
				
				if($mto != "")
				{
					$this->Send_Mail($mto, $mod_mail_sub, $mod_mail_body); // only to assigned to Moderators email addresses
				}
			}*/
			
			if($mtask == "new") // check mail task for new ticket or new comment
			{
				$user_mail_sub = $configuser_mail_subject . ' ' . $config->get( 'config.sitename' ) . ' Ticket Id :- ' . $ticketcode;
				$user_mail_body = $configuser_mail_body;
			} else if($mtask == "newcomment")	{
				$user_mail_sub = $ticketconfig[0]->comment_mail_subject . ' Ticket Id :- ' . $ticketcode;
				$user_mail_body = $ticketconfig[0]->comment_mail_body . "<br/>" . '<b> Ticket Title </b> :- ' . $ticket_title . "<br/>" . '<b> Comment </b> :- ' . $comment ;
			}
			
			if( ($created_by == $created_for or $created_for == 0) and $created_by != 0 ) // check for registered user only
			{
				$uto = JFactory::getUser($created_by)->email;
			} else {
				$uto = JFactory::getUser($created_for)->email;
			}
			
			if( $created_by == 0 ) // check for guest users only
			{
				$uto = $guestemail;
			}
			$userto = (array)$uto;
			$this->Send_Mail($userto, $user_mail_sub, $user_mail_body); // only to users email addresses
			
			return ;
		}
	
	function Send_Mail($to = null, $subject = null, $body = null)
	{
		$config = JFactory::getConfig();
		$mailer = JFactory::getMailer();
		
		//$fromEmail = $config->get( 'config.mailfrom' );
		//$fromName = $config->get( 'config.fromname' );
		
		$fromEmail = $config->get('mailfrom');
        $fromName = $config->get('fromname');
		
		//$test = JUtility::sendMail($fromEmail, $fromName, $to, $subject, $body,1);
		
		$sender = array( 
			$fromEmail,
			$fromName
			);
		
		$mailer->setSender($sender);
		$mailer->addRecipient($to);
		$mailer->setSubject($subject);
		$mailer->isHTML(true);
		$mailer->Encoding = 'base64';
		$mailer->setBody($body);

		$test = $mailer->Send();
		$mailer->ClearAddresses();
		
		return ;
	}
}