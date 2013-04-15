<?php error_reporting(E_ALL);
  ini_set("display_errors", 1); 
  header('Cache-Control: no-cache, must-revalidate');
  header('Content-type: application/json');
 require_once 'include/connection_util.php';


try{
$em = ConnectionUtil::getEntityManager();
$array =$em->getRepository('NewsFeed')->findAll();
echo '{"news" : [';
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]}";
}catch (Exception $e){
$log->LogError($e->getMessage());
}
?>