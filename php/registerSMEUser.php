<?php 
	error_reporting(E_ALL);
	ini_set("display_errors", 1); 
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	require_once 'include/connection_util.php';
	require_once './lib/Swift/lib/swift_required.php';
	$msg = "An Error Occur During Registration Please Try Again";
	try
	{
		$logger=new KLogger ( "../logs/log.txt" , KLogger::DEBUG );
		$logger->LogDebug("Email:".$_POST['email']);		
		$user = new SMEUser();
		$user->setFullName($_POST["fullName"]);
		$user->setEmail($_POST["email"]);
		$user->setPassword($_POST["password"]);
		$user->setPhoneNo($_POST["phoneNumber"]);
		$logger->LogInfo($user->toJSON());
		ConnectionUtil::beginTransaction();
		ConnectionUtil::save($user);
		ConnectionUtil::commit();
		$msg="Hello...".$_POST["fullName"].",\nThanks for your registration with our MMSME !\nWe have already sent you a confirmation mail to your mail address.";
		$transport = Swift_SmtpTransport::newInstance('relay-hosting.secureserver.net', 25);

		
		// Create the Mailer using your created Transport
		$mailer = Swift_Mailer::newInstance($transport);

		// Create a message
		$message = Swift_Message::newInstance('NoRely-yourmyanmarsme-com')
		  ->setFrom(array('noreply@yourmyanmarsme.com' => 'MMSME-NoReply'))
		  ->setTo(array($user->getEmail() => $user->getFullName()))
		  ->setBody("Greetings, ".$user->getFullName()."\n\nThank you for your interest in Myanmar SME Project.\n\nYou are receiving this email because someone has started a registraion on our website \"www.yourmyanmarsme.com\" using the email address\n".$user->getEmail()." and a user name ".$user->getFullName().".\n\n\n\nBest Regards\nAdmin")
		  ;

		// Send the message
		$result = $mailer->send($message);
		
		//echo '{"result" : 0}';
		$success = 1;
	} catch (Exception $e) {
		ConnectionUtil::rollback();
		$msg = $e->getMessage();
		$log->LogInfo($e->getMessage());
	   //echo '{"result" : 1}';
	  $success = 0;
	}

	//echo "{\"success\" : \"" . $success . "\", \"msg\" : \"" . $msg . "\"}";
	/*echo "{";
	echo				"\"msg\": \"" . $msg . "\"\n";
	echo "}";*/
	$arr = array('success'=>$success, 'msg'=> $msg);
	echo json_encode($arr);
?>