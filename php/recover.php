<?php error_reporting(E_ALL);
  ini_set("display_errors", 1); 
  header('Cache-Control: no-cache, must-revalidate');
  header('Content-type: application/json');
 require_once 'include/connection_util.php';



require_once './lib/Swift/lib/swift_required.php';
try{
$em = ConnectionUtil::getEntityManager();
$user =$em->find('User',$_POST["userName"]);
if(is_null($user)){
echo '{"username" : "guest","result" : 0}';
$log->LogInfo("Invalid Email Address");

}else{
$smeuser =$em->getRepository('SMEUser')->findOneBy((array('email' => $_POST["userName"])));
$transport = Swift_SmtpTransport::newInstance('relay-hosting.secureserver.net', 25);


// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);

// Create a message
$message = Swift_Message::newInstance('NoRely-yourmyanmarsme-com')
  ->setFrom(array('noreply@yourmyanmarsme.com' => 'MMSME-NoReply-Password-Recovery'))
  ->setTo(array($smeuser->getEmail() => $smeuser->getFullName()))
  ->setBody("Greetings, ".$smeuser->getFullName()."\n\nYour Password is ". $user->getPassword()."\n\nYou are receiving this email because someone has requested the password recovery on our website \"www.yourmyanmarsme.com\" using the email address ".$smeuser->getEmail().".\n\n\n\nBest Regards\nAdmin")
  ;

// Send the message
$result = $mailer->send($message);
echo '{"username" : "guest","result" : 1}';

}
} catch (Exception $e) {

  $log->LogInfo($e->getMessage());
   echo '{"result" : 1}';
}
?>
