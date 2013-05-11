<? get_header();?>
<link href="sources/js/uploadify/uploadify.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="sources/js/uploadify/swfobject.js"></script>
<script type="text/javascript" src="sources/js/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript" src="sources/js/place/add.js"></script>
<script type="text/javascript">
var placeAddUrl='<?=base_url();?>/place/add/pictures/<?=$this->session_id;?>/'
</script>

		<div class="left-column">
			<div class="cbox br5-top">
				<h1>Добавяне на място</h1> 
				
				<div class="cbox-middle">    
				    <div class="tab_container">
				    	<form class="cboxForm" name="placeAddForm" id="placeAddForm" autocomplete="off">
				        <div id="placeAddSteps-1" class="tab_content">
				            
				            <div class="step1"></div>
							<div class="clear"></div> 
							
					    	
					    		<h4 class="titleBlock br4">Основна информация</h4>
					    		
						    	<div class="input-holder">
						    		<label class="label">Име</label>
                                    <input type="text" name="name" class="inputText" onkeyup="if(event.keyCode!=9) placeValidation.vFieldT('name')" onchange="placeValidation.vFieldT('name')"/>
						    		<small>Пример: Дон Домат 3 &middot; Starbucks бул. Васил Левски &middot; Fibank Младост</small>
					    		</div>

					    		<div class="input-holder">
						    		<label class="label">Адрес</label> 
						    		
						    		<div class="addMapHolder glow">
						    			<div class="map" id="placeAddMap" style="width: 100%; height: 100%; background: #eee;"></div>
						    		</div>
						    		
						    		<input type="text" id="address" name="address" class="inputText" style="float: right; margin-right: 3px;"/>
						    		<small>Пример: гр. София, бул. България 32</small>
					    		</div>
					    		
					    		<div class="input-holder none">
						    		<label class="label">Категория</label>  
                                    
									<? $place_subcategory_num=1;?>
                                    <? foreach($place_subcategories as $root_category=>$subcategories):?>	
                                        <div id="subCatList<?=$root_category;?>" class="tagsHelper clean catColor<?=$root_category;?>">
                                        
                                        <? foreach($subcategories->result() as $place_subcategory):?>
                                            <a href="#addSuggest-<?=$place_subcategory_num;?>" class="fakecheck">
												<?=$place_subcategory->name;?>
                                            </a>
                                            <input type="checkbox" name="subcategories[]" id="addSuggest-<?=$place_subcategory_num;?>" value="<?=$place_subcategory->id;?>"/>
                                            <? $place_subcategory_num++;?>
                                         <? endforeach?>
                                        </div>
                                    <? endforeach?>
					    		</div> 
                                
                                <input type="hidden" name="coord_x" />
                                <input type="hidden" name="coord_y" />
                                <input type="hidden" name="coord_country" />
                                <input type="hidden" name="coord_district" />
                                <input type="hidden" name="coord_municipality" />
                                <input type="hidden" name="coord_city" />
                                
                                <div class="input-holder" style="border: 0px;">
                                	<a class="fr btn30" style="margin-left:10px;" id="finishPlaceAdd-1">Приключи</a>
						    		<a class="fr btn30" id="step2Btn">Стъпка 2 &raquo;</a>
                                    
					    		</div>
					    		 
							<div class="clear"></div>
				            
				        </div><!-- end of step1 tab -->
				         

                                
				        <div id="placeAddSteps-2" style="display:none">
				            
				            <div class="step2"></div>
							
							<div class="clear"></div>
					    	
					    	
					    		<h4 class="titleBlock br4">Допълнителна информация</h4>
					    		<div class="input-holder">
						    		<label class="label">Описание</label>
						    		<textarea class="flexible-commentBox" style="width: 446px; height: 80px;" name="description"></textarea>
					    		</div>
					    		
						    	<div class="input-holder">
						    		<label class="label">Работно време</label>
                                    <input type="text" class="inputText" name="work_time"/>
						    		<small>Пример: Понеделник - Неделя, 11ч - 24ч</small>
					    		</div>
					    		
					    		<div class="input-holder">
						    		<!--<label class="label">Други</label>-->
						    		<div class="tagsHelper checkboxHelper colSimulation" style="margin-left: 0px;"> 
                                    <? foreach($place_tags->result() as $place_tag):?>
                                    	<a href="#placeAddTag-<?=$place_tag->id;?>" class="fakecheck">
                                        	<?=$place_tag->name;?>
                                        </a>
										<input type="checkbox" name="tags[]" id="placeAddTag-<?=$place_tag->id;?>" value="<?=$place_tag->id;?>"/>
                                    <? endforeach?>
						    		</div>
					    		</div>
                                
                            <div class="input-holder" style="border: 0px;">
                           		 <a class="fr btn30" style="margin-left:10px;" id="finishPlaceAdd-2">Приключи</a>
                                <a class="fr btn30" id="step3Btn">Стъпка 3 &raquo;</a>
                            </div>

							<div class="clear"></div>
				            
				        </div><!-- end of step2 -->
					</form>


						<div id="placeAddSteps-3" style="display:none">
				            
				            <div class="step3"></div>
							<div class="clear"></div>
					    	
					    	
							<h4 class="titleBlock br4">Снимки</h4>
                            <div class="input-holder">
                                <label class="label">Качи снимка</label>
                                <input type="file" id="placeAddUpload" class="inputText" />
                                <small>Разрешени формати: JPG, PNG, GIF</small>
                            </div>
                            
                            <div class="input-holder" style="border: 0px;">
                                <a href="#step2" class="fr btn30" style="margin-left:10px;"
                                 id="finishPlaceAdd-3">Приключи</a>						    		
					    	</div>
						    
							<div class="clear"></div>
				            
				        </div><!-- end of tab2 -->
 
					</div><!-- end of tab_container -->
				    
					<div class="clear"></div>
					
				</div><!-- end of cbox-middle -->
				
 
			</div><!-- end of cbox -->
			
		</div> <!-- end left-column -->

		<div class="right-column">		
			<? get_popular_box();?>			
			<? get_near_users();?>
		</div> <!-- end of right-column -->
	
<? get_footer();?>