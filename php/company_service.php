<?php 
  header('Cache-Control: no-cache, must-revalidate');
  header('Content-type: application/json'); ?>
<?php require_once 'include/connection_util.php';
	  require_once 'include/file_util.php';
 ?>
<?php
	$msg = "";
	$id = "";
	$logo = "";
	$image1 = "";
	$image2 = "";
	$image3 = "";
	$image4 = "";
	$image5 = "";
	$image6 = "";
	$advertisement = "";
	
	
	if(isset($_POST["mode"]) && $_POST["mode"] != 'retrieve'){
		
		if($_POST["mode"] == 'new' || $_POST["mode"] == 'edit'){
			FileUtil::createDir("../images/".FileUtil::validateFileName($_POST["name"]));
		}
		$company = new SMECompany();	
		if(isset($_POST["name"]))	
			$company->setName(str_replace("\\'","'",$_POST["name"]));
			
		$logger=new KLogger ( "../logs/log.txt" , KLogger::DEBUG );
		$logger->LogDebug("ID:".$_POST['id']);
		if(isset($_POST["logo"])){
			$logger->LogDebug("LOGO:".$_POST["logo"]);
			$logger->LogDebug("POS".strpos($_POST["logo"],".."));
			if(strpos($_POST["logo"],"/") != 0){
				$start = strpos($_POST["logo"], "temp/") + 5;
				$logger->LogDebug("STRART in LOGO :" .$start);
				$name=substr($_POST["logo"], $start);
				$logger->LogDebug("FILE NAME :" .$name);
				$path="../images/".FileUtil::validateFileName($_POST["name"])."/".$name;
				FileUtil::moveFile($_POST["logo"], $path);
				$path="/images/".FileUtil::validateFileName($_POST["name"])."/".$name;
				$company->setLogo($path);
			}
			else{
				$company->setLogo($_POST["logo"]);	
			}
			$logo = $company->getLogo();
		}
		
		
		if(isset($_POST["image1"])){
			if(strpos($_POST["image1"],"/")!=0){
				$start=strpos($_POST["image1"],"temp/")+5;
				$name=substr($_POST["image1"],$start);
				$path="../images/".FileUtil::validateFileName($_POST["name"])."/".$name;
				FileUtil::moveFile($_POST["image1"],$path);
				$path="/images/".FileUtil::validateFileName($_POST["name"])."/".$name;
				$image1=$path;
				$company->setImage1($path);
			}
			else{
				$company->setImage1($_POST["image1"]);	
			}
			$image1 = $company->getImage1();
		}
		if(isset($_POST["image2"])){
			if(strpos($_POST["image2"],"/")!=0){
				$start=strpos($_POST["image2"],"temp/")+5;
				$name=substr($_POST["image2"],$start);
				$path="../images/".FileUtil::validateFileName($_POST["name"])."/".$name;
				FileUtil::moveFile($_POST["image2"],$path);
				$path="/images/".FileUtil::validateFileName($_POST["name"])."/".$name;
				$company->setImage2($path);
			}
			else{
				$company->setImage2($_POST["image2"]);	
			}
			$image2 = $company->getImage2();
		}
		if(isset($_POST["image3"])){
			if(strpos($_POST["image3"],"/")!=0){
				$start=strpos($_POST["image3"],"temp/")+5;
				$name=substr($_POST["image3"],$start);
				$path="../images/".FileUtil::validateFileName($_POST["name"])."/".$name;
				FileUtil::moveFile($_POST["image3"],$path);
				$path="/images/".FileUtil::validateFileName($_POST["name"])."/".$name;
				$company->setImage3($path);
			}
			else{
				$company->setImage3($_POST["image3"]);	
			}
			$image3 = $company->getImage3();
		}
		if(isset($_POST["image4"])){
			if(strpos($_POST["image4"],"/")!=0){
				$start=strpos($_POST["image4"],"temp/")+5;
				$name=substr($_POST["image4"],$start);
				$path="../images/".FileUtil::validateFileName($_POST["name"])."/".$name;
				FileUtil::moveFile($_POST["image4"],$path);
				$path="/images/".FileUtil::validateFileName($_POST["name"])."/".$name;
				$company->setImage4($path);
			}
			else{
				$company->setImage4($_POST["image4"]);	
			}
			$image4 = $company->getImage4();
		}
		if(isset($_POST["image5"])){
			if(strpos($_POST["image5"],"/")!=0){
				$start=strpos($_POST["image5"],"temp/")+5;
				$name=substr($_POST["image5"],$start);
				$path="../images/".FileUtil::validateFileName($_POST["name"])."/".$name;
				FileUtil::moveFile($_POST["image5"],$path);
				$path="/images/".FileUtil::validateFileName($_POST["name"])."/".$name;
				$company->setImage5($path);
			}
			else{
				$company->setImage5($_POST["image5"]);	
			}
			$image5 = $company->getImage5();
		}
		if(isset($_POST["image6"])){
			if(strpos($_POST["image6"],"/")!=0){
				$start=strpos($_POST["image6"],"temp/")+5;
				$name=substr($_POST["image6"],$start);
				$path="../images/".FileUtil::validateFileName($_POST["name"])."/".$name;
				FileUtil::moveFile($_POST["image6"],$path);
				$path="/images/".FileUtil::validateFileName($_POST["name"])."/".$name;
				$company->setImage6($path);
			}
			else{
				$company->setImage6($_POST["image6"]);	
			}
			$image6 = $company->getImage6();
		}
		if(isset($_POST["contactNo1"]))
			$company->setContactNo1($_POST["contactNo1"]);
		if(isset($_POST["contactNo2"]))
			$company->setContactNo2($_POST["contactNo2"]);
		if(isset($_POST["advertisement"])){
			if(strpos($_POST["advertisement"],"/")!=0){
				$start=strpos($_POST["advertisement"],"temp/")+5;
				$name=substr($_POST["advertisement"],$start);
				$path="../images/".FileUtil::validateFileName($_POST["name"])."/".$name;
				FileUtil::moveFile($_POST["advertisement"],$path);
				$path="/images/".FileUtil::validateFileName($_POST["name"])."/".$name;
				$company->setAd($path);
			}
			else{
				$company->setAd($_POST["advertisement"]);	
			}
			$advertisement = $company->getAd();
		}
			
		if(isset($_POST["desc"]))
			$company->setDesciption(str_replace("\\'","'",$_POST["desc"]));
		if(isset($_POST["longDesc"]))
			$company->setLongDesc(str_replace("\\'","'",$_POST["longDesc"]));
		if(isset($_POST["worksiteAdd"]))
			$company->setWorksiteAddress(str_replace("\\'","'",$_POST["worksiteAdd"]));
		if(isset($_POST["businessAdd"]))
			$company->setBusinessAddress(str_replace("\\'","'",$_POST["businessAdd"]));
		if(isset($_POST["rank"]))
			$company->setRank($_POST["rank"]);
			
		if($_POST["mode"]=="new"){
			try{
				$logger->LogInfo($company->toJSON());
				ConnectionUtil::beginTransaction();
				ConnectionUtil::save($company);
				ConnectionUtil::commit();
				$msg="successfully saved!";
				$id=$company->getId();
				FileUtil::deleteFilesInFolder("../images/temp/");
			}
			catch(Exception $e){
				ConnectionUtil::rollback();
				$msg = $e->getMessage();
			} 
		}
		else if( $_POST["mode"]=="edit"){
			try{
				$deleteList=$_POST["deleteList"];
				$logger->LogDebug("deleteList:".$deleteList);
				if(trim($deleteList)!=''){
					$list=explode(",", $deleteList);
					$logger->LogDebug("list:".$list);
					foreach ($list as $f){
						$logger->LogDebug("delete:".$f);
						FileUtil::deleteFile($f);	
					}
				}
				$id=$_POST["id"];	
				$logger->LogDebug("ID : ".$id);
				$company->setId($_POST["id"]);
				$logger->LogDebug($company->toJSON());
				ConnectionUtil::beginTransaction();
				ConnectionUtil::update($company);
				ConnectionUtil::commit();
				$msg = "successfully updated!";
				FileUtil::deleteFilesInFolder("../images/temp/");
			}
			catch(Exception $e){
				ConnectionUtil::rollback();
				$msg = $e->getMessage();
			} 
		}
		else if($_POST["mode"]=="delete"){
			try{
				$id=$_POST["id"];				
				ConnectionUtil::beginTransaction();
				$company=ConnectionUtil::find("SMECompany",$_POST["id"]);
				
				if($company->getLogo() != ''){
					FileUtil::deleteFile("..".$company->getLogo());
				}if($company->getAd() != ''){
					FileUtil::deleteFile("..".$company->getAd());
				}
				if($company->getImage1() != ''){
					FileUtil::deleteFile("..".$company->getImage1());
				}if($company->getImage2() != ''){
					FileUtil::deleteFile("..".$company->getImage2());
				}if($company->getImage3() != ''){
					FileUtil::deleteFile("..".$company->getImage3());
				}if($company->getImage4() != ''){
					FileUtil::deleteFile("..".$company->getImage4());
				}if($company->getImage5() != ''){
					FileUtil::deleteFile("..".$company->getImage5());
				}if($company->getImage6() != ''){
					FileUtil::deleteFile("..".$company->getImage6());
				}
				
				FileUtil::deleteFolder("../images/".FileUtil::validateFileName($company->getName()));
				
				ConnectionUtil::delete($company);
				ConnectionUtil::commit();
				$msg = "successfully deleted!";
			}
			catch(Exception $e){
				ConnectionUtil::rollback();
				$msg = $e->getMessage();
			} 	
		}
	}
	
	
	
	if($_POST["mode"] == 'retrieve'){
//		$companies=ConnectionUtil::findAllWithLimit('SMECompany',array(),20,1);
		FileUtil::deleteFilesInFolder("../images/temp/");
		$companies=ConnectionUtil::findAll('SMECompany');
		$i = 0;
		$jsText = "[";
		foreach($companies as $company){
			if($i > 0)
				$jsText .= ",";
			$jsText .= $company->toJSON();
			$i++;
		}
		$jsText .= "]";
		echo str_replace("\\\\\\","",$jsText);
//		echo $jsText;
	}
	else{
		echo "{";
		echo				"\"msg\": \"" . $msg . "\",\n";
		echo				"\"logo\": \"" . $logo . "\",\n";
		echo				"\"image1\": \"" . $image1 . "\",\n";
		echo				"\"image2\": \"" . $image2 . "\",\n";
		echo				"\"image3\": \"" . $image3 . "\",\n";
		echo				"\"image4\": \"" . $image4 . "\",\n";
		echo				"\"image5\": \"" . $image5 . "\",\n";
		echo				"\"image6\": \"" . $image6 . "\",\n";
		echo				"\"advertisement\": \"" . $advertisement . "\",\n";
		echo				"\"id\": \"" . $id . "\"\n";
	echo "}";
	}
?>