var title="Personal Information";
var edit = false;
$("#userForm").load(navigation.userForm);
function register(){
if(!validateUserForm()){
	
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