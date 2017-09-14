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
 
/**
 * HTML View class for the JSP Tickets Component
 */
class jspticketsViewjsptickets extends JViewLegacy
{
        // Overwriting JView display method
        function display($tpl = null) 
        {
		 $app = JFactory::getApplication();
		 $urlitemid = JRequest::getVar('Itemid');
		if($urlitemid!="")
		{
			$expire= time() + (60*60*24*365);
			setcookie("cookie_itemid", $urlitemid, $expire);
		}
		 $session = JFactory::getSession(); // needed for guest user
		 $session->set( 'Itemid', $urlitemid );
         $model = $this->getModel();
		 $config = $model->getConfig(); // calling configuration function from model
		 
		 $this->urlitemid = $urlitemid;
		 $this->config = $config;
		 //$pane = JPane::getInstance('Tabs', array(), true);
		 //$this->assignRef('pane',$pane);
		 $this->form	= $this->get('Form');          //loads jform from model
		 parent::display($tpl);
		}
		
		public function genFBTickets()
		{						
			$date = JFactory::getDate();
			$db = JFactory::getDBO();
			$query = "SELECT * FROM #__jsptickets_configuration WHERE `id` = '1'";
			$db->setQuery($query);
			$config = $db->loadobjectlist();
									
			$currentdate = date("Y-m-d H:i:s");
			$narration = JText::_('LOG_NEW_TICKET_CREATED');
				
			$filter_array = explode( ',' , $config[0]->fb_filter_words );
			
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
						
			// you can only get the access to page data through these app details which you can get from registering to "developers.facebook.com"
			// and creating an app on it
			$app_id = $config[0]->fb_app_id;
			$app_secret = $config[0]->fb_app_secret;
			$latest_time = $config[0]->last_fbpost_time;
								
			//Get the contents of a Facebook page
			$access = file_get_contents('https://graph.facebook.com/oauth/access_token?client_id='.$app_id.'&client_secret='.$app_secret.'&grant_type=client_credentials');
			$access_token = explode("=",$access);
			$FBpage = file_get_contents('https://graph.facebook.com/' . $FBid . '/feed?access_token=' . $access_token[1] . '&limit=20&since=' . $latest_time);
			//Interpret data with JSON
			$FBdata = json_decode($FBpage);
			
			if($FBdata == null)
			{
				return;
			}
			
			$query = "SELECT `id` FROM #__categories WHERE `extension` LIKE 'com_jsptickets' AND `alias` LIKE 'uncategorised'";
			$db->setQuery($query);
			$catdata = $db->loadobjectlist();
			
			$naid = $nfid = $ncid = "";
			$created_for = $assigned_to = $email_comment = 0;
			$post['jform']['title'] = $config[0]->fb_ticket_title;
			$post['jform']['subject'] = $config[0]->fb_ticket_subject;
			$post['jform']['status'] = 1; // new
			
			$sql = "SELECT MIN(`id`) AS `id` FROM `#__jsptickets_priorities` WHERE `publish` = 1";
			$db->setQuery($sql);
			$priorityid = $db->loadObject();
			$post['jform']['priority'] = $priorityid->id;
			
			$post['jform']['category_extension'] = json_encode((array)"com_jsptickets");
			$category = json_encode((array)$catdata[0]->id);
			
			//$currtimestamp = $date->Format("Y-m-d H:i:s");
			
			foreach($FBdata AS $row)
			{
				foreach($row AS $i)
				{
					foreach($filter_array AS $key=>$filter_str)
					{
						if( isset( $i->message ) and strstr( strtolower($i->message), strtolower($filter_str) ) ) // if there is any related fb post
						{
							$fbuserid = $i->from->id;
							$post['guestname'] = $i->from->name;
																
							$userdetails = file_get_contents('https://graph.facebook.com/' . $i->from->id);
							$userdetails = json_decode($userdetails);
							
							$fbusername = $userdetails->username;
							if(isset($userdetails->username) && $userdetails->username != null)
							{
								$post['guestemail'] = $fbusername ."@facebook.com" ;
							} else {
								$post['guestemail'] = $fbuserid ."@facebook.com" ;
							}
							$fbpostid = $i->id;         // fb post id
							$post['description'] = $i->message;    // fb post
							if($latest_time < strtotime($i->created_time))
							{
								$latest_time = strtotime($i->created_time); // stores latest fb post time in Unix format stored in our database
							}
							
							$ticketcodedid =  uniqid("", false);    // later will be used in new tickets
							
							$query = 'SELECT EXISTS(SELECT * FROM `#__jsptickets_ticket` WHERE `fb_post_id` = "' . $fbpostid . '") AS `exists`';
							$db->setQuery($query);
							$ticketexists = $db->loadobjectlist();
							$tc_exists = $ticketexists[0]->exists;

							if($tc_exists)
							{
								// if ticket exists in database with this fb post id then do here 
							} else {
								$post['description'] = str_replace('"','\"', $post['description']);
								
								$query = 'INSERT INTO `#__jsptickets_ticket` (`ticketcode`, `title`, `subject`, `description`, `category_extension`, `category_id`, `priority_id`, `status_id`, `attachment_id`, `feedback_id`, `comment_id`, `created`, `created_by`, `created_for`, `modified`, `assigned_by`, `assigned_to`, `email_comment`, `guestname`, `guestemail`, `fb_post_id`)
								VALUES ("'. $ticketcodedid .'", "' . $post['jform']['title'] . '", "' . $post['jform']['subject']. '", "' . $post['description'] . '", "' . $post['jform']['category_extension']  . '", '. "'" . $category . "'" .', ' . $post['jform']['priority'] . ', ' . $post['jform']['status'] . ', "' . $naid . '", "' . $nfid . '", "' . $ncid . '", "' . $currtimestamp . '", ' . 0 . ", " . $created_for .  ', "' . $currtimestamp . '", ' . 0 . ", " . $assigned_to . ', "' . $email_comment . '", "'. $post['guestname'] .'", "' . $post['guestemail'] . '", "'. $fbpostid .'");';
								$db->setQuery($query);
								if (!$db->query()) 
									{
										JError::raiseError( 500, $db->getErrorMsg() );
									}
								$id = $db->insertid();	                //gets the latest id of the ticket
								
								$query = 'INSERT INTO `#__jsptickets_audit` (`ticket_id`, `narration`, `created`) VALUES (' . $id . ', "' . $narration . '", "' . $currtimestamp. '");';
								
								$db->setQuery($query);
								if (!$db->query()) 
								{
									JError::raiseError( 500, $db->getErrorMsg() );
								}
								$logid = $db->insertid();
								
								$this->create_mail("fbticket", $config[0]->fb_send_mail, $ticketcodedid, $post['jform']['subject'], $post['description'], $config[0]->email_notification, $config[0]->admin_email_id, $post['guestname'], $post['guestemail'] ); // send mail to administrators and users about there new ticket
							}
						} else {  // if there is no related fb posts
							//echo "no related search found".'<br/>';
						}
					} // for all related filters
				} // for each posts
			}
		//update the date in configuration with latest timestamp					
		$query = 'UPDATE `#__jsptickets_configuration` SET `last_fbpost_time` = "' . $latest_time . '" WHERE `id` = 1';
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
		return;
	  }
	  
