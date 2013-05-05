$("#fullNameError").hide();
$("#emailError").hide();
$("#passwordError").hide();
$("#confirmPasswordError").hide();
$("#companyNameError").hide();
$("#confirmPasswordError2").hide();
$("#emailError2").hide();
$("#phoneNumberError").hide();
$("#userForm").load(navigation.userForm);
function register(){
if($("#fullName").val()==""){
	$("#fullNameError").show();
$("#emailError").hide();
	$("#passwordError").hide();
$("#confirmPasswordError").hide();
$("#emailError2").hide();
$("#confirmPasswordError2").hide();
$("#phoneNumberError").hide();
}else if($("#email").val()==""){
	$("#emailError").show();
	$("#fullNameError").hide();
	$("#passwordError").hide();
$("#confirmPasswordError").hide();
$("#emailError2").hide();
$("#confirmPasswordError2").hide();
$("#phoneNumberError").hide();
}else if($("#password").val()==""){
	$("#passwordError").show();
	$("#fullNameError").hide();
$("#emailError").hide();
$("#confirmPasswordError").hide();
$("#emailError2").hide();
$("#confirmPasswordError2").hide();
$("#phoneNumberError").hide();
}
else if($("#confirmPassword").val()==""){
	$("#confirmPasswordError").show();
	$("#fullNameError").hide();
$("#emailError").hide();
	$("#passwordError").hide();
$("#emailError2").hide();
$("#confirmPasswordError2").hide();
$("#phoneNumberError").hide();
}
else if(!validateEmail($("#email").val())){
$("#emailError2").show();
	$("#fullNameError").hide();
	$("#passwordError").hide();
$("#confirmPasswordError").hide();
$("#emailError").hide();
$("#confirmPasswordError2").hide();
$("#phoneNumberError").hide();
}else if($("#password").val()!=$("#confirmPassword").val()){
	$("#fullNameError").hide();
$("#emailError").hide();
$("#emailError2").hide();
	$("#passwordError").hide();
$("#confirmPasswordError").hide();
$("#phoneNumberError").hide();
$("#confirmPasswordError2").show();
}else if(!validatePhNo($("#phoneNumber").val())){
	$("#fullNameError").hide();
$("#emailError").hide();
$("#emailError2").hide();
	$("#passwordError").hide();
$("#confirmPasswordError").hide();
$("#confirmPasswordError2").hide();
$("#phoneNumberError").show();
}
else{
	fullName=$("#fullName").val();
email=$("#email").val();
description=$("#description").val();
phoneNumber=$("#phoneNumber").val();
req_params = "fullName="+fullName+"&password="+$("#password").val()+"&email="+email+"&phoneNumber="+phoneNumber;
	goto(navigation.confirmation,req_params );
	
}
}