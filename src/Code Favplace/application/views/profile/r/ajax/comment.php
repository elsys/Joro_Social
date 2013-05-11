                     <div class="post-item" id="post-<?=$item->id;?>-1">
						<a href="profile/<?=$this->username;?>" class="avatar">
                        	<img src="<?=profile_avatar($this->profile_id,50);?>" class="rounded" alt="" />
                        </a>
						<a href="profile/<?=$this->username;?>" class="nickname"><?=$this->username;?></a>
						<span class="post"><?=$item->comment;?>
						</span>
                        <!--
						<div class="attachments">
							<a href="#"><img src="sources/images/sample1.jpg" alt="" /></a>
							<a href="#"><img src="sources/images/sample2.jpg" alt="" /></a>
						</div>
                        -->
						<span class="meta">
							<a href="#" class="a_comments" title="Коментар"></a> <b class="middot fl">&middot;</b>
							<a href="#" class="a_photos" title="Снимка"></a> <b class="middot fl">&middot;</b>
							<a href="#" class="a_videos" title="Видео"></a>
							<b>&middot;</b> 
							<a href="#">@ Corona del Mar, California</a> 
							<b>&middot;</b> 
							<?=wall_date($item->date_diff,$item->date);?>
							<b>&middot;</b>  
							<a 
                            onclick="showWallCommentBox(this,<?=$item->id;?>,1)">
                            Коментирай</a> 
						</span>
                        
                        <div class="comment_tooltip"></div>
						<div class="post-reply">

						</div><!-- end of post-replies -->  
                        
                        <div class="comment_tooltip" style="display: none;"></div>
						<div class="post-reply-appender"></div>                      
					</div>