// JavaScript Document

function placeAddUploadify()
{
	$('#placeAddUpload').uploadify({
		'uploader'  : 'sources/js/uploadify/uploadify.swf',
		'script'    : placeAddUrl+placeAddData.place_id,
		'cancelImg' : 'sources/js/uploadify/cancel.png',
		'folder'    : 'pictures',
		'fileDataName' : 'picture',
		'fileExt'     : '*.jpg;*.png',
		'fileDesc'    : 'Images (.jpg, .png)',
		'multi'       : true,
		'auto'      : true,
		'sizeLimit'   : 2102400,
		'onComplete'  : function(event, ID, fileObj, response, data) {
		},
		'onAllComplete' : function(event,data) {
		  $("#picUploadSuccessful").show("fast");
		}
	});
}
$(document).ready(function () {
	$("#step2Btn").click(function(){
		if(placeValidation.isFormValid()){
			$('#placeAddSteps-1').hide();
			$('#placeAddSteps-2').show();
		}
	});
	
	$('#placeAddForm a.fakecheck"').click(function(){
		placeValidation.vField('subcategories[]');
	});
	
	$("#step3Btn").click(function(){
		$("#step3Btn").html('Мястото се добавя...');
		$('#placeAddSteps-2').hide();
		$('#placeAddSteps-3').show();
		placeAddSubmit(function(){
			placeAddUploadify()
		});
	});
	
	$("#finishPlaceAdd-1").click(function(){
		if(placeValidation.isFormValid()){
			placeAddSubmit();
			window.location=placeAddData.url;
		}
	});
	
	$("#finishPlaceAdd-2").click(function(){
		if(placeValidation.isFormValid()){
			placeAddSubmit();
			window.location=placeAddData.url;
		}
	});
	
	$("#finishPlaceAdd-3").click(function(){
		window.location=placeAddData.url;
	});
});

/*-----------------------------------------------------------
	Form validation
-----------------------------------------------------------*/

var placeValidation=createFormValidation();
				
var config={
	instanceName:"placeValidation",
	timeout:300,
	form:"document.placeAddForm",
	
	fieldInvalid:function(label,message){
		label.parentNode.className="input-holder invalid";
	},
	fieldValid:function (label,message){	
		if(message!="internal") label.parentNode.className="input-holder valid";
	},
	
	rules:{
		"name":"trim|required|min_length[2]|max_length[1000]",
		"address":"trim|required|min_length[2]|max_length[1000]",
		"coord_x":"trim|required",
		"coord_y":"trim|required"
		//"subcategories[]":"callback[checkSubcategories()]"
	},
	
	messagesInvalid:{
		"name":"",
		"address":"",
		"coord_x":"",
		"coord_y":"",
		"subcategories[]":""
	}
};

function checkSubcategories()
{
	alert("in");
	var nodeList=document.placeAddForm.elements['subcategories[]'];
	for(node in nodeList)
	{
		if(nodeList[node].checked) return true;	
	}
	return false;
}

placeValidation.setRules(config);	



/*-----------------------------------------------------------
	Load placeAdd map
-----------------------------------------------------------*/

locationNeedingFunctionsToCall.push('initializePlaceAddMap()');

var placeAddMap;
var geocoder;
var lastPlaceAddMarker;
var lastPlaceAddResult;
var infowindow;

function initializePlaceAddMap()
{	
  var myOptions = {
	zoom: 12,
	center: initialLocation,
	mapTypeId: google.maps.MapTypeId.HYBRID,
	language: "bg"
  };
  
  placeAddMap = new google.maps.Map(document.getElementById("placeAddMap"),myOptions);		
  geocoder = new google.maps.Geocoder();
  infowindow = new google.maps.InfoWindow();

  setPlaceByCoords(initialLocation);
  
  google.maps.event.addListener(placeAddMap, 'click', function(event) {
	  setPlaceByCoords(event.latLng);		
  });
}

function setPlaceByCoords(latLng)
{
	if(lastPlaceAddMarker){
		lastPlaceAddMarker.setMap(null);
		lastPlaceAddMarker=null;	
	}

	geocoder.geocode({'latLng': latLng}, function(results, status) {
	  if (status == google.maps.GeocoderStatus.OK) {
		if (results[0]) {
			lastPlaceAddMarker=new google.maps.Marker({
			  position: latLng, 
			  map: placeAddMap, 
			  draggable: true,
			  animation: google.maps.Animation.DROP,
			  title:"Място на обекта"
			});	
			
			lastPlaceAddResult=results[0];
			
			setCoordsInForm(lastPlaceAddResult);
			$("#address").val(lastPlaceAddResult.formatted_address);
			
			placeValidation.setFieldStatus("address","valid","internal");
			placeValidation.setFieldStatus("coord_x","valid","internal");
			placeValidation.setFieldStatus("coord_y","valid","internal");
				
			google.maps.event.addListener(lastPlaceAddMarker, 'click', function() {
				placeAddMap.setCenter(lastPlaceAddMarker.position);
				placeAddMap.setZoom(16);
				infowindow.setContent(results[0].formatted_address);
		  		infowindow.open(placeAddMap, lastPlaceAddMarker);
			});
			
			google.maps.event.addListener(lastPlaceAddMarker, 'dragend', function() {
				setCoordsInForm(lastPlaceAddResult);
			});
		}
	  } else {
		alert("Geocoder failed due to: " + status);
	  }
	}); 
}

