<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   <head>
      <title>Pushpin attach drag event</title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      <script type="text/javascript" src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=7.0"></script>
      <script type="text/javascript">
      var map = null;
            
      function getMap()
      {
        map = new Microsoft.Maps.Map(document.getElementById('myMap'), {credentials: 'Your Bing Maps Key'});
      }
      
      function attachPushpinDragEvent()
      {
        var pushpinOptions = {draggable:true}; 
        var pushpin= new Microsoft.Maps.Pushpin(map.getCenter(), pushpinOptions); 
        var pushpindrag= Microsoft.Maps.Events.addHandler(pushpin, 'drag', onDragDetails);  
        map.entities.push(pushpin); 
        alert('drag newly added pushpin to raise event');
      }
      
      onDragDetails = function (e) 
      {
        alert("Event Info - start drag \n" + "Start Latitude/Longitude: " + e.entity.getLocation() ); 
      }
      
      </script>
   </head>
   <body onload="getMap();">
      <div id='myMap' style="position:relative; width:400px; height:400px;"></div>
      <div>
         <input type="button" value="AttachPushpinDragEvent" onclick="attachPushpinDragEvent();" />
      </div>
   </body>
</html>