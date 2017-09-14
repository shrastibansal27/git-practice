<?php
/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: list.php  $
 */
 

 
 
// no direct access
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHTML::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
$document = JFactory::getDocument();
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/style.css" />');
$model = $this->getModel();
$user = JFactory::getUser();
$usergrpId = $model->getUserGroupIdByUid($user->id);
$listOrder	= $this->listOrder;
$listDirn	= $this->listDirn;
$filter_option_access = json_decode($this->config[0]->filter_option_access);
$j=2;
?>
<link rel="stylesheet" href="<?php echo JURI::root();?>media/jui/css/chosen.css" type="text/css" />
<script src="<?php echo JURI::root();?>media/jui/js/chosen.jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
	(function($){
		$('#collapseModal').modal({"backdrop": true,"keyboard": true,"show": true,"remote": ""});
	})(jQuery);
	jQuery(document).ready(function()
	{
		jQuery('.hasTooltip').tooltip({"container": false});
	});
	// window.addEvent('domready', function() {
		// new Joomla.JMultiSelect('adminForm');
	// });
	jQuery(document).ready(function (){
		jQuery('#adminForm select').chosen({
			disable_search_threshold : 10,
			allow_single_deselect : true
		});
	});		
</script>
<script language="javascript" type="text/javascript">
Joomla.submitbutton = function(pressbutton) {
	var submitForm = document.adminForm;
	
	if ( pressbutton ) {
		if( pressbutton == 'remove' )
		{
			var val = confirm("<?php echo JText::_('REMOVAL_CONFIRM_MSG');?>");
			if(val==true)
			{
				submitForm.task.value=pressbutton;
				submitForm.submit();
				return true;
			
			} else {
				return false;
			}
		}
		else
		{
			submitForm.task.value=pressbutton;
			submitForm.submit();
			return true;
		}
	}
}
</script>
<form  class="form-validate" name="adminForm" id="adminForm" method="post" action="<?php echo JRoute::_('index.php?option=com_jsptickets&task=jsptickets');?>" enctype="multipart/form-data">
	<div id="filter-bar" class="btn-toolbar">
		<div class="filter-search btn-group pull-left">
			<label class="element-invisible" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('Search');?>" value="<?php echo $this->search; ?>" title="<?php echo JText::_('COM_CATEGORIES_ITEMS_SEARCH_FILTER'); ?>" />
		</div>
		<div class="btn-group hidden-phone">	
			<button class="btn tip" title="Search" type="submit"><i class="icon-search"></i></button>
			<button class="btn tip" title="Clear" type="button" onclick="document.getElementById('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
		</div>
		
		<div class="clearfix"></div>
		
		<div class="btn-group filtering-selectbox">
		<?php if( in_array( 1, $filter_option_access ) || in_array( $usergrpId, $filter_option_access) ) //either user group is "public" or the current user's user group is authorised
		{	?> 
			<?php echo $this->form->getInput('fltr_type', null , $this->filterType); ?>
			<?php echo $this->form->getInput('fltr_category', null , $this->filterCat); ?>
			<?php echo $this->form->getInput('fltr_follow_up', null , $this->filterFollow_up); ?>
			<?php echo $this->form->getInput('fltr_priority', null , $this->filterPriority); ?>
			<?php echo $this->form->getInput('fltr_status', null , $this->filterStatus); ?>
			<?php //echo $this->form->getInput('fltr_assigned_to', null , $this->filterAssigned_to);
				echo '<input type="hidden" id="jform_fltr_assigned_to" name="jform[fltr_assigned_to]" value="" />'; ?>
		<?php
		}	?>
			<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
	<div class="clearfix"></div>
	</div>
	<div class="table-scroll">
	<table class="table table-striped ticket-table">
		<thead>
			<tr class="row<?php echo $j % 2; ?>">
				<th width="2%" class="center">
					<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>
				
				<th>
					<?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
				</th>
				
				<th>
					<?php echo JHtml::_('grid.sort', JText::_('FOLLOW_UP'), 'a.follow_up', $listDirn, $listOrder); ?>
				</th>
				
				<th>
					<?php echo JHtml::_('grid.sort', 'JCATEGORY', 'a.category_id', $listDirn, $listOrder); ?>
				</th>
				
				<th width="250px">
					<?php echo JHtml::_('grid.sort', JText::_('SUBJECT'), 'a.subject', $listDirn, $listOrder); ?>
				</th>
				
				<th>
					<?php echo JHtml::_('grid.sort', JText::_('CREATED_BY'), 'a.created_by', $listDirn, $listOrder); ?>
				</th>
				
				<th>
					<?php echo JHtml::_('grid.sort', JText::_('ASSIGNED_TO'), 'a.assigned_to', $listDirn, $listOrder); ?>
				</th>
				
				<th>
					<?php echo JHtml::_('grid.sort', JText::_('PRIORITY'), 'a.priority_id', $listDirn, $listOrder); ?>
				</th>
				
				<th>
					<?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.status_id', $listDirn, $listOrder); ?>
				</th>
				
				<th>
					<?php echo JHtml::_('grid.sort', 'TICKETCODE', 'a.ticketcode', $listDirn, $listOrder); ?>
				</th>
				
			</tr>
		</thead>

		<tbody>
			<?php if($this->data != null) {
			
					
				foreach ($this->data as $i => $item) {
				$canCheckin	= $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $user->id || $item->checked_out == 0;
				
				if($item->follow_up == 1){
						$img = 'red_flag.png';
						$follow_info = JText::_( 'UNFOLLOW_ITEM' );
						$alt = JText::_( 'FOLLOWED' );
					} else if($item->follow_up == 0){
						$img = 'grey_flag.png';
						$follow_info = JText::_( 'FOLLOW_ITEM' );
						$alt = JText::_( 'UNFOLLOWED' );
					}
			?>
				<tr class="row<?php echo $j % 2; ?>">
				
					<td width="2%" class="center">
							<?php echo JHtml::_('grid.id', $i, $item->ticketcode); ?>
					</td>
					
					<td>
						<?php if ($item->checked_out) : ?>
						<?php echo JHtml::_('jgrid.checkedout', $i, '', $item->checked_out_time, NULL, $canCheckin); ?>
						<?php endif; ?>
						<a href="<?php echo JRoute::_('index.php?option=com_jsptickets&controller=ticketlist&task=edit&ticketcode='.$item->ticketcode);?>">
								<?php echo $this->escape($item->title); ?>
						</a>
					</td>
					
					<td>
						<span class="editlinktip hasTip" title="<?php echo $follow_info; ?>">
						<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $item->follow_up ? 'unfollow' : 'follow' ?>')">
							<img src="<?php echo JURI::base();?>components/com_jsptickets/images/main_page_icons/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" />
						</a>			
					</td>
					
					<td> 
							<?php $categories = json_decode($item->category_id);
							if(count($categories) == 1)
							{
								foreach($categories AS $k){
								echo $this->ticketcategory($k) . '<br />';} 
							} else {
								echo $this->ticketcategory($categories[0]) . '<br />...';
							}?>						
					</td>
					
					<td width="250px"> 
							<?php //echo JHTML::_('string.truncate', ($item->description), $length = 150);
							echo $item->subject; ?>						
					</td>
					
					<td>
							<?php if(isset( $item->created_by) && $item->created_by!=0 )
									{
										echo $this->getUserById($item->created_by); 
									} else {
										echo '<b>'.JText::_("GUEST_USER").'</b>';
									}?>										
					</td>
										
					<td>
							<?php if(isset( $item->assigned_to) && $item->assigned_to!=0 )
									{
										echo $this->getUserById($item->assigned_to); 
									} else {
										echo '<b>'.JText::_("NOT_ASSIGNED_TO").'</b>';
									}?>										
					</td>
					
					<td>
							<?php echo $this->ticketpriority($item->priority_id); ?>						
					</td>
					
					<td>
							<?php echo $this->ticketstatus($item->status_id); ?>						
					</td>
					
					<td colspan='1'>
							<?php echo $item->ticketcode; ?>						
					</td>
					
				</tr>
			
			<?php } } else { echo '<tr><td colspan="10"><center><h5>'. JText::_('NO_TICKET_IN_LIST') .'</h5></center></td></tr>'; }?>
			
		</tbody>

		<tfoot>
			<tr>
				<td colspan="15">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
	</table>
	</div>

<div>
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="" />
<input type="hidden" name="filter_order_Dir" value="" />
<input type="hidden" name="option" value="com_jsptickets" />
<input type="hidden" name="controller" value="ticketlist" />
<input type="hidden" name="task" value="ticketlist" />
<?php echo JHtml::_('form.token'); ?>
</div>
</form>