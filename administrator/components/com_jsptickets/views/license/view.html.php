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
JToolBarHelper::title(JText::_('JSP_LOCATION'), 'jlocator_article.png');
jimport( 'joomla.application.component.view');

class JspTicketsViewLicense extends JViewLegacy {
	
function display($tpl=null){
		
		$app = JFactory::getApplication();
	    $model = $this->getModel('license');
		$this->addToolBarForm();
		$license_key = $model->getLicenseKey();
		$license_key =$license_key[0];
		if($license_key != '')
		$license_key = $model->encrypt_decrypt('decrypt', $license_key);
		$this->assignRef('licensekey', $license_key);
		parent::display($tpl);		
	}
	
	
	function addToolBarForm(){
	JToolBarHelper::title(JText::_('jSecure Authentication'), 'generic.png');
	JToolBarHelper::apply('applylicense');
	JToolBarHelper::save('savelicense');
	JToolBarHelper::cancel('cancel', 'Close');
	}
		
	function save(){
	        
		$app = JFactory::getApplication();
        $model = $this->getModel('license');  		
		$license_key =$_POST['license_key'];	
		$license_key = $model->encrypt_decrypt('encrypt', $license_key);
		$result =$model->setLicenseKey($license_key);
		if($result){
 			$link = 'index.php?option=com_jsplocation';
 			$msg  = 'Details Has Been Saved';
 			$app->redirect($link,$msg,'MESSAGE');
 	    }

	}
	function apply(){
		$app = JFactory::getApplication();
		$model = $this->getModel('license');
		$license_key =$_POST['license_key'];	
		$license_key = $model->encrypt_decrypt('encrypt', $license_key);
		$result =$model->setLicenseKey($license_key);
		if($result){
 			$link = 'index.php?option=com_jsplocation&task=license';
 			$msg  = 'Details Has Been Saved';
 			$app->redirect($link,$msg,'MESSAGE');
 	    }

	}
}
	?>