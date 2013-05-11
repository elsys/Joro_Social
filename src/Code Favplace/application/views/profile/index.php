<? get_header();?>
		<div class="left-column">
			<div class="cbox">
				<!--<h1>yordanoff</h1>-->

				<div class="cbox-middle br4">
				
						<h4 class="titleBlock br4" style="font-size: 24px; text-transform: none;">
							<a href="profile/<?=$profile->username;?>"><?=$profile->username;?></a>
						</h4>
						
						<div class="left-subcol">
			            	<img src="sources/images/place-sample.gif" alt="" width="200" height="200" />
			            	
			            	<a href="javascript:showLogin()" class="follow-btn">Проследи</a>  
			            	
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
				            			<a href="profile/favorite_places/<?=$profile->username;?>">
					            			<span class="icon"></span> 
					            			<span class="num"><?=$favorites_count;?></span>
				            			</a>
				            			<div class="clear"></div>
				            		</span>
		        					<a href="profile/favorite_places/<?=$profile->username;?>" class="was-btn"><b>Любими</b> <span></span></a>
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

					
				</div><!-- end of cbox-middle -->

				
			</div><!-- end of cbox -->

			
		</div> <!-- end left-column -->

		<div class="right-column">		
			<? get_popular_box();?>			
			<? get_near_users();?>
		</div> <!-- end of right-column -->
	
<? get_footer();?>