<?php
/**
 * jSecure Authentication components for Joomla!
 * jSecure Authentication extention prevents access to administration (back end)
 * login page without appropriate access key. 
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2015
 * @package     jSecure3.4
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: view.html.php  $
 */
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );
jimport('joomla.html.pane');

class jsecureViewCountryblock extends JViewLegacy {
	protected $form;
	protected $item;
	protected $state;
	
function display($tpl=null){
        $this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');

		$basepath   = JPATH_ADMINISTRATOR .'/components/com_jsecure';
		$configFile	= $basepath.'/params.php';
		require_once($configFile);
		$JSecureConfig = new JSecureConfig();
		
		$this->assignRef('JSecureConfig',$JSecureConfig);

        $model = $this->getModel('jsecurelog');
        $data = $model->getCountryList();
        $result = $model->countryLimitList();		
		$this->addToolbar();		
		jimport('joomla.html.pagination');
		$this->assignref('data',$data);
		$this->assignref('result',$result);
		//log end here
		parent::display($tpl);		
}
    protected function addToolbar()
	{		
			JToolBarHelper::title(JText::_('jSecure Authentication'), 'generic.png');
			JToolBarHelper::apply('applyCountryblock');
			JToolBarHelper::save('saveCountryblock');
			JToolBarHelper::cancel('cancel');
			JToolBarHelper::publish('publish', 'JTOOLBAR_PUBLISH', true);
		    JToolBarHelper::unpublish('unpublish', 'JTOOLBAR_UNPUBLISH', true);
		
	}

    protected function addnewToolbar(){
	JToolBarHelper::title(JText::_('jSecure Authentication'), 'generic.png');
    JToolBarHelper::cancel('cancelcountrylog');
    JToolBarHelper::deleteList($msg = 'Are you sure want to delete?',$task = 'removecountrylog',$alt = 'Delete');
    }
	
		function save(){
		$app = &JFactory::getApplication();
	    $msg  = 'Details Has Been Saved';
		$result = $this->saveDetails();
 		if($result){
 			$link = 'index.php?option=com_jsecure';
 			$msg  = 'Details has been saved';
 			$app->redirect($link,$msg,'MESSAGE');
 	    }
 	}
 	function apply(){
		$app = &JFactory::getApplication();
	    $msg  = 'Details Has Been Saved';
		$result = $this->saveDetails();
 		if($result){
 			$link = 'index.php?option=com_jsecure&task=countryblock';
 			$msg  = 'Details has been saved';
 			$app->redirect($link,$msg,'MESSAGE');
 	    }
 	}
	
