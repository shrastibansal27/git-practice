/* Start AjaxObj Code */ 

var AjaxObj = new Object();
AjaxObj.showMessage=1;
AjaxObj.Message='';
AjaxObj.favouriteId = 0;
AjaxObj.Request = function(url, callbackMethod)
{
	AjaxObj.request = AjaxObj.createRequestObject();
	AjaxObj.request.onreadystatechange = callbackMethod;
	AjaxObj.request.open("POST", url, true);
	
	//console.log(url);
	
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

function chkfield()
{ 
	var submitForm = document.adminForm;
	var category_id = submitForm.category_id;
	var country_id = submitForm.country_id;
	var state_id = submitForm.state_id;
	var city_id = submitForm.city_id;
	var area_id = submitForm.area_id;

	if(submitForm.zipsearch.value == "ZIP/Postal Code"){
			alert("Please select appropriate drop down box or provide ZIP/Postal Code");
			return false;
	}
	else
	{
		if ( /[^ A-Za-z\d]/.test(submitForm.zipsearch.value)) {
    	alert("Please enter only numeric and letter characters");
    	submitForm.zipsearch.focus();
    	return false;
		}
	}
	if(submitForm.zipsearch.value != "ZIP/Postal Code" && submitForm.radius.value=="0"){
			alert("Select Radius");
			submitForm.radius.focus();
			return false;
	}
	if(category_id !=undefined){
	submitForm.category_id.value = '';
	}
	if(country_id !=undefined){
	submitForm.country_id.value = '';
	}
	if(state_id !=undefined){
	submitForm.state_id.value = '';
	}
	if(city_id !=undefined){
	submitForm.city_id.value = '';
	}
	if(area_id !=undefined){
	submitForm.area_id.value = '';
	}
	submitForm.submit();
}

/*submitform1 Function is called when any drop-down from the component view is selected-Starts Here*/
function submitform1(){

	var submitForm = document.adminForm;

	if(submitForm.zipsearch!=undefined){
	submitForm.zipsearch.value="";
	}
	if(submitForm.radius!=undefined){
	submitForm.radius.value="";
	}

	submitForm.submit();
}
/*submitform1 Function is called when any drop-down from the component view is selected-Starts Here*/

function chkapiCountry() {
var submitForm = document.adminForm;
myOption = -1;
for (i=submitForm.apiCountry.length-1; i > -1; i--)
{
	if (submitForm.apiCountry[i].checked)
		{
			myOption = i;
		}
}

if (myOption == -1)
	{
	alert("You must select a Country");
	return false;
	}

submitForm.submit();
}

function funcreset(val)
{ 	
    var submitForm = document.adminForm;
    submitForm.task.value=val;
	submitForm.submit();
}

function getGeoloc()
{


	
	var submitForm = document.adminForm;
	var category_id = submitForm.category_id;
	var country_id = submitForm.country_id;
	var state_id = submitForm.state_id;
	var city_id = submitForm.city_id;
	var area_id = submitForm.area_id;
	
	if(category_id !=undefined){
	submitForm.category_id.value = '';
	}
	if(country_id !=undefined){
	submitForm.country_id.value = '';
	}
	if(state_id !=undefined){
	submitForm.state_id.value = '';
	}
	if(city_id !=undefined){
	submitForm.city_id.value = '';
	}
	if(area_id !=undefined){
	submitForm.area_id.value = '';
	}
	if(submitForm.zipsearch !=undefined){
		if(submitForm.zipsearch.value != "")
		{
			submitForm.zipsearch.value = "";
		}
	}
	if (navigator.geolocation)
	{
   				
		navigator.geolocation.getCurrentPosition(function(position) {
   		document.getElementById('geolat').value = position.coords.latitude;
   		document.getElementById('geolong').value = position.coords.longitude;
			
		
   		document.getElementById('locateme').value = "true";
		
		
			
 		submitForm.submit();
		
		
 		}); 
						
	}
	else
	{
  		alert("geolocation services are not supported by your browser.");
	}
}

function branchhit(passed_id)
{
	var strParam="index.php?option=com_jsplocation&view=classic&task=branch_hit&branch_hit_id="+ passed_id;
	
	
	AjaxObj.Request(strParam);
    return false;
}


