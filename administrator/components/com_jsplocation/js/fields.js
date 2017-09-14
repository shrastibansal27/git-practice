// radio button
function addRadioElement()
{alert('add radio');
var	count=document.getElementById('field_value_label').value;
var count1 = document.getElementById('field_value').value;
//alert("count" + count);
count = parseInt(count) + parseInt('1');
count1 = parseInt(count) + parseInt('1');
var contentID = document.getElementById('hideableradio1');
var mydiv   = document.createElement('div');
mydiv.setAttribute('id', 'field'+contentID);
var inputOne  = document.createElement('input');
inputOne.value = "Label Name";
inputOne.type  = "text";
inputOne.name  = "radiolabel"+ count;
inputOne.style.width = '80px';

mydiv.appendChild(inputOne);

var inputTwo  = document.createElement('input');
inputTwo.value = "Value Name";
inputTwo.type  = "text";
inputTwo.name  = "radioname"+count;
inputTwo.style.width = '80px';
mydiv.appendChild(inputTwo);

document.getElementById('field_value_label').value = count;
document.getElementById('field_value').value = count1;
contentID.appendChild(mydiv);
}

function EditRadioElement(value, label)
{	alert('edit radio');
	var count=1;
	count = parseInt(count) + parseInt('1');
	
	var contentID  = document.getElementById('hideableradio1');
	
	var mydiv	   = document.createElement('div');
	mydiv.setAttribute('id', 'field'+contentID);
	var inputOne   = document.createElement('input');
	inputOne.value = label;
	inputOne.type  = "text";
	inputOne.name  = "radiolabel"+ count;
	inputOne.style.width = '80px';
	mydiv.appendChild(inputOne);

	var inputTwo   = document.createElement('input');
	inputTwo.value = value;
	inputTwo.type  = "text";
	inputTwo.name  = "radioname"+count;
	inputTwo.style.width = '80px';
	mydiv.appendChild(inputTwo);

	contentID.appendChild(mydiv);

}

function removeRadioElement(radiocontent)
{ alert('remove radio');
var	countremove=document.getElementById('field_value_label').value;
var contentID = document.getElementById('hideableradio1');
alert(contentID);
contentID.removeChild(document.getElementById('field'+contentID));
countremove=countremove-1;
document.getElementById('field_value_label').value = countremove;
//contentID = contentID-1;
}

// checkbox button
function addCheckboxElement()
{alert('add check');
var	count=document.getElementById('check1').value;
var	count1=document.getElementById('check2').value;
count = parseInt(count) + parseInt('1');
count1 = parseInt(count) + parseInt('1');
var contentID = document.getElementById('hideablecheck1');
var mydiv   = document.createElement('div');
mydiv.setAttribute('id', 'field'+contentID);
var inputOne  = document.createElement('input');
inputOne.value = "Label Name";
inputOne.type  = "text";
inputOne.name  = "checkboxlabel"+ count;
inputOne.style.width = '80px';
mydiv.appendChild(inputOne);

var inputTwo  = document.createElement('input');
inputTwo.value = "Value Name";
inputTwo.type  = "text";
inputTwo.name  = "checkboxname"+count;
inputTwo.style.width = '80px';
mydiv.appendChild(inputTwo);

document.getElementById('check1').value = count;
document.getElementById('check2').value = count1;
contentID.appendChild(mydiv);
}


function EditCheckboxElement(value, label)
{	alert('edit check');
	var	count=document.getElementById('fieldcount').value;
	//var count=1;
	count = parseInt(count) + parseInt('1');
	
	var contentID  = document.getElementById('checkboxcontent');
	var mydiv	   = document.createElement('div');
	mydiv.setAttribute('id', 'field'+contentID);
	var inputOne   = document.createElement('input');
	inputOne.value = label;
	inputOne.type  = "text";
	inputOne.name  = "checkboxlabel"+ count;
	inputOne.style.width = '80px';
	mydiv.appendChild(inputOne);

	var inputTwo   = document.createElement('input');
	inputTwo.value = value;
	inputTwo.type  = "text";
	inputTwo.name  = "checkboxname"+count;
	inputTwo.style.width = '80px';
	mydiv.appendChild(inputTwo);

	document.getElementById('fieldcount').value = count;
	contentID.appendChild(mydiv);

}


