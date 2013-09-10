var navigation;
var today = new Date();
var lables;
var newsfeeds;
var comp_id;
var companylist;
var req_params;
var xmlhttp;
var adlist;
var companyDetails;
var zonelist;
var activeMenu = null;
var links;
var recoverStatus;

// check the input email is valid email format or not.
function validateEmail(email)
{
var x=email;
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {  
	return false;
  }
return true;
}
function data_clear(data){
	for(var i=0;i<data.length;i++){
		document.getElementById(data[i]).value="";
	}
	document.getElementById(data[0]).focus();
}
function data_valid(data1,data2){
	var flag=true;
	for(var i=0;i<data1.length;i++){
		if(document.getElementById(data1[i]).value==""){
			alert("Please! Enter " + data2[i]);
			document.getElementById(data1[i]).focus();
			flag=false;
			break;
		}
	}
	return flag;
}

function swapJsonKeyValues(input) {
    var one, output = {};
    for (one in input) {
        if (input.hasOwnProperty(one)) {
            output[input[one]] = one;
        }
    }
    return output;
}

// check input phone no is valid or not.
function validatePhNo(no){
	var s =!(no.match("[A-z]"));
	return s
}

function loadJSON(url,param){
//alert(param);
if (xmlhttp ==null){	
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  }
 if(comp_id != null){
  url = url+"_"+comp_id;
  }
  xmlhttp.open("POST",url,false);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
 if(param != null){
//  xmlhttp.setRequestHeader("Content-length", param.length);
//xmlhttp.setRequestHeader("Connection", "close");
xmlhttp.send(param);
//alert(xmlhttp.responseText);
  }else{

xmlhttp.send();
  }
 
try
  {												
//narvigation= eval ("(" + xmlhttp.responseText + ")");
var obj= JSON.parse(xmlhttp.responseText,  function (key, value) {

    var type;
    if (value && typeof value === 'object') {
        type = value.type;
        if (typeof type === 'string' && typeof window[type] === 'function') {
            return new (window[type])(value);
        }
    }
    return value;
});

xmlhttp.close;
return obj;
}
catch(err)
  {													 
	//alert(xmlhttp.responseText); 
	goto(navigation.error);
	//alert($('#commonError').text());
	
	//$('#commonError').write(xmlhttp.responseText);
	//return null;
  }
}

function enterKey(e,fcn)
{
var keynum;

if(window.event) // IE8 and earlier
	{
	keynum = e.keyCode;
	}
else if(e.which) // IE9/Firefox/Chrome/Opera/Safari
	{
	keynum = e.which;
	}
if (keynum == 13){
fcn();
}
}

function goto(url,params){
req_params = params;


if( url == navigation.zones){

$("#jqnews").hide();
$("#md_content2").width("765px");
}else 
if(url ==navigation.comDetail){
$("#jqnews").hide();
companyDetails=req_params;
}else
//if(url == navigation.home)
{
$("#comp_box").hide();
$("#slider1").show();
$("#jqnews").show();
$("#lf_content").show();
$("#md_content2").width("765px");
}

window.location.hash="#"+links[url];
}
function loadMainContent(url){
	$("#maincontent").load(url);
}

function loadNavigation(){
 navigation = loadJSON("/json/navigation.json.txt");

}

function loadlables(){
lables= loadJSON("/json/lables.json.txt");
}

function loadNewsFeeds(){
newsfeeds= loadJSON(navigation.getNewsFeed);
}

//-------- give email and password parameters to getAuth.php to check for login --------//
function loadAuthentication(){
auth= loadJSON(navigation.getAuth,req_params);
}

//-------- give email and name parameters to getAuth_api.php to check for login --------//
function loadAuthentication_api(){
auth= loadJSON(navigation.getAuth_api,req_params);
}


function registerSMEUser(){
var result=loadJSON(navigation.registerSMEUser,req_params);
return result;
}

function registeruser_api(){
var result=loadJSON(navigation.registration_api,req_params);
return result;
}

function updateSMEUser(){
var result=loadJSON(navigation.updateSMEUser,req_params);
return result;
}

function loadCompanyList(){
companylist= loadJSON(navigation.getCompanyList);

}

function loadZoneList(){
zonelist= loadJSON(navigation.getZoneList);

}

