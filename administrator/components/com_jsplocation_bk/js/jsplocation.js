/* Start AjaxObj Code */ 
var maptype='';
var AjaxObj = new Object();
AjaxObj.showMessage=1;
AjaxObj.Message='';
AjaxObj.favouriteId = 0;
AjaxObj.Request = function(url, callbackMethod)
{
	AjaxObj.request = AjaxObj.createRequestObject();
	AjaxObj.request.onreadystatechange = callbackMethod;
	AjaxObj.request.open("POST", url, true);
	AjaxObj.request.send(url);
}
AjaxObj.setMessage = function (message)
{
	AjaxObj.Message=message;
}
AjaxObj.setShowMessage = function (m)
{
	AjaxObj.showMessage=m;
}
AjaxObj.createRequestObject = function()
{
	var obj;
	if(window.XMLHttpRequest)
	{
		obj = new XMLHttpRequest();
	}
	else if(window.ActiveXObject)
	{
		obj = new ActiveXObject("MSXML2.XMLHTTP");
	}
	return obj;
}
AjaxObj.CheckReadyState = function(obj)
{
	if( obj.readyState == 4 )
	{	
		return true;
	} 
	return false;
}

/* End AjaxObj Code */ 



function showStates() {

	var countryId = document.getElementById("country_id");
    selectedCountryId = countryId.value;
	var strParam="index.php?option=com_jsplocation&controller=city&task=getState&country="+ selectedCountryId;
	AjaxObj.Request(strParam, generateStatesarea);
    return false;
}


function generateStatesarea() {
	var stateObj = document.getElementById("state_id");	
	stateObj.options.length = 0;
	stateObj.options[0] = new Option("Select State","Select State");
	
	var cityObj = document.getElementById("city_id");
	cityObj.options.length = 0;
	cityObj.options[0] = new Option("Select City","Select City");
	
	if(AjaxObj.CheckReadyState(AjaxObj.request)){
		stateDetails = AjaxObj.request.responseText;
		if(stateDetails != ""){
			state=stateDetails.split("*");
			totalRows = state.length;
			for (var i =0;i<totalRows; i++) {
				var stateValueStr = state[i];
				stateValues=stateValueStr.split("|");
				stateObj.options[stateObj.length] = new Option(stateValues[1],stateValues[0]);
			}
		}
	}
}

function showStatesSite() {
	var countryId = document.getElementById("country_id");
    selectedCountryId = countryId.value;
	var strParam="index.php?option=com_jsplocation&controller=city&task=getState&country="+ selectedCountryId;
	AjaxObj.Request(strParam, generateStatesSite);
    return false;
}


function generateStatesSite() {
	var stateObj = document.getElementById("state_id");	
	stateObj.options.length = 0;
	stateObj.options[0] = new Option("Select State","Select State");
	
	var cityObj = document.getElementById("city_id");
	cityObj.options.length = 0;
	cityObj.options[0] = new Option("Select City","Select City");
	
	var areaObj = document.getElementById("area_id");
	areaObj.options.length = 0;
	areaObj.options[0] = new Option("Select Area","Select Area");
	
	if(AjaxObj.CheckReadyState(AjaxObj.request)){
		stateDetails = AjaxObj.request.responseText;
		if(stateDetails != ""){
			state=stateDetails.split("*");
			totalRows = state.length;
			for (var i =0;i<totalRows; i++) {
				var stateValueStr = state[i];
				stateValues=stateValueStr.split("|");
				stateObj.options[stateObj.length] = new Option(stateValues[1],stateValues[0]);
			}
		}
	}
}

function showStatesAdmin() {
	var countryId = document.getElementById("country_id");
    selectedCountryId = countryId.value;
	var strParam="index.php?option=com_jsplocation&controller=city&task=getState&country="+ selectedCountryId;
	AjaxObj.Request(strParam, generateStatesAdmin);
    return false;
}


