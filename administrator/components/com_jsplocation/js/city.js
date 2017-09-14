Joomla.submitbutton = function(pressbutton) {
	var submitForm = document.adminForm;
	
	if (pressbutton == 'cancel') {
	submitForm.submit();
	return true;
	}
	if(submitForm.country_id.value == "0"){
		alert("Please select country");
		submitForm.country_id.focus();
		return false;
	}
	if((submitForm.state_id.value == "Select State") || (submitForm.state_id.value == "")){
		alert("Please select state");
		submitForm.state_id.focus();
		return false;
	}
	if(submitForm.city.value.trim() == ""){
		alert("Please enter city");
		submitForm.city.focus();
		return false;
	}
	else {
		var x=document.getElementById('city').value;
		var iChars = "`~!@#$%^&*()+=-[]\\\';/{}|\":<>?";
		for (var i = 0; i < x.length; i++) {
			if (iChars.indexOf(x.charAt(i)) != -1) {
			alert ("Special characters not allowed.");
			document.getElementById('city').focus();
			return false;
			}			
		 }
	}
	submitForm.task.value=pressbutton;
	submitForm.submit();
}
