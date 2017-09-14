<?php
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator - Classic Theme
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: brdesc.php  $
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
?>

<?php
if(isset($this->imgparam))
{
	if(($this->showimg == 1 && $this->imgparam == 2) or $this->imgparam == 1 or ($this->imgparam=='' && $this->showimg == 1))
	{
	?>
			<div align="center">
				<h4><?php echo $this->brname; ?></h4>
				<br/>
				<img src="images/jsplocationimages/jsplocationImages/<?php echo $this->brimg;?>" width="100%" height="100%"/>
			</div>	
	<?php	
	}
}

else if(isset($this->plgimg))
{
	if(($this->plgimg == 1 and $this->plgshowimg == 1))
	{
	?>
		<div align="center">
			<h4><?php echo $this->brname; ?></h4>
			<br/>
			<img src="images/jsplocationimages/jsplocationImages/<?php echo $this->plgbrimg;?>" width="100%" height="100%"/>
		</div>	
	<?php
	}
}	

else
{
	if(isset($this->brdesc))
	{	
		echo "<div align=\"center\"><h4>".$this->brname."</h4></div>";
		echo "<br/>";
		echo $this->brdesc;
	}	
}
?>