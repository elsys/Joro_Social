// Form validation

var eventValidation=createFormValidation();
				
var config={
	instanceName:"eventValidation",
	timeout:300,
	form:"document.eventAddForm",
	
	fieldInvalid:function(label,message){
		if(message=="place_id") document.getElementById('map-box').className="invalid";
		else if(message=="date_start") label.parentNode.className="input-holder invalid";
		else{		
			label.parentNode.className="input-holder invalid";
		}
	},
	fieldValid:function (label,message){	
		if(message=="place_id")	document.getElementById('map-box').className="valid";
		else if(message=="date_start") label.parentNode.className="input-holder valid";
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
	/*
	fields:{
		"name":{
			rules:"trim|required|max_length[1000]",
			valid:"",
			invalid:""
		}	
	}*/
};		

eventValidation.setRules(config);	

function eventAddSubmit()
{
	if(eventValidation.isFormValid()) document.eventAddForm.submit();
}

// End of form validation

// Place search autcomplete
$(function(){									
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
						"coord_x":result.coord_x,
						"coord_y":result.coord_y				
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
			
			// place the marker on the map
			
			if(lastPlaceEventMarker){
				lastPlaceEventMarker.setMap(null);
				lastPlaceEventMarker=null;	
			}
			
			var latlng = new google.maps.LatLng(ui.item.coord_x, ui.item.coord_y);
			
			eventAddMap.setCenter(latlng);				
			lastPlaceEventMarker = new google.maps.Marker({
				map: eventAddMap, 
				position: latlng,
				draggable: true,
		 		animation: google.maps.Animation.DROP,
				title: ui.item.name
			});
		},				
		delay:200,
		minLength: 2
	});
});

// End of place search autocomplete

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

// End of datepickers

var eventAddMap;
var lastPlaceEventMarker;

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

	// Intialize GMaps for event adding
    var myOptions = {
      zoom: 15,
      center: new google.maps.LatLng(42.6847001, 23.318978),
      mapTypeId: google.maps.MapTypeId.HYBRID,
	  language: "bg"
    };
	
    eventAddMap = new google.maps.Map(document.getElementById("eventAddMap"),myOptions);	
	// End of intialize GMaps for event adding			
});


function eventAddPlaceChoosing(type)
{
	$("#map-box").toggle();	 
	if(type==2){
		document.eventAddForm.place_id.value=0;	
	}
} 