function removeCheckboxElement()
{ alert('remove check');
var	countremove=document.getElementById('check1').value;
var contentID = document.getElementById('hideablecheck1');
alert(contentID);
contentID.removeChild(document.getElementById('field'+contentID));
countremove=countremove-1;
document.getElementById('check1').value = countremove;
}


// select option
function addSelectElement()
{
var	count=document.getElementById('select1').value;
var	count1 =document.getElementById('select2').value;
count = parseInt(count) + parseInt('1');
count1 = parseInt(count) + parseInt('1');
var contentID = document.getElementById('hideableselect1');
var mydiv   = document.createElement('div');
mydiv.setAttribute('id', 'field'+contentID);
var inputOne  = document.createElement('input');
inputOne.value = "Label Name";
inputOne.type  = "text";
inputOne.name  = "selectlabel"+ count;
inputOne.style.width = '80px';
mydiv.appendChild(inputOne);

var inputTwo  = document.createElement('input');
inputTwo.value = "Value Name";
inputTwo.type  = "text";
inputTwo.name  = "selectname"+ count;
inputTwo.style.width = '80px';
mydiv.appendChild(inputTwo);

document.getElementById('select1').value = count;
document.getElementById('select2').value = count1;
contentID.appendChild(mydiv);
}

function EditSelectElement(value, label)
{	alert('edit select');
	var count=1;
	count = parseInt(count) + parseInt('1');
	
	var contentID  = document.getElementById('selectcontent');
	
	var mydiv	   = document.createElement('div');
	mydiv.setAttribute('id', 'field'+contentID);
	var inputOne   = document.createElement('input');
	inputOne.value = label;
	inputOne.type  = "text";
	inputOne.name  = "selectlabel"+ count;
	inputOne.style.width = '80px';
	mydiv.appendChild(inputOne);

	var inputTwo   = document.createElement('input');
	inputTwo.value = value;
	inputTwo.type  = "text";
	inputTwo.name  = "selectname"+count;
	inputTwo.style.width = '80px';
	mydiv.appendChild(inputTwo);

	contentID.appendChild(mydiv);

}

function removeSelectElement()
{
var	countremove=document.getElementById('select1').value;
var contentID = document.getElementById('hideableselect1');
contentID.removeChild(document.getElementById('field'+contentID));
countremove=countremove-1;
document.getElementById('select1').value = countremove;
}

function showtextboxes(value)
{

// For showing Text Area
  if(value == 'text area')
   {   
       document.getElementById("hideablearea1").style.display = 'block';
       document.getElementById("hideablearea2").style.display = 'block';
   }
   else
    {
       document.getElementById("hideablearea1").style.display = 'none'; 
       document.getElementById("hideablearea2").style.display = 'none';
    }

// For showing Radio Tab
  if(value == 'radio')
	{
      
       document.getElementById("hideableradio1").style.display = 'block'; 
       
    }   
     else
    {
      document.getElementById("hideableradio1").style.display = 'none';
      
    }

// For showing Checkbox Tab
  if(value == 'check')
       
   {   
       document.getElementById("hideablecheck1").style.display = 'block';
       
   }
     else
    {    
      document.getElementById("hideablecheck1").style.display = 'none';
      
    }

// For showing Select Option Tab
    if(value == 'select')
     {
       document.getElementById("hideableselect1").style.display = 'block';
       
      }
     else
     {
       document.getElementById("hideableselect1").style.display = 'none';
       
     }
  return true;
}