	 function delete()
     {
	
     $app = &JFactory::getApplication();
     $task = JRequest::getCmd('task');      
      $post = JRequest::get('post');
	  
      
	  $logid=implode(',',$post['cid']);
	  	  
      $model = $this->getModel('jsecurelog');
      $log= $model->removeBlockedCountry($logid);
     
     $link = 'index.php?option=com_jsecure&task=countrylog';
    $msg  = 'Log deleted successfully';
    $app->redirect($link,$msg,'MESSAGE');
    }	
	
	
	
	
	
	
		function saveDetails(){	
 		
		jimport('joomla.filesystem.file');	
		$app           = JFactory::getApplication();
		$option		= JRequest::getVar('option', '', '', 'cmd');
		$post       = JRequest::get( 'post' );
		
	
		$basepath   = JPATH_ADMINISTRATOR .'/components/com_jsecure';
		$configFile	= $basepath.'/params.php';
		
		$xml	    = $basepath.'/com_jsecure.xml';
		
		require_once($configFile);
		
		if(! is_writable($configFile)){
			$link = "index.php?option=com_jsecure";
			$msg = 'Configuration File is Not Writable /administrator/components/com_jsecure/params.php ';
			$app->redirect($link, $msg, 'notice'); 
			exit();
		}

		// Read the ini file
		if (JFile::exists($configFile)) {
			$content = JFile::read($configFile);
		} else {
			$content = null;
		}

		$config = new JRegistry('JSecureConfig');
		$oldValue = new JSecureConfig();

		$config_array = array();
		$config_array['publish'] = $oldValue->publish;	
		$config_array['publishemailcheck'] = JRequest::getVar('publishemailcheck', 0, 'post', 'int');
		$config_array['publishevent'] = JRequest::getVar('publishevent', 0, 'post', 'int');
		$config_array['blacklistemail'] = JRequest::getVar('blacklistemail','', 'post', 'string');
		$config_array['publishlogdb'] = JRequest::getVar('publishlogdb', 0, 'post', 'int');
		$config_array['publishforumcheck'] = JRequest::getVar('publishforumcheck', 0, 'post', 'int');
		$config_array['forumfrequency'] = JRequest::getVar('forumfrequency','', 'post', 'string');
		$config_array['key']                          =  $oldValue->key;
		$config_array['passkeytype']	             =  $oldValue->passkeytype;
		$config_array['countryblock']	             =  JRequest::getVar('publishcountryblock', 0, 'post', 'int');
		$config_array['options']                     =  $oldValue->options; 
		$config_array['custom_path']				 =  $oldValue->custom_path;		
		$config_array['captchapublish']			= $oldValue->captchapublish;		
		$config_array['imageSecure']    		= $oldValue->imageSecure;
		$config_array['enableMasterPassword']   = $oldValue->enableMasterPassword;
		$config_array['master_password']        = $oldValue->master_password;
		$config_array['include_basic_confg']    = $oldValue->include_basic_confg;
		$config_array['include_email_scan']    = $oldValue->include_email_scan;
		$config_array['include_image_secure']   = $oldValue->include_image_secure;
		$config_array['include_user_key']       = $oldValue->include_user_key;
		$config_array['include_adminpwdpro']    = $oldValue->include_adminpwdpro;
		$config_array['include_mail']           = $oldValue->include_mail;
		$config_array['include_ip']             = $oldValue->include_ip;
		$config_array['include_mastermail']     = $oldValue->include_mastermail;
		$config_array['include_adminid']        = $oldValue->include_adminid;
		$config_array['include_logincontrol']   = $oldValue->include_logincontrol;
		$config_array['include_metatags']       = $oldValue->include_metatags;
		$config_array['include_purgesessions']	= $oldValue->include_purgesessions;
		$config_array['include_log']            = $oldValue->include_log;
		$config_array['include_showlogs']       = $oldValue->include_showlogs;
		$config_array['include_directorylisting']= $oldValue->include_directorylisting;
		$config_array['include_component_protection']= $oldValue->include_component_protection;
		$config_array['include_autobanip'] = $oldValue->include_autobanip;
		$config_array['include_graph']           = $oldValue->include_graph;
		$config_array['sendemail']				 = $oldValue->sendemail;
		$config_array['sendemaildetails']		 = $oldValue->sendemaildetails;
		$config_array['emailid']				 = $oldValue->emailid;
		$config_array['emailsubject']			 = $oldValue->emailsubject;
		$config_array['iptype']	                 = $oldValue->iptype;
		$config_array['iplistB']                 = $oldValue->iplistB;
		$config_array['iplistW']                 = $oldValue->iplistW;
		$config_array['abip']                    = $oldValue->abip;
		$config_array['ablist']                  = $oldValue->ablist;
		$config_array['abiplist']                = $oldValue->abiplist;
		$config_array['abiptrylist']             = $oldValue->abiptrylist;
		$config_array['spamip']                  = $oldValue->spamip;
		$config_array['spamlist']                = $oldValue->spamlist;
		$config_array['allowedthreatrating']     = $oldValue->allowedthreatrating;
		$config_array['mpsendemail']			 = $oldValue->mpsendemail;
		$config_array['mpemailsubject']			 = $oldValue->mpemailsubject;
		$config_array['mpemailid']				 = $oldValue->mpemailid;
		$config_array['login_control']			 = $oldValue->login_control;
		$config_array['adminpasswordpro']		 = $oldValue->adminpasswordpro;
		$config_array['metatagcontrol']		     = $oldValue->metatagcontrol;
		$config_array['metatag_generator']		 = $oldValue->metatag_generator;
		$config_array['metatag_keywords']		 = $oldValue->metatag_keywords;
		$config_array['metatag_description']	 = $oldValue->metatag_description;
		$config_array['metatag_rights']		     = $oldValue->metatag_rights;
		$config_array['adminType']				 = $oldValue->adminType;
		$config_array['delete_log']				 = $oldValue->delete_log;
						
		if($config_array['publish']	== 1){
			$session    = JFactory::getSession();
			$session->set('jSecureAuthentication', 1);
		}

//		$modifiedFieldName	=$this->checkModifiedFieldName($config_array, $oldValue, $JSecureCommon, $keyvalue, $masterkeyvalue);
		$modifiedFieldName	=$this->checkModifiedFieldName($config_array, $oldValue, null , null , null );
		
		$config->loadArray($config_array);
		
		$fname = JPATH_COMPONENT_ADMINISTRATOR.'/'.'params.php';
		
		$model 	= $this->getModel( 'jsecurelog' );
			
		
		if (JFile::write($fname, $config->toString('PHP', array('class' => 'JSecureConfig','closingtag' => false)))) 
			$msg = JText::_('The Configuration Details have been updated');
		 else 
			$msg = JText::_('ERRORCONFIGFILE');
	
		if($modifiedFieldName != ''){
			$basepath   = JPATH_COMPONENT_ADMINISTRATOR .'/models/jsecurelog.php';
			require_once($basepath);
		
			$model 	= $this->getModel( 'jsecurelog' );
			$change_variable = str_replace('<br/>', '\n', $modifiedFieldName); 
		
			$insertLog = $model ->insertLog('JSECURE_EVENT_CONFIGURATION_FILE_CHANGED', $change_variable);			
		}
		
		$JSecureConfig		  = new JSecureConfig();
		if($JSecureConfig->mpsendemail != '0')
			$result	= $this->sendmail($JSecureConfig, $modifiedFieldName);
		
		return true;
 	}
	
