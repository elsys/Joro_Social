<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Favplace.BG</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<base href="<?=site_url();?>"></base>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="sources/css/main.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="sources/css/flick/jquery-ui-187custom.css" type="text/css" media="screen" />
	<script type="text/javascript" src="sources/js/jquery142.js"></script>
	<script type="text/javascript" src="sources/js/jquery-ui-187custom.js"></script>
	<script type="text/javascript" src="sources/js/autoresize.js"></script>
	<script type="text/javascript" src="sources/js/tipsy.js"></script>
	<script type="text/javascript" src="sources/js/gallery.js"></script>
	<script type="text/javascript" src="sources/js/popup.js"></script>
	<script type="text/javascript" src="sources/js/formValidation.js"></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=bg"></script>
	<script type="text/javascript" src="sources/js/gmaps.js"></script>
	<script type="text/javascript" src="sources/js/uniform.js"></script>
	<script type="text/javascript" src="sources/js/combined.js"></script>
</head>
<body>
	<div id="fade"></div> 

	<div class="topline"></div>

	<div class="header">
		<div class="wrap">
			<ul id="nav">
				<li><a href="#" id="logo" title="Начало">Favplace - Начало</a></li> 
				<li><a href="catalogue">Места</a></li>
				<li><a href="events">Събития</a></li>
				<li><a href="help">Помощ</a></li>
				<? if($this->user_logged):?>
				<li>
					<a href="#" id="my-places-btn"><b>Мои Места</b></a>
					<div id="my-places-box" class="shadow">
						
						<? foreach($business_places->result() as $business_place): ?>
						<a href="place/<?= $business_place->id; ?>/<?= url_title($business_place->name); ?>" class="place">
							<img src="sources/images/place-sample.gif" alt="<?= htmlspecialchars($business_place->name); ?>" />
							<b><?= htmlspecialchars($business_place->name); ?></b>
						</a>
						<? endforeach; ?>
                        
                        <? if($business_places->num_rows()==0):?>						
						<a href="help/business" class="btn30">Нямаш места?</a>                        
                        <? endif;?>
					</div>
				</li>
				<? endif; ?>
			</ul>	
            <? if($this->user_logged):?>
            <div class="fr">
				<a class="minimized">
					<img class="avatar" src="<?=profile_avatar($this->profile_id);?>" alt="<?=$this->username;?>'s avatar" />
					<span class="username"><?=$this->username;?></span>
					<span id="arr-close"></span>
				</a>
				<ul id="dropdown">
					<li><a href="profile">Профил</a></li>
					<li><a href="followed/<?=$this->username;?>">Приятели</a></li>
					<li><a href="profile/edit">Настройки</a></li>
					<li><a href="signout">Изход</a></li>
					<li>
						<input type="text" id="profileCity" value=""/>
					</li>
				</ul>
			</div>
			<? else: ?>
			<div class="fr">
				<a href="signup" class="signup-btn">Регистрация</a>
				<a href="signin" class="signin-btn">Вход</a>
			</div>
            <? endif; ?>		
		 </div><!-- / .wrap -->
		
		<? if($this->user_logged && isset($page_place_view)): ?>
		<div class="moderation">
			<div class="wrap">
				<ul class="modnav" style="float: left">
					<!-- icons will be added -->
                    <!--
					<li><a href="#">Статистика</a></li>
					<li><a href="#">Коментари <span class="notification">24</span></a></li>-->
					<li><a href="business/customization/<?=$place->id;?>">Визия</a></li>
					<li><a href="business/menu/edit/<?=$place->id;?>">Меню</a></li>
				</ul>
				
                <!--
				<ul class="modnav">
					<li><a href="#">Редактирай:</a></li>
					<li><a href="#">Информация</a></li>
					<li><a href="#">Визия</a></li>
					<li><a href="#">Меню</a></li>
				</ul>
                -->
				
				<div class="clear"></div>
			</div>
		</div><!-- / .moderation -->
		<? endif; ?>
		 
	</div><!-- / .header -->
	 
	<div class="topmap">
		<div class="wrap">
			<div class="quick-search br4">
            	<script>
				$(document).ready(function(){
				$(function() {
					$( "#mainSearch" ).autocomplete({
						source:  function(request,response) {

						$.ajax({
							 type: "POST",
							 url: "search/places_sugg",
							 data: {'name':request.term},
							 dataType:"json",
							 success: function(results){
							   if(results.status=="ok"){
							   		var data=Array();
									
									for(i=0;i<results.places.length;i++){
										data.push({
											"label":results.places[i].name,
											"value":results.places[i].name
										});
									}
									
									response(data);
							   }
							   else response();
							 },
							 error: function (msg){
								  alert("Възникна грешка при свързване със сървъра.");   
							 }
						  });	

						
						},
			
						delay:300,
						minLength: 2,
						select: function( event, ui ) {
							
						},
						open: function() {
							$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
						},
						close: function() {
							$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
						}
					});
				});
				
				$(function() {
					$( "#profileCity" ).autocomplete({
						source:  function(request,response) {
						$.ajax({
							 type: "POST",
							 url: "profile/profile_city_sugg",
							 data: {'city':request.term},
							 dataType:"json",
							 success: function(results){
							
							   if(results.status=="ok"){
							   		var data=Array();
									for(i=0;i<results.cities.length;i++){
										data.push({
											"label":results.cities[i].name,
											"value":results.cities[i].name
										});
									}
									
									response(data);
							   }
							   else response();
							 },
							 error: function (msg,a,b){
								  alert("Възникна грешка при свързване със сървъра. "+b);   
							 }
						  });	

						
						},
			
						//delay:300,
						//minLength: 2,
						select: function( event, ui ) {
							alert(ui.item.value);
						},
					});
				});

				$(function() {
					$( "#advancedSearchCity" ).autocomplete({
						source:  function(request,response) {
						$.ajax({
							 type: "POST",
							 url: "profile/profile_city_sugg",
							 data: {'city':request.term},
							 dataType:"json",
							 success: function(results){
								
							   if(results.status=="ok"){
							   		var data=Array();
									for(i=0;i<results.cities.length;i++){
										data.push({
											"label":results.cities[i].name,
											"value":results.cities[i].name
										});
									}
									
									response(data);
							   }
							   else response();
							 },
							 error: function (msg,a,b){
								  alert("Възникна грешка при свързване със сървъра. "+b);   
							 }
						  });	

						
						},
			
						//delay:300,
						//minLength: 2,
						select: function( event, ui ) {
							alert(ui.item.value);
						},
					});
				});
				});
				
				function searchSubmit(form)
				{
					if(form.name.value=="Какво търсиш?") form.name.value="";
				}
				</script>
				<form action="search/places" method="post" autocomplete="off" onsubmit="return searchSubmit(this)">
					<input type="text" name="name" id="mainSearch" class="search-field br3" value="Какво търсиш?" />
					<input type="submit" class="search-btn" value="Търси" />
					<a id="advancedSearch-btn"><b class="arrClose"></b>Подробно търсене</a>

				
				<div class="btnpad"></div>
				
				<div id="advancedSearch-box" class="br3">
						<div class="clear"></div>					 
						
						<div class="input-holder">
							<label class="label">Град</label>
							<div class="rightContentHolder">
								<input type="text" id="advancedSearchCity" name="city" class="inputText" />
							</div>	
						</div> 
			    		<div class="input-holder">
				    		<label class="label">Категория</label>
				    		<div class="rightContentHolder">
					    		<? $place_subcategory_num=1;?>
                                    <? foreach($h_search_subcategories as $root_category=>$subcategories):?>	
                                        <div id="hSubCatList<?=$root_category;?>" class="tagsHelper clean catColor<?=$root_category;?>">
                                        
                                        <? foreach($subcategories->result() as $place_subcategory):?>
                                            <a href="#suggest-<?=$place_subcategory_num;?>" class="fakecheck">
												<?=$place_subcategory->name;?>
                                            </a>
                                            <input type="checkbox" name="h_subcategories[]" id="suggest-<?=$place_subcategory_num;?>" value="<?=$place_subcategory->id;?>"/>
                                            <? $place_subcategory_num++;?>
                                         <? endforeach?>
                                        </div>
                                    <? endforeach?>
				    		</div><!-- end of tagsHolder -->
						</div><!-- end of input-holder -->
										    		
			    		<div class="input-holder" style="width: 100%;">
				    		<!--<label class="label">Други</label>-->
				    		<div class="tagsHelper checkboxHelper colSimulation" style="margin-left: 0px;"> 
                            
                            	<? $h_search_tags_count=1;?>
                            	<? foreach($h_search_tags->result() as $tag):?>
                                	<a href="#h_tags-<?=$h_search_tags_count;?>"
                                    class="fakecheck"><?=$tag->name;?></a>
									<input type="checkbox" name="h_tags[]" id="h_tags-<?=$h_search_tags_count;?>" value="<?=$tag->id;?>"/>
                                    
                                    <? $h_search_tags_count++;?>
                                <? endforeach?>
                           
				    		</div>
			    		</div>


				</div><!-- end of advancedSearch-box -->
			</form>  			
				<div class="clear"></div>
			</div><!-- quick-search -->
			
				<div class="clear"></div>
		</div><!-- end of wrap -->
		
		<div class="clear"></div>
	
		<div id="radioViews">
			<a id="view1" class="act"></a>
			<a id="view2"></a>
			<a id="view3"></a>
		</div> 
		
		<div id="map_canvas"></div> 
						
		<div class="fix"></div> 
		
	</div> 

 
	<div class="wrap">