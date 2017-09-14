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
var $jq_jspticket = jQuery.noConflict();
Joomla.submitbutton = function(pressbutton) {
	var submitForm = document.adminForm;
	var flag1=flag2=flag3=false;
	var msg_str='';
	
	if( pressbutton == 'cancel' )
	{
		submitForm.task.value=pressbutton;
		submitForm.submit();
		return true;
	}
	
	if ( document.formvalidator.isValid(document.id('adminForm')) )
	{
		if(document.getElementById("jform_gen_fb_tickets").value == 1)
		{
			if(submitForm.getElementById("jform_fb_app_id").value == null || submitForm.getElementById("jform_fb_app_id").value == "")
			{
				submitForm.getElementById("jform_fb_app_id-lbl").className = "hasToolTip invalid";
				submitForm.getElementById("jform_fb_app_id").className = "required invalid";
				submitForm.getElementById("jform_fb_app_id").required = "true";
				return false;
			}
			if(submitForm.getElementById("jform_fb_app_secret").value == null || submitForm.getElementById("jform_fb_app_secret").value == "")
			{
				submitForm.getElementById("jform_fb_app_secret-lbl").className = "hasToolTip invalid";
				submitForm.getElementById("jform_fb_app_secret").className = "required invalid";
				submitForm.getElementById("jform_fb_app_secret").required = "true";
				return false;
			}
		}
		if(document.getElementById("jform_gen_twitter_tickets").value == 1)
		{
			if(submitForm.getElementById("jform_custom_twitter_consumerkey").value == null || submitForm.getElementById("jform_custom_twitter_consumerkey").value == "")
			{
				submitForm.getElementById("jform_custom_twitter_consumerkey-lbl").className = "hasToolTip invalid";
				submitForm.getElementById("jform_custom_twitter_consumerkey").className = "required invalid";
				submitForm.getElementById("jform_custom_twitter_consumerkey").required = "true";
				return false;
			}
			if(submitForm.getElementById("jform_custom_twitter_consumersecret").value == null || submitForm.getElementById("jform_custom_twitter_consumersecret").value == "")
			{
				submitForm.getElementById("jform_custom_twitter_consumersecret-lbl").className = "hasToolTip invalid";
				submitForm.getElementById("jform_custom_twitter_consumersecret").className = "required invalid";
				submitForm.getElementById("jform_custom_twitter_consumersecret").required = "true";
				return false;
			}
			if(submitForm.getElementById("jform_custom_twitter_accesstoken").value == null || submitForm.getElementById("jform_custom_twitter_accesstoken").value == "")
			{
				submitForm.getElementById("jform_custom_twitter_accesstoken-lbl").className = "hasToolTip invalid";
				submitForm.getElementById("jform_custom_twitter_accesstoken").className = "required invalid";
				submitForm.getElementById("jform_custom_twitter_accesstoken").required = "true";
				return false;
			}
			if(submitForm.getElementById("jform_custom_twitter_accesstoken_secret").value == null || submitForm.getElementById("jform_custom_twitter_accesstoken_secret").value == "")
			{
				submitForm.getElementById("jform_custom_twitter_accesstoken_secret-lbl").className = "hasToolTip invalid";
				submitForm.getElementById("jform_custom_twitter_accesstoken_secret").className = "required invalid";
				submitForm.getElementById("jform_custom_twitter_accesstoken_secret").required = "true";
				return false;
			}
		}
		
		allow_cat=submitForm.getElementById("jform_select_category");
		op_acc=submitForm.getElementById("jformfilter_option_access");
			
		cat_ext=submitForm.getElementById("jform_category_extension");
		stat=submitForm.getElementById("jform_status");
		var c_op_acc=c_cat_ext=c_stat=0;
		
		op_len=op_acc.options.length;
		cat_len=cat_ext.options.length;
		stat_len=stat.options.length;
		
		for(i=0;i<op_len;i++)
		{
			if(op_acc.options[i].selected)
			{
				c_op_acc++;
			}
		}
		
		for(i=0;i<cat_len;i++)
		{
			if(cat_ext.options[i].selected)
			{
				c_cat_ext++;
			}
		}
		
		for(i=0;i<stat_len;i++)
		{
			if(stat.options[i].selected)
			{
				c_stat++;
			}
		}
		
		if(c_op_acc==0)
		{
			submitForm.getElementById("jform_filter_option_access-lbl").className = "hasToolTip invalid";
			submitForm.getElementById("jformfilter_option_access").className = "required invalid";
			submitForm.getElementById("jformfilter_option_access").required = "true";
			msg_str+='<div><p>Invalid field: <?php echo JText::_("CONFIG_FILTER_OPTION_ACCESS_LABEL");?></p></div>';
		} else {
			flag1=true;
		}
		
		if(allow_cat.options[allow_cat.selectedIndex].value==1 && c_cat_ext==0)
		{
			submitForm.getElementById("jform_category_extension-lbl").className = "hasToolTip invalid";
			submitForm.getElementById("jform_category_extension").className = "required invalid";
			submitForm.getElementById("jform_category_extension").required = "true";
			msg_str+='<div><p>Invalid field: <?php echo JText::_("TICKET_CATEGORY_EXTENSION_LABEL");?></p></div>';
		} else {
			flag2=true;
		}
		
		if(c_stat==0)
		{
			submitForm.getElementById("jform_status-lbl").className = "hasToolTip invalid";
			submitForm.getElementById("jform_status").className = "required invalid";
			submitForm.getElementById("jform_status").required = "true";
			msg_str+='<div><p>Invalid field: <?php echo JText::_("CONFIG_TICKET_STATUS");?></p></div>';
		} else {
			flag3=true;
		}
		
		if(flag1==true && flag2==true && flag3==true)
		{
			submitForm.task.value=pressbutton;
			submitForm.submit();
			return true;
		} else {
			alert('<?php echo JTEXT::_("MANDATORY_FIELD_MISSING");?>');
			if($jq_jspticket("div #system-message").length)
			{
				$jq_jspticket("div #system-message").append(msg_str);
			} else if($jq_jspticket("div #system-message-container").length) {
				$jq_jspticket("div #system-message-container").append('<div id="system-message" class="alert alert-error"><h4 class="alert-heading"></h4><div></div></div>');
				$jq_jspticket("div #system-message").append(msg_str);
			}
			return false;
		}
	} else {
		if($jq_jspticket('#jformfilter_option_access').hasClass('invalid')){
			$jq_jspticket("#system-message").append('<div><p>Invalid field: <?php echo JText::_("CONFIG_FILTER_OPTION_ACCESS_LABEL");?></p></div>');
		}
		return false;
	}
}

