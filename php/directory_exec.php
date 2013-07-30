<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1); 
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	require_once 'include/connection_util.php';
	$msg = "An Error Occur During Creating directory";
	try
	{
		$tagid_arr = array();
		$tags_arr = explode(',', $_POST["tags"]);
		//print_r($tags_arr);//exit();
		for ($i=0; $i<count($tags_arr); $i++)
		{
			//echo $tags_arr[$i];
			$em = ConnectionUtil::getEntityManager();
			$query =$em->createQuery("SELECT tt FROM Tags tt WHERE tt.tagname = :alphabet");
			$query->setParameter('alphabet', $tags_arr[$i]);
			$result = $query->getResult();
			if(count($result) == 0)
			{
				$tagname = $tags_arr[$i];
				$tags = new Tags();
				$tags->setTagname($tagname);
				$logger=new KLogger ( "../logs/log.txt" , KLogger::DEBUG );
				$logger->LogDebug("Tag Name:".$tagname);
				$logger->LogInfo($tags->toJSON());
				ConnectionUtil::beginTransaction();
				ConnectionUtil::save($tags);
				ConnectionUtil::commit();
				
				ConnectionUtil::beginTransaction();
				$tagss=ConnectionUtil::findAll('Tags');
				ConnectionUtil::commit();
				$ttag = '';
				foreach($tagss as $val)
				{
					$ttag = $val->getTagid();
				}
				$tagid_arr[] = $ttag;
			}
			else
			{
				$result_arr = $result[$i]->toJSON();
				$result_arr = json_decode($result_arr);					
				$tagid_arr[] = $result_arr->tagid;
			}
		}
		
		$logger=new KLogger ( "../logs/log.txt" , KLogger::DEBUG );
		$logger->LogDebug("Directory Name:".$_POST['name']);		
		$userdirectory = new UserDirectory1();
		$userdirectory->setname($_POST["name"]);
		$userdirectory->setcolorcode($_POST["colorcode"]);
		$userdirectory->setdescription($_POST["description"]);
		$userdirectory->setsmeuseremail($_POST["smeuseremail"]);
		$userdirectory->setpublic($_POST["is_public"]);
		$userdirectory->setrating($_POST["rating"]);
		$logger->LogInfo($userdirectory->toJSON());
		ConnectionUtil::beginTransaction();
		ConnectionUtil::save($userdirectory);
		ConnectionUtil::commit();

		ConnectionUtil::beginTransaction();
		$directory=ConnectionUtil::findAll('UserDirectory1');
		ConnectionUtil::commit();
		$directory_id = '';
		foreach($directory as $val)
		{
			$directory_id = $val->getdirectoryid();
		}
		
		foreach($tagid_arr as $tagid)
		{
			$logger=new KLogger ( "../logs/log.txt" , KLogger::DEBUG );
			$logger->LogDebug("Tag id:".$tagid);
			$directorytag = new DirectoryTag1();
			$directorytag->setdirectoryid($directory_id);
			$directorytag->settagid($tagid);
			$logger->LogInfo($directorytag->toJSON());
			ConnectionUtil::beginTransaction();
			ConnectionUtil::save($directorytag);
			ConnectionUtil::commit();
		}
		//$msg="Hello...".$_POST["fullName"].",\nThanks for your registration with our MMSME !\nWe have already sent you a confirmation mail to your mail address.";
		$msg = "Save successfully";
		$success = 1;
	} catch (Exception $e) {
		ConnectionUtil::rollback();
		$msg = $e->getMessage();
		$log->LogInfo($e->getMessage());
		$success = 0;
		$directory_id = '';
	}
	$arr = array('success'=>$success, 'msg'=> $msg, 'directoryid'=> $directory_id);
	echo json_encode($arr);
?>