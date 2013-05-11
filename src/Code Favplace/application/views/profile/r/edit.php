<? get_header();?>
		<div class="left-column">
			<div class="cbox">
				<h1>Редакция на профил</h1>
				
                <script type="text/javascript">
				function saveInfo()
				{
					var form=document.editProfileInfo;					
						
					var sex_id;	
					for (i=0;i<form.sex_id.length;i++) {
						if(form.sex_id[i].checked){
							sex_id=form.sex_id[i].value;
						}
					}
					
					$.ajax({
					   type: "POST",
					   url: "profile/edit/info",
					   data: {
						'name':form.name.value,
						'sex_id':sex_id,
					   	'birth_day':form.birth_day.value,
						'birth_month':form.birth_month.value,
						'birth_year':form.birth_year.value,
					   	'personal_site':form.personal_site.value,
					   	'twitter':form.twitter.value,
						'facebook':form.facebook.value,
					   	'description':form.description.value
					   },
					   dataType:"json",
					   success: function(result){
						 if(!result){
							 alert("Възникна грешка при свързване със сървъра.");
						 }
						 else{
							 if(result.status=="ok") alert("Редакцията е успешна!");
							 else alert("Възникна грешка при свързване със сървъра!");
						 }
					   },
					   error: function (msg){
							alert("Възникна грешка при свързване със сървъра.");   
					   }
					});	

				}
				</script>
                
				<div class="cbox-middle">
				
						<h4 class="titleBlock br4" style="font-size: 24px; text-transform: none;">
							<a href="<?=$this->username;?>"><?=$this->username;?></a>
						</h4>
						
						<form action="profile/edit/save_info" name="editProfileInfo" class="cboxForm" method="post">
				    		<h4 class="titleBlock br4">Инфо</h4>

					    	<div class="input-holder">
					    		<label class="label">Име</label>
	                            <input type="text" name="name" class="inputText" value="<?=$profile->name;?>" />
				    		</div>
				    		
				    		<div class="input-holder radio_fix_margin">
					    		<label class="label">Пол</label>
					    		                             
	                            <input type="radio" name="sex_id" value="1" 
                                <?=$profile->sex_id==1?'checked="checked"':'';?> />
	                            <label>Мъж</label>
	                            
	                            <input type="radio" name="sex_id" value="2"
                                <?=$profile->sex_id==2?'checked="checked"':'';?> />
	                            <label>Жена</label>
				    		</div>
				    		
				    		<div class="input-holder">
					    		<label class="label">Град</label>

								<select name="city" class="cities-list">
									<option value="115">София</option>
									<option value="84">Пловдив</option>
									<option value="18">Варна</option>
									<option value="15">Бургас</option>
									<option value="1">Айтос</option>
									<option value="2">Антоново</option>
									<option value="3">Асеновград</option>
									<option value="4">Балчик</option>
									<option value="5">Банско</option>
									<option value="142">Банкя</option>
									<option value="6">Батак</option>
									<option value="7">Белене</option>
									<option value="8">Белоградчик</option>
									<option value="9">Белослав</option>
									<option value="10">Берковица</option>
									<option value="11">Благоевград</option>
									<option value="12">Бобов Дол</option>
									<option value="13">Боровец</option>  
								</select>
				    		</div>
				    		
				    		<div class="input-holder birthdate">
					    		<label class="label">Рожденна дата</label>

								<div class="day">
						    		<select name="birth_day" class="comboSelectNot">
                                    	<option value="">-</option>
                                   		<? for($i=1;$i<=31;$i++):?>
                                        <? if(date("j",strtotime($profile->birthdate))==$i):?>
						    				<option value="<?=$i;?>" selected="selected"><?=$i;?></option>
                                        <? else:?>
                                        	<option value="<?=$i;?>"><?=$i;?></option>
                                        <? endif;?>
                                    	<? endfor?>
						    		</select>
								</div>
								
					    		<div class="month">					    		
						    		<select name="birth_month">
                                    	<? $months=array(
											"1" =>"януари",
											"2" =>"февруари",
											"3" =>"март",
											"4" =>"април",
											"5" =>"май",
											"6" =>"юни",
											"7" =>"юли",
											"8" =>"август",
											"9" =>"септември",
											"10"=>"октомври",
											"11"=>"ноември",
											"12"=>"декември"
										);?>
                                        
                                    	<option value="">-</option>
                                        
						    			<? foreach($months as $key=>$value):?>
                                        <? if(date("n",strtotime($profile->birthdate))==$key):?>
                                        	<option value="<?=$key;?>" selected="selected"><?=$value;?></option>
                                        <? else:?>
                                        	<option value="<?=$key;?>"><?=$value;?></option>
                                        <? endif;?>
                                        <? endforeach;?>
						    		</select>
					    		</div>
					    		
					    		<div class="year">
					    			<select name="birth_year" class="comboSelectNot">
                                        <option value="">-</option>
                                        <? for($i=date("Y")-5;$i>date("Y")-80;$i--):?>
                                        <? if(date("Y",strtotime($profile->birthdate))==$i):?>
						    				<option value="<?=$i;?>" selected="selected"><?=$i;?></option>
                                        <? else:?>
                                        	<option value="<?=$i;?>"><?=$i;?></option>
                                        <? endif;?>
                                        <? endfor?>
						    		</select>
					    		</div>
				    		</div>
				    		
				    		<div class="input-holder">
					    		<label class="label">Уебсайт</label>
	                            <input type="text" name="personal_site" class="inputText"
                                value="<?=$profile->personal_site;?>" />
	                            <small>                            
									Без http://
								</small>
				    		</div>
				    		
				    		<div class="input-holder">
					    		<label class="label">Twitter</label>
	                            <input type="text" name="twitter" class="inputText"
                                value="<?=$profile->twitter;?>" />
	                            <small>                            
						    		Например https://twitter.com/fapbg
								</small>
				    		</div>
				    		
				    		<div class="input-holder">
					    		<label class="label">Facebook</label>
	                            <input type="text" name="facebook" class="inputText"
                                value="<?=$profile->facebook;?>" />
	                            <small>                            
						    		Например http://www.facebook.com/#!/profile.php?id=100001111159513
								</small>
				    		</div>
				    		
				    		<div class="input-holder">
						    	<label class="label">Описание</label>
						    	<textarea class="flexible-commentBox" style="width: 451px; height: 50px;" name="description"><?=$profile->description;?></textarea>
						    	<small>                            
									Автобиография в няколко символа :)
								</small>
					    	</div>
	
						    <div class="input-holder">
					    		<input type="button" class="btn30 fr btn-padding" value="Запази"
                                onclick="saveInfo()"/>
				    		</div>
				    	</form>
		


						<form action="profile/edit/avatar" class="cboxForm" enctype="multipart/form-data" method="post">
							<h4 class="titleBlock br4">Аватар</h4>
							
							<div class="input-holder">
								<div class="avatarHolder">
									<img src="<?=profile_avatar($profile->id);?>" alt="" width="20" height="20" />
									<img src="<?=profile_avatar($profile->id,50);?>" alt="" width="50" height="50" />
									<img src="<?=profile_avatar($profile->id,150);?>" alt="" width="150" height="150" />
									<img src="<?=profile_avatar($profile->id,200);?>" alt="" width="200" height="200" />
								</div>
					    		<small style="margin-left: 0px; margin-top: 10px;">Ако имате <a href="http://gravatar.com" target="_blank" style="color: #888;">Gravatar</a>, то той се използва по подразбиране.</small>
                                <? if($profile->avatar):?>
                                <a href="profile/delete/avatar">Изтрий</a>	
                                <? endif;?>
							</div>

							<div class="input-holder">
					    		<label class="label"><!-- <span class="iupload"></span> --> Качи</label> 
                                <input type="file" name="avatar" class="inputText" />
					    		<small>Разрешени формати: JPG, PNG, GIF</small>
				    		</div>
				    		<div class="input-holder">
					    		<label class="label"><!-- <span class="inet"></span> --> От нета</label> <input type="text" name="url" class="inputText" />
					    		<small>Пример: http://upload.wikimedia.org/wikipedia/commons/1/16/Tsarevets-Panorama.jpg</small>
				    		</div>
				    		
				    		<div class="input-holder">
					    		<input type="submit" class="btn30 fr btn-padding" value="Запази" />
				    		</div>
				    	</form>
				    	
				    	
				    	
						<form action="" class="cboxForm">
					    	<h4 class="titleBlock br4">Профилна сигурност</h4>	
					    	
					    	<div class="input-holder radio_fix">
					    		<label class="label">Отключен</label>
					    		<input type="radio" name="" value="" class="privacy-radio-btn" />
								<label style="width: 400px; margin-left: 5px; float: left;">Всички могат да ви следят. <br />Статусите ви са публични.</label>
					    	</div>
					    	
					    	<div class="input-holder radio_fix">
					    		<label class="label">Заключен</label>
					    		<input type="radio" name="" value="" />
					    		<label style="width: 400px; margin-left: 5px; float: left;">
					    			Ще могат да ви следят само хора, на които разрешите. <br />Статусите ви няма да бъдат видими за потребители, които не ви следят.
					    		</label>
					    	</div>
	
						    <div class="input-holder">
					    		<input type="button" class="btn30 fr btn-padding" value="Запази" />
				    		</div>
				    	</form>	

						<form class="cboxForm" name="editAccountEmail" onsubmit="return saveAccountEmail()">
                        	<h4 class="titleBlock br4">E-mail и парола</h4>
                        
                        	<div class="input-holder">
					    		<label class="label">Email</label>
	                            <input type="text" name="email" class="inputText"
                                value="<?=$profile->email;?>" onkeyup="if(event.keyCode!=9) editAccountEmailValidation.vFieldT('email')" onchange="editAccountEmailValidation.vFieldT('email')"/>
                                <small>
                            		Вашата електронна поща.
                           		</small>
				    		</div>
                            
                            <div class="input-holder">
					    		<input type="submit" name="sBtn" class="btn30 fr btn-padding" value="Запази" />
				    		</div>
                            
                            <script>
							var editAccountEmailValidation=createFormValidation();
					
							var configEmailValidation={
								instanceName:"editAccountEmailValidation",
								timeout:300,
								form:"document.editAccountEmail",
								sBtn:document.editAccountEmail.sBtn,
								secondsToWait:10,
								waitMessage:"Моля изчакайте ",						
								fieldInvalid:function(label,message){
									label.parentNode.getElementsByTagName("small")[0].innerHTML=message;
									label.parentNode.className="input-holder invalid";
								},
								fieldValid:function (label,message){	
									label.parentNode.getElementsByTagName("small")[0].innerHTML=message;
									label.parentNode.className="input-holder valid";
								},
								fieldWait:function (label,message){
									label.parentNode.getElementsByTagName("small")[0].innerHTML=message;
								},						
								rules:{
									"email":"trim|required|valid_email|callback[checkEmail(this.config.form)]"
								},						
								messagesInvalid:{
									"email":"Вашата електронна поща."
								}
							};		
							
							editAccountEmailValidation.setRules(configEmailValidation);	
							
							// by default the email is valid
							editAccountEmailValidation.setFieldStatus("email","valid","Този email е валиден");
							function checkEmail(form)
							{
								  form=eval(form);
								  editAccountEmailValidation.setFieldStatus("email","wait","Проверява се...");
		
								  $.ajax({
									 type: "POST",
									 url: "profile/edit/is_new_email_free",
									 data: {"email":form.email.value},
									 dataType: "json",
									 success: function(result){
									   if(result.status=="ok"){ 
										   editAccountEmailValidation.setFieldStatus("email","valid",
										   "Този email е валиден");
									   }
									   else if(result.status=="error"){
										   editAccountEmailValidation.setFieldStatus("email","invalid",
										   "Вече има регистрация с този email.");
									   }
									   else {
										  alert("Възникна грешка при проверка на email-a.");   
									   }
									 },
									 error: function (msg){
										  alert("Възникна грешка при проверка на email-a.");   
									 }
								  });	
							}
							
							function saveAccountEmail()
							{
								var form=document.editAccountEmail;

								if(editAccountEmailValidation.isFormValid()){
								$.ajax({
								 type: "POST",
								 url: "profile/edit/account_email",
								 data: {
									 "email":form.email.value
								 },
								 dataType:"json",
								 success: function(result){
								   if(!result) alert("Възникна грешка при свързване със сървъра.");
									 
								   if(result.status=="ok"){ 
									   alert("Информацията е променена!"); 
								   }
								   else if(result.status=="error"){
									   editAccountEmailValidation.setFieldStatus("email","invalid",
									   result.description);
								   }
								   else {
									  alert("Възникна грешка при свързване със сървъра.");   
								   }
								 },
								 error: function (msg){
									  alert("Възникна грешка при свързване със сървъра.");   
								 }
							  });	
								}
								return false;
							}
							</script>
                        </form>
				    	
					    <form class="cboxForm" name="editAccountPassword" onsubmit="return saveAccountInfo()" autocomplete="off">	
				    		
				    		

                            
                            <div class="input-holder">
					    		<label class="label">Стара парола</label>
	                            <input type="password" name="old_password" class="inputText" onkeyup="if(event.keyCode!=9) editAccountPasswordValidation.vFieldT('old_password')" value=""/>
	                            <small>                            
									Латински букви и цифри. От 6 до 50 символа.
	                            </small>
				    		</div>
				    		
				    		<div class="input-holder">
					    		<label class="label">Нова парола</label>
	                            <input type="password" name="password" class="inputText" onkeyup="if(event.keyCode!=9) editAccountPasswordValidation.vFieldT('password')" />
	                            <small>                            
									Латински букви и цифри. От 6 до 50 символа.
	                            </small>
				    		</div>
				    		
				    		<div class="input-holder">
					    		<label class="label">Нова парола</label>
	                            <input type="password" name="password_r" class="inputText" onkeyup="if(event.keyCode!=9) editAccountPasswordValidation.vFieldT('password_r')" />
	                            <small>                            
						    		Потвърдете новата си парола.
								</small>
				    		</div>
							
							<div class="input-holder">
					    		<input type="submit" name="sBtn" class="btn30 fr btn-padding" value="Запази" />
				    		</div>
                            
                            <script>
							var editAccountPasswordValidation=createFormValidation();
					
							var configPasswordValidation={
								instanceName:"editAccountPasswordValidation",
								timeout:300,
								form:"document.editAccountPassword",
								sBtn:document.editAccountPassword.sBtn,
								secondsToWait:10,
								waitMessage:"Моля изчакайте ",							
								fieldInvalid:function(label,message){
									if(message&&message!="internal"){
										label.parentNode.getElementsByTagName("small")[0].innerHTML=message;
									}
									label.parentNode.className="input-holder invalid";
									if(message!="internal") label.focus();
								},
								fieldValid:function (label,message){	
									if(message&&message!="internal"){
										label.parentNode.getElementsByTagName("small")[0].innerHTML=message;
									}
									label.parentNode.className="input-holder valid";
								},
								rules:{
								"old_password":"required|min_length[6]|max_length[50]",
								"password":"required|min_length[6]|max_length[50]|callback[checkPassword(this.config.form)]",
								"password_r":"required|min_length[6]|max_length[50]|matches[password]"
								},
								
								messagesInvalid:{
									"old_password":"От 6 до 50 символа.",
									"password":"От 6 до 50 символа.",
									"password_r":"Потвърдете паролата си."
								}
							};	
							
							editAccountPasswordValidation.setRules(configPasswordValidation);
							
							
							function checkPassword(form)
							{
								form=eval(form);
								if(form.password_r.value!=""&&form.password.value!=form.password_r.value){
									editAccountPasswordValidation.setFieldStatus("password_r","invalid","internal");
								}
								else if(form.password_r.value!=""&&form.password.value==form.password_r.value){
									editAccountPasswordValidation.setFieldStatus("password_r","valid","internal");
								}
							}
			
							function saveAccountInfo()
							{
								var form=document.editAccountPassword;

								if(editAccountPasswordValidation.isFormValid()){
								$.ajax({
								 type: "POST",
								 url: "profile/edit/account_password",
								 data: {
									 "old_password":form.old_password.value,
									 "password":form.password.value,
									 "password_r":form.password_r.value
								 },
								 dataType:"json",
								 success: function(result){
								   if(!result) alert("Възникна грешка при свързване със сървъра.");
									 
								   if(result.status=="ok"){ 
									   alert("Информацията е променена!"); 
									   
									   form.old_password.value="";
									   form.old_password.parentNode.className="input-holder";
									   
									   form.password.value="";
									   form.password.parentNode.className="input-holder";
									   
									   form.password_r.value="";
									   form.password_r.parentNode.className="input-holder";
								   }
								   else if(result.status=="error"){
									   alert(result.description); 
								   }
								   else {
									  alert("Възникна грешка при свързване със сървъра.");   
								   }
								 },
								 error: function (msg){
									  alert("Възникна грешка при свързване със сървъра.");   
								 }
							  });	
								}
								return false;
							}
							</script>
				    	</form>

											              				    				              				    
					<div class="clear"></div>
				
				</div>

			</div><!-- end of cbox -->

			
		</div> <!-- end left-column -->

		<div class="right-column">		
			<? get_popular_box();?>			
			<? get_near_users();?>
		</div> <!-- end of right-column -->
	
<? get_footer();?>