<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: view.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

JToolBarHelper::title(JText::_('JSPLOCATION_CONFIGURATION'), 'configuration_article.png');
jimport( 'joomla.application.component.view');
jimport('joomla.html.pane');
jimport( 'joomla.html.html.tabs' );

class JspLocationViewConfiguration extends JViewLegacy {
	
	function display($tpl=null)
	{
		$model = $this->getModel('configuration');
		$params = $model->getParams();
		$this->assignRef('params',$params);

		$branchList[]			= JHTML::_('select.option',  '0', JText::_( 'Use Default Map Location Overrides' ), 'id', 'branch_name' );
		$branchList        		= array_merge( $branchList, $model->branchList());
		$list['branch']    		= JHTML::_('select.genericlist',$branchList, 'branch_id', 'class="inputbox" onchange="return hideLocOvrParams(this)" size="1"','id', 'branch_name', $params['branch_id']);
		$branchList_image[]		= JHTML::_('select.option',  '0', JText::_( 'Upload a default image' ), 'id', 'branch_name' );
		$branchList_image       = array_merge( $branchList_image, $model->branchList());
		$list['branch_image']   = JHTML::_('select.genericlist',$branchList_image, 'branch_img_id', 'class="inputbox" onchange="return PicsParam(this)" size="1"','id', 'branch_name', $params['branch_img_id']);

	    $units		= $params['radius_range'] == 'Yes' ? $units = JText::_('MILES') : $units = JText::_('KILOMETERS');
		
		$radiusValue = $params['locateme_radius'];
		$radius = $params['locateme_radius'];
		$radiusList[] = JHTML::_( 'select.option', $radiusValue, $radius, 'id', 'locateme_radius');
		$radiusList[] = JHTML::_( 'select.option', '5', "5", 'id', 'locateme_radius' );
		$radiusList[] = JHTML::_( 'select.option', '10', "10", 'id', 'locateme_radius' );
		$radiusList[] = JHTML::_( 'select.option', '15', "15", 'id', 'locateme_radius' );
		$radiusList[] = JHTML::_( 'select.option', '25', "25", 'id', 'locateme_radius' );
		$radiusList[] = JHTML::_( 'select.option', '50', "50", 'id', 'locateme_radius' );
		$radiusList[] = JHTML::_( 'select.option', '100', "100", 'id', 'locateme_radius' );
		$radiusList[] = JHTML::_( 'select.option', '500', "500" , 'id', 'locateme_radius');
		$radiusList[] = JHTML::_( 'select.option', '1000', "1000", 'id', 'locateme_radius' );
		$radiusList[] = JHTML::_( 'select.option', '2000', "2000", 'id', 'locateme_radius' );
		$list['radius']  = JHTML::_( 'select.genericlist', $radiusList, 'locateme_radius','class="droplist"', 'id', 'locateme_radius');
		$this->addToolbarform();
		$this->assignRef("list",$list);	
	
		parent::display($tpl);
	}

	function updateImgname($newfilename)
	{
		$mainframe = Jfactory::GetApplication();
    	$db				= & JFactory::getDBO();
		
		$model = $this->getModel('configuration');
		$model->enterImagename($newfilename);
		
		$link = 'index.php?option=com_jsplocation&controller=configuration&task=configuration';
		$msg  = 'Details Has Been Saved';
		$mainframe->redirect($link,$msg, 'MESSAGE');
	}
	
