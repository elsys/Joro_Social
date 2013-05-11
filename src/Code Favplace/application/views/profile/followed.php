<? get_header();?>
		<div class="left-column">
			<div class="cbox">
				<!--<h1>yordanoff</h1>-->

				<div class="cbox-middle br4">
				
						<h4 class="titleBlock br4" style="font-size: 24px; text-transform: none;">
							<?php /* <a href="profile/<?=$profile->username;?>"><?=$profile->username;?></a> */ ?>
						</h4>
						
						<div class="text-description">
							<div class="filterBox br3" style="width: 600px;">	
		
								<form action="" id="viewSwitch">
									<input type="radio" id="vs1" name="radio" checked="checked" /> <label for="vs1" id="vs1"></label>
									<input type="radio" id="vs2" name="radio" /> <label for="vs2" id="vs2"></label>
								</form> 
								
								<div class="clear"></div>
							</div><!-- end of filterBox -->
							
							<div class="clear"></div>		 					
							
							<!--<div class="thumbsView">-->
							
							<div class="thumbsView users">
							
                            <script>
							function profileUnfollow(username,a)
							{
								a.innerHTML="Моля изчакайте...";
								
								$.ajax({
								 type: "GET",
								 url: "profile/unfollow/"+username,
								 dataType: "json",
								 success: function(response){
									if(response.status=="ok"){
										var box=a.parentNode;
										box.parentNode.removeChild(box);
									}
									else if(response.status=="error") alert(response.description);
								 },
								 error: function (msg){
									  alert("Възникна грешка при свързване със сървъра.");   
								 }
							  });
							}
							</script>
                            
                            <? foreach($followed->result() as $profile):?>
								<div class="ibox br4">
									<h4>
                                    	<a href="<?=profile_link($profile->username);?>"><?=$profile->username;?></a>
                                    </h4>	
									<a href="<?=profile_link($profile->username);?>">
                                    	<img src="<?=profile_avatar($profile->followed_id,150);?>" alt="" height="160" />
                                    </a>
                                    <? if($profile->follower_id==$this->profile_id):?>
                                    <a onclick="profileUnfollow('<?=$profile->username;?>',this)"                                     class="follow-btn following">
                                        <span class="cur">Следиш го / я</span>
                                        <span class="action">Спри следенето</span>
                                    </a>
                                    <? endif;?>
								</div><!-- / .ibox user -->
                            <? endforeach;?>
								
							</div><!-- end of empty div -->
						
						</div>
				              				    
					<div class="clear"></div>

					
					
				</div><!-- end of cbox-middle -->
				
				<div class="pagination">
					<ul>
						<?=$this->pagination->create_links();?>
					</ul>
				</div> 
				
			</div><!-- end of cbox -->

			
		</div> <!-- end left-column -->

		<div class="right-column">		
			<? get_popular_box();?>			
			<? get_near_users();?>
		</div> <!-- end of right-column -->
	
<? get_footer();?>