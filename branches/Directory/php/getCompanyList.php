<?php error_reporting(E_ALL);
  ini_set("display_errors", 1); 
  header('Cache-Control: no-cache, must-revalidate');
  header('Content-type: application/json');
 require_once 'include/connection_util.php';


try{
$em = ConnectionUtil::getEntityManager();
echo '{"companies" :[';
echo '{"popular"     : [';
$query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.rank <=10 ");
$array = $query->getResult();
if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"A"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'A%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"B"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'B%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"C"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'C%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"D"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'D%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"E"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'E%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"F"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'F%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"G"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'G%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"H"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'H%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"I"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'I%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"J"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'J%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"K"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'K%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"L"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'L%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"M"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'M%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"N"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'N%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"O"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'O%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"P"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'P%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"Q"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'Q%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"R"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'R%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"S"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'S%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"T"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'T%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"U"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'U%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"V"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'V%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"W"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'W%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"X"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'X%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"Y"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'Y%');
$array = $query->getResult();

if(count($array)==0){
echo "]},";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]},";
}
echo '{"Z"     : [';
 $query =$em->createQuery("SELECT smeCompany FROM SMECompany smeCompany WHERE smeCompany.name LIKE :alphabet");
$query->setParameter('alphabet', 'Z%');
$array = $query->getResult();

if(count($array)==0){
echo "]}";
}else  {
for ($i=1; $i<count($array); $i++)
  {
  echo  $array[$i-1]->toJSON().",";

  }
echo  $array[count($array)-1]->toJSON()."]}";
}


echo "]}";
}catch (Exception $e){
$log->LogError($e->getMessage());
}
?>