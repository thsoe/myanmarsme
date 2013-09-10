<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1); 
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	error_reporting(0);
	require_once 'include/connection_util.php';
	$cri_str = ' WHERE 1=1';
	$email = '';
	//$type = 'guest';
	if(isset($_POST['directorylist']))		// display directory list
	{
		$directory_id = clean($_POST['directorylist']);
		$email = clean($_POST['email']);
		$type = clean($_POST['type']);
		$cri_str .= " AND dc.directoryid  = " . $directory_id;
		$success = false;
		$guest_str = '';
		try{
			$em = ConnectionUtil::getEntityManager();
			$directory = $em->getRepository('UserDirectory')->findOneBy((array('directoryid' => $directory_id)));
			if($type == "user")	// user
			{
				//display user name
				$is_private = 2;
				$user = $em->getRepository('SMEUser')->findOneBy((array('email' => $email)));
				$guest_str = '<h2  style="border-bottom:1px solid #f58220;color:#f58220;padding-bottom:5px;font-size:13px;">
							<strong id="pinfo">Welcome ' . $user->getFullName() . '</strong>
						</h2>
						<table id="divdashboard_result" width="100%">
							<tr>
								<td width="50%" valign="top">
									<div id="divuser">' . 
										$directory->getname() . 
									'</div>
									<br />
									<div id="divuser">' . 
										$directory->getdescription() . 
									'</div>
									<div id="divnewdirectory" >
										<br /><br />
										<a id="get_started" href="javascript:create_company(' . $directory_id . ')" style="float:left">Create New Entry</a>
									</div>
									<br /><br />
									<table id="tbluserdirectorylist" border="0" cellpadding="7" cellspacing="0" align="center">';
			}
			else
			{
				//display user name
				$is_private = 1;
				$guest_str = '<h2  style="border-bottom:1px solid #f58220;color:#f58220;padding-bottom:5px;font-size:13px;">
							<strong id="pinfo">Welcome Guest</strong>
						</h2>
						<table id="divdashboard_result" width="100%">
							<tr>
								<td width="50%" valign="top">
									<div id="divuser">' . 
										$directory->getname() . 
									'</div>
									<br />
									<div id="divuser">' . 
										$directory->getdescription() . 
									'</div>
									<br /><br />
									<table id="tbluserdirectorylist" border="0" cellpadding="7" cellspacing="0" align="center">';
			}
			
			// directory company
			$query =$em->createQuery("SELECT dc FROM DirectoryCompany dc " . $cri_str);
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
					$company = $em->getRepository('SMECompany')->findOneBy((array('id' => $result_arr->companyid)));
					
					$guest_str .= "<td width='100px' height='50px' style='text-decoration:none;' 
									onclick = \"display_list(" . $directory_id . ", " . $company->getId() . ", 1, " . $is_private . ", '" . $type . "');\" 
									>
										<div style='text-align:center;width:100px;height:50px;border:1px solid black;background:#FFFFFF;'>" .
										 $company->getName() . 
										"</div>
									</td>";
									
					/* $guest_str .= "<td width='100px' height='50px' style='text-decoration:none;' 
									onclick = 'display_directory(" . $result_arr->directoryid . ", 1, 2);' 
									onblur='display_directory(" . $result_arr->directoryid . ", 2, 2);'
									>
										<div style='text-align:center;width:100px;height:50px;border:1px solid black;background:" . $result_arr->colorcode .";'>" .
										$result_arr->name . "<br />By " . $user->getFullName() . 
										"</div>
									</td>"; */
				}
			}
			$guest_str .= '</tr></table>
								</td>
								<td id="divdirectorylistdetail" width="50%" valign="top">
									&nbsp;
								</td>
							</tr>
						</table>';
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

	if(isset($_POST['companyid']) && isset($_POST['directoryid']) && isset($_POST['usertype']))		// display company detail
	{
		$is_private = 1;
		if(isset($_POST['is_private']))
			$is_private = clean($_POST['is_private']);
		if(isset($_POST['usertype']))
			$type = clean($_POST['usertype']);
		//echo $type;exit();
		try{
			$em = ConnectionUtil::getEntityManager();
			//echo $_POST['directoryid'];exit();
			$cri_str .= ' AND cp.id = ' . $_POST['companyid'];
			$query =$em->createQuery("SELECT cp FROM SMECompany cp " . $cri_str);
			$result = $query->getResult();
			//print_r($result);exit();
			$guest_str = '';
			if(count($result) > 0)
			{
				for ($i=0; $i<count($result); $i++)
				{
					$result_arr = $result[$i]->toJSON();
					$result_arr = json_decode($result_arr);
					$guest_str .= "<div style='border:1px solid blue; margin:20px;'>";
					$guest_str .= "<img src='/images/delete.png' style='margin:10px;' align='right' onclick=\"display_list(" . $_POST['directoryid'] . ", " . $_POST['companyid'] . ", 2, " . $is_private . ", '" . $type . "');\">";
					/* $directorycompany = $em->getRepository('DirectoryCompany')->findOneBy((array('directoryid' => $result_arr->directoryid)));
					if(! is_null($directorycompany))
					{
						$company = $em->getRepository('SMECompany')->findOneBy((array('id' => $directorycompany->getcompanyid()))); */
					$guest_str .= "<div style='width:100%;height:120px;'><div style='width:40%;float:left;'>
						<img src='" . $result_arr->logo . "' style='margin:20px;width:110px;height:110px;border:0.5px solid #38196a;' /></div>
						<div style='width:60%;float:right;'>" . $result_arr->name . "<br />" . 
						$result_arr->description . "</div></div>";
					//}
					$guest_str .= "<br /><div style='margin:20px;'><strong style='font-size:17px;'>About</strong>";
					if($is_private == 2 && $type == 'user')	
						$guest_str .= "<div style='float:right; margin-right:10px;'>
							<input type='button' onclick='edit_company(" .$_POST['directoryid'] . ", " . $_POST['companyid'] . ", " . $result_arr->id . ")' name='btnedit' id='btnedit' value='Edit'></div>";
					$guest_str .= "<br />" . 
						$result_arr->name . "<br /><strong style='font-size:14px;'>Description</strong><br />" . 
						$result_arr->description;
					
						$guest_str .= "<br /><strong style='font-size:14px;'>General Information</strong><br />Please contact us at <br />" . 
							$result_arr->businessAddress . " " . $result_arr->contactNo1 . " <br /> And you can contact at <br />" . 
							$result_arr->worksiteAddress . " " . $result_arr->contactNo2;
					
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