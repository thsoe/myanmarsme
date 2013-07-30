<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1); 
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	require_once 'include/connection_util.php';
	$msg = "An Error Occur During Creating directory";
	try
	{
		//print_r($_FILES);
		//echo $_FILES["logo"]["tmp_name"];exit();
		if($_FILES['logo']['size']==0)
			$msg = 'Please select logo Image.';
		else if(!in_array($_FILES['logo']['type'], array('image/gif','image/jpeg','image/jpg','image/png')))
			$msg = 'Please select (gif , jpeg , jpg , png ) extension only.';
		if($_FILES['ad']['size']==0)
			$msg = 'Please select ad Image.';
		else if(!in_array($_FILES['ad']['type'], array('image/gif','image/jpeg','image/jpg','image/png')))
			$msg = 'Please select (gif , jpeg , jpg , png ) extension only.';
		$logo_path = "/images/company_upload/" . $_FILES["logo"]["name"];
		$ad_path = "/images/company_upload/" . $_FILES["ad"]["name"];
		//echo $_POST["name"];exit();
		$logger=new KLogger ( "../logs/log.txt" , KLogger::DEBUG );
		$logger->LogDebug("Company Name:".$_POST['name']);		
		$smecompany = new SMECompany();
		$smecompany->setName($_POST["name"]);
		$smecompany->setLogo($logo_path);
		$smecompany->setAd($ad_path);
		$smecompany->setDesciption($_POST["description"]);
		$smecompany->setBusinessAddress($_POST["businessAddress"]);
		$smecompany->setworksiteAddress($_POST["worksiteAddress"]);
		$smecompany->setContactNo1($_POST["contactNo1"]);
		$smecompany->setContactNo2($_POST["contactNo2"]);
		$smecompany->setRank(1);
		$logger->LogInfo($smecompany->toJSON());
		ConnectionUtil::beginTransaction();
		ConnectionUtil::save($smecompany);
		ConnectionUtil::commit();

		ConnectionUtil::beginTransaction();
		$directory=ConnectionUtil::findAll('SMECompany');
		ConnectionUtil::commit();
		$id = '';
		$rank = 1;
		foreach($directory as $val)
		{
			$id = $val->getId();
		}		
		$logger=new KLogger ( "../logs/log.txt" , KLogger::DEBUG );
		$logger->LogDebug("company id:".$id);
		$directorycompany = new DirectoryCompany();
		$directorycompany->setdirectoryid($_POST["directoryid"]);
		$directorycompany->setcompanyid($id);
		$directorycompany->setrank($rank);
		$logger->LogInfo($directorycompany->toJSON());
		ConnectionUtil::beginTransaction();
		ConnectionUtil::save($directorycompany);
		ConnectionUtil::commit();
		
		move_uploaded_file($_FILES["logo"]["tmp_name"], '..' . $logo_path);
		move_uploaded_file($_FILES["ad"]["tmp_name"], '..' . $ad_path);
		//$msg="Hello...".$_POST["fullName"].",\nThanks for your registration with our MMSME !\nWe have already sent you a confirmation mail to your mail address.";
		$msg = "Save successfully";
		$success = 1;
	} catch (Exception $e) {
		ConnectionUtil::rollback();
		$msg = $e->getMessage();
		$log->LogInfo($e->getMessage());
		$success = 0;
	}
	header("location:/#dashboard");
	//$arr = array('success'=>$success, 'msg'=> $msg);
	//echo json_encode($arr);
?>