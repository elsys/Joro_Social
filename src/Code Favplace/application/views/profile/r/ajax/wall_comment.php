							<div class="reply-box">
								<a href="profile/<?=$this->username;?>" class="avatar">
                                	<img src="<?=profile_avatar($this->profile_id);?>" class="rounded" alt="" />
                                 </a>
								<a href="profile/<?=$this->username;?>" class="nickname">
									<?=$this->username;?>
                                </a>
								<span class="post"><?=htmlspecialchars($comment);?></span>
							</div>