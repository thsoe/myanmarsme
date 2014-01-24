<script type="text/javascript" src="/js/urlcheck.js"></script>
<script type="text/javascript" src="/js/sme/directory_list.js"></script>
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
				$businessAddress = $result_arr->businessAddress;				
				$weblink = $result_arr->weblink;
				$contactNo1 = $result_arr->contactNo1;
			}
			
		}
		$rating = 1;
		$em = ConnectionUtil::getEntityManager();
		$cri_str = ' WHERE ud.directoryid = ' . $directoryid;
		$query =$em->createQuery("SELECT ud FROM UserDirectory1 ud " . $cri_str);
		$result = $query->getResult();
		if(count($result) > 0)
		{
			for ($i=0; $i<count($result); $i++)
			{
				$result_arr = $result[$i]->toJSON();
				$result_arr = json_decode($result_arr);
				$rating = $result_arr->rating;
			}
		}
		
		$em = ConnectionUtil::getEntityManager();
		$cri_str = ' WHERE dc.directoryid = ' . $directoryid . ' AND dc.companyid = ' . $companyid;
		$query =$em->createQuery("SELECT dc FROM DirectoryCompany dc " . $cri_str);
		$result = $query->getResult();
		if(count($result) > 0)
		{
			for ($i=0; $i<count($result); $i++)
			{
				$result_arr = $result[$i]->toJSON();
				$result_arr = json_decode($result_arr);
				$companydescription = $result_arr->compnayDescription;
				$directoryCompnayid = $result_arr->directoryCompnayid;
			}
		}
		
		$em = ConnectionUtil::getEntityManager();
		$cri_str = ' WHERE dc.directorycompanyid = ' . $directoryCompnayid;
		$query =$em->createQuery("SELECT dc FROM DirectoryCompanyRecomendation dc " . $cri_str);
		$result = $query->getResult();
		if(count($result) > 0)
		{
			for ($i=0; $i<count($result); $i++)
			{
				$result_arr = $result[$i]->toJSON();
				$result_arr = json_decode($result_arr);
				$recommendation	 = $result_arr->recommendation;
			}
		}
		
		$cri_str1 = ' WHERE dt.companyid = ' . $companyid;
		$query =$em->createQuery("SELECT dt FROM CompanyTag1 dt " . $cri_str1);
		$result = $query->getResult();
		$tagids = '';
		$tagnames = '';
		if(count($result) > 0)
		{
			for ($i=0; $i<count($result); $i++)
			{
				$result_arr = $result[$i]->toJSON();
				$result_arr = json_decode($result_arr);
				$tagid = $result_arr->tagid;
				if($tagids == '')
					$tagids = $tagid;
				else
					$tagids .= ',' . $tagid;
				$tags =$em->getRepository('Tags')->findOneBy((array('tagid' => $tagid)));
				if($tagnames == '')
					$tagnames = $tags->getTagname();
				else
					$tagnames .= ',' . $tags->getTagname();
			}
		}
	}
	catch (Exception $e){
		$log->LogError($e->getMessage());
		echo $e->getMessage();
	}
?>
		<div class="title_bar"><span>Edit Entry</span></div>
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
				<td width="33%" align="left" valign="top" style="">Url (If there is any)::</td>
				<td width="67%" align="left" valign="top" style="">
					<input type="text" name="txturl" id="txturl" value="<?php echo $weblink; ?>" style="width:400px;" />
				</td>
			  </tr>
			  <tr>
				<td width="33%" align="left" valign="top" style="">Rating:</td>
				<td width="67%" align="left" valign="top" style="">
					<?php
						for($i=1;$i<=5;$i++)
						{
							if($i<=$rating)
								echo '<img src="images/rate.gif" id="imgrate' . $i . '" onmouseover="change_image(' . $i . ',1);" onmouseout="change_image(' . $i . ',0);" onclick="select_rate(' . $i . ');" style="cursor:pointer;" />';
							else
								echo '<img src="images/no_rate.gif" id="imgrate' . $i . '" onmouseover="change_image(' . $i . ',1);" onmouseout="change_image(' . $i . ',0);" onclick="select_rate(' . $i . ');" style="cursor:pointer;" />';
						}
					?>
					<input type="hidden" name="hidrate" id="hidrate" value="<?php echo $rating; ?>" style="width:400px;" />
				</td>
			  </tr>
			  <tr>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">Any related product or service you know of? :</td>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">
					<textarea name="description" id="description" ROWS="4" style="width:400px;"><?php echo $companydescription; ?></textarea>
				</td>
			  </tr>
			  <tr>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">Any related product or service you know of? :</td>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">
					<textarea name="txtrecommend" id="txtrecommend" ROWS="4" style="width:400px;"><?php echo $recommendation; ?></textarea>
				</td>
			  </tr>
			  <tr>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">Business Address:</td>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">
					<textarea name="businessAddress" id="businessAddress" ROWS="4" style="width:400px;"><?php echo $businessAddress; ?></textarea>
				</td>
			  </tr>			  
			  <tr>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">Contact Number 1:</td>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">
					<input type="text" name="contactNo1" id="contactNo1" value="<?php echo $contactNo1; ?>" style="width:400px;" />
				</td>
			  </tr>
			  <tr>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">Contact Number 1:</td>
				<td align="left" valign="top" style="border-bottom:1px dotted #dfdfdf;">
					<input type="text" name="txttag" id="txttag" value="<?php echo $tagnames; ?>" style="width:400px;" />
				</td>
			  </tr>		  
			  <tr>
				<td align="left" valign="top" style="">&nbsp;</td>
				<td align="left" valign="top" style="">
					<span style="padding:1px 30px 0 0;float:left;">
						<input class="button" type="submit" value="Update" onclick="update_company();"/>
					</span>
					<input type="hidden" name="directoryid" id="directoryid" value="<?php echo $directoryid; ?>" />
					<input class="button" type="button" value="Cancel" onclick="cancel_com_edit('<?php echo $directoryid; ?>')" />
				</td>
			  </tr>
			</table>
			</form>
		</div><!--container-->

		<div class="content_btm"><div class="cor_lf_b"></div><div class="cor_rt_b"></div></div><!--do not touch this, this is for image-->

	</div><!--md_content-->

</div><!--content-->