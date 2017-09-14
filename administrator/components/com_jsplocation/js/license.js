Joomla.submitbutton = function(pressbutton) {
   var submitForm = document.adminForm;
	if(pressbutton == 'savelicense')
	{
    submitForm.task.value='savelicense';
	submitForm.submit();
    return true;
	}
	if(pressbutton=="applylicense"){
		submitForm.task.value='applylicense';
		submitForm.submit();
		return true;
	}		

	submitForm.task.value=pressbutton;
	submitForm.submit();
	
}


	