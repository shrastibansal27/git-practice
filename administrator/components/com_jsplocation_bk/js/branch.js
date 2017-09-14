window.onload = function ()
 {
	 loc_img_disp();           //for location image
}

function isNumberKey(evt)
           {
		   
               var charCode = (evt.which) ? evt.which : event.keyCode
 
                if (charCode == 46)
               {
				var inputValue = document.getElementById("info_lat").value;
				var longitudeValue = document.getElementById("info_lng").value;
			   
                
                   if(inputValue.indexOf('.') < 1)
                   {
                       return true;
                   }
				   
				   if(longitudeValue.indexOf('.') < 1)
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
		   
		   
function ImgUpload(fName)
 {
     var submitForm = document.adminForm;
     submitForm.task.value="upload" ;
     return true;
 }
 function ImgDelete(fName)
 {
	 var submitForm = document.adminForm;
     submitForm.task.value="delete";
     return true;
 }
function loadImage()
{
	 var submitForm = document.adminForm;
	 var pth=submitForm.pointerImage.options[submitForm.pointerImage.selectedIndex].value;
	 submitForm.imgPreview.src="../images/jsplocationimages/jsplocationPointers/" + pth;
	 return true;
}
Joomla.submitbutton = function(pressbutton)
 {
	var submitForm = document.adminForm;
	
	/*--- Code to make delete and upload images functionality work in joomla versions greater than 3.4.3 ---*/
	
	var task = document.getElementById('task').value;
	
	if(task){
	
	pressbutton = task;
	}
	if (pressbutton == 'delete')
	  {
	     submitForm.submit();
	     return true;
	  }
	  
	  if (pressbutton == 'upload')
	  {
	     submitForm.submit();
	     return true;
	  }
	  
	  /*--- Code to make delete and upload images functionality work in joomla versions greater than 3.4.3 ---*/
 
	 
	 if (pressbutton == 'cancel')
	  {
	     submitForm.submit();
	     return true;
	  }
	 if(submitForm.branch_name.value.trim()== "")
	 {	
	     alert("Please enter location name!!!");
		 submitForm.branch_name.focus();
		 return false;
	 }
	 else
	 {
		 var x=document.forms["adminForm"]["branch_name"].value;
		 var iChars = "`~!@#$%^&*()+=-[]\\\';/{}|\":<>?";
		 for (var i = 0; i < x.length; i++)
		 {
			 if (iChars.indexOf(x.charAt(i)) != -1)
			 {
			 alert ("Special characters not allowed.");
			 submitForm.branch_name.focus();
			 return false;
			}
		 }
	 }
	 if(submitForm.country_id.value == "0")
	  {
		 alert("Please select country");
		 submitForm.country_id.focus();
		 return false;
	  }
     if((submitForm.state_id.value == "Select State") || (submitForm.state_id.value == ""))
	 {
		 alert("Please select state");
		 submitForm.state_id.focus();
		 return false;
	 }
     if((submitForm.city_id.value == "Select City") || (submitForm.city_id.value == 0))
	 {
		 alert("Please select city");
		 submitForm.city_id.focus();
		 return false;
	 }
	 /*if((submitForm.area_id.value == "Select Area") || (submitForm.area_id.value == "")){
		alert("Please select area");
		submitForm.area_id.focus();
		return false;
	 }*/
	 if(submitForm.address1.value.trim()== "")
	 {
		 alert("Please enter address");
		 submitForm.address1.focus();
		 return false;
	 }
	 else
	 {
		 var x=document.forms["adminForm"]["address1"].value;	
		 var iChars = "`~!@#$%^&*()+=[]\\\';/{}|\":<>?";
		 for (var i = 0; i < x.length; i++) {
		 if (iChars.indexOf(x.charAt(i)) != -1) {
			alert ("Special characters not allowed.");
			submitForm.address1.focus();
			return false;
			}
		}
	}
	if(submitForm.lat_long_override.value == "1"){
		if(submitForm.lat_ovr.value.trim()== ""){
			alert("Please enter latitude override for the location");
			submitForm.lat_ovr.focus();
			return false;
			}
		else {
			var x=document.forms["adminForm"]["lat_ovr"].value;	
			var iChars = "`~!@#$%^&*()+=[]\\\';/{}|\":<>?";
			for (var i = 0; i < x.length; i++) {
				if (iChars.indexOf(x.charAt(i)) != -1) {
				alert ("Special characters not allowed.");
				submitForm.lat_ovr.focus();
				return false;
				}
			}
		}
		if(submitForm.long_ovr.value.trim()== ""){
			alert("Please enter longitude override for the location");
			submitForm.long_ovr.focus();
			return false;
			}
		else {
			var x=document.forms["adminForm"]["long_ovr"].value;	
			var iChars = "`~!@#$%^&*()+=[]\\\';/{}|\":<>?";
			for (var i = 0; i < x.length; i++) {
				if (iChars.indexOf(x.charAt(i)) != -1) {
				alert ("Special characters not allowed.");
				submitForm.long_ovr.focus();
				return false;
				}
			}
		}
	}
	if(submitForm.zip.value.trim()== ""){
		alert("Please enter zip code");
		submitForm.zip.focus();
		return false;
	}

	else if ((submitForm.zip.value.length<"<?php echo $min_zip; ?>") || (submitForm.zip.value.length>"<?php  echo $max_zip; ?>"))
	{
         //alert("<?php $min_zip; ?>");
		alert("Enter zip code in between  min value='<?php echo $min_zip; ?>' and maximum value='<?php  echo $max_zip; ?>'");
		submitForm.zip.focus();
		return false;
	}
	else 
	{
		var x=document.forms["adminForm"]["zip"].value;	
		var iChars = "`~!@#$%^&*()+=[]\\\';/{}|\":<>?";
		for (var i = 0; i < x.length; i++) {
			if (iChars.indexOf(x.charAt(i)) != -1) {
			alert ("Special characters not allowed.");
			submitForm.zip.focus();
			return false;
			}
		}
	}
	
	/* if(submitForm.contact_person.value!= "")
	 {
	      var numerics=document.forms["adminForm"]["contact_person"].value;
	     var contact = /^((\w+ )*\w+)?$/;
		if (!contact.test(numerics)) //Illegal Characters check
		{		
			alert("No white spaces and special characters are allowed!");
			submitForm.contact_person.focus();
			return false;
		}
	}*/
	    

	if(submitForm.email.value != ""){
		var x=document.forms["adminForm"]["email"].value
		var email_filter =  /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i ; /* Valid Email address Regular Expression*/
		if (!email_filter.test(x))
  		{
  			alert("Not a valid e-mail address");
			submitForm.email.focus();
  			return false;
  		}
	}

	if(submitForm.website.value != ""){
		 var theurl=document.adminForm.website.value;
		 var tomatch= /^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/;
		 if (!(tomatch.test(theurl)))
		 {
			 window.alert("Invalid URL.Enter correct URL. Example: http://www.mysite.com");
			 submitForm.website.focus();
			 return false;
		 }
	}
	
	/*
	
	if(submitForm.facebook.value != ""){
		 var theurl=document.adminForm.facebook.value;
		 var tomatch= /http(s)?:\/\/www\.facebook\.com\/[a-z0-9_]+$/
		 if (!(tomatch.test(theurl)))
		 {
			 window.alert("Invalid Facebook link.Enter correct Link. Example: http://www.facebook.com/name");
			 submitForm.facebook.focus();
			 return false;
		 }
	}
	if(submitForm.twitter.value != ""){
		 var theurl=document.adminForm.twitter.value;
		 var tomatch= /http(s)?:\/\/www\.twitter\.com\/[a-z0-9_]+$/
		 if (!(tomatch.test(theurl)))
		 {
			 window.alert("Invalid Twitter link.Enter correct Link. Example: http://www.twitter.com/name");
			 submitForm.twitter.focus();
			 return false;
		 }
	}*/
	if(!chkInputboxValdSpec('inputbox_vald_spec'))
	{
		return false;
	}
			
	submitForm.task.value=pressbutton;
	submitForm.submit();
}
function checkIt(evt){
	evt = (evt) ? evt : window.event
	var charCode = (evt.which) ? evt.which : evt.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57)) 
	{
		status = "This field accepts numbers only."
		alert("This field accepts numbers only.");
		return false
	}
	status = ""
	return true
}
function chkInputboxValdSpec(class_name){
	cust_flag = 1;
	$$('.'+class_name).each(function(e){
		custom_field_val_tmp = e.value ; 
		if(/^[a-zA-Z0-9- ]*$/.test(custom_field_val_tmp) == false)
		{
			e.setStyle('border', '1px solid red');
			cust_flag = 0;
		}	 
		else
		{
			e.setStyle('border', '1px solid lightgrey');
		}		
	});
	
	if(cust_flag == 0)
	{ 
		alert('Custom Field contains special characters!!');
		return false;
	}
	
	return true;
} 


