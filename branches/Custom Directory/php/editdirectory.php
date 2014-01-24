<script type="text/javascript" src="/js/urlcheck.js"></script>
<script type="text/javascript" src="/js/sme/directory.js"></script>
<script language="javascript" src="/js/color_picker/js/colorpicker.js"></script>
<link type="text/css" href="/js/color_picker/css/colorpicker.css" rel="stylesheet" />
<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1); 
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	error_reporting(0);
	require_once 'include/connection_util.php';
	$companyid = '';
	if(isset($_COOKIE['editdirectoryid']))
		$directoryid = $_COOKIE['editdirectoryid'];
	if(isset($_COOKIE['editcompanyid']))
		$companyid = $_COOKIE['editcompanyid'];
	try{
		$em = ConnectionUtil::getEntityManager();
		$cri_str = ' WHERE dt.directoryid = ' . $directoryid;
		$query =$em->createQuery("SELECT ud FROM UserDirectory ud LEFT JOIN ud.directorytag dt " . $cri_str);
		$result = $query->getResult();
		if(count($result) > 0)
		{
			for ($i=0; $i<count($result); $i++)
			{
				$result_arr = $result[$i]->toJSON();
				$result_arr = json_decode($result_arr);
				$name = $result_arr->name;
				$colorcode = str_replace('#', '', $result_arr->colorcode);
				$description = $result_arr->description;
				$public = $result_arr->public;
				$smeuseremail = $result_arr->smeuseremail;
				
				$cri_str1 = ' WHERE dt.directoryid = ' . $directoryid;
				$query =$em->createQuery("SELECT dt FROM DirectoryTag dt " . $cri_str1);
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
		}
	}
	catch (Exception $e){
		$log->LogError($e->getMessage());
		echo $e->getMessage();
		$success = 0;
	}
?>
<script>
	jQuery(document).ready(function(){
		$('#txtcolor').ColorPicker(
				{
					onSubmit: function(hsb, hex, rgb, el) 
					{
						$(el).val(hex);
						$(el).ColorPickerHide();
					},
					onBeforeShow: function () 
					{
						$(this).ColorPickerSetColor(this.value);
					}
				});
		if('<?php echo $public; ?>' == 1)
			get_public(1);
		else
			get_public(0);
	});
</script>
<div class="content_top">
<div class="cor_lf_t"></div>
<div class="cor_rt_t"></div>
</div>
<p><!--do not touch this, this is for image--></p>
<div class="container">
<form id="frmnewdirectory" name="frmnewdirectory" method="post">
	<h2  style="border-bottom:1px solid #f58220;color:#f58220;padding-bottom:5px;font-size:13px;">
		<strong id="pinfo">Create new directory</strong>		
	</h2>
	<br /><br />
	
	<div width="80%" style="padding-left:150px;" >
		<strong id="pinfo">What Kind of Directory are you creating?</strong>
		<br /><br />
		Directory Name 
		<input type="hidden" name="hiddirectoryid" id="hiddirectoryid" value="<?php echo $directoryid; ?>"/>
		<input type="hidden" name="hidcompanyid" id="hidcompanyid" value="<?php echo $companyid; ?>"/>
		<input type="text" name="txtdirectoryname" id="txtdirectoryname" value="<?php echo $name; ?>" />
		<input type="text" name="txtcolor" id="txtcolor" value="<?php echo $colorcode; ?>" />		
		<br /><br />
		<img id="imgpublic" src="/images/public.png" onclick="get_public(1);" style="cursor:pointer;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<img id="imgprivate" src="/images/private.png" onclick="get_public(0);" style="cursor:pointer;">
		<input type="hidden" id="txtpublic" name="txtpublic" value="<?php echo $public; ?>"/>
		<br /><br />
		Describe Briefly on what your directory is about<br />
		<input type="text" name="txtdirectorydesc" id="txtdirectorydesc" value="<?php echo $description; ?>" size="120"/>
		<br /><br />
		Directory Tag 
		<input type="text" name="txtdirectorytag" id="txtdirectorytag" value="<?php echo $tagnames; ?>"/>
		<br /><br />
		<a href="javascript:update_directory()" class="button" style="float:left;margin-right:10px;">Update</a>
        <a href="javascript:goto(navigation.dashboard) " class="button" style="float:left;margin-right:10px;">Cancel</a>
	</div>
</form>
</div>
<p><!--container--></p>
<div class="content_btm">
<div class="cor_lf_b"></div>
<div class="cor_rt_b"></div>
</div>
<p><!--do not touch this, this is for image--> <!--md_content--> <!--content--></p>
</body>
</html>