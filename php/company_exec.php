<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1); 
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	require_once 'include/connection_util.php';
	$msg = "An Error Occur During Creating directory";
	try
	{
		$logger=new KLogger ( "../logs/log.txt" , KLogger::DEBUG );
		$logger->LogDebug("Company Name:".$_POST['name']);		
		$smecompany = new SMECompany();
		$smecompany->setName($_POST["name"]);
		$smecompany->setDesciption($_POST["description"]);
		$smecompany->setBusinessAddress($_POST["businessAddress"]);
		$smecompany->setworksiteAddress($_POST["worksiteAddress"]);
		$smecompany->setContactNo1($_POST["contactNo1"]);
		$smecompany->setContactNo2($_POST["contactNo2"]);
		$smecompany->setRank(1);
		
		if(isset($_POST['hidid']))	// update company
		{
			if($_FILES['logo']['size'] > 0)
				$logo_path = "/images/company_upload/logo_" . $_POST["directoryid"] . $_FILES["logo"]["name"];
			else
				$logo_path = $_POST['hidlogo'];
			if($_FILES['ad']['size'] > 0)
				$ad_path = "/images/company_upload/adv_" . $_POST["directoryid"] . $_FILES["ad"]["name"];
			else
				$ad_path = $_POST['hidad'];
			$logger->LogInfo($smecompany->toJSON());
			$smecompany->setLogo($logo_path);
			$smecompany->setAd($ad_path);
			$smecompany->setId($_POST['hidid']);
			ConnectionUtil::beginTransaction();
			ConnectionUtil::update($smecompany);
			ConnectionUtil::commit();
			
			if($_FILES['logo']['size'] > 0)
			{
				unlink($_POST['hidlogo']);
				move_uploaded_file($_FILES["logo"]["tmp_name"], '..' . $logo_path);
			}
			if($_FILES['ad']['size'] > 0)
			{
				unlink($_POST['hidad']);
				move_uploaded_file($_FILES["ad"]["tmp_name"], '..' . $ad_path);
			}
		}
		else	// add new company
		{
			if($_FILES['logo']['size']==0)
				$msg = 'Please select logo Image.';
			else if(!in_array($_FILES['logo']['type'], array('image/gif','image/jpeg','image/jpg','image/png')))
				$msg = 'Please select (gif , jpeg , jpg , png ) extension only.';
			if($_FILES['ad']['size']==0)
				$msg = 'Please select ad Image.';
			else if(!in_array($_FILES['ad']['type'], array('image/gif','image/jpeg','image/jpg','image/png')))
				$msg = 'Please select (gif , jpeg , jpg , png ) extension only.';
			$logo_path = "/images/company_upload/logo_" . $_POST["directoryid"] . $_FILES["logo"]["name"];
			$ad_path = "/images/company_upload/adv_" . $_POST["directoryid"] . $_FILES["ad"]["name"];
			
			$logger->LogInfo($smecompany->toJSON());
			$smecompany->setLogo($logo_path);
			$smecompany->setAd($ad_path);
			ConnectionUtil::beginTransaction();
			ConnectionUtil::save($smecompany);
			ConnectionUtil::commit();

			/* ConnectionUtil::beginTransaction();
			$directory=ConnectionUtil::findAll('SMECompany');
			ConnectionUtil::commit();
			$id = '';
			$rank = 1;
			foreach($directory as $val)
			{
				$id = $val->getId();
			} */
			
			$id = '';
			$rank = 1;
			$em = ConnectionUtil::getEntityManager();
			$query =$em->createQuery("SELECT tt FROM SMECompany tt ORDER BY tt.id ASC");
			$result = $query->getResult();
			if(count($result) > 0)
			{
				for ($i=0; $i<count($result); $i++)
				{
					$result_arr = $result[$i]->toJSON();
					$result_arr = json_decode($result_arr);					
					$id = $result_arr->id;
				}
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
		}
		
		//$msg="Hello...".$_POST["fullName"].",\nThanks for your registration with our MMSME !\nWe have already sent you a confirmation mail to your mail address.";
		$msg = "Save successfully";
		$success = 1;
	} catch (Exception $e) {
		ConnectionUtil::rollback();
		$msg = $e->getMessage();
		$log->LogInfo($e->getMessage());
		$success = 0;
	}
	header("location:/#user_directorylist");
	//$arr = array('success'=>$success, 'msg'=> $msg);
	//echo json_encode($arr);
?>