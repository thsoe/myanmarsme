<?php error_reporting(E_ALL);
 require_once 'include/connection_util.php';

try{
$em = ConnectionUtil::getEntityManager();
if($_GET["company"]=="Popular"){
$query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.rank <=10 ");
}else{
$query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', $_GET["company"].'%');
}
$array = $query->getResult();
if(count($array)==0){
echo "<div class='company_detail'><p>There is no item under '".$_GET["company"]."' categories.</p></div>";
}else  {
for ($i=1; $i<=count($array); $i++)
  {
echo  "<div class='company_detail'><p><a href=''><img src='".$array[$i-1]->getLogo()."' width='100' height='100' /></a><h3>".$array[$i-1]->getName()."</h3><br/><p>".$array[$i-1]->getDescription()."</p><p><a class='read_more' href=''>Read More&nbsp;&raquo;</a></p></div>";
}
}
}catch (Exception $e){
$log->LogError($e->getMessage());
}
?>