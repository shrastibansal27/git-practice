<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: configuration.php  $
 */
 
// no direct access
defined('_JEXEC') or die( 'Restricted access' );

class TableConfiguration extends JTable
{
	
	var $id 					= null;
	
	var $maptitle  				= null;

	var $jquery  				= null;
	
	var $height					= null;
	
	var $zoomlevel				= null;
	
	var $lat_ovr_conf			= null;
	
	var $long_ovr_conf			= null;
	
        var $language_local			= null;
	
	var $branch_id				= null;
		
	var $branch_url				= null;
	
	var $search					= null;
	
	var $directions				= null;
	
	var $branchlist				= null;
	
	var $country				= null;
	
	var $state 					= null;
	
	var $city					= null;
	
	var $area  					= null;
	
	var $displaytitle			= null;
	
	var $zip_search				= null;

    var $category_search		= null;
	
	var $country_search			= null;
	
	var $state_search			= null;
	
	var $city_search			= null;
	
	var $area_search			= null;
	
	var $google_autocomplete_address = null;
	
	var $radius_range			= null;

	var $template				= null;
	
	var $min_zip                = null;
	
	var $max_zip                = null;
	
	var $locateme               = null;
	
	var $locateme_radius        = null;	
	
	var $branch_img_id          = null;
	
	var $image_display          = null;
	
	var $imagename              = null;
	
	var $direction_range        = null;
	
	var $show_pointer_type      = null;
	
	var $page_limit             = null;
	
	var $pointertype            = null;
	
	var $fillcolor            	= null;
	
	var $fontsize            	= null;
	
	function __construct(&$db)
	{
		parent::__construct( '#__jsplocation_configuration', 'id', $db );
	}

	
}