function selectText(containerid) 
{
	if (document.selection) {
		var range = document.adminForm.createTextRange();
		range.moveToElementText(document.getElementById(containerid));
		range.select();
	} else if (window.getSelection) {
		var range = document.createRange();
		range.selectNode(document.getElementById(containerid));
		window.getSelection().addRange(range);
	}
}

function showfiletype( val )
{
	if( val == 1 ){
		document.getElementById("jform_file_types-lbl").style.display="block";
		document.getElementById("jform_file_types").style.display="block";
	} else {
		document.getElementById("jform_file_types-lbl").style.display="none";
		document.getElementById("jform_file_types").style.display="none";
	}
}

function showcategory( val )
{
	if( val == 1 ){
		document.getElementById("jform_category_extension-lbl").style.display="block";
		document.getElementById("jform_category_extension").style.display="block";
	} else {
		document.getElementById("jform_category_extension-lbl").style.display="none";
		document.getElementById("jform_category_extension").style.display="none";
	}
}

function showfbgen( val )
{
	if( val == 1 ){
		document.getElementById("jform_fb_app_id-lbl").style.display="block";
		document.getElementById("jform_fb_app_id").style.display="block";
		document.getElementById("jform_fb_app_secret-lbl").style.display="block";
		document.getElementById("jform_fb_app_secret").style.display="block";
		document.getElementById("jform_fb_page_url-lbl").style.display="block";
		document.getElementById("jform_fb_page_url").style.display="block";
		document.getElementById("jform_fb_filter_words-lbl").style.display="block";
		document.getElementById("jform_fb_filter_words").style.display="block";
		document.getElementById("jform_fb_send_mail-lbl").style.display="block";
		document.getElementById("jform_fb_send_mail").style.display="block";
		document.getElementById("jform_fb_ticket_title-lbl").style.display="block";
		document.getElementById("jform_fb_ticket_title").style.display="block";
		document.getElementById("jform_fb_ticket_subject-lbl").style.display="block";
		document.getElementById("jform_fb_ticket_subject").style.display="block";
	} else {
		document.getElementById("jform_fb_app_id-lbl").className = "hasToolTip";
		document.getElementById("jform_fb_app_id").className = "";
		document.getElementById("jform_fb_app_id").required = "false";
		document.getElementById("jform_fb_app_secret-lbl").className = "hasToolTip";
		document.getElementById("jform_fb_app_secret").className = "";
		document.getElementById("jform_fb_app_secret").required = "false";
		
		document.getElementById("jform_fb_app_id-lbl").style.display="none";
		document.getElementById("jform_fb_app_id").style.display="none";
		document.getElementById("jform_fb_app_secret-lbl").style.display="none";
		document.getElementById("jform_fb_app_secret").style.display="none";
		document.getElementById("jform_fb_page_url-lbl").style.display="none";
		document.getElementById("jform_fb_page_url").style.display="none";
		document.getElementById("jform_fb_filter_words-lbl").style.display="none";
		document.getElementById("jform_fb_filter_words").style.display="none";
		document.getElementById("jform_fb_send_mail-lbl").style.display="none";
		document.getElementById("jform_fb_send_mail").style.display="none";
		document.getElementById("jform_fb_ticket_title-lbl").style.display="none";
		document.getElementById("jform_fb_ticket_title").style.display="none";
		document.getElementById("jform_fb_ticket_subject-lbl").style.display="none";
		document.getElementById("jform_fb_ticket_subject").style.display="none";
	}
}

