<?php //<link rel="stylesheet" type="text/css" href="sources/css/style.css" /> ?>
<link rel="stylesheet" type="text/css" href="sources/css/colorpicker.css" /> 
<link rel="stylesheet" type="text/css" href="sources/css/owners.css" /> 
<script type="text/javascript" src="sources/js/colorpicker.js"></script>
<script type="text/javascript" src="sources/js/customization.js"></script> 
<script type="text/javascript">
function saveStyle(place_id) 
{
	$.ajax({
		type: "post",
		url: "business/customization/"+place_id,
		dataType: 'json',
		data: {"css":$("#customization-style").val()},
		success:  function(data) {},
		error: function (XMLHttpRequest, textStatus, errorThrown)
	{
		alert("error: "+errorThrown);  
	}
	});
}
</script> 
  
<div id="controls" class="draggable br4 glowBig">
	<div id="colors">
		<div class="dragHandle"><span class="iresize"></span></div>
		
		<div class="clear"></div>
		
		<div class="etHolder">
			<h4 id="t1" class="expandTitle br3">Заглавия</h4>
			<span id="ch1" class="controlsHelper" title="<span class='biggerFont'>Заглавията на модулите</span> <br /> <span class='small gc'>кликни за да видиш елементите</small>">?</span>
		</div>
		<div id="eb1" class="expandBox br3">		        
	        <div class="optionHolder">
		        <label>Заоблени ъгли</label>
	        	<div class="sliderBar" id="border-rounder"></div>
	        </div>
	        
            <div class="optionHolder">
                <label>Фон</label>
                <input type="text" maxlength="6" id="topGradientValue" class="pickable" rel="backgroundTop" value="ffffff" style="background: #fff;" />
                <input type="text" maxlength="6" id="bottomGradientValue" class="pickable" rel="backgroundBottom" value="f1f1f1" style="background: #f1f1f1;" />
            </div> 
            
            <div class="optionHolder">
                <label>Долна ивица</label>
                <input type="text" maxlength="6" id="borderBottomColorValue" class="pickable" rel="borderBottomColor" value="dddddd" style="background: #ddd;" />
                <div class="sliderBar" id="border-bottom"></div>
            </div> 
            
            <div class="optionHolder">
                <label>Текст</label>
                <input type="text" maxlength="6" id="textColor" class="pickable" rel="textColor" value="444444" style="background: #444;" />
            </div>
            
            <div class="optionHolder">
                <label>Сянка на текста</label>
                <input type="text" maxlength="6" id="fontShadowColorValue" class="pickable" rel="fontShadowColor" value="ffffff" style="background: #fff;" />
                <div class="sliderBar" id="fontShadowSize"></div>
            </div>  
	         
	        <div class="optionHolder">
		        <label>Шрифт</label>
		        <select id="fontSelector" style="width: 100%; margin: 5px 0px;">
		            <option selected="seleted" value=""MyriadPro", Arial, Sans-Serif" style="font-family: "MyriadPro", Arial, Sans-Serif">Myriad Pro</option>
		            <option value="Arial, Sans-Serif" style="font-family: Arial, Sans-Serif">Arial</option>
		            <option value="Georgia, Serif" style="font-family: Georgia, Serif">Georgia</option>
		            <option value=""Lucida Grande", Arial, Sans-Serif" style="font-family: "Lucida Grande", Arial, Sans-Serif">Lucida Grande</option>
		            <option value="Tahoma, Sans-Serif" style="font-family: Tahoma, Sans-Serif;">Tahoma</option>
		            <option value="Verdana, Sans-Serif" style="font-family: Verdana, Sans-Serif;">Verdana</option> 
		        </select>
	        </div>
        </div><!-- end of expandBox -->
          
        <div class="clear"></div> 
        
		<div class="etHolder">
			<h4 id="t2" class="expandTitle br3">Кутии</h4>
			<span id="ch2" class="controlsHelper" title="<span class='biggerFont'>Модулите с информация</span> <br /> <span class='small gc'>кликни за да видиш елементите</small>">?</span>
		</div>
		<div id="eb2" class="expandBox br3">
 	        
	            <div class="optionHolder">
	                <label>Фон</label>
	                <input type="text" maxlength="6" id="boxBgrSolidValue" class="pickable" rel="boxBgrSolid" value="ffffff" style="background: #ffffff;" /> 
	            </div>
     	        <b class="subTitle">Сянка</b>
	            <div class="optionHolder">
	                <label for="boxShadowColorValue">Цвят</label>
	                <input type="text" maxlength="6" id="boxShadowColorValue" class="pickable" rel="boxShadowColor" value="babea9" style="background: #babea9;" /> 
	                
	                <label>Размер</label>
	                <div class="sliderBar" id="boxShadowSize"></div>
	                
	                <label>Позиция по X</label>
					<div class="sliderBar" id="boxShadowPosX"></div>
					
	                <label>Позиция по Y</label>
					<div class="sliderBar" id="boxShadowPosY"></div>
	            </div>
	            
	            
	            <b class="subTitle">Текст</b>
	            <div class="optionHolder">
	                <label>Цвят</label>
	                <input type="text" maxlength="6" id="boxTextColor" class="pickable" rel="boxTextColor" value="444444" style="background: #444444;" />
	            </div>  
	    		<div class="optionHolder">
					<label>Шрифт</label>
					<select id="boxFontSelector" style="width: 100%; margin: 5px 0px;">
						<option selected="seleted" value="MyriadPro, Arial, Sans-Serif" style="font-family:MyriadPro, Arial, Sans-Serif">Myriad Pro</option>
						<option value="Arial, Sans-Serif" style="font-family: Arial, Sans-Serif">Arial</option>
						<option value="Georgia, Serif" style="font-family: Georgia, Serif">Georgia</option>
						<option value="Lucida Grande, Arial, Sans-Serif" style="font-family: Lucida Grande, Arial, Sans-Serif">Lucida Grande</option>
						<option value="Tahoma, Sans-Serif" style="font-family: Tahoma, Sans-Serif;">Tahoma</option>
						<option value="Verdana, Sans-Serif" style="font-family: Verdana, Sans-Serif;">Verdana</option> 
					</select>
				</div>        
				
				
				<b class="subTitle">Тагове</b>
				<div class="optionHolder">
					<label>Заглавие</label>
					<input type="text" maxlength="6" id="boxAIFontColorB" class="pickable" rel="boxAIFontColorB" value="777777" style="background: #777777;" />
				</div>
				<div class="optionHolder">
					<label>Съдържание</label>
					<input type="text" maxlength="6" id="boxAIFontColorT" class="pickable" rel="boxAIFontColorT" value="444444" style="background: #444444;" />
				</div>
				
				
				<b class="subTitle">Линкове</b>	        
	            <div class="optionHolder">
	                <label>Линк</label>
	                <input type="text" maxlength="6" id="linkNormalValue" class="pickable" rel="linkNormal" value="1a74c7" style="background: #1a74c7;" /> 
	            </div>
	            <div class="optionHolder">
	                <label>Ховър</label>
	                <input type="text" maxlength="6" id="linkHoverValue" class="pickable" rel="linkHover" value="7A901C" style="background: #7A901C;" /> 
	            </div> 
				<div class="optionHolder">
					<label>Второстепенни</label>
					<input type="text" maxlength="6" id="boxSecondLinks" class="pickable" rel="boxSecondLinks" value="555555" style="background: #555555;" />
				</div>
		        <div class="optionHolder">
			        <label>Шрифт</label>
			        <select id="linkFontSelector" style="width: 100%; margin: 5px 0px;">
			            <option selected="seleted" value="MyriadPro, Arial, Sans-Serif" style="font-family:MyriadPro, Arial, Sans-Serif">Myriad Pro</option>
			            <option value="Arial, Sans-Serif" style="font-family: Arial, Sans-Serif">Arial</option>
			            <option value="Georgia, Serif" style="font-family: Georgia, Serif">Georgia</option>
			            <option value="Lucida Grande, Arial, Sans-Serif" style="font-family: Lucida Grande, Arial, Sans-Serif">Lucida Grande</option>
			            <option value="Tahoma, Sans-Serif" style="font-family: Tahoma, Sans-Serif;">Tahoma</option>
			            <option value="Verdana, Sans-Serif" style="font-family: Verdana, Sans-Serif;">Verdana</option> 
			        </select>
		        </div>
 
        </div><!-- end of expandBox -->
          
        <div class="clear"></div> 

		<div class="etHolder">
			<h4 id="t3" class="expandTitle br3">Фон</h4>
			<span id="ch3" class="controlsHelper" title="<span class='biggerFont'>Фонът на страницата</span>">?</span>
		</div>
		<div id="eb3" class="expandBox br3"> 
	        
	            <div class="optionHolder">
	                <label>Фон</label>
	                <input type="text" maxlength="6" id="bodyBgrColorTopValue" class="pickable" rel="bodyBgrColorTop" value="ECEDE6" style="background: #ECEDE6;" />
	                <input type="text" maxlength="6" id="bodyBgrColorBottomValue" class="pickable" rel="bodyBgrColorBottom" value="ECEDE6" style="background: #ECEDE6;" />  
	            </div>
	        
	        	<b class="subTitle">Картинка</b>    
	            <div class="optionHolder">
	                <label>Качи</label>
	                <div class="clear"></div>
	                <input type="file" id="bodyBgrImageValue" value="http://img.edno23.com/site2/logoo.gif" style="display: none !important;" rel="bodyBgrImage" />
				</div>
				
				<div class="optionHolder">
					<label>Повторение</label>
	                <select id="bgrRepeat" style="width: 100%; margin: 5px 0px;">
		                <option value="repeat">Повторение по X и Y</option>
		            	<option value="repeat-x">Повторение по X</option>
		            	<option value="repeat-y">Повторение по Y</option>
		                <option value="no-repeat">Без повторение</option>
		        	</select>
				</div> 
		        	
		        <div class="optionHolder">
		        	<label>Позиция по X</label>
	                <select id="bgrPositionX" style="width: 100%; margin: 5px 0px;">
		                <option value="left">Ляво</option>
		            	<option value="center">Център</option>
		            	<option value="right">Дясно</option>
		        	</select>
		        </div>

				<div class="optionHolder">
		        	<label>Позиция по Y</label>
	                <select id="bgrPositionY" style="width: 100%; margin: 5px 0px;">
		                <option value="top">Горе</option>
		            	<option value="center">Център</option>
		            	<option value="bottom">Долу</option>
		        	</select>
				</div>
		        
		        <div class="optionHolder">
		        	<label>Цвят отдолу</label>
	                <input type="text" maxlength="6" id="bodyBgrSolidValue" class="pickable" rel="bodyBgrSolid" value="ffffff" style="background: #ffffff;" />
				</div>	
				
				<div class="optionHolder">
		        	<label>Картинката в момента</label>
	        		<img src="sources/images/place-sample.gif" width="100%" alt="Картинката в момента" />	
					<a href="#" class="imgRemove" onclick="alert('Сигурни ли сте, че искате да премахнете картинката?');">Изтрий</a>
				</div>	 
	             
        </div><!-- end of expandBox -->
		
		<div class="clear"></div>

		<a class="btn30" style="margin-top: 5px;" onclick="saveStyle(<?= $place->id; ?>)">Запиши</a>
		
		<a href="#" class="btn30dec" style="margin-top: 3px;" onclick="alert('Сигурни ли сте, че искате да се откажете от направените промени?');">Откажи</a> 
	</div> <!-- end of #colors -->
</div>
 
<input type="hidden" id="customization-style" name="customization-style" />
