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
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.model' );
class jspLocationModelLicense extends JModelLegacy {
    function setLicenseKey($license_key){
		$db =JFactory::getDbo();
		$query ="SELECT license_key from #__jsplocation_license ";
		$db->setQuery($query);
		$rows =$db->loadRow();
		if(empty($rows))
		$query ="INSERT INTO #__jsplocation_license (license_key) VALUES ('".$license_key."')";
		else
		$query ="UPDATE #__jsplocation_license SET license_key = '".$license_key."'";
		$db->setQuery($query);
		$result = $db->query();	
		return true;
	}
	
	function getLicenseKey(){
		$db= JFactory::getDBO();
		$query ="SELECT license_key from #__jsplocation_license ";
		$db->setQuery($query);
		$rows =$db->loadRow();
		return $rows;
	}
	
   function encrypt_decrypt($action, $string) {
   $output = false;
   $key = '$b@bl2I@?%%4K*mC6r273~8l3|6@>D';
   $iv = md5(md5($key));
   if( $action == 'encrypt' ) {
       $output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $string, MCRYPT_MODE_CBC, $iv);
       $output = base64_encode($output);
   }
   else if( $action == 'decrypt' ){
       $output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($string), MCRYPT_MODE_CBC, $iv);
       $output = rtrim($output, "");
   }
   return $output;
}


}
?>		