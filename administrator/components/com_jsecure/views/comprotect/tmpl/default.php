<?php
/**
 * jSecure Authentication components for Joomla!
 * jSecure Authentication extention prevents access to administration (back end)
 * login page without appropriate access key.
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2015
 * @package     jSecure3.4
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: default.php  $
 */
	
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//JHTML::_('behavior.mootools');
//JHTML::_('script','system/modal.js', false, true);
//JHTML::_('stylesheet','system/modal.css', array(), true);

$document = JFactory::getDocument();

$document->addCustomTag('<script language="javascript" type="text/javascript" src="components/com_jsecure/js/comprotect.js"></script>');
$basepath   = JPATH_ADMINISTRATOR .'/components/com_jsecure';
		$configFile	 = $basepath.'/params.php';
		
		require_once($configFile);
		$app        = JFactory::getApplication();
		$JSecureConfig = new JSecureConfig();

if (!jsecureControllerjsecure::isMasterLogged() and $JSecureConfig->enableMasterPassword == '1' and $JSecureConfig->include_component_protection == '1' )
{
JError::raiseWarning(404, JText::_('NOT_AUTHERIZED'));
$link = "index.php?option=com_jsecure";
$app->redirect($link);	

}
else{

?>
<form action="index.php?option=com_jsecure" method="post" name="adminForm" onsubmit="return submitbutton();" autocomplete="off" id="adminForm">
<table class="table table-striped" cellspacing="1">
<thead>
	<tr><th colspan=6 style='text-align:left;'><h1><?php echo JText::_( 'Component Protection' ); ?></h1></th></tr>
</thead>
<thead>
	<tr>
		<th width="5">
			<?php echo JText::_( 'Num' ); ?>
		</th>
		<th class="title">
			<?php echo JText::_( 'Component Name' ); ?>
		</th>
		<th class="title">
			<?php echo JText::_( 'Enable Protection' ); ?>
		</th>
		<th class="title">
			<?php echo JText::_( 'Password' ); ?>
		</th>
	</tr>
</thead>
<tbody>
	<?php
	$password = $this->password;
	$i=0;$k = 0;
	foreach($this->components as $row){
		if($row->name != 'jsecure'){
		$enabled = 0;
		foreach($password as $pass){
         if($pass->com_id == $row->extension_id and $pass->status == 1)
           $enabled = 1;
		}

	?>
	<tr class="<?php echo "row$k"; ?>">
		<td>
			<?php echo   $i+1; ?>
		</td>
		<td align="left">
				<?php 
		
	$name = str_replace('com_','',$row->name);
	$name = ucfirst($name); 
	echo JText::_($name); ?>
			</a>
		</td>	
		<td align="left">

		<?php	echo $list['status']  = JHTML::_( 'select.genericlist', $this->status, "component[$row->extension_id][status]",'class="droplist" style="width:40.0552%;"','id', 'title', $enabled );
		//echo $enabled;
		?>
		</td>
		<td align="left">
			<?php  echo '<input type="password" name="component['.$row->extension_id.'][key]" value="" size="50" />';?>

		</td>
		
	</tr>
	<?php
		$k = 1 - $k;	$i++;
		}
	}
	?>
</tbody>
</table>

<input type="hidden" name="option" value="com_jsecure" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
</form>
<?php
}
?>