function showlicense(key,subcatid){
jQuery.noConflict();
var domain = window.location.hostname;
var loc = window.location.pathname;
var dir = loc.substring(0, loc.lastIndexOf('/'));
pathname = domain+dir;
jQuery.ajax({
  type: "POST",
  url: 'http://dev2.taolabs.in/php/joomlaserviceprovider/?option=com_license',
  data: {key :key ,domain : domain ,subcatid :subcatid},
  success: function(data) {
  if(data != ''){
    if(data == 'Your Subscription is Active.'){
 var license = '<div class="response" style= "background-color: #52b600; color:#fff; width:302px; float:right; padding: 10px 20px; font-size: 19px; text-align: center;"><p><img src="http://'+pathname+'/components/com_jsplocation/images/validmsg.png" style="width:45px;"></p><p> '+data+'</p></div>';

    }else{
 var license = '<div class="response" style= "background-color: #942a25; color:#fff; width:302px; float:right; padding: 10px 20px; font-size: 19px; text-align: center;"><p><img src="http://'+pathname+'/components/com_jsplocation/images/warningicon.png" style="width:45px;"></p><p>  WARNING: '+data+'</p></div>';

    }
 
  jQuery('#license').html(license);
  
  }
  
            },
      
});

  }
  
