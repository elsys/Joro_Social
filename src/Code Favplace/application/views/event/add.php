<? get_header();?>
<script type="text/javascript" src="sources/js/event/add.js"></script>

		<div class="left-column">
			<div class="cbox br5-top">
				<h1>Създай събитие</h1> 				
				<div class="cbox-middle">      
				    	<form action="" class="cboxForm" name="eventAddForm" 
                        method="post" enctype="multipart/form-data" onsubmit="return test()" autocomplete="off">
				    		
				    		<div class="input-holder">
					    		<label class="label">Какво?</label>
		                        <input type="text" name="name" class="inputText" onkeyup="if(event.keyCode!=9) eventValidation.vFieldT('name')" onchange="eventValidation.vFieldT('name')"/>
					    		<small>Пример: D'n'B парти</small>
				    		</div><!-- / .input-holder -->
				    		
				    		
				    		<div class="input-holder">
					    		<label class="label">Кога?</label>
                                <input type="text" id="datepicker-1" class="inputText" style="width: 150px"/>
                                <input type="hidden" name="date_start" id="date_start"/>
                                <div class="hour">
                                    <select name="hour_start">
                                    <? for($i=0;$i<=23;$i++):?>
                                        <? if($i<10):?>
                                            <option value="0<?=$i;?>">0<?=$i;?>:00</option>
                                        <? else:?>
                                            <option value="<?=$i;?>"><?=$i;?>:00</option>
                                        <? endif;?>
                                    <? endfor;?>
                                    </select>
                                </div>
                                
		                        <a id="event-end-btn">Добави край</a>
		                        <span class="hour-desc">Начало</span>
		                        
		                        <div class="clear"></div>
		                        
		                        <div id="event-end">
			                        <input type="text" id="datepicker-2" class="inputText" style="width: 150px; float: left;" />
                                    <input type="hidden" name="date_end" id="date_end"/>
			                        <div class="hour">
				                        <select name="hour_end">
										<? for($i=0;$i<=23;$i++):?>
                                            <? if($i<10):?>
                                                <option value="0<?=$i;?>">0<?=$i;?>:00</option>
                                            <? else:?>
                                                <option value="<?=$i;?>"><?=$i;?>:00</option>
                                            <? endif;?>
                                        <? endfor;?>
				                        </select>
			                        </div>
									<span class="hour-desc">Край</span>
									<a id="event-end-remove-btn">(премахни)</a>
		                        </div><!-- / #event-end -->
				    		</div><!-- / .input-holder -->
				    		
				    		
				    		<div class="input-holder">
					    		<label class="label">Къде?</label>

                                <? if(isset($place)):?>
					    		<div class="checkbox_fix">
		                        	<input type="radio" name="place_choosing" 
                                    onclick="setDefaultPlace(this,<?=$place->id;?>)"  
                                    onchange="eventAddPlaceChoosing(1)" checked="checked"/>
                                    <a href="place/<?=$place->id;?>/<?=url_title($place->name);?>" target="_blank">
										<?=$place->name;?>
                                    </a>
		                        </div>
		                        <div class="clear"></div>
                                
                                <div class="checkbox_fix" style="margin: 10px 0px 0px 140px;">
		                        	<input type="radio" name="place_choosing" onchange="eventAddPlaceChoosing(2)"/>
									<a>
                                        Избери място
                                    </a>
		                        </div>
		                        <div class="clear"></div>						
                                <? endif;?>
		                        
								<div id="map-box" <? if( ! isset($place)) echo 'style="display:block"';?>>
									<div class="addMapHolder glow" style="margin-top: 10px;">
						    			<div class="map" id="eventAddMap" style="width: 100%; height: 100%; background: #eee;"></div>
						    		</div>
						    		
                                    <div>
					    			<input type="text" id="place_autocomplete" class="inputText" style="float: right; margin-right: 3px;"/>
                                    </div>
                                    <? if(isset($place)):?>
                                    <input type="hidden" name="place_id" value="<?=$place->id;?>"/>
                                    <? else:?>
                                    <input type="hidden" name="place_id" />
                                    <? endif;?>
						    		<small>Пример: гр. София, бул. България 32</small>					    		
					    		</div><!-- / #show-map -->
                                
							</div><!-- / .input-holder -->
							
							
							<div class="input-holder">
					    		<label class="label">Още инфо?</label>
					    		<textarea class="flexible-commentBox" style="width: 446px; height: 80px;" name="description"></textarea>
				    		</div><!-- / .input-holder -->
				    		
				    		
				    		<div class="input-holder">
					    		<label class="label">Публичност</label> 
					    		
					    		<div class="checkbox_fix">
		                        	<input type="radio" name="visible" value="1" checked="checked" /><span class="tooltip-r" title="Видимо за всички.">За всички</span>
		                        </div>

								<div class="clear"></div>
								
					    		<div class="checkbox_fix" style="margin: 10px 0px 0px 140px">		                        
			                        <input type="radio" name="visible" value="2" /><span class="tooltip-r" title="Видимо само за хората, които ви следят.">Само за приятели</span>
								</div>
		                        
		                        <div class="clear"></div> 
							</div><!-- / .input-holder -->
				    		
				    		
				    		<div class="input-holder">
					    		<label class="label">Добави снимка</label>
					    		<input type="file" name="picture"/>
				    		</div><!-- / .input-holder -->
				    
					<div class="clear"></div>
					<a class="btn30 big" onclick="eventAddSubmit()">Създай</a>
					
				</div><!-- end of cbox-middle -->				
			</div><!-- end of cbox -->			
		</div> <!-- end left-column -->

		<div class="right-column">		
			<? get_popular_box();?>			
			<? get_near_users();?>
		</div> <!-- end of right-column -->
<? get_footer();?>