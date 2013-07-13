<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1); 
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	error_reporting(0);
	require_once 'include/connection_util.php';
	$cri_str = ' WHERE 1=1';
	$email = '';
	if(isset($_POST['tagid']) && $_POST['tagid'] > 0)
		$cri_str .= ' AND dt.tagid = ' . $_POST['tagid'];
	if(isset($_POST['email']))
		$email = clean($_POST['email']);
	$success = false;
	$guest_str = '';
	//$user_str = '';
	try{
		$em = ConnectionUtil::getEntityManager();
		if($email == '')
		{
			/*$query =$em->createQuery("SELECT ud FROM UserDirectory ud LEFT JOIN ud.directorytag dt LEFT JOIN dt.tags tt WHERE dt.tagid = '" . $_POST["tagid"] . "'");
			$query =$em->createQuery("SELECT ud FROM UserDirectory ud LEFT JOIN ud.directorytag dt " . $cri_str . " AND ud.public = 1");
			$query =$em->createQuery("SELECT userdirectory FROM UserDirectory userdirectory WHERE userdirectory.public = 1"); */		
			
			$query =$em->createQuery("SELECT ud FROM UserDirectory ud LEFT JOIN ud.directorytag dt LEFT JOIN dt.tags tt " . $cri_str . " AND ud.public = 1");
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
					
					$guest_str .= "<td width='100px' height='50px'><div style='text-align:center;width:100px;height:50px;border:1px solid black;background:" . $result_arr->colorcode .";'>" .
									$result_arr->name . "<br />" . $result_arr->description . 
									"</div></td>";
				}
			}
		}
		//if(isset($_POST['email']) && $_POST['email'] != '')
		else
		{
			$query =$em->createQuery("SELECT ud FROM UserDirectory ud LEFT JOIN ud.directorytag dt LEFT JOIN dt.tags tt " . $cri_str . " AND ud.public = 1 AND ud.smeuseremail = :alphabet");
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
					
					$guest_str .= "<td width='100px' height='50px' onclick='display_detail($result_arr->directoryid)'><div style='text-align:center;width:100px;height:50px;border:1px solid black;background:" . $result_arr->colorcode .";'>" .
									$result_arr->name . "<br />" . $result_arr->description . 
									"</div></td>";
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
	
	function clean($str) 
	{
		$str = @trim ( $str );
		if (get_magic_quotes_gpc ()) {
			$str = stripslashes ( $str );
		}
		return mysql_real_escape_string ( $str );
	}
?>