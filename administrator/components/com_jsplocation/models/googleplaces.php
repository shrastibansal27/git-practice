<?php
	/**
		* JSP Location components for Joomla!
		* JSP Location is an interactive store locator
		*
		* @author      $Author: Ajay Lulia $
		* @copyright   Joomla Service Provider - 2016
		* @package     JSP Store Locator 2.2
		* @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
		* @version     $Id: branch.php  $
	*/
	// no direct access
	defined( '_JEXEC' ) or die( 'Restricted access' );
	jimport( 'joomla.application.component.model' );
	class jspLocationModelGoogleplaces extends JModelLegacy {
		function setApiKey($apikey){
			$mainframe = Jfactory::GetApplication();
			$db = $this->getDBO();
			$selectapikey = "select * from #__jsplocation_gplaces_apikey where name = 'googleapikey' AND id = '1' AND apikey != ''";
			$db->setQuery($selectapikey);
			$selectedapikey = $db->loadObjectList();
			$getapikey = $selectedapikey[0]->apikey;
			$apikey = addslashes($apikey);
			if(!empty($apikey)){
				if($getapikey !=''){
					$updateapiquery = "UPDATE #__jsplocation_gplaces_apikey SET apikey = '".$apikey."' where id = '1'";
					$db->setQuery( $updateapiquery );
					$db->query();
				}
				else {
					
					$insertapikey = "INSERT INTO #__jsplocation_gplaces_apikey (id,name,apikey) VALUES('1','googleapikey','".$apikey."')";
					$db->setQuery($insertapikey);
					$result = $db->execute();
				}
				
			}
		}
		function setGoogleData($search){
			$mainframe = Jfactory::GetApplication();
			$db = $this->getDBO();
			$search = addslashes($search);
			$googleapikey = "select apikey from #__jsplocation_gplaces_apikey" ;
			$db->setQuery($googleapikey);
			$setapikey = $db->loadObjectList();
			$api = $setapikey[0]->apikey;
			$xml = simplexml_load_file("https://maps.googleapis.com/maps/api/place/textsearch/xml?query=$search&key=".$api.""); 
			if($xml->status !=  'OK')
			{
				$errormessage = $xml->error_message;
				return $errormessage;
			}
			if($xml->children()->status == 'OK'){
				$addresses = $xml->children()->result;
				$placesinfo = array();
				$truncate_table_query = "truncate table #__jsplocation_gplaces_temp";
				$db->setQuery($truncate_table_query);
				$truncate = $db->execute(); 
				foreach($addresses as $address){
					$storename = $address->name;
					$storeaddress = $address->formatted_address;
					$storename = addslashes($storename);
					$storeaddress = addslashes($storeaddress);
					$lat = $address->geometry->location->lat;
					$lng = $address->geometry->location->lng;
					$data = $storename.'__'.$storeaddress.'__'.$lat.'__'.$lng;
					$placesinfo[] = $data;
					$insert_into_db = 'insert into #__jsplocation_gplaces_temp(name,address,latitude,longitude) values("'.$storename.'","'.$storeaddress.'",'.$lat.','.$lng.')';
					$db->setQuery($insert_into_db);
					$result = $db->execute(); 
				}
				return '';
			}
		}
		function getGoogleData(){
			$mainframe = Jfactory::GetApplication();
			$db = $this->getDBO();
			$query = "select * from #__jsplocation_gplaces_temp";
			$db->setQuery($query);
			$getData = $db->loadObjectList();
			return $getData;
		}
		function getGoogleapi(){
			$mainframe = Jfactory::GetApplication();
			$db = $this->getDBO();
			$query = "select apikey from #__jsplocation_gplaces_apikey";
			$db->setQuery($query);
			$setapikey = $db->loadObjectList();
			$apikey = $setapikey[0]->apikey;
			return $apikey;
		}
		function yahooApiData($id){
			$mainframe = Jfactory::GetApplication();
			$db = $this->getDBO();
			$query = "select address from #__jsplocation_gplaces_temp where id = ".$id;
			$db->setQuery($query);
			$address = $db->loadObjectList();
			$addressdetail = $address[0]->address;
			$addresslashdetail = addslashes($addressdetail);
			$addressdet = str_replace(' ',"%20",$addressdetail);
			$geocode 	= file_get_contents("http://query.yahooapis.com/v1/public/yql?q=SELECT%20*%20FROM%20geo.places%20WHERE%20text%3D%22$zipsearch". $addressdet."%22&format=json");
			$output = json_decode($geocode);
			$CountryCount = $output->query->count;
			$temp = array();
			if($CountryCount>=1)
			{
				$city = $output->query->results->place->locality1->content;
				$area = $output->query->results->place->admin2->content;
				/*In few locations area is blank so to fetch area for further code*/
				if($area==""){
					$area = $city;
				}
				$zipcode = $output->query->results->place->postal->content;
				$country = $output->query->results->place->country->content;
				$state = $output->query->results->place->admin1->content;
				$latitude = $output->query->results->place->centroid->latitude;
				$longitude = $output->query->results->place->centroid->longitude;
				/*if state or city is blank then give invalid data message*/
				if(($city =='') || ($country =='')){
					$link = 'index.php?option=com_jsplocation&controller=googleplaces&task=googleplaces';
					$msg = 'Cannot create location as data from API is insufficent';
					$mainframe->redirect($link,$msg,'Message');
				}
				if(($area !='') && ($country !='') && ($state !='') && ($city !='') && ($latitude !='') && ($longitude !='')){
					$area = addslashes($area);
					$country = addslashes($country);
					$state = addslashes($state);
					$city = addslashes($city);
					$countryquery ="SELECT title FROM #__jsplocation_country where title ='".$country."'";
					$db->setQuery($countryquery);
					$countryrows = $db->loadObjectList();
					if(empty($countryrows)){
						$countrysql="INSERT INTO #__jsplocation_country (title,published) VALUES('".$country."','1')";
						$db->setQuery($countrysql);
						$db->query($countrysql);
					}
					$conquery ="SELECT id,title FROM #__jsplocation_country where title ='".$country."'";
					$db->setQuery($conquery);
					$conrows = $db->loadObjectList();
					$countryid = $conrows[0]->id;
					$country_name= $conrows[0]->title;
					$statecheck = "SELECT * from #__jsplocation_state where title='".$state."' AND country_id=".$countryid;
					$db->setQuery($statecheck);
					$statecheckrows = $db->loadObjectList();
					if(empty($statecheckrows)){
						$statesql="INSERT INTO #__jsplocation_state (title,published,country_id) VALUES('".$state."','1','".$countryid."')";
						$db->setQuery($statesql);
						$db->query($statesql);
					}
					$statequery ="SELECT id,title FROM #__jsplocation_state where title ='".$state."'";
					$db->setQuery($statequery);
					$staterows = $db->loadObjectList();
					$stateid = $staterows[0]->id; 
					$state_name = $staterows[0]->title; 
					$citycheck = "SELECT * from #__jsplocation_city where title='".$city."' AND country_id='".$countryid."'AND state_id=".$stateid;
					$db->setQuery($citycheck);
					$citycheckrows = $db->loadObjectList();
					if(empty($citycheckrows)){
						$citysql="INSERT INTO #__jsplocation_city (title,published,country_id,state_id) VALUES('".$city."','1','".$countryid."','".$stateid."')";
						$db->setQuery($citysql);
						$db->query($citysql);
					}
					$cityquery ="SELECT id,title FROM #__jsplocation_city where title ='".$city."'";
					$db->setQuery($cityquery);
					$cityrows = $db->loadObjectList();
					$cityid = $cityrows[0]->id;
					$city_name = $cityrows[0]->title;
					$areacheck = "SELECT * from #__jsplocation_area where title='".$area."' AND country_id='".$countryid."' AND city_id='".$cityid."' AND state_id=".$stateid;
					$db->setQuery($areacheck);
					$areacheckrows = $db->loadObjectList();
					if(empty($areacheckrows)){
						$areasql="INSERT INTO #__jsplocation_area (title,published,country_id,state_id,city_id) VALUES('".$area."','1','".$countryid."','".$stateid."','".$cityid."')";
						$db->setQuery($areasql);
						$db->query($areasql);
					}
					$areaquery = "SELECT id,title FROM #__jsplocation_area where title ='".$area."'";
					$db->setQuery($areacheck);
					$arearows = $db->loadObjectList();
					$areaid = $arearows[0]->id;
					$areatitle = $arearows[0]->title;
				}
				if(($countryid !=''||$stateid !=''||$cityid !=''||$areaid !='')){
					$namesql = "select name from #__jsplocation_gplaces_temp where id = ".$id;
					$db->setQuery($namesql);
					$name_det = $db->loadObjectList();
					$name = $name_det[0]->name;
					$name = addslashes($name);
					$query = "INSERT INTO #__jsplocation_branch (branch_name,address1,latitude,longitude,lat_long_override,zip,area_id,city_id,state_id,country_id,category_id,contact_person,gender,email,website,contact_number,description,facebook,twitter,published) VALUES('".$name."','".$addresslashdetail."','".$latitude."','".$longitude."','','".$zipcode."','".$areaid."','".$cityid."','".$stateid."','".$countryid."','','','','','','','','','','1')";	
					$db->setQuery($query);
					$db->query($query);
				}
			}
		}
	}
?>