<? get_header();?>
	
		<div class="left-column">
			<div class="cbox br5-top">
				
				<h3>Активност</h3>
				<form id="" class="tab-checkers">
		        	<small>Покажи: </small>
		        	<a href="#check_comments" class="fakecheck fakechecked" id="fake_check_all" title=""></a>
					<input type="checkbox" name="" id="check_all" />
					
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
				
				<div class="cbox-middle br-reset"> 

					<form action="" id="" class="post-form">
						<textarea id="postform" class="br4"></textarea>
						 
						<div id="charsLeft"></div>
						
						<div class="post-meta br3">
							<a href="#?w=600" rel="uploader" class="px-btn br3 poplight"><span class="iphoto"></span> Добави файл</a>
							<!--<a href="#" class="px-btn br3"><span class="ivideo"></span> Добави видео</a>-->
							<div class="px-btn br3">
								<span class="fl">Сподели в</span>
								
								<a href="#fb" class="fakecheck" id="fakefb"></a>
								<input type="checkbox" name="fb" id="fb" checked="checked" checked="yes" />
								
								<a href="#twitter" class="fakecheck" id="faketwitter"></a>
								<input type="checkbox" name="twitter" id="twitter" />
								
								<a href="#edno23" class="fakecheck" id="fakeedno23"></a>
								<input type="checkbox" name="edno23" id="edno23" />
								
								<a class="isettings"></a>
							</div>
							<a href="#" class="btn30 fr">Сподели</a>
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
					
					<div class="post-item">
						<a href="#" class="avatar"><img src="sources/images/avatar.jpg" class="rounded" alt="" /></a>
						<a href="#" class="nickname">yordanoff</a>
						<span class="post">В имение за $75 мил. :) Всеки ъгъл на къщата е обзаведен в екстравагантен стил и невиждан лукс. Разгърнат върху 6700м² <a href="#">Portabello</a> е идеалното място за релаксация.
						</span>
						<span class="meta">
							<a href="#" class="a_comments" title="Коментар"></a>
							<b>&middot;</b> 
							<a href="#">@ Corona del Mar, California</a> 
							<b>&middot;</b> 
							Преди 3 мин  
							<b>&middot;</b>  
							<a href="#">Коментирай</a> 
						</span>
						
						<div class="comment_tooltip"></div>
						<div class="post-reply">
							
							<div class="reply-box">
								<a href="#" class="avatar"><img src="sources/images/avatar.jpg" class="rounded" alt="" /></a>
								<a href="#" class="nickname">yordanoff</a>
								<span class="post">В имение за $75 мил. :)</span>
							</div>
							
							<div class="reply-box">
								<a href="#" class="avatar"><img src="sources/images/avatar.jpg" class="rounded" alt="" /></a>
								<a href="#" class="nickname">yordanoff</a>
								<span class="post">В имение за $75 мил. :)</span>
							</div>
							
							<div class="reply-box">
								<a href="#" class="avatar"><img src="sources/images/avatar.jpg" class="rounded" alt="" /></a>
								<a href="#" class="nickname">yordanoff</a>
								<span class="post">Дааааааааа ве, сигурно!</span>
							</div>
						
							<form action="" id="" class="singlePostForm">
								<textarea class="flexible-commentBox"></textarea>
								<input type="button" class="reply-postbtn" value="Пусни" /> 
							</form>
						
						</div><!-- end of post-replays -->
					</div>
					
					<div class="post-item">
						<a href="#" class="avatar"><img src="sources/images/avatar.jpg" class="rounded" alt="" /></a>
						<a href="#" class="nickname">yordanoff</a>
						<span class="post">В имение за $75 мил. :) Всеки ъгъл на къщата е обзаведен в екстравагантен стил и невиждан лукс. Разгърнат върху 6700м² <a href="#">Portabello</a> е идеалното място за релаксация.
						</span>
						<div class="attachments">
							<a href="#"><img src="sources/images/sample1.jpg" alt="" /></a>
							<a href="#"><img src="sources/images/sample2.jpg" alt="" /></a>
						</div>
						<span class="meta">
							<a href="#" class="a_comments" title="Коментар"></a> <b class="middot fl">&middot;</b>
							<a href="#" class="a_photos" title="Снимка"></a> <b class="middot fl">&middot;</b>
							<a href="#" class="a_videos" title="Видео"></a>
							<b>&middot;</b> 
							<a href="#">@ Corona del Mar, California</a> 
							<b>&middot;</b> 
							Преди 3 мин  
							<b>&middot;</b>  
							<a href="#">Коментирай</a> 
						</span>
					</div>
					
				</div><!-- end of cbox-middle -->
				


			</div><!-- end of cbox -->
			
		</div> <!-- end left-column -->

		<div class="right-column">
			<? get_user_helper();?>		
			<? get_popular_box();?>
			<? get_near_users();?>
        </div> <!-- end of right-column -->
		 
<? get_footer();?>