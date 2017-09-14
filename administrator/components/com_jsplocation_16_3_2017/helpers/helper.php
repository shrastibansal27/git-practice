<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Location  2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: helper.php  $
 */
 
// no direct access
defined('_JEXEC') or die( 'Restricted access' );
jimport('joomla.filesystem.folder');

class TemplatesHelper
{	
	public static function parseXMLTemplateFile()
	{  
		$filter="";
		$data = array();
		$counter=0;
		$data[0] = new JObject;
		$recurse=false;
		$path=JPATH_SITE.'/'.'components/com_jsplocation/views';
		$folder=JFolder::folders($path, $filter, $recurse);
		foreach ($folder as $f)
		{
			$path= JPATH_SITE.'/'.'components/com_jsplocation/views'.'/'.$f;
			$subFolder=JFolder::files($path, $filter=".xml", $recurse);	
			foreach ($subFolder as $sf)
			{			
				// Check of the xml file exists
				$templateBaseDir= JPATH_SITE.'/'.'components/com_jsplocation/views'.'/'.$f.'/'.$sf;				
				$filePath = JPath::clean($templateBaseDir);	
				if (is_file($filePath))
				{
				$xml = JApplicationHelper::parseXMLInstallFile($filePath);
				if ($xml['type'] == 'template') {
				foreach ($xml as $key => $value) {
					$data[$counter] = new JObject;
					$data[$counter]->set($key, $value);
					$counter=$counter+1;
				}
				}
			}
			}
		}	
		return $data;  
	}
}

class pointerHelper
{
	public static function readImages()
	{
		$filter="";
		$recurse="";
		$path=JPATH_SITE.'/'.'/images/jsplocationimages/jsplocationPointers';
		$imgFiles=JFolder::files($path, $filter, $recurse);
		
		foreach ($imgFiles as $i => $value) 
			{
				if(stripos($value,".db"))
				{					
					unset($imgFiles[$i]);
				} 
			}		
		return $imgFiles;
	}

	public static function readBranchImages($directoryPath)
	{
		
		$filter="";
		$recurse="";
		//$path=JPATH_SITE.'/'.'/images/jsplocationimages/jsplocationImages';
		
		$path = $directoryPath;
		if(file_exists($path)){
		$imgFiles=JFolder::files($path, $filter, $recurse);
		
		foreach ($imgFiles as $i => $value) 
			{
				if(stripos($value,".db"))
				{					
					unset($imgFiles[$i]);
				} 
			}	
		}
		else{
		$imgFiles = "";
		}		
		return $imgFiles;
	}
}
