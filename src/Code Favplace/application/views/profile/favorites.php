<? get_header();?>
	
		<div class="one-column">
			<div class="cbox br5 thumbsView" id="jsHolder">
				<!--<h3>Активност</h3>-->
				<div class="cbox-middle"> 
					
					<div class="filterBox br3">	
						
						<div class="sortBy">
							<small>Покажи: </small>
							<select class="comboSelect fl">
								<option value="1">Най-нови</option>
								<option value="2">Най-стари</option>
								<option value="2">Посещения</option>
								<option value="3">Коментари</option>
								<option value="4">Официални профили</option> 
							</select>
						</div>
						
						<div class="sortBy">
							<select class="comboSelect fl" style="position: relative; margin-left: 300px;">
								<option value="1">Всички категории</option>
								<option value="2">Заведения</option>
								<option value="2">Нощен живот</option>
								<option value="3">Забавления</option>
								<option value="4">Забележителности и природа</option>
								<option value="5">Хотели, вили и други</option>
								<option value="6">Всекидневни</option> 
							</select>
						</div> 

						<form action="" id="viewSwitch">
							<input type="radio" id="vs1" name="radio" checked="checked" /> <label for="vs1" id="vs1"></label>
							<input type="radio" id="vs2" name="radio" /> <label for="vs2" id="vs2"></label>
						</form> 
						
						<div class="clear"></div>
					</div><!-- end of filterBox -->
					
					<div class="clear"></div>		 					
					
					<!--<div class="thumbsView">-->
					
					<div>
					
                    <? foreach($places->result() as $place):?>
						<div class="ibox br4 cat-1">
							<h4>
                            	<a href="place/<?=$place->id;?>/<?=url_title($place->name);?>">
									<?=$place->name;?>
                                </a>
                            </h4>	
							
							<a href="#"><img src="sources/images/place-sample.gif" alt="" /></a>
							
							<em>Заведения</em><span class="icat"></span>
							
			            	<div class="subcat">
			            		<a href="#">Заведения</a>, <a href="#">Дискотеки</a>
			            	</div>
			            	
			            	<div class="iboxDescription">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries
			            	</div>
			            	
			            	<div class="metainfo">
			            		<span class="here-small"></span><span class="smallInfo"><b>Посетено:</b> 234</span>
				            	<span class="fav-small"></span><span class="smallInfo" style="background: none;"><b>Любимо:</b> 314</span>
				            	<a href="#" class="px-btn br3">Повече &raquo;</a>
			            	</div>
						</div>		 			
					<? endforeach?>	
                    <!--
						<div class="ibox br4 cat-2">
							<h4><a href="#">Starbucks The Mall</a></h4>	
							
							<a href="#"><img src="sources/images/place-sample.gif" alt="" /></a>
							
							<em>Заведения</em><span class="icat"></span>
							
			            	<div class="subcat">
			            		<a href="#">Заведения</a>, <a href="#">Дискотеки</a>
			            	</div>
			            	
			            	<div class="iboxDescription">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries
			            	</div>
			            	
			            	<div class="metainfo">
			            		<span class="here-small"></span><span class="smallInfo"><b>Посетено:</b> 234</span>
				            	<span class="fav-small"></span><span class="smallInfo" style="background: none;"><b>Любимо:</b> 314</span>
				            	<a href="#" class="px-btn br3">Повече &raquo;</a>
			            	</div>
						</div>	
						
						<div class="ibox br4 cat-3">
							<h4><a href="#">Starbucks The Mall</a></h4>	
							
							<a href="#"><img src="sources/images/place-sample.gif" alt="" /></a>
							
							<em>Заведения</em><span class="icat"></span>
							
			            	<div class="subcat">
			            		<a href="#">Заведения</a>, <a href="#">Дискотеки</a>
			            	</div>
			            	
			            	<div class="iboxDescription">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries
			            	</div>
			            	
			            	<div class="metainfo">
			            		<span class="here-small"></span><span class="smallInfo"><b>Посетено:</b> 234</span>
				            	<span class="fav-small"></span><span class="smallInfo" style="background: none;"><b>Любимо:</b> 314</span>
				            	<a href="#" class="px-btn br3">Повече &raquo;</a>
			            	</div>
						</div>	
						
						<div class="ibox br4 cat-4">
							<h4><a href="#">Starbucks The Mall</a></h4>	
							
							<a href="#"><img src="sources/images/place-sample.gif" alt="" /></a>
							
							<em>Заведения</em><span class="icat"></span>
							
			            	<div class="subcat">
			            		<a href="#">Заведения</a>, <a href="#">Дискотеки</a>
			            	</div>
			            	
			            	<div class="iboxDescription">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries
			            	</div>
			            	
			            	<div class="metainfo">
			            		<span class="here-small"></span><span class="smallInfo"><b>Посетено:</b> 234</span>
				            	<span class="fav-small"></span><span class="smallInfo" style="background: none;"><b>Любимо:</b> 314</span>
				            	<a href="#" class="px-btn br3">Повече &raquo;</a>
			            	</div>
						</div>	
						
						<div class="ibox br4 cat-5">
							<h4><a href="#">Starbucks The Mall</a></h4>	
							
							<a href="#"><img src="sources/images/place-sample.gif" alt="" /></a>
							
							<em>Заведения</em><span class="icat"></span>
							
			            	<div class="subcat">
			            		<a href="#">Заведения</a>, <a href="#">Дискотеки</a>
			            	</div>
			            	
			            	<div class="iboxDescription">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries
			            	</div>
			            	
			            	<div class="metainfo">
			            		<span class="here-small"></span><span class="smallInfo"><b>Посетено:</b> 234</span>
				            	<span class="fav-small"></span><span class="smallInfo" style="background: none;"><b>Любимо:</b> 314</span>
				            	<a href="#" class="px-btn br3">Повече &raquo;</a>
			            	</div>
						</div>	
						
						<div class="ibox br4 cat-6">
							<h4><a href="#">Starbucks The Mall</a></h4>	
							
							<a href="#"><img src="sources/images/place-sample.gif" alt="" /></a>
							
							<em>Заведения</em><span class="icat"></span>
							
			            	<div class="subcat">
			            		<a href="#">Заведения</a>, <a href="#">Дискотеки</a>
			            	</div>
			            	
			            	<div class="iboxDescription">
								Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries
			            	</div>
			            	
			            	<div class="metainfo">
			            		<span class="here-small"></span><span class="smallInfo"><b>Посетено:</b> 234</span>
				            	<span class="fav-small"></span><span class="smallInfo" style="background: none;"><b>Любимо:</b> 314</span>
				            	<a href="#" class="px-btn br3">Повече &raquo;</a>
			            	</div>
						</div>							
					</div>		
					-->		 					
							 					
				</div><!-- end of cbox-middle -->
				
				<div class="pagination">
					<ul>
                    	<? /*$this->pagination->create_links();*/?>
                        <!--
						<li class="next"><a href="#"><span>Следваща</span><b class="arrow"></b></a></li>
						<li class="prev"><a href="#"><b class="arrow"></b><span>Предишна</span></a></li>
                        -->
					</ul>
				</div>

			</div><!-- end of cbox -->
			
		</div> <!-- end left-column -->


		 
<? get_footer();?>