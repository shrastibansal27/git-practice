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
jimport('joomla.html.pane');

JHtml::_('behavior.framework', true);
JHTML::_('script','system/modal.js', false, true);
JHTML::_('stylesheet','system/modal.css', array(), true);

$document = JFactory::getDocument();
$document->addScript(JURI::base()."components/com_jsptickets/js/ticket.js");
$document->addScript('components/com_jsptickets/js/jquery-1.10.1.min.js');
$document->addScript('components/com_jsptickets/js/jquery.cookie.js'); //js file to manage jQuery cookies
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/style.css" />');
$user = JFactory::getUser();
$model = $this->getModel( 'tickets' );
if(!$user->guest) // check if a user is registered user or a guest
{
	$currentUsersGrp = $model->getUserGroupByUid($user->id);
} else {
	$currentUsersGrp = "Guest";
}
$action = "index.php?option=com_jsptickets&controller=ticketlist&task=edit&ticketcode=".$this->ticketcode;
$i = 2;
?>
<script language="javascript" type="text/javascript">
var $jq_jspticket = jQuery.noConflict();

$jq_jspticket(document).ready(function (){

	currentTab=$jq_jspticket.cookie("currentTab");
	if(currentTab!=undefined && $jq_jspticket("div #"+currentTab).length!=0)
	{
		currenttabid="#"+currentTab;
		$jq_jspticket(".nav-tabs > li > a").each( function(){
			if ($jq_jspticket(this).attr("href")==currenttabid)
			{
				$jq_jspticket(this).parent("li").attr("class","active");
				$jq_jspticket(this).attr("class","tab-pane active");
			} else {
				$jq_jspticket(this).parent("li").attr("class","");
				$jq_jspticket(this).attr("class","tab-pane");
			}
		});
		$jq_jspticket("div .tab-pane").each( function(){
			// remove all ".tab-pane active" and replace with ".tab-pane"
			$jq_jspticket(this).attr("class","tab-pane");
		});
		// then only apply ".tab-pane active" to the current active tab
		$jq_jspticket("div "+currenttabid).attr("class","tab-pane active");
	} else {
	// leave as it is
	$jq_jspticket(".nav-tabs > li > a:first").parent("li").attr("class","active");
	$jq_jspticket(".nav-tabs > li > a:first").attr("class","tab-pane active");
	$jq_jspticket(".tab-content > .tab-pane:first").attr("class","tab-pane active");
	}
});

function setTabCookie(getId)
{
	var currentTab;
	$jq_jspticket.cookie("currentTab", getId);
	currentTab=$jq_jspticket.cookie("currentTab");
	return;
}

