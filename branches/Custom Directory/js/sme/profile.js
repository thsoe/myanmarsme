$("#fullName1").text(auth.username);
$("#email1").text(auth.email);
$("#phoneNumber1").text(auth.phoneNumber);
if(auth.companies.company.length===0){
$("#companies").append("<div class='company_detail'><p>You have no associated commpanies.</p></div>");
}else{
$.each(auth.companies.company, function(index, value) {
  $("#companies").append("<div class='company_detail'><p><a href='javascript:goto(navigation.comDetail,auth.companies.company["+index+"])'><img src='"+value.logo+"' width='100' height='100' /></a><h3>"+value.name+"</h3><br/><p>"+value.description+"</p><p><a class='read_more' href='javascript:goto(navigation.comDetail,companylist.companies[0].popular["+index+"])'>Read More&nbsp;&raquo;</a></p></div>");
});
}
var title="Edit - Personal Information";
var edit = true;
function editProfile(){
	
$("#userForm").load(navigation.userForm);
window.location.hash="#EditProfile";

}

function update(){
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