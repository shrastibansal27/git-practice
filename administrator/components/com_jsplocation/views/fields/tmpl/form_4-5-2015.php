<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: form.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$document =& JFactory::getDocument();
$document->addScript(JURI::base()."components/com_jsplocation/js/fields.js");
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
?>

<script language="javascript" type="text/javascript">
<!--

Joomla.submitbutton = function(pressbutton) {
	var submitForm = document.adminForm;
	
	if (pressbutton == 'cancel') {
	submitForm.submit();
	return true;
	}
	if(submitForm.field_name.value == ""){
		alert("You must provide a Field Name");
		submitForm.field_name.focus();
		return false;
	}
	else
	{
		if ( /[^ A-Za-z\-\d]/.test(submitForm.field_name.value)) {
    	alert("Please enter only letter and numeric characters");
    	submitForm.field_name.focus();
    	return false;
		}
	}
	submitForm.task.value=pressbutton;
	submitForm.submit();
}

//-->
</script>

<form action="index.php?option=com_jsplocation" method="post" name="adminForm" onsubmit="return submitbutton();" id="adminForm">
<div class="">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'DETAILS' ); ?></legend>
		<table class="table table-striped">
		
		<tr>
			<td class="key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'FIELDS_NAME' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'FIELDS_NAME' ); ?>:
				</label>
                </span>
			</td>
			<td>

				 <?php
						if(isset($this->data->id) and  $this->data->id<= 7){
						?>
					<input type="text" name="field_name" readonly="true" value="<?php echo $this->data->field_name; ?>">
						<?php
						}
						else
						{
						?>
			    <input type="text" name="field_name"  value="<?php echo $this->data->field_name; ?>">
				<?php } ?>
				<?php /*?><?php echo $this->data->field_name;?><?php */?>
			</td>
		</tr>
		<tr>
			<td class="key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'PUBLISH' ); ?>">
				<label for="name">
					<?php echo JText::_( 'PUBLISH' ); ?>:
				</label>
                </span>
			</td>
			<td >
			<fieldset id="published" class="radio btn-group">
			<input type="radio" name="published" value="1" <?php echo ($this->data->published == 1)? 'checked="checked"':''; ?> id="published1" />
            <label class="btn" for="published1"><?php echo JText::_('Yes'); ?></label>
            <input type="radio" name="published" value="0" <?php echo ($this->data->published ==0)? 'checked="checked"':''; ?> id="published0" />
            <label class="btn" for="published0"><?php echo JText::_('No'); ?></label>
            
            </fieldset>
			</td>
		</tr>		
		<tr>
			<td class="key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'SHOW_ON_THE_MAP' ); ?>">
				<label for="name">
					<?php echo JText::_( 'SHOW_ON_THE_MAP' ); ?>:
				</label>
                </span>
			</td>
			<td class="paramlist_value" width="60%"><fieldset id="map_display" class="radio btn-group">
			<input type="radio" name="map_display" value="1" <?php echo ($this->data->map_display == 1)? 'checked="checked"':''; ?> id="map_display1" />
            <label class="btn" for="map_display1"><?php echo JText::_('Yes'); ?></label>
            <input type="radio" name="map_display" value="0" <?php echo ($this->data->map_display ==0)? 'checked="checked"':''; ?> id="map_display0" />
            <label class="btn" for="map_display0"><?php echo JText::_('No'); ?></label>
            
            </fieldset></td>
		</tr>		
		<tr>
			<td class="key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'SHOW_ON_THE_SIDEBAR' ); ?>">
				<label for="name">
					<?php echo JText::_( 'SHOW_ON_THE_SIDEBAR' ); ?>:
				</label>
                </span>
			</td>
			<td >
		<fieldset id="sidebar_display" class="radio btn-group">
		<input type="radio" name="sidebar_display" value="1" <?php echo ($this->data->sidebar_display == 1)? 'checked="checked"':''; ?> id="sidebar_display1" />
		<label class="btn" for="sidebar_display1"><?php echo JText::_('Yes'); ?></label>
		<input type="radio" name="sidebar_display" value="0" <?php echo ($this->data->sidebar_display ==0)? 'checked="checked"':''; ?> id="sidebar_display0" />
		<label class="btn" for="sidebar_display0"><?php echo JText::_('No'); ?></label>
		</fieldset>
		</td>
		</tr>		
		</table>
	</fieldset>
</div>
<?php
if(isset($this->field_type)){
?>
<input type="hidden" name="field_type" value="<?php echo $this->field_type ?>" />
<?php
}
?>
<input type="hidden" name="option" value="com_jsplocation" />
<input type="hidden" name="task" value="fields" />
<input type="hidden" name="controller" value="fields" />
<input type="hidden" name="id" value="<?php echo $this->data->id; ?>"/>
<!--<input type="hidden" name="edit" value="" />-->
<?php echo JHtml::_('form.token'); ?>
</form>