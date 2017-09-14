<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Location 1.8
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: script.php  $
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access');

class com_jsplocationInstallerScript
{
        function install($parent)
        {          
            $manifest = $parent->get("manifest");
            $parent = $parent->getParent();
            $source = $parent->getPath("source");
             
            $installer = new JInstaller();
            
            foreach($manifest->plugins->plugin as $plugin) {
                $attributes = $plugin->attributes();
                $plg = $source . '/' . $attributes['folder'].'/'.$attributes['plugin'];
                $installer->install($plg);
            }
            
            foreach($manifest->modules->module as $module) {
                $attributes = $module->attributes();
                $mod = $source . '/' . $attributes['folder'].'/'.$attributes['module'];
                $installer->install($mod);
            }
            
            
            $db = JFactory::getDbo();
            $tableExtensions = $db->nameQuote("#__extensions");
            $columnElement   = $db->nameQuote("element");
            $columnType      = $db->nameQuote("type");
            $columnEnabled   = $db->nameQuote("enabled");

            $db->setQuery('update #__modules set published = 0, position="position-7" where module = "mod_jsplocation" and published = 0');
            $db->query();

			$db->setQuery('update #__extensions set enabled = 1 where element = "jsplocation" and type = "plugin"');
            $db->query();
			
         
  			echo '<b>JSP Location Module installation successful</b>', '<br />';
			echo '<b>JSP Location Plugin installation successful</b>';
			echo "<br><br><b><a href='index.php?option=com_jsplocation&installData=true' style='-moz-border-radius: 10px 10px 10px 10px;  background: none repeat scroll 0 0 #CCCCCC; border: 1px solid #000000; padding: 5px; width: 210px;'>Click Here To Install Sample Data</a></b><br> &nbsp;&nbsp;";
        }
		
		function update( $parent ) {
		
				$db = JFactory::getDBO();
				
				$config = JFactory::getConfig();
				$databaseName=$config->get('db');
				$dbPrefix =$config->get('dbprefix');
				
				$countColumnsSql = "SELECT count(*) AS Columns FROM information_schema.columns WHERE table_name = '".$dbPrefix."jsplocation_configuration' and table_schema = '".$databaseName."'";
				$db->setQuery($countColumnsSql);
				$db->query();
				$records = $db->loadObject();
				
				if($records->Columns == 38){
				
				$sql = "ALTER TABLE #__jsplocation_configuration ADD COLUMN map_type enum('0','1') NOT NULL DEFAULT '0', ADD COLUMN BingMap_key varchar(200) NOT NULL";
				$db->setQuery($sql);
				$db->query();
			
				$insertSql = "INSERT INTO #__jsplocation_configuration (map_type, BingMap_key) VALUES ('0', '')";
				$db->setQuery($insertSql);
				$db->query();
				}
				
		}

     
}