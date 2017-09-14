<?php
error_reporting(0);
/**
 * JSP Location components for Joomla!
 * JSP Location is an interactive store locator
 *
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2016
 * @package     JSP Store Locator 2.2
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: jsplocation.php  $
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.model');
class jsplocationModeljspLocation extends JModelLegacy{
function categoryList(){
		
		$db =& $this->getDBO();
		$query = "SELECT id,title from #__jsplocation_category where published = 1 ORDER BY title ASC";
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		return $rows;
	}

	function countryList(){
		$db =& $this->getDBO();
		$query = "SELECT id,title from #__jsplocation_country where published = 1 ORDER BY title ASC";
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		return $rows;
	}
	
	function stateList($country_id){
		$db =& $this->getDBO();
		$query = "SELECT id,title,country_id from #__jsplocation_state where published = 1";
		if($country_id > 0){
			$query .= " and country_id=$country_id";
		}
		$query .= " ORDER BY title ASC";	
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		return $rows;
 	}
	
	function cityList($state_id){
		$db =& $this->getDBO();
		$query = "SELECT id,title,state_id from #__jsplocation_city where published = 1";
		if($state_id > 0){
			$query .= " and state_id=$state_id";
		}
		$query .= " ORDER BY title ASC";
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		return $rows;
 	}
	
 	function areaList($city_id){
    	$db =& $this->getDBO();
    	$query = "SELECT id,title,city_id from #__jsplocation_area where published = 1";
		if($city_id > 0){
			$query .= " and city_id=$city_id";
		}
		$query .= " ORDER BY title ASC";
 		$db->setQuery($query);
    	$rows = $db->loadObjectList();
    	return $rows;
 	}
	
	function getParams(){
		$db =& $this->getDBO();
    	$query = "SELECT * from #__jsplocation_configuration where id = 1";
 		$db->setQuery($query);
    	$configParams = $db->loadObjectList();
		//print_r($configParams);
		//exit();
		return $configParams;
	}
	
	function getMapLanguage(){
            $db =& $this->getDBO();
            $lang_select = "SELECT language_local from #__jsplocation_configuration where id = 1";
            $db->setQuery($lang_select);
    	    $langParams = $db->loadObjectList();
            //print_r($langParams[0]->language_local);die;
            $lang_name = $langParams[0]->language_local;
            $map_lang_select = "SELECT map_language_code from #__jsplocation_map_lang where map_language = '".$lang_name."'";
            $db->setQuery($map_lang_select);
            $lang_code = $db->loadObjectList();
            return $lang_code;
        }
		
	function displayJsearch($task,$category_id,$country_id,$state_id,$city_id,$area_id,$zipsearch,$radius,$limit,$limitstart){
	
		
		$limitstart = ( $limit != 0 ? (floor($limitstart / $limit) * $limit) : 0 );
		$mainframe = Jfactory::GetApplication();          				// For calling menu params
		global $search;
		$params = &$mainframe->getParams();
		$this->params=$params;

		$db =& $this->getDBO();                          				// For calling extension params
    	$query = "SELECT * from #__jsplocation_configuration where id = 1";
		
 		$db->setQuery($query);
    	$configParams = $db->loadObjectList();
		
	   $search_radius =  $configParams[0]->search_radius;
	   $search_radius_status =  $configParams[0]->search_radius_status;
		
		
		$count="";
		$orderby = "";
		
		if($category_id >= 0 || $country_id >= 0 || $state_id >= 0 || $city_id >= 0 || $area_id >= 0 || $zipsearch=='ZIP/Postal Code') 		// Query to search locations if any drop-down is selected
		{
			if($category_id > 0){
				$where[] = " b.category_id RLIKE '[[:<:]]".$category_id."[[:>:]]'";
				$count = count($where);
			}
			
			if($country_id > 0){
				$where[] = " b.country_id=$country_id";
				$count = count($where);
			}
			
			if($state_id > 0){
				$where[] = " b.state_id=$state_id";
				$count = count($where);
			}
			
			if($city_id > 0){
				$where[] = " b.city_id=$city_id";
				$count = count($where);
			}
					
			if($area_id > 0){
				$where[] = " b.area_id=$area_id";
				$count = count($where);
			}

			$where = ($count ? ' WHERE '.implode(' AND ', $where) : '');
			
			$query = 'SELECT area.title as area_name, 
			city.title as city_name, 
			state.title as state_name, 
			country.title as country_name, 
			b.* from #__jsplocation_branch b 
			LEFT JOIN #__jsplocation_area area on area.id = b.area_id 
			LEFT JOIN #__jsplocation_city city on city.id = b.city_id 
			LEFT JOIN #__jsplocation_state state on state.id = b.state_id 
			LEFT JOIN #__jsplocation_country country on country.id = b.country_id'.$where;

			if($where == ''){
                $query .=" where  b.published = 1";
				$query .=" ORDER BY b.branch_name ASC";
    		}else{
   				$query .=" and b.published = 1";
				$query .=" ORDER BY b.branch_name ASC";
    		}
		}

		if(($zipsearch!=JText::_('POSTAL_CODE')) and ($zipsearch!=''))				// Query to search locations according to the entered zip code
		{
			
			
						
			$zip_hit=$zipsearch;											// Condition to enter values in zip hit graph start here
			if(isset($zip_hit))
			{
				$i=0;
				$date=date("Y-m-d");
				$sql = $db->getQuery(true);
				//$sql="SELECT `hits` from `#__jsplocation_ziphits` WHERE `zip` = '$zip_hit' AND `date` = '$date'";
                $zip_hit = str_replace(array("'", '"'), $val);
                $sql->select($db->quoteName(array('hits')));
                $sql->from($db->quoteName('#__jsplocation_ziphits'));
                $sql->where($db->quoteName('zip') .'=' . $db->quote($zip_hit).'AND'. $db->quote('date').'='.$db->quote($date));
				
												
				$db->setQuery($sql);
				$hitsearch=$db->loadObjectList();
				
				if(isset($hitsearch) and $hitsearch != NULL)
				{
					foreach($hitsearch as $item)
					{
					$i=$item->hits;
					$i++;
					}
					$sql1="UPDATE `#__jsplocation_ziphits` SET `hits` = ".$i." WHERE `zip` = '$zip_hit'  AND `date` = '$date'";
					$db->setQuery($sql1);
					$db->query();
				}
				
				else
				{
					$i++;
					$sql2 = "INSERT INTO `#__jsplocation_ziphits` ( `zip`, `hits`, `date`) VALUES ( '$zip_hit', '$i', '$date') ";
					$db->setQuery($sql2);
					$db->query();
				}
			}																			// Condition to enter values in zip hit graph ends here
			
			$dbCountries = $this->countryList();
			$dbCountry1 = "";
			
			foreach($dbCountries as $dbCountry)
			{
				$dbCountry='"'.ucwords(strtolower($dbCountry->title)).'"'.',';
				$dbCountry1.= $dbCountry;
			}
			$dbCountry1  = $dbCountry1.'**'; 
			$dbCountries = str_replace(",**","",$dbCountry1);
			
			$postal 	= explode(" ",$zipsearch);
			$postal		= $postal[0];
			
			$zipsearch 	= str_replace(" ","%20",$zipsearch);
			$dbCountries = str_replace(' ',"%20",$dbCountries);
			$dbCountries = str_replace('"',"%22",$dbCountries);
			$dbCountries = str_replace(',',"%2C",$dbCountries);
			$dbCountries = str_replace('&',"%26",$dbCountries);
			
			//$geocode 	= file_get_contents("http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20geo.places%20where%20text%3D%22$zipsearch%22%20and%20postal%20LIKE%20%22$postal%25%22%20and%20country%20IN%20($dbCountries)&format=json");
			
			/*--- Original Yahoo Query ----*/
			
		    //$geocode 	= $this->file_get_contents_curls( "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20geo.places%20where%20text%3D%22$zipsearch%22%20and%20postal%20LIKE%20%22$postal%25%22%20and%20country%20IN%20($dbCountries)&format=json" );
			
			/*--- Original Yahoo Query ----*/
			
			/*--- Yahoo Query to search by place ---*/
					
			//$geocode 	= $this->file_get_contents_curls( "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20geo.placefinder%20where%20text%3D%22$zipsearch%22&format=json");
			
			$geocode 	= $this->file_get_contents_curls("http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20geo.places%20where%20text%3D%22$zipsearch%22&format=json");
									
			/*--- Yahoo Query to search by place ---*/
			
			$output = json_decode($geocode);
			
			$CountryCount = $output->query->count;
							
			$temp = array();
			
			if($CountryCount == 1){
						
			/*-- Calculate distance between two points to find radius ---*/
						
			$latfrom = $output->query->results->place->boundingBox->southWest->latitude;
			$latto = $output->query->results->place->boundingBox->northEast->latitude;
			$longfrom = $output->query->results->place->boundingBox->southWest->longitude;
			$longto = $output->query->results->place->boundingBox->northEast->longitude;
			
			
			if($search_radius_status == 'No'){
			$distance = $this->haversineGreatCircleDistance($latfrom,$longfrom,$latto,$longto,$earthRadius = 3959);
			
			$radius = $distance;
			
			
			}
			else{
			$radius = $search_radius;
			
			
			}
						
			//$radius = 100;
			
			$lat = $output->query->results->place->centroid->latitude;
			$long = $output->query->results->place->centroid->longitude;
					
			//$lat = $output->query->results->Result[$i]->latitude;
			//$long = $output->query->results->Result[$i]->longitude;
									
			$temp1= $this->multiCountries($lat, $long, $radius);
			$temp =array_merge($temp1, $temp);
												
			$search = $temp;

			if(empty($search)){
			
			$geocode 	= $this->file_get_contents_curls("https://maps.googleapis.com/maps/api/geocode/json?address=$zipsearch");

			$output = json_decode($geocode);
	
			if($output->status == 'ZERO_RESULTS'){
			$search = $temp;
			
			}
			// if(isset($output['results'])){
			else{
			
			$latfrom = $output->results[0]->geometry->bounds->southwest->lat;
			$latto = $output->results[0]->geometry->bounds->northeast->lat;
			$longfrom = $output->results[0]->geometry->bounds->southwest->lng;;
			$longto = $output->results[0]->geometry->bounds->northeast->lng;
			
				if($search_radius_status == 'No'){
			$distance = $this->haversineGreatCircleDistance($latfrom,$longfrom,$latto,$longto,$earthRadius = 3959);
			
			$radius = $distance;
			
			
			}
			else{
			$radius = $search_radius;
			
			
			}
		
			
			$lat = $output->results[0]->geometry->location->lat;
			$long = $output->results[0]->geometry->location->lng;
					
			$temp1= $this->multiCountries($lat, $long, $radius);
			$temp =array_merge($temp1, $temp);
												
			$search = $temp;
}
			// }

			}
			return $search;
			
			}
			
			if($CountryCount>1)
			{
				// $radius_in_sqkm = $output->query->results->Result[0]->radius;
				// $radius = sqrt($radius_in_sqkm);
				
				//$radius = 100;
			
				for($i=0; $i<$CountryCount; $i++)
				{
					$lat = $output->query->results->place[$i]->centroid->latitude;
					$long = $output->query->results->place[$i]->centroid->longitude;
					
			/*-- Calculate distance between two points to find radius ---*/
						
			$latfrom = $output->query->results->place[$i]->boundingBox->southWest->latitude;
			$latto = $output->query->results->place[$i]->boundingBox->northEast->latitude;
			$longfrom = $output->query->results->place[$i]->boundingBox->southWest->longitude;
			$longto = $output->query->results->place[$i]->boundingBox->northEast->longitude;
			
				if($search_radius_status == 'No'){
			$distance = $this->haversineGreatCircleDistance($latfrom,$longfrom,$latto,$longto,$earthRadius = 3959);
			
			$radius = $distance;
			
			
			}
			else{
			$radius = $search_radius;
			
			
			}

			$temp1= $this->multiCountries($lat,$long,$radius);
			$temp =array_merge($temp1,$temp);
			
			}
												
			$search = $temp;

			if(empty($search)){
			
			$geocode 	= $this->file_get_contents_curls("https://maps.googleapis.com/maps/api/geocode/json?address=$zipsearch");

			$output = json_decode($geocode);
	
			if($output->status == 'ZERO_RESULTS'){
			$search = $temp;
			
			}
			else{
			
			$latfrom = $output->results[0]->geometry->bounds->southwest->lat;
			$latto = $output->results[0]->geometry->bounds->northeast->lat;
			$longfrom = $output->results[0]->geometry->bounds->southwest->lng;;
			$longto = $output->results[0]->geometry->bounds->northeast->lng;
			
				if($search_radius_status == 'No'){
			$distance = $this->haversineGreatCircleDistance($latfrom,$longfrom,$latto,$longto,$earthRadius = 3959);
			
			$radius = $distance;
			
			
			}
			else{
			$radius = $search_radius;
			
			
			}
		
			
			$lat = $output->results[0]->geometry->location->lat;
			$long = $output->results[0]->geometry->location->lng;
					
			$temp1= $this->multiCountries($lat, $long, $radius);
			$temp =array_merge($temp1, $temp);
												
			$search = $temp;
            }
		

			}


			return $search;
			}
						
			// $lat		= (isset($output->query->results->Result->latitude) == 1) ? $lat = $output->query->results->Result->latitude : $lat = "";
			// $long		= (isset($output->query->results->Result->longitude) == 1) ? $long = $output->query->results->Result->longitude : $long = "";

			$lat		= (isset($output->query->results->place->centroid->latitude) == 1) ? $lat = $output->query->results->Result->latitude : $lat = "";
			$long		= (isset($output->query->results->place->centroid->longitude) == 1) ? $long = $output->query->results->Result->longitude : $long = "";

			if($lat=='' and $long=='')
			{
				$search="";
				return $search;
			} 
			
			$units		= ($this->radiusRange() != 'Yes') ? $units = "6371" : $units = "3959";
									
			$radius_in_sqkm = $output->query->results->Result->radius;
			
			$radius = sqrt($radius_in_sqkm);
									
			//$radius=100;

			$query="SELECT area.title as area_name, 
			city.title as city_name, 
			state.title as state_name, 
			country.title as country_name, 
			b.*, IFNULL(( $units * acos( cos( radians($lat) ) * cos( radians( IF(lat_long_override>0,lat_ovr,latitude) ) ) 
			* cos( radians( IF(lat_long_override>0,long_ovr,longitude) ) - radians($long) ) + sin( radians($lat) ) * 
			sin( radians( IF(lat_long_override>0,lat_ovr,latitude) ) ) ) ),0) AS distance FROM #__jsplocation_branch b 
			LEFT JOIN #__jsplocation_area area on area.id = b.area_id 
			LEFT JOIN #__jsplocation_city city on city.id = b.city_id 
			LEFT JOIN #__jsplocation_state state on state.id = b.state_id 
			LEFT JOIN #__jsplocation_country country on country.id = b.country_id 
			where b.published = '1' HAVING distance < $radius ORDER BY distance ASC";
		
			
		}
		
		if($task!='search')														// Default Page Load Query
		{
			if($query=='')														// Condition to check if any previous query is not loaded (example: if category is selected from menu item)
			{
				$query = "SELECT area.title as area_name, 
				city.title as city_name, 
				state.title as state_name, 
				country.title as country_name, 
				b.* from #__jsplocation_branch b 
				LEFT JOIN #__jsplocation_area area on area.id = b.area_id 
				LEFT JOIN #__jsplocation_city city on city.id = b.city_id 
				LEFT JOIN #__jsplocation_state state on state.id = b.state_id 
				LEFT JOIN #__jsplocation_country country on country.id = b.country_id 
				where b.published = 1 ORDER BY branch_name ASC";
			}
						
			$db->setQuery($query);												//SetQuery to find out total number of records for pagination
			$countrows = count($db->loadObjectList());
			
			if($limitstart >= $countrows)
			{
				$limitstart = 0;
			}	
			
			if(isset($limit) && isset($limitstart))
			{
				$db->setQuery($query,$limitstart,$limit);						//SetQuery to search results with pagination
			}	
			
			else
			{
				$db->setQuery($query);											//SetQuery to search results with pagination where number of result is less then pagination limit
			}
			
			$search=$db->loadObjectList();
			
			if($countrows > 0)
			{
		 		$search[0]->totalresult = $countrows;							//Assign count value of search result to be used in view.html.php
			}
		}
		
		if($task == 'search')      												// Any search going on
		{
			$db->setQuery($query);												//SetQuery to find out total number of records for pagination
			$countrows = count($db->loadObjectList());
			
			if($limitstart >= $countrows)
			{
				$limitstart = 0;
			}	
			
			if(isset($limit) && isset($limitstart))
			{	
				$db->setQuery($query,$limitstart,$limit);						//SetQuery to search results with pagination
			}	
			
			else
			{
				$db->setQuery($query);											//SetQuery to search results with pagination where number of result is less then pagination limit
			}
			
			$search=$db->loadObjectList();
			
			if($countrows > 0)
			{
		 		$search[0]->totalresult = $countrows;							//Assign count value of search result to be used in view.html.php
			}
      	}
		
		//echo $query
		return $search;
	}
	
	function haversineGreatCircleDistance(
  $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo,$earthRadius)
	{
	  // convert from degrees to radians
	  $latFrom = deg2rad($latitudeFrom);
	  $lonFrom = deg2rad($longitudeFrom);
	  $latTo = deg2rad($latitudeTo);
	  $lonTo = deg2rad($longitudeTo);

	  $latDelta = $latTo - $latFrom;
	  $lonDelta = $lonTo - $lonFrom;

	  $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
		cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
	  return $angle * $earthRadius;
	}

	function locateMe($task,$geolat,$geolong,$radius,$limit,$limitstart){
			
		$db =& $this->getDBO();
    	$query = "SELECT locateme_radius,radius_range  from #__jsplocation_configuration where id = 1";
		$db->setQuery($query);
    	$configParams = $db->loadObjectList();
		
		$lat  = $geolat;
		$long = $geolong;
		$units		= ($configParams[0]->radius_range != 'Yes') ? $units = "6371" : $units = "3959";
		
		$query="SELECT area.title as area_name, 
		city.title as city_name, 
		state.title as state_name, 
		country.title as country_name, 
		b.*, IFNULL(( $units * acos( cos( radians($lat) ) * cos( radians( IF(lat_long_override>0,lat_ovr,latitude) ) ) 
		* cos( radians( IF(lat_long_override>0,long_ovr,longitude) ) - radians($long) ) + sin( radians($lat) ) * 
		sin( radians( IF(lat_long_override>0,lat_ovr,latitude) ) ) ) ),0) AS distance FROM #__jsplocation_branch b 
		LEFT JOIN #__jsplocation_area area on area.id = b.area_id 
		LEFT JOIN #__jsplocation_city city on city.id = b.city_id 
		LEFT JOIN #__jsplocation_state state on state.id = b.state_id 
		LEFT JOIN #__jsplocation_country country on country.id = b.country_id 
		where b.published = '1' HAVING distance < $radius ORDER BY distance ASC";
		
		$db->setQuery($query);												//SetQuery to find out total number of records for pagination
		$countrows = count($db->loadObjectList());
			
		if($limitstart >= $countrows)
		{
			$limitstart = 0;
		}	
		
		if(isset($limit) && isset($limitstart))
		{
			$db->setQuery($query,$limitstart,$limit);						//SetQuery to search results with pagination
		}	
		
		else
		{
			$db->setQuery($query);											//SetQuery to search results with pagination where number of result is less then pagination limit
		}
		
		$search=$db->loadObjectList();
		
		if($countrows > 0)
		{
			$search[0]->totalresult = $countrows;							//Assign count value of search result to be used in view.html.php
			$search[0]->locateme = true;
			$search[0]->locatemeradius = $radius;
			$search[0]->latnow = $geolat;
			$search[0]->longnow = $geolong;
		}
		return $search;
	}
	
	function fieldDetails(){
		$db =& $this->getDBO();
		$query = "SELECT * from #__jsplocation_fields where published=1";
		$db->setQuery($query);
		$fieldDetails = $db->loadAssocList();
		return $fieldDetails;
	}
	
	function defaultAddress()
	{
		$mainframe = Jfactory::GetApplication();
	    $params = &$mainframe->getParams();
		$this->params=$params;
		
		$db =& $this->getDBO();
		$loc=$this->params->get('map_location');
		
		if($loc == '' || $loc == 0)
		{
			$query = "SELECT configuration.branch_id as branch_id,
			area.title as area_name, 
			city.title as city_name, 
			state.title as state_name, 
			country.title as country_name, 
			b.* from #__jsplocation_branch b 
			LEFT JOIN #__jsplocation_configuration configuration on configuration.branch_id = b.id 
			LEFT JOIN #__jsplocation_area area on area.id = b.area_id 
			LEFT JOIN #__jsplocation_city city on city.id = b.city_id 
			LEFT JOIN #__jsplocation_state state on state.id = b.state_id 
			LEFT JOIN #__jsplocation_country country on country.id = b.country_id 
			where configuration.branch_id = b.id";
    	}
		
		else
		{
			$query = "SELECT area.title as area_name, 
			city.title as city_name, 
			state.title as state_name, 
			country.title as country_name, 
			a.id as branch_id ,a.* from #__jsplocation_branch a 
			LEFT JOIN #__jsplocation_area area on area.id = a.area_id 
			LEFT JOIN #__jsplocation_city city on city.id = a.city_id 
			LEFT JOIN #__jsplocation_state state on state.id = a.state_id 
			LEFT JOIN #__jsplocation_country country on country.id = a.country_id 
			where a.id = ".$loc;
 		}
		
		$db->setQuery($query);
    	$defaultAddress = $db->loadObjectList();
		return $defaultAddress;
	}

	function multiCountries($lat, $long, $radius){
		$db =& $this->getDBO();
		$units		= ($this->radiusRange() != 'Yes') ? $units = "6371" : $units = "3959";
		
		//$radius = 100; 
		
		$query="SELECT area.title as area_name, 
		city.title as city_name, 
		state.title as state_name, 
		country.title as country_name, 
		b.*, IFNULL(( $units * acos( cos( radians($lat) ) * cos( radians( IF(lat_long_override>0,lat_ovr,latitude) ) ) 
		* cos( radians( IF(lat_long_override>0,long_ovr,longitude) ) - radians($long) ) + sin( radians($lat) ) * 
		sin( radians( IF(lat_long_override>0,lat_ovr,latitude) ) ) ) ),0) AS distance FROM #__jsplocation_branch b 
		LEFT JOIN #__jsplocation_area area on area.id = b.area_id 
		LEFT JOIN #__jsplocation_city city on city.id = b.city_id 
		LEFT JOIN #__jsplocation_state state on state.id = b.state_id 
		LEFT JOIN #__jsplocation_country country on country.id = b.country_id 
		where b.published = '1' HAVING distance < $radius ORDER BY distance ASC";
					
		
		$db->setQuery($query);
		$search=$db->loadObjectList();
		return $search;
	}
	
	function radiusRange(){
		$db =& $this->getDBO();
		$query = "SELECT radius_range from #__jsplocation_configuration
		where id = 1";
		$db->setQuery($query);
		$radiusRange=$db->loadObjectList();
		return $radiusRange;
	}

	function getcustomFeilds(){
		$db =& $this->getDBO();
		$query = "SELECT branch.branch_name AS branch_name, feilds.field_name AS feild_name,
		          feilds.map_display as map_display,
                  feilds.sidebar_display as sidebar_display,b . *
					FROM #__jsplocation_customfields b
					LEFT JOIN #__jsplocation_branch branch ON branch.id = b.branch_id
					LEFT JOIN #__jsplocation_fields feilds ON feilds.id = feild_id
					WHERE feilds.published =1
					AND feilds.predefined =0
					order by feild_id";
		$db->setQuery($query);
		$customfeildsinfo = $db->loadObjectList();
		return $customfeildsinfo;
	}
	
	function getManFeilds(){
		$db =& $this->getDBO();
		$query = "SELECT field_name, map_display, sidebar_display,published FROM #__jsplocation_fields WHERE predefined =1";
		$db->setQuery($query);
		$manfeildsinfo = $db->loadObjectList();
		return $manfeildsinfo;
	}
	
	function getdescfields($id){
			
		$db =& $this->getDBO();
		$query = "SELECT branch_name,youtube_url,vimeo_url,description,imagename,image_display FROM #__jsplocation_branch WHERE id =".$id;
						
		$db->setQuery($query);
		$descinfo = $db->loadObjectList();
		
		return $descinfo;
	}

	function file_get_contents_curls($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	function branchdetails($id){
		$db =& $this->getDBO();
		$query = "SELECT * FROM #__jsplocation_branch WHERE id =".$id;
		$db->setQuery($query);
		$branchdetails = $db->loadObjectList();
		return $branchdetails;
	}
	function getCityName($cityID){
		$db =& $this->getDBO();
		$query = "SELECT title FROM #__jsplocation_city WHERE id =".$cityID;
		$db->setQuery($query);
		$branchdetails = $db->loadObjectList();
		return $branchdetails;
	}
	function getDefaultFieldStatus(){
		$db =& $this->getDBO();
		$query = "SELECT published FROM #__jsplocation_fields WHERE id IN(2,4,5,6,7)";
		$db->setQuery($query);
		$getDefaultFieldStatus = $db->loadObjectList();
		return $getDefaultFieldStatus;
	}
	function branchlist(){
        $db =& $this->getDBO();
				
        $query = "SELECT id,branch_name,city_id,country_id FROM #__jsplocation_branch";
        $db->setQuery($query);
        $branchdetails = $db->loadObjectList();
        
        $branchlist = array();
        
        for($i=0;$i<count($branchdetails);$i++){
        
            $branchid = $branchdetails[$i]->id;
        
            $branchname = $branchdetails[$i]->branch_name;
        
            $cityid = $branchdetails[$i]->city_id;
            
            $cityquery = "SELECT title FROM #__jsplocation_city where id=".$cityid;
            $db->setQuery($cityquery);
            $cityname = $db->loadObjectList();
            
            
            $countryid = $branchdetails[$i]->country_id;
            
            $countryquery = "SELECT title FROM #__jsplocation_country where id=".$countryid;
            $db->setQuery($countryquery);
            $countryname = $db->loadObjectList();
            
            $branchlist[$i]['id'] = $branchid;
            $branchlist[$i]['branchname'] = $branchname;
            $branchlist[$i]['cityname'] = $cityname;
            $branchlist[$i]['countryname'] = $countryname;
        }
        
        
        return $branchlist;
    }
	
	function selectedcategorybranchlist($selectedCategory){
						
        $db =& $this->getDBO();
		
		$query = "SELECT id FROM #__jsplocation_category where title='".$selectedCategory."'";
        $db->setQuery($query);
        $category_id = $db->loadObjectList();
		
		
		$category_id = $category_id[0]->id;
				
        $query = "SELECT id,branch_name,city_id,country_id FROM #__jsplocation_branch where category_id=".$category_id;
        $db->setQuery($query);
        $branchdetails = $db->loadObjectList();
        
        $selectedcategorybranchlist = array();
        
        for($i=0;$i<count($branchdetails);$i++){
        
            $branchid = $branchdetails[$i]->id;
        
            $branchname = $branchdetails[$i]->branch_name;
        
            $cityid = $branchdetails[$i]->city_id;
            
            $cityquery = "SELECT title FROM #__jsplocation_city where id=".$cityid;
            $db->setQuery($cityquery);
            $cityname = $db->loadObjectList();
            
            
            $countryid = $branchdetails[$i]->country_id;
            
            $countryquery = "SELECT title FROM #__jsplocation_country where id=".$countryid;
            $db->setQuery($countryquery);
            $countryname = $db->loadObjectList();
            
            $selectedcategorybranchlist[$i]['id'] = $branchid;
            $selectedcategorybranchlist[$i]['branchname'] = $branchname;
            $selectedcategorybranchlist[$i]['cityname'] = $cityname;
            $selectedcategorybranchlist[$i]['countryname'] = $countryname;
        }
		
		
		       
        return $selectedcategorybranchlist;
    }
		
	function allcategory(){
	
		$db =& $this->getDBO();
        $query = "SELECT title FROM #__jsplocation_category";
        $db->setQuery($query);
        $categorylist = $db->loadObjectList();
		
		 return $categorylist;
		
	}
	
	function getlatlng($storeid){
	
	$db =& $this->getDBO();
     $query = "SELECT latitude,longitude FROM #__jsplocation_branch where id=".$storeid;
     $db->setQuery($query);
     $latlngobj = $db->loadObjectList();
		
	return $latlngobj;
	
	}
	
	
	
}
?>