Joomla.submitbutton = function(pressbutton) {
	var submitForm = document.adminForm;
	var vtitle = vsubject = true;
	var flag1 = flag2 = flag3 = flag4 = true;
	var editordesctext = true;
	if( ( pressbutton == 'cancel' ) )
	{
		submitForm.controller.value="ticketform";
		submitForm.task.value=pressbutton;
		submitForm.submit();
		return true;
	}
	
	if ( document.formvalidator.isValid(document.id('adminForm')) )//jform_created_for_name
	{				
		if(submitForm.getElementById("jform_title") != null)
		{
			if(submitForm.getElementById("jform_title").value!='')
			{
			
			var theValue = $jq_jspticket("#jform_title").val().trim();
					
					
					if(theValue == ''){
					vtitle = false;
					}
					else{
					vtitle = true;
					}
			
			
			
			} else {
				submitForm.getElementById("jform_title").className = "required invalid";
				submitForm.getElementById("jform_title").required = "true";
				vtitle = false;
				alert('<?php echo JTEXT::_("MANDATORY_FIELD_MISSING");?>');
				return false;
			}
		}
		
		if(submitForm.getElementById("jform_subject") != null)
		{
			if(submitForm.getElementById("jform_subject").value!='')
			{
				
				var theValue = $jq_jspticket("#jform_subject").val().trim();
					
					if(theValue == ''){
					vsubject = false;
					}
					else{
					vsubject = true;
					}
				
				
				
			} else {
				submitForm.getElementById("jform_subject").className = "required invalid";
				submitForm.getElementById("jform_subject").required = "true";
				vsubject = false;
				alert('<?php echo JTEXT::_("MANDATORY_FIELD_MISSING");?>');
				return false;
			}
		}
		
		if(submitForm.getElementById("category_id") != null)
		{
			if(submitForm.getElementById("category_id").selectedIndex >-1)
			{
				//if any option is selected
				flag1 = true;
			} else {
				submitForm.getElementById("category_id").className = "required invalid";
				submitForm.getElementById("category_id").required = "true";
				flag1 = false;
				alert('<?php echo JTEXT::_("MANDATORY_FIELD_MISSING");?>');
				return false;
			}
		}
				
		if(submitForm.getElementById("jform_created_for_id")!=undefined && submitForm.getElementById("jform_created_for")!=undefined)
		{
			if(submitForm.getElementById("jform_created_for_id").value=='' || submitForm.getElementById("jform_created_for_id").value==0)
			{
				submitForm.getElementById("jform_created_for").className = "required invalid";
				submitForm.getElementById("jform_created_for").setAttribute("required", "true");
				flag2 = false;
			} else {
				flag2 = true;
			}
		}
		
		if(submitForm.getElementById("jform_created_for_id")!=undefined && submitForm.getElementById("jform_created_for_name")!=undefined)
		{
			if(submitForm.getElementById("jform_created_for_id").value=='' || submitForm.getElementById("jform_created_for_id").value==0)
			{
				submitForm.getElementById("jform_created_for_name").className = "required invalid";
				submitForm.getElementById("jform_created_for_name").setAttribute("required", "true");
				flag2 = false;
			} else {
				flag2 = true;
			}
		}
		
		if(submitForm.getElementById("jform_assigned_to_id")!=undefined && submitForm.getElementById("jform_assigned_to")!=undefined)
		{
			if(submitForm.getElementById("jform_assigned_to_id").value=='' || submitForm.getElementById("jform_assigned_to_id").value==0)
			{
				submitForm.getElementById("jform_assigned_to").className = "required invalid";
				submitForm.getElementById("jform_assigned_to").setAttribute("required", "true");
				flag3 = false;
			} else {
				flag3 = true;
			}
		}
		
		if(submitForm.getElementById("jform_assigned_to_id")!=undefined && submitForm.getElementById("jform_assigned_to_name")!=undefined)
		{
			if(submitForm.getElementById("jform_assigned_to_id").value=='' || submitForm.getElementById("jform_assigned_to_id").value==0)
			{
				submitForm.getElementById("jform_assigned_to_name").className = "required invalid";
				submitForm.getElementById("jform_assigned_to_name").setAttribute("required", "true");
				flag3 = false;
			} else {
				flag3 = true;
			}
		}
				
		var editorpresent = ($jq_jspticket('#description_ifr')[0]!=undefined); //returns true is TinyMCE editor present
			
		editordesctext = false;
		textarea_hidden = $jq_jspticket('textarea#description:hidden').length;
		if(editorpresent && textarea_hidden==1) {
		$jq_jspticket($jq_jspticket('#description_ifr')[0].contentWindow).each(function() {
			var editor_text = $jq_jspticket('#description_ifr').contents().find('body').text();
			var chk_edit=/[0-9a-zA-Z]/.test(editor_text);
			if(!chk_edit) {
				flag4 = false;
			} else {
				//if something is present in editor
				editordesctext = true;
				flag4 = true;
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
				flag4 = false;
			} else {
				//if something is present in editor
				flag4 = true;
			}
		});
	}
		
		var c_editorpresent = ($jq_jspticket('#comments_ifr')[0]!=undefined); //returns true is TinyMCE editor present

		c_editordesctext = false;
		c_textarea_hidden = $jq_jspticket('textarea#comments:hidden').length;
		if(c_editorpresent && c_textarea_hidden==1) {
			$jq_jspticket($jq_jspticket('#comments_ifr')[0].contentWindow).each(function() {
				var editor_text = $jq_jspticket('#comments_ifr').contents().find('body').text();
				var chk_edit=/[0-9a-zA-Z]/.test(editor_text);
				if(!chk_edit) {
					flag5 = false;
				} else {
					//if something is present in editor
					c_editordesctext = true;
					flag5 = true;
				}
			});
		}

		// first check whether there is content in the editor of the comment if no text is present then start checking the textarea
		if($jq_jspticket('textarea#comments') && c_editordesctext == false && c_textarea_hidden==0) {
			$jq_jspticket('textarea#comments').each(function() {
				var c_textarea_text = $jq_jspticket(this).val();
				if(c_editorpresent && c_textarea_text!=null) //if TinyMCE editor is present instead of textarea
				{
					$jq_jspticket($jq_jspticket('#comments_ifr')[0].contentWindow).each(function() {
							$jq_jspticket('#comments_ifr').contents().find('body').text(c_textarea_text);
					});
				}
				var chk_text=/[0-9a-zA-Z]/.test(c_textarea_text);
				if(!chk_text) {
					flag5 = false;				
				} else {
					//if something is present in editor
					flag5 = true;
				}
			});
		}

		var f_editorpresent = ($jq_jspticket('#feedback_ifr')[0]!=undefined); //returns true is TinyMCE editor present

		f_editordesctext = false;
		f_textarea_hidden = $jq_jspticket('textarea#feedback:hidden').length;
		if(f_editorpresent && f_textarea_hidden==1) {
			$jq_jspticket($jq_jspticket('#feedback_ifr')[0].contentWindow).each(function() {
				var editor_text = $jq_jspticket('#feedback_ifr').contents().find('body').text();
				var chk_edit=/[0-9a-zA-Z]/.test(editor_text);
				if(!chk_edit) {
					flag6 = false;
				} else {
					//if something is present in editor
					f_editordesctext = true;
					flag6 = true;
				}
			});
		}

		// first check whether there is content in the editor of the feedback if no text is present then start checking the textarea
		if($jq_jspticket('textarea#feedback') && f_editordesctext == false && f_textarea_hidden==0) {
			$jq_jspticket('textarea#feedback').each(function() {
				var f_textarea_text = $jq_jspticket(this).val();
				if(f_editorpresent && f_textarea_text!=null) //if TinyMCE editor is present instead of textarea
				{
					$jq_jspticket($jq_jspticket('#feedback_ifr')[0].contentWindow).each(function() {
							$jq_jspticket('#feedback_ifr').contents().find('body').text(f_textarea_text);
					});
				}
				var chk_text=/[0-9a-zA-Z]/.test(f_textarea_text);
				if(!chk_text) {
					flag6 = false;				
				} else {
					//if something is present in editor
					flag6 = true;
				}
			});
		}
		
		if(flag4 == false)
		{
			alert('<?php echo $this->escape(JText::_('TICKET_DESCRIPTION_EMPTY'));?>');
		}
		if(vtitle == false || vsubject== false || flag1 == false || flag2 == false || flag3 == false || flag4 == false) // if condition gets false
		{
			alert('<?php echo JTEXT::_("MANDATORY_FIELD_MISSING");?>');
			return false;
		} else {	// if all fields are valid including jform fields then submit the form
			submitForm.controller.value="ticketform";
			submitForm.task.value=pressbutton;
			submitForm.submit();
			return true;
		}
	} else {
		alert('<?php echo JTEXT::_("MANDATORY_FIELD_MISSING");?>');
		return false;
	}
}

