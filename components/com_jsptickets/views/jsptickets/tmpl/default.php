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
$document = JFactory::getDocument();
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/style.css" />');

$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/bootstrap.css" />');
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/bootstrap.min.css" />');
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/bootstrap-responsive.css" />');
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/bootstrap-responsive.min.css" />');

$user = JFactory::getUser();
$mainframe = JFactory::getApplication();
$session = JFactory::getSession();
if(array_key_exists("cookie_itemid",$_COOKIE))
{
	$menuitemid	= $_COOKIE["cookie_itemid"];
} else {
	$menuitemid	= $session->get('Itemid');
}
JSite::getMenu()->setActive($menuitemid);
$i=0;
?>
<script language="javascript" type="text/javascript">
function validateEmail(email) 
{
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}
function NewSubmit()
{
		var submitForm = document.adminForm;
		var flag11 = flag12 = true;
		var new_guestname = submitForm.getElementById("jform_new_guestname").value;
		var new_guestemail = submitForm.getElementById("jform_new_guestemail").value;
		var validateNewEmail = validateEmail(submitForm.getElementById("jform_new_guestemail").value);
		
		if(document.getElementById("newsubmit").value == "New Ticket")
		{
			if(new_guestname == '')
			{
				submitForm.getElementById("jform_new_guestname-lbl").className = "hasTip invalid";
				submitForm.getElementById("jform_new_guestname").className = "required invalid";
				submitForm.getElementById("jform_new_guestname").setAttribute("required", "true");
				flag11 = false;
			} else {
				submitForm.getElementById("jform_new_guestname-lbl").className = "hasTip required";
				submitForm.getElementById("jform_new_guestname").className = "required";
				submitForm.getElementById("jform_new_guestname").removeAttribute("required");
			}
			
			if(new_guestemail == '' || !(validateNewEmail))
			{
				submitForm.getElementById("jform_new_guestemail-lbl").className = "hasTip invalid";
				submitForm.getElementById("jform_new_guestemail").className = "required invalid";
				submitForm.getElementById("jform_new_guestemail").setAttribute("required", "true");
				flag12 = false;
			}else {
				submitForm.getElementById("jform_new_guestemail-lbl").className = "hasTip required";
				submitForm.getElementById("jform_new_guestemail").className = "validate-email required";
				submitForm.getElementById("jform_new_guestemail").removeAttribute("required");
			}
			
			if(flag11 == false || flag12 == false)
			{
				return false;
			} else {
				submitForm.submit();
				return true;
			}
		}
}
function SearchSubmit()
{
		var submitForm = document.adminForm;
		var flag21 = flag22 = true;
		var search_guestemail = submitForm.getElementById("jform_guestemail").value;
		var search_ticketid = submitForm.getElementById("jform_ticketid").value;
		var validateSearchEmail = validateEmail(submitForm.getElementById("jform_guestemail").value);
	
		if(document.getElementById("searchsubmit").value == "Search Ticket")
		{			
			if(search_guestemail == '' || !(validateSearchEmail))
			{
				submitForm.getElementById("jform_guestemail-lbl").className = "hasTip invalid";
				submitForm.getElementById("jform_guestemail").className = "required invalid";
				submitForm.getElementById("jform_guestemail").setAttribute("required", "true");
				flag21 = false;
			} else {
				submitForm.getElementById("jform_guestemail-lbl").className = "hasTip required";
				submitForm.getElementById("jform_guestemail").className = "validate-email required";
				submitForm.getElementById("jform_guestemail").removeAttribute("required");
			}
			
			if(search_ticketid == '')
			{
				submitForm.getElementById("jform_ticketid-lbl").className = "hasTip invalid";
				submitForm.getElementById("jform_ticketid").className = "required invalid";
				submitForm.getElementById("jform_ticketid").required = "true";
				flag22 = false;
			} else {
				submitForm.getElementById("jform_ticketid-lbl").className = "hasTip required";
				submitForm.getElementById("jform_ticketid").className = "required";
				submitForm.getElementById("jform_ticketid").removeAttribute("required");
			}
			
			if(flag21 == false || flag22 == false)
			{
				return false;
			} else {
				submitForm.submit();
				return true;
			}
		}
}
</script>
<?php if( $this->config[0]->access_control == 0 ) // if `access control` in configuration is set to PUBLIC
		{
			if(!$user->guest) // send registered user to LIST page
			{
				$mainframe->redirect(JRoute::_("index.php?option=com_jsptickets&view=tickets&controller=ticketlist&task=display&Itemid=". $menuitemid), "");
			} else {
				if($user->id == 0 && ( ($session->get( 'ticketid' ) != "" || $session->get( 'ticketid' ) != null) && ($session->get( 'guestemail' )!= "" || $session->get( 'guestemail' )!= null)  ))
				{
					$mainframe->redirect(JRoute::_("index.php?option=com_jsptickets&view=tickets&controller=ticketlist&task=display&Itemid=". $menuitemid), "");
				}
?>
	<form name="adminForm" id="adminForm"  method="post" action="<?php echo JRoute::_('index.php?option=com_jsptickets&view=tickets&controller=ticketlist&task=display&Itemid='.$menuitemid);?>">
	<ul class="nav nav-pills">
	<li class="active"><a href="#newticket" data-toggle="tab"><?php echo JText::_('NEW_TICKET');?></a></li>
	<li><a href="#searchticket" data-toggle="tab"><?php echo JText::_('SEARCH_TICKET');?></a></li>
	</ul>
	<?php
		//echo $this->pane->startPane('guest-pane');
		//echo $this->pane->startPanel(JText::_('NEW_TICKET'), 'New Ticket');
	?>
	<div class="tab-content"> <!-- content-tab div starts here -->
		<div class="tab-pane active" id="newticket">
		<div class="page-header">
		<h5>
		<?php echo JText::_("GUESTUSER_NEW_NOTICE");?>
		</h5>
		</div>
		
		
					<div class="form-group">
					<label class="control-label span2" for=""><?php echo $this->form->getLabel('new_guestname'); ?></label>
					<div class="col-sm-10">
					<?php echo $this->form->getInput('new_guestname', null , ''); ?>
					</div>
					</div>
		
					<div class="form-group">
					<label class="control-label span2" for=""><?php echo $this->form->getLabel('new_guestemail'); ?></label>				
					<div class="col-sm-10">
					<?php echo $this->form->getInput('new_guestemail', null , ''); ?>
					</div>
					</div>
					
				<div class="page-header"></div>
					
					<div class="form-group">	
					<input class="btn btn-info" type="button" id="newsubmit" name="newsubmit" value="New Ticket" onclick="return NewSubmit();" />
					</div>
					
				
					
			

					
				
	</div>
	
	
	
	<?php
		//echo $this->pane->endPanel();
		//echo $this->pane->startPanel(JText::_('SEARCH_TICKET'), 'Search Ticket');
	?>
	<div class="tab-pane" id="searchticket">
	
					
			<div class="page-header">
			<h5>
			<?php echo JText::_("GUESTUSER_SEARCH_NOTICE");?>
			</h5>
			</div>	
			
			
					<div class="row-fluid">
					<label class="control-label span2" for=""><?php echo $this->form->getLabel('guestemail'); ?></label>
					<div class="col-sm-10">
					<?php echo $this->form->getInput('guestemail', null , ''); ?>
					</div>
					</div>
		
					<div class="row-fluid">
					 <label class="control-label span2" for=""><?php echo $this->form->getLabel('ticketid'); ?></label>								
					<div class="col-sm-10">
					<?php echo $this->form->getInput('ticketid', null , ''); ?>
					</div>
					</div>
					
				<div class="page-header"></div>
	
					<div class="form-group">	
					<input class="btn btn-info" type="button" id="searchsubmit" name="searchsubmit" value="Search Ticket" onclick="return SearchSubmit();" />
					</div>
	
	</div>
</div> <!-- content-tab div ends here -->
	
<div>
	<input type="hidden" name="option" value="com_jsptickets" />
	<input type="hidden" name="controller" value="ticketlist" />
	<input type="hidden" name="task" value="display" />
</div>
	</form>
	
<!--<form>
  
  <div class="form-group">
    <label for="exampleInputEmail1"><?php //echo $this->form->getLabel('new_guestname'); ?></label>
   <?php //echo $this->form->getInput('new_guestname', null , ''); ?>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1"><?php //echo $this->form->getLabel('new_guestemail'); ?></label>
   <?php //echo $this->form->getInput('new_guestemail', null , ''); ?>
  </div>

  <input class="btn btn-info" type="button" id="newsubmit" name="newsubmit" value="New Ticket" onclick="return NewSubmit();" />
</form>-->




	
<?php
			}
		} else { // if `access control` in configuration is set to REGISTERED
			if(!$user->guest) // send registered user to LIST page
			{
				$mainframe->redirect(JRoute::_("index.php?option=com_jsptickets&view=tickets&controller=ticketlist&task=display"), "");
			} else { // give guest user the MESSAGE
				echo JText::_("ONLY_FOR_REGISTERED_MSG");
			}
		}
?>