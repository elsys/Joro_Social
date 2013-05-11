<? get_header();?>
<link href="sources/js/uploadify/uploadify.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="sources/js/uploadify/swfobject.js"></script>
<script type="text/javascript" src="sources/js/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#place_pictures').uploadify({
    'uploader'  : 'sources/js/uploadify/uploadify.swf',
    'script'    : '<?=base_url();?>/place/add/pictures/<?=$this->session_id;?>/<?=$place->id;?>',
    'cancelImg' : 'sources/js/uploadify/cancel.png',
    'folder'    : 'pictures',
    'fileDataName' : 'picture',
	'fileExt'     : '*.jpg;*.png',
  	'fileDesc'    : 'Images (.jpg, .png)',
	'multi'       : true,
    'auto'      : true,
	'sizeLimit'   : 2102400,
    'onComplete'  : function(event, ID, fileObj, response, data) {
        alert("Снимките са качени успешно.");
    },
	'onAllComplete' : function(event,data) {
	  $("#picUploadSuccessful").show("fast");
    }
  });
  
  $("#gallery_prev").click(function(){
	  if(gallery_image>0){
		  gallery_image--;
		  galleryGetImage();
	  }
  });
  
  $("#gallery_next").click(function(){
	  if(gallery_image<gallery_total){
		  gallery_image++;
		  galleryGetImage();
	  }
  });
  
  galleryGetImage();
  
  	// Intialize GMaps for event adding
    var myOptions = {
      zoom: 15,
      center: new google.maps.LatLng(<?=$place->coord_x;?>, <?=$place->coord_y;?>),
      mapTypeId: google.maps.MapTypeId.HYBRID,
	  language: "bg"
    };
	
    new google.maps.Map(document.getElementById("view_map"),myOptions);	
	// End of intialize GMaps for event adding			
  
});
var place_id=<?=$place->id;?>;
var gallery_total=<?=$pictures_count;?>;
var gallery_image=0;

function galleryGetImage()
{
	$.ajax({
	   type: "GET",
	   url: "place/gallery/ajax_image/<?=$place->id;?>/"+gallery_image,
	   dataType: "json",
	   success: function(response){
		   if(response.status=="ok"){
			    $("#gallery_image").attr("src",response.picture);
				$("#gallery_position").html((response.position+1)+" / "+gallery_total);
		   }
		  // else if(response.status=="error") alert(response.description);		 
	   },
	   error: function (msg,a,b){
			alert("Възникна грешка при зареждане на изображението."+a);   
	   }
	});	
}

    </script>
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
										
										
										var favoriteBtnStatus=<?=(int) $place_favorite;?>;
										
										$(document).ready(function(){
											$("#placeFavoriteBtn").click(function(){
											  if(favoriteBtnStatus==1){
												   var action="remove";
												   favoriteBtnStatus=0;
											  }
											  else{
												  var action="add";
												  favoriteBtnStatus=1;
											  }
											  
											  $.ajax({
												type: "post",
												url: "profile/favorite_place/"+action,
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
											});
										});
										
										</script>
		            					<a class="was-btn" id="placeFavoriteBtn">
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
				        
                        <!--
				        	<div class="meta-controls">
				        		<a href="#" class="act">Всички снимки</a> <b class="middot">&middot;</b> <a href="#">Само от потребители</a> <b class="middot">&middot;</b> <a href="#">Само от собственика</a>
				        	</div>
                            
                        -->
				        	
				        	<div class="clear"></div>
				        	
							<div id="gallery" class="ad-gallery">

								<div style="width:600px;height:400px">
									<img src="" id="gallery_image">
                                </div>
                                
                                <span id="gallery_position"></span>
                                
                                <a id="gallery_prev">Prev</a>
                                <a id="gallery_next">Next</a>						
                                
                                <? if($this->user_logged):?>
                                <a href="#?w=600" rel="uploader" class="px-btn br3 poplight"><span class="iphoto"></span> Добави снимки</a>
                                <? endif;?>
						</div><!-- end of gallery -->

				        </div><!-- end of tab2 -->
                                          
				        <div id="tab3" class="tab_content">
                       		<table class="place-menu">
                            <? foreach($place_menu->result as $category):?>
								<tr class="menu-cat">
									<td colspan="3"><b><?=$category->name;?></b></td>
								</tr>
                                
                                <? foreach($category->subcategories->result as $subcategory):?>
                                    <tr class="menu-subcat">
                                        <td colspan="3"><?=$subcategory->name;?></td>
                                    </tr>
                                    
                                    <? foreach($subcategory->items->result as $item):?>
                                    <tr class="menu-item">
                                        <td class="item-title"><b><?=$item->name;?></b></td>
                                        <td class="item-weight"><?=$item->amount;?></td>
                                        <td class="item-price"><?=$item->price;?></td>
                                    </tr>
                                    <tr class="item-description">
                                        <td colspan="3">
                                            <?=$item->description;?>
                                        </td>
                                    </tr><!-- / item -->
                                    <? endforeach;?>  
                                    <!-- end of items list -->                                  
                                <? endforeach;?>
                                <!-- end of subcategories list -->
                            <? endforeach;?>
                            <!-- end of categories list -->
							</table>                        
				        </div>
                        
				        <div id="tab4" class="tab_content">
                        	<a href="event/add/<?=$place->id;?>">Създай събитие</a>
                            <br/><br/>
                        
                        
				            <? foreach($place_events->result() as $event):?>
                            	<a href="<?=event_link($event);?>"><?=$event->name;?></a><br/>
                            <? endforeach;?>
				        </div>
				        <div id="tab5" class="tab_content">
				            <div id="view_map" style="height:300px; width:100%;"></div>
				        </div>
				        <div id="tab6" class="tab_content">
				            <? foreach($place_favorites->result() as $profile_):?>
                            	<div style="float:left;width:60px; margin-bottom:20px;">
                            	<img src="<?=profile_avatar($profile_->id,50);?>"/>
								<?=$profile_->username;?><br/>
                                </div>
                            <? endforeach;?>
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
        
        <div id="uploader" class="popup_block">
          <h3>Добави снимки</h3>
          <div style="margin: 0px 20px 20px 20px;padding:20px;">
          	  <br/>
              <div class="error" style="display:none"><span class="statusIcon"></span><span>Размерът на файла трябва да е до 3 MB.</span><a href="#" class="smallCloseBtn"></a></div>
              <div class="warning" style="display:none"><span class="statusIcon"></span><span>Внимание, внимание!</span><a href="#" class="smallCloseBtn"></a></div>
              <div id="picUploadSuccessful" class="successful" style="display:none">
              	<span class="statusIcon"></span>
                <span>Файлът е качен успешно!</span>
                <a href="#" class="smallCloseBtn"></a>
              </div>
              
              <form action="">
                  <div class="input-holder">
					  <input type="file" id="place_pictures"/>
                      <br/>
                      <small style="margin-left:0px;">Разрешени формати: JPG, PNG</small>
                  </div>
              </form>	
              <br/>
          </div>
          
        <? if($place_customization) : ?>
		<style type="text/css">
            <?=$place_customization->css; ?>
        </style>
        <? endif; ?>
	
<? get_footer();?>