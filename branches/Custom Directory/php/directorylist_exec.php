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
	if(isset($_POST['directorylist']))		// display directory list
	{
		$directory_id = $_POST['directorylist'];
		$email = $_POST['email'];
		$type = $_POST['type'];
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
										<div style='text-align:center;cursor:pointer;width:100px;height:50px;border:1px solid black;background:#FFFFFF;'>" .
										 $company->getName() . 
										"</div>
									</td>";
				}
			}
			$guest_str .= '</tr></table>
								</td>
								<td id="divdirectorylistdetail" width="50%" valign="top">
									&nbsp;
								</td>
							</tr>
						</table>
						<a href="../#dashboard" class="button" style="float:left;margin-right:10px;">Back</a>';
			$success = true;
		}
		catch (Exception $e){
			echo '<br>'.$e->getMessage();
			$log->LogError($e->getMessage());
		}
		$arr = array('success'=>$success, 'guest_str'=> $guest_str);
		echo json_encode($arr);
	}

	if(isset($_POST['companyid']) && isset($_POST['directoryid']) && isset($_POST['usertype']))		// display company detail
	{
		$is_private = 1;
		if(isset($_POST['is_private']))
			$is_private = $_POST['is_private'];
		if(isset($_POST['usertype']))
			$type = $_POST['usertype'];
		try{
			$em = ConnectionUtil::getEntityManager();
			// ------------------ select rate from user directory --------- //
			$query1 =$em->createQuery("SELECT ud FROM UserDirectory1 ud WHERE ud.directoryid = " . $_POST['directoryid']);
			$result1 = $query1->getResult();
			//print_r
			if(count($result1) > 0)
			{
				for ($i=0; $i<count($result1); $i++)
				{
					$result_arr1 = $result1[$i]->toJSON();
					$result_arr1 = json_decode($result_arr1);
					$rating = $result_arr1->rating;
				}
			}
			$query2 =$em->createQuery("SELECT dc FROM DirectoryCompany dc WHERE dc.directoryid = " . $_POST['directoryid'] . " AND dc.companyid = " . $_POST['companyid']);
			$result2 = $query2->getResult();
			//print_r($result2);
			if(count($result2) > 0)
			{
				for ($i=0; $i<count($result2); $i++)
				{
					$result_arr2 = $result2[$i]->toJSON();
					$result_arr2 = json_decode($result_arr2);
					$directoryCompnayid = $result_arr2->directoryCompnayid;
					$compnayDescription = $result_arr2->compnayDescription;
				}
			}
			//echo $rating;exit();
			// ------------------ select company information --------- //	
			$em = ConnectionUtil::getEntityManager();			
			$cri_str .= ' AND cp.id = ' . $_POST['companyid'];
			$query =$em->createQuery("SELECT cp FROM SMECompany cp " . $cri_str);
			$result = $query->getResult();
			$guest_str = '';
			if(count($result) > 0)
			{
				for ($i=0; $i<count($result); $i++)
				{
					$result_arr = $result[$i]->toJSON();
					$result_arr = json_decode($result_arr);
					//----------- continue to write for detail --------------//
					$guest_str .= "<div style='border:1px solid blue; margin:20px;'>";
					$guest_str .= "<img src='/images/delete.png' style='margin:10px;cursor:pointer;' align='right' onclick=\"display_list(" . $_POST['directoryid'] . ", " . $_POST['companyid'] . ", 2, " . $is_private . ", '" . $type . "');\">";
					$guest_str .= "<div style='width:100%;height:120px;'><div style='width:50%;float:left;'>
						<iframe src='http://" . $result_arr->weblink . "' height='120px' width='100%' frameborder='1'> </iframe></div>
						<div style='width:40%;float:right;'>" . $result_arr->name . "<br />" ;
						//$result_arr->description;
					
					for($i=1;$i<=5;$i++)
					{
						if($i<=$rating)
							$guest_str .= '<img src="/images/rate.gif" />';
						else
							$guest_str .= '<img src="/images/no_rate.gif" />';
					}
					$guest_str .= "</div></div>";
					$guest_str .= "<br /><div style='margin:20px;'><strong style='font-size:17px;'>About</strong>";
					if($is_private == 2 && $type == 'user')	
						$guest_str .= "<div style='float:right; margin-right:10px;'>
							<input type='button' style='cursor:pointer;' onclick='edit_company(" .$_POST['directoryid'] . ", " . $_POST['companyid'] . ", " . $result_arr->id . ")' name='btnedit' id='btnedit' value='Edit'></div>";
					$guest_str .= "<br />" . 
						$result_arr->name . "<br /><strong style='font-size:14px;'>Description</strong><br />" . 
						$compnayDescription;
					
						$guest_str .= "<br /><strong style='font-size:14px;'>General Information</strong><br />Please contact us at <br />" . 
							$result_arr->businessAddress . " <br />" . $result_arr->contactNo1; //. " <br /> And you can contact at <br />" . 
							//$result_arr->worksiteAddress . " " . $result_arr->contactNo2;
					
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
	
	if(isset($_POST['url_company_name']))
	{
		try{
			$em = ConnectionUtil::getEntityManager();
			$cri_str .= "AND cp.name = '" . $_POST['url_company_name'] . "'";
			$query =$em->createQuery("SELECT cp FROM SMECompany cp " . $cri_str);
			$result = $query->getResult();
			$url_str = '';
			if(count($result) > 0)
			{
				for ($i=0; $i<count($result); $i++)
				{
					$result_arr = $result[$i]->toJSON();
					$result_arr = json_decode($result_arr);					
					$url_str .= $result_arr->weblink;
				}
			}
		}
		catch (Exception $e){
			$log->LogError($e->getMessage());
			$url_str = '<br>'.$e->getMessage();
			$success = 0;
		}
		$arr = array('success'=>$success, 'url_str'=> $url_str);
		echo json_encode($arr);
	}
?>