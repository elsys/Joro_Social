<? get_header();?>
<script type="text/javascript" src="sources/js/welcome/r/index.js"></script>

		<div class="left-column">
			<div class="cbox br5-top">
				
				<h3>Активност</h3>
				<form id="" class="tab-checkers">
		        	<!--<small>Покажи: </small>-->
		        	<a href="#check_all" class="fakecheck fakechecked" id="fake_check_all" title="Покажи всички постове"></a>
					<input type="checkbox" name="" id="check_all" />
					
			        <a href="#check_comments" class="fakecheck" id="fake_check_comments" title="Коментари"></a>
					<input type="checkbox" name="" id="check_comments" />
					
					<a href="#check_photos" class="fakecheck" id="fake_check_photos" title="Снимки"></a>
					<input type="checkbox" id="check_photos" />
					
					<a href="#check_videos" class="fakecheck" id="fake_check_videos" title="Видео"></a>
					<input type="checkbox" name="" id="check_videos" />
					
					<a href="#check_checkins" class="fakecheck" id="fake_check_checkins" title="Кой е тук"></a>
					<input type="checkbox" name="" id="check_checkins" />
					
					<a href="#check_going" class="fakecheck" id="fake_check_going" title="Събития"></a>
					<input type="checkbox" name="" id="check_going" />
					
					<a href="#check_were" class="fakecheck" id="fake_check_were" title="Кой го е посетил"></a>
					<input type="checkbox" name="" id="check_were" />
					
					<!--
					<a href="#check_events" class="fakecheck" id="fake_check_events" title="Събития"></a>
					<input type="checkbox" name="" id="check_events" />
					-->
					
					<a href="#check_achievements" class="fakecheck" id="fake_check_achievements" title="Значки"></a>
					<input type="checkbox" name="" id="check_achievements" />
				</form>	
				
				<div class="cbox-middle br-reset"> 
					<form name="profileCommentForm" class="post-form">

	                    <div class="post-form-box">
	                    	<div class="txt-fake br4" id="comment_rich"></div>
							<textarea name="comment_text" id="comment_text" class="flexible-commentBox br4"></textarea>
							<div class="clear"></div>
	                    </div>
	    
	    				<div class="post-form-box">
    	                    <input id="comment_autocomplete" class="inputText" type="text" />	
							<input type="hidden" name="comment_json"/>
                            <input id="geotag_autocomplete" class="inputText" type="text" />
                            <input type="hidden" name="geotag_place_id" value="0"/>
						</div>
						
						<div class="clear"></div>
						
						<!--<div id="charsLeft"></div>-->
						
						<div class="post-meta br3">
							<a href="#?w=600" rel="uploader" class="px-btn br3 poplight"><span class="iphoto"></span> Добави файл</a>
							<div class="px-btn br3">
								<span class="fl">Сподели в</span>
								
								<a href="#fb" class="fakecheck" id="fakefb"></a>
								<input type="checkbox" name="fb" id="fb" checked="checked"/>
								
								<a href="#twitter" class="fakecheck" id="faketwitter"></a>
								<input type="checkbox" name="twitter" id="twitter" />
								
								<a href="#edno23" class="fakecheck" id="fakeedno23"></a>
								<input type="checkbox" name="edno23" id="edno23" />
								
								<a class="isettings"></a>
							</div>
							<a href="javascript:profileComment()" class="btn30 fr">Сподели</a>
						</div>
					</form><!-- end of post-form -->
					
					<!-- Attachments popups --> 
					<div id="uploader" class="popup_block">
					    <h3>Прикачи</h3>
					    <ul class="tabs-uploader">
					        <li><a href="#attachPhoto" class="attachPhoto-button">Снимки</a></li>
					        <li><a href="#attachVideo" class="attachVideo-button">Видео</a></li>
					    </ul>	
					    <div id="attachPhoto" class="tab_content fl" style="margin: 0px 20px 20px 20px;">
					    
					    	<div class="error"><span class="statusIcon"></span><span>Размерът на файла трябва да е до 3 MB.</span><a href="#" class="smallCloseBtn"></a></div>
 					    	<div class="warning"><span class="statusIcon"></span><span>Внимание, внимание!</span><a href="#" class="smallCloseBtn"></a></div>
					    	<div class="successful"><span class="statusIcon"></span><span>Файлът е качен успешно!</span><a href="#" class="smallCloseBtn"></a></div>
					    	
					    	<form action="">
					    		<div class="input-holder">
						    		<label class="label"><!-- <span class="iupload"></span> --> Качи</label> <input type="file" class="inputText" />
						    		<small>Разрешени формати: JPG, PNG, GIF</small>
					    		</div>
					    		<div class="input-holder">
						    		<label class="label"><!-- <span class="inet"></span> --> От нета</label> <input type="text" class="inputText" />
						    		<small>Пример: http://upload.wikimedia.org/wikipedia/commons/1/16/Tsarevets-Panorama.jpg</small>
					    		</div>
					    		<div class="input-holder">
						    		<input type="button" class="btn30 fr btn-padding" value="Прикачи" />
					    		</div>
					    	</form>	
					    	
					    	
					    </div>
					    <div id="attachVideo" class="tab_content fl" style="margin: 0px 20px 20px 20px;">
							<form action="">
					    		<div class="input-holder">
						    		<label class="label"><!-- <span class="inet"></span> --> От нета</label> <input type="text" class="inputText" />
						    		<small>Поддържани сайтове: YouTube, vbox7, Vimeo. <br />Пример: http://www.youtube.com/watch?v=JW4895399YQ</small>
					    		</div>
					    		<div class="input-holder">
					    			<div class="videoupload-underconstruction"></div>
						    		<label class="label"><!-- <span class="iupload"></span> --> Качи</label> <input type="file" class="inputText" />
						    		<small>Разрешени формати: MP4, AVI, WMV до 150mb.</small>
					    		</div>
					    		<div class="input-holder">
						    		<input type="button" class="btn30 fr btn-padding" value="Прикачи" />
					    		</div>
					    	</form>		
					    </div> 
					</div>
					<!-- end of Attachments popups -->
                    
                    
                  <div id="wallstream">  
                    
                  <? foreach($wallstream->result() as $item):?>
                     <div class="post-item" id="post-<?=$item->id;?>-<?=$item->w_type;?>">
						<a href="<?=profile_link($item->from_name);?>" class="avatar">
                        	<img src="<?=profile_avatar($item->from_id,50);?>" class="rounded" alt="" />
                        </a>
						<a href="<?=profile_link($item->from_name);?>" class="nickname">
							<?=profile_link($item->from_name);?>
                        </a>
						<span class="post"><?=$item->content;?></span>
                        
                        <? if(isset($item->pictures)):?>
						<div class="attachments">
                        	<? foreach($item->pictures->result() as $picture):?>
							<a href="pictures/<?=$picture->name."_600_400".$picture->ext;?>" target="_blank"><img src="pictures/<?=$picture->name."_100_100".$picture->ext;?>" alt="" style="width:100px;height:100px"/></a>
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

						<? if($item->comments):?>						
                        <div class="comment_tooltip"></div>
						<div class="post-reply">                        
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
						</div><!-- /. post-reply -->
						<? endif;?>
						
						<div class="comment_tooltip" style="display: none;"></div>
						<div class="post-reply-appender"></div>
						
					</div>
                  <? endforeach;?> 

				</div><!-- end of cbox-middle -->
				<a id="showMore" onclick="showMore()">Виж още</a>
                </div> <!-- End of wallstream -->

			</div><!-- end of cbox -->
			
		</div> <!-- end left-column -->

		<div class="right-column">
			<? get_user_helper();?>		
			<? get_popular_box();?>
			<? get_near_users();?>
        </div> <!-- end of right-column -->
		 
<? get_footer();?>