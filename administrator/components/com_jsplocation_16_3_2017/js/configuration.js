window.onload = function ()
{
	callonload();           //for pointertype options
	callonload2();          //for image options	
}
function ImgUpload(fName)
{
var submitForm = document.adminForm;
submitForm.task.value="upload" ;
return true;
}
function defaultLocImg(fName)
{
var submitForm = document.adminForm;
submitForm.task.value="defaultimageupload" ;
return true;
}
function ImgDelete()
{
var submitForm = document.adminForm;
submitForm.task.value="delete" ;
return true;
}

function locationDetails(){
var submitForm = document.adminForm;
submitForm.task.value="locationdetails" ;
return true;
}

function exportData(){
var submitForm =document.adminForm;
submitForm.task.value="exportdata";
return true;
}





function branchstatus(optValue){

if(optValue != null && optValue != undefined  )
{

	if(optValue == "0"){

		document.getElementById("locationdetails1").style.display = "none";
		document.getElementById("locationfilepath1").style.display = "none";
		document.getElementById("branchlocationsamplefile").style.display = "none";
	} else {
		document.getElementById("locationdetails1").style.display = "";
		document.getElementById("locationfilepath1").style.display = "";
		document.getElementById("branchlocationsamplefile").style.display = "";
	}
}



}

function isNumberKey(evt)
           {
		   
               var charCode = (evt.which) ? evt.which : event.keyCode
 
               if (charCode == 46)
               {
				var inputValue = document.getElementById("info_lat").value;
				var longitudeValue = document.getElementById("info_lng").value;
			   
                
                   if (inputValue.indexOf('.') < 1)
                   {
                       return true;
                   }
				   
				   if (longitudeValue.indexOf('.') < 1)
                   {
                       return true;
                   }
				   
                   return false;
               }
			   
			   if(charCode == 43 || charCode == 45){
			   
			   return true;
			   
			   }
               if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
               {
                   return false;
               }
               return true;
           }


Joomla.submitbutton = function(pressbutton) {

	var submitForm = document.adminForm;
	var task = document.getElementById('task').value;
	if(task){
	pressbutton = task;
	}
	
	if (pressbutton == 'cancel') {
	submitForm.task.value=pressbutton;
	submitForm.submit();
	return true;
	}

	if (pressbutton == 'locationdetails') {
	submitForm.task.value=pressbutton;
	submitForm.submit();
	return true;
	}
	
	if(pressbutton == 'exportdata'){
	submitForm.task.value=pressbutton;
	submitForm.submit();
	return true;
	}
	
	
	
	if(submitForm.maptitle.value!="")
	{ 
	 
	 var numerics = document.forms["adminForm"]["maptitle"].value;
	     var map = /^((\w+ )*\w+)?$/;
		if (!map.test(numerics)) //Illegal Characters check
		{		
			alert("No white spaces and special characters are allowed!");
			submitForm.maptitle.focus();
			return false;
		}
	}
	var mapTypeBing = document.getElementById('map_type1').checked;
	if(mapTypeBing==true)
	  { if(submitForm.bing_key.value.trim()=="")
	        { alert("please enter the bing map key");
			   submitForm.bing_key.focus();
		       return false;
			}
	  }
	if(submitForm.height.value.trim()== ""){
		alert("Please enter height in PX for Map");
		submitForm.height.focus();
		return false;
	}
	else
	{
		if ( !(/^[0-9]+$/.test(submitForm.height.value))) {
    	alert("Please enter only numeric characters");
    	submitForm.height.focus();
    	return false;
		}
	}
		
	if(submitForm.branch_id.value.trim() == "0"){
		if(submitForm.lat_ovr_conf.value.trim() == ""){
			alert("Please enter latitude override for Map location");
			submitForm.lat_ovr_conf.focus();
			return false;
			}		
		else {
			var x=document.forms["adminForm"]["lat_ovr_conf"].value;	
			var iChars = "`~!@#$%^&*()+=[]\\\';/{}|\":<>?";
			for (var i = 0; i < x.length; i++) {
			if (iChars.indexOf(x.charAt(i)) != -1) {
			alert ("Special characters not allowed.");
			submitForm.lat_ovr_conf.focus();
				return false;
				}
			}
		}
		
		if(submitForm.long_ovr_conf.value.trim()== ""){
			alert("Please enter longitude override for Map location");
			submitForm.long_ovr_conf.focus();
			return false;
			}
		else {
			var x=document.forms["adminForm"]["long_ovr_conf"].value;	
			var iChars = "`~!@#$%^&*()+=[]\\\';/{}|\":<>?";
			for (var i = 0; i < x.length; i++) {
				if (iChars.indexOf(x.charAt(i)) != -1) {
				alert ("Special characters not allowed.");
				submitForm.long_ovr_conf.focus();
				return false;
				}
			}
		}
	}
	if(submitForm.zoomlevel.value.trim()== ""){
		alert("Please enter zoom level for Map");
		submitForm.zoomlevel.focus();
		return false;
	}
	else {
		if ( !(/^\d*([.]\d{2})?$/.test(submitForm.zoomlevel.value))) {
		alert("Please enter zoom level in PX for Map");
		submitForm.zoomlevel.focus();
		return false;
		}
	}
	if(submitForm.branch_id.value == ""){
		alert("Please select default location which should display on map on page load");
		submitForm.branch_id.focus();
		return false;
	}
	if(submitForm.page_limit.value != ""){
		if ( !(/^[0-9]+$/.test(submitForm.page_limit.value))) {
    	alert("Please enter only numeric characters on Location List Limit / Pagination");
    	submitForm.page_limit.focus();
    	return false;
		}
	}
	if(submitForm.min_zip.value != ""){
		if ( !(/^[0-9]+$/.test(submitForm.min_zip.value))) {
    	alert("Please enter only numeric characters on Zip Code Minimum Value");
    	submitForm.min_zip.focus();
    	return false;
		}
	}
	if(submitForm.max_zip.value != ""){
		if ( !(/^[0-9]+$/.test(submitForm.max_zip.value))) {
    	alert("Please enter only numeric characters on Zip Code Maximum Value.");
    	submitForm.max_zip.focus();
    	return false;
		}
	}
	
	submitForm.task.value=pressbutton;
	submitForm.submit();
}