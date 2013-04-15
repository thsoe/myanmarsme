<?php error_reporting(E_ALL);
  ini_set("display_errors", 1); 
  header('Cache-Control: no-cache, must-revalidate');
  header('Content-type: application/json');?>
<?php require_once 'include/connection_util.php';
 ?>
<?php
	$msg="";
	$id="";
	if(isset($_POST["mode"])){
		$zone=new IndustrialZone();	
		if(isset($_POST["name"]))	
			$zone->setName(str_replace("\\'","'",$_POST["name"]));
		if(isset($_POST["latitude"]))
			$zone->setLat($_POST["latitude"]);
		if(isset($_POST["longitude"]))
			$zone->setLng($_POST["longitude"]);
		if(isset($_POST["address"]))
			$zone->setAddress(str_replace("\\'","'",$_POST["address"]));
		if(isset($_POST["contactNo"]))
			$zone->setContactNo($_POST["contactNo"]);
		if(isset($_POST["contactNo2"]))
			$zone->setContactNo2($_POST["contactNo2"]);
		if(isset($_POST["contactNo3"]))
			$zone->setContactNo3($_POST["contactNo3"]);
		if(isset($_POST["area"]))
			$zone->setArea(str_replace("\\'","'",$_POST["area"]));
		if(isset($_POST["stateDivision"]))
			$zone->setStateDvision(str_replace("\\'","'",$_POST["stateDivision"]));
		if(isset($_POST["midcZone"]))
			$zone->setMidcZone(str_replace("\\'","'",$_POST["midcZone"]));
		if(isset($_POST["estYear"]))
			$zone->setEstablishmentYear($_POST["estYear"]);
		if(isset($_POST["industrialCountry"]))
			$zone->setIndustryCount(str_replace("\\'","'",$_POST["industrialCountry"]));
		if($_POST["mode"] == "new"){
			try{
				ConnectionUtil::beginTransaction();
				ConnectionUtil::save($zone);
				ConnectionUtil::commit();
				 $msg = "successfully saved!";
				 $id = $zone->getId();
			}
			catch(Exception $e){
				ConnectionUtil::rollback();
				$msg = $e->getMessage();
			} 
		}
		else if( $_POST["mode"] == "edit"){
			try{
				$zone->setId($_POST["id"]);
				ConnectionUtil::beginTransaction();
				ConnectionUtil::update($zone);
				ConnectionUtil::commit();
				$msg = "successfully updated!";
				$id = $_POST["id"];
			}
			catch(Exception $e){
				ConnectionUtil::rollback();
				$msg = $e->getMessage();
			} 
		}
		else if($_POST["mode"]=="delete"){
			try{
								
				ConnectionUtil::beginTransaction();
				$zone=ConnectionUtil::find("IndustrialZone",$_POST["id"]);
				
				ConnectionUtil::delete($zone);
				ConnectionUtil::commit();
				$msg = "successfully deleted!";
				$id = $_POST["id"];
			}
			catch(Exception $e){
				ConnectionUtil::rollback();
				$msg = $e->getMessage();
			} 	
		}
	}
	
	
	if($_POST["mode"] == 'retrieve'){
//		$users=ConnectionUtil::findAllWithLimit('IndustrialZone',array(),20,1);
		$zones=ConnectionUtil::findAll('IndustrialZone');
		echo "[\n";
		$i=0;		
		foreach($zones as $zone){
			if($i > 0)
				echo ",";
			echo $zone->toJSON();
			$i++;
		}
		echo "]\n";
	}
	else{
		echo "{";
		echo				"\"msg\": \"" . $msg . "\",\n";
		echo				"\"id\": \"" . $id . "\"\n";
		echo "}";
	}
?>