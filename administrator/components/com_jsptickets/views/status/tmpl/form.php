<?php
/**
* JSP Tickets components for Joomla!
* JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
* developed by Joomla Service Provider Team.
* @author      $Author: Ajay Lulia $
* @copyright   Joomla Service Provider - 2013
* @package     JSP Tickets 1.0
* @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
* @version     $Id: form.php  $
*/

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
JHTML::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
$document = JFactory::getDocument();
$document->addScript('components/com_jsptickets/js/jquery-1.10.1.min.js');
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/style.css" />');
?>
<script language="javascript" type="text/javascript">
var $jq_jspticket = jQuery.noConflict();
Joomla.submitbutton = function(pressbutton) {
	var submitForm = document.adminForm;
	var vtitle=flag1=true;
	
	if ( pressbutton == 'cancel' )
	{
		submitForm.task.value=pressbutton;
		submitForm.submit();
		return true;
	}
	
	if ( document.formvalidator.isValid(document.id('adminForm')) ) {		
	var editorpresent = ($jq_jspticket('#description_ifr')[0]!=undefined); //returns true is TinyMCE editor present
			
	editordesctext = false;
	textarea_hidden = $jq_jspticket('textarea#description:hidden').length;
	if(editorpresent && textarea_hidden==1) {
		$jq_jspticket($jq_jspticket('#description_ifr')[0].contentWindow).each(function() {
			var editor_text = $jq_jspticket('#description_ifr').contents().find('body').text();
			var chk_edit=/[0-9a-zA-Z]/.test(editor_text);
			if(!chk_edit) {
				flag1 = false;
			} else {
				//if something is present in editor
				editordesctext = true;
				flag1 = true;
			}
		});
	}

	// first check whether there is content in the editor of the description if no text is present then start checking the textarea
	if($jq_jspticket('textarea#description') && editordesctext == false && textarea_hidden==0) {
		$jq_jspticket('textarea#description').each(function() {
			var textarea_text = $jq_jspticket(this).val();
			if(editorpresent && textarea_text!=null) //if TinyMCE editor is present instead of textarea
			{					
				$jq_jspticket($jq_jspticket('#description_ifr')[0].contentWindow).each(function() {
						$jq_jspticket('#description_ifr').contents().find('body').text(textarea_text);
				});
			}
			var chk_text=/[0-9a-zA-Z]/.test(textarea_text);
			if(!chk_text) {
				flag1 = false;
			} else {
				//if something is present in editor
				flag1 = true;
			}
		});
	}
	
		if(submitForm.getElementById("jform_name").value!="")
		{
			vtitle = true;
		} else {
			vtitle = false;
		}

		if(vtitle==true)
		{
			submitForm.task.value=pressbutton;
			submitForm.submit();
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}
</script>
<form class="form-validate" id="adminForm" name="adminForm" method="post" action="index.php?option=com_jsptickets&task=statuslist" enctype="multipart/form-data" onsubmit="return false;">
<?php echo $this->form->getInput('id', null, $this->statusid);?>
<fieldset class="adminform">
<table class="admintable" width="100%">
	<tbody>		
		<tr>
			<tr>
			<td>
				<?php echo $this->form->getLabel('name'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('name', null , $this->statusname); ?>
			</td>
		</tr>
			
		<tr>
			<td>
				<?php echo $this->form->getLabel('publish'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('publish', null , $this->statuspublish); ?>
			</td>
		</tr>
				
		<tr>
			<td>
				<?php echo JHTML::tooltip(JText::_('STATUS_DESCRIPTION_DESC'), JText::_('STATUS_DESCRIPTION_LABEL'), '', JText::_('STATUS_DESCRIPTION_LABEL'));?>
			</td>
			<td>
				<?php echo JFactory::getEditor()->display('description', $this->statusdescription ,'350','250','40','6',array('pagebreak', 'readmore', 'image', 'article')); ?>
			</td>
		</tr>
	</tbody>
</table>
</fieldset>
<div>
<input type="hidden" name="option" value="com_jsptickets" />
<input type="hidden" name="controller" value="statusform" />
<input type="hidden" name="task" value="statusform" />
<?php echo JHtml::_('form.token'); ?>
</div>
</form>