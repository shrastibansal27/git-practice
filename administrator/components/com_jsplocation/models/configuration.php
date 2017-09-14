<?php
	/**
		* JSP Location components for Joomla!
		* JSP Location is an interactive store locator
		*
		* @author      $Author: Ajay Lulia $
		* @copyright   Joomla Service Provider - 2016
		* @package     JSP Store Locator 2.2
		* @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
		* @version     $Id: configuration.php  $
	*/
	// no direct access
	defined( '_JEXEC' ) or die( 'Restricted access' );
	include('reader.php');
	require_once 'Classes/PHPExcel.php';
	jimport( 'joomla.application.component.model' );
	class jspLocationModelConfiguration extends JModelLegacy {
		function getParams()
		{
			$db = $this->getDBO();
			$query = "SELECT * from #__jsplocation_configuration where id = 1";
			$db->setQuery($query);
			$rows = $db->loadAssoc();
			return $rows;
		}
		function branchList()
		{
			$db = $this->getDBO();
			$query = "SELECT id,branch_name from #__jsplocation_branch where published = 1";
			$query .= " ORDER BY branch_name asc";
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			return $rows;
		}
		function enterImagename($newfilename)
		{
			$db = $this->getDBO();
			echo $query = "UPDATE #__jsplocation_configuration SET imagename= '".$newfilename."'";
			$db->setQuery($query);
			$db->query();
			return;
			
		}
		function getImagename($brId) {
			$db = $this->getDBO();
			if ($brId == 0){
				$query = "select imagename from #__jsplocation_configuration where id = 1"; 
			}
			else
			{
				$query = "select imagename from #__jsplocation_branch where id = ".$brId; 
			}
			$db->setQuery($query);
			$rows = $db->loadObjectList();
			return $rows;
		}
		function getMapLanguage(){
			$db = $this->getDBO();
			$lang_query = "SELECT * from #__jsplocation_map_lang";
			$db->setQuery($lang_query);
			$result = $db->loadObjectList();
			return $result;
		}
		function getMapLanguageData(){
			$db = $this->getDBO();
			$lang_query_data = "SELECT language_local from #__jsplocation_configuration where id = 1";
			$db->setQuery($lang_query_data);
			$lang_name_array = $db->loadObjectList();
			$lang_name = $lang_name_array[0]->language_local;
			$lang_query_code = "SELECT map_language_code from #__jsplocation_map_lang where map_language = '".$lang_name."'";
			$db->setQuery($lang_query_code);
			$lang_code = $db->loadObjectList();
			$result = $lang_code[0]->map_language_code;
			return $result;
		}
		function importlocationdetails($filepath)
		{
			$db = $this->getDBO();
			$ext = strtolower(substr(strrchr($filepath, "."), 1));
			$session = JFactory::getSession();
			$filepath = str_replace('\\', '/', $filepath);
			if (file_exists($filepath)){
				if(($ext == 'xls' || $ext == 'xlsx')){
					$excel = new Spreadsheet_Excel_Reader();
					$excel->read($filepath);    
					$column1 ='';
					$x=2;
					$branchname=array();
					$flag = '';
					$count =0;
					$importedlocations = 0;
					/* If whole row is empty then skip the row */
					while($x<=$excel->sheets[0]['numRows']){
						if (!isset($excel->sheets[0]['cells'][$x])) {
							$x++;
							continue;
						}
						$emailvar =array();
						$flag = '';
						$column1 = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : '';
						$column2= isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : '';
						$column3= isset($excel->sheets[0]['cells'][$x][3]) ? $excel->sheets[0]['cells'][$x][3] : '';
						$column4 = isset($excel->sheets[0]['cells'][$x][4]) ? $excel->sheets[0]['cells'][$x][4] : '';
						$column5 = isset($excel->sheets[0]['cells'][$x][5]) ? $excel->sheets[0]['cells'][$x][5] : '';
						$column6 = isset($excel->sheets[0]['cells'][$x][6]) ? $excel->sheets[0]['cells'][$x][6] : '';//area
						$column7 = isset($excel->sheets[0]['cells'][$x][7]) ? $excel->sheets[0]['cells'][$x][7] : '';//city 
						$column8 = isset($excel->sheets[0]['cells'][$x][8]) ? $excel->sheets[0]['cells'][$x][8] : '';//state
						$column9 = isset($excel->sheets[0]['cells'][$x][9]) ? $excel->sheets[0]['cells'][$x][9] : ''; //country
						$column10 = isset($excel->sheets[0]['cells'][$x][10]) ? $excel->sheets[0]['cells'][$x][10] : '';
						$column11 = isset($excel->sheets[0]['cells'][$x][11]) ? $excel->sheets[0]['cells'][$x][11] : '';
						$column12 = isset($excel->sheets[0]['cells'][$x][12]) ? $excel->sheets[0]['cells'][$x][12] : '';
						$column13 = isset($excel->sheets[0]['cells'][$x][13]) ? $excel->sheets[0]['cells'][$x][13] : '';
						$column14 = isset($excel->sheets[0]['cells'][$x][14]) ? $excel->sheets[0]['cells'][$x][14] : '';
						$column15 = isset($excel->sheets[0]['cells'][$x][15]) ? $excel->sheets[0]['cells'][$x][15] : '';
						$column16 = isset($excel->sheets[0]['cells'][$x][16]) ? $excel->sheets[0]['cells'][$x][16] : '';
						$column17 = isset($excel->sheets[0]['cells'][$x][17]) ? $excel->sheets[0]['cells'][$x][17] : '';
						$column18 = isset($excel->sheets[0]['cells'][$x][18]) ? $excel->sheets[0]['cells'][$x][18] : '';
						$column19 = isset($excel->sheets[0]['cells'][$x][19]) ? $excel->sheets[0]['cells'][$x][19] : '';
						/* $column1 = preg_replace('/[^A-Za-z0-9\-]/', '', $column1);
							$column2 = preg_replace('/[^A-Za-z0-9\-]/', '', $column2);
						$column16 = preg_replace('/[^A-Za-z0-9\-]/', '', $column16); */
						$column1 = addslashes($column1);
						$column2 = addslashes($column2);
						$column16 = addslashes($column16);
						/* Validation for latitude*/
						// if(preg_match('/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}$/', $column3)){
						// }
						// else{
						// $flag = '1';
						// }
						/* Validation for longitude */
						// if(preg_match("/^-?([1]?[1-7][1-9]|[1]?[1-8][0]|[1-9]?[0-9])\.{1}\d{1,6}$/", $column4)){
						// }
						// else{
						// $flag = '1';
						// }
						/* Validation for phone number */
						if($column15 !=''){
							$column15= preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $column15);
							if(preg_match('/^([0-9\(\)\/\+ \-]*)$/',$column15)){
							}
							else{
								$flag = '1';
							}
						}
						/* Validation for email */
						if($column13 !=''){
							$column13= preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $column13);
							if(filter_var($column13, FILTER_VALIDATE_EMAIL)){
							}
							else{
								$flag = '1';
							}
						}
						/* Check whether branch name,country,state,city,area,latitude,longitude are not blank */
						if(($column6!= '')&& ($column7!= '') &&($column8!= '') &&($column9!= '') &&($column1!= '')&& ($column3!= '') && ($column4!= ''))
						{
							/* inserting data into database */
							/*inserting country */
							$column9 = preg_replace('/[^\P{C}\n]+/u','',$column9);
							$countryquery ="SELECT title FROM #__jsplocation_country where title ='".$column9."'";
							$db->setQuery($countryquery);
							$countryrows = $db->loadObjectList();
							if(empty($countryrows)){
								$insertdata =1;
								$countrysql="INSERT INTO #__jsplocation_country (title,published) VALUES('".$column9."','".$column19."')";
								$db->setQuery($countrysql);
								$db->query($countrysql);
							}
							$countryquery ="SELECT id FROM #__jsplocation_country where title ='".$column9."'";
							$db->setQuery($countryquery);
							$countryrows = $db->loadObjectList();
							$countryid =$countryrows[0]->id;
							/*inserting state */
							$column8 = preg_replace('/[^\P{C}\n]+/u','',$column8);
							$statecheck = "SELECT * from #__jsplocation_state where title='".$column8."' AND country_id=".$countryid;
							$db->setQuery($statecheck);
							$statecheckrows = $db->loadObjectList();
							if(empty($statecheckrows)){
								$statesql="INSERT INTO #__jsplocation_state (title,published,country_id) VALUES('".$column8."','".$column19."','".$countryid."')";
								$db->setQuery($statesql);
								$db->query($statesql);
							}
							$statequery ="SELECT id FROM #__jsplocation_state where title ='".$column8."'";
							$db->setQuery($statequery);
							$staterows = $db->loadObjectList();
							$stateid =$staterows[0]->id;
							/*inserting city */
							$column7 = preg_replace('/[^\P{C}\n]+/u','',$column7);
							$citycheck = "SELECT * from #__jsplocation_city where title='".$column7."' AND country_id='".$countryid."'AND state_id=".$stateid;
							$db->setQuery($citycheck);
							$citycheckrows = $db->loadObjectList();
							if(empty($citycheckrows)){
								$citysql="INSERT INTO #__jsplocation_city (title,published,country_id,state_id) VALUES('".$column7."','".$column19."','".$countryid."','".$stateid."')";
								$db->setQuery($citysql);
								$db->query($citysql);
							}
							$cityquery ="SELECT id FROM #__jsplocation_city where title ='".$column7."'";
							$db->setQuery($cityquery);
							$cityrows = $db->loadObjectList();
							$cityid =$cityrows[0]->id;
							/*inserting area */
							$column6 = preg_replace('/[^\P{C}\n]+/u','',$column6);
							$areacheck = "SELECT * from #__jsplocation_area where title='".$column6."' AND country_id='".$countryid."' AND city_id='".$cityid."' AND state_id=".$stateid;
							$db->setQuery($areacheck);
							$areacheckrows = $db->loadObjectList();
							if(empty($areacheckrows)){
								$areasql="INSERT INTO #__jsplocation_area (title,published,country_id,state_id,city_id) VALUES('".$column6."','".$column19."','".$countryid."','".$stateid."','".$cityid."')";
								$db->setQuery($areasql);
								$db->query($areasql);
							}
							$areaquery ="SELECT id FROM #__jsplocation_area where title ='".$column6."'";
							$db->setQuery($areaquery);
							$arearows = $db->loadObjectList();
							$areaid =$arearows[0]->id;
							/* If any one is blank then do not insert in database */
							if(($countryid ==''||$stateid ==''||$cityid ==''||$areaid =='')||($flag =='1')){
								$branchname[] =$column1;
								$count++;
							}
							else{
								$query = "INSERT INTO #__jsplocation_branch (branch_name,address1,latitude,longitude,lat_long_override,zip,area_id,city_id,state_id,country_id,category_id,contact_person,gender,email,website,contact_number,description,facebook,twitter,published) VALUES('".$column1."','".$column2."','".$column3."','".$column4."','".$lat_long_override."','".$column5."','".$areaid."','".$cityid."','".$stateid."','".$countryid."','".$column10."','".$column11."','".$column12."','".$column13."','".$column14."','".$column15."','".$column16."','".$column17."','".$column18."','".$column19."')";			
								$db->setQuery($query);
								$db->query($query);
								$importedlocations++;
							}
						}
						else{
							/* If branch name,country,state,city,area are blank increase "locations not imported" count */
							$branchname[] =$column1;
							$count++;
						}
						$x++;
					}
					if($count!=0)
					{
						$branchname['notimportedlocationcount'] = $count;
					}
					fclose($handle);
					/* If no locations are imported return 0 */
					if($importedlocations == 0){
						return 0;
						
					}
					if(!empty($branchname)){
						return $branchname;
					}
					else{
						return 1;
					}	
				}
				else{
					return 0;
				}
			}
			else{
				return 0;
			}
		}
		function exportlocations(){
			$mainframe =JFactory::GetApplication();
			$db = $this->getDBO();
			$sql = "SELECT b.branch_name,b.address1,b.latitude,b.longitude,b.zip,a.title AS area,ci.title AS city,s.title AS state,c.title AS country,b.category_id,b.contact_person,b.gender,b.email,b.website,b.contact_number,b.description,b.facebook,b.twitter,b.published
			FROM #__jsplocation_branch AS b
			LEFT JOIN #__jsplocation_area AS a ON b.area_id =a.id
			LEFT JOIN #__jsplocation_city AS ci ON b.city_id=ci.id
			LEFT JOIN #__jsplocation_state AS s ON b.state_id =s.id
			LEFT JOIN #__jsplocation_country AS c ON b.country_id=c.id";
			$db->setQuery($sql);
			$result = $db->loadObjectList();
			// Instantiate a new PHPExcel object 
			$objPHPExcel = new PHPExcel();  
			// Set the active Excel worksheet to sheet 0 
			$objPHPExcel->setActiveSheetIndex(0);  
			// Initialise the Excel row number 
			$rowCount = 1;  
			//start of printing column names as names of MySQL fields  
			$column = 'A';
			$properties = get_object_vars($result[0]);
			$columns = array_keys($properties);
			foreach($columns as $header ){
				$var =$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount,$header);
				$column++;
			}
			$valuedata =$db->loadRowList();
			$rowCount = 2;
			foreach($valuedata as $records){
				$column = 'A';
				foreach($records as $data){
					if(!isset($data)) 
					$value = NULL; 
					elseif ($records != "") 
					$value = strip_tags($data);
					else 
					$value = "";  
					$objPHPExcel->getActiveSheet()->setCellValue($column.$rowCount, $value);
					$column++;
				}
				$rowCount++;
			}
			// /*Redirect output to a client’s web browser (Excel5) */
			ob_end_clean();
			header("Content-Type: text/plain; charset=ISO-8859-1");
			//header("Content-type: text/xls; charset=UTF-8");
			header('Content-Type: application/vnd.ms-excel'); 
			header('Content-Disposition: attachment;filename="Locations.xls"'); 
			header('Cache-Control: max-age=0'); 
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
			$objWriter->save('php://output');
			die;
		}
	}