function showtwittergen( val )
{
	var submitForm = document.adminForm;
	if( val == 1 ){
		
		document.getElementById("jform_custom_twitter_consumerkey-lbl").style.display="block";
		document.getElementById("jform_custom_twitter_consumerkey").style.display="block";
		document.getElementById("jform_custom_twitter_consumersecret-lbl").style.display="block";
		document.getElementById("jform_custom_twitter_consumersecret").style.display="block";
		document.getElementById("jform_custom_twitter_accesstoken-lbl").style.display="block";
		document.getElementById("jform_custom_twitter_accesstoken").style.display="block";
		document.getElementById("jform_custom_twitter_accesstoken_secret-lbl").style.display="block";
		document.getElementById("jform_custom_twitter_accesstoken_secret").style.display="block";
		
		document.getElementById("jform_twitter_screenname-lbl").style.display="block";
		document.getElementById("jform_twitter_screenname").style.display="block";
		document.getElementById("jform_twitter_filter_words-lbl").style.display="block";
		document.getElementById("jform_twitter_filter_words").style.display="block";
		document.getElementById("jform_twitter_send_mail-lbl").style.display="block";
		document.getElementById("jform_twitter_send_mail").style.display="block";
		document.getElementById("jform_twitter_ticket_title-lbl").style.display="block";
		document.getElementById("jform_twitter_ticket_title").style.display="block";
		document.getElementById("jform_twitter_ticket_subject-lbl").style.display="block";
		document.getElementById("jform_twitter_ticket_subject").style.display="block";
	} else {
		document.getElementById("jform_custom_twitter_consumerkey-lbl").className = "hasToolTip";
		document.getElementById("jform_custom_twitter_consumerkey").className = "";
		document.getElementById("jform_custom_twitter_consumerkey").required = "false";
		document.getElementById("jform_custom_twitter_consumersecret-lbl").className = "hasToolTip";
		document.getElementById("jform_custom_twitter_consumersecret").className = "";
		document.getElementById("jform_custom_twitter_consumersecret").required = "false";
		document.getElementById("jform_custom_twitter_accesstoken-lbl").className = "hasTip";
		document.getElementById("jform_custom_twitter_accesstoken").className = "";
		document.getElementById("jform_custom_twitter_accesstoken").required = "false";
		document.getElementById("jform_custom_twitter_accesstoken_secret-lbl").className = "hasToolTip";
		document.getElementById("jform_custom_twitter_accesstoken_secret").className = "";
		document.getElementById("jform_custom_twitter_accesstoken_secret").required = "false";
		
		if(document.getElementById("jform_custom_twitter_consumerkey") != null)
		{
			document.getElementById("jform_custom_twitter_consumerkey-lbl").style.display="none";
			document.getElementById("jform_custom_twitter_consumerkey").style.display="none";
		}
		if(document.getElementById("jform_custom_twitter_consumersecret") != null)
		{
			document.getElementById("jform_custom_twitter_consumersecret-lbl").style.display="none";
			document.getElementById("jform_custom_twitter_consumersecret").style.display="none";
		}
		if(document.getElementById("jform_custom_twitter_accesstoken") != null)
		{
			document.getElementById("jform_custom_twitter_accesstoken-lbl").style.display="none";
			document.getElementById("jform_custom_twitter_accesstoken").style.display="none";
		}
		if(document.getElementById("jform_custom_twitter_accesstoken_secret") != null)
		{
			document.getElementById("jform_custom_twitter_accesstoken_secret-lbl").style.display="none";
			document.getElementById("jform_custom_twitter_accesstoken_secret").style.display="none";
		}
		document.getElementById("jform_twitter_screenname-lbl").style.display="none";
		document.getElementById("jform_twitter_screenname").style.display="none";
		document.getElementById("jform_twitter_filter_words-lbl").style.display="none";
		document.getElementById("jform_twitter_filter_words").style.display="none";
		document.getElementById("jform_twitter_send_mail-lbl").style.display="none";
		document.getElementById("jform_twitter_send_mail").style.display="none";
		document.getElementById("jform_twitter_ticket_title-lbl").style.display="none";
		document.getElementById("jform_twitter_ticket_title").style.display="none";
		document.getElementById("jform_twitter_ticket_subject-lbl").style.display="none";
		document.getElementById("jform_twitter_ticket_subject").style.display="none";
	}
}
</script>
<form id="adminForm" name="adminForm" method="post" action="index.php?option=com_jsptickets&task=jsptickets" enctype="multipart/form-data" onsubmit="return submitbutton();">

