		<div class="rbox">
				<h3>
					Наблизо
					<a href="#" class="px-btn br3">Наблизо</a>
				</h3>
				<div class="rbox-middle br-reset">
					<ul class="avatars-listing">
                    <? foreach($near_users->result as $near_user):?>                    
						<li>
                        	<a href="<?=profile_link($near_user->username);?>">
                            	<img src="<?=profile_avatar($near_user->id,50);?>" class="rounded" alt="" />
                            </a>
                        </li>
                    <? endforeach;?>
					</ul>
				</div>
				<div class="pagination">
					<a href="#" class="view-more"><span>Виж още</span><b class="arrow"></b></a>
				</div>
				
			</div> <!-- end of rbox -->