		function checkModifiedFieldName($newValue, $oldValue, $JSecureCommon, $keyvalue=null, $masterkeyvalue=null){

	$basepath   = JPATH_ADMINISTRATOR .'/components/com_jsecure';
	$commonFile	= $basepath.'/common.php';
	require_once($commonFile);
	$ModifiedValue = '';
	
		foreach($newValue as $key){
			$currentKeyName =  key($newValue);
		
			if(isset($oldValue)){
			 
			 if(array_key_exists($currentKeyName, $oldValue)){
				$result=($newValue[$currentKeyName] == $oldValue->$currentKeyName) ? '1' : '0';
				
				if(!$result){

				if( (!isset($JSecureCommon[$currentKeyName])  ||  !isset($newValue[$currentKeyName])) && $currentKeyName != 'key'  )
				{
					continue;
				}


				
					switch($currentKeyName){
					
						case 'key':
							$ModifiedValue = ($ModifiedValue != '') ? ($ModifiedValue . JText::_('JSECURE_EVENT_PASS_KEY_CHANGE') . '<br/>') : JText::_('JSECURE_EVENT_PASS_KEY_CHANGE') . '<br/>';
							break;

						case 'passkeytype':
							if( !isset($newValue[$currentKeyName]) || !isset($JSecureCommon[$currentKeyName])  )
								break;	
						
							$val = ($newValue[$currentKeyName] == 'form') ? $passkeytype[1] :  $passkeytype[0] ;
							$ModifiedValue = ($ModifiedValue != '') ? ($ModifiedValue . $JSecureCommon[$currentKeyName] . ' = ' . $val . '<br/>') : ( $JSecureCommon[$currentKeyName] . ' = ' . $val . '<br/>');
						break;

						case 'options':
							if( !isset($newValue[$currentKeyName]) || !isset($JSecureCommon[$currentKeyName])  )
								break;	
						
							$val = ($newValue[$currentKeyName] !=0) ? $options[1] :  $options[0];
							$ModifiedValue = ($ModifiedValue != '') ? ($ModifiedValue . $JSecureCommon[$currentKeyName] . ' = ' . $val . '<br/>') : ( $JSecureCommon[$currentKeyName] . ' = ' . $val . '<br/>');
						break;

						default:
							if( !isset($newValue[$currentKeyName]) || !isset($JSecureCommon[$currentKeyName])  )
								break;	
						
							$ModifiedValue = ($ModifiedValue != '') ? ($ModifiedValue . $JSecureCommon[$currentKeyName] . ' = ' . $newValue[$currentKeyName] . '<br/>') : ( $JSecureCommon[$currentKeyName] . ' = ' . $newValue[$currentKeyName] . '<br/>');
						break;
					}

				}	
				next($newValue);
			 }
		  }
		}
	  return $ModifiedValue;
   }
	