function remleft()
{
	var submitForm = document.adminForm;
	var tex = submitForm.comments.value;
	var len = tex.length;
	var rem = 120-len;

	if(rem<0)
	{
		rem=0;
	}

	submitForm.rem.value = rem;

	if(len >= 120)
	{
		tex = tex.substring(0,120);
		submitForm.comments.value = tex;
		return false;
	}

} 

</script>
<form  class="form-validate" name="adminForm" id="adminForm" method="post" action="<?php echo $action;?>" enctype="multipart/form-data">
<?php
	//echo $this->pane->startPane('config-pane');
	//echo $this->pane->startPanel(JText::_('TICKET_FORM'), 'Ticket Form');
?>

<ul class="nav nav-tabs">
  <li class="active"><a href="#ticket_form" data-toggle="tab" onclick='setTabCookie("ticket_form");'><?php echo JText::_('TICKET_FORM');?></a></li>
  <li><a href="#ticket_comments" data-toggle="tab" onclick='setTabCookie("ticket_comments");'><?php echo JText::_('COMMENTS');?></a></li>
<?php if($this->attach != null) { ?>
  <li><a href="#ticket_attachments" data-toggle="tab" onclick='setTabCookie("ticket_attachments");'><?php echo JText::_('ATTACHMENTS');?></a></li>
<?php } ?>
<?php if($this->ticketid != 0) { ?>
  <li><a href="#ticket_feedbacks" data-toggle="tab" onclick='setTabCookie("ticket_feedbacks");'><?php echo JText::_('FEEDBACKS');?></a></li>
  <li><a href="#ticket_log" data-toggle="tab" onclick='setTabCookie("ticket_log");'><?php echo JText::_('LOG');?></a></li>
<?php } ?>
</ul>

