<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: script.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
jimport('joomla.filesystem.file');

class com_jspticketsInstallerScript
{
	function install($parent)
	{          
		$manifest = $parent->get("manifest");
		$parent = $parent->getParent();
		$source = $parent->getPath("source");
		 
		$installer = new JInstaller();
		
		$mediasrc = JPATH_ADMINISTRATOR.'/components/com_jsptickets/jsp_tickets';
		$mediadest = JPATH_SITE.'/images/jsp_tickets';
				
		$db = JFactory::getDbo();
		
		// JTableCategory is autoloaded in J! 3.0, so...
		if (version_compare(JVERSION, '3.0', 'lt'))
		{
			JTable::addIncludePath(JPATH_PLATFORM . 'joomla/database/table');
		}
				
		$query='SELECT * FROM `#__jsptickets_temp_categories`';
		$db->setQuery($query);
		$jsp_cat_exists = $db->loadObjectList();
		
		if(count($jsp_cat_exists)>0)
		{
			$query = 'INSERT IGNORE INTO `#__categories` SELECT * FROM `#__jsptickets_temp_categories` WHERE `extension` LIKE "com_jsptickets"';
			$db->setQuery($query);
			$db->query();
		}
		
		$query='SELECT `id` FROM `#__categories` WHERE `extension` = "com_jsptickets" AND `alias` = "uncategorised" AND `path` = "uncategorised"';
		$db->setQuery($query);
		$if_exists = $db->loadObject();
		
		if(isset($if_exists->id))
		{
			// No need to add 'uncategorised' category
		} else {
			// Initialize a new category
			$category = JTable::getInstance('Category');
			$category->extension = 'com_jsptickets';
			$category->title = 'Uncategorised';
			$category->description = 'Uncategorised';
			$category->published = 1;
			$category->access = 1;
			$category->params = '{"image":null,"assigned_to":"[\"7\",\"8\"]"}';
			$category->metadata = '{"page_title":"","author":"","robots":""}';
			$category->language = '*';
			 
			// Set the location in the tree
			$category->setLocation(1, 'last-child');
			 
			// Check to make sure our data is valid
			if (!$category->check())
			{
			JError::raiseNotice(500, $category->getError());
			return false;
			}
			 
			// Now store the category
			if (!$category->store(true))
			{
			JError::raiseNotice(500, $category->getError());
			return false;
			}
			 
			// Build the path for our category
			$category->rebuildPath($category->id);
		}
		
		foreach($manifest->plugins->plugin as $plugin) {
			$attributes = $plugin->attributes();
			$plg = $source . '/' . $attributes['folder'] . '/' . $attributes['plugin'];
			$installer->install($plg);
		}
		
		// AS the plugin will be installed earlier than the component from package hence sql for plugin.
		$query = "UPDATE `#__extensions` SET `enabled` = 1 WHERE `element` = 'jsptickets' AND `type` = 'plugin' AND `folder` = 'system'";
		$db->setQuery( $query );
		$db->query();
		
		$result = JFolder::move($mediasrc, $mediadest);
		if(JFolder::exists($mediasrc))
		{
			JFolder::delete($mediasrc);
		}
		
		echo '<b>JSP Tickets Plugin installation successful</b>';
	}
	
	function uninstall($parent)
	{
	$database	= JFactory::getDBO();
	jimport('joomla.filesystem.file');

	$query='SELECT * FROM `#__categories` WHERE `extension` LIKE "com_jsptickets"';
	$database->setQuery($query);
	$jsp_cat_exists = $database->loadObjectList();
	
	if(count($jsp_cat_exists)>0)
	{
		// copy data from joomla categories table to jsptickets categories table 
		$query = 'INSERT IGNORE INTO `#__jsptickets_temp_categories` SELECT * FROM `#__categories` WHERE `extension` LIKE "com_jsptickets"';
		$database->setQuery($query);
		$database->query();
	}
	
	// remove all entries from database
	$query = 'DELETE FROM `#__extensions` WHERE `element` LIKE "%jsptickets%"';
	$database->setQuery($query);
	$database->query();
	
	if( is_dir(JPATH_ROOT.'/'.'plugins'.'/'.'system'.'/'.'jsptickets') )
	{
		JFile::delete(JPATH_ROOT.'/'.'plugins'.'/'.'system'.'/'.'jsptickets'.'/'.'jsptickets.php');
		JFile::delete(JPATH_ROOT.'/'.'plugins'.'/'.'system'.'/'.'jsptickets'.'/'.'jsptickets.xml');
		JFile::delete(JPATH_ROOT.'/'.'plugins'.'/'.'system'.'/'.'jsptickets'.'/'.'index.html'); 
	
		if( is_dir(JPATH_ROOT.'/'.'plugins'.'/'.'system'.'/'.'jsptickets'.'/'.'twitteroauth-libs') )
		{
			JFile::delete(JPATH_ROOT.'/'.'plugins'.'/'.'system'.'/'.'jsptickets'.'/'.'twitteroauth-libs'.'/'.'OAuth.php'); 
			JFile::delete(JPATH_ROOT.'/'.'plugins'.'/'.'system'.'/'.'jsptickets'.'/'.'twitteroauth-libs'.'/'.'twitteroauth.php'); 
			JFile::delete(JPATH_ROOT.'/'.'plugins'.'/'.'system'.'/'.'jsptickets'.'/'.'twitteroauth-libs'.'/'.'index.html'); 
			rmdir(JPATH_ROOT.'/'.'plugins'.'/'.'system'.'/'.'jsptickets'.'/'.'twitteroauth-libs');
		}	
		rmdir(JPATH_ROOT.'/'.'plugins'.'/'.'system'.'/'.'jsptickets');
	}
	
		echo '<h3>JSP Tickets has been succesfully uninstalled.</h3>';
		echo '<h3>Thank You for using JSP Tickets.</h3>';
	} 
}