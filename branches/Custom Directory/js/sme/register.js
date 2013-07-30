var title="Personal Information";
edit = false;
$("#userForm").load(navigation.userForm);
// when click on Submit button of confirmation.
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