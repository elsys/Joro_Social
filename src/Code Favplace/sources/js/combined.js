
/*-----------------------------------------------------------
	Call location needing functions when position is received 
-----------------------------------------------------------*/

var locationNeedingFunctionsToCall=Array();
var stopInitialLocationCheck;


$(document).ready(function(){
	if(locationNeedingFunctionsToCall.length){
		if(browserSupportFlag!=0 && initialLocation){
			for(i in locationNeedingFunctionsToCall) eval(locationNeedingFunctionsToCall[i]);
			return;
		}
		
		stopInitialLocationCheck=setInterval(function(){
			if(browserSupportFlag!=0 && initialLocation){
				clearInterval(stopInitialLocationCheck);				
				for(i in locationNeedingFunctionsToCall) eval(locationNeedingFunctionsToCall[i]);
			}
		},100);
	}
});


$(document).ready(function () {
/*-----------------------------------------------------------
	Profile navigation 
-----------------------------------------------------------*/
	$(".minimized").click(function () {	
		if(!($(".minimized").hasClass('act'))) {
			$(".minimized").addClass("act");
		} else {
			$(".minimized").removeClass("act");			
		}
		
		$('#dropdown').slideToggle('fast');
	});
	
/*-----------------------------------------------------------
	My places - dropdown  
-----------------------------------------------------------*/
	$("#my-places-btn").click(function () {	
		if(!($("#my-places-btn").hasClass('act'))) {
			$("#my-places-btn").addClass("act");
		} else {
			$("#my-places-btn").removeClass("act");			
		}
		
		$('#my-places-box').slideToggle('fast');
	});
	
/*-----------------------------------------------------------
	Search box
-----------------------------------------------------------*/
	$("#advancedSearch-btn").click(function () {	
		if(!($("#advancedSearch-btn").hasClass('act'))) {
			$("#advancedSearch-btn").addClass("act");
		} else {
			$("#advancedSearch-btn").removeClass("act");			
		}
		
		$("#advancedSearch-box").slideToggle("fast");
		$(".btnpad").slideToggle(0);
	});
	
/*-----------------------------------------------------------
	Fakechecks 
-----------------------------------------------------------*/
	// check for what is/isn't already checked and match it on the fake ones
	$("input:checkbox").each( function() {
		if((this.checked)) { 
			$("#fake"+this.id).addClass('fakechecked')
		} else { 
			$("#fake"+this.id).removeClass('fakechecked');
		}
	});
	
	// function to 'check' the fake ones and their matching checkboxes
	$("a.fakecheck").click(function(){
		if(($(this).hasClass('fakechecked'))) {
			$(this).removeClass('fakechecked') 
		} else { 
			$(this).addClass('fakechecked');
		} 
		$(this.hash).trigger("click");
		return false;
	});	

/*-----------------------------------------------------------
	Main Search Field - clear value on focus
-----------------------------------------------------------*/	
	$('#mainSearch').focus(function() {  
	    if (this.value == this.defaultValue) {  
	        this.value = '';  
	    } 
	});
	
	$('#mainSearch').focusout(function() {  
	    if (this.value == '') {  
	        this.value = this.defaultValue;  
	    } 
	});  

}); 

/*-----------------------------------------------------------
	Place gallery
-----------------------------------------------------------*/
$(function() { 
    var galleries = $('.ad-gallery').adGallery();
    $('#switch-effect').change(
      function() {
        galleries[0].settings.effect = $(this).val();
        return false;
      }
    );  
});
  

