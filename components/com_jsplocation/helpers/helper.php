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

class imageHelper
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
  public static function getParams($params)
    {
        return $params;
    }
	public static function readBranchImages($directoryPath)
	{
		
		$filter="";
		$recurse="";
		//$path=JPATH_SITE.'/'.'/images/jsplocationimages/jsplocationImages';
		
		$path = $directoryPath;
		
		if (file_exists($path)) {
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
