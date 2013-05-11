<? get_header();?>
		
		<div class="left-column">
			<div class="cbox br5-top">
				
				<h3>
					Забравена парола
				</h3>				
				<div class="cbox-middle br-reset">  
			    	<form action="" name="recoverForm" class="recoverForm" onsubmit="return recoverValidation.isFormValid();" method="post" autocomplete="off">
                        <? if(form_error("email")):?>
                        <div class="error">
                            <span class="statusIcon"></span>
                            <span><?=form_error("email");?></span>
                   		</div>
                        <? endif;?>
			    		<div class="input-holder">
				    		<label class="label">E-mail</label>
                            <input type="text" name="email" class="inputText" 
                            onkeyup="if(event.keyCode!=9) recoverValidation.vFieldT('email')" onchange="recoverValidation.vFieldT('email')"/>
				    		<small>
                            Вашата електронна поща въведена при регистрацията.
                            </small>
			    		</div>
			    		<div class="input-holder" style="border: 0px;">
			    			<span style="margin-top: 10px; float: left">
			    				<a href="signin" style="color: #777;">Вход</a>
			    				&middot; 
			    				<a href="signup" style="color: #777;">Регистрация</a>
			    			</span>
				    		<input type="submit" name="sBtn" class="btn30 fr btn-padding" value="Възстановяване"/>
			    		</div>
			    	</form>	
                    <script>
					var recoverValidation=createFormValidation();
					
					var config={
						instanceName:"recoverValidation",
						timeout:300,
						form:"document.recoverForm",
						sBtn:document.recoverForm.sBtn,
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
						"email":"trim|required|valid_email",
						},
						
						messagesInvalid:{
							"email":"Вашата електронна поща въведена при регистрацията.",
						}
					};		

					recoverValidation.setRules(config);	
					</script>
				    
					<div class="clear"></div>
				</div><!-- end of cbox-middle -->


			</div><!-- end of cbox -->
			
		</div> <!-- end left-column -->

		<div class="right-column">
			<? get_tour_widget();?>
        </div> <!-- end of right-column -->
        
<? get_footer();?>