function generateStatesAdmin() {
	var stateObj = document.getElementById("state_id");	
	stateObj.options.length = 0;
	stateObj.options[0] = new Option("Select State","Select State");
	
	if(AjaxObj.CheckReadyState(AjaxObj.request)){
		stateDetails = AjaxObj.request.responseText;
		if(stateDetails != ""){
			state=stateDetails.split("*");
			totalRows = state.length;
			for (var i =0;i<totalRows; i++) {
				var stateValueStr = state[i];
				stateValues=stateValueStr.split("|");
				stateObj.options[stateObj.length] = new Option(stateValues[1],stateValues[0]);
			}
		}
	}
}

function showStatesBranchAdmin() {
	var countryId = document.getElementById("country_id");
    selectedCountryId = countryId.value;
	var strParam="index.php?option=com_jsplocation&controller=city&task=getState&country="+ selectedCountryId;
	AjaxObj.Request(strParam, generateStatesBranchAdmin);
    return false;
}


function generateStatesBranchAdmin() {
	var stateObj = document.getElementById("state_id");	
	stateObj.options.length = 0;
	stateObj.options[0] = new Option("Select State","Select State");
	
	var cityObj = document.getElementById("city_id");	
	cityObj.options.length = 0;
	cityObj.options[0] = new Option("Select City","Select City");
	
	var areaObj = document.getElementById("area_id");	
	areaObj.options.length = 0;
	areaObj.options[0] = new Option("Select Area","Select Area");
	
	if(AjaxObj.CheckReadyState(AjaxObj.request)){
		stateDetails = AjaxObj.request.responseText;
		if(stateDetails != ""){
			state=stateDetails.split("*");
			totalRows = state.length;
			for (var i =0;i<totalRows; i++) {
				var stateValueStr = state[i];
				stateValues=stateValueStr.split("|");
				stateObj.options[stateObj.length] = new Option(stateValues[1],stateValues[0]);
			}
		}
	}
}

/* End code of displaying the State according to Country */

/* Start code of displaying the City according to State */
function showCities(id){
	var countryId = document.getElementById("country_id");
	var stateId = document.getElementById("state_id");
    selectedStateId = stateId.value;
	var strParam="index.php?option=com_jsplocation&controller=city&task=getCity&state="+ selectedStateId  + "&country=" + selectedCountryId;
	AjaxObj.Request(strParam, generateCities);
    return false;

}

function generateCities(){
	var cityObj = document.getElementById("city_id");
	cityObj.options.length = 0;
	cityObj.options[0] = new Option("Select City","Select City");
	
	if(AjaxObj.CheckReadyState(AjaxObj.request)){
		cityDetails = AjaxObj.request.responseText;
		if(cityDetails != ""){
			city=cityDetails.split("*");
			totalRows = city.length;
			for (var i =0;i<totalRows; i++) {
				var cityValueStr = city[i];
				cityValues=cityValueStr.split("|");
				cityObj.options[cityObj.length] = new Option(cityValues[1],cityValues[0]);
			}
		}
	}
}

function showCitiesBranchAdmin(id){
    var stateId = document.getElementById("state_id");
    var countryId = document.getElementById("country_id");
	
	console.log(countryId);
	
	selectedStateId = stateId.value;
    selectedCountryId = countryId.value;
    var strParam="index.php?option=com_jsplocation&controller=city&task=getCity&state="+ selectedStateId + "&country=" + selectedCountryId;
    AjaxObj.Request(strParam,generateCitiesBranchAdmin);
	return false;

}

function generateCitiesBranchAdmin(){
	var cityObj = document.getElementById("city_id");
	cityObj.options.length = 0;
	cityObj.options[0] = new Option("Select City","Select City");
	
	var areaObj = document.getElementById("area_id");
	areaObj.options.length = 0;
	areaObj.options[0] = new Option("Select Area","Select Area");
	
	if(AjaxObj.CheckReadyState(AjaxObj.request)){
		cityDetails = AjaxObj.request.responseText;
		if(cityDetails != ""){
			city=cityDetails.split("*");
			totalRows = city.length;
			for (var i =0;i<totalRows; i++) {
				var cityValueStr = city[i];
				cityValues=cityValueStr.split("|");
				cityObj.options[cityObj.length] = new Option(cityValues[1],cityValues[0]);
			}
		}
	}
}

