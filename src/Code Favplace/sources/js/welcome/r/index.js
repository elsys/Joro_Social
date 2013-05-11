function profileComment()
{		
	makeMentionedSpecial();			
				
	var pureText=document.profileCommentForm.comment_text.value;
	
	pureText = pureText.replace("\r\n", "\n");
	pureText = pureText.replace("\r", "\n");
	pureText = pureText.replace("\n", "\\n");
	pureText = pureText.replace('\"', '\\"');
	
	if(pureText=="")
	{
		alert("Не можете да напишете празен коментар");
		return;	
	}
	
	document.profileCommentForm.comment_text.value="";
	
	if(comment_mentioned.length)
	{
		var profilePStr="["
		for(key in comment_mentioned)
		{
			var p=comment_mentioned[key];
			profilePStr+='{"id":'+p.id+', "type":'+p.type+'}, ';
		}
		profilePStr=profilePStr.substr(0,profilePStr.length-2);
		profilePStr+="]";
	}else profilePStr="[]";
	

	var geotagPlaceId=document.profileCommentForm.geotag_place_id.value;
	
	if(geotagPlaceId!=0) geotagType=1;
	else geotagType=0;
	
	var jsonStr='{"comment":"'+pureText+'",'+
	'"params":'+profilePStr+', "geotag_place_id":"'+geotagPlaceId+'","geotag_type":"'+geotagType+'"}';
	
	$.ajax({
	  type: "post",
	  url: "profile/comment",
	  dataType: 'json',
	  data: {"comment_json":jsonStr},
	  success:  function(data) {
		if(data.status=="ok"){
			$("#wallstream").prepend(data.content);	
		}
		else if(data.status=="error") alert(data.description);
	  },
	  error: function (XMLHttpRequest, textStatus, errorThrown)
	  {
		alert("Възникна грешка при свързване със сървъра. "+errorThrown);  
	  }
	});
}

var comment_mentioned=[];

var sel_ie_pos=0;

  $.fn.extend({
  insertAtCaret: function(myValue){
  var obj;
  if( typeof this[0].name !='undefined' ) obj = this[0];
  else obj = this;
	
  if ($.browser.msie) {
	obj.value=obj.value.substring(0, sel_ie_pos)+myValue+obj.value.substring(sel_ie_pos+1,obj.value.length);
	var range = obj.createTextRange();
	range.collapse(true);			
	range.move('character', sel_ie_pos+myValue.length-1);
	range.select();
	obj.focus();
	abc.nothing='';
	}
  else if ($.browser.mozilla || $.browser.webkit) {
	var startPos = obj.selectionStart-1;
	var endPos = obj.selectionEnd;
	var scrollTop = obj.scrollTop;
	obj.value = obj.value.substring(0, startPos)+myValue+obj.value.substring(endPos,obj.value.length);
	obj.focus();
	obj.selectionStart = startPos + myValue.length;
	obj.selectionEnd = startPos + myValue.length;
	obj.scrollTop = scrollTop;
  } else {
	obj.value += myValue;
	obj.focus();
  }
  }
  });
  


function removeMentioned(el)
{
	
}

function addMentioned(el)
{
	for(key in comment_mentioned)
	{
		var p=comment_mentioned[key];
		if(p.id==el.id && p.type==el.type) return;
	}
	
	comment_mentioned.push({
		'id':el.id,
		'name':el.label,
		'type':el.type
	});
}

function makeMentionedSpecial()
{
	var value = $("#comment_text").val();
	var mentioned=comment_mentioned;
	for(str in mentioned)
	{		
		value = value.replace(eval("/"+mentioned[str].name+"/g"),
		"<b>"+mentioned[str].name+"</b>");
	}
	
	value = value.replace(/\n/ig,"<br/>");
	$("#comment_rich").html(value);
}


var specialTimeout;
$(document).ready(function(){
	$("#comment_text").keyup(function (event) {
	
	if(event.shiftKey&&event.keyCode==50) {
		if($("#comment_autocomplete").css("display")=="none"||
		$("#comment_autocomplete").css("display")==""){
			 $("#comment_autocomplete").toggle();	
		}
		$("#comment_autocomplete").focus();				
	}
	
	if(specialTimeout) clearTimeout(specialTimeout);
	specialTimeout=setTimeout("makeMentionedSpecial()",200);
	}).keyup();		
});    

