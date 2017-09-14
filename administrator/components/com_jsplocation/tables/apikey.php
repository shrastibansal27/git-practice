<?php
	class TableApikey extends JTable
	{
		var $id 		= null;		
		var $name  		= null;		
		var $apikey  	= null;
		function __construct(&$db)
		{
			parent::__construct( '#__jsplocation_gplaces_apikey', 'id', $db );
		}
	}
?>
