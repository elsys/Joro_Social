<? get_header(); ?>

		<div class="left-column">
			<div class="cbox br5-top">
				<h1>Заявка за бизнес версия за "<?= htmlspecialchars($place->name); ?>"</h1>

				<div class="cbox-middle">    
	 				
						<form action="business/request/<?= $place->id; ?>" class="cboxForm" method="post">
 
				    		<div class="input-holder">
						    	<label class="label" style="margin-left: 0px; text-align: left;">Описание</label>
						    	
						    	<div class="clear"></div>
						    	
						    	<small style="margin-left: 0px; font-size: 12px;">                            
									Автобиография в няколко символа :)
								</small>
						    	
						    	<div class="clear"></div>
						    	
						    	<textarea class="flexible-commentBox" style="width: 596px; height: 150px; margin-top: 10px;" name="request"></textarea>
					    	</div>
	
						    <div class="input-holder">
					    		<input type="submit" class="btn30 fr btn-padding" value="Изпрати заявка" />
				    		</div>
				    	</form><!-- / form.cboxForm -->
	 				
					<div class="clear"></div>
				</div><!-- end of cbox-middle -->
				
			</div><!-- end of cbox -->
			
		</div> <!-- end left-column -->

		<div class="right-column">		
			<? get_popular_box();?>			
			<? get_near_users();?>
		</div> <!-- end of right-column -->
	
<? get_footer();?>