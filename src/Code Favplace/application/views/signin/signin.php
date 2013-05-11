<? get_header();?>
		
		<div class="left-column">
			<div class="cbox br5-top">
				<h3>Вход</h3>				
				<div class="cbox-middle br-reset"> 
					<? if($signin_message):?>
                    	<div class="error">
                        	<span class="statusIcon"></span>
                            <span><?=$signin_message;?></span>
                        </div>
                    <? endif?>
			    	
			    	<form action="signin" class="cboxForm" method="post">
				    	<div class="input-holder">
				    		<label class="label">Псевдоним</label>
                            <input type="text" name="username" class="inputText" /> 
			    		</div> 
			    		<div class="input-holder">
				    		<label class="label">Парола</label>
                            <input type="password" name="password" class="inputText" /> 
			    		</div> 
			    		<div class="input-holder" style="border: 0px;">
			    			<span style="margin-top: 10px; float: left">
			    				<a href="signup" style="color: #777;">Регистрация</a>
			    				&middot; 
			    				<a href="forgotten" style="color: #777;">Забравена парола</a>
			    			</span>
				    		<input type="submit" class="btn30 fr btn-padding" value="Вход" />
			    		</div>
			    	</form>	
				    
					<div class="clear"></div>
				</div><!-- end of cbox-middle -->


			</div><!-- end of cbox -->
			
		</div> <!-- end left-column -->

		<div class="right-column">	
			<? get_tour_widget();?>
        </div> <!-- end of right-column -->
        
<? get_footer();?>