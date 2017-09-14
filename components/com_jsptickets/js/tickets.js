/**
 * JSP Tickets components for Joomla!
 * JSP Tickets is a Joomla 2.5 and Joomla 3.0 support/tickets extension
 * developed by Joomla Service Provider Team.
 * @author      $Author: Ajay Lulia $
 * @copyright   Joomla Service Provider - 2013
 * @package     JSP Tickets 1.0
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: tickets.js  $
 */
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
			state=stateDetails.split("-");
			totalRows = state.length;
			for (var i =0;i<totalRows; i++) {
				var stateValueStr = state[i];
				stateValues=stateValueStr.split("|");
				stateObj.options[stateObj.length] = new Option(stateValues[1],stateValues[0]);
			}
		}
	}
}
/* Start of Ticket List Tools */
function Edit()
{
	var submitForm = document.adminForm;
	if (submitForm.boxchecked.value==0)
	{
		alert('Please first make a selection from the list');
		return false;
	} else {
		submitForm.task.value="edit" ;
		return true;
	}
}

function New()
{
var submitForm = document.adminForm;
submitForm.task.value="add" ;
return true;
}

/*function Checkin()
{
var submitForm = document.adminForm;
submitForm.task.value="checkin" ;
return true;
}*/

function Follow()
{
	var submitForm = document.adminForm;
	if (submitForm.boxchecked.value==0)
	{
		alert('Please first make a selection from the list');
		return false;
	} else {
	submitForm.task.value="follow" ;
	return true;
	}
}

function Unfollow()
{
	var submitForm = document.adminForm;
	if (submitForm.boxchecked.value==0)
	{
		alert('Please first make a selection from the list');
		return false;
	} else {
	submitForm.task.value="unfollow" ;
	return true;
	}
}

function Remove()
{
var submitForm = document.adminForm;
	if (submitForm.boxchecked.value==0)
	{
		alert('Please first make a selection from the list');
		return false;
	} else {
			submitForm.task.value="remove" ;
			var val = confirm("Message: Deleting ticket will also delete its associated attachments, feedbacks, comments and log. Are you sure ?");
			if(val==true)
			{
				//submitForm.task.value=pressbutton;
				submitForm.submit();
				return true;	
			} else {
				return false;
			}
		}
}

/* End of Ticket List Tools */
/* Start of Ticket Form Tools */

function Save()
{
var submitForm = document.adminForm;
submitForm.controller.value="ticketform" ;
submitForm.task.value="save" ;
submitbutton();
}

function Apply()
{
var submitForm = document.adminForm;
submitForm.controller.value="ticketform" ;
submitForm.task.value="apply" ;
submitbutton();
}

function ListClose()
{
var submitForm = document.adminForm;
submitForm.controller.value="ticketlist" ;
submitForm.task.value="cancel" ;
submitForm.submit();
}

function FormClose()
{
var submitForm = document.adminForm;
submitForm.controller.value="ticketform" ;
submitForm.task.value="cancel" ;
submitForm.submit();
}
/* End of Ticket Form Tools */