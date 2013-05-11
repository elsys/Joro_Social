var cssText              = '',
    forValue             = '';

var cssStuff = new Array();

cssStuff['backgroundBottom']   = "#f1f1f1";
cssStuff['backgroundTop']      = "#fff";
cssStuff['borderBottomColor']  = "#ddd";
cssStuff['borderBottomSize']   = "1px";
cssStuff['borderRadius']       = "4px";
cssStuff['textColor']          = "#444";
cssStuff['hoverColor']         = "#ccc";
cssStuff['hoverBackground']    = "#28597a";
cssStuff['activeBackground']   = "#1b435e";
cssStuff['fontSize']           = "14px";
cssStuff['fontShadowColor']    = "#fff";
cssStuff['fontShadowSize']     = "1px";
cssStuff['fontStack']          = "Arial, sans-serif";
cssStuff['linkNormal']         = "";
cssStuff['linkHover']          = "";
cssStuff['linkHoverBgr']       = "none";
cssStuff['linkFont']           = "inherit";
cssStuff['bodyBgrColorTop']    = "#ECEDE6";
cssStuff['bodyBgrColorBottom'] = "#ECEDE6";
cssStuff['bodyBgrImage']       = "http://media.smashingmagazine.com/cdn_smash/wp-content/uploads/2010/12/coded_complete_list.jpg";
cssStuff['bodyBgrImageRepeat'] = "repeat";
cssStuff['bodyBgrPositionX']   = "";
cssStuff['bodyBgrPositionY']   = "";
cssStuff['bodyBgrSolid']       = "";
cssStuff['boxBgrSolid']        = "#ffffff";
cssStuff['boxShadowSize']      = "5px";
cssStuff['boxShadowColor']     = "#babea9";
cssStuff['boxShadowPosX']	   = "1px";
cssStuff['boxShadowPosY']	   = "1px";
cssStuff['boxTextColor']	   = "#444";
cssStuff['boxFont']			   = "inherit";
cssStuff['boxAIFontColorB']    = "#777";
cssStuff['boxAIFontColorT']    = "#444";
cssStuff['boxSecondLinks']     = "#777";
    
function createCSS() {    
    cssText              = "  .cbox h1.business_title, .cbox h3.business_title, .businessColumn h3 { "; 
    cssText             += "     border-bottom: "+ cssStuff['borderBottomSize'] +" solid " + cssStuff['borderBottomColor'] + ";";
    
    cssText             += "     background: " + cssStuff['backgroundBottom'] + ";";
    cssText             += "     background: -webkit-gradient(linear, left top, left bottom, from(" + cssStuff['backgroundTop'] + "), to(" + cssStuff['backgroundBottom'] + "));";
    cssText             += "     background: -moz-linear-gradient(top, " + cssStuff['backgroundTop'] + ", " + cssStuff['backgroundBottom'] + ");";
    
//	cssText             += "     padding: " + cssStuff['buttonPadding'] + ";";
    
    cssText             += "     -webkit-border-radius: " + cssStuff['borderRadius'] + ";";
    cssText             += "     -moz-border-radius: " + cssStuff['borderRadius'] + ";";
    cssText             += "     border-radius: " + cssStuff['borderRadius'] + ";";
    
    cssText				+= "	-moz-border-radius-bottomleft: 0px;-moz-border-radius-bottomright: 0px;-webkit-border-bottom-left-radius: 0px;-webkit-border-bottom-right-radius: 0px;border-bottom-left-radius: 0px;   border-bottom-right-radius: 0px;";
    
    cssText             += "     -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;";
    cssText             += "     -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;";
    cssText             += "     box-shadow: rgba(0,0,0,1) 0 1px 0;";
    
    cssText             += "     text-shadow: rgba(0,0,0,.4) 0 1px 0;";
    
    cssText             += "     color: " + cssStuff['textColor'] + ";";
//	cssText             += "     font-size: " + cssStuff['fontSize'] + ";";
	cssText             += "     text-shadow: " + cssStuff['fontShadowColor'] + " 1px 1px " + cssStuff['fontShadowSize'] + ";";
    cssText             += "     font-family: " + cssStuff['fontStack'] + ";";
    cssText             += "     text-decoration: none;";
    cssText             += "     vertical-align: middle;";
    
    cssText             += "  }";
    
    cssText             += "  a { ";
//	cssText             += "     background: " + cssStuff['hoverBackground'] + ";";
    cssText             += "     color: " + cssStuff['linkNormal'] + "!important;";
    cssText             += "     font-family: " + cssStuff['linkFont'] + "!important;";
    cssText             += "  }";
    
    cssText             += "  a:hover { ";
//  cssText             += "     background: " + cssStuff['linkHoverBgr'] + "!important;";
    cssText             += "     color: " + cssStuff['linkHover'] + "!important;";
    cssText             += "  }";
    
    cssText             += "  body { ";
    cssText             += "     background: " + cssStuff['bodyBgrColorBottom'] + ";";
    cssText             += "     background: -webkit-gradient(linear, left top, left bottom, from(" + cssStuff['bodyBgrColorTop'] + "), to(" + cssStuff['bodyBgrColorBottom'] + ")) no-repeat "+ cssStuff['bodyBgrColorBottom'] +";";
    cssText             += "     background: -moz-linear-gradient(top, " + cssStuff['bodyBgrColorTop'] + ", " + cssStuff['bodyBgrColorBottom'] + ") no-repeat "+ cssStuff['bodyBgrColorBottom'] +";";
	
	cssText             += "     background: " + cssStuff['bodyBgrSolid'] + " url(" + cssStuff['bodyBgrImage'] + ") " + cssStuff['bodyBgrPositionX'] + " " + cssStuff['bodyBgrPositionY'] + " " + cssStuff['bodyBgrImageRepeat'] +";";
    cssText             += "  }";
    
    cssText             += "  .cbox-middle, .rbox-middle { ";
    cssText             += "     background: " + cssStuff['boxBgrSolid'] + ";";
    cssText             += "  }";
    
    cssText             += "  .cbox, .rbox { ";
    cssText             += "     -moz-box-shadow: "+ cssStuff['boxShadowColor'] +" " + cssStuff['boxShadowPosX'] + " " + cssStuff['boxShadowPosY'] + " " + cssStuff['boxShadowSize'] + ";";
    cssText             += "     -webkit-box-shadow: "+ cssStuff['boxShadowColor'] +" " + cssStuff['boxShadowPosX'] + " " + cssStuff['boxShadowPosY'] + " " + cssStuff['boxShadowSize'] + ";";
    cssText             += "     box-shadow: "+ cssStuff['boxShadowColor'] +" " + cssStuff['boxShadowPosX'] + " " + cssStuff['boxShadowPosY'] + " " + cssStuff['boxShadowSize'] + ";";
    cssText             += "     color: " + cssStuff['boxTextColor'] + ";";
	cssText             += "  	 font-family: " + cssStuff['boxFont'] + ";";
    cssText             += "  }";
    
    cssText             += "  .additional-info ul li { "; 
	cssText             += "     color: " + cssStuff['boxAIFontColorT'] + ";"; 
    cssText             += "  }";

    cssText             += "  .additional-info ul li b { "; 
	cssText             += "     color: " + cssStuff['boxAIFontColorB'] + ";"; 
    cssText             += "  }";
    
    cssText             += "  .subcat, .subcat a { ";
	cssText             += "     color: " + cssStuff['boxSecondLinks'] + " !important;"; 
    cssText             += "  }";
                
    $("#css_box style").replaceWith("<style type='text/css'>" + cssText + "</style>");
  
    $("#customization-style").val(cssText);
}
 

