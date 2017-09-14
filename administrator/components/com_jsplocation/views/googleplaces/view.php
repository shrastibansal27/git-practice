<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: view.html.php  $
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
JToolBarHelper::title(JText::_('GOOGLE PLACES LOCATIONS'), 'jlocator_article.png');
require_once(JPATH_COMPONENT_ADMINISTRATOR.'/'.'tables'.'/'.'googleplaces.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.'/'.'tables'.'/'.'apikey.php');
jimport( 'joomla.application.component.view');

class JspLocationViewGoogleplaces extends JViewLegacy {
	function display($tpl=null)
	{
		$mainframe = Jfactory::GetApplication();
	    $model = $this->getModel('googleplaces');
		$data = $model->setGoogleData();
		$result = $model->getGoogleData();
		$apikey = $model->getGoogleapi();
		$this->addToolbar();
		$this->assignRef('data',$data);
		$this->assignRef('result',$result);
		$this->assignRef('apikey',$apikey);
		
		parent::display($tpl);
	}
	
	function setGoogleData($tpl=null)
	{
		$mainframe = Jfactory::GetApplication();
	    $model = $this->getModel('googleplaces');
		$search = JRequest::getVar('search');
	    $data = $model->setGoogleData($search);
		if ($data !=""){
       $msg = JText::_("Your API key must have been expired.");
       $link = 'index.php?option=com_jsplocation&controller=googleplaces&task=googleplaces';
       }
        else{
       $msg = "Stores searched succesfully";
       $link = 'index.php?option=com_jsplocation&controller=googleplaces&task=googleplaces';
       }
		
		$this->assignRef('data',$data);
		$mainframe->redirect($link, $msg, 'MESSAGE');
		parent::display($tpl);
	}
	
	function selectionData(){
		$mainframe = Jfactory::GetApplication();
        $model = $this->getModel('googleplaces');
		$id = JRequest::getVar('id');
		$sid = $model->yahooApiData($id);
		$link = 'index.php?option=com_jsplocation&controller=googleplaces&task=googleplaces';
		$msg	= JText::_( 'Location Created Successfully' );
 	    $mainframe->redirect($link, $msg, 'MESSAGE');
		parent::display($tpl);
	}
	
	protected function addToolbar()
	{
		  JToolBarHelper::apply('apply');
		JToolBarHelper::save('save');
		JToolBarHelper::cancel('cancel');
	}
	
	
	function saveData($tpl = null){
		
		$mainframe = Jfactory::GetApplication();
		$apikey = JRequest::getVar('apikey');
	    $task = JRequest::getCmd('task');
		$model = $this->getModel('googleplaces');
		$api = $model->setApiKey($apikey);
		
		$result = $model->setGoogleData();
		
		
		//$db =  JFactory::getDBO();
        //$tableClassName = 'JTableGoogleplaces' ;
		//$row = new $tableClassName($db);
		
		
		/*to check wrong api key message*/
		if($result !="")
		{   
	        $link = "index.php?option=com_jsplocation&controller=googleplaces&task=googleplaces";
			$msg = JText::_("$result");
			
		}
		else
		{
		
		switch($task){
			case 'save':
			default:
				$link = "index.php?option=com_jsplocation";
				$msg	= JText::_( 'Changes saved' );
			break;
			
			case 'apply':
				$link = "index.php?option=com_jsplocation&controller=googleplaces&task=googleplaces";
				$msg	= JText::_( 'Api Key saved successfully' );
		}
		}
	   
       $mainframe->redirect( $link, $msg, 'MESSAGE' );
	  
	}
	
	
	function cancelData(){
    $mainframe = JFactory::getApplication();    
    $mainframe->redirect('index.php?option=com_jsplocation','');
     $mainframe->redirect( $link, $msg, 'MESSAGE' );
   }
}
?>