	  function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) 
	  {
		$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
		return $connection;
	  }
	  
	  function genTwitterTickets()
	  {
		require_once(JPATH_PLUGINS."/system/jsptickets/twitteroauth-libs/twitteroauth.php"); //Path to twitteroauth library
		$date = JFactory::getDate();
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__jsptickets_configuration WHERE `id` = '1'";
		$db->setQuery($query);
		$config = $db->loadobjectlist();
		$config_array = array();
		$config_array['twitter_screenname'] = $config[0]->twitter_screenname;
		$notweets = 20;
		$config_array['last_tweet_id'] = $config[0]->last_tweet_id;
		
		$mainframe = Jfactory::GetApplication();
		$narration = JText::_('LOG_NEW_TICKET_CREATED');
		
		$consumerkey = $config[0]->custom_twitter_consumerkey;
		$consumersecret = $config[0]->custom_twitter_consumersecret;
		$accesstoken = $config[0]->custom_twitter_accesstoken;
		$accesstokensecret = $config[0]->custom_twitter_accesstoken_secret;
		
		$connection = $this->getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
		$tweets = $connection->get("https://api.twitter.com/1.1/search/tweets.json?q=%40".$config_array['twitter_screenname']."&since_id=".$config_array['last_tweet_id']."&count=".$notweets."&result_type=mixed");
		$filter_array = explode( ',' , $config[0]->twitter_filter_words );
		$query = "SELECT `id` FROM #__categories WHERE `extension` LIKE 'com_jsptickets' AND `alias` LIKE 'uncategorised'";
		$db->setQuery($query);
		$catdata = $db->loadobjectlist();
					
		$naid = $nfid = $ncid = "";
		$created_for = $assigned_to = $email_comment = 0;
		$post['jform']['title'] = $config[0]->twitter_ticket_title;
		$post['jform']['subject'] = $config[0]->twitter_ticket_subject;
		$post['jform']['status'] = 1; // new
					
		$sql = "SELECT MIN(`id`) AS `id` FROM `#__jsptickets_priorities` WHERE `publish` = 1";
		$db->setQuery($sql);
		$priorityid = $db->loadObject();
		$post['jform']['priority'] = $priorityid->id;
					
		$post['jform']['category_extension'] = json_encode((array)"com_jsptickets");
		$category = json_encode((array)$catdata[0]->id);
		foreach($tweets->statuses AS $tweet)
		{
			foreach($filter_array AS $key=>$filter_str)
			{
				if( isset( $tweet->text ) and strstr( strtolower($tweet->text), strtolower($filter_str) ) )
				{
					$tweetid = $tweet->id_str;         // tweet id
					$post['guestname'] = $tweet->user->name;
					$twitteruserid = $tweet->user->id_str;
					$twitterusername = $tweet->user->screen_name;
					$post['guestemail'] = $twitterusername . "@twitter.com";
					$post['description'] = $tweet->text;
					$post['description'] = str_replace('"','\"', $post['description']);
					$tweetcreated_at = $tweet->created_at;
					
					if($config_array['last_tweet_id'] < $tweetid)
					{
						$config_array['last_tweet_id'] = $tweetid;
					}
					
					$query = 'SELECT EXISTS(SELECT * FROM `#__jsptickets_ticket` WHERE `tweet_id` = "' . $tweetid . '") AS `exists`';
					$db->setQuery($query);
					$ticketexists = $db->loadobjectlist();
					$tc_exists = $ticketexists[0]->exists;
					$currtimestamp = $date->Format("Y-m-d H:i:s");
									
					if($tc_exists)
					{
						// if ticket exists in database with this fb post id then do here 
					} else {
						$ticketcodedid =  uniqid("", false);    // later will be used in new tickets
						$query = 'INSERT INTO `#__jsptickets_ticket` (`ticketcode`, `title`, `subject`, `description`, `category_extension`, `category_id`, `priority_id`, `status_id`, `attachment_id`, `feedback_id`, `comment_id`, `created`, `created_by`, `created_for`, `modified`, `assigned_by`, `assigned_to`, `email_comment`, `guestname`, `guestemail`, `tweet_id`, `twitter_username`)
									VALUES ("'. $ticketcodedid .'", "' . $post['jform']['title'] . '", "' . $post['jform']['subject']. '", "' . $post['description'] . '", ' . "'" . $post['jform']['category_extension']  . "'" .', '. "'" . $category . "'" .', ' . $post['jform']['priority'] . ', ' . $post['jform']['status'] . ', "' . $naid . '", "' . $nfid . '", "' . $ncid . '", "' . $currtimestamp . '", ' . 0 . ", " . $created_for .  ', "' . $currtimestamp . '", ' . 0 . ", " . $assigned_to . ', "' . $email_comment . '", "'. $post['guestname'] .'", "' . $post['guestemail'] . '", "'. $tweetid .'", "'. $twitterusername .'");';
						$db->setQuery($query);
						if (!$db->query()) 
						{
							JError::raiseError( 500, $db->getErrorMsg() );
						}
						$id = $db->insertid();	                //gets the latest id of the ticket
										
						$query = 'INSERT INTO `#__jsptickets_audit` (`ticket_id`, `narration`, `created`) VALUES (' . $id . ', "' . $narration . '", "' . $currtimestamp. '");';
						$db->setQuery($query);
						if (!$db->query()) 
						{
							JError::raiseError( 500, $db->getErrorMsg() );
						}
						$logid = $db->insertid();
						
						$this->create_mail("twitterticket", $config[0]->twitter_send_mail, $ticketcodedid, $post['jform']['subject'], $post['description'], $config[0]->email_notification, $config[0]->admin_email_id, $post['guestname'], $post['guestemail'] ); // send mail to administrators and users about there new ticket						
					}
				}
			}
		}
		$query = 'UPDATE `#__jsptickets_configuration` SET `last_tweet_id` = "' . $config_array['last_tweet_id'] . '" WHERE `id` = 1';
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
		return;
	  }
	  
	  function create_mail($task = null, $socialmail = null, $tcid = null, $ticket_sub = null, $ticket_desc = null, $sendemail = null, $adminemail = null, $guestname = null, $guestemail = null)
	  {
		$config = JFactory::getConfig();
		if($task == "fbticket")
		{
			if($socialmail == 1)  //if social mails are allowed
			{
				if($adminemail != null)
				{
					$Email = explode(",",$adminemail); // admin emails in array form
					$adminto = (array)$Email;
					$admin_mail_sub = JText::_('ADMIN_MAIL_SUBJECT') . ' ' . $config->get( 'config.sitename' ) . ' Ticket Id :- ' . $tcid . ' ';
					$admin_mail_body = '<b>Subject</b> :- ' . $ticket_sub . "<br/>" . '<b>Message</b> :- ' . $ticket_desc ;
					$this->Send_Mail($adminto, $admin_mail_sub, $admin_mail_body);
				}
				
				// for the facebook user
				$to = $guestemail;
				$subject = JText::_("USER_MAIL_SUBJECT") . ' ' . $config->get( 'config.sitename' ) . ' Ticket Id :- ' . $tcid;
				$body = JText::_("MAIL_GREETINGS") . " " . $guestname . "<br/>" . JText::_("USER_FB_MAIL_BODY") . JURI::root() ."<br/>". JText::_("MAIL_USER_NAME"). ": ". $guestname. "<br/>". JText::_("MAIL_USER_EMAIL"). ": " . $guestemail . "<br/>". JText::_("MAIL_TICKETID"). ": ". $tcid;
				$this->Send_Mail($to, $subject, $body);
			}
		}
		if($task == "twitterticket")
		{
			if($socialmail == 1)  //if social mails are allowed
			{
				if($adminemail != null)
				{	
					$Email = explode(",",$adminemail); // admin emails in array form
					$adminto = (array)$Email;
					$admin_mail_sub = JText::_('ADMIN_MAIL_SUBJECT') . ' ' . $config->get( 'config.sitename' ) . ' Ticket Id :- ' . $tcid . ' ';
					$admin_mail_body = '<b>Subject</b> :- ' . $ticket_sub . "<br/>" . '<b>Message</b> :- ' . $ticket_desc ;
					$this->Send_Mail($adminto, $admin_mail_sub, $admin_mail_body);
				}
			}
		}
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