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
JHtml::_('behavior.tooltip');
$document =& JFactory::getDocument();
JHtml::_('behavior.framework', true);
JHTML::_('script','system/modal.js', false, true);
JHTML::_('stylesheet','system/modal.css', array(), true);
$document->addCustomTag('<script language="javascript" type="text/javascript" src="components/com_jsplocation/js/country.js"></script>');
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

<form action="index.php?option=com_jsplocation" method="post" name="adminForm" onsubmit="return submitbutton();" id="adminForm">
<div class="">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'DETAILS' ); ?></legend>
		<table class="table table-striped" cellspacing="1">
		<tr>
			<td class="key">
            	<span class="editlinktip hasTip" title="<?php echo JText::_( 'COUNTRY' ); ?>">
				<label for="name">
        			<?php echo JText::_( 'COUNTRY' ); ?>:
				</label>
                </span>
			</td>
			<td>
				<input type="text" id="country" name="country" value="<?php echo preg_replace('/[[:^print:]]/','',$this->data->title); ?>">
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
			<td>
			    <fieldset id="published" class="radio btn-group">
            	<input  type="radio" name="published" value="1"  <?php echo ($this->data->published == 1) ? 'checked="checked"' : ""; ?> id="published1" /><label class="btn" for="published1">Yes</label>
				<input type="radio" name="published" value="0"  <?php echo ($this->data->published == 0) ? 'checked="checked"' : ""; ?> id="published0" /><label class="btn" for="published0">No</label>
				</fieldset>
			</td>
		</tr>		
		</table>
	</fieldset>
</div>				
<input type="hidden" name="option" value="com_jsplocation" />
<input type="hidden" name="task" value="country" />
<input type="hidden" name="controller" value="country" />
<input type="hidden" name="id" value="<?php echo $this->data->id; ?>" />
<?php echo JHtml::_('form.token'); ?>
</form>
