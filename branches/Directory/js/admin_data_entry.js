function checkCookie(){
    var cookieEnabled=(navigator.cookieEnabled)? true : false;
    if (typeof navigator.cookieEnabled=="undefined" && !cookieEnabled){ 
        document.cookie="testcookie";
        cookieEnabled=(document.cookie.indexOf("testcookie")!=-1)? true : false;
    }
    return (cookieEnabled)?true:showCookieFail();
}

function showCookieFail(){
	window.stop();
	alert("cookie need to support for this site! Please enable the cookie in browser");
}


checkCookie();
function checkAuthentication(result){
	if(result.status == 'N'){
		window.location="login.html";
	}
	load();
}
function isLogin(){
	$.ajax({
		url : "../php/user_service.php",
		type : "POST",
		dataType : "json",
		data : {checkAuthentication : 'Y'} ,
		success : checkAuthentication,
		error : function (result){
			$("#error").html(result.responseText);
		}
	});
}

$(document).ready(function(){
	$("#login").click(function (){
		var user = $("#name").val();
		var password = $("#password").val();
		if($.trim(user)==''){ 
			$("#error").html("empty name!");
			return;
		}
		if($.trim(password)==''){
			$("#error").html("empty password!");
			return;
		}
		var data = {name : user, password : password};
		$.ajax({
			url : "../php/user_service.php",
			type : "POST",
			dataType : "json",
			data : data ,
			success : function(result){
				if(result.status == '00'){
					window.location="zone_entry.html";
//					document.cookie="sessionId="+sessionId;
				}
				else if(result.status == '01'){
					$("#error").html("bad cridential!");
				}
			},
			error : function (result){
				$("#error").html(result.responseText);
			}
		});
	});
	$("#cancel").click(function(){
		$("#name").val("");
		$("#password").val("");
	});
		
});
