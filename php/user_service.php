<?php
	session_start();
	if(isset($_POST["checkAuthentication"]) && $_POST["checkAuthentication"] == 'Y'){
		if(isset($_SESSION["name"]))
			echo '{ "status":"Y" ,"name" :"'.$_SESSION["name"].'","sessionId" : "' .session_id() . '"}';
		else
			echo '{ "status" :"N","sessionId" : "' .session_id() . '"}';
	}
	else{
		if(isset($_POST["name"]) && $_POST["name"] == "38383630" && isset($_POST["password"])
			&& $_POST["password"] == 'myanmarsme' ){
				$_SESSION["name"] = $_POST["name"];
			echo '{ "status" : "00" , "sessionId" : "' .session_id() . '"}';
		}
		else{
			echo ' { "status" : "01" } ';
		}
	}
?>