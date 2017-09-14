Joomla.submitbutton = function(pressbutton) {
	var submitForm = document.adminForm;
	
	if (pressbutton == 'cancel') {
	submitForm.submit();
	return true;
	}
	if((submitForm.country_id.value == "0")){
		alert("Please select country");
		submitForm.country_id.focus();
		return false;
	}
	if((submitForm.state_id.value == "Select State") || (submitForm.state_id.value == "")){
		alert("Please select state");
		submitForm.state_id.focus();
		return false;
	}
	if((submitForm.city_id.value == "Select City") || (submitForm.city_id.value == "")){
		alert("Please select city");
		submitForm.city_id.focus();
		return false;
	}
	if(submitForm.area.value.trim()== ""){
		alert("Please enter area");
		submitForm.area.focus();
		return false;
	}
	else {
		if ( /[^ A-Za-z\d]/.test(submitForm.area.value)) {
    	alert("Please enter only letter and numeric characters");
    	submitForm.area.focus();
    	return false;
		}
	}
	submitForm.task.value=pressbutton;
	submitForm.submit();
}