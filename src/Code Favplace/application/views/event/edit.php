<? get_header();?>
<script type="text/javascript" src="sources/js/event/edit.js"></script>
		<div class="left-column">
			<div class="cbox br5-top">
				<h1>Редактирай "<?=$event->name;?>"</h1> 
				
				<div class="cbox-middle">      
						
				    	<form action="" class="cboxForm" name="eventAddForm" 
                        method="post" enctype="multipart/form-data" onsubmit="eventEditSubmit()">
				    		
				    		<div class="input-holder">
					    		<label class="label">Какво?</label>
		                        <input type="text" name="name" class="inputText" value="<?=$event->name;?>"  onkeyup="if(event.keyCode!=9) eventValidation.vFieldT('name')" onchange="eventValidation.vFieldT('name')"/>
					    		<small>Пример: D'n'B парти</small>
				    		</div><!-- / .input-holder -->
				    		
				    		
				    		<div class="input-holder">
					    		<label class="label">Кога?</label>
		                        
		                        <input type="text" id="datepicker-1" class="inputText" style="width: 150px"/>
                                <input type="hidden" name="date_start" id="date_start" value=""/>
		                        <div class="hour">
			                        <select name="hour_start">
                                    <? for($i=0;$i<=23;$i++):?>
                                    	<? if($i<10):?>
                                        	<option value="0<?=$i;?>" 
											<?=set_selected($i,date("H",strtotime($event->date_start)));?>>
                                            	0<?=$i;?>:00
                                            </option>
                                        <? else:?>
                                        	<option value="<?=$i;?>" 
											<?=set_selected($i,date("H",strtotime($event->date_start)));?>>
												<?=$i;?>:00
                                            </option>
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
				                        <select name="hour_end" id="hour_end">
										<? for($i=0;$i<=23;$i++):?>
                                            <? if($i<10):?>
                                                <option value="0<?=$i;?>" 
                                                <?=set_selected($i,date("H",strtotime($event->date_end)));?>>
                                                	0<?=$i;?>:00
                                                 </option>
                                            <? else:?>
                                                <option value="<?=$i;?>" 
												<?=set_selected($i,date("H",strtotime($event->date_end)));?>>
													<?=$i;?>:00
                                                </option>
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
					    		
					    		<!-- този див се появява, само ако събитието е създадено от бутона "СЪЗДАЙ СЪБИТИЕ" на страница на дадено място -->
					    		<!-- ако събитието е създадено от страница СЪБИТИЯ -> "създай ново" този див го няма -->
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
		                        <!-- endif (btw изтрий ги тия html коментари) --> 
		                        
		                        <!-- ELSE 
				    		 	<a id="show-map-btn" style="margin: 7px 0px; float: left;">Избери място</a>
		                        ENDELSE -->
		                        
								<div id="map-box" <? if( ! isset($place)) echo 'style="display:block"';?>>
									<div class="addMapHolder glow" style="margin-top: 10px;">
						    			<div class="map" id="eventEditMap" style="width: 100%; height: 100%; background: #eee;"></div>
						    		</div>
						    		
					    			<input type="text" id="place_autocomplete" class="inputText" style="float: right; margin-right: 3px;"/>
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
					    		<textarea class="flexible-commentBox" style="width: 446px; height: 80px;" name="description"><?=$event->description;?></textarea>
				    		</div><!-- / .input-holder -->
				    		
				    		
				    		<div class="input-holder">
					    		<label class="label">Публичност</label> 
					    		
					    		<div class="checkbox_fix">
		                        	<input type="radio" name="visible" value="1" <?=set_checked($event->visible,1);?>/><span class="tooltip-r" title="Видимо за всички.">За всички</span>
		                        </div>

								<div class="clear"></div>
								
					    		<div class="checkbox_fix" style="margin: 10px 0px 0px 140px">		                        
			                        <input type="radio" name="visible" value="2" <?=set_checked($event->visible,2);?>/><span class="tooltip-r" title="Видимо само за хората, които ви следят.">Само за приятели</span>
								</div>
		                        
		                        <div class="clear"></div> 
							</div><!-- / .input-holder -->
				    		
				    		
				    		<div class="input-holder">
					    		<label class="label">Добави снимка</label>
					    		<input type="file" name="picture"/>
					    		
                                
					    		<div class="uploaded-image">
					    			
					    			<!-- при клик на самата снимка - тя става главна, при клик на линка изтрий - тя се изтрива и друга става главна -->
					    			<? if($event->picture):?>
					    			<div class="selected">
                                        <img src="<?=event_thumb($event);?>" alt="" />
							    		<a href="event/delete_main_picture/<?=$event->id;?>">Изтрий (главна)</a>
						    		</div>
                                    <? endif;?>
					    		</div><!-- / .uploaded-image -->
                                
				    		</div><!-- / .input-holder -->
				    
					<div class="clear"></div>
					<a class="btn30 big" onclick="eventEditSubmit()">Промени</a>
					
				</div><!-- end of cbox-middle -->
				
 
			</div><!-- end of cbox -->
			
		</div> <!-- end left-column -->

		<div class="right-column">		
			<? get_popular_box();?>			
			<? get_near_users();?>
		</div> <!-- end of right-column -->

	<script>

	$(document).ready(function(){
		$("#datepicker-1").datepicker( "setDate" , "<?=date("d.m.Y",strtotime($event->date_start));?>");
		<? if(substr($event->date_end,0,-9)!='0000-00-00'):?>		
		$("#event-end-btn").click();
		$("#datepicker-2").datepicker( "setDate" , "<?=date("d.m.Y",strtotime($event->date_end));?>");
		<? endif;?>
		
		// Intialize GMaps for event adding
		var myOptions = {
		  zoom: 15,
		  center: new google.maps.LatLng(<?=$place->coord_x;?>, <?=$place->coord_y;?>),
		  mapTypeId: google.maps.MapTypeId.HYBRID,
		  language: "bg"
		};
		
		eventEditMap = new google.maps.Map(document.getElementById("eventEditMap"),myOptions);	
		addEventMapMarker('<?=stripslashes($place->name);?>',<?=$place->coord_x;?>, <?=$place->coord_y;?>);
		// End of intialize GMaps for event adding		
	});
	
	</script>
<? get_footer();?>