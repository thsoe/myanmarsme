<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1); 
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	require_once 'include/connection_util.php';
	$msg = "An Error Occur During Registration Please Try Again";
	try
	{
		$logger=new KLogger ( "../logs/log.txt" , KLogger::DEBUG );
		$logger->LogDebug("Email:".$_POST['email']);		
		$user = new SMEUser();
		$user->setFullName($_POST["fullName"]);
		$user->setEmail($_POST["email"]);
		$logger->LogInfo($user->toJSON());
		ConnectionUtil::beginTransaction();
		ConnectionUtil::save($user);
		ConnectionUtil::commit();
		$msg="Hello...".$_POST["fullName"].",\nThanks for your registration with our MMSME !\nYou must edit your password in edit profile by clicking on your name.";
		
		$success = 1;
	} catch (Exception $e)
	{
		ConnectionUtil::rollback();
		$msg = $e->getMessage();
		$log->LogInfo($e->getMessage());
		$success = 0;
	}
	$arr = array('success'=>$success, 'msg'=> $msg);
	echo json_encode($arr);
?>