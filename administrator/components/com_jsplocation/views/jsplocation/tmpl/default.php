<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$document =& JFactory::getDocument();
include JPATH_COMPONENT_ADMINISTRATOR.'/'.'helpers'.'/'.'helper.php';
$license_key = licenseHelper::getLicenseKey();
$sub_cat_id = licenseHelper::getSubscriptionCatid();
JHtml::_('behavior.framework', true);
JHTML::_('script','system/modal.js', false, true);
JHTML::_('stylesheet','system/modal.css', array(), true);
$document->addCustomTag('<script language="javascript" type="text/javascript" src="components/com_jsplocation/js/validate_license.js"></script>');
$document->addScriptDeclaration("window.addEvent('domready', function() {
			$$('.hasTip').each(function(el) {
				var title = el.get('title');
				if (title) {
					var parts = title.split('::', 2);
					el.store('tip:title', parts[0]);
					el.store('tip:text', parts[1]);
				}
			});
			var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false});
		});
		window.addEvent('domready', function() {

			SqueezeBox.initialize({});
			SqueezeBox.assign($$('a.modal'), {
				parse: 'rel'
			});
		});
		var key = '$license_key';
		var subcatid = '$sub_cat_id';
		window.onload = function(){showUpdates();showlicense(key,subcatid);}
");
$document->addCustomTag('<script language="javascript" type="text/javascript" src="components/com_jsplocation/js/jsplocation.js"></script>');
?>
<div class="span6">
	<div class="well well-small">
		<div class="module-title nav-header">Quick Icons</div>
			<div class="row-striped">
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsplocation&controller=branch"><img src="components/com_jsplocation/images/menu_list_icons/branch_icon_16x16.png" border="0" />&nbsp;<span><?php echo JText::_( 'BRANCH_MANAGEMENT' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsplocation&controller=fields"><img src="components/com_jsplocation/images/menu_list_icons/fields_icon_16x16.png" border="0"/>&nbsp;<span><?php echo JText::_( 'FIELDS_MANAGEMENT' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsplocation&controller=country"><img src="components/com_jsplocation/images/menu_list_icons/country_icon_16x16.png" border="0"/>&nbsp;<span><?php echo JText::_( 'COUNTRY_MANAGEMENT' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsplocation&controller=state"><img src="components/com_jsplocation/images/menu_list_icons/state_icon_16x16.png" border="0"/>&nbsp;<span><?php echo JText::_( 'STATE_MANAGEMENT' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsplocation&controller=city"><img src="components/com_jsplocation/images/menu_list_icons/city_icon_16x16.png" border="0"/>&nbsp;<span><?php echo JText::_( 'CITY_MANAGEMENT' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsplocation&controller=area"><img src="components/com_jsplocation/images/menu_list_icons/area_icon_16x16.png" border="0"/>&nbsp;<span><?php echo JText::_( 'AREA_MANAGEMENT' ); ?></span></a></div></div>
				
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsplocation&controller=googleplaces"><img src="components/com_jsplocation/images/menu_list_icons/google_places_16x16.png" border="0"/>&nbsp;<span><?php echo JText::_( 'GOOGLE_PLACES_LOCATIONS' ); ?></span></a></div></div>
				
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsplocation&controller=category"><img src="components/com_jsplocation/images/menu_list_icons/category_icon_16x16.png" border="0"/>&nbsp;<span><?php echo JText::_( 'CATEGORY_MANAGEMENT' ); ?></span></a></div></div>
				<div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsplocation&controller=configuration"><img src="components/com_jsplocation/images/menu_list_icons/configuration_icon_16x16.png" border="0"/>&nbsp;<span><?php echo JText::_( 'JSPLOCATION_CONFIGURATION' ); ?></span></a></div></div>
                <div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsplocation&controller=brgraph"><img src="components/com_jsplocation/images/menu_list_icons/branchhitgraphs-j3.png" border="0"/>&nbsp;<span><?php echo JText::_( 'BRANCHHIT_GRAPHS' ); ?></span></a></div></div>
                <div class="row-fluid"><div class="span12"><a href="index.php?option=com_jsplocation&controller=zipgraph"><img src="components/com_jsplocation/images/menu_list_icons/ziphitgraphs-j3.png" border="0"/>&nbsp;<span><?php echo JText::_( 'ZIPHIT_GRAPHS' ); ?></span></a></div></div>		
			</div>	
	</div>
</div>

<div class="span4">
  <table cellpadding="0" cellspacing="0" border="1" class="table table-striped" bordercolor="#DDDDDD" width="100%">
    <tr class="row0">
      	<th colspan="2" style="background-color:#FFF;">
	  		<div align="center">
				<a href="http://www.joomlaserviceprovider.com" title="Joomla Service Provider" target="_blank">
					<img src="components/com_jsplocation/images/logo.jpg" alt="Joomla Service Provider" border="none"/>
				</a>
			</div>
        	<div style="text-align:center;">
          		<h3><?php echo JText::_( 'JSP STORE LOCATOR' ); ?></h3>
        	</div>
		</th>
    </tr>
    <tr class="row1">
      <td><?php echo JText::_( 'VERSION_TEXT' ); ?></td>
      <td><?php echo JText::_( 'VERSION_DESCRIPTION' ); ?></td>
    </tr>
    <tr class="row2">
      <td><?php echo JText::_( 'SUPPORT' ); ?></td>
      <td><a href="http://www.joomlaserviceprovider.com/component/kunena/28-jlocator.html" target="_blank"><?php echo JText::_( 'JSP STORE LOCATOR FORUM' ); ?></a></td>
    </tr>
	<tr>
          <td><?php echo JText::_( 'UPDATES' ); ?></td>
         <td>
		 	<div id="image" name="image"><img src="components/com_jsplocation/images/sh-ajax-loader-wide.gif" /></div>
		 	<div id="version"></div>
		  	<button id="chkupdates" class="btn btn-small" onclick="showUpdates();" href="#">Check For Update</button>	 
		</td>
        </tr>
		
		<tr id="show_notes">
          <td><?php echo JText::_( 'NOTES' ); ?></td>
          <td><div id="notes"></div></td>
        </tr>
  </table>
 <div id="license"></div> 
</div>