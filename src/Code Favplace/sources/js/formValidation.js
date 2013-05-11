  // JavaScript Document
var formValidation={
  config_valid:false,
  fieldTimeout:new Array(),
  config:null,
  fieldStatus:[],
  setFieldStatus:function (field,status,message){
	  this.fieldStatus[field]=status;
  
	  var label=eval(this.config.form+"."+field);
  
	  if(status=="invalid"){
		  if(message) this.config.fieldInvalid(label,message);
		  else if(this.config.messagesInvalid){
			  this.config.fieldInvalid(label,this.config.messagesInvalid[field]);
		  }
	  }
	  else if(status=="valid"){
		  if(message) this.config.fieldValid(label,message);
		  else if(this.config.messagesValid){
			  this.config.fieldValid(label,this.config.messagesValid[field]);
		  }
	  }
	  else if(status=="wait"){
		   if(message) this.config.fieldWait(label,message);
		   else if(this.config.messagesInvalid){
			   this.config.fieldWait(label,this.config.messagesWait[field]);
		   }
	  }
  },
  setRules:function(config){	  
	  this.config=config;	
	  // does the form exist
	  if(eval(this.config.form)) this.config_valid=true;
	  else this.config_valid=false;
	  
	  if(this.config.sBtn) this.sBtnValue=this.config.sBtn.value;
	 
	  if(this.config.secondsToWait) this.secondsToWait=this.config.secondsToWait;
	  else this.config.secondsToWait=this.secondsToWait;
	  
	  if(this.config.messagesValid==null){
		this.config.messagesValid=this.config.messagesInvalid;
	  }
	  
	  for(field in this.config.rules){
		  if(this.config.defaultFieldStatus) this.fieldStatus[field]=this.config.defaultFieldStatus;
		  else this.fieldStatus[field]="invalid";
		  
		  this.fieldTimeout[field]=null;
	  }
	  
	 
	  
  },
  vFieldT:function (fieldStr){
	clearTimeout(this.fieldTimeout[fieldStr]);
  	this.fieldTimeout[fieldStr]=setTimeout(this.config.instanceName+".vField('"+fieldStr+"')",this.config.timeout);
  },
  vField:function(fieldStr){	  	  
  var rules=this.config.rules[fieldStr].split("|");
  var form=this.config.form;
  
  var field=eval(form+"."+fieldStr);
  
 // if(field.toString()=="[object NodeList]")
  
 if(field.value) var fieldValue=field.value;
  
  for(rule in rules){
	  var ruleParts=rules[rule].match(/(.*?)\[(.*?)\]/);
	  if(ruleParts){
		  curRule=ruleParts[1];
		  curParam=ruleParts[2];
	  }else{
		  var curRule=rules[rule];
		  var curParam='';	
	  }

	  switch(curRule)
	  {
		  
		  
		  case "trim":
			  fieldValue=fieldValue.replace(/^\s+|\s+$/g,"");
			  break;
		  case "required":
			  if(fieldValue==null||fieldValue==""){
				  this.setFieldStatus(fieldStr,"invalid");
				  return false;
			  }
			  break;
		  case "matches":
			  var fieldToMatch=eval(form+"."+curParam);
			  if(fieldValue!=fieldToMatch.value){
				  this.setFieldStatus(fieldStr,"invalid");
				  return false;
			  }
			  break;
		  case "min_length":
			  if(fieldValue.length<curParam){
				  this.setFieldStatus(fieldStr,"invalid");
				  return false;
			  }
			  break;
		  case "max_length":
			  if(fieldValue.length>curParam){
				  this.setFieldStatus(fieldStr,"invalid");
				  return false;
			  }
			  break;
		  case "exact_length":
			  if(fieldValue.length!=curParam){
				  this.setFieldStatus(fieldStr,"invalid");
				  return false;
			  }
			  break;
		  case "alpha":
			  if(fieldValue.search(/^([a-z])+$/i)==-1){
				  this.setFieldStatus(fieldStr,"invalid");
				  return false;
			  }
			  break;
		  case "alpha_numeric":
			  if(fieldValue.search(/^([a-z0-9])+$/i)==-1){
				  this.setFieldStatus(fieldStr,"invalid");
				  return false;
			  }
			  break;
		  case "alpha_dash":
			  if(fieldValue.search(/^([-a-z0-9_-])+$/i)==-1){
				  this.setFieldStatus(fieldStr,"invalid");
				  return false;
			  }
			  break;
		  case "numeric":
			  if(fieldValue.search(/^[\-+]?[0-9]*\.?[0-9]+$/)==-1){
				  this.setFieldStatus(fieldStr,"invalid");
				  return false;
			  }
			  break;
		  case "integer":
			  if( ! parseInt(fieldValue,10)){
				  this.setFieldStatus(fieldStr,"invalid");
				  return false;
			  }
			  break;
		  case "is_natural":
			  if(fieldValue.search(/^[0-9]+$/)==-1){
				  this.setFieldStatus(fieldStr,"invalid");
				  return false;
			  }
			  break;
		  case "is_natural_no_zero":
			  if(fieldValue.search(/^[0-9]+$/)==-1){
				  this.setFieldStatus(fieldStr,"invalid");
				  return false;
			  }
			  break;
		  case "valid_email":
			  if(fieldValue.search(/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ig)==-1){
				  this.setFieldStatus(fieldStr,"invalid");
				  return false;
			  }
			  break;
		  case "callback": eval(curParam);
			  break;
	  }
}
  
  this.setFieldStatus(fieldStr,"valid");

  },
  sBtnValue:'',
  secondsToWait:10,
  isFormValid:function (){
	  if(!this.config.secondsToWait){
		  alert("Възникна грешка при свързването със сървъра."); 
		  return false;
	  }
	  this.config.secondsToWait--;
	  for(field in this.config.rules){
		  if(this.fieldStatus[field]=="wait"){
			  if(this.config.sBtn){
				  this.config.sBtn.value=this.config.waitMessage+this.config.secondsToWait+" сек.";
			  }
			  that=this;
			  setTimeout("that.isFormValid()",1000);
			  return false;
		  }else{
			  if(this.config.sBtn){
			  	this.config.sBtn.value=this.sBtnValue;
			  }
			  this.config.secondsToWait=this.secondsToWait;
		  }
		  if(this.fieldStatus[field]=="invalid"){
			  alert(field);
			  var label=eval(this.config.form+"."+field);
			  this.config.fieldInvalid(label, this.config.messagesInvalid[field])
			  return false;
		  }
	  }
	  return true;	  
  }
  
  };
  
  function createFormValidation()
  {
	  return $.extend(true, {}, formValidation)  
  }