/*-----------------------------------------------------------
	Tabs 
-----------------------------------------------------------*/
$(document).ready(function() {
	//Default Action
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first, ul.tabs-dots li:first, ul.tabs-uploader li:first").addClass("act").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content
	
	//On Click Event
	$("ul.tabs li, ul.tabs-dot li, ul.tabs-uploader li, .tabLink").click(function() {
		$("ul.tabs li, ul.tabs-dot li, ul.tabs-uploader li, .tabLink").removeClass("act"); //Remove any "active" class
		$(this).addClass("act"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content
		var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active content 
		return false;
	});
});


/*-----------------------------------------------------------
	Tooltips
-----------------------------------------------------------*/
$(function() {
	$('.tooltip').tipsy({fade: false, gravity: 's', offset: 5});
	$('.tooltip-r').tipsy({fade: false, gravity: 'w'});
	$('.tab-checkers a').tipsy({fade: false, gravity: 's', offset: 5});
	$('.categoryCheckers a').tipsy({fade: false, gravity: 'n', offset: 10});
	$('.controlsHelper').tipsy({fade: false, gravity: 'w', offset: 20, html: true});
});
 

/*-----------------------------------------------------------
	Resizable and draggable elements
-----------------------------------------------------------*/
$(document).ready(function() {
	 
	$(".draggable").draggable({ handle: '.dragHandle' });
	
	//initializeMap();
	
	resz = false;
			
	$('#view1').click(function() {	
		$("#view1").addClass("act");
		$("#view2").removeClass("act");
		$("#view3").removeClass("act");
		
		$(".topmap").removeClass("mapFullscreen");
		$(".header").removeClass("headerFullscreen");
		$(".quick-search").removeClass("qsFullscreen");
		$("body").removeClass("bodyFullscreen"); 
		
		if(resz) {
			$(".topmap").resizable("disable");
			resz = false;
		}
    });
    
	$('#view2').click(function() {	
		$("#view1").removeClass("act");
		$("#view2").addClass("act");
		$("#view3").removeClass("act");
		
		$(".topmap").addClass("mapFullscreen");
		$(".header").addClass("headerFullscreen");
		$(".quick-search").addClass("qsFullscreen");
		$("body").addClass("bodyFullscreen"); 
		
		if(resz) {
			$(".topmap").resizable("disable");
			resz = false;
		}
    });
	
	$('#view3').click(function() {	
		$("#view1").removeClass("act");
		$("#view2").removeClass("act");
		$("#view3").addClass("act");
	
		$(".topmap").removeClass("mapFullscreen");
		$(".header").removeClass("headerFullscreen");
		$(".quick-search").removeClass("qsFullscreen");
		$("body").removeClass("bodyFullscreen"); 
					
		$(".topmap").resizable({
   			stop: function (){alert(map.checkResize())}
		});
		
		resz = true;
    }); 
	 
});


/*-----------------------------------------------------------
	Customization tools 
-----------------------------------------------------------*/
$(document).ready(function(){
	
	$('#t1').click(function() {	
		$('#eb1').toggle('fast'); 
	});
 
 	$('#t2').click(function() {	
		$('#eb2').toggle('fast'); 
	});

	$('#t3').click(function() {	
		$('#eb3').toggle('fast'); 
	}); 
	
	$('#t4').click(function() {	
		$('#eb4').toggle('fast'); 
	});



	/* Customization (controls) helper */
	var chHidden1 = true;
	var chHidden2 = true;
	$("#fade").hide();
 
	$('#ch1').click(function (){
	    if(chHidden1) {
  	    	$("#fade").show();
			$("h1, h3").addClass("accent");
 	    	$("#ch1").addClass("act");
 	    	
 	    	chHidden1 = false;
 	    } else {
 	    	if(chHidden2) {
	    		$("#fade").hide(); 			
	    	} 	
			$("h1, h3").removeClass("accent");
 	    	$("#ch1").removeClass("act");
 	    		    	
	    	chHidden1 = true;
	    }
	});
 
	$(".titlesCover").hide();
 
	$('#ch2').click(function (){
	    if(chHidden2) {
  	    	$("#fade").show();
			$(".cbox, .rbox").addClass("accent");
 	    	$("#ch2").addClass("act");
 	    	
 	    	chHidden2 = false;
 	    } else {
 	    	if(chHidden1) {
	    		$("#fade").hide(); 			
	    	}
			$(".cbox, .rbox").removeClass("accent"); 
 	    	$("#ch2").removeClass("act");
 	    		    	
	    	chHidden2 = true;
	    }
	});
	
});

// Customized radio buttons
$(function() {
	$("#viewSwitch").buttonset();
});

// View Switchers 
$(document).ready(function() {
 
	$("#vs1").change(function(){
		$(".topmap").removeClass('catalogueFullscreen');	
		$(".quick-search").removeClass("qsCatalogueFullscreen");
		$(".topline").removeClass('toplineFullscreen');
		$(".header").removeClass('headerFullscreen');
		$("#footer").removeClass("footerFullscreen");
		$("#jsHolder").removeClass('listView');
		
		$("#jsHolder").addClass('thumbsView');		
	});

	$("#vs2").change(function(){
		$("#jsHolder").removeClass('thumbsView');
		
		$("#jsHolder").addClass('listView');
		$(".topline").addClass('toplineFullscreen');
		$(".header").addClass('headerFullscreen');
		$(".topmap").addClass('catalogueFullscreen');
		$(".topmap").append('<div class="listViewExpandFix">abvbg</div>');
		$(".quick-search").addClass("qsCatalogueFullscreen");
		$("#footer").addClass("footerFullscreen");
		
	});
	
});
 

function showLogin()
{
	alert("Моля влезте, за да използвате тази функционалност.");	
} 

/*-----------------------------------------------------------
	Post textarea temporary	
-----------------------------------------------------------
$("#comment_text").one('click', function() {
	$("#comment_rich").height(function() {
		$(this).height();
		alert("wtf");	
	});
});
*/


/*-----------------------------------------------------------
	Auto resize fields
-----------------------------------------------------------*/
$(document).ready(function () {
    $('.flexible-commentBox').autoResize({
		animateCallback : function() {
			$("#comment_rich").css("height",$(this).css("height"));
		}
	});
});



/*-----------------------------------------------------------
	Activity filters
-----------------------------------------------------------*/
$(document).ready(function() {
 
 /* ------------------------------------------------
	Turns OFF active filter's icons
	if "ALL" button is active (fakechecked)
 
	ELSE 

	Turns ON active filter's icons
	if "ALL" button is NOT active (fakechecked)
 ------------------------------------------------ */
 
	$("form a#fake_check_all").click(function() {
		if($("form a#fake_check_all").hasClass('fakechecked')) 
		{
			$("form a#fake_check_comments").removeClass('fakechecked');
			$("form a#fake_check_photos").removeClass('fakechecked');
			$("form a#fake_check_videos").removeClass('fakechecked');
			$("form a#fake_check_checkins").removeClass('fakechecked');
			$("form a#fake_check_going").removeClass('fakechecked');
			$("form a#fake_check_were").removeClass('fakechecked');
			$("form a#fake_check_achievements").removeClass('fakechecked');
		} 
		else 
		{
			$("form a#fake_check_comments").addClass('fakechecked');
			$("form a#fake_check_photos").addClass('fakechecked');
			$("form a#fake_check_videos").addClass('fakechecked');
			$("form a#fake_check_checkins").addClass('fakechecked');
			$("form a#fake_check_going").addClass('fakechecked');
			$("form a#fake_check_were").addClass('fakechecked');
			$("form a#fake_check_achievements").addClass('fakechecked');
		}  
	});
	
	
/* ------------------------------------------------
	Turns OFF "VIEW ALL" button if there are 
	other active filters
 
	ELSE 

	Turns ON "VIEW ALL" button if there ARE NOT
	other active filters
 ------------------------------------------------ */
	$("form a#fake_check_comments, form a#fake_check_photos, form a#fake_check_videos, form a#fake_check_checkins, form a#fake_check_going, form a#fake_check_were, form a#fake_check_events, form a#fake_check_achievements").click(function() {
		if($("form a#fake_check_all").hasClass('fakechecked')) 
		{
			$("form a#fake_check_all").removeClass('fakechecked');
		} 
		else 
		{
			if( (!($("form a#fake_check_comments").hasClass('fakechecked')) &&
				!($("form a#fake_check_photos").hasClass('fakechecked')) &&
				!($("form a#fake_check_videos").hasClass('fakechecked')) &&
				!($("form a#fake_check_checkins").hasClass('fakechecked')) &&
				!($("form a#fake_check_going").hasClass('fakechecked')) &&
				!($("form a#fake_check_were").hasClass('fakechecked')) &&
				!($("form a#fake_check_achievements").hasClass('fakechecked')))
			) 
			{
				$("form a#fake_check_all").addClass('fakechecked');
			}
		}  
	});
	
});


/*-----------------------------------------------------------
	FORMS STYLING	
-----------------------------------------------------------*/
$(function(){
	$("form.cboxForm input:checkbox, form.cboxForm input:radio, form.cboxForm input:file, select").uniform();
});