<div class="tab-content"> <!-- content-tab div starts here -->
<div class="tab-pane active" id="ticket_form">
<?php echo $this->form->getInput('id', null, $this->ticketid);?>
<fieldset class="adminform">
<table class="adminlist align-left" width="100%">

	<tbody>
		<tr>
			<td>
				<?php echo $this->form->getLabel('title'); ?>
			</td>
			<td>
				<?php

				$tickettitle = ltrim($this->tickettitle);
				
				echo $this->form->getInput('title', null ,$tickettitle); ?>
			</td>
		</tr>
		
		<tr>
			<td>
				<?php echo $this->form->getLabel('subject'); ?>
			</td>
			<td>
				<?php

				 $ticketsubject = ltrim($this->ticketsubject);
				
				echo $this->form->getInput('subject', null ,$ticketsubject); ?>		
			</td>
		</tr>
		<!--
		<tr>
			<td>
				<?php //echo $this->form->getLabel('category_extension'); ?>
			</td>
			<td>
				<?php //echo $this->form->getInput('category_extension', null , $this->ticketcategory_extension); ?>		
			</td>
		</tr>
		-->
		<tr>
			<td>
				<label id="category_id-lbl" class="required" title="" for="category_id" aria-invalid="false">
				<?php echo JHTML::tooltip(JText::_('TICKET_CATEGORY_DESC'), JText::_('TICKET_CATEGORY_LABEL'), '', JText::_('TICKET_CATEGORY_LABEL'));?>
				<span class="star">&nbsp;*</span>
				</label>
			</td>
			<td>
				<?php echo $this->list['category'] ; ?>		
			</td>
		</tr>
		
		<?php //if($this->ticketid == '') echo "<script type=\"text/javascript\">showCategoriesAdmin(document.getElementById('jform_category_extension').value);</script>";
			//if($this->ticketid == '') echo "<script type=\"text/javascript\">showCategoriesAdmin(" . $this->config[0]->category_extension . ");</script>";
		?>
		
		<tr>
			<td>
				<?php echo $this->form->getLabel('priority'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('priority', null , $this->ticketpriority_id); ?>		
			</td>
		</tr>
		
		<tr>
			<td>
				<?php echo $this->form->getLabel('status'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('status', null , $this->ticketstatus_id); ?>		
			</td>
		</tr>
		
		<tr>
			<td>
				<?php echo $this->form->getLabel('attachment'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('attachment', null , ''); ?>		
			</td>
		</tr>
		
		<tr>
			<td>
				<?php echo $this->form->getLabel('created_for'); ?>
			</td>
			<td>	
				<?php if($this->ticketid != 0)
					{
						if( ($this->ticketcreated_by == 0 || $this->ticketcreated_by == '') && ($this->ticketguestname) && ($this->ticketguestemail) ) 
						{
							echo '<span><label id="guestuser_created_for">'.$this->ticketguestemail.'</label></span>';
							echo '<input type="hidden" id="jform_created_for_id" name="jform[created_for]" value="0"/>';
						} else {
							echo $this->form->getInput('created_for', null , $this->ticketcreated_for); 
						}
					} else { 
						echo $this->form->getInput('created_for', null , $this->ticketcreated_for); 
					} 
				?>
			</td>
		</tr>
				
		<tr>
			<td>
				<?php echo $this->form->getLabel('assigned_to'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('assigned_to', null , $this->ticketassigned_to); ?>		
			</td>
		</tr>
		
		<tr>
			<td>
				<label id="description-lbl" class="required" title="" for="description" aria-invalid="false">
				<?php echo JHTML::tooltip(JText::_('TICKET_DESCRIPTION_DESC'), JText::_('TICKET_DESCRIPTION_LABEL'), '', JText::_('TICKET_DESCRIPTION_LABEL'));?>
				<span class="star">&nbsp;*</span>
				</label>
			</td>
			<td> 
					<?php
					//JFactory::getEditor()->display($name, $html, $width, $height, $col, $row, $buttons=true, $id=null, $params=array())
					echo JFactory::getEditor()->display('description', $this->ticketdescription ,'350','250','40','6',array('pagebreak', 'readmore', 'image', 'article')); ?>	
			</td>
		</tr>
		<?php 
		if($this->ticketid != 0)
		{
			if( ($this->ticketcreated_by == 0 || $this->ticketcreated_by == '') && ($this->ticketguestname) && ($this->ticketguestemail) ) {?>
		<tr>
			<td>
				<label id="guestname_lbl" title="">
				<?php echo JHTML::tooltip(JText::_('TICKET_GUESTNAME_DESC'), JText::_('TICKET_GUESTNAME_LABEL'), '', JText::_('TICKET_GUESTNAME_LABEL'));?>
				<span class="star">&nbsp;*</span>
				</label>
			</td>
			<td>
				<?php echo $this->ticketguestname; ?>
			</td>
		</tr>
		<tr>
			<td>
				<label id="guestemail_lbl" title="">
				<?php echo JHTML::tooltip(JText::_('TICKET_GUESTEMAIL_DESC'), JText::_('TICKET_GUESTEMAIL_LABEL'), '', JText::_('TICKET_GUESTEMAIL_LABEL'));?>
				<span class="star">&nbsp;*</span>
				</label>
			</td>
			<td>
				<?php echo $this->ticketguestemail; ?>
			</td>
		</tr>
		<?php } else {?>
		<tr>
			<td>
				<label id="username_lbl" title="">
				<?php echo JHTML::tooltip(JText::_('TICKET_USERNAME_DESC'), JText::_('TICKET_USERNAME_LABEL'), '', JText::_('TICKET_USERNAME_LABEL'));?>
				<span class="star">&nbsp;*</span>
				</label>
			</td>
			<td>
				<?php echo JFactory::getUser($this->ticketcreated_by)->name; ?>
			</td>
		</tr>
		<tr>
			<td>
				<label id="useremail_lbl" title="">
				<?php echo JHTML::tooltip(JText::_('TICKET_USEREMAIL_DESC'), JText::_('TICKET_USEREMAIL_LABEL'), '', JText::_('TICKET_USEREMAIL_LABEL'));?>
				<span class="star">&nbsp;*</span>
				</label>
			</td>
			<td>
				<?php echo JFactory::getUser($this->ticketcreated_by)->email; ?>
			</td>
		</tr>
		<?php } } ?>
	</tbody>

</table>
</fieldset>
</div>
<?php
	//echo $this->pane->endPanel();
	//echo $this->pane->startPanel(JText::_('COMMENTS'), 'comments');
?>

<div class="tab-pane" id="ticket_comments">
<fieldset class="adminform">
<table class="adminlist table-striped align-left" width="100%">
	<thead>
		<tr class="row<?php echo $i % 2; ?>">
			<th width="300px">
				<?php echo JText::_('COMMENTS'); ?>
			</th>
			
			<th>
				<?php echo JText::_('CREATED'); ?>
			</th>
			
			<th>
				<?php echo JText::_('CREATED_BY'); ?>
			</th>
			
			<th width="80px">
				<?php echo JText::_('ACTIONS'); ?>
			</th>
		</tr>
	<tbody>
		<?php  if($this->comments != null) {
				foreach ($this->comments as $i => $item) {?>
		<tr class="row<?php echo $i % 2; ?>">
			<td width="300px">
				<?php echo html_entity_decode($item->comments);?>
			</td>
			
			<td>
				<?php echo $item->created; ?>
			</td>
			
			<td>
				<?php if($item->created_by == 0){
						echo $this->ticketguestname." (".JText::_("GUEST_USER").")";
					} else {
						echo $this->getUserById($item->created_by); } ?>
			</td>
			
			<td width="80px">
				<?php $coid = $item->id;
					$user = JFactory::getUser();
					if($currentUsersGrp == "Super Users" || $currentUsersGrp == "Administrator" || $user->id == $item->created_by)
					  { ?>
						<a class="view_log_btn" href="index.php?option=com_jsptickets&controller=ticketlist&task=edit&ticketcode=<?php echo $this->ticketcode;?>&editcommentid=<?php echo $coid;?>" ><?php echo JText::_('BTN_EDIT');?></a>
						<a class="view_log_btn" href="index.php?option=com_jsptickets&controller=ticketform&task=commentdelete&commentid=<?php echo $coid;?>&ticketcode=<?php echo $this->ticketcode;?>" ><?php echo JText::_('BTN_DELETE');?></a>
				<?php } else {
						echo '<h6>'.JText::_("NO_ACTIONS").'</h6>';
					  }?>
			</td>
			<?php }?>
		</tr>
		
		<tr>
			<td colspan="4">
				<?php echo $this->commentpagination->getPagesLinks(); ?>
			</td>
		</tr>
		<?php } else { echo '<tr><td colspan="5"><center><h5>'. JText::_('NO_COMMENT_IN_TICKET') .'</h5></center></td></tr>'; } ?>
		<tr>
			<td>
				<label id="comments-lbl" class="hasTooltip required" title="" for="comments" aria-invalid="false">
				<?php echo JHTML::tooltip(JText::_('TICKET_COMMENTS_DESC'), JText::_('TICKET_COMMENTS_LABEL'), '', JText::_('TICKET_COMMENTS_LABEL'));?>
				</label>
			</td>
			<td colspan="3">
				<?php //echo $this->form->getInput('description', null, $this->catdescription);
				//JFactory::getEditor()->display($name, $html, $width, $height, $col, $row, $buttons=true, $id=null, $params=array())
				if(isset($this->commentedit[0]->comments))
				{
					$comment = $this->commentedit[0]->comments;
				}	else	{
					$comment = '';
				}
				if($this->tickettweet_id == '')
				{
					echo JFactory::getEditor()->display('comments', $comment ,'350','250','40','6',array('pagebreak', 'readmore', 'image', 'article')); 	
				} else {
					echo '<textarea id="comments" name="comments" placeholder="Tweet comment not to be more than 120 char.s" width="350" height="250" cols="40" rows="6" onKeyUp="return remleft();">'.$comment.'</textarea>';
					echo "<br>".'<label for="rem">Words left - </label>'.'<input type="text" name="rem" size="3" readonly value="120" class="inputboxwc" />';
				}
				?>
			</td>
		</tr>
		
		<tr>
			<td>
				<?php echo $this->form->getLabel('email_comment'); ?>
			</td>
			<td colspan="3">
				<?php echo $this->form->getInput('email_comment', null , $this->ticketemail_comment); ?>
			</td>
		</tr>
	</tbody>
</table>
</fieldset>
</div>
<?php
	//echo $this->pane->endPanel();
	
	if($this->attach != null) {
	//echo $this->pane->startPanel(JText::_('ATTACHMENTS'), 'attachments');
?>
<div class="tab-pane" id="ticket_attachments">
		<table class="table-striped align-left" width="100%">
			<thead>
				<tr class="row<?php echo $i % 2; ?>">
					<th>
						<?php echo JText::_('ATTACHMENT_NAME'); ?>
					</th>
					
					<th>
						<?php echo JText::_('CREATED'); ?>
					</th>
					
					<th>
						<?php echo JText::_('CREATED_BY'); ?>
					</th>
					<th>
						<?php echo JText::_('ACTIONS'); ?>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php  if($this->attach != null) {
						foreach ($this->attach as $i => $item) {?>
				<tr class="row<?php echo $i % 2; ?>">
					<td>
						<?php /*<a href='index.php?option=com_jsptickets&controller=ticketform&task=download&fullpath=<?php echo JURI::root(); ?>images/jsp_tickets/attachments/<?php echo $item->attachement_name; ?>' target="_blank" ><?php echo $item->attachement_name; ?></a>*/ ?>
						
						<?php
						$fullpath = JPATH_ROOT. "/images/jsp_tickets/attachments/".$item->attachement_name;
						$filename = $item->attachement_name;
						?>
						<a href='index.php?option=com_jsptickets&controller=ticketform&task=download&fullpath=<?php echo $fullpath; ?>&filename=<?php echo $filename; ?>' ><?php echo $item->attachement_name; ?></a> 
						
					</td>
					<td>
						<?php echo $item->created; ?>
					</td>
					<td>
						<?php if($item->created_by == 0){
						echo $this->ticketguestname." (".JText::_("GUEST_USER").")";
					} else {
						echo $this->getUserById($item->created_by); } ?>
					</td>
					<td>
						<?php $aid = $item->id;
							$user = JFactory::getUser();
							if($currentUsersGrp == "Super Users" || $currentUsersGrp == "Administrator" || $user->id == $item->created_by)
							  { ?>
								<a class="view_log_btn" href="index.php?option=com_jsptickets&controller=ticketform&task=attachdelete&attachid=<?php echo $aid;?>&ticketcode=<?php echo $this->ticketcode;?>" ><?php echo JText::_('BTN_DELETE');?></a>
						<?php } else {
								echo '<h6>'.JText::_("NO_ACTIONS").'</h6>';
							  }?>
					</td>
				</tr>
				<?php }} else { echo '<tr><td colspan="4"><center><h5>'. JText::_('NO_ATTACHMENT_IN_TICKET') .'</h5></center></td></tr>'; }?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4">
						<?php echo $this->attachmentpagination->getPagesLinks(); ?>
					</td>
				</tr>
			</tfoot>
		</table>
</div>
<?php
	//echo $this->pane->endPanel();
	}
	
	if($this->ticketid != 0)
	{
		//echo $this->pane->startPanel(JText::_('FEEDBACKS'), 'feedbacks');
?>
<div class="tab-pane" id="ticket_feedbacks">
		<table class="adminlist table-striped align-left" width="100%">
			<thead>
				<tr class="row<?php echo $i % 2; ?>">
					<th>
						<?php echo JText::_('RATING'); ?>
					</th>
					
					<th width="300px">
						<?php echo JText::_('FEEDBACKS'); ?>
					</th>
					
					<th>
						<?php echo JText::_('CREATED'); ?>
					</th>
					
					<th>
						<?php echo JText::_('CREATED_BY'); ?>
					</th>
					
					<th width="80px">
						<?php echo JText::_('ACTIONS'); ?>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php  if($this->feed != null) {
						foreach ($this->feed as $i => $item) {?>
				<tr class="row<?php echo $i % 2; ?>">
					<td>
						<?php echo $this->getRatingById($item->rating); ?>
					</td>
					
					<td width="300px">
						<?php echo html_entity_decode($item->feedbacks); ?>
					</td>
					
					<td>
						<?php echo $item->created; ?>
					</td>
					
					<td>
						<?php if($item->created_by == 0){
								echo $this->ticketguestname." (".JText::_("GUEST_USER").")";
							} else {
								echo $this->getUserById($item->created_by); } ?>
					</td>
					
					<td width="80px">
						<?php $fid = $item->id;
							$user = JFactory::getUser();
							if($currentUsersGrp == "Super Users" || $currentUsersGrp == "Administrator" || $user->id == $item->created_by)
							  { ?>
								<a class="view_log_btn" href="index.php?option=com_jsptickets&controller=ticketlist&task=edit&ticketcode=<?php echo $this->ticketcode;?>&editfeedbackid=<?php echo $fid;?>" ><?php echo JText::_('BTN_EDIT');?></a>
								<a class="view_log_btn" href="index.php?option=com_jsptickets&controller=ticketform&task=feedbackdelete&feedid=<?php echo $fid;?>&ticketcode=<?php echo $this->ticketcode;?>" ><?php echo JText::_('BTN_DELETE');?></a>
						<?php } else {
								echo '<h6>'.JText::_("NO_ACTIONS").'</h6>';
							  }?>
					</td>
				</tr>
				<?php }?>
				
				<tr>
					<td colspan="5">
						<?php echo $this->feedbackpagination->getPagesLinks(); ?>
					</td>
				</tr>
				<?php } else { echo '<tr><td colspan="5"><center><h5>'. JText::_('NO_FEEDBACK_IN_TICKET') .'</h5></center></td></tr>'; } ?>
				<tr>
					<td>
						<?php echo $this->form->getLabel('ratings'); ?>
					</td>
					<td colspan="4">
						<?php
						if(isset($this->feededit[0]->rating))
						{
							$rating = $this->feededit[0]->rating;
						}	else	{
							$rating = 3;
						}
						echo $this->form->getInput('ratings', null , $rating); ?>		
					</td>
				</tr>
				
				<tr>
					<td>
						<label id="feedback-lbl" class="hasTooltip required" title="" for="feedback" aria-invalid="false">
						<?php echo JHTML::tooltip(JText::_('TICKET_FEEDBACK_DESC'), JText::_('TICKET_FEEDBACK_LABEL'), '', JText::_('TICKET_FEEDBACK_LABEL'));?>
						</label>
					</td>
					<td colspan="4">
						<?php //JFactory::getEditor()->display($name, $html, $width, $height, $col, $row, $buttons=true, $id=null, $params=array())
						if(isset($this->feededit[0]->feedbacks))
						{
							$feedback = $this->feededit[0]->feedbacks;
						}	else	{
							$feedback = '';
						}
						echo JFactory::getEditor()->display('feedback', $feedback ,'350','250','40','6',array('pagebreak', 'readmore', 'image', 'article')); ?>	
					</td>
				</tr>
			</tbody>
		</table>
</div>

<?php
	//echo $this->pane->endPanel();
	//echo $this->pane->startPanel(JText::_('LOG'), 'Log');
?>

<div class="tab-pane" id="ticket_log">
<table class="table-striped ticket-table align-left" width="100%">
	<thead>
		<tr class="row<?php echo $i % 2; ?>">
			<th>
				<?php echo JText::_('NARRATION'); ?>
			</th>
			
			<th>
				<?php echo JText::_('CREATED'); ?>
			</th>
		</tr>
	</thead>
	<tbody>	
		<?php  if(isset($this->log) and $this->log != null) {
				foreach ($this->log as $i => $item) {?>
		<tr class="row<?php echo $i % 2; ?>">
			<td>
				<?php echo $item->narration; ?>
			</td>
			<td>
				<?php echo $item->created; ?>
			</td>
		</tr>
		<?php }} else { echo '<tr><td colspan="5"><center><h5>'. JText::_('NO_TICKET_HISTORY') .'</h5></center></td></tr>'; }?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2">
						<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
</table>
</div>
<?php
	//echo $this->pane->endPanel();
	}
	//echo $this->pane->endPane();
?>

</div> <!-- content-tab div ends here -->

<div>
<input type="hidden" name="twitter_username" value= '<?php echo $this->tickettwitter_username; ?>' />
<input type="hidden" name="ticketcode" value= '<?php echo $this->ticketcode; ?>' />
<input type="hidden" name="created" value= '<?php echo $this->ticketcreated;?>' />
<input type="hidden" name="created_by" value= '<?php echo $this->ticketcreated_by;?>' />

<!-- For checking if any feedback or comment is opened for update or not -->
<input type="hidden" name="edit_feedbackid" value= '<?php echo isset($this->editfeedbackid)? $this->editfeedbackid : '';?>' />
<input type="hidden" name="edit_commentid" value= '<?php echo isset($this->editcommentid)? $this->editcommentid : '';?>' />

<!-- For checking if assignee or status of any ticket is changed or not -->
<input type="hidden" name="post_assigned_to" value= '<?php echo $this->ticketassigned_to;?>' />
<input type="hidden" name="post_status" value= '<?php echo $this->ticketstatus_id;?>' />

<input type="hidden" name="option" value="com_jsptickets" />
<input type="hidden" name="controller" value="ticketlist" />
<input type="hidden" name="task" value="edit" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHtml::_('form.token'); ?>
</div>
</form>
<!--<script type="text/javascript">showCategoriesAdmin(document.getElementById('jform_category_extension').value);</script>-->