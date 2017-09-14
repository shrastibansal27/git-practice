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
jimport( 'joomla.user.user' ); // for retrieving users info
jimport( 'joomla.access.access' );
JHTML::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
$document = JFactory::getDocument();
$document->addScript(JURI::base()."components/com_jsptickets/js/tickets.js");
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/style.css" />');

$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/bootstrap.css" />');
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/bootstrap.min.css" />');
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/bootstrap-responsive.css" />');
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/bootstrap-responsive.min.css" />');

$model = $this->getModel( 'tickets' );
$session = JFactory::getSession();
$mainframe =  JFactory::GetApplication();
$user = JFactory::getUser();
$post = JRequest::get('post');

JSite::getMenu()->setActive($this->ItemId);

if(!$user->guest) // check if a user is registered user or a guest
{
	$currentUsersGrp = $model->getUserGroupByUid($user->id);
	$guestname = "";
	$guestemail = "";
	$ticketid = "";
	
} else {
	$currentUsersGrp = "Guest";
	$guestname = $this->ticketguestname;
	$guestemail = $this->ticketguestemail;
	$ticketid = $this->ticketguestticketid;
	
}

$checkempty = $model->getCheckEmptyList( $guestname, $guestemail, $ticketid );

if($user->id == 0 && $guestname == "" && $guestemail == "") // no guest user without guestname n email can be entered.
{
	$mainframe->redirect(JRoute::_("index.php?option=com_jsptickets&view=jsptickets&Itemid=".$this->ItemId), "");
}

$Bool_Val = $this->Throw_Error($this->ticketid, $checkempty);

if($Bool_Val == 1 && $this->ticketid != "")  // Don't throw error until the new ticket form is opened cause in that case ticketid be "null"
{
	$mainframe->redirect(JRoute::_("index.php?option=com_jsptickets&view=jsptickets&Itemid=".$this->ItemId), JText::_("NO_TICKETS_MSG"), "MESSAGE");
}

if($user->id != 0 && $session->get( 'guestemail') != "" && $session->get( 'guestname') != "" )  //if registered user comes in and guest user details are still set
{
	$session->set( 'guestname', '' );
	$session->set( 'guestemail', '' );
	$mainframe->redirect(JRoute::_("index.php?option=com_jsptickets&view=jsptickets&Itemid=".$this->ItemId), "");
}

$action = "index.php?option=com_jsptickets&view=tickets&controller=ticketlist&task=edit&ticketcode=".$this->ticketcode ."&Itemid=".$this->ItemId;
	
$i = 2;
$load_jquery = $this->config[0]->load_jquery;
	if($load_jquery==2) //in "Auto" mode
	{
?>
	<script type="text/javascript">
		if (typeof jQuery==="undefined") {
		<?php $document->addScript(JURI::base()."administrator/components/com_jsptickets/js/jquery-1.10.1.min.js"); ?>
		}
	</script>
<?php
	} else if($load_jquery==1) //in "Yes" mode
	{
		$document->addScript(JURI::base()."administrator/components/com_jsptickets/js/jquery-1.10.1.min.js");
	}
