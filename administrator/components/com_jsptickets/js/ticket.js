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

function showCategoriesAdmin(selectedext) {
	//var countryId = document.getElementById("country_id");
    //selectedCountryId = countryId.value;
	var strParam="index.php?option=com_jsptickets&controller=ticketform&task=getCategory&extension="+ selectedext;
	AjaxObj.Request(strParam, generateCategoryAdmin);
    return false;
}


function generateCategoryAdmin() {
	var stateObj = document.getElementById("category_id");	
	stateObj.options.length = 0;
	//stateObj.options[0] = new Option("Select category","Select category");
		
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

function showUpdates()
{
	var k = jQuery.noConflict();
	k('#image').show();
	k('#version').hide();
	k('#notes').hide();
	var strParam="index.php?option=com_jsptickets&task=getVersion";
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
		url:"http://www.joomlaserviceprovider.com/index.php?option=com_extensionversion&task=getVersionInfo&extension=jspticket",
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