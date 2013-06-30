function show_alert()
{
	alert('url'+url);
var result;
var alertString;
if(edit){
result=updateSMEUser();
alertString="Your account has been successfully updated please logout and login again to see the changes.";
}
else{
result=registerSMEUser();
alertString="Hello..."+fullName+",\nThanks for your registration with our MMSME !\nWe have already sent you a confirmation mail to your mail address.";
}
if(result.result==0){
alert(alertString);
goto(navigation.home);
}else{
alert("An Error Occur During Registration Please Try Again");
goto(navigation.register);
}
}
function back(){
if(edit){
goto(navigation.profile);
}
else{
goto(navigation.register);
}
}


	$("#fullName1").text(fullName);
$("#email1").text(email);
$("#companyName1").text(companyName);
$("#description1").text(description);
$("#phoneNumber1").text(phoneNumber);