<?php

/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: list.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$document = JFactory::getDocument();
JHtml::_('behavior.framework', true);
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
");
$document->addCustomTag('<script language="javascript" type="text/javascript" src="components/com_jsplocation/js/jsplocation.js"></script>');
$document->addCustomTag('<script language="javascript" type="text/javascript" src="components/com_jsplocation/js/googleplaces.js"></script>');

$document->addStyleSheet(JURI::base() . "components/com_jsplocation/css/jsplocation.css");
?>

<legend><?php echo JText::_('GOOGLE_PLACES_LOCATIONS');?></legend>
<form action="index.php?option=com_jsplocation" method="post" name="adminForm" id="adminForm" onsubmit="searchbtn.disabled = true;filterbtn.disabled = true;">
			<div>
			
				<label for="apikey"><span style="width:220px; display:inline-block;">Google places API key</span>
                   <input id="apikey" type="text" value="<?php echo $this->apikey;?>" title="apikey" style="width:300px;" placeholder = "Enter Your Google API Key"  name="apikey" on change="document.adminForm.submit();">&nbsp;&nbsp;&nbsp;<a href="https://console.developers.google.com/apis/credentials" target='_blank'>Generate Google Places API Key</a>
                </label>
			</div>
			
			<div id="filter-bar" class="btn-toolbar">
			<label for="search"><span class="pull-left" style="width:220px;">Search Stores On Google Places</span>
				<div class="filter-search btn-group pull-left">
					<input id="search" type="text" title="Search" value="" placeholder="For Eg: Nike Stores In Mumbai" name="search" on change="document.adminForm.submit();">
				</div>
				
				<div class="btn-group pull-left">
				<!--<button class="btn tip" rel="tooltip" type="submit" data-original-title="Search" onclick="this.form.submit();">-->
					<button class="btn tip" id="searchbtn" name="searchbtn" rel="tooltip" type="submit" data-original-title="Search" onclick="return EnterPlace();">
						<i class="icon-search"></i>
					</button>
					<button class="btn tip" id="filterbtn" name="filterbtn" rel="tooltip" onclick="document.id('search').value='';this.form.submit();" type="button" data-original-title="Clear">
						<i class="icon-remove"></i>
					</button>
				</div>
				</label>
			</div>	
<table class="table table-striped" cellspacing="1">			
	<tr>
	     <th class="title">
			<?php echo JText::_( 'NUM' ); ?>
		</th>
		<th class="title">
			<?php echo JText::_( 'NAME' ); ?>
		</th>
		<th class="title">
			<?php echo JText::_( 'ADDRESS_LIST' ); ?>
		</th>
		<th class="title">
			<?php //echo JText::_( 'CREATE_LOCATION' ); ?>
		</th>
	</tr>
	
</thead>
<tbody>
	<?php
	$i=0;$k = 0;
	if($this->result != null){
	foreach($this->result as $row){
	 
	?>
	<tr class="<?php echo "row$k"; ?>">
		
		<td align="left">
			<?php echo $row->id; ?>
		</td>
		<td align="left">
        	
			<?php echo $row->name; ?>
            </span>
		</td>	
		<td align="left">
			<?php echo $row->address; ?>
		</td>
		<td align="left"> 
		<input type="button"  name="button" class="btn btn-info" value="Create Location" id="<?php echo $row->id;?>" onclick ="return SelectLocation(this.id)"></input></td>	
        <a href="<?php echo JURI::base(); ?>index.php?option=com_jsplocation&task=googleplaces">
            	
            </a>
				
		</td>
		
		</tr>
	<?php
		$k = 1 - $k;	$i++;
	}
}
else { echo '<tr><td colspan="10"><center><h5>'. JText::_('NO_RESULT_IN_LIST') .'</h5></center></td></tr>'; }
	?>
</tbody>
</table>				
<input type="hidden" name="option" value="com_jsplocation" />
<input type="hidden" name="task" value="googleplaces" />
<input type="hidden" name="controller" value="googleplaces" />
<input type="hidden" id="createlocationid" name="id" value="" />
<?php echo JHtml::_('form.token'); ?>
</form>