$document->addScript(JURI::base()."components/com_jsptickets/js/jquery_cookie.js");
?>
<script language="javascript" type="text/javascript">
if (typeof jQuery==="undefined") {
	alert("<?php echo JText::_("JQUERY_LOAD_ERROR");?>");
} else {
	var $jq_jspticket = jQuery.noConflict();
}
$jq_jspticket(document).ready(function (){
	
	

	var titlevalue = document.getElementById('jform_title').value;
	
	if(titlevalue){
	
	$jq_jspticket("#jform_title").prop("readonly", true);
	$jq_jspticket("#jform_subject").prop("readonly", true);
	$jq_jspticket("#category_id").prop("readonly", true);
	
	
	// document.getElementById('jform_title').disabled = true;
	// document.getElementById('jform_subject').disabled = true;
	 document.getElementById('category_id').disabled = true;
	document.getElementById('descriptiondiv').disabled = true;
		
	}


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

function submitbutton() {
	var submitForm = document.adminForm;
	var vtitle = vsubject = true;
	var flag1 = flag2 = flag3 = flag4 = true;
	var editordesctext = true;
	
	if ( document.formvalidator.isValid( document.getElementById('adminForm')) )
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
					//submitForm.getElementById("category_id").className = "invalid";
					
					
					
					
					submitForm.getElementById("category_id").required = "true";
					flag1 = false;
					alert('<?php echo JTEXT::_("MANDATORY_FIELD_MISSING");?>');
					return false;
				}
			}
			if(submitForm.getElementById("jform_created_for") != null)
			{
				if(submitForm.getElementById("jform_created_for").value !=-1)
				{
					//if any option is selected
					flag2 = true;
				} else {
					submitForm.getElementById("jform_created_for").className = "required invalid";
					submitForm.getElementById("jform_created_for").required = "true";
					flag2 = false;
					alert('<?php echo JTEXT::_("MANDATORY_FIELD_MISSING");?>');
					return false;
				}
			}
			if(submitForm.getElementById("jform_assigned_to") != null)
			{
				if(submitForm.getElementById("jform_assigned_to").value !=-1)
				{
					//if any option is selected
					flag3 = true;
				} else {
					submitForm.getElementById("jform_assigned_to").className = "required invalid";
					submitForm.getElementById("jform_assigned_to").required = "true";
					flag3 = false;
					alert('<?php echo JTEXT::_("MANDATORY_FIELD_MISSING");?>');
					return false;
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
			
			if(vtitle == false || vsubject== false || flag1 == false || flag2 == false || flag3 == false || flag4 == false) // if any condition gets false
			{
				alert('<?php echo JTEXT::_("MANDATORY_FIELD_MISSING");?>');
				
				return false;
			} else {	// if all fields are valid including jform fields then submit the form
				submitForm.submit();
				return true;
			}
	} else {
		alert('<?php echo JTEXT::_("MANDATORY_FIELD_MISSING");?>');
		
		var cat = document.getElementById("category_id").value;
				
		//var selectedValue = cat.options[cat.selectedIndex].value;
			
		console.log(cat);
									
		if (cat == "")
		{
			$jq_jspticket("#category_id").removeClass("invalid");
		}
		
		
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
<style>
.nav-pills li a{display:block !important;}
 
</style>
<form name="adminForm" id="adminForm" method="post" action="<?php echo JRoute::_($action);?>" enctype="multipart/form-data"> <!--  onsubmit="return submitbutton();" -->

<div class="adminlist" style="width:100%">
<?php if($user->id == 0) { ?>
		<div> <?php echo '<b>'.JText::_('GREETINGS').$guestname.' !!!</b> '. JText::_('GUESTUSERTYPE'); ?> </div>
<?php } else { ?>
		<div> <?php echo '<b>'.JText::_('GREETINGS').JFactory::getUser($user->id)->name.' !!!</b> '. JText::_('REGISTEREDUSERTYPE'); ?> </div>
<?php } ?>
</div>
<br />

<ul class="nav nav-tabs">
  <li class="active"><a href="#ticket_form" data-toggle="tab" onclick='setTabCookie("ticket_form");'><?php echo JText::_('TICKET_FORM');?></a></li>
  <?php
 
   
   $tickcode = $_GET['ticketcode'];
   
  if($post['task'] == 'edit' || $tickcode != ""){
  ?>	
  <li><a href="#ticket_comments" data-toggle="tab" onclick='setTabCookie("ticket_comments");'><?php echo JText::_('COMMENTS');?></a></li>
  <?php
  }
  ?>
  
  
  <?php if($this->attach != null) { ?>
  <li><a href="#ticket_attachments" data-toggle="tab" onclick='setTabCookie("ticket_attachments");'><?php echo JText::_('ATTACHMENTS');?></a></li>
<?php } ?>
<?php if($this->ticketid != 0) { ?>
  <li><a href="#ticket_feedbacks" data-toggle="tab" onclick='setTabCookie("ticket_feedbacks");'><?php echo JText::_('FEEDBACKS');?></a></li>
  <li><a href="#ticket_log" data-toggle="tab" onclick='setTabCookie("ticket_log");'><?php echo JText::_('LOG');?></a></li>
<?php } ?>
</ul>

<div class="tab-content clearfix"> <!-- content-tab div starts here -->
<div class="tab-pane active" id="ticket_form">
<?php echo $this->form->getInput('id', null, $this->ticketid);?>
<fieldset class="adminform">
<!--Ticket Form-->
					<div class="page-header"></div>
					<br/>
					<div class="row-fluid">
					<label class="control-label span3" for=""><?php echo $this->form->getLabel('title'); ?></label>
					<div class="col-sm-10">
					<?php

					$tickettitle = ltrim($this->tickettitle);
					
					echo $this->form->getInput('title', null ,$tickettitle); ?>
					</div>
					</div>
				
					<div class="row-fluid">
					<label class="control-label span3" for=""><?php echo $this->form->getLabel('subject'); ?></label>
					<div class="col-sm-10">
					<?php
						$ticketsubject = ltrim($this->ticketsubject);

					echo $this->form->getInput('subject', null , $ticketsubject); ?>
					</div>
					</div>
				
				
				
			
						
			
		
		<?php if($this->config[0]->select_category == 1 || $currentUsersGrp == "Super Users" || $currentUsersGrp == "Administrator") { ?>   <!-- check whether the select category is allowed from back end or not -->
		
				
				<div class="row-fluid">
				<label id="category_id-lbl" class="control-label span3 required" title="" for="category_id" aria-invalid="false">
				<?php echo JHTML::tooltip(JText::_('TICKET_CATEGORY_DESC'), JText::_('TICKET_CATEGORY_LABEL'), '', JText::_('TICKET_CATEGORY_LABEL'));?>
				<span class="star">&nbsp;*</span>
				</label>
				<div class="col-sm-10">
				<?php echo $this->list['category'] ; ?>
				</div>
				</div>
				
			
			
		
		<?php
		}
		?>
					<div class="row-fluid">
					<label class="control-label span3" for=""><?php echo $this->form->getLabel('priority'); ?></label>
					<div class="col-sm-10">
					<?php echo $this->form->getInput('priority', null , $this->ticketpriority_id); ?>
					</div>
					</div>
		

		<?php 
		if($this->ticketid != 0 || $this->ticketid != '')
		{ 
		?>
		<div class="row-fluid">
					
		
				<label class="control-label span3" for=""><?php echo $this->form->getLabel('status'); ?></label>
				<div class="col-sm-10">
				<?php 
					if( $currentUsersGrp == "Super Users" || $currentUsersGrp == "Administrator" ) 
					{
						echo $this->form->getInput('status', null , $this->ticketstatus_id); 
					} else {
						if($this->ticketid != 0 || $this->ticketid != '')
						{
							echo $this->list['status'];
						}
					}?>		
				</div>
		</div>
		<?php
		} else {
			echo '<input type="hidden" id="jform_status" name="jform[status]" value="1"/>';
		}
		?>
		
		<?php if($this->config[0]->file_upload == 1 || $currentUsersGrp == "Super Users" || $currentUsersGrp == "Administrator") { ?>  <!-- check whether the file upload is allowed from back end or not -->   
		
					<div class="row-fluid">
					<label class="control-label span3" for=""><?php echo $this->form->getLabel('attachment'); ?></label>
					<div class="col-sm-10">
					<?php echo $this->form->getInput('attachment', null , ''); ?>	
					</div>
					</div>
		
		<?php } ?>
		
		<?php if($currentUsersGrp == "Super Users" || $currentUsersGrp == "Administrator"){ ?>
		
				
					<div class="row-fluid">
					<label class="control-label span3" for=""><?php echo $this->form->getLabel('created_for'); ?></label>
					<div class="col-sm-10">
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
					</div>
					</div>	
		
					<div class="row-fluid">
					<label class="control-label span3" for=""><?php echo $this->form->getLabel('assigned_to'); ?></label>
					<div class="col-sm-10">
					<?php echo $this->form->getInput('assigned_to', null , $this->ticketassigned_to); ?>	
					</div>
					</div>
				
			
				
			
		<?php } else { ?>
				<input type="hidden" name="created_for" value= '<?php echo $this->ticketcreated_for ;?>' />
				<input type="hidden" name="assigned_to" value= '<?php echo $this->ticketassigned_to ;?>' />
		<?php } ?>
	
		
				<div class="row-fluid">
				<label id="description-lbl" class="control-label span3 required" title="" for="description" aria-invalid="false">
				<?php echo JHTML::tooltip(JText::_('TICKET_DESCRIPTION_DESC'), JText::_('TICKET_DESCRIPTION_LABEL'), '', JText::_('TICKET_DESCRIPTION_LABEL'));?>
				<span class="star">&nbsp;*</span>
				</label>
					<div id="descriptiondiv">
					<div class="span9" style="margin-left:1px;height:30% !important;">
					<?php echo JFactory::getEditor()->display('description', $this->ticketdescription ,'85%','80','60','10',array('pagebreak', 'readmore', 'image', 'article')); ?>	
					</div>
					</div>
					</div>	
		<?php
		if($this->ticketid != 0)
		{
			if( ($this->ticketcreated_by == 0 || $this->ticketcreated_by == '') && ($this->ticketguestname) && ($this->ticketguestemail) ) {?>
				
				<div class="row-fluid">
				<label id="guestname_lbl" class="control-label span3" title="">
				<?php echo JHTML::tooltip(JText::_('TICKET_GUESTNAME_DESC'), JText::_('TICKET_GUESTNAME_LABEL'), '', JText::_('TICKET_GUESTNAME_LABEL'));?>
				<span class="star">&nbsp;*</span>
				</label>
				<div class="col-sm-10">
				<?php echo $this->ticketguestname; ?>
				</div>
				</div>	
		
				<div class="row-fluid">
				<label id="guestemail_lbl" class="control-label span3" title="">
				<?php echo JHTML::tooltip(JText::_('TICKET_GUESTEMAIL_DESC'), JText::_('TICKET_GUESTEMAIL_LABEL'), '', JText::_('TICKET_GUESTEMAIL_LABEL'));?>
				<span class="star">&nbsp;*</span>
				</label>
				<div class="col-sm-10">
				<?php echo $this->ticketguestemail; ?>
				</div>
				</div>	
				
		<?php } else {?>
				<div class="row-fluid">
				<label id="username_lbl" class="control-label span3" title="">
				<?php echo JHTML::tooltip(JText::_('TICKET_USERNAME_DESC'), JText::_('TICKET_USERNAME_LABEL'), '', JText::_('TICKET_USERNAME_LABEL'));?>
				<span class="star">&nbsp;*</span>
				</label>
				<div class="col-sm-10">
				<?php echo JFactory::getUser($this->ticketcreated_by)->name; ?>
				</div>
				</div>
				
				<div class="row-fluid">
				<label id="useremail_lbl" class="control-label span3" title="">
				<?php echo JHTML::tooltip(JText::_('TICKET_USEREMAIL_DESC'), JText::_('TICKET_USEREMAIL_LABEL'), '', JText::_('TICKET_USEREMAIL_LABEL'));?>
				<span class="star">&nbsp;*</span>
				</label>
				<div class="col-sm-10">
				<?php echo JFactory::getUser($this->ticketcreated_by)->email; ?>
				</div>
				</div>
			
		<?php } } ?>
	
<!--Ticket Form-->
</fieldset>
</div>

<div class="tab-pane" id="ticket_comments">
<!--Comments-->
<table class="table-bordered jsptickets_form_table align-left" cellpadding="0" cellspacing="0" border="0">
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
	</thead>
	<tbody>
		<tr>

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
						if($currentUsersGrp == "Super Users" || $currentUsersGrp == "Administrator" || $user->id == $item->created_by)
						{ if($user->id!=0){?>
								<a class="jsptickets_view_log_btn" href="<?php echo JRoute::_('index.php?option=com_jsptickets&view=tickets&controller=ticketlist&task=edit&ticketcode='.$this->ticketcode.'&editcommentid='.$coid.'&key=authorise&Itemid='.$this->ItemId);?>" ><?php echo JText::_('BTN_EDIT');?></a>
									<?php } else {?>
								<a class="jsptickets_view_log_btn" href="<?php echo JRoute::_('index.php?option=com_jsptickets&view=tickets&controller=ticketlist&task=edit&ticketcode='.$this->ticketcode.'&editcommentid='.$coid.'&Itemid='.$this->ItemId);?>" ><?php echo JText::_('BTN_EDIT');?></a>
									<?php } ?>
								<a class="jsptickets_view_log_btn" href="<?php echo JRoute::_('index.php?option=com_jsptickets&view=tickets&controller=ticketform&task=commentdelete&commentid='.$coid.'&ticketcode='.$this->ticketcode.'&Itemid='.$this->ItemId);?>" ><?php echo JText::_('BTN_DELETE');?></a>
					<?php } else {
							echo '<h6>'.JText::_("NO_ACTIONS").'</h6>';
						  }?>
				</td>
				<?php }} else { echo '<tr><td colspan="5"><center><h5>'. JText::_('NO_COMMENT_IN_TICKET') .'</h5></center></td></tr>'; }?>
						
		</tr>
		<tr>
			<td colspan="4">
				<?php echo $this->commentpagination->getPagesLinks(); ?>
			</td>
		</tr>
	</tbody>
</table>
<br />
<table class="adminlist table-bordered jsptickets_form_table align-left" cellpadding="0" cellspacing="0" border="0">
	<tbody>

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
				}if($this->tickettweet_id == '')
				{
				
					echo JFactory::getEditor()->display('comments', $comment ,'85%','90','60','10',array('pagebreak', 'readmore', 'image', 'article')); 	
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

</table>
<!--Comments-->
</div>
<?php
	if($this->attach != null) {	
?>
	<div class="tab-pane" id="ticket_attachments">
<!--Attachments-->
		<table class="table-bordered jsptickets_form_table align-left" style="width:100%">
			<thead>
				<?php if( !($this->config[0]->file_upload == 1 || $currentUsersGrp == "Super Users" || $currentUsersGrp == "Administrator") )  // check whether the file upload is allowed from back end or not 
					  {	?>
						<tr class="row<?php echo $i % 2; ?>"><?php echo '<center><h3>'.JText::_("AUTHORIZE_ATTACHMENTS_MSG").'</h3></center>';?></tr>
				<?php } ?>
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
						<?php
						$fullpath = JPATH_ROOT. "/images/jsp_tickets/attachments/".$item->attachement_name;
						$filename = $item->attachement_name;
						?>
						<a href="<?php echo JRoute::_('index.php?option=com_jsptickets&view=tickets&controller=ticketform&task=download&fullpath='.$fullpath.'&filename='.$filename); ?>" ><?php echo $item->attachement_name; ?></a> 
						
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
							if($currentUsersGrp == "Super Users" || $currentUsersGrp == "Administrator" || $user->id == $item->created_by)
							  { ?>
								<a class="jsptickets_view_log_btn" href="<?php echo JRoute::_('index.php?option=com_jsptickets&view=tickets&controller=ticketform&task=attachdelete&attachid='.$aid.'&ticketcode='.$this->ticketcode.'&Itemid='.$this->ItemId);?>" ><?php echo JText::_('BTN_DELETE');?></a>
						<?php } else {
								echo '<h6>'.JText::_("NO_ACTIONS").'</h6>';
							  }?>
					</td>
				</tr>
				<?php }} else { echo '<tr><td colspan="4"><center><h5>'. JText::_('NO_ATTACHMENT_IN_TICKET') .'</h5></center></td></tr>'; }?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2">
						<?php echo $this->attachmentpagination->getPagesLinks(); ?>
					</td>
				</tr>
			</tfoot>
		</table>
		<!--Attachments-->
	</div>
