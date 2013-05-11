// JavaScript Document

var eventValidation=createFormValidation();
				
var config={
	instanceName:"eventValidation",
	timeout:300,
	form:"document.eventAddForm",
	defaultFieldStatus:"valid",
	
	fieldInvalid:function(label,message){
		if(message=="internal") return;
		
		if(message=="place_id") document.getElementById('map-box').className="invalid";
		else if(message=="date_start") label.parentNode.className="valid";
		else{		
			label.parentNode.className="input-holder invalid";
			if(message!="internal") label.focus();
		}
	},
	fieldValid:function (label,message){	
		if(message=="internal") return;
	
		if(message=="place_id")	document.getElementById('map-box').className="valid";
		else if(message=="date_start") label.parentNode.className="valid";
		else{
			label.parentNode.className="input-holder valid";
		}
	},
	
	rules:{
		"name":"trim|required|max_length[1000]",
		"date_start":"trim|required|max_length[100]",
		"place_id":"required|numeric"
	},
	
	messagesInvalid:{
		"name":"",
		"date_start":"date_start",
		"place_id":"place_id"
	}
};		

eventValidation.setRules(config);	

function eventEditSubmit()
{
	if(eventValidation.isFormValid()) document.eventAddForm.submit();
}


// Datepickers

/* Bulgarian initialisation for the jQuery UI date picker plugin. */
/* Written by Stoyan Kyosev (http://svest.org). */
jQuery(function($){
    $.datepicker.regional['bg'] = {
        closeText: 'затвори',
        prevText: '&#x3c;назад',
        nextText: 'напред&#x3e;',
		nextBigText: '&#x3e;&#x3e;',
        currentText: 'днес',
        monthNames: ['Януари','Февруари','Март','Април','Май','Юни',
        'Юли','Август','Септември','Октомври','Ноември','Декември'],
        monthNamesShort: ['Яну','Фев','Мар','Апр','Май','Юни',
        'Юли','Авг','Сеп','Окт','Нов','Дек'],
        dayNames: ['Неделя','Понеделник','Вторник','Сряда','Четвъртък','Петък','Събота'],
        dayNamesShort: ['Нед','Пон','Вто','Сря','Чет','Пет','Съб'],
        dayNamesMin: ['Не','По','Вт','Ср','Че','Пе','Съ'],
		weekHeader: 'Wk',
        dateFormat: 'd.mm.yy',
		firstDay: 1,
        isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['bg']);
});

$(function() {
	$("#datepicker-1").datepicker({ minDate: 0, altFormat: 'yy-mm-dd',altField: '#date_start',
	onSelect: function(dateText, inst){
		eventValidation.vFieldT('date_start');
	}
	});
	$("#datepicker-2").datepicker({ minDate: 0, altFormat: 'yy-mm-dd',altField: '#date_end',
	onSelect: function(dateText, inst){
		eventValidation.vFieldT('date_end');
	}});
	
});

$(document).ready(function() {
	// Datepicker for date_end toggle

	$("#event-end-btn").click(function() {
		$(this).hide();
		$("#event-end").show();	
		$("span.hour-desc, #event-end-remove-btn").show('fast');
	});

	$("#event-end-remove-btn").click(function() {
		$(this).hide();
		$("#event-end-btn").show();
		$("#event-end").hide();	
		$("span.hour-desc").hide();
		$("#date_end").val('');
		$("#hour_end").attr('selectedIndex', 0);
	});	
	
	// End of datepicker for date_end toggle
});

// End of datepickers


function setDefaultPlace(checkbox,placeId)
{
	if(checkbox.checked){
		document.eventAddForm.place_id.value=placeId;	
		eventValidation.setFieldStatus("place_id","valid","internal");
	}
}

$(function(){									
	//attach autocomplete
	$("#place_autocomplete").autocomplete({
		
		//define callback to format results
		source: function(req, add){
			//pass request to server
			$.ajax({
			  type: "post",
			  url: "event/place/autocomplete",
			  dataType: 'json',
			  data: req,
			  success:  function(data) {
				var suggestions = [];
				
				//process response
				$.each(data, function(i, result){								
					suggestions.push({
						"id":result.id,
						"label":result.name,
					
					});
				});
				
				//pass array to callback
				add(suggestions);
			  },
			  error: function (XMLHttpRequest, textStatus, errorThrown)
			  {
				alert("error: "+errorThrown);  
			  }
			});
		},
		select: function(e, ui) {
			document.eventAddForm.place_id.value=ui.item.id;
			eventValidation.vFieldT('place_id');
			
			addEventMapMarker(ui.item.label,ui.item.coord_x, ui.item.coord_y);
		},				
		delay:200,
		minLength: 2
	});
});

function eventAddPlaceChoosing(type)
{
	$("#map-box").toggle();	 
	if(type==2){
		document.eventAddForm.place_id.value=0;	
		eventValidation.setFieldStatus("place_id","invalid","internal");
	}
} 

var eventEditMap;
var lastPlaceEventMarker;
function addEventMapMarker(name,coord_x,coord_y)
{
	// place the marker on the map
			
	if(lastPlaceEventMarker){
		lastPlaceEventMarker.setMap(null);
		lastPlaceEventMarker=null;	
	}
	
	var latlng = new google.maps.LatLng(coord_x,coord_y);
	
	eventEditMap.setCenter(latlng);				
	lastPlaceEventMarker = new google.maps.Marker({
		map: eventEditMap, 
		position: latlng,
		draggable: true,
		animation: google.maps.Animation.DROP,
		title: name
	});	
}