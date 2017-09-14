<?php
	/**
		* JSP Location components for Joomla!
		* JSP Location is an interactive store locator
		*
		* @author      $Author: Ajay Lulia $
		* @copyright   Joomla Service Provider - 2016
		* @package     JSP Store Locator 2.2
		* @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
		* @version     $Id: branch.php  $
	*/
	// no direct access
	defined('_JEXEC') or die( 'Restricted access' );
	class JTableBranch extends JTable
	{
		var $id 					= null;
		var $branch_name 			= null;		
		var $address1 				= null;		
		var $latitude 				= null;		
		var $longitude 				= null;		
		var $lat_long_override			= null;		
		var $lat_ovr 				= null;		
		var $long_ovr 				= null;		
		var $zip 				= null;		
		var $landmark 				= null;		
		var $area_id 				= null;		
		var $city_id 				= null;		
		var $state_id 				= null;		
		var $country_id 			= null;		
		var $category_id 			= null;		
		var $contact_person 		= null;		
		var $gender 				= null;		
		var $email 					= null;		
		var $website 				= null;		
		var $contact_number 		= null;		
		var $description 			= null;		
		var $facebook	 			= null;		
		var $twitter	 			= null;		
		var $pointerImage	 		= null;		
		var $published 				= null;		
		var $imagename              = null;		
		var $image_display          = null;		
		var $youtube_url            = null;		
		var $vimeo_url              = null;		
		var $dailymotion_url        = null;		
		var $flickr_url             = null;		
		var $slideshare_url         = null;		
		var $speakerdeck_url         = null;		
		var $store_videos = null;		
		var $additional_link        = null;		
		function __construct(&$db)
		{
			parent::__construct( '#__jsplocation_branch', 'id', $db );
		}
	}
