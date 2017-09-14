<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: about.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
JHTML::_('behavior.tooltip');
$document = JFactory::getDocument();
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/style.css" />');
//checking extension version
$document->addScript('components/com_jsptickets/js/jquery-1.10.1.min.js'); //Only needed in joomla 2.5
JHTML::_('script','system/modal.js', false, true);
JHTML::_('stylesheet','system/modal.css', array(), true);
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
		window.onload = function(){showUpdates();}
");
$document->addCustomTag('<script language="javascript" type="text/javascript" src="components/com_jsptickets/js/ticket.js"></script>');
$document->addCustomTag('<script language="javascript" type="text/javascript" src="components/com_jsptickets/js/jquery.mCustomScrollbar.min.js"></script>');
?>
<form id="adminForm" name="adminForm" action="index.php?option=com_jsptickets" method="post">
<table class="adminform" width="100%">
  <tbody>
    <tr>
		<td width="100%" valign="top">
				<div id="content-pane" class="pane-sliders">
				  <table cellpadding="4" cellspacing="0" border="1" class="adminform" width="100%">
						<tr class="row0">
						  <th colspan="2"  style="background-color:#FFF;"> <div style="float:left;"> <a href="http://www.joomlaserviceprovider.com" title="Joomla Service Provider" target="_blank"><img src="components/com_jsptickets/images/logo.jpg" alt="Joomla Service Provider" border="none"/></a></div>
							<div style="text-align:center;margin-top:25px;">
							  <h3><?php echo JText::_( 'JSPTICKETS' ); ?></h3>
							</div>
						  </th>
						</tr>
						<tr class="row1">
						  <td width="100"><?php echo JText::_( 'VERSION_TEXT' ); ?></td>
						  <td><?php echo JText::_( 'VERSION_DESCRIPTION' ); ?></td>
						</tr>
						<tr class="row2">
						  <td><?php echo JText::_( 'SUPPORT' ); ?></td>
						  <td><a href="http://www.joomlaserviceprovider.com/component/kunena/44-jsp-tickets.html" target="_blank"><?php echo JText::_( 'JSPTICKETS_FORUM' ); ?></a></td>
						</tr>
						<tr>
							<td><?php echo JText::_( 'UPDATES' ); ?></td>
							 <td>
								<div id="image" name="image"><img src="components/com_jsptickets/images/sh-ajax-loader-wide.gif" /></div>
								<div id="version"></div>
								<input type="button" id="chkupdates" class="btn btn-small" onclick="showUpdates();" value="<?php echo JText::_( 'CHECK_FOR_UPDATE' ); ?>" />
							</td>
						</tr>
						<tr id="show_notes">
						  <td><?php echo JText::_( 'NOTES' ); ?></td>
						  <td><div id="notes"></div></td>
						</tr>
				  </table>
				</div>
			</td>
		</tr>
	</tbody>
	</table>