<?php
	}
	
	if($this->ticketid != 0)
	{
?>
	<div class="tab-pane" id="ticket_feedbacks">
<!--Feedbacks-->	
		<table class="table-bordered jsptickets_form_table align-left" style="width:100%">
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
							if($currentUsersGrp == "Super Users" || $currentUsersGrp == "Administrator" || $user->id == $item->created_by)
							  { if($user->id!=0){?>
									<a class="jsptickets_view_log_btn" href="<?php echo JRoute::_('index.php?option=com_jsptickets&view=tickets&controller=ticketlist&task=edit&ticketcode='.$this->ticketcode.'&editfeedbackid='.$fid.'&key=authorise&Itemid='.$this->ItemId);?>" ><?php echo JText::_('BTN_EDIT');?></a>
									<?php } else { ?>
									<a class="jsptickets_view_log_btn" href="<?php echo JRoute::_('index.php?option=com_jsptickets&view=tickets&controller=ticketlist&task=edit&ticketcode='.$this->ticketcode.'&editfeedbackid='.$fid.'&Itemid='.$this->ItemId);?>" ><?php echo JText::_('BTN_EDIT');?></a>
									<?php } ?>
									<a class="jsptickets_view_log_btn" href="<?php echo JRoute::_('index.php?option=com_jsptickets&view=tickets&controller=ticketform&task=feedbackdelete&feedid='.$fid.'&ticketcode='.$this->ticketcode.'&Itemid='.$this->ItemId);?>" ><?php echo JText::_('BTN_DELETE');?></a>
						<?php } else {
								echo '<h6>'.JText::_("NO_ACTIONS").'</h6>';
							  }?>
					</td>
				</tr>
				<?php }} else { echo '<tr><td colspan="5"><center><h5>'. JText::_('NO_FEEDBACK_IN_TICKET') .'</h5></center></td></tr>'; }?>
			
				<tr>
					<td colspan="5">
						<?php echo $this->feedbackpagination->getPagesLinks(); ?>
					</td>
				</tr>
			</tbody>
		</table>
		<br />
		<table class="adminlist table-bordered jsptickets_form_table align-left" style="width:100%">
			<tbody>
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
						
						
						
						echo JFactory::getEditor()->display('feedback', $feedback ,'85%','90','60','10',array('pagebreak', 'readmore', 'image', 'article')); ?>	
					</td>
				</tr>
			</tbody>
		</table>
		<!--Feedbacks-->	
	</div>

	<div class="tab-pane" id="ticket_log">
		<!--History-->	
		<table class="table-bordered jsptickets_form_table ticket-table align-left" style="width:100%">
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
						<?php echo $this->pagination->getPagesLinks(); ?>
					</td>
				</tr>
			</tfoot>
		</table>
		<!--History-->	
	</div>
