<script type="text/javascript" src="/js/urlcheck.js"></script>
<script type="text/javascript" src="/js/sme/directory.js"></script>
<script>
	$('.colorpicker').css('display', 'none');
</script>
<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1); 
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	error_reporting(0);
	require_once 'include/connection_util.php';
	$companyid = '';
	if(isset($_COOKIE['edit_directory']))
		$directoryid = $_COOKIE['edit_directory'];
	if(isset($_COOKIE['edit_company']))
		$companyid = $_COOKIE['edit_company'];
	// echo $directoryid;exit();
	try{
		$em = ConnectionUtil::getEntityManager();
		$cri_str = ' WHERE com.id = ' . $companyid;
		$query =$em->createQuery("SELECT com FROM SMECompany com " . $cri_str);
		$result = $query->getResult();
		if(count($result) > 0)
		{
			for ($i=0; $i<count($result); $i++)
			{
				$result_arr = $result[$i]->toJSON();
				$result_arr = json_decode($result_arr);
				$name = $result_arr->name;
				$logo = $result_arr->logo;
				$description = $result_arr->description;
				$businessAddress = $result_arr->businessAddress;
				$worksiteAddress = $result_arr->worksiteAddress;
				$contactNo1 = $result_arr->contactNo1;
				$contactNo2 = $result_arr->contactNo2;
				$ad = $result_arr->ad;
				$rank = $result_arr->rank;
			}
		}
	}
	catch (Exception $e){
		$log->LogError($e->getMessage());
		echo $e->getMessage();
	}
?>
		<div class="title_bar"><span>Company Detail</span></div>
		<div class="content_top"><div class="cor_lf_t"></div><div class="cor_rt_t"></div></div><!--do not touch this, this is for image-->
		<div class="container">
			<form id="frmeditcompany" name="frmeditcompany" method="post" enctype="multipart/form-data">
			<table width="100%" border="0" cellpadding="5" cellspacing="0">
			  <tr>
				<td width="33%" align="left" valign="top" style="">Company Name:</td>
				<td width="67%" align="left" valign="top" style="">
					<input type="hidden" name="hidid" id="hidid" value="<?php echo $companyid; ?>" style="width:400px;" />
					<input type="text" name="name" id="name" value="<?php echo $name; ?>" style="width:400px;" />
				</td>
			  </tr>
			  <tr>
				<td align="left" valign="top" style="">Company Logo:</td>
				<td  align="left" valign="top" style="">
					<input type="hidden" id="hidlogo" name="hidlogo" value="<?php echo $logo; ?>" />
					<div id="divlogo" style="display:none;">
						<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
						<input type="file" name="logo" id="logo" style="width:400px;" value="<?php echo $logo; ?>" />
						<input type="button" value="Cancel" name="btncancel" id="btncancel" onclick="display_file('logo', 2);" />
					</div>
					<div id="divchangelogo">
						<img src="<?php echo $logo; ?>" width="110px" height="110px" />
						<input type="button" value="Change" name="btnchange" id="btnchange" onclick="display_file('logo', 1);">
					</div>
				</td>
			  </tr>
			  <tr>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">Company Description:</td>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">
					<textarea name="description" id="description" ROWS="4" style="width:400px;"><?php echo $description; ?></textarea>
				</td>
			  </tr>
			  <tr>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">Business Address:</td>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">
					<textarea name="businessAddress" id="businessAddress" ROWS="4" style="width:400px;"><?php echo $businessAddress; ?></textarea>
				</td>
			  </tr>
			  <tr>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">Worksite Address:</td>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">
					<textarea name="worksiteAddress" id="worksiteAddress" ROWS="4" style="width:400px;"><?php echo $worksiteAddress; ?></textarea>
				</td>
			  </tr>
			  <tr>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">Contact Number 1:</td>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">
					<input type="text" name="contactNo1" id="contactNo1" value="<?php echo $contactNo1; ?>" style="width:400px;" />
				</td>
			  </tr>
			   <tr>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">Contact Number 2:</td>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">
					<input type="text" name="contactNo2" id="contactNo2" value="<?php echo $contactNo2; ?>" style="width:400px;" />
				</td>
			  </tr>
			  <tr>
				<td align="left" valign="top" style="">Advertising Image:</td>
				<td  align="left" valign="top" style="">
					<input type="hidden" id="hidad" name="hidad" value="<?php echo $ad; ?>" />
					<div id="divad" style="display:none;">
						<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
						<input type="file" name="ad" id="ad" style="width:400px;" value="<?php echo $ad; ?>" />
						<input type="button" value="Cancel" name="btncancel" id="btncancel" onclick="display_file('ad', 2);" />
					</div>
					<div id="divchangead">
						<img src="<?php echo $ad; ?>" width="110px" height="110px" />
						<input type="button" value="Change" name="btnchange" id="btnchange" onclick="display_file('ad', 1);" >
					</div>
				</td>
			  </tr>
			  <tr>
				<td align="left" valign="top" style="">&nbsp;</td>
				<td align="left" valign="top" style="">
					<span style="padding:1px 30px 0 0;float:left;">
						<!--input class="button" type="reset" value="CLEAR" /-->
						<input class="button" type="submit" value="Update" onclick="update_company();"/>
					</span>
					<input type="hidden" name="directoryid" id="directoryid" value="<?php echo $directoryid; ?>" />
					<!--a href="javascript:upload_company();" class="button">Upload</a-->
					<input class="button" type="button" value="Cancel" onclick="javascript:goto(navigation.user_directorylist);" />
				</td>
			  </tr>
			</table>
			</form>
		</div><!--container-->

		<div class="content_btm"><div class="cor_lf_b"></div><div class="cor_rt_b"></div></div><!--do not touch this, this is for image-->

	</div><!--md_content-->

</div><!--content-->