$(function(){
	
	//attach autocomplete
	$("#comment_autocomplete").autocomplete({
		
		//define callback to format results
		source: function(req, add){
			//pass request to server
			$.ajax({
			  type: "post",
			  url: "profile/comment/autocomplete",
			  dataType: 'json',
			  data: req,
			  success:  function(data) {
				var suggestions = [];
				
				//process response
				$.each(data, function(i, result){								
					suggestions.push({
						"id":result.id,
						"label":result.name,
						"type":result.type,														
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
		
		//define select handler
		select: function(e, ui) {
			
			addMentioned(ui.item);
			
			$("#comment_autocomplete").toggle(function () {
				$("#comment_autocomplete").val('');
				$("#comment_text").focus();
			});
			
			$("#comment_text").insertAtCaret(ui.item.value);
			makeMentionedSpecial();						
		},
		
		//define select handler
		change: function() {											
			//prevent 'to' field being updated and correct position
			$("#comment_autocomplete").val("").css("top", 2);
		}	,					
		delay:200,
		minLength: 2
	});
	
	//add click handler to friends div 

	$("#comment_rich").click(function(){
		
		//focus 'to' field
		$("#comment_autocomplete").focus();
	});
	
	//add live handler for clicks on remove links
	$(".remove", document.getElementById("friends")).live("click", function(){
	
		//remove current friend
		$(this).parent().remove();
		
		//correct 'to' field position
		if($("#comment_rich span").length === 0) {
			$("#comment_autocomplete").css("top", 0);
		}				
	});				
});

$(function(){									
	//attach autocomplete
	$("#geotag_autocomplete").autocomplete({
		
		//define callback to format results
		source: function(req, add){
			//pass request to server
			$.ajax({
			  type: "post",
			  url: "profile/geotag/autocomplete",
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
			document.profileCommentForm.geotag_place_id.value=ui.item.id;
		},				
		delay:200,
		minLength: 2
	});
});

function wallComment(ref_id,w_type,comment)
{
	$.ajax({
	  type: "post",
	  url: "profile/wall/comment",
	  dataType: 'json',
	  data: {"ref_id":ref_id,"w_type":w_type,"comment":comment},
	  success:  function(response) {														
		if(response.status=="ok"){
			$("#post-"+ref_id+"-"+w_type+" .post-reply-appender").append(response.content);
		}
		else if(response.status=="error") alert(data.description);
	  },
	  error: function (XMLHttpRequest, textStatus, errorThrown)
	  {
		alert("Възникна грешка при свързване със сървъра. "+errorThrown); 
	  }
	});
}

function showWallCommentBox(a,ref_id,w_type)
{											
	a.parentNode.removeChild(a);

	var form=document.createElement("form");
	form.setAttribute("class","singlePostForm");
	form.setAttribute("id","w_c_b_"+ref_id+"_"+w_type);
	
	var textarea=document.createElement("textarea");
	textarea.setAttribute("class","flexible-commentBox");
	
	var button=document.createElement("input");
	button.setAttribute("type","button");
	button.setAttribute("class","reply-postbtn");
	button.setAttribute("value","Пусни");
	button.onclick=function (){
		var comment=document.getElementById("w_c_b_"+ref_id+"_"+w_type).getElementsByTagName('textarea')[0];
		wallComment(ref_id,w_type,comment.value);
		document.getElementById("w_c_b_"+ref_id+"_"+w_type).parentNode.removeChild(document.getElementById("w_c_b_"+ref_id+"_"+w_type));
	}
	
	form.appendChild(textarea);
	form.appendChild(button);

	$("#post-"+ref_id+"-"+w_type+" .post-reply-appender").append(form);
	$('.flexible-commentBox').autoResize();
}

var pWallShowMore=10;
var pWallShowMoreWorking=false;

function showMore()
{
	if(pWallShowMoreWorking) return;
	pWallShowMoreWorking=true;
	$.ajax({
	  type: "get",
	  url: "welcome/ajax_wall/"+pWallShowMore,
	  dataType: 'json',
	  success:  function(response) {
		if(response.status=="ok"){		
			if(response.count=="0"){
				pWallShowMoreWorking=true;
				return;
			}
			$("#wallstream").append(response.content);
			pWallShowMoreWorking=false;
		}
		else if(response.status=="error") alert(data.description);
	  },
	  error: function (XMLHttpRequest, textStatus, errorThrown)
	  {
		alert("Възникна грешка при свързване със сървъра."); 
	  }
	});
	pWallShowMore+=10;
}