<?php
	//echo $this->pane->endPanel();
	}
	//echo $this->pane->endPane();
?>
<div class="page-header"></div>
<table class="jsptickets_toolbar_grid form span3" style="width:24%;" cellpadding="0" cellspacing="0" border="0">
	<tbody>	
		<tr>
			
				<td><input style="" class="btn btn-success" type="button" name="save" value="Save" onclick ="return Save()"></input></td>	
				
				<?php if($checkempty != "") // if there is no ticket for the user then redirect him directly to default ticket form
					{ ?>
					<td> &nbsp;<input class="btn btn-danger" type="button" name="cancel" value="Cancel" onclick ="return FormClose()"></input></td>
				<?php } else {?>
					<td> &nbsp;<input class="btn btn-danger" type="button" name="cancel" value="Cancel" onclick ="return ListClose()"></input></td>
				<?php } ?>
		</tr>					
	</tbody>
</table>

</div> <!-- content-tab div ends here -->

<div>
<input type="hidden" name="twitter_username" value= '<?php echo $this->tickettwitter_username; ?>' />
<input type="hidden" name="ticketcode" value= '<?php echo $this->ticketcode; ?>' />
<input type="hidden" name="created" value= '<?php echo $this->ticketcreated;?>' />
<input type="hidden" name="created_by" value= '<?php echo $this->ticketcreated_by;?>' />