<ul class="nav nav-tabs">
  <li class="active"><a href="#basic" data-toggle="tab"><?php echo JText::_('BASIC_SETTINGS');?></a></li>
  <li><a href="#facebook" data-toggle="tab"><?php echo JText::_('FACEBOOK_TICKETS');?></a></li>
  <li><a href="#twitter" data-toggle="tab"><?php echo JText::_('TWITTER_TICKETS');?></a></li>
  <li><a href="#category" data-toggle="tab"><?php echo JText::_('CATEGORY');?></a></li>
  <li><a href="#config_status" data-toggle="tab"><?php echo JText::_('STATUS');?></a></li>
  <li><a href="#message_settings" data-toggle="tab"><?php echo JText::_('MESSAGE_SETTINGS');?></a></li>
</ul>

<div class="tab-content configuration"> <!-- content-tab div starts here -->
	<div class="tab-pane active" id="basic">
	<fieldset class="adminform">
	<?php echo $this->form->getInput('id', null, $this->configid);?>
	
	<table class="admintable" width="100%">
	<tbody>		
			<tr>
				<td>
					<?php echo $this->form->getLabel('file_upload'); ?>
				</td>
				<td>
					<?php echo $this->form->getInput('file_upload', null , $this->configfile_upload); ?>
				</td>
			</tr>
			
			<tr>
				<td>
					<?php echo $this->form->getLabel('file_types'); ?>
				</td>
				<td>
					<?php echo $this->form->getInput('file_types', null , $this->configfile_types); ?>
				</td>
			</tr>
		
		<tr>
			<td>
				<?php echo $this->form->getLabel('load_jquery'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('load_jquery', null , $this->configload_jquery); ?>
			</td>
		</tr>
			
			<tr>
				<td>
					<?php echo $this->form->getLabel('access_control'); ?>
				</td>
				<td>
					<?php echo $this->form->getInput('access_control', null , $this->configaccess_control); ?>
				</td>
			</tr>
			
			<tr>
				<td>
					<?php echo $this->form->getLabel('filter_option_access'); ?>
				</td>
				<td>
					<?php echo $this->form->getInput('filter_option_access', null, $this->configfilter_option_access);?>
				</td>
			</tr>
			
			<tr>
				<td>
					<?php echo $this->form->getLabel('socialticket_gen_timeinterval'); ?>
				</td>
				<td>
					<?php echo $this->form->getInput('socialticket_gen_timeinterval', null , $this->configsocialticket_gen_timeinterval); ?>
				</td>
			</tr>
			
			<tr>
				<td>
					<?php echo $this->form->getLabel('cronjob_link'); ?>
				</td>
				<td>
					<?php echo '<div id="cronjob" onclick="return selectText(\'cronjob\');" title="Click and press CTRL+C to copy..." >'.JURI::root().'index.php?option=com_jsptickets&view=jsptickets&task=gensocialtickets'.'</div>'?>
				</td>
			</tr>
	</tbody>
	</table>
	</fieldset>
	</div>

	<div class="tab-pane" id="facebook">
	
	<table class="admintable" width="100%">
	<tbody>
		<tr>
			<td>
				<?php echo $this->form->getLabel('gen_fb_tickets'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('gen_fb_tickets', null , $this->configgen_fb_tickets); ?>
				<span class="editlinktip hasTip" title='<?php echo JTEXT::_("CONFIG_FB_INFO");?>'>
				<img border="0" src="templates/hathor/images/menu/icon-16-info.png"/>
				</span>
				<?php echo '<a href="https://www.facebook.com/legal/terms" target="_blank">'.JText::_("LEGAL_INFO").'</a>'." ".'<a href="https://developers.facebook.com/docs/opengraph/getting-started/#create-app" target="_blank">'.JText::_("FB_APP_CREATION").'</a>';?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->form->getLabel('fb_app_id'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('fb_app_id', null , $this->configfb_app_id); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->form->getLabel('fb_app_secret'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('fb_app_secret', null , $this->configfb_app_secret); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->form->getLabel('fb_page_url'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('fb_page_url', null , $this->configfb_page_url); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->form->getLabel('fb_filter_words'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('fb_filter_words', null , $this->configfb_filter_words); ?>
			</td>
		</tr>
		
		<tr>
			<td>
				<?php echo $this->form->getLabel('fb_send_mail'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('fb_send_mail', null , $this->configfb_send_mail); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->form->getLabel('fb_ticket_title'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('fb_ticket_title', null , $this->configfb_ticket_title); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->form->getLabel('fb_ticket_subject'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('fb_ticket_subject', null , $this->configfb_ticket_subject); ?>
			</td>
		</tr>
	</tbody>
	</table>
	</div>

	
	<div class="tab-pane" id="twitter">
	<table class="admintable" width="100%">
	<tbody>
		<tr>
			<td>
				<?php echo $this->form->getLabel('gen_twitter_tickets'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('gen_twitter_tickets', null , $this->configgen_twitter_tickets); ?>
					<span class="editlinktip hasTip" title='<?php echo JTEXT::_("CONFIG_TWITTER_INFO");?>'>
						<img border="0" src="templates/hathor/images/menu/icon-16-info.png"/>
					</span>
				<?php echo '<a href="https://support.twitter.com/articles/18311-the-twitter-rules#" target="_blank">'.JText::_("LEGAL_INFO").'</a>'." ".'<a href="https://dev.twitter.com/docs/auth/tokens-devtwittercom" target="_blank">'.JText::_("TWITTER_APP_CREATION").'</a>';?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->form->getLabel('custom_twitter_consumerkey'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('custom_twitter_consumerkey', null , $this->configcustom_twitter_consumerkey); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->form->getLabel('custom_twitter_consumersecret'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('custom_twitter_consumersecret', null , $this->configcustom_twitter_consumersecret); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->form->getLabel('custom_twitter_accesstoken'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('custom_twitter_accesstoken', null , $this->configcustom_twitter_accesstoken); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->form->getLabel('custom_twitter_accesstoken_secret'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('custom_twitter_accesstoken_secret', null , $this->configcustom_twitter_accesstoken_secret); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->form->getLabel('twitter_screenname'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('twitter_screenname', null , $this->configtwitter_screenname); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->form->getLabel('twitter_filter_words'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('twitter_filter_words', null , $this->configtwitter_filter_words); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->form->getLabel('twitter_send_mail'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('twitter_send_mail', null , $this->configtwitter_send_mail); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->form->getLabel('twitter_ticket_title'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('twitter_ticket_title', null , $this->configtwitter_ticket_title); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $this->form->getLabel('twitter_ticket_subject'); ?>
			</td>
			<td>
				<?php echo $this->form->getInput('twitter_ticket_subject', null , $this->configtwitter_ticket_subject); ?>
			</td>
		</tr>
		
	</tbody>
	</table>
	</div>
	
	<div class="tab-pane" id="category">
	<table class="admintable" width="100%">
		<tbody>
			<tr>
				<td>
					<?php echo $this->form->getLabel('select_category'); ?>
				</td>
				<td>
					<?php echo $this->form->getInput('select_category', null , $this->configselect_category); ?>
				</td>
			</tr>
			
			<tr>
				<td>
					<?php echo $this->form->getLabel('category_extension'); ?>
				</td>
				<td>
					<?php echo $this->form->getInput('category_extension', null , $this->configcategory_extension); ?>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
	
	<div class="tab-pane" id="config_status">
	<table class="admintable" width="100%">
		<tbody>
			<tr>
				<td>
					<?php echo $this->form->getLabel('status'); ?>
				</td>
				<td>
					<?php echo $this->form->getInput('status', null , $this->configstatus); ?>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
	
	<div class="tab-pane" id="message_settings">
	<table class="admintable" width="100%">
		<tbody>
		<legend><?php echo JText::_("CONFIG_FRONTEND_MESSAGE_LEGEND"); ?></legend>
			<tr>
				<td>
					<?php echo $this->form->getLabel('ticket_saved_msg'); ?>
				</td>
				<td>
					<?php echo $this->form->getInput('ticket_saved_msg', null , $this->configticket_saved_msg); ?>
				</td>
			</tr>
			
			<tr>
				<td>
					<?php echo $this->form->getLabel('ticket_removed_msg'); ?>
				</td>
				<td>
					<?php echo $this->form->getInput('ticket_removed_msg', null , $this->configticket_removed_msg); ?>
				</td>
			</tr>
			
			<tr>
				<td>
					<?php echo $this->form->getLabel('ticket_followup_msg'); ?>
				</td>
				<td>
					<?php echo $this->form->getInput('ticket_followup_msg', null , $this->configticket_followup_msg); ?>
				</td>
			</tr>
			
			<tr>
				<td>
					<?php echo $this->form->getLabel('ticket_removefollow_msg'); ?>
				</td>
				<td>
					<?php echo $this->form->getInput('ticket_removefollow_msg', null , $this->configticket_removefollow_msg); ?>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
	
</div> <!-- content-tab div ends here -->

<div>
<input type="hidden" name="option" value="com_jsptickets" />
<input type="hidden" name="controller" value="config" />
<input type="hidden" name="task" value="config" />
<?php echo JHtml::_('form.token'); ?>
</div>
</form>

<script type="text/javascript">
 showfiletype(document.getElementById('jform_file_upload').value);
 showfbgen(document.getElementById('jform_gen_fb_tickets').value);
 showtwittergen(document.getElementById('jform_gen_twitter_tickets').value);
 showcategory(document.getElementById('jform_select_category').value);
</script>