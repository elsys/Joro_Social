
$(document).ready(function(){	
	$("#going-btn").click(function(){	
		$.ajax({
			type: "post",
			url: "event/will_go",
			dataType: 'json',
			data: {"event_id":event_id},
			success:  function(response) {
				if(response.status=="ok") $("#going-btn").hide();
			},
			error: function (XMLHttpRequest, textStatus, errorThrown)
			{
			  alert("error: "+errorThrown);  
			}
		});
	
	});
});