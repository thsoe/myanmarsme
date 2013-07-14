<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1); 
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	error_reporting(0);
	require_once 'include/connection_util.php';
	
	try{
		//$em = ConnectionUtil::getEntityManager();
		//print_r($em);
		/* $query =$em->executeQuery("SELECT DISTINCT tagname FROM tags");
		$tags_result = $query->getResult();
		for ($i=1; $i<=count($tags_result); $i++)
		{
			print_r($array[$i]);echo '<br>';
		}
		 */
		/* $directory =$em->findAll('Tags');
		ConnectionUtil::commit();
		print_r($directory); */
		//$directory =$em->findByCriteriaWithLimit('User',$_POST["userName"]);
		ConnectionUtil::beginTransaction();
		$companies=ConnectionUtil::findAll('Tags');
		ConnectionUtil::commit();
		$tag_str = '';
		foreach($companies as $company)
		{
			$tag_str.= "<option value='" . $company->getTagid() . "'>" . $company->getTagname()."</option>";	
		}
	}
	catch (Exception $e){
		$log->LogError($e->getMessage());
	}
?>
<script type="text/javascript" src="/js/urlcheck.js"></script>
<!--script type="text/javascript" src="/js/sme/dashboard_data.js"></script-->
<script type="text/javascript">
	jQuery(document).ready(function(){
		get_dashboard('guest');
		if(auth.result != 0 )
		{
			jQuery('#divuser').css('display','block');
			jQuery('#divguesttext').css('display','none');
			jQuery('#divnewdirectory').css('display','inline');
			get_dashboard('user');
		}
		else
			jQuery('#divguesttext').css('display','inline');
	});
	function get_dashboard(type, tag)
	{
		email = '';
		if(auth.result != 0 && type == 'user')
			email = auth.email;		
		req_params = 'email=' + email;
		if(tag == undefined)
			req_params += '&tagid=0';
		else
			req_params += '&tagid=' + tag.value;
		tag_result = loadJSON(navigation.dashboard_exec,req_params);
		if(tag_result.success)
		{
			if(type == 'guest')
				jQuery('#tblguestdashboard').html(tag_result.guest_str);
			else
				jQuery('#tbluserdashboard').html(tag_result.guest_str);
		}
	}
	
	function display_detail(directoryid)
	{
		
	}
</script>
<form id="frmdashboard" name="frmdashboard">
	<h2  style="border-bottom:1px solid #f58220;color:#f58220;padding-bottom:5px;font-size:13px;">
		<strong id="pinfo">Welcome Guest</strong>
	</h2>
	<table id="divdashboard_result">
		<tr>
			<td width="50%">
				<div id="divguesttext" style="display:none;">
					<br /><br />you can create your own directory of SMEs, People, Resources , etc here.<br />
					Please register to use the complete set of features
				</div>
				<br /><br />	
				<div id="divuser" style="display:none;" >
					Your Directories:
					<select id = "selusertag" name = "selusertag" onchange="get_dashboard('user', this)">
						<option value="0">All Tags</option>
						<?php echo $tag_str; ?>
					</select>
				</div>
				<br /><br />
				<table id="tbluserdashboard" border="0" cellpadding="7" cellspacing="0" align="center">
					
				</table>
				<div id="divnewdirectory" >
					<br /><br />
					<a id="get_started" href="javascript:goto(navigation.newdirectory)" style="float:left">Create Your Directory</a>
				</div>
				<br />Discover Directories : 
				<!--img src="/images/tag.png" /-->
				<select id = "seltag" name = "seltag" onchange="get_dashboard('guest', this)">
					<option value="0">All Tags</option>
					<?php echo $tag_str; ?>
				</select>
				<br /><br />
				<table id="tblguestdashboard" border="0" cellpadding="7" cellspacing="0" align="center">
					
				</table>
			</td>
			<td id="divdirectorydetail" width="50%">
				&nbsp;
			</td>
		</tr>
	</table>
</form>