function showCitiesSite(id){
	var stateId = document.getElementById("state_id");
    selectedStateId = stateId.value;
	var strParam="index.php?option=com_jsplocation&controller=city&task=getCity&state="+ selectedStateId;
	AjaxObj.Request(strParam, generateCitiesSite);
    return false;

}

function generateCitiesSite(){
	var cityObj = document.getElementById("city_id");
	cityObj.options.length = 0;
	cityObj.options[0] = new Option("Select City","Select City");
	
	var areaObj = document.getElementById("area_id");	
	areaObj.options.length = 0;
	areaObj.options[0] = new Option("Select Area","Select Area");
	
	if(AjaxObj.CheckReadyState(AjaxObj.request)){
		cityDetails = AjaxObj.request.responseText;
		if(cityDetails != ""){
			city=cityDetails.split("*");
			totalRows = city.length;
			for (var i =0;i<totalRows; i++) {
				var cityValueStr = city[i];
				cityValues=cityValueStr.split("|");
				cityObj.options[cityObj.length] = new Option(cityValues[1],cityValues[0]);
			}
		}
	}
}

function showAreas(){
	var cityId = document.getElementById("city_id");
    selectedCityId = cityId.value;
	var strParam="index.php?option=com_jsplocation&controller=area&task=getArea&city="+ selectedCityId;
	AjaxObj.Request(strParam, generateAreas);
    return false;

}

function generateAreas(){
	var cityObj = document.getElementById("area_id");
	cityObj.options.length = 0;
	cityObj.options[0] = new Option("Select Area","Select Area");
	if(AjaxObj.CheckReadyState(AjaxObj.request)){
		cityDetails = AjaxObj.request.responseText;
		if(cityDetails != ""){
			city=cityDetails.split("*");
			totalRows = city.length;
			for (var i =0;i<totalRows; i++) {
				var cityValueStr = city[i];
				cityValues=cityValueStr.split("|");
				cityObj.options[cityObj.length] = new Option(cityValues[1],cityValues[0]);
			}
		}
	}
}

function showAreas2(){


   var stateId = document.getElementById("state_id");
    var countryId = document.getElementById("country_id");    
   
    var cityId = document.getElementById("city_id");
    selectedStateId = stateId.value;
    selectedCountryId = countryId.value;
   selectedCityId = cityId.value;
    
    var strParam="index.php?option=com_jsplocation&controller=branch&task=getArea&city="+ selectedCityId  +"&country="+ selectedCountryId +"&state="+ selectedStateId;
    AjaxObj.Request(strParam, generateAreas2);
   return false;

}

function generateAreas2(){
	var areaObj = document.getElementById("area_id");
	areaObj.options.length = 0;
	areaObj.options[0] = new Option("Select Area",0);
	if(AjaxObj.CheckReadyState(AjaxObj.request)){
		areaDetails = AjaxObj.request.responseText;
		if(areaDetails != ""){
			area=areaDetails.split("*");
			totalRows = area.length;
			for (var i =0;i<totalRows; i++) {
				var areaValueStr = area[i];
				areaValues=areaValueStr.split("|");
				areaObj.options[areaObj.length] = new Option(areaValues[1],areaValues[0]);
			}
		}
	}
}

function blankList(){
	var stateObj = document.getElementById("state_id");	
	stateObj.options.length = 0;	
	stateObj.options[0] = new Option("Select State","Select State");

	var cityObj = document.getElementById("city_id");
	cityObj.options.length = 0;
	cityObj.options[0] = new Option("Select City","Select City");
	
	var areaObj = document.getElementById("area_id");
	areaObj.options.length = 0;
	areaObj.options[0] = new Option("Select Area","Select Area");
}

