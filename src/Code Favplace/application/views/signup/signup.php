<? get_header();?>
		
		<div class="left-column">
			<div class="cbox br5-top">
				
				<h3>
					Присъедини се
				</h3>				
				<div class="cbox-middle br-reset">  
			    	<form action="" name="regForm" class="cboxForm" onsubmit="return regValidation.isFormValid();" method="post" autocomplete="off">
				    	<div class="input-holder">
				    		<label class="label">Псевдоним</label>
                            <input type="text" name="username" class="inputText" value="<?=set_value("username");?>"
                            onkeyup="if(event.keyCode!=9) regValidation.vFieldT('username')" onchange="regValidation.vFieldT('username')"/>
                            <small>
                            <? if(form_error("username")):?>
                            <?=form_error("username");?>
                            <? else:?>
				    		Латински букви и цифри. От 3 до 18 символа.
                            <? endif?>
                            </small>
			    		</div>
			    		<div class="input-holder">
				    		<label class="label">E-mail</label>
                            <input type="text" name="email" class="inputText" value="<?=set_value("email");?>"
                            onkeyup="if(event.keyCode!=9) regValidation.vFieldT('email')" onchange="regValidation.vFieldT('email')"/>
				    		<small>
                            <? if(form_error("email")):?>
                            <?=form_error("email");?>
                            <? else:?>
                            Вашата електронна поща.
                            <? endif?>
                            </small>
			    		</div>
			    		<div class="input-holder">
				    		<label class="label">Парола</label>
                            <input type="password" name="password" class="inputText"
                            onkeyup="if(event.keyCode!=9) regValidation.vFieldT('password')" />
				    		<small>
                            <? if(form_error("password")):?>
                            <?=form_error("password");?>
                            <? else:?>
                            От 6 до 50 символа.
                            <? endif?>
                            </small>
			    		</div>
			    		<div class="input-holder">
				    		<label class="label">Парола, отново</label>
                            <input type="password" name="password_r" class="inputText"
                            onkeyup="if(event.keyCode!=9) regValidation.vFieldT('password_r')" />
				    		<small>
                            <? if(form_error("password_r")):?>
                            <?=form_error("password_r");?>
                            <? else:?>
                            Потвърдете паролата си.
                            <? endif?>
                            </small>
			    		</div>
			    		<div class="input-holder" style="border: 0px;">
			    			<span style="margin-top: 10px; float: left">
			    				<a href="signin" style="color: #777;">Вход</a>
			    				&middot; 
			    				<a href="forgotten" style="color: #777;">Забравена парола</a>
			    			</span>
				    		<input type="submit" name="sBtn" class="btn30 fr btn-padding" value="Регистрация"/>
			    		</div>
			    	</form>	
                    <script>
					var regValidation=createFormValidation();
					
					var config={
						instanceName:"regValidation",
						timeout:300,
						form:"document.regForm",
						sBtn:document.regForm.sBtn,
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
						fieldWait:function (label,message){
							label.parentNode.getElementsByTagName("small")[0].innerHTML=message;
						},
						
						rules:{
						"username":"alpha_numeric|required|min_length[3]|max_length[18]|callback[checkUsername(this.config.form)]",
						"email":"trim|required|valid_email|callback[checkEmail(this.config.form)]",
						"password":"required|min_length[6]|max_length[50]|callback[checkPassword(this.config.form)]",
						"password_r":"required|min_length[6]|max_length[50]|matches[password]"
						},
						
						messagesInvalid:{
							"username":"Латински букви и цифри. От 3 до 18 символа.",
							"email":"Вашата електронна поща.",
							"password":"От 6 до 50 символа.",
							"password_r":"Потвърдете паролата си."
						}
					};		
					
					function checkUsername(form)
					{
						form=eval(form);
						regValidation.setFieldStatus("username","wait","Проверява се...");
						$.ajax({
						   type: "POST",
						   url: "signup/is_username_free",
						   data: "username="+form.username.value,
						   dataType: "json",
						   success: function(response){

							 if(response.usernameFree=="1"){ 
								 regValidation.setFieldStatus("username","valid","Този псевдоним е свободен.");
							 }
							 else if(response.usernameFree=="0"){
								 regValidation.setFieldStatus("username","invalid","Този псевдоним е зает, избери друг.");
							 }
							 else{
								alert("Възникна грешка при проверка на псевдонима.");   
							 }
						   },
						   error: function (msg,a,b){
								alert("Възникна грешка при проверка на псевдонима."+a);   
						   }
						});
					}
					
					function checkEmail(form)
					{
						  form=eval(form);
						  regValidation.setFieldStatus("email","wait","Проверява се...");

						  $.ajax({
							 type: "POST",
							 url: "signup/is_email_free/",
							 data: "email="+form.email.value,
							 dataType: "json",
							 success: function(response){

							   if(response.emailFree=="1"){ 
								   regValidation.setFieldStatus("email","valid",
								   "Този email е валиден");
							   }
							   else if(response.emailFree=="0"){
								   regValidation.setFieldStatus("email","invalid",
								   "Вече има регистрация с този email.");
							   }
							   else {
								  alert("Възникна грешка при проверка на email-a.");   
							   }
							 },
							 error: function (msg,a,b){
								  alert("Възникна грешка при проверка на email-a."+a);   
							 }
						  });	
					}
					
					function checkPassword(form)
					{
						form=eval(form);
						if(form.password_r.value!=""&&form.password.value!=form.password_r.value){
							regValidation.setFieldStatus("password_r","invalid","internal");
						}
						else if(form.password_r.value!=""&&form.password.value==form.password_r.value){
							regValidation.setFieldStatus("password_r","valid","internal");
						}
					}

					regValidation.setRules(config);	
					</script>
				    
					<div class="clear"></div>
				</div><!-- end of cbox-middle -->


			</div><!-- end of cbox -->
			
		</div> <!-- end left-column -->

		<div class="right-column">
			<? get_tour_widget();?>
        </div> <!-- end of right-column -->
        
<? get_footer();?>