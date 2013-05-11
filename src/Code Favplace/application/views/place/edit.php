<? get_header();?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=bg"></script>
<script type="text/javascript">

  var placeMap;
  var geocoder;
  var lastPlaceAddMarker;
  var lastPlaceAddResult;
  var infowindow;

  function initializePlaceMap() {
	// toSource()
    var myOptions = {
      zoom: 16,
      mapTypeId: google.maps.MapTypeId.HYBRID,
	  language: "bg",
	  center:new google.maps.LatLng(<?=$place->coord_x;?>,<?=$place->coord_y;?>)
    };

    placeMap = new google.maps.Map(document.getElementById("placeAddMap"),myOptions);		
	geocoder = new google.maps.Geocoder();
	infowindow = new google.maps.InfoWindow();
	
	google.maps.event.addListener(placeMap, 'click', function(event) {
		if(lastPlaceAddMarker){
			lastPlaceAddMarker.setMap(null);
			lastPlaceAddMarker=null;	
		}

		geocoder.geocode({'latLng': event.latLng}, function(results, status) {
		  if (status == google.maps.GeocoderStatus.OK) {
			if (results[0]) {
				lastPlaceAddMarker=new google.maps.Marker({
				  position: event.latLng, 
				  map: placeMap, 
				  draggable: true,
				  animation: google.maps.Animation.DROP,
				  title:"Място на обекта"
				});	
				
				lastPlaceAddResult=results[0];
				
				setCoords(lastPlaceAddResult);
					
				google.maps.event.addListener(lastPlaceAddMarker, 'click', function() {
					placeMap.setCenter(lastPlaceAddMarker.position);
					placeMap.setZoom(16);
				});
				google.maps.event.addListener(lastPlaceAddMarker, 'dragend', function() {
					setCoords(lastPlaceAddResult);
				});
			  infowindow.setContent(results[0].formatted_address);
			  infowindow.open(placeMap, lastPlaceAddMarker);
			}
		  } else {
			alert("Geocoder failed due to: " + status);
		  }
		});
    });
	
	lastPlaceAddMarker = new google.maps.Marker({
		map: placeMap, 
		position: new google.maps.LatLng(<?=$place->coord_x;?>, <?=$place->coord_y;?>),
		draggable: true,
		animation: google.maps.Animation.DROP,
		title: '<?=$place->name;?>'
	});
  }
  

  $(document).ready(function () {
	  initializePlaceMap();
  });
  
  function setCoords(result)
  {
	  var location=result.geometry.location.toString();
	  location=location.split(",");
	  var coord_x=location[0].substr(1,location[0].length);
	  var coord_y=location[1].substr(0,location[1].length-1);
	  
	  var form=document.placeAddForm;
	  
	  form.coord_city.value='';
	  form.coord_municipality.value='';
	  form.coord_district.value='';
	  form.coord_country.value='';
	  
	  for(addr in result.address_components){
		 var addr_type=result.address_components[addr].types;
		 var address=result.address_components[addr];

		 if(addr_type[0]=="sublocality"&&addr_type[1]=="political"){ // city
			 document.placeAddForm.coord_city.value=address.short_name;
		 }		 
		 if(addr_type[0]=="locality"&&addr_type[1]=="political"){ // municipality
			 document.placeAddForm.coord_municipality.value=address.short_name;
		 }
		 if(addr_type[0]=="administrative_area_level_1"&&addr_type[1]=="political"){ // district
			 document.placeAddForm.coord_district.value=address.short_name;
		 }
		 if(addr_type[0]=="country"&&addr_type[1]=="political"){ // country
			 document.placeAddForm.coord_country.value=address.short_name;
		 }
	  }

	  form.coord_x.value=coord_x;
	  form.coord_y.value=coord_y;
  }
  
  
   $(function() {
		$( "#address" ).autocomplete({
			source:  function(request,response) {
				address=request.term;
				geocoder.geocode( 
					{ 'address': address,region:"bg",language:"bg"}, 
					function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
						  var data=new Array();
						  for(i=0;i<results.length;i++){
								data.push({
									"label":results[0].formatted_address,
									"value":results[0].formatted_address,
									"result":results[i]
								}); 
						  }

						  response(data);	
						} else {
						  response();
						  //alert("Geocode was not successful for the following reason: " + status);
					   }
					}
				);
			},

			delay:300,
			minLength: 2,
			select: function( event, ui ) {
				if(lastPlaceAddMarker){
					lastPlaceAddMarker.setMap(null);
					lastPlaceAddMarker=null;	
				}
				
				lastPlaceAddResult=ui.item.result;
				
				placeMap.setCenter(lastPlaceAddResult.geometry.location);
				
				lastPlaceAddMarker = new google.maps.Marker({
					map: placeMap, 
					position: lastPlaceAddResult.geometry.location,
					draggable: true,
		 			animation: google.maps.Animation.DROP,
					title: lastPlaceAddResult.address_components[0].long_name
				});
				
				setCoords(lastPlaceAddResult);
				
				google.maps.event.addListener(lastPlaceAddMarker, 'click', function() {
					placeMap.setCenter(lastPlaceAddMarker.position);
					placeMap.setZoom(16);
					infowindow.setContent(lastPlaceAddResult.formatted_address);
			 	    infowindow.open(map, lastPlaceAddMarker);
				});
				
				google.maps.event.addListener(lastPlaceAddMarker, 'dragend', function() {
				 	setCoords(lastPlaceAddResult);
				});

			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});
	});

	var toggledPlaceAddCatNum=0;
	
	$(document).ready(function(){
		for(i=1; i<=<?=$place_categories->num_rows();?>; i++) {
			document.getElementById('fake_placeAddCat'+i).idToToggle=i; 		
			
			$('#fake_placeAddCat'+i).click(function() {	
				var curDisplay=document.getElementById('subCatList'+(this.idToToggle+"")).style.display;	
				
				if(curDisplay=='none'||curDisplay=='')toggledPlaceAddCatNum++;
				else if(toggledNum>0) toggledPlaceAddCatNum--;
				
				$('#subCatList'+(this.idToToggle+"")).toggle('fast');
				
				//if(toggledNum>0) $('.subcatLabel').hide();
				//else $('.subcatLabel').show();
			});
		}
	});
	
	
	var addPicturesCount=1;
	
	function addPictureFile()
	{
		if(addPicturesCount>=10) return;
		addPicturesCount++;
		var element=document.createElement("input");
		element.setAttribute("type","file");
		element.setAttribute("class","inputText");
		element.setAttribute("name","pictures_"+addPicturesCount);
		$("#picturesList").append(element);
	}
	