function blankListAreaAdmin(){
	var stateObj = document.getElementById("state_id");	
	stateObj.options.length = 0;	
	stateObj.options[0] = new Option("Select State","Select State");

	var cityObj = document.getElementById("city_id");
	cityObj.options.length = 0;
	cityObj.options[0] = new Option("Select City","Select City");

}

function blankListCityAdmin(){
	var stateObj = document.getElementById("state_id");	
	stateObj.options.length = 0;	
	stateObj.options[0] = new Option("Select State","Select State");

}
function hideBingMap(optionsValue)
{
  if(optionsValue == true){
   alert("i am here");
   }
}
function hideSearchParams(optionsValue) {
	if(optionsValue.value == "Yes"){
		document.getElementById("search_params_category").style.display = "none";
		document.getElementById("search_params_country").style.display = "none";
		document.getElementById("search_params_state").style.display = "none";
		document.getElementById("search_params_city").style.display = "none";
		document.getElementById("search_params_area").style.display = "none";
		document.getElementById("search_params_range").style.display = "none";
		document.getElementById("search_params_zip").style.display = "";
		document.getElementById("search_params_locateme").style.display = "";
		document.getElementById("search_params_auto").style.display = "";
		document.getElementById("search_params_locateme_range").style.display = "";
		
	} else {
		document.getElementById("search_params_category").style.display = "none";
		document.getElementById("search_params_country").style.display = "none";
		document.getElementById("search_params_state").style.display = "none";
		document.getElementById("search_params_city").style.display = "none";
		document.getElementById("search_params_area").style.display = "none";
		document.getElementById("search_params_range").style.display = "none";
		document.getElementById("search_params_zip").style.display = "none";
		document.getElementById("search_params_locateme").style.display = "none";
		document.getElementById("search_params_auto").style.display = "none";
		document.getElementById("search_params_locateme_range").style.display = "none";
	}
}

function hideLatLongParams(optionsValue) {
	if(optionsValue.value == "1"){
		document.getElementById("lat_ovr").style.display = "";
		document.getElementById("long_ovr").style.display = "";
		document.getElementById("show_map").style.display = "";
		document.getElementById("mapCanvas").style.display = "";
		document.getElementById("infoPanel").style.display = "none";
		document.getElementById("markerStatus").style.display = "none";
		initialize();
	} else {
		document.getElementById("lat_ovr").style.display = "none";
		document.getElementById("long_ovr").style.display = "none";
		document.getElementById("show_map").style.display = "none";
		document.getElementById("mapCanvas").style.display = "none";
		document.getElementById("infoPanel").style.display = "none";
		document.getElementById("markerStatus").style.display = "none";
	}
}

function hideLocOvrParams(optionsValue) {

	if(optionsValue.value == "0"){
	    //alert(mapType);
		document.getElementById("Loclat_ovr").style.display = "";
		document.getElementById("Loclong_ovr").style.display = "";
		document.getElementById("loc_limit").style.display = "";
		document.getElementById("show_map").style.display = "";
		if(document.getElementById('map_type0').checked==true){
		 
		 document.getElementById("mapCanvas").style.display = 'block';
		  document.getElementById("myMap").style.display = 'none';
		  }
		  else if(document.getElementById('map_type1').checked==true) {
		  
		   document.getElementById("mapCanvas").style.display = 'none';
		  document.getElementById("myMap").style.display = 'block';
		  }
		document.getElementById("infoPanel").style.display = "none";
		document.getElementById("markerStatus").style.display = "none";
		initialize();
	} else {
	    
		document.getElementById("Loclat_ovr").style.display = "none";
		document.getElementById("Loclong_ovr").style.display = "none";
		document.getElementById("loc_limit").style.display = "none";
		document.getElementById("show_map").style.display = "none";
		document.getElementById("mapCanvas").style.display = "none";
		 document.getElementById("myMap").style.display = 'none';
		document.getElementById("infoPanel").style.display = "none";
		document.getElementById("markerStatus").style.display = "none";
	}
}


