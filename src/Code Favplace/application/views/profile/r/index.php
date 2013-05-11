<? get_header();?>
		<script>
		function profileFollow(username)
		{
			$('#profileFollow').attr("innerHTML","Моля изчакайте...");
			
			$.ajax({
			 type: "GET",
			 url: "profile/follow/"+username,
			 dataType: "json",
			 success: function(response){
				if(response.status=="ok"){
					$('#profileFollow').attr("href","javascript:profileUnfollow('"+username+"')");
					$('#profileFollow').attr("innerHTML","Спри следенето");
				}
				else if(response.status=="error") alert(response.description);
			 },
			 error: function (msg){
				  alert("Възникна грешка при свързване със сървъра.");   
			 }
		  });
		}
		
		function profileUnfollow(username)
		{
			$('#profileFollow').attr("innerHTML","Моля изчакайте...");
			
			$.ajax({
			 type: "GET",
			 url: "profile/unfollow/"+username,
			 dataType: "json",
			 success: function(response){
				if(response.status=="ok"){
					$('#profileFollow').attr("href","javascript:profileFollow('"+username+"')");
					$('#profileFollow').attr("innerHTML","Проследи");
				}
				else if(response.status=="error") alert(response.description);
			 },
			 error: function (msg){
				  alert("Възникна грешка при свързване със сървъра.");   
			 }
		  });
		}
		</script>
		<div class="left-column">
			<div class="cbox">
				<!--<h1>yordanoff</h1>-->

				<div class="cbox-middle br4">
				
						<h4 class="titleBlock br4" style="font-size: 24px; text-transform: none;">
							<a href="profile/<?=$profile->username;?>"><?=$profile->username;?></a>
                            
                            <? if($profile->id==$this->profile_id):?>
							<a href="profile/edit" class="px-btn br4">Редактирай</a>
                            <? endif;?>
						</h4>
						
			            <div class="left-subcol">
			            	<img src="<?=profile_avatar($profile->id,200);?>" alt="" width="200" height="200" />
			            	
                            <? if( ! $followed && $this->profile_id!=$profile->id):?>
			            	<a href="javascript:profileFollow('<?=$profile->username;?>')" 
                            id="profileFollow" class="follow-btn">
                            	Проследи
                            </a>
                            <? elseif($followed):?>
                            <a href="javascript:profileUnfollow('<?=$profile->username;?>')" 
                            id="profileFollow" class="follow-btn">
                            	Спри следенето
                            </a>
			            	<? endif?>
			            	<div class="box"> 
				            	<div class="subcat">
				            		<a href="#" target="_blank" rel="nofollow">thewebsite.bg</a>  
				            		<a href="#">Facebook icon</a>  
				            		<a href="#">Twitter icon</a>
				            		<a href="#">Direct message icon</a>  
				            	</div>
			            	</div>
			            </div>
			            
			            <div class="right-subcol">
							<div class="checkin-box">
							
				            	<div class="checkin">
				            		<span class="col1">
				            			<a href="#">
					            			<span class="icon"></span> 
					            			<span class="num"><?=$profile->places_visited;?></span>
				            			</a>
				            			<div class="clear"></div>
				            		</span>
		        					<a href="#" class="here-btn"><b>Посетил</b> <span></span></a>
				            	</div>
				            	
				            	<div class="checkin">
				            		<span class="col2">
				            			<a href="#">
					            			<span class="icon"></span> 
					            			<span class="num"><?=$profile->places_will_visit;?></span>
				            			</a>
				            			<div class="clear"></div>
				            		</span>
		        					<a href="#" class="going-btn"><b>Ще посети</b> <span></span></a>
				            	</div>
				            	
				            	<div class="checkin">
				            		<span class="col3">
				            			<a href="profile/favorite_places/<?=$this->username;?>">
					            			<span class="icon"></span> 
					            			<span class="num"><?=$favorites_count;?></span>
				            			</a>
				            			<div class="clear"></div>
				            		</span>
		        					<a href="profile/favorite_places/<?=$this->username;?>" class="was-btn">
                                    	<b>Любими</b> <span></span>
                                    </a>
				            	</div>
			            	
			            	</div><!-- end of checkin-box -->
			            	
			            	<div class="text-description">
                            	<?=htmlspecialchars($profile->description);?>
			            	</div>
			            	
			            </div><!-- end of right-subcol --> 
				              				    
					<div class="clear"></div>

					<div class="text-description">
	            		<h4 class="titleBlock br4">Значки</h4>
	            		<a href="#">Значка</a>
	            		<a href="#">Значка</a>
	            		<a href="#">Значка</a>
	            		<a href="#">Значка</a>
	            	</div>
	            				 
					<div class="clear"></div>
					
				 	<div style="position: relative; margin-top: 20px;">
						<h4 class="titleBlock br4" style="padding: 16px 10px 10px 10px;">Активност</h4>
						
						<form id="" class="tab-checkers" style="right: 3px;">
				        	<small>Покажи: </small>
					        <a href="#check_comments" class="fakecheck fakechecked" id="fake_check_comments" title="Коментари"></a>
							<input type="checkbox" name="" id="check_comments" />
							
							<a href="#check_photos" class="fakecheck fakechecked" id="fake_check_photos" title="Снимки"></a>
							<input type="checkbox" id="check_photos" />
							
							<a href="#check_videos" class="fakecheck fakechecked" id="fake_check_videos" title="Видео"></a>
							<input type="checkbox" name="" id="check_videos" />
							
							<a href="#check_checkins" class="fakecheck fakechecked" id="fake_check_checkins" title="Кой е тук"></a>
							<input type="checkbox" name="" id="check_checkins" />
							
							<a href="#check_going" class="fakecheck fakechecked" id="fake_check_going" title="Кой ще го посети"></a>
							<input type="checkbox" name="" id="check_going" />
							
							<a href="#check_were" class="fakecheck fakechecked" id="fake_check_were" title="Кой го е посетил"></a>
							<input type="checkbox" name="" id="check_were" />
							
							<a href="#check_events" class="fakecheck fakechecked" id="fake_check_events" title="Събития"></a>
							<input type="checkbox" name="" id="check_events" />
							
							<a href="#check_achievements" class="fakecheck fakechecked" id="fake_check_achievements" title="Значки"></a>
							<input type="checkbox" name="" id="check_achievements" />
						</form>
					</div>
 
					<div id="wallstream">
                    <? foreach($wallstream->result() as $item):?>
                     <div class="post-item" id="post-<?=$item->id;?>-<?=$item->w_type;?>">
						<a href="<?=profile_link($item->from_name);?>" class="avatar">
                        	<img src="<?=profile_avatar($item->from_id,50);?>" class="rounded" alt="" />
                        </a>
						<a href="<?=profile_link($item->from_name);?>" class="nickname">
							<?=profile_link($item->from_name);?>
                        </a>
						<span class="post"><?=$item->content;?>
						</span>
                        <? if(isset($item->pictures)):?>
						<div class="attachments">
                        	<? foreach($item->pictures->result() as $picture):?>
							<a href="#"><img src="pictures/<?=$picture->name."_100_100".$picture->ext;?>" alt="" style="width:100px;height:100px"/></a>
                            <? endforeach; ?>
						</div>
                        <? endif;?>
						<span class="meta">
							<a href="#" class="a_comments" title="Коментар"></a> <b class="middot fl">&middot;</b>
							<!--<a href="#" class="a_photos" title="Снимка"></a> <b class="middot fl">&middot;</b>
							<a href="#" class="a_videos" title="Видео"></a>
							<b>&middot;</b> -->
							<?=wall_date($item->date_diff,$item->date);?>
                            
                            <? if($item->w_type==1 && $item->sub_type==1):?>
							<b>&middot;</b>
							<a href="place/<?=$item->to_id;?>/<?=url_title($item->to_name);?>">
                            	@<?=htmlspecialchars($item->to_name);?>
                            </a> 
                            <? endif;?>
                            
							<b>&middot;</b>  
							<a 
                            onclick="showWallCommentBox(this,<?=$item->id;?>,<?=$item->w_type;?>)">
                            Коментирай</a> 
						</span>

												
                        <div class="comment_tooltip"></div>
						<div class="post-reply">
                        <? if($item->comments):?>
							<? foreach($item->comments->result() as $comment):?>
							<div class="reply-box">
								<a href="<?=profile_link($comment->username);?>" class="avatar">
                                	<img src="<?=profile_avatar($comment->profile_id);?>" class="rounded" alt="" />
                                 </a>
								<a href="<?=profile_link($comment->username);?>" class="nickname">
									<?=$comment->username;?>
                                </a>
								<span class="post"><?=htmlspecialchars($comment->comment);?></span>
							</div>
                            <? endforeach;?> 
                        <? endif;?>					
						</div><!-- /. post-reply -->
						
						
						<div class="comment_tooltip" style="display: none;"></div>
						<div class="post-reply-appender"></div>
						
					</div>
                  	<? endforeach;?> 
                    </div>
					
				</div><!-- end of cbox-middle -->
				
			<a id="showMore" onclick="showMore(<?=$profile->id;?>)">Виж още</a>
				
			</div><!-- end of cbox -->

			
		</div> <!-- end left-column -->

		<div class="right-column">		
			<? get_popular_box();?>			
			<? get_near_users();?>
		</div> <!-- end of right-column -->
	
    
                                <script>
							
							function profileComment()
							{		
								makeSpecial();						
								var pureText=document.profileCommentForm.comment_text.value;
								
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
								
								var jsonStr='{"comment":"'+pureText+'","params":'+profilePStr+', "geotag_place_id":"'+geotagPlaceId+'","geotag_type":"'+geotagType+'"}';
								
								prompt("",jsonStr.toSource());
								
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
							
							
							
							<!-- FROM AUTOCOMPLETE.HTML ---------------------------------------------->
							
							

		
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
							
							function makeSpecial()
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
								specialTimeout=setTimeout("makeSpecial()",200);
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
											makeSpecial();						
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
											$("#post-"+ref_id+"-"+w_type+" .post-reply").append(response.content);
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
//									$('.comment_tooltip').show();
								}
								
								var pWallShowMore=10;
								var pWallShowMoreWorking=false;
								function showMore(profileId)
								{
									alert("profile/ajax_wall/"+profileId+"/"+pWallShowMore);
									if(pWallShowMoreWorking) return;
									pWallShowMoreWorking=true;
									$.ajax({
									  type: "get",
									  url: "profile/ajax_wall/"+profileId+"/"+pWallShowMore,
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
							
							
							<!-- END OF TAKEN CODE --------------------------------------------------->
							</script>
<? get_footer();?>