   function sendmail($JSecureConfig, $fieldName){
   		
		$config   = new JConfig();

		 $to        = $JSecureConfig->mpemailid;	
		 $to        = ($to) ? $to :  $config->mailfrom;
		 
		 if($to){
			$fromEmail  = $config->mailfrom;
			$fromName  = $config->fromname;
			$subject      = $JSecureConfig->mpemailsubject;
			$body         = JText::_( 'BODY_MESSAGE_FOR_MODIFIED_FIELDNAME:' ) .$_SERVER['REMOTE_ADDR'];
			$body		.= " ";
			$body		.= $fieldName ;  
			
			$headers = '';
			$headers .= 'From: '. $fromName . ' <' . $fromEmail . '>';
			JFactory::getMailer()->sendMail($fromEmail, $fromName, $to, $subject, $body,1);
		 }	
	}



	
	function countrylog($tpl=null){
	
	
	    $mainframe = Jfactory::GetApplication();
        $model = $this->getModel('jsecurelog');
        $result = $model->getBlockedCountry();
		
        $context = JRequest::getVar('option');
		$limit        = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$search  = $mainframe->getUserStateFromRequest( $context.'country'.'search','search','','string' );
		$search  = JString::strtolower($search);
        $limitstart    = $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');
        $limitstart = ( $limit != 0 ? (floor($limitstart / $limit) * $limit) : 0 );
        $totalcount = $model->CountList();
		
        $pagination = new JPagination($totalcount, $limitstart, $limit);
        $session = JFactory::getSession();
        $menuName = $session->get('menuName');
        $task = $_REQUEST['task'];
        if((!empty($menuName)) && (!empty($_REQUEST['task'])))
		{
           if($menuName != $_REQUEST['task'])
           {
               $session->set('menuName',$_REQUEST['task']);
               $menuName = $session->get('menuName');
               $data = $model->countryList('start');
               $pagination->pagesStart = 1;
               $pagination->pagesCurrent = 1;
               $pagination->limitstart = 0;
                
           }
           else
           {
            
               $session->set('menuName',$_REQUEST['task']);
               $result = $model->countryList();
               
           }
		}
		else
		{
        
           if(!empty($_REQUEST['task']))
           $session->set('menuName',$_REQUEST['task']);
           $result = $model->countryList();
		}
	   
        $this->addnewToolbar();
        $this->assignref('result',$result);
        $this->assignRef('pagination',$pagination);
		$this->assignRef('search',$search);	
        parent::display($tpl);
	
	}



	
	
	
	
	
	
	
	
	
	
	
}
?>