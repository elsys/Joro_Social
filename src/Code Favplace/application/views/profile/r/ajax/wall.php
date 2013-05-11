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
							<a href="#"><img src="pictures/<?=$picture->name."_200".$picture->ext;?>" alt="" style=""width:100px;height:100px"/></a>
                            <? endforeach;?>
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