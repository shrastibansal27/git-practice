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
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
JHTML::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$document = JFactory::getDocument();
$filepath = JURI::root() . '/' . "images" . '/' . "jsp_tickets" . '/' . "cat_images" . '/' . $this->catimage;
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/style.css" />');
?>
<script language="javascript" type="text/javascript">
var $jq_jspticket = jQuery.noConflict();
Joomla.submitbutton = function(pressbutton) {
	var submitForm = document.adminForm;
	var flag1=false;
	var msg_str='';
	
	if(pressbutton == 'cancel')
	{
		submitForm.task.value=pressbutton;
		submitForm.submit();
		return true;
	}
	
	if ( document.formvalidator.isValid(document.id('adminForm')) ) {
		submitForm.task.value=pressbutton;
		
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
		
		var assgn_to = submitForm.getElementById("jformassigned_to");
		var assgn_to_len=assgn_to.options.length;
		var c_assgn_to=0;
		
		for(i=0;i<assgn_to_len;i++)
		{
			if(assgn_to.options[i].selected)
			{
				c_assgn_to++;
			}
		}

		if((c_assgn_to > 0) && (submitForm.getElementById("jform_title").value!=''))
		{
			submitForm.submit();
			return true;
		} else {
			if(c_assgn_to == 0)
			{
				submitForm.getElementById("jform_assigned_to-lbl").className = "hasToolTip invalid";
				submitForm.getElementById("jformassigned_to").className = "required invalid";
				submitForm.getElementById("jformassigned_to").setAttribute("required", "true");
			}
			if(submitForm.getElementById("jform_title").value=='')
			{
				submitForm.getElementById("jform_title-lbl").className = "hasToolTip invalid";
				submitForm.getElementById("jform_title").className = "required invalid";
				submitForm.getElementById("jform_title").setAttribute("required", "true");
			}
			return false;
		}
	} else {
		if($jq_jspticket('#jformassigned_to').hasClass('invalid')){
			submitForm.getElementById("jform_assigned_to-lbl").className = "hasToolTip invalid";
			$jq_jspticket("#system-message").append('<div><p>Invalid field: <?php echo JText::_("CATEGORY_ASSIGNED_TO_LABEL");?></p></div>');
		}
		return false;
	}
}
</script>
<form  class="form-validate" name="adminForm" id="adminForm" method="post" action="index.php?option=com_jsptickets&task=catlist" enctype="multipart/form-data" onsubmit="return submitbutton();">
<?php echo $this->form->getInput('id', null, $this->catid);?>
<fieldset class="adminform">
<table class="admintable" width="100%">
	<tbody>		
		<tr>
			<td>
				<?php echo $this->form->getLabel('title'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('title', null , $this->cattitle); ?>
			</td>
		</tr>
		
		<tr>
			<td>
				<?php echo $this->form->getLabel('alias'); ?>
			</td>
			<td>
				<?php 
				if(isset($this->catpath) && $this->catpath=="uncategorised")
				{ ?>
				<label id="jform_alias" name="jform[alias]"><?php echo $this->catalias;?></label>
				<?php } else {
				echo $this->form->getInput('alias', null , $this->catalias);
				}?>
			</td>
		</tr>
		
		<tr>
			<td>
				<?php echo $this->form->getLabel('published'); ?>
			</td>
			<td>
				<?php 
				if(isset($this->catpath) && $this->catpath=="uncategorised")
				{ ?>
				<label id="jform_published" name="jform[published]">
				<?php echo $this->catpublished ? "Published" : "Unpublished" ;?>
				</label>
				<?php } else {
				echo $this->form->getInput('published', null , $this->catpublished);
				}?>				
			</td>
		</tr>
		
		<tr>
			<td>
				<?php echo $this->form->getLabel('parent_id'); ?>
			</td>
			<td>
				<?php
				if(isset($this->catpath) && $this->catpath=="uncategorised")
				{ ?>
					<label id="jform_parent_id" name="jform[parent_id]">
					<?php
					if($this->catparent_id=='1')
					{
						echo "-No Parent-";				
					} else {
						echo $this->getParentCategoryname($this->catparent_id);					
					}?> 
					</label>
				<?php } else { 
					echo $this->form->getInput('parent_id', null , $this->catparent_id); 
				} ?>		
			</td>
		</tr>
		
		<tr>
			<td>
				<?php echo JHTML::tooltip(JText::_('CATEGORY_DESCRIPTION_DESC'), JText::_('CATEGORY_DESCRIPTION_LABEL'), '', JText::_('CATEGORY_DESCRIPTION_LABEL'));?>
			</td>
			<td>
				<?php echo JFactory::getEditor()->display('description', $this->catdescription ,'350','250','40','6',array('pagebreak', 'readmore', 'image', 'article')); ?>	
			</td>
		</tr>
		
		<tr>
			<td>
				<?php echo $this->form->getLabel('image'); ?><label>[<?php echo JText::_('MAX_FILESIZE_2MB'); ?>]</label>
			</td>
			<td>
				<?php echo $this->form->getInput('image', null, $this->catimage); ?>
				<?php if( $this->catimage != null ) { ?>
					<span class="editlinktip">
						<label id="paramsshowAllChildren-lbl" for="paramsshowAllChildren" class="hasTip" title='<img src="<?php echo $filepath; ?>" width="100" height="100"/>'>
							<?php echo JText::_('IMAGE_PREVIEW'); ?>
						</label>
					</span>		
				<?php } else {?>
						<label class="label_image">
							<?php echo JText::_('NO_IMAGE'); ?>
						</label>
					</span>		
				<?php } ?>
			</td>
		</tr>
		
		<tr>
			<td>
				<?php echo $this->form->getLabel('assigned_to'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('assigned_to', null , $this->catassigned_to); ?>	
			</td>
		</tr>
	</tbody>
</table>
</fieldset>
<div>
<input type="hidden" name="post_image" value= '<?php echo $this->catimage ;?>' />
<input type="hidden" name="option" value="com_jsptickets" />
<input type="hidden" name="controller" value="catform" />
<input type="hidden" name="task" value="catform" />
<?php echo JHtml::_('form.token'); ?>
</div>
</form>