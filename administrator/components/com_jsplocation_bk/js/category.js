Joomla.submitbutton = function(pressbutton) {
	var submitForm = document.adminForm;
	
	if (pressbutton == 'cancel') {
	submitForm.submit();
	return true;
	}
	if(submitForm.category.value.trim()== ""){
		alert("Please enter category");
		submitForm.category.focus();
		return false;
	}
	else {
		if ( /[^ A-Za-z\d]/.test(submitForm.category.value)) {
    	alert("Please enter only letter and numeric characters");
    	submitForm.category.focus();
    	return false;
		}
	}
	submitForm.task.value=pressbutton;
	submitForm.submit();
}