function loadRecover(){
recoverStatus= loadJSON(navigation.getRecover,req_params);

}
function loadCompanyAds(){
adlist= loadJSON("/json/companyads.json.txt");

}

function loadCompanyDetails(id){
	comp_id=id;
companyDetails= loadJSON("/json/companydetails.json.txt");

}

function setActive(element){ 
element.id="active_state"; 
if(activeMenu == null){
	activeMenu = element;
}
else{
activeMenu.id=""; 
activeMenu = element;
}

}

function parseHeader(){
document.getElementById('wel_col3').innerHTML=today.toLocaleDateString();
if(auth.result == 0 ){
document.getElementById('wel_col2').innerHTML='<a href="javascript:goto(navigation.lfSignIn)">'+lables.signIn+'</a> / <a href="javascript:goto(navigation.register)">Register</a>';
document.getElementById('wel_col1').innerHTML='Welcome ' + auth.username;
}
else{
document.getElementById('wel_col2').innerHTML='<a href="javascript:logout()">'+lables.logOut+'</a><br/><a id="wish_list" href="javascript:goto(navigation.wishList)">Wish List</a>';
document.getElementById('wel_col1').innerHTML='Welcome <a href="javascript:goto(navigation.profile)">' + auth.username+'</a>';
}

}

function recover()
{
	$("#pleasewait").show();
	if($('input[name=text]').val()==""){
	$("#error1").show();
	$("#error2").hide();
	$("#pleasewait").hide();
	$("#passwords").hide();	
	}else{
	req_params = "userName="+$('input[name=text]').val();
	loadRecover();
	if(recoverStatus.result==0){
		$("#error1").hide();
 		$("#pleasewait").hide();
		$("#passwords").hide();	
		$("#error2").show();
	}else{
		$("#error1").hide();
  		$("#error2").hide();
		$("#pleasewait").hide();
		$("#passwords").show();
	}
	}
}

//------------- check email, password for sign in from If_signIn.html ---------- //
function authenticate(){
$("#pleasewait").show();
$("#error").hide();
$("#error1").hide();
$("#error2").hide();

if($('input[name=text]').val()==""){
$("#error1").show();
$("#pleasewait").hide();
}else if($('input[name=password]').val()==""){
$("#error2").show();
$("#pleasewait").hide();
}else{
$("#error1").hide();
$("#error2").hide();
req_params = "userName="+$('input[name=text]').val()+"&password="+$('input[name=password]').val();
loadAuthentication();
if (auth !=null){
if(auth.result == 0 ){
$("#error").show();
$("#pleasewait").hide();
}else{
parseHeader();
$("#error").hide();
//$("#icon_1").hide();
//$("#lfupload").show();
$.cookies.set("session", JSON.stringify(auth));
//setCookie("session",auth,1);
//goto(navigation.home);}
goto(navigation.dashboard);}
}}
}

//------------- check email, password for facebook login from If_signIn.html ---------- //
function authenticate_api(email, name)
{
	$("#pleasewait").show();
	$("#error").hide();
	$("#error1").hide();
	$("#error2").hide();
	req_params = "userName="+email;
	loadAuthentication_api();
	if (auth != null)
	{
		if(auth.result == 0) // if the email is not found, register in user
		{
			req_params = "fullName="+name+"&email="+email;
			result = registeruser_api();
			if(result.success)	// if the registration is success, login again with email.
				authenticate_api(email, name);
			else
			{
				$("#error").show();
				$("#pleasewait").hide();
			}
		}
		else
		{
			parseHeader();
			$("#error").hide();
			$.cookies.set("session", JSON.stringify(auth));
			//goto(navigation.home);
			goto(navigation.dashboard);
		}
	}
}

//------------- when click sign out ---------- //
function logout(){
/* FB.logout(function(response) {
  alert('logout');
}); */
auth = {
"username" : "Guest",
"result" : 0
};
parseHeader();
//$("#icon_1").show();
//$("#lfupload").hide();
$("#pleasewait").hide();
$.cookies.del("session");

//goto(navigation.home);
window.location = '#';
window.location.reload();
}

function home_dashboard()
{
	if(auth.result == 0 )
		goto(navigation.home);
	else
		goto(navigation.dashboard);
}

var fullName="";
var email="";
var companyName="";
var description="";
var phoneNumber="";