	protected function addToolbarform()
	{
		JToolBarHelper::apply('apply');
		JToolBarHelper::save('save');
		JToolBarHelper::cancel('cancel');
	}
	
		
	function locationdetails(){

	$mainframe = Jfactory::GetApplication();
	$session = JFactory::getSession();    
    $count = $session->get('countlocation');
	
	$upload=0;
	$logfile = JPATH_COMPONENT_ADMINISTRATOR.'/'.'locationlogs';
	$file=JRequest::getVar('branchpath', '', 'files', 'array');
	$serverpath=JPATH_COMPONENT_ADMINISTRATOR.'/'.'locationpath'; 
    $serverpath = str_replace('\\', '\\\\', $serverpath);
	$serverpath = str_replace('/', '\\\\', $serverpath);
	$filename = JFile::makeSafe($file['name']);	

	if(empty($filename)){

	$link = 'index.php?option=com_jsplocation&controller=configuration&task=configuration';
	$msg  = 'Please Select the File';
	$mainframe->redirect($link,$msg, 'MESSAGE');

	}
	

    		// Make the file name safe.			
			

			$ext = strtolower(substr(strrchr($file['name'], "."), 1));
			$extensions_allowed = array('xls', 'xlsx');
			$src=$file['tmp_name'].$file['name'];		
			$dest=$serverpath;
									
			/*-- Create Store Directory for File upload --*/			

			$directory_path = $serverpath;
		
			 if(!file_exists($serverpath)){
			$result = mkdir($directory_path,0755);
			}
						
			// Move the uploaded file into a permanent location.
			
			if(($result == 1)||(file_exists($serverpath))){
			if (isset( $file['name'] )) 
			{
				if(!in_array($ext, $extensions_allowed))
				{
	 				$upload=1;
					$msg  = 'Invalid File type';
	 				JError::raiseWarning(0,$msg, 'Warning');
				}
				
	    		if ($upload==1)
	    		{
	    			$link = 'index.php?option=com_jsplocation&controller=configuration&task=configuration';
	    			$mainframe->redirect($link);	
	    		}
	    		
			    // Make sure that the full file path is safe.
				$filepath = JPath::clean($directory_path.'/'. $filename);
	
				copy($file['tmp_name'],$filepath);

			    // Move the uploaded file.			   
			//  $fileuploaded = JFile::upload($file['tmp_name'],$directory_path );
			
			$locationfilepath=JPATH_COMPONENT_ADMINISTRATOR.'/'.'locationpath'.'/'.$filename; 
			$locationfilepath = str_replace('/', '\\', $locationfilepath);

	}
	
        $logfile = str_replace('/', '\\', $logfile);
        $date = date("d-m-Y");	
	
		$model = $this->getModel('configuration');
		$response= $model->importlocationdetails($locationfilepath);
		
	    $incresult = implode(" ,",$response);
		$logfile =$logfile.'\\'."locationlogs".$date.'.'."txt";
		
		
		$myfile = fopen($logfile, "w") or die("Unable to open locations log file!");
		fwrite($myfile, $incresult);
		fclose($myfile);
			
			if(($response == 0)) {
			$link = 'index.php?option=com_jsplocation&controller=configuration&task=configuration';
			$msg  = 'Data not imported.Please check whether file exist, file is valid or file is not imported or data already exists into database';
			$mainframe->redirect($link,$msg, 'MESSAGE');
			}
			
			elseif(($response == 1)){
			$link = 'index.php?option=com_jsplocation&controller=configuration&task=configuration';
			$msg='import data successfully';
			$mainframe->redirect($link,$msg, 'MESSAGE');
			}
			else{
            $link = 'index.php?option=com_jsplocation&controller=configuration&task=configuration';
            $msg  = $response["notimportedlocationcount"].' locations were not imported due to invalid or blank data. Kindly check log files at '.$logfile.' .Please reimport only those locations which were not imported.';
            $session->clear("countlocation");
            $mainframe->redirect($link,$msg, 'MESSAGE');
            }
			$this->display();

	}
	
	
	else{
            $link = 'index.php?option=com_jsplocation&controller=configuration&task=configuration';
	    	$msg  = 'Directory not created ,please check folder permissions';
		    $mainframe->redirect($link,$msg, 'MESSAGE');
}

	
	}
	
	function exportdata(){
	
	$mainframe =JFactory::GetApplication();
	$db	= & JFactory::getDBO();
	$model = $this->getModel('configuration');
	$model->exportlocations();
	}
	
	
	
	
	
	
	
	
	
	
	}
	
