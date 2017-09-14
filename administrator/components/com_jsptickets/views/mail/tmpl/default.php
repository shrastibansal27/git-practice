<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
JHTML::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHTML::_('behavior.modal');
$value=null;
$document = JFactory::getDocument();
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/style.css" />');
?>
<script language="javascript" type="text/javascript">
Joomla.submitbutton = function(pressbutton) {
	var submitForm = document.adminForm;
	
	if( pressbutton == 'cancel' || document.formvalidator.isValid(document.id('adminForm')) )
	{
		submitForm.task.value=pressbutton;
		submitForm.submit();
		return true;
	}
}

function showAdminEmailId( val )
{
	if( val == 1 ){
		document.getElementById("jform_admin_email_id-lbl").style.display="block";
		document.getElementById("jform_admin_email_id").style.display="block";
	} else {
		document.getElementById("jform_admin_email_id-lbl").style.display="none";
		document.getElementById("jform_admin_email_id").style.display="none";
	}
}
</script>
<form id="adminForm" name="adminForm" method="post" action="index.php?option=com_jsptickets&task=jsptickets" enctype="multipart/form-data" onsubmit="return submitbutton();">

<ul class="nav nav-tabs">
  <li class="active"><a href="#basic_settings" data-toggle="tab"><?php echo JText::_('BASIC_SETTINGS');?></a></li>
  <li><a href="#new_mail" data-toggle="tab"><?php echo JText::_('NEW_MAIL');?></a></li>
  <li><a href="#comment_mail" data-toggle="tab"><?php echo JText::_('COMMENT_MAIL');?></a></li>
  <li><a href="#assignee_changed_mail" data-toggle="tab"><?php echo JText::_('ASSIGNEE_CHANGED_MAIL');?></a></li>
</ul>

<div class="tab-content mail"> <!-- content-tab div starts here -->
<div class="tab-pane active" id="basic_settings">
<?php echo $this->form->getInput('id', null, $this->configid);?>
<fieldset class="adminform">
<?php
	// echo $this->pane->startPane('mail-pane');
	// echo $this->pane->startPanel(JText::_('BASIC_SETTINGS'), 'basic_settings');
 ?>
<table class="admintable" width="100%">
	<tbody>
		<tr>
			<td>
				<?php echo $this->form->getLabel('email_notification'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('email_notification', null , $this->configemail_notification); ?>
			</td>
		</tr>
		
		<tr>
			<td>
				<?php echo $this->form->getLabel('admin_email_id'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('admin_email_id', null , $this->configadmin_email_id); ?>
			</td>
		</tr>
	</tbody>
</table>
</fieldset>
</div>
<?php 
	//echo $this->pane->endPanel();
	//echo $this->pane->startPanel(JText::_('NEW_MAIL'), 'new_mail');
?>
<div class="tab-pane" id="new_mail">
<fieldset class="adminform">
<table class="admintable" width="100%">
	<tbody>
		<tr>
			<td>
				<?php echo $this->form->getLabel('new_mail_subject'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('new_mail_subject', null , $this->confignew_mail_subject); ?>
			</td>
		</tr>
		
		<tr>
			<td>
				<?php echo $this->form->getLabel('new_mail_body'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('new_mail_body', null , $this->confignew_mail_body); ?>
			</td>
		</tr>
	</tbody>
</table>
</fieldset>
</div>
<?php
	//echo $this->pane->endPanel();
	//echo $this->pane->startPanel(JText::_('COMMENT_MAIL'), 'comment_mail');
?>
<div class="tab-pane" id="comment_mail">
<fieldset class="adminform">
<table class="admintable" width="100%">
	<tbody>
		<tr>
			<td>
				<?php echo $this->form->getLabel('comment_mail_subject'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('comment_mail_subject', null , $this->configcomment_mail_subject); ?>
			</td>
		</tr>
		
		<tr>
			<td>
				<?php echo $this->form->getLabel('comment_mail_body'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('comment_mail_body', null , $this->configcomment_mail_body); ?>
			</td>
		</tr>
	</tbody>
</table>
</fieldset>
</div>
<?php
	//echo $this->pane->endPanel();
	//echo $this->pane->startPanel(JText::_('ASSIGNEE_CHANGED_MAIL'), 'assignee_changed_mail');
?>
<div class="tab-pane" id="assignee_changed_mail">
<fieldset class="adminform">
<table class="admintable" width="100%">
	<tbody>
		<tr>
			<td>
				<?php echo $this->form->getLabel('assignee_changed_mail_subject'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('assignee_changed_mail_subject', null , $this->configassignee_changed_mail_subject); ?>
			</td>
		</tr>
		
		<tr>
			<td>
				<?php echo $this->form->getLabel('assignee_changed_mail_body'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('assignee_changed_mail_body', null , $this->configassignee_changed_mail_body); ?>
			</td>
		</tr>
	</tbody>
</table>
<?php
	//echo $this->pane->endPanel();
	//echo $this->pane->endPane();
?>
</fieldset>
</div>

</div> <!-- content-tab div ends here -->

<div>
<input type="hidden" name="option" value="com_jsptickets" />
<input type="hidden" name="controller" value="mail" />
<input type="hidden" name="task" value="mail" />
<?php echo JHtml::_('form.token'); ?>
</div>
</form>

<script type="text/javascript">
 showAdminEmailId(document.getElementById('jform_email_notification').value);
</script>