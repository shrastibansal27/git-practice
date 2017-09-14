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

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHTML::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
$document = JFactory::getDocument();
$document->addCustomTag('<link rel="stylesheet" type="text/css" href="components/com_jsptickets/css/style.css" />');

$user		= JFactory::getUser();
$userId		= $user->get('id');
$extension	= $this->escape($this->state->get('filter.extension'));
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$ordering 	= ($listOrder == 'a.lft');
$saveOrder 	= ($listOrder == 'a.lft' && $listDirn == 'asc');
?>

<form action="<?php echo JRoute::_('index.php?option=com_jsptickets&task=catlist');?>" method="post" name="adminForm" id="adminForm">
	<div id="filter-bar" class="btn-toolbar">
		<div class="filter-search btn-group pull-left">
			<label class="element-invisible" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('Search');?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_CATEGORIES_ITEMS_SEARCH_FILTER'); ?>" />
		</div>
		<div class="btn-group hidden-phone">
			<button class="btn tip" title="Search" type="submit"><i class="icon-search"></i></button>
			<button class="btn tip" title="Clear" type="button" onclick="document.getElementById('filter_search').value='';this.form.submit();"><i class="icon-remove"></i></button>
		</div>
		<div class="clearfix"></div>
		<div class="btn-group filtering-selectbox">
			<select name="filter_level" class="input-medium" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_MAX_LEVELS');?></option>
				<?php echo JHtml::_('select.options', $this->f_levels, 'value', 'text', $this->state->get('filter.level'));?>
			</select>
			<select name="filter_published" class="input-medium" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true);?>
			</select>
			<select name="filter_access" class="input-medium" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_ACCESS');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'));?>
			</select>
			<select name="filter_language" class="input-medium" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_LANGUAGE');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('contentlanguage.existing', true, true), 'value', 'text', $this->state->get('filter.language'));?>
			</select>
			<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
			<?php echo $this->pagination->getLimitBox(); ?> </div>
		<div class="clearfix"></div>
	</div>
	<div class="table-scroll">
	<table class="table table-striped" id="categoryList">
		<thead>
			<tr>
				<th width="1%" class="nowrap hidden-phone"> <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
				</th>
				<th> <?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?> </th>
				<th width="5%"  class="nowrap hidden-phone"> <?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.published', $listDirn, $listOrder); ?> </th>
				<th width="12%"> <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ORDERING', 'a.lft', $listDirn, $listOrder); ?>
					<?php if ($saveOrder) :?>
					<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'saveorder'); ?>
					<?php endif; ?>
				</th>
				<th width="10%"> <?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ACCESS', 'a.title', $listDirn, $listOrder); ?> </th>
				<th width="5%" class="nowrap hidden-phone"> <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_LANGUAGE', 'language', $this->state->get('list.direction'), $this->state->get('list.ordering')); ?> </th>
				<th width="1%" class="nowrap hidden-phone"> <?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?> </th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="15"><?php echo $this->pagination->getListFooter(); ?></td>
			</tr>
		</tfoot>
		<tbody>
			<?php
			$originalOrders = array();
			if($this->items!=null && $this->items!='') {
			foreach ($this->items as $i => $item) :
				$orderkey	= array_search($item->id, $this->ordering[$item->parent_id]);
				$canEdit	= $user->authorise('core.edit',			$extension.'.category.'.$item->id);
				$canCheckin	= $user->authorise('core.admin', 'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
				$canEditOwn	= $user->authorise('core.edit.own',		$extension.'.category.'.$item->id) && $item->created_user_id == $userId;
				$canChange	= $user->authorise('core.edit.state',	$extension.'.category.'.$item->id) && $canCheckin;
				$alt = $item->published ? JText::_('PUBLISHED') : JText::_('UNPUBLISHED');
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="order nowrap center hidden-phone">
					<?php 
					if($item->path!="uncategorised")
					{
						echo JHtml::_('grid.id', $i, $item->id);
					} else { ?>
						<span class="editlinktip hasTip" title="<?php echo JText::_('ONLY_BE_MODIFIED'); ?>">
							<img src="<?php echo JURI::base();?>components/com_jsptickets/images/main_page_icons/disabled.png" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /> 
						</span>
					<?php }	?>
				</td>
				<td><?php echo str_repeat('<span class="gi">&mdash;</span>', $item->level-1) ?>
					<?php if ($item->checked_out) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'categories.', $canCheckin); ?>
					<?php endif; ?>
					<?php if ($canEdit || $canEditOwn) : ?>
					<a href="<?php echo JRoute::_('index.php?option=com_jsptickets&controller=catlist&task=edit&id='.$item->id);?>"> <?php echo $this->escape($item->title); ?></a>
					<?php else : ?>
					<?php echo $this->escape($item->title); ?>
					<?php endif; ?>
					<span class="small" title="<?php echo $this->escape($item->path); ?>">
					<?php if (empty($item->note)) : ?>
					<?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->alias));?>
					<?php else : ?>
					<?php echo JText::sprintf('JGLOBAL_LIST_ALIAS_NOTE', $this->escape($item->alias), $this->escape($item->note));?>
					<?php endif; ?>
					</span></td>
				<td class="center">
					<?php 
					if($item->path!="uncategorised")
					{
						echo JHtml::_('jgrid.published', $item->published, $i, '', $canChange);
					} else {?>
						<span class="editlinktip hasTip" title="<?php echo JText::_('ONLY_BE_MODIFIED'); ?>">
							<img src="<?php echo JURI::base();?>components/com_jsptickets/images/main_page_icons/disabled.png" width="16" height="16" border="0" alt="<?php echo $alt; ?>" /> 
						</span>
					<?php } ?>
				</td>
				<td class="order nowrap center hidden-phone"><?php if ($canChange) : ?>
					<?php if ($saveOrder) : ?>
					<span><?php echo $this->pagination->orderUpIcon($i, isset($this->ordering[$item->parent_id][$orderkey - 1]), 'orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span> <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, isset($this->ordering[$item->parent_id][$orderkey + 1]), 'orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
					<?php endif; ?>
					<?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
					<input type="text" name="order[]" class= "input-small" size="5" value="<?php echo $orderkey + 1;?>" <?php echo $disabled ?> class="text-area-order" />
					<?php $originalOrders[] = $orderkey + 1; ?>
					<?php else : ?>
					<?php echo $orderkey + 1;?>
					<?php endif; ?></td>
				<td class="center"><?php echo $this->escape($item->access_level); ?></td>
				<td class="small nowrap hidden-phone"><?php if ($item->language=='*'):?>
					<?php echo JText::alt('JALL', 'language'); ?>
					<?php else:?>
					<?php echo $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
					<?php endif;?></td>
				<td class="center hidden-phone"><span title="<?php echo sprintf('%d-%d', $item->lft, $item->rgt);?>"> <?php echo (int) $item->id; ?></span></td>
			</tr>
			<?php endforeach; 
			} else {
			echo '<tr><td colspan="7"><center><h5>'.JText::_("NO_CATEGORY_TO_DISPLAY").'</h5></center></td></tr>';
			}?>
		</tbody>
	</table>
	</div>
	<?php //Load the batch processing form. ?>
	<?php echo $this->loadTemplate('batch'); ?>
	<div>
		<input type="hidden" name="extension" value="<?php echo $extension;?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<input type="hidden" name="original_order_values" value="<?php echo implode($originalOrders, ','); ?>" />
		<input type="hidden" name="option" value="com_jsptickets" />
		<input type="hidden" name="controller" value="catlist" />
		<input type="hidden" name="task" value="catlist" />
		<?php echo JHtml::_('form.token'); ?> </div>
</form>
