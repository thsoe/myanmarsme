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
		$smecompany->setWeblink($_POST["txturl"]);
		$smecompany->setBusinessAddress($_POST["businessAddress"]);
		$smecompany->setContactNo1($_POST["contactNo1"]);
		
		if(isset($_POST['hidid']))	// update company
		{
			// ----------------- select for duplicate company ------------------- //
			$em = ConnectionUtil::getEntityManager();
			$cri_str = " WHERE 1=1 AND cp.name = '" . $_POST['name'] . "' AND cp.weblink = '" . $_POST['txturl'] . "' AND cp.id <> '" . $_POST['hidid'] . "'";
			$query =$em->createQuery("SELECT cp FROM SMECompany cp " . $cri_str);
			$result = $query->getResult();
			$company_id = '';
			if(count($result) > 0)
			{
				for ($i=0; $i<count($result); $i++)
				{
					$result_arr = $result[$i]->toJSON();
					$result_arr = json_decode($result_arr);					
					$company_id = $result_arr->id;
				}
			}
			
			// ---------- check this company is used in other directory -------//
			$cri_str = ' WHERE dc.companyid = ' . $_POST['hidid'];
			$query =$em->createQuery("SELECT dc FROM DirectoryCompany dc " . $cri_str);
			$result = $query->getResult();
			$other_count = count($result);
			
			if($company_id == '')
			{
				if($other_count == 1)
				{
					// -------------- update this company ---------- //
					$logger->LogInfo($smecompany->toJSON());
					$smecompany->setId($_POST['hidid']);
					ConnectionUtil::beginTransaction();
					ConnectionUtil::update($smecompany);
					ConnectionUtil::commit();
					$company_id = $_POST['hidid'];
				}
				else
				{
					//------- save this company as new company -------//
					$logger->LogInfo($smecompany->toJSON());
					ConnectionUtil::beginTransaction();
					ConnectionUtil::save($smecompany);
					ConnectionUtil::commit();
					
					//$em = ConnectionUtil::getEntityManager();
					$query =$em->createQuery("SELECT tt FROM SMECompany tt ORDER BY tt.id ASC");
					$result = $query->getResult();
					if(count($result) > 0)
					{
						for ($i=0; $i<count($result); $i++)
						{
							$result_arr = $result[$i]->toJSON();
							$result_arr = json_decode($result_arr);					
							$company_id = $result_arr->id;
						}
					}
				}
			}
			else
			{
				// -------------- delete this company and no need to do company info table---------- //
				ConnectionUtil::beginTransaction();
				$company=ConnectionUtil::find("SMECompany",$_POST["hidid"]);
				//$logger->LogInfo($company);
				ConnectionUtil::delete($company);
				ConnectionUtil::commit();
			}
			
			//--------------------- update rate ---------//
			$em = ConnectionUtil::getEntityManager();
			$userdirectory = $em->find('UserDirectory1',$_POST["directoryid"]);
			$userdirectory->setrating($_POST["hidrate"]);
			$userdirectory->setdirectoryid($_POST["directoryid"]);
			$em->persist($userdirectory);
			$em->flush();
			
			// -------------- delete this DirectoryCompany ---------- //
			ConnectionUtil::beginTransaction();
			$query =$em->createQuery("SELECT dc FROM DirectoryCompany dc WHERE  dc.companyid = " . $_POST['hidid'] . ' AND dc.directoryid = ' . $_POST['directoryid']);
			$result = $query->getResult();
			foreach($result as $dircom)
			{
				$result_arr = $dircom->toJSON();
				$result_arr = json_decode($result_arr);					
				$directory_company_id = $result_arr->directoryCompnayid;
				ConnectionUtil::delete($dircom);
				ConnectionUtil::commit();
			}
			ConnectionUtil::beginTransaction();
			$query1 =$em->createQuery("SELECT dcr FROM DirectoryCompanyRecomendation dcr WHERE  dcr.directorycompanyid = " . $directory_company_id);
			$result1 = $query1->getResult();
			foreach($result1 as $dircomrec)
			{
				$result_arr = $dircomrec->toJSON();
				$result_arr = json_decode($result_arr);					
				$directory_company_id = $result_arr->directorycompanyid;
				ConnectionUtil::delete($dircomrec);
				ConnectionUtil::commit();
			}
			
			// -------------- save new this DirectoryCompany ---------- //
			$logger=new KLogger ( "../logs/log.txt" , KLogger::DEBUG );
			$logger->LogDebug("company id:".$company_id);
			$directorycompany = new DirectoryCompany();
			$directorycompany->setdirectoryid($_POST["directoryid"]);
			$directorycompany->setcompanyid($company_id);
			$directorycompany->setcompnayDescription($_POST['description']);
			$directorycompany->setrank($_POST['hidrate']);
			$logger->LogInfo($directorycompany->toJSON());
			ConnectionUtil::beginTransaction();
			ConnectionUtil::save($directorycompany);
			ConnectionUtil::commit();
			
			// -------------- save new this company directory recommendation ---------- //
			$directorycompany_id = 1;
			$em = ConnectionUtil::getEntityManager();
			$query =$em->createQuery("SELECT tt FROM DirectoryCompany tt ORDER BY tt.directoryCompnayid ASC");
			$result = $query->getResult();
			if(count($result) > 0)
			{
				for ($i=0; $i<count($result); $i++)
				{
					$result_arr = $result[$i]->toJSON();
					$result_arr = json_decode($result_arr);					
					$directorycompany_id = $result_arr->directoryCompnayid;
				}
			}
			$logger=new KLogger ( "../logs/log.txt" , KLogger::DEBUG );
			$logger->LogDebug("directorycompany_id:".$directorycompany_id);
			$directorycompany = new DirectoryCompanyRecomendation();
			$directorycompany->setdirectorycompanyid($directorycompany_id);
			$directorycompany->setrecommendation($_POST['txtrecommend']);
			$directorycompany->setlinkoption('1');
			$logger->LogInfo($directorycompany->toJSON());
			ConnectionUtil::beginTransaction();
			ConnectionUtil::save($directorycompany);
			ConnectionUtil::commit();
			
			// -------------- delete this company tag ---------- //
			ConnectionUtil::beginTransaction();
			$query =$em->createQuery("SELECT ct FROM CompanyTag1 ct WHERE ct.companyid = " . $_POST["hidid"]);
			$result = $query->getResult();
			foreach($result as $dtag)
			{
				ConnectionUtil::delete($dtag);
				ConnectionUtil::commit();
			}
			
			//----------- check the enter tag is exist or not ---------//
			$tagid_arr = array();
			$tags_arr = explode(',', $_POST["txttag"]);
			for ($i=0; $i<count($tags_arr); $i++)
			{
				$em = ConnectionUtil::getEntityManager();
				$query =$em->createQuery("SELECT tt FROM Tags tt WHERE tt.tagname = :alphabet");
				$query->setParameter('alphabet', $tags_arr[$i]);
				$result = $query->getResult();
				//----------- insert in tag if the enter tag is not exist---------//
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
					for ($j=0; $j<count($result); $j++)
					{
						$result_arr = $result[$j]->toJSON();
						$result_arr = json_decode($result_arr);					
						$tagid_arr[] = $result_arr->tagid;
					}
				}
			}
			
			//----------- insert company tag ---------//
			foreach($tagid_arr as $tagid)
			{
				$logger=new KLogger ( "../logs/log.txt" , KLogger::DEBUG );
				$logger->LogDebug("Tag id:".$tagid);
				$companytag = new CompanyTag1();
				$companytag->setcompanyid($company_id);
				$companytag->settagid($tagid);
				$logger->LogInfo($companytag->toJSON());
				
				ConnectionUtil::beginTransaction();
				ConnectionUtil::save($companytag);
				ConnectionUtil::commit();
			}
		}
		else	// add new company
		{
			// select for duplicate company
			$em = ConnectionUtil::getEntityManager();
			$cri_str = " WHERE 1=1 AND cp.name = '" . $_POST['name'] . "' AND cp.weblink = '" . $_POST['txturl'] . "'";
			$query =$em->createQuery("SELECT cp FROM SMECompany cp " . $cri_str);
			$result = $query->getResult();
			$company_id = '';
			if(count($result) > 0)
			{
				for ($i=0; $i<count($result); $i++)
				{
					$result_arr = $result[$i]->toJSON();
					$result_arr = json_decode($result_arr);					
					$company_id = $result_arr->id;
				}
			}
			if($company_id == '')
			{
				$logger->LogInfo($smecompany->toJSON());
				ConnectionUtil::beginTransaction();
				ConnectionUtil::save($smecompany);
				ConnectionUtil::commit();
				$em = ConnectionUtil::getEntityManager();
				$query =$em->createQuery("SELECT tt FROM SMECompany tt ORDER BY tt.id ASC");
				echo $query;exit();
				$result = $query->getResult();
				if(count($result) > 0)
				{
					for ($i=0; $i<count($result); $i++)
					{
						$result_arr = $result[$i]->toJSON();
						$result_arr = json_decode($result_arr);					
						$company_id = $result_arr->id;
					}
				}
			}
			$em = ConnectionUtil::getEntityManager();
			$userdirectory = $em->find('UserDirectory1',$_POST["directoryid"]);
			$userdirectory->setrating($_POST["hidrate"]);
			$userdirectory->setdirectoryid($_POST["directoryid"]);
			$em->persist($userdirectory);
			$em->flush();

			//--------- update rating for user directory ------//
			$logger=new KLogger ( "../logs/log.txt" , KLogger::DEBUG );
			$logger->LogDebug("company id:".$company_id);
			$directorycompany = new DirectoryCompany();
			$directorycompany->setdirectoryid($_POST["directoryid"]);
			$directorycompany->setcompanyid($company_id);
			$directorycompany->setcompnayDescription($_POST['description']);
			$directorycompany->setrank($_POST['hidrate']);
			$logger->LogInfo($directorycompany->toJSON());
			ConnectionUtil::beginTransaction();
			ConnectionUtil::save($directorycompany);
			ConnectionUtil::commit();
			
			// -------------------- recommendation ---------------------//			
			$directorycompany_id = 1;
			$em = ConnectionUtil::getEntityManager();
			$query =$em->createQuery("SELECT tt FROM DirectoryCompany tt ORDER BY tt.directoryCompnayid ASC");
			$result = $query->getResult();
			if(count($result) > 0)
			{
				for ($i=0; $i<count($result); $i++)
				{
					$result_arr = $result[$i]->toJSON();
					$result_arr = json_decode($result_arr);					
					$directorycompany_id = $result_arr->directoryCompnayid;
				}
			}
			
			$logger=new KLogger ( "../logs/log.txt" , KLogger::DEBUG );
			$logger->LogDebug("directorycompany_id:".$directorycompany_id);
			$directorycompany = new DirectoryCompanyRecomendation();
			$directorycompany->setdirectorycompanyid($directorycompany_id);
			$directorycompany->setrecommendation($_POST['txtrecommend']);
			$directorycompany->setlinkoption('1');
			$logger->LogInfo($directorycompany->toJSON());
			ConnectionUtil::beginTransaction();
			ConnectionUtil::save($directorycompany);
			ConnectionUtil::commit();
			
			//----------- check the enter tag is exist or not ---------//
			$tagid_arr = array();
			$tags_arr = explode(',', $_POST["txttag"]);
			for ($i=0; $i<count($tags_arr); $i++)
			{
				$em = ConnectionUtil::getEntityManager();
				$query =$em->createQuery("SELECT tt FROM Tags tt WHERE tt.tagname = :alphabet");
				$query->setParameter('alphabet', $tags_arr[$i]);
				$result = $query->getResult();
				
				//----------- insert in tag if the enter tag is not exist---------//
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
					for ($j=0; $j<count($result); $j++)
					{
						$result_arr = $result[$j]->toJSON();
						$result_arr = json_decode($result_arr);					
						$tagid_arr[] = $result_arr->tagid;
					}
				}
			}
			//----------- insert company tag ---------//
			foreach($tagid_arr as $tagid)
			{
				$logger=new KLogger ( "../logs/log.txt" , KLogger::DEBUG );
				$logger->LogDebug("Tag id:".$tagid);
				$companytag = new CompanyTag1();
				$companytag->setcompanyid($company_id);
				$companytag->settagid($tagid);
				$logger->LogInfo($companytag->toJSON());
				ConnectionUtil::beginTransaction();
				ConnectionUtil::save($companytag);
				ConnectionUtil::commit();
			}
		}
		$msg = "Save successfully";
		$success = 1;
	} catch (Exception $e) {
		ConnectionUtil::rollback();
		$msg = $e->getMessage();
		$log->LogInfo($e->getMessage());
		$success = 0;
	}
	header("location:/php/user_directorylist.php?id=" . $_POST["directoryid"]);
?>