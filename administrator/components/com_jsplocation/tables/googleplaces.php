<?php
class TableGoogleplaces extends JTable
{
	
	var $id 					= null;
	
	var $name  				= null;

	var $address  				= null;
	
	var $latitude  				= null;
	
	var $longitude 				= null;
	
	
	
	function __construct(&$db)
	{
		parent::__construct( '#__jsplocation_gplaces_temp', 'id', $db );
	}

	
}
?>

