// Google maps 
// Geolocation
var initialLocation;
var siberia = new google.maps.LatLng(60, 105);
var newyork = new google.maps.LatLng(40.69847032728747, -73.9514422416687);
var browserSupportFlag=0;

function getInitialLocation()
{
  // Try W3C Geolocation (Preferred)
  if(navigator.geolocation) {
    browserSupportFlag = 1;
    navigator.geolocation.getCurrentPosition(function(position) {
      initialLocation=new google.maps.LatLng(position.coords.latitude,position.coords.longitude);	  
    }, function() {
      handleNoGeolocation(browserSupportFlag);
    });
  // Try Google Gears Geolocation
  } else if (google.gears) {
    browserSupportFlag = 1;
    var geo = google.gears.factory.create('beta.geolocation');
    geo.getCurrentPosition(function(position) {
	  initialLocation=new google.maps.LatLng(osition.latitude, position.longitude)
    }, function() {
      handleNoGeoLocation(browserSupportFlag);
    });
  // Browser doesn't support Geolocation
  } else {
    browserSupportFlag = 2;
    handleNoGeolocation(browserSupportFlag);
  }
  
  function handleNoGeolocation(errorFlag) {
    if (errorFlag == 2) {
      alert("Geolocation service failed.");
	  initialLocation=newyork;
    } else {
      alert("Your browser doesn't support geolocation. We've placed you in Siberia.");
	  initialLocation=siberia;
    }
  } 
}

getInitialLocation();

function initializeHeaderMap() {
   var myOptions = {
	center: initialLocation,
    zoom: 16,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    mapTypeControl: true,
    mapTypeControlOptions: {
        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
        position: google.maps.ControlPosition.BOTTOM
    },
    navigationControl: true,
    navigationControlOptions: {
        style: google.maps.NavigationControlStyle.ZOOM_PAN,
        position: google.maps.ControlPosition.TOP_RIGHT
    },
    scaleControl: true,
    scaleControlOptions: {
        position: google.maps.ControlPosition.TOP_LEFT
    }     
  };
  new google.maps.Map(document.getElementById("map_canvas"), myOptions);
}