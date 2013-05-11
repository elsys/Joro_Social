<? get_header();?>

<? get_customize_tools(); ?>

		<div class="left-column">
			<div class="cbox br5-top">
				<h1 class="business_title"><?=htmlspecialchars($place->name);?></h1>
			
				<ul class="tabs dot">
			        <li><a href="#info">Инфо</a></li>
			        <li><a href="#tab2">Галерия</a></li>
			        <li><a href="#tab3">Меню</a></li>
			        <li><a href="#tab4">Събития</a></li> 
					<li><a href="#tab5">Карта</a></li>
					<li><a href="#tab6">Фенове</a></li> 
			    </ul>

				<div class="cbox-middle">    
				    <div class="tab_container">
				        <div id="info" class="tab_content">
				            
				            <div class="left-subcol">
				            	<img src="sources/images/place-sample.gif" alt="" width="200" height="103" />
				            	
				            	<div class="cat">
					            	<a href="#" class="cat-1"><em>Заведения</em><span class="icat"></span></a>
					            	<div class="subcat">
					            		<a href="#">Заведения</a>, <a href="#">Дискотеки</a>
					            	</div>
				            	</div>
				            	
				            	<div class="box"> 
					            	<div class="subcat">
					            		<a href="#">София</a>, 
					            		<br /><a href="#">бул. Лорем Ипсум 192</a> <!-- view it on the map -->
					            	</div>
				            	</div>
				            	
				            	<div class="box"> 
					            	<div class="subcat">
					            		<a href="#" target="_blank" rel="nofollow">thewebsite.bg</a>
					            		<br />
					            		<a href="#" class="phone">02 / 123 42 23</a>
					            		<a href="#">Skype status</a>
					            		<a href="#">Facebook icon</a> <!-- view it on the map -->
					            	</div>
				            	</div>
				            </div>
				            
				            <div class="right-subcol">
								<div class="checkin-box">
								
					            	<div class="checkin">
					            		<span class="col1">
					            			<a href="#">
						            			<span class="icon"></span> 
						            			<span class="num">42</span>
						            			
						            			<span class="me">
						            				<b>Аз:</b> <span>4 пъти</span>
						            			</span>
					            			</a>
					            			<div class="clear"></div>
					            		</span>
		            					<a href="#" class="here-btn"><b>Тук съм</b> <span></span></a>
					            	</div>
					            	
					            	<div class="checkin">
					            		<span class="col2">
					            			<a href="#">
						            			<span class="icon"></span> 
						            			<span class="num">4</span>
						            			
						            			<span class="me">
						            				<b>Аз:</b> <span>22 Сеп, 22:30</span>
						            			</span>
					            			</a>
					            			<div class="clear"></div>
					            		</span>
		            					<a href="#" class="going-btn"><b>Отивам</b> <span></span></a>
					            	</div>
					            	
					            	<div class="checkin">
					            		<span class="col3">
					            			<a href="#">
						            			<span class="icon"></span> 
						            			<span class="num" id="placeFavoritesNum">
													<?=$place_favorites_count;?>
                                                </span>						            			
						            			<span class="me">
						            				<b>Аз:</b> <span>(?)</span>
						            			</span>
					            			</a>
					            			<div class="clear"></div>
					            		</span>
                                        <script>
										function addPlaceToFavorites(place_id)
										{
											$.ajax({
											  type: "post",
											  url: "profile/favorite_place/add",
											  dataType: 'json',
											  data: {"place_id":place_id},
											  success:  function(data) {
												if(data.status=="ok"){
													$("#placeFavoritesNum").html(data.favorites_count);
												}
												else if(data.status=="error") alert(data.description);
											  },
											  error: function (XMLHttpRequest, textStatus, errorThrown)
											  {
												alert("Възникна грешка при свързване със сървъра."+errorThrown);  
											  }
											});	
										}
										</script>
		            					<a class="was-btn" onclick="addPlaceToFavorites(<?=$place->id;?>)">
                                        	<b>Любимо!</b> <span></span>
                                        </a>
					            	</div>
				            	
				            	</div><!-- end of checkin-box -->
				            	
				            	<div class="text-description">
                                	 <?=$place->description;?>
				            		 <a href="#">Чети нататък &raquo;</a>
				            	</div>
				            	
				            </div><!-- end of right-subcol -->
				            
				            
				            <div class="additional-info">
				            	
				            	<ul class="col">
									<li><b>Отворено:</b> <?=$place->work_time;?></li>
									<li><b>Цени:</b> 10-20лв / човек</li>
									<li><b>Паркинг:</b> Собствен</li>
				            	</ul>
				            	<ul class="col">                                   
                                    <? $place_tags_c=0;?>
                                    
                                    <? $place_tag=$place_tags->next_row();?>
                                	<? while($place_tag):?>
                                    <? if($place_tags_c==floor($place_tags->num_rows()/2)) break; ?>
                                    <li>
                                    	<b><?=$place_tag->name;?>:</b>
                                        <span class="check-<?=$place_tag->status?'yes':'no';?>"></span>
                                        <div class="clear"></div>                                     
                                        <? $place_tags_c++;?>
                                        <? $place_tag=$place_tags->next_row();?>
                                    </li>	
                                    <? endwhile;?>
				            	</ul>
				            	<ul class="col">
                                	<? while($place_tag):?>
                                    <? if($place_tags_c==$place_tags->num_rows()) break; ?>
                                    <li>
                                    	<b><?=$place_tag->name;?>:</b>
                                        <span class="check-<?=$place_tag->status?'yes':'no';?>"></span>
                                        <div class="clear"></div>                                     
                                        <? $place_tags_c++;?>
                                        <? $place_tag=$place_tags->next_row();?>
                                    </li>	
                                    <? endwhile;?>
				            	</ul>
				            	
				            </div><!-- end of additional-info -->
				            
				            
				        </div><!-- end of tab1 -->
				        
				        <div id="tab2" class="tab_content">
				        
				        	<div class="meta-controls">
				        		<a href="#" class="act">Всички снимки</a> <b class="middot">&middot;</b> <a href="#">Само от потребители</a> <b class="middot">&middot;</b> <a href="#">Само от собственика</a>
				        	</div>
				        	
				        	<div class="clear"></div>
				        	
							<div id="gallery" class="ad-gallery">
								<div class="ad-image-wrapper"></div>
								<div class="ad-nav">
									<div class="ad-thumbs">
									  <ul class="ad-thumb-list">
											<li>
								              <a href="sources/images/samples/1.jpg">
								                <img src="sources/images/samples/thumbs/t1.jpg" class="image0">
								              </a>
								            </li>
								            <li>
								              <a href="sources/images/samples/10.jpg">
								                <img src="sources/images/samples/thumbs/t10.jpg" alt="" class="image1">
								              </a>
								            </li>
								            <li>
								              <a href="sources/images/samples/11.jpg">
								                <img src="sources/images/samples/thumbs/t11.jpg" alt="" class="image2">
								              </a>
								            </li>
								            <li>
								              <a href="sources/images/samples/12.jpg">
								                <img src="sources/images/samples/thumbs/t12.jpg" alt="" class="image3">
								              </a>
								            </li>
								            <li>
								              <a href="sources/images/samples/13.jpg">
								                <img src="sources/images/samples/thumbs/t13.jpg" alt="" class="image4">
								              </a>
								            </li>
								            <li>
								              <a href="sources/images/samples/14.jpg">
								                <img src="sources/images/samples/thumbs/t14.jpg" alt="" class="image5">
								              </a>
								            </li>
									  </ul>
									</div>
								</div><!-- end of ad-nav -->
								
								<div style="width: 100%;text-align: center; float: left;">
									<div class="carouselNav">
										<div class="ad-controls"></div>
									</div>							
								</div>
						</div><!-- end of gallery -->

				        </div><!-- end of tab2 -->
				        
				        <div id="tab3" class="tab_content">
				            3
				        </div>
				        <div id="tab4" class="tab_content">
				            4
				        </div>
				        <div id="tab5" class="tab_content">
				            5
				        </div>
				        <div id="tab6" class="tab_content">
				            6
				        </div>
				    </div>  
				    
					<div class="clear"></div>
					
				</div><!-- end of cbox-middle -->
				
 
			</div><!-- end of cbox -->
			
		</div> <!-- end left-column -->

		<div class="right-column">		
			<? get_popular_box();?>			
			<? get_near_users();?>
		</div> <!-- end of right-column -->

<div id="c_css">
	<style type="text/css" id="c_css"></style>
</div>
	
<? if($customization) : ?>
<style type="text/css">
	<?= $customization->css; ?>
</style>
<? endif; ?>
	
<? get_footer();?>