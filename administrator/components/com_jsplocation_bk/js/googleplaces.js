Joomla.submitbutton = function(pressbutton) {
	if (pressbutton == 'cancel') {
     submitForm.task.value="cancel";
    submitForm.submit();
    return true;
    }
	Joomla.submitform(pressbutton);
	}
	 
function SelectLocation(id)
{
var submitForm = document.adminForm;
submitForm.task.value="SelectLocationid";

document.getElementById('createlocationid').value = id;

submitForm.submit();
return true;

}

function EnterPlace(id){
var submitForm = document.adminForm;
submitForm.task.value="SearchGooglePlaces";
var search = document.getElementById('search').value;
if(search == ""){
    return false;
}
submitForm.submit();
return true;
    
}

