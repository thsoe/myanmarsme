$("#pinfo").text(title);
$("#fullNameError").hide();
$("#emailError").hide();
$("#passwordError").hide();
$("#confirmPasswordError").hide();
$("#companyNameError").hide();
$("#confirmPasswordError2").hide();
$("#emailError2").hide();
$("#phoneNumberError").hide();
$("#passwordCheckBox").hide();
$("#passwordEdit").hide();
$("#buttonUpdate").hide();
$("#buttonRegister").show();
$("#link").attr("href", "javascript:register()")
if(edit){
$("#passwordCheckBox").show();
$("#passwordEdit").show();
$("#buttonUpdate").show();
$("#buttonRegister").hide();
$("#password").attr("disabled", true);
$("#confirmPassword").attr("disabled", true);
$("#link").attr("href", "javascript:update()")
}

if(auth.result != 0 ){
$("#fullName").val(auth.username);
$("#email").val(auth.email);
$("#email").attr('disabled', true);
$("#phoneNumber").val(auth.phoneNumber);
}
var passwd=0;

// when check on 'Enable Password Edit' checkbox, the password field can be edit.
function enablePasswordFields(){
if (passwd==0){
passwd=1;
$("#password").attr("disabled", false);
$("#confirmPassword").attr("disabled", false);
}else{
passwd=0;
$("#password").attr("disabled", true);
$("#confirmPassword").attr("disabled", true);
}
}

// validation for user registration.
function validateUserForm(){
if($("#fullName").val()==""){
	$("#fullNameError").show();
	$("#emailError").hide();
	$("#passwordError").hide();
	$("#confirmPasswordError").hide();
	$("#emailError2").hide();
	$("#confirmPasswordError2").hide();
	$("#phoneNumberError").hide();
	return false;
}else if($("#email").val()==""){
	$("#emailError").show();
	$("#fullNameError").hide();
	$("#passwordError").hide();
	$("#confirmPasswordError").hide();
	$("#emailError2").hide();
	$("#confirmPasswordError2").hide();
	$("#phoneNumberError").hide();
	return false;
}else if($("#password").val()=="" && passwd==1 ){
	$("#passwordError").show();
	$("#fullNameError").hide();
	$("#emailError").hide();
	$("#confirmPasswordError").hide();
	$("#emailError2").hide();
	$("#confirmPasswordError2").hide();
	$("#phoneNumberError").hide();
	return false;
}
else if($("#confirmPassword").val()=="" && passwd==1){
	$("#confirmPasswordError").show();
	$("#fullNameError").hide();
	$("#emailError").hide();
	$("#passwordError").hide();
	$("#emailError2").hide();
	$("#confirmPasswordError2").hide();
	$("#phoneNumberError").hide();
	return false;
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
	return false;
}else if(!validatePhNo($("#phoneNumber").val())){
	$("#fullNameError").hide();
	$("#emailError").hide();
	$("#emailError2").hide();
	$("#passwordError").hide();
	$("#confirmPasswordError").hide();
	$("#confirmPasswordError2").hide();
	$("#phoneNumberError").show();
	return false;
}else{
	return true;	
}
}