$(function() {

    $("head").append("<style type='text/css'></style>");
 
    createCSS();  
    
	$('#border-rounder').slider({
		values: [8],
		min: 0,
		max: 20,
		slide: function(event, ui) {
		    cssStuff['borderRadius'] = ui.value + "px";
		    createCSS();
		}
	});
	
	$('#border-bottom').slider({
		values: [1],
		min: 0,
		max: 10,
		slide: function(event, ui) {
		    cssStuff['borderBottomSize'] = ui.value + "px";
		    createCSS();
		}
	});
	
	$('#fontShadowSize').slider({
		values: [1],
		min: 0,
		max: 10,
		slide: function(event, ui) {
		    cssStuff['fontShadowSize'] = ui.value + "px";
		    createCSS();
		}
	});
	
	$('.pickable').ColorPicker({
    	onSubmit: function(hsb, hex, rgb, el) {
    		$(el).val(hex).css("background", "#" + hex);
    		$(el).ColorPickerHide();
    		
    		forValue = $(el).attr("rel");
    		    		
    		cssStuff[forValue] = "#" + hex;
    		createCSS();
    		
    	},
    	onChange: function(hsb, hex, rgb, el) {
    	
    		$($(this).data('colorpicker').el).val(hex).css("background", "#" + hex);
    		
    		forValue = $($(this).data('colorpicker').el).attr("rel");
    		    		
    		cssStuff[forValue] = "#" + hex;
    		createCSS();
    		
    	},
    	onBeforeShow: function () {
    		$(this).ColorPickerSetColor(this.value);
    	}
    });
    
    $("#fontSelector").change(function() {
        cssStuff['fontStack'] = $(this).val();
        createCSS();
    });
    
    $("#linkFontSelector").change(function() {
        cssStuff['linkFont'] = $(this).val();
        createCSS();
    });
    
	$("#bgrRepeat").change(function() {
        cssStuff['bodyBgrImageRepeat'] = $(this).val();
        createCSS();
    });

	$("#bgrPositionX").change(function() {
        cssStuff['bodyBgrPositionX'] = $(this).val();
        createCSS();
    });
    
   	$("#bgrPositionY").change(function() {
        cssStuff['bodyBgrPositionY'] = $(this).val();
        createCSS();
    });

	$('#boxShadowSize').slider({
		values: [1],
		min: 0,
		max: 10,
		slide: function(event, ui) {
		    cssStuff['boxShadowSize'] = ui.value + "px";
		    createCSS();
		}
	}); 
	
	$('#boxShadowPosX').slider({
		values: [1],
		min: -10,
		max: 10,
		slide: function(event, ui) {
		    cssStuff['boxShadowPosX'] = ui.value + "px";
		    createCSS();
		}
	});     
    
	$('#boxShadowPosY').slider({
		values: [1],
		min: -10,
		max: 10,
		slide: function(event, ui) {
		    cssStuff['boxShadowPosY'] = ui.value + "px";
		    createCSS();
		}
	});
	
	$("#boxFontSelector").change(function() {
        cssStuff['boxFont'] = $(this).val();
        createCSS();
    });
 
});