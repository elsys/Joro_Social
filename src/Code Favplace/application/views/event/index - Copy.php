<? get_header();?>
		<div class="left-column">
			<div class="cbox br5-top">
				<h1><?=$event->name;?></h1>
			
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
				            	<img src="<?=event_thumb($event);?>" alt=""/>
				            	
				            	<div class="box">
				            		<div class="subcat">
				            			<a href="#" class="going-btn" style="width: 198px; margin: 0px; border: 1px solid #e8e8e8;"><b>Отивам</b> <span></span></a>
				            		</div>
				            	</div>
				            	
				            	<div class="box">
					            	<div class="subcat">
					            		<b style="margin-bottom: 3px; float: left; width: 100%;">Начало</b>
					            		<br />
										<?=event_info_date($event->date_start);?>
                                        <b class="middot">&middot;</b><?=event_info_time($event->date_start);?>
					            	</div>
				            	</div>
				            	
                                <? if(event_info_date_exists($event->date_end)):?>                               
				            	<div class="box">
					            	<div class="subcat">
					            		<b style="margin-bottom: 3px; float: left; width: 100%;">Край</b>
					            		<br /><?=event_info_date($event->date_end);?>
                                        <b class="middot">&middot;</b><?=event_info_time($event->date_end);?>
					            	</div>
				            	</div>                               
                                <? endif;?>
				            	
				            	<div class="box"> 
					            	<div class="subcat">
										<?=event_info_visibility($event->visible);?>
					            	</div>
				            	</div>
				            	
				            	<div class="box"> 
					            	<div class="subcat">
										<b style="margin-bottom: 3px; float: left; width: 100%;">Създател</b> 
										<br />
                                        <a href="<?=$event->creator;?>" style="color: #1a74c7;">
											<?=$event->creator;?>
                                        </a>
					            	</div>
				            	</div> 
				            </div>
				            
				            <div class="right-subcol">
				            
				            	<!--
								<div class="checkin-box">
					            	
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
				            	
				            	</div>< end of checkin-box -->
				            	
				            	<div class="text-description" style="margin-top: 0px;">
                                	 <?=$event->description;?>
				            		 <!-- <a href="#">Чети нататък &raquo;</a>-->
				            	</div>
				            	
				            </div><!-- end of right-subcol --> 
				            
				            <img src="sources/images/sample_map.jpg" style="-moz-border-radius: 5px; padding: 3px; border: 1px solid #eee; margin-top: 12px;" width="601" alt="temporary" />
				            
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
	
<? get_footer();?>