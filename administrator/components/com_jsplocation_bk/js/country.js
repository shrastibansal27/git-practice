Joomla.submitbutton = function(pressbutton) {
	var submitForm = document.adminForm;
	
	if (pressbutton == 'cancel') {
	submitForm.submit();
	return true;
	}
	if(submitForm.country.value.trim() == ""){
		alert("Please enter country");
		submitForm.country.focus();
		return false;
	}
	else {
		var x=document.getElementById('country').value;
		var iChars = "`~!@#$%^&*()+=-[]\\\';/{}|\":<>?";
		for (var i = 0; i < x.length; i++) {
			if (iChars.indexOf(x.charAt(i)) != -1) {
			alert ("Special characters not allowed.");
			document.getElementById('country').focus();
			return false;
			}				
		}
	}
	submitForm.task.value=pressbutton;
	submitForm.submit();
}