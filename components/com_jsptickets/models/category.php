<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: category.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
jimport('joomla.application.component.modeladmin');
jimport( 'joomla.filesystem.file' );

class jspticketsModelcategory extends JModelAdmin {
	
	function getlist()
	{
		return;
	}
	
	public function getForm($data = array(), $loadData = true)
        {
 
			$app = JFactory::getApplication();
 
			// Get the form.
            $form = $this->loadForm('com_jsptickets.category', 'category', array('control' => 'jform', 'load_data' => true));
            if (empty($form)) {
                return false;
            }
            return $form;
 
        }
		
	public function getFormData($id = null, $option = null)
	{
		$db = JFactory::getDBO();
		$query = 'SELECT * FROM `#__categories` WHERE `extension` LIKE "'. $option . '" AND `id` LIKE '. $id ;
		$db->setQuery($query);
		$data = $db->loadObjectList();
		return $data;
	}
	
	function escape_string($query_input = null)
	{
		$search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
		$replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
		return str_replace($search, $replace, $query_input);
	}
	
	public function getCategoryCount($option = null,$search = null,$filter_level = null,$filter_published = null,$filter_access = null,$filter_language = null)
	{
		$db = JFactory::getDBO();
		$condn= array();
		$query = 'SELECT * FROM `#__categories` WHERE `extension` LIKE "'. $option . '"';
		
		if($this->escape_string($search)!=null || $filter_level!=null || $filter_published!=null || $filter_access!=null || $filter_language!=null)
		{
			$query.=" AND ";
		}
		
		if($this->escape_string($search)!=null)
		{
			$str = '(title LIKE "%'. $this->escape_string($search) . '%" OR alias LIKE "%'. $this->escape_string($search) . '%")';
			$condn = array_merge((array)$str, $condn);
		}
		if($filter_level!=null && $filter_level != "*")
		{
			$str = 'level = '.$filter_level;
			$condn = array_merge((array)$str, $condn);
		}
		if($filter_published != null && $filter_published != "*")
		{
			$str = 'published = '.$filter_published;
			$condn = array_merge((array)$str, $condn);
		}
		if($filter_access != null && $filter_access != "*")
		{
			$str = 'access = '.$filter_access;
			$condn = array_merge((array)$str, $condn);
		}
		if($filter_language != null && $filter_language != "*")
		{
			$str = "language LIKE '{$filter_language}'";
			$condn = array_merge((array)$str, $condn);
		}
		$final_condn = implode($condn," AND ");
		$query.=$final_condn;
		$db->setQuery($query);
		$data = $db->loadObjectList();
		return count($data);
	}
	
	public function publish($id)
	{
		$db = JFactory::getDBO();
		$query = "UPDATE `#__categories` SET `published` = '1' WHERE `id` = " . $id ;
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
	}
	
	public function unpublish($id)
	{
		$db = JFactory::getDBO();
		$query = "UPDATE `#__categories` SET `published` = '0' WHERE `id` = " . $id ;
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
	}
	
	public function remove($id)
	{
		$db = JFactory::getDBO();
		
		$this->removecatfiles($id);
		$query = "DELETE FROM `#__categories` WHERE `id` = " . $id ;
		$db->setQuery($query);
		if (!$db->query()) 
		{
			JError::raiseError( 500, $db->getErrorMsg() );
		}
	}
	
	public function removecatfiles($id)
	{
		$db = JFactory::getDBO();
		
		$query = "SELECT `params` FROM `#__categories` WHERE `id` = " . $id ;
		$db->setQuery($query);
		$data = $db->loadObject();
		$params = json_decode($data->params);
		$dest= JPATH_ROOT . '/images/jsp_tickets/cat_images/' . $params->image;
		if(JFile::exists($dest))
		{
			JFile::delete($dest);
		}
		return;
	}
}