function showUpdates()
{
	var k = jQuery.noConflict();
	k('#image').show();
	k('#version').hide();
	k('#notes').hide();
	var strParam="index.php?option=com_jsplocation&task=getVersion";
	AjaxObj.Request(strParam,generateStates);
	return false;
}

function generateStates()
{
	if(AjaxObj.CheckReadyState(AjaxObj.request))
	{
		var k = jQuery.noConflict();	
		var extensionVersion = AjaxObj.request.responseText;
		k.ajax({
		url:"http://www.joomlaserviceprovider.com/index.php?option=com_extensionversion&task=getVersionInfo&extension=jsplocation",
		dataType: 'jsonp', 
		success:function(json)
		{
			
			if(extensionVersion < json.version){
			var version="<font color='#FF0000'>New Version Available - "+json.version+"</font><br/><a href='http://www.joomlaserviceprovider.com/component/docman/doc_details/14-jsp-location.html' title='Click here to get latest version' target='_blank'>Click here</a> to get latest version";
			var notes= json.notes;
			k('#version').html(version);
			k('#notes').html(notes);
		}
		
		else
		{
			var version="<font color='#51A351'>Version is up to date</font>";
			var notes= json.notes;
			k('#version').html(version);
			k('#notes').html(notes);
			k('#show_notes').hide();
			
		}
		},
		error:function(){
		alert("Unable to connect to server to check for the extension version update");
		},
		});
    k('#image').hide();
    k('#version').show();
    k('#notes').show();

	}

}
function callonload()              //for pointertype options
{
	if(document.getElementById("pointertype1").value == "Yes")
	{
	 	document.getElementById("pointeroptions").style.display = "none";
		document.getElementById("pointeroptions2").style.display = "none";
		document.getElementById("pointer_delete_btn").style.display = "none";
		document.getElementById("custom_pointer_list").style.display = "none";
		document.getElementById("pointer_upload_block").style.display = "none";
	}
	else
	{
	 	document.getElementById("pointeroptions").style.display = "none";
		document.getElementById("pointeroptions2").style.display = "none";
		document.getElementById("pointer_delete_btn").style.display = "";
		document.getElementById("custom_pointer_list").style.display = "";
		document.getElementById("pointer_upload_block").style.display = "";
	}
	return;
}

function callonload2()              //for pointertype options
{
	if(document.getElementById("image_display_yes").value == "Yes")
	{
	 	document.getElementById("default_image_opt1").style.display = "";
		document.getElementById("branch_image_upload").style.display = "";
		document.getElementById("default_image_opt2").style.display = "";
	}
	else
	{
	 	document.getElementById("default_image_opt1").style.display = "none";
		document.getElementById("branch_image_upload").style.display = "none";
		document.getElementById("default_image_opt2").style.display = "none";
	}
	return;
}


function loc_img_disp()              //for pointertype options
{
	if(document.getElementById("image_display1") != null)
	{
		if(document.getElementById("image_display1").value == "1")
		{
			document.getElementById("loc_img_desc").style.display = "";
			document.getElementById("loc_img_upld").style.display = "";
		}
		else
		{
			document.getElementById("loc_img_desc").style.display = "none";
			document.getElementById("loc_img_upld").style.display = "none";
		}
	}
}

function PicsParam(optionsValue) {
	if(optionsValue.value == "0"){
		document.getElementById("branch_image_upload").style.display = "";
	} else {
		document.getElementById("branch_image_upload").style.display = "none";
	}
    var strParam ="index.php?option=com_jsplocation&controller=configuration&task=getImgname&brid="+optionsValue.value;
	AjaxObj.Request(strParam, loadImage);
    return false;
}

function loadImage()
{
	if(AjaxObj.CheckReadyState(AjaxObj.request)){
    imgDetails = AjaxObj.request.responseText;
	if(imgDetails != '')
		{
		//document.getElementById('image_preview').src = "../images/jsplocationimages/jsplocationImages/"+imgDetails;
		}
		else
		{
        // document.getElementById('image_preview').src = "../images/jsplocationimages/jsplocationImages/noimage.jpg";
		}

	}

}