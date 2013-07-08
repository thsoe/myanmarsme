<?php error_reporting(E_ALL);
  ini_set("display_errors", 1); 
  header('Cache-Control: no-cache, must-revalidate');
  header('Content-type: application/json');
  
  error_reporting(0);
 require_once 'include/connection_util.php';
try{
$em = ConnectionUtil::getEntityManager();
$user =$em->find('User',$_POST["userName"]);

if(is_null($user)){
echo '{"username" : "guest","result" : 0}';
$log->LogInfo("User not found");


}else if($user->getPassword()==$_POST["password"]){
$user =$em->getRepository('SMEUser')->findOneBy((array('email' => $_POST["userName"])));
$json ='{"username" : "'.$user->getFullName().'","result" : 1,"email" : "'.$user->getEmail().'","phoneNumber" : "'.$user->getPhoneNo().'","companies" : {"company":[';

//echo '{"username" : "'.$user->getFullName().'","result" : 1,"email" : "'.$user->getEmail().'","phoneNumber" : "'.$user->getPhoneNo().'"}';
//$log->LogInfo('{"companies" : [');
$last_key = end(array_keys($user->getCompanies()));
foreach ($user->getCompanies() AS $key => $value) {
if ($key == $last_key) {
        $json =$json.$value->toJSON();
    } else {
       $json =$json.$value->toJSON().",";
    }

}
$json =$json.']}}';
echo $json;
}else{
echo '{"username" : "guest","result" : 0}';
$log->LogInfo("Wrong Password!");
}
}catch (Exception $e){
$log->LogError($e->getMessage());
}
?>