<!-- For checking if the Guest User Name if present or not -->
<input type="hidden" name="guestname" value= '<?php echo isset($guestname)? $guestname : '';?>' />
<input type="hidden" name="guestemail" value= '<?php echo isset($guestemail)? $guestemail : '';?>' />

<!-- For checking if any feedback or comment is opened for update or not -->
<input type="hidden" name="edit_feedbackid" value= '<?php echo isset($this->editfeedbackid)? $this->editfeedbackid : '';?>' />
<input type="hidden" name="edit_commentid" value= '<?php echo isset($this->editcommentid)? $this->editcommentid : '';?>' />

<!-- For checking if assignee or status of any ticket is changed or not -->
<input type="hidden" name="post_assigned_to" value= '<?php echo $this->ticketassigned_to;?>' />
<input type="hidden" name="post_status" value= '<?php echo $this->ticketstatus_id;?>' />

<input type="hidden" name="Itemid" value="<?php echo $this->ItemId;?>" />
<input type="hidden" name="option" value="com_jsptickets" />
<input type="hidden" name="controller" value="ticketlist" />
<input type="hidden" name="task" value="edit" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHtml::_('form.token'); ?>
</div>
</form>
<!--<script type="text/javascript">showCategoriesAdmin(document.getElementById('jform_category_extension').value);</script>-->