</script>

		<div class="left-column">
			<div class="cbox br5-top">
				<h1>Редакция на "<?=$place->name;?>"</h1> 
				
				<div class="cbox-middle">    
				    <div class="tab_container">
				    <form action="" class="cboxForm" name="placeEditForm" method="post">
				        <div id="step1" class="tab_content">
							<div class="clear"></div> 
							
					    	
					    		<h4 class="titleBlock br4">Основна информация</h4>
					    		
						    	<div class="input-holder">
						    		<label class="label">Име</label>
                                    <?=$place->name;?>
					    		</div>

					    		<div class="input-holder">
						    		<label class="label">Адрес</label> 
						    		
						    		<div class="addMapHolder glow">
						    			<div class="map" id="placeAddMap" style="width: 100%; height: 100%; background: #eee;"></div>
						    		</div>
						    		
						    		<input type="text" id="address" name="address" class="inputText" style="float: right; margin-right: 3px;" value="<?=$place->address;?>"/>
						    		<small>Пример: гр. София, бул. България 32</small>
					    		</div>
					    		
					    		<div class="input-holder none">
						    		<label class="label">Категория</label>  
                                    
									<? $place_subcategory_num=1;?>
                                    <? foreach($place->categories as $root_category=>$subcategories):?>	
                                        <div id="subCatList<?=$root_category;?>" class="tagsHelper clean catColor<?=$root_category;?>">
                                        
                                        <? foreach($subcategories->result() as $place_subcategory):?>
                                            <a href="#addSuggest-<?=$place_subcategory_num;?>" class="fakecheck <?=$place_subcategory->status?'fakechecked':'';?>">
												<?=$place_subcategory->name;?>
                                            </a>
                                            <input type="checkbox" name="subcategories[]" id="addSuggest-<?=$place_subcategory_num;?>" value="<?=$place_subcategory->id;?>" <?=set_checked($place_subcategory->status,1);?>/>
                                            <? $place_subcategory_num++;?>
                                         <? endforeach?>
                                        </div>
                                    <? endforeach?>
					    		</div> 
					    		 
							<div class="clear"></div>
				            
				        </div><!-- end of step1 tab -->
				         

                                
				        <div id="placeAddSteps-2">
							
							<div class="clear"></div>
					    	
					    	
					    		<h4 class="titleBlock br4">Допълнителна информация</h4>
					    		<div class="input-holder">
						    		<label class="label">Описание</label>
						    		<textarea class="flexible-commentBox" style="width: 446px; height: 80px;" name="description"><?=$place->description;?></textarea>
					    		</div>
					    		
						    	<div class="input-holder">
						    		<label class="label">Работно време</label>
                                    <input type="text" class="inputText" name="work_time" 
                                    value="<?=$place->work_time;?>"/>
						    		<small>Пример: Понеделник - Неделя, 11ч - 24ч</small>
					    		</div>
					    		
					    		<div class="input-holder">
						    		<!--<label class="label">Други</label>-->
						    		<div class="tagsHelper checkboxHelper colSimulation" style="margin-left: 0px;"> 
                                    <? foreach($place->tags->result() as $place_tag):?>
                                    	<a href="#placeAddTag-<?=$place_tag->id;?>" class="fakecheck <?=$place_tag->status?'fakechecked':'';?>">
                                        	<?=$place_tag->name;?>
                                        </a>
										<input type="checkbox" name="tags[]" id="placeAddTag-<?=$place_tag->id;?>" value="<?=$place_tag->id;?>"  <?=set_checked($place_subcategory->status,1);?>/>
                                    <? endforeach?>
						    		</div>
					    		</div>
                                
                                <input type="hidden" name="coord_x" value="<?=$place->coord_x;?>"/>
                                <input type="hidden" name="coord_y" value="<?=$place->coord_y;?>"/>
                                <input type="hidden" name="coord_country" value="<?=$place->country;?>"/>
                                <input type="hidden" name="coord_district" value="<?=$place->district;?>"/>
                                <input type="hidden" name="coord_municipality" value="<?=$place->municipality;?>"/>
                                <input type="hidden" name="coord_city" value="<?=$place->city;?>"/>
                                
					    	<a class="fr btn30" onclick="document.placeEditForm.submit();">Редактирай</a>
						    
							<div class="clear"></div>
				            
				        </div><!-- end of step2 -->
				        
				        </form>
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