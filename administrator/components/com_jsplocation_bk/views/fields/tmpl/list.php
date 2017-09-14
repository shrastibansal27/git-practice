<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: list.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$document =& JFactory::getDocument();
JHtml::_('behavior.framework', true);
JHTML::_('script','system/modal.js', false, true);
JHTML::_('stylesheet','system/modal.css', array(), true);
$document->addScriptDeclaration("window.addEvent('domready', function() {
			$$('.hasTip').each(function(el) {
				var title = el.get('title');
				if (title) {
					var parts = title.split('::', 2);
					el.store('tip:title', parts[0]);
					el.store('tip:text', parts[1]);
				}
			});
			var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false});
		});
		window.addEvent('domready', function() {

			SqueezeBox.initialize({});
			SqueezeBox.assign($$('a.modal'), {
				parse: 'rel'
			});
		});
");
?>
<legend><?php echo JText::_( 'FIELDS_LIST' ); ?></legend>

<form action="index.php?option=com_jsplocation" method="post" name="adminForm" id="adminForm">
<table class="table table-striped">
<tr>
	<div class="btn-group pull-right hidden-phone">
			<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
			<?php echo $this->pagination->getLimitBox(); ?>
	</div>
</tr>
</table>
<table class="table table-striped" cellspacing="1">
<thead>
	<tr>
    <th colspan="5"><?php echo JText::_( 'FIELD_LIST_DESC' ); ?></th>
    </tr>
	<tr>
		<th width="5">
			<?php echo JText::_( 'Num' ); ?>
		</th>
		<th width="5">
			<input type="checkbox" onclick="Joomla.checkAll(this)" title="Check All" value="" name="checkall-toggle"/>
		</th>
		<th class="title">
			<?php echo JText::_( 'FIELDS_NAME' ); ?>
		</th>
        <th class="title">
			<?php echo JText::_( 'FIELDS_TYPE'  ); ?>
		</th>
		<th class="title">
			<?php echo JText::_( 'PUBLISHED' ); ?>
		</th>
	</tr>
</thead>
<tfoot>
	<tr>
		<td colspan="15">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tr>
</tfoot>
<tbody>
	<?php
	$i=0;$k = 0;
	if($this->data){
	foreach($this->data as $row){
		$link 		= JRoute::_( 'index.php?option=com_jsplocation&controller=fields&task=edit&cid[]='. $row->id );
		if($row->published == 1){
			
			$publish_info = JText::_( 'UNPUBLISH_ITEM' );
			$iconclass = "icon-publish";
			$aclass = "btn btn-micro active";
		} else if($row->published == 0){
			
			$publish_info = JText::_( 'PUBLISH_ITEM' );
			$iconclass = "icon-unpublish";
			$aclass = "btn btn-micro ";
		}
	?>
	<tr class="<?php echo "row$k"; ?>">
		<td>
			<?php echo  $this->pagination->getRowOffset( $i ); ?>
		</td>
		<td align="center">
			<?php echo JHtml::_('grid.id', $i, $row->id); ?>
		</td>
		<td align="left">
        	<span class="editlinktip hasTip" title="<?php echo JText::_( 'EDIT' );?>::<?php echo htmlspecialchars($row->field_name); ?>">
			<a href="<?php echo $link; ?>">
				<?php echo $row->field_name; ?>
            </a>
            </span>
		</td>	
		<td align="left">
			<?php echo $row->field_type; ?>
		</td>
		<td align="left">
			<span class="editlinktip hasTip" title="<?php echo $publish_info; ?>">
				<a class="<?php echo $aclass; ?>"  href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $row->published ? 'unpublish' : 'publish' ?>')">
					<i class="<?php echo $iconclass;  ?>"></i>
				</a>
			</span>			
		</td>
	</tr>
	<?php
		$k = 1 - $k;	$i++;
	}
}
	?>
</tbody>
</table>
<input type="hidden" name="option" value="com_jsplocation" />
<input type="hidden" name="task" value="fields" />
<input type="hidden" name="controller" value="fields" />
<input type="hidden" name="boxchecked" value="0" />
</form>