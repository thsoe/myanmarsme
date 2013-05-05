var infowindow;
	var latlng = new google.maps.LatLng(16.828, 96.162);
var maphide = false;
	    var myOptions = {
	      zoom: 12,
	      center: latlng,
	      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);


 function createMarker(name, latlng) {
    var marker = new google.maps.Marker({position: latlng, map: map});
    google.maps.event.addListener(marker, "click", function() {
      if (infowindow) infowindow.close();
      infowindow = new google.maps.InfoWindow({content: name});
      infowindow.open(map, marker);
    });
    return marker;
  }

function showOtherLinks(){
$("#otherLinks").animate({"height": "toggle"}, { duration: 500 });
}

function hidepanel(){


animate();
$("#zoneDetails").animate({"width": "toggle"}, { duration: 500 });
}

function animate(){
var mapWidth ="98%";
if(maphide){
mapWidth ="64%";
document.getElementById('maptoggle').innerHTML=" &nbsp<<&nbsp ";
document.getElementById('maptoggle').title="(Hide)";

maphide=false;
}else{
document.getElementById('maptoggle').innerHTML="&nbsp>>&nbsp ";
document.getElementById('maptoggle').title="(Details)";
maphide=true;
}

$("#map_canvas").animate({"width": mapWidth}, { duration: 600 });
var div = document.getElementById('map_canvas');

    
    div.style.width = mapWidth;

  google.maps.event.trigger(map,"resize");  

}


var oldindex=null;
function showSlidingDiv(index){
if (infowindow) infowindow.close();

if(oldindex !=null){
$("#slidingDiv"+oldindex).animate({"height": "toggle"}, { duration: 500 });
}
if(oldindex !=index){
google.maps.event.trigger(google.maps.Map.prototype.markers[index], "click");
$("#slidingDiv"+index).animate({"height": "toggle"}, { duration: 500 });
oldindex=index;
}else{
oldindex=null;
}
}

google.maps.Map.prototype.markers = new Array();

  google.maps.Map.prototype.addMarker = function(marker) {
    this.markers[this.markers.length] = marker;
  };

  google.maps.Map.prototype.getMarkers = function() {
    return this.markers
  };

  google.maps.Map.prototype.clearMarkers = function() {
    if(infowindow) {
      infowindow.close();
    }

    for(var i=0; i<this.markers.length; i++){
      this.markers[i].set_map(null);
    }
  };

loadZoneList();
var a = new Array();


	$.each(zonelist.zones, function(index, value) {
		var t =  new Object();
		t.name = "<b>"+value.name+"</b><br />"+value.address+"<br />Contacts :<br/> "+value.contactNo+"<br />"+value.contactNo2+"<br />"+value.contactNo3;
		t.lat =  value.lat;
	    t.lng =  value.lng;
	a[index] =t;
		$("#zoneDetails").append("<div id='hide2'>"+
	                        "<div style='padding:2px 5px;'onClick='showSlidingDiv("+index+"); return false;'>"+
	                            value.name+" Details"+
	                        "</div>"+
	                        "<div id='slidingDiv"+index+"' style='display:none;clear:both;'>"+
	                        "<table cellpadding='4' cellspacing='0' width='100%' style='border-top:1px solid #c3c3c3;background:#fff;'>"+
	                            "<tr>"+
	                                "<td width='100%' style='padding-left:10px;' valign='top'>"+
	                                    "<b style='color:#0067D1;'>"+value.name+"</b><br/>"+value.address+"<br/>Contacts: <br/>"+value.contactNo+"<br />"+value.contactNo2+"<br />"+value.contactNo3+
	                                    "<span style='float:left;width:100%;border-bottom:1px dotted #dfdfdf;'>&nbsp;</span>"+
	                                    "<br /><br /><br />"+
	                                    "<b style='color:#0067D1;'>Industrial Zone Characteristics</b>"+
	                                    "<br />"+
	                                    "<ul>"+
	                                        "<li>Terrain of "+value.area+"</li>"+
	                                        "<li> State/Division : " + value.stateDivision+"</li>"+
	                                        "<li> MIDC Zone : " + value.midcZone+"</li>"+
	                                        "<li> Year of Establishment : "+value.establishmentYear+"</li>"+
	                                    "</ul>"+
	                                    "<span style='float:left;width:100%;border-bottom:1px dotted #dfdfdf;'>&nbsp;</span>"+
	                                    "<br /><br />"+
	                                    "<b style='color:#0067D1;'>Services provided to Investors in the Zone</b><br />"+
	                                    "<ul>"+
	                                        "<li>"+value.industryCount+" Industries</li>"+
	                                    "</ul><!--<br /><a href='#see-map' style='color:#F07200;'>See Map &raquo;</a>-->"+
	                                "</td>"+
	                            "</tr>"+
	                        "</table>"+
	                        "</div>"+
	                    "</div>");

});

   for (var i = 0; i < a.length; i++) {

        var latlng = new google.maps.LatLng(a[i].lat, a[i].lng);
        map.addMarker(createMarker(a[i].name,latlng));
     }