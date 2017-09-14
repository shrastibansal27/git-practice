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

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
JHTML::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
$document = JFactory::getDocument();
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/style.css" />');
$listOrder	= $this->listOrder;
$listDirn	= $this->listDirn;
$i=2;
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
	window.addEvent('domready', function() {
		new Joomla.JMultiSelect('adminForm');
	});
	jQuery(document).ready(function (){
		jQuery('select').chosen({
			disable_search_threshold : 10,
			allow_single_deselect : true
		});
	});		
</script>
<script language="javascript" type="text/javascript">
Joomla.submitbutton = function(pressbutton) {
	var submitForm = document.adminForm;
	
	if ( pressbutton ) {
	submitForm.task.value=pressbutton;
	submitForm.submit();
	return true;
	}
}
</script>
<form  class="form-validate" name="adminForm" id="adminForm" method="post" action="index.php?option=com_jsptickets&task=jsptickets" enctype="multipart/form-data" onsubmit="return ">
	<div id="filter-bar" class="btn-toolbar">
		<div class="filter-search btn-group pull-left">
			<label class="element-invisible" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('Search');?>" value="<?php echo $this->search; ?>" title="<?php echo JText::_('COM_CATEGORIES_ITEMS_SEARCH_FILTER'); ?>" />
		</div>
		<div class="btn-group hidden-phone">	
			<button class="btn tip" title="Search" type="submit"><i class="icon-search"></i></button>
			<button class="btn tip" title="Clear" type="button" onclick="document.id('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
		</div>
		<div class="clearfix"></div>
		
		<div class="btn-group filtering-selectbox">
			<select name="filter_published" class="input-medium" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->filter_published, true);?>
			</select>
			<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
	<div class="clearfix"></div>
	</div>
	<div class="table-scroll">
	<table class="table table-striped" style="text-align:center;">
		<thead>
			<tr class="row<?php echo $i % 2; ?>">
				<th width="2%" class="center">
					<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>
				
				<th>
					<?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.name', $listDirn, $listOrder); ?>
				</th>
				
				<th width="10%">
					<?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.publish', $listDirn, $listOrder); ?>
				</th>
				
				<th class="nowrap" width="5%">
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
				</th>
				
			</tr>
		</thead>
		
		<tbody>
			<?php if($this->data != null) {
				foreach ($this->data as $i => $item) {
				
					if($item->publish == 1){
						$img = 'tick.png';
						$publish_info = JText::_( 'UNPUBLISH_ITEM' );
						$alt = JText::_( 'PUBLISHED' );
					} else if($item->publish == 0){
						$img = 'publish_x.png';
						$publish_info = JText::_( 'PUBLISH_ITEM' );
						$alt = JText::_( 'UNPUBLISHED' );
					}
				?>
				<tr class="row<?php echo $i % 2; ?>">
				
					<td width="2%" class="center">
						<?php 
							if($item->id != 1 && $item->id != 2)
							{
								echo JHtml::_('grid.id', $i, $item->id); 
							} else {
						?>
								<span class="editlinktip hasTip" title="<?php echo JText::_('ONLY_BE_MODIFIED'); ?>">
									<img src="<?php echo JURI::base();?>components/com_jsptickets/images/main_page_icons/disabled.png" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /> 
								</span>
						<?php	}	?>
					</td>
					
					<td>
						<?php 
							if($item->id != 1 && $item->id != 2)
							{	?>
								<a href="<?php echo JRoute::_('index.php?option=com_jsptickets&controller=statuslist&task=edit&id='.$item->id);?>">
								<?php echo $this->escape($item->name); ?>
								</a>
						<?php	} else {	
								echo $this->escape($item->name);
								}	?>
					</td>
					
					<td width="10%">
						<?php 
							if($item->id != 1 && $item->id != 2)
							{	?>
								<span class="editlinktip hasTip" title="<?php echo $publish_info; ?>">
									<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $item->publish ? 'unpublish' : 'publish' ?>')">
										<img src="<?php echo JURI::base();?>components/com_jsptickets/images/main_page_icons/<?php echo $img;?>" width="16" height="16" border="0" alt="<?php echo $alt; ?>" />
									</a>
								</span>
						<?php	} else { ?>
								<span class="editlinktip hasTip" title="<?php echo JText::_('ONLY_BE_MODIFIED'); ?>">
									<img src="<?php echo JURI::base();?>components/com_jsptickets/images/main_page_icons/disabled.png" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /> 
								</span>
						<?php } ?>
					</td>
					
					<td class="nowrap" width="5%">
						<?php echo $item->id; ?>						
					</td>
					
				</tr>
				<?php } } else {
				echo '<tr><td colspan="7"><center><h5>'.JText::_("NO_STATUS_TO_DISPLAY").'</h5></center></td></tr>';
				} ?>
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
<input type="hidden" name="controller" value="statuslist" />
<input type="hidden" name="task" value="statuslist" />
<?php echo JHtml::_('form.token'); ?>
</div>
</form>