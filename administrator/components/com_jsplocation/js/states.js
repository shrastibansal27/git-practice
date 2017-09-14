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
	if(submitForm.state.value.trim()== ""){
		alert("Please enter state");
		submitForm.state.focus();
		return false;
	}
	else {
		var x=document.getElementById('state').value;
		//alert(x);			
		var iChars = "`~!@#$%^&*()+=-[]\\\';/{}|\":<>?";
		for (var i = 0; i < x.length; i++) {
			if (iChars.indexOf(x.charAt(i)) != -1) {
			alert ("Special characters not allowed.");
			document.getElementById('state').focus();
			return false;
			}				
		}
	}
	submitForm.task.value=pressbutton;
	submitForm.submit();
}
