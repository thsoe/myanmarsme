<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1); 
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	error_reporting(0);
	require_once 'include/connection_util.php';
	
	try{
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
<script type="text/javascript" src="/js/sme/user_dashboard.js"></script>
<script type="text/javascript">
	
</script>
<form id="frmdashboard" name="frmdashboard">
	<h2  style="border-bottom:1px solid #f58220;color:#f58220;padding-bottom:5px;font-size:13px;">
		<strong id="pinfo">Directories</strong>
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
				<select id = "seltag" name = "seltag" onchange="get_dashboard('guest', this)">
					<option value="0">All Tags</option>
					<?php echo $tag_str; ?>
				</select>
				<br /><br />
				<table id="tblguestdashboard" border="0" cellpadding="7" cellspacing="0" align="center">
					
				</table>
			</td>
			<td id="divdirectorydetail" width="50%" valign="top">
				&nbsp;
			</td>
		</tr>
	</table>
</form>