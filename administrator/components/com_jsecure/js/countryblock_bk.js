Joomla.submitbutton = function(pressbutton){
	var submitForm = document.adminForm;
	
	if (pressbutton == 'cancelcountrylog') {				
		 submitForm.task.value = pressbutton;
		 submitForm.submit();
		 return true;								
	}
	
	if (pressbutton == 'removecountrylog') {
	
		 submitForm.task.value = pressbutton;
		
		 submitForm.submit();
		 return true;								
	}
	
	if(pressbutton=="help"){
		submitForm.task.value=pressbutton;
		submitForm.submit();
		return true;
	}
		
	
	if(pressbutton=="saveCountryblock"){

		submitForm.task.value='saveCountryblock';
		submitForm.submit();
		return true;
		
	}
	
	if(pressbutton=="applyCountryblock"){

	 
	  submitForm.task.value='applyCountryblock';
		submitForm.submit();
		return true;
}


if(submitForm.task.value=="publish"){

 submitForm.task.value='publish';
		submitForm.submit();
		return true;
}


if(submitForm.task.value=="unpublish"){

 submitForm.task.value='unpublish';
		submitForm.submit();
		return true;
}


/* Search is not working so we add temporary condition */
if(submitForm.task.value == 'countrylog'){
submitForm.task.value == 'countrylog';
}
else{

submitForm.task.value = pressbutton;

}

submitForm.submit();

}


