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

<script language="javascript" type="text/javascript">

function chkvalidate(){					
			var x=document.getElementById('search').value;
			//alert(x);
			if(x == ""){
				alert("Please enter Search text.");
				document.getElementById('search').focus();
				return false;
			}
			else {
			var iChars = "`~!@#$%^&*()+=-[]\\\';/{}|\":<>?";
			for (var i = 0; i < x.length; i++) {
				if (iChars.indexOf(x.charAt(i)) != -1) {
				alert ("Filter not allowed special characters.");
				document.getElementById('search').focus();
				return false;
				}				
				}		
			}
}

</script>

<legend><?php echo JText::_( 'COUNTRY_LIST' ); ?></legend>
<form action="index.php?option=com_jsplocation" method="post" name="adminForm" id="adminForm">
<table class="table table-striped" cellspacing="1">
<tr>
		<div id="filter-bar" class="btn-toolbar">
		<div class="filter-search btn-group pull-left">
		<input id="search" type="text" title="Search" value="<?php echo $this->search;?>" placeholder="Filter:" name="search" on change="document.adminForm.submit();">
		</div>
		<div class="btn-group pull-left">
		<!--<button class="btn tip" rel="tooltip" type="submit" data-original-title="Search" onclick="this.form.submit();">-->
		<button class="btn tip" rel="tooltip" type="submit" data-original-title="Search" onclick="return chkvalidate();">
		<i class="icon-search"></i>
		</button>
		<button class="btn tip" rel="tooltip" onclick="document.id('search').value='';this.form.submit();" type="button" data-original-title="Clear">
		<i class="icon-remove"></i>
		</button>
		</div>
		<div class="btn-group pull-right hidden-phone">
			<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
		</div>
</tr>
</table>
<table class="table table-striped" cellspacing="1">
<thead>
	<tr>
    <th colspan="4"><?php echo JText::_( 'COUNTRY_LIST_DESC' ); ?></th>
    </tr>
	<tr>
		<th width="5">
			<?php echo JText::_( 'Num' ); ?>
		</th>
		<th width="5">
			<input type="checkbox" onclick="Joomla.checkAll(this)" title="Check All" value="" name="checkall-toggle"/>
		</th>
		<th class="title">
			<?php echo JText::_( 'COUNTRY' ); ?>
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
	if($this->data != null){
	foreach($this->data as $row){
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
        	<span class="editlinktip hasTip" title="<?php echo JText::_( 'EDIT' );?>::<?php echo htmlspecialchars(preg_replace('/[[:^print:]]/','',$row->title)); ?>">
			<a href="<?php echo JURI::base(); ?>index.php?option=com_jsplocation&controller=country&task=edit&cid[]=<?php echo $row->id; ?>">
				<?php echo $row->title; ?>
            </a>
            </span>
		</td>
		<td align="left">
			<span class="editlinktip hasTip" title="<?php echo $publish_info; ?>">
				<a class="<?php echo $aclass; ?>"  href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $row->published ? 'unpublish' : 'publish' ?>')">
					<i class="<?php echo $iconclass; ?>"></i>
				</a>
			</span>			
		</td>
	</tr>
	<?php
		$k = 1 - $k;	$i++;
	}
}
else { echo '<tr><td colspan="10"><center><h5>'. JText::_('NO_RESULT_IN_LIST') .'</h5></center></td></tr>'; }
	?>
</tbody>
</table>
<input type="hidden" name="option" value="com_jsplocation" />
<input type="hidden" name="controller" value="country" />
<input type="hidden" name="task" value="country" />
<input type="hidden" name="boxchecked" value="0" />
</form>