function setCoordsInForm(result)
{
	var location=result.geometry.location.toString();
	location=location.split(",");
	var coord_x=location[0].substr(1,location[0].length);
	var coord_y=location[1].substr(0,location[1].length-1);
	
	var form=document.placeAddForm;
	
	form.coord_city.value='';
	form.coord_municipality.value='';
	form.coord_district.value='';
	form.coord_country.value='';
	
	for(addr in result.address_components){
	   var addr_type=result.address_components[addr].types;
	   var address=result.address_components[addr];

	   if(addr_type[0]=="sublocality"&&addr_type[1]=="political"){ // city
		   document.placeAddForm.coord_city.value=address.short_name;
	   }		 
	   if(addr_type[0]=="locality"&&addr_type[1]=="political"){ // municipality
		   document.placeAddForm.coord_municipality.value=address.short_name;
	   }
	   if(addr_type[0]=="administrative_area_level_1"&&addr_type[1]=="political"){ // district
		   document.placeAddForm.coord_district.value=address.short_name;
	   }
	   if(addr_type[0]=="country"&&addr_type[1]=="political"){ // country
		   document.placeAddForm.coord_country.value=address.short_name;
	   }
	}

	form.coord_x.value=coord_x;
	form.coord_y.value=coord_y;
}


$(function() {
	$( "#address" ).autocomplete({
		source:  function(request,response) {
			address=request.term;
			geocoder.geocode( 
				{ 'address': address,region:"bg",language:"bg"}, 
				function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
					  var data=new Array();
					  for(i=0;i<results.length;i++){
							data.push({
								"label":results[0].formatted_address,
								"value":results[0].formatted_address,
								"result":results[i]
							}); 
					  }

					  response(data);	
					} else {
					  response();
					  //alert("Geocode was not successful for the following reason: " + status);
				   }
				}
			);
		},

		delay:300,
		minLength: 2,
		select: function( event, ui ) {
			if(lastPlaceAddMarker){
				lastPlaceAddMarker.setMap(null);
				lastPlaceAddMarker=null;	
			}
			
			lastPlaceAddResult=ui.item.result;
			
			placeAddMap.setCenter(lastPlaceAddResult.geometry.location);
			
			lastPlaceAddMarker = new google.maps.Marker({
				map: placeAddMap, 
				position: lastPlaceAddResult.geometry.location,
				draggable: true,
				animation: google.maps.Animation.DROP,
				title: lastPlaceAddResult.address_components[0].long_name
			});
			
			setCoordsInForm(lastPlaceAddResult);
			
			google.maps.event.addListener(lastPlaceAddMarker, 'click', function() {
				placeAddMap.setCenter(lastPlaceAddMarker.position);
				placeAddMap.setZoom(16);
				infowindow.setContent(lastPlaceAddResult.formatted_address);
				infowindow.open(map, lastPlaceAddMarker);
			});
			
			google.maps.event.addListener(lastPlaceAddMarker, 'dragend', function() {
				setCoordsInForm(lastPlaceAddResult);
			});

		},
		open: function() {
			$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
		},
		close: function() {
			$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
		}
	});
});	


var placeAddData;
function placeAddSubmit(callback)
{	
	var str="";	
	$("#placeAddForm :input").each(function(i, e){			
		if(e.name!='' && e.value!=''){
			if(e.type=="checkbox"){
				if(e.checked==true) str+=e.name+"="+e.value+"&";
			}
			else str+=e.name+"="+e.value+"&";
		}
	});
	
	alert(str);
	
	$.ajax({
	  type: "post",
	  url: "place/add/ajax",
	  dataType: 'json',
	  data: str,
	  success:  function(data) {
		if(data.status=="ok"){
			placeAddData=data;
			callback();
		}
		else if(data.status=="error") alert(data.description);
	  },
	  error: function (XMLHttpRequest, textStatus, errorThrown)
	  {
		alert("Възникна грешка при свързване със сървъра. "+errorThrown);  
	  }
	});
}