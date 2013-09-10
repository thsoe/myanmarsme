<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1); 
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	error_reporting(0);
	require_once 'include/connection_util.php';
	$cri_str = ' WHERE 1=1';
	$email = '';
	$type = 'guest';
	if(isset($_POST['tagid']))		// display directory
	{
		if(isset($_POST['tagid']) && $_POST['tagid'] > 0)
			$cri_str .= ' AND dt.tagid = ' . $_POST['tagid'];
		if(isset($_POST['email']))
			$email = clean($_POST['email']);
		if(isset($_POST['type']))
			$type = clean($_POST['type']);
		$success = false;
		$guest_str = '';
		//$user_str = '';
		try{
			$em = ConnectionUtil::getEntityManager();
			//if($email == '')
			if($type == 'guest')
			{
				/*$query =$em->createQuery("SELECT ud FROM UserDirectory ud LEFT JOIN ud.directorytag dt LEFT JOIN dt.tags tt WHERE dt.tagid = '" . $_POST["tagid"] . "'");
				$query =$em->createQuery("SELECT ud FROM UserDirectory ud LEFT JOIN ud.directorytag dt " . $cri_str . " AND ud.public = 1");
				$query =$em->createQuery("SELECT userdirectory FROM UserDirectory userdirectory WHERE userdirectory.public = 1"); */		
				if($email != '')
					$cri_str .= ' AND ud.smeuseremail != :alphabet';
				$query =$em->createQuery("SELECT ud FROM UserDirectory ud LEFT JOIN ud.directorytag dt LEFT JOIN dt.tags tt " . $cri_str . " AND ud.public = 1");
				if($email != '')
					$query->setParameter('alphabet', $email);
				$result = $query->getResult();
				if(count($result) > 0)
				{
					for ($i=0; $i<count($result); $i++)
					{
						if($i%4 == 0)
						{
							if($i != 0)
								$guest_str .= "</tr>";
							$guest_str .= "<tr>";
						}
						$result_arr = $result[$i]->toJSON();
						$result_arr = json_decode($result_arr);
						
						$user = $em->getRepository('SMEUser')->findOneBy((array('email' => $result_arr->smeuseremail)));
						//echo $user->getFullName();exit();
						$guest_str .= "<td width='100px' height='50px' style='text-decoration:none;' 
										onclick = \"display_list(" . $result_arr->directoryid . ", '" . $type . "');\" 
										>
											<div style='text-align:center;width:100px;height:50px;border:1px solid black;background:" . $result_arr->colorcode .";'>" .
											$result_arr->name . "<br />By " . $user->getFullName() . 
											"</div>
										</td>";
						//echo $guest_str;exit();
						
					}
				}
			}
			//if(isset($_POST['email']) && $_POST['email'] != '')
			else
			{
				$query =$em->createQuery("SELECT ud FROM UserDirectory ud LEFT JOIN ud.directorytag dt LEFT JOIN dt.tags tt " . $cri_str . " AND ud.smeuseremail = :alphabet");
				$query->setParameter('alphabet', $email);
				$result = $query->getResult();
				//print_r($result);
				if(count($result) > 0)
				{
					for ($i=0; $i<count($result); $i++)
					{
						if($i%4 == 0)
						{
							if($i != 0)
								$guest_str .= "</tr>";
							$guest_str .= "<tr>";
						}
						$result_arr = $result[$i]->toJSON();
						$result_arr = json_decode($result_arr);
						$user = $em->getRepository('SMEUser')->findOneBy((array('email' => $result_arr->smeuseremail)));
						$guest_str .= "<td width='100px' height='50px' style='text-decoration:none;' 
										onclick = \"display_list(" . $result_arr->directoryid . ", '" . $type . "');\" 
										>
											<div style='text-align:center;width:100px;height:50px;border:1px solid black;background:" . $result_arr->colorcode .";'>" .
											$result_arr->name . "<br />By " . $user->getFullName() . 
											"</div>
										</td>";
										
						/*$guest_str .= "<td width='100px' height='50px' style='text-decoration:none;' 
										onclick = 'display_directory(" . $result_arr->directoryid . ", 1, 2);' 
										onblur='display_directory(" . $result_arr->directoryid . ", 2, 2);'
										>
											<div style='text-align:center;width:100px;height:50px;border:1px solid black;background:" . $result_arr->colorcode .";'>" .
											$result_arr->name . "<br />By " . $user->getFullName() . 
											"</div>
										</td>";*/
					}
				}
			}
			$success = true;
		}
		catch (Exception $e){
			echo '<br>'.$e->getMessage();
			$log->LogError($e->getMessage());
		}
		//$arr = array('success'=>$success, 'guest_str'=> $guest_str, 'user_str'=> $user_str);
		$arr = array('success'=>$success, 'guest_str'=> $guest_str);
		echo json_encode($arr);
	}

	if(isset($_POST['directoryid']))		// display detail
	{
		$is_private = 1;
		if(isset($_POST['is_private']))
			$is_private = clean($_POST['is_private']);
		try{
			$em = ConnectionUtil::getEntityManager();
			//echo $_POST['directoryid'];
			$cri_str .= ' AND dt.directoryid = ' . $_POST['directoryid'];
			$query =$em->createQuery("SELECT ud FROM UserDirectory ud LEFT JOIN ud.directorytag dt " . $cri_str);
			$result = $query->getResult();
			//print_r($result);
			$guest_str = '';
			if(count($result) > 0)
			{
				for ($i=0; $i<count($result); $i++)
				{
					$result_arr = $result[$i]->toJSON();
					$result_arr = json_decode($result_arr);
					$guest_str .= "<div style='border:1px solid blue; margin:20px;'>";
					$guest_str .= "<img src='/images/delete.png' style='margin:10px;' align='right' onclick='display_directory(" . $_POST['directoryid'] . ", 2, 1);'>";
					$directorycompany = $em->getRepository('DirectoryCompany')->findOneBy((array('directoryid' => $result_arr->directoryid)));
					if(! is_null($directorycompany))
					{
						$company = $em->getRepository('SMECompany')->findOneBy((array('id' => $directorycompany->getcompanyid())));
						$guest_str .= "<div style='width:100%;height:120px;'><div style='width:40%;float:left;'>
							<img src='" . $company->getLogo() . "' style='margin:20px;width:110px;height:110px;border:0.5px solid #38196a;' /></div>
							<div style='width:60%;float:right;'>" . $company->getName() . "<br />" . 
							$company->getDescription() . "</div></div>";
					}
					$guest_str .= "<br /><div style='margin:20px;'><strong style='font-size:17px;'>About</strong>";
					if($is_private == 2)	
						$guest_str .= "<div style='float:right; margin-right:10px;'>
							<input type='button' onclick='edit_directory(" . $_POST['directoryid'] . ", " . $company->getId() . ")' name='btnedit' id='btnedit' value='Edit'></div>";
					$guest_str .= "<br />" . 
						$result_arr->name . "<br /><strong style='font-size:14px;'>Description</strong><br />" . 
						$result_arr->description;
					if(! is_null($company))
					{
						$guest_str .= "<br /><strong style='font-size:14px;'>General Information</strong><br />Please contact us at <br />" . 
							$company->getBusinessAddress() . " " . $company->getContactNo1() . " <br /> And can you contact at <br />" . 
							$company->getWorksiteAddress() . " " . $company->getContactNo2();
					}
					$guest_str .= "</div></div>";
					$success = 1;
				}
			}
		}
		catch (Exception $e){
			$log->LogError($e->getMessage());
			$guest_str = '<br>'.$e->getMessage();
			$success = 0;
		}
		$arr = array('success'=>$success, 'guest_str'=> $guest_str);
		echo json_encode($arr);
	}
	
	function clean($str) 
	{
		$str = @trim ( $str );
		if (get_magic_quotes_gpc ()) {
			$str = stripslashes ( $str );
		}
		return mysql_real_escape_string ( $str );
	}
?>