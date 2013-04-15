<?php require_once 'include/connection_util.php';
	  require_once 'include/file_util.php';
	  FileUtil::deleteFilesInFolder("../images/temp/");
 ?>

<!--?php require_once 'zone.php' ?-->

<html>
<head>
	<title>Company entry</title>
	<?php require_once 'include/include.php'; ?>
	<script type="text/javascript" src="../js/company_entry.js" ></script>
	<link href="../style/company_entry.css" rel="stylesheet" type="text/css" />
</head>
	<body>
		<div id="overlay" class="overlay"></div>
		<img id="loading" src="../images/loading.gif" style="display:none;">
		<div  id="popup" class="popup">
			<input type="hidden" id="mode" value="new" />
			<input type="hidden" id="index" value="" />
			<input type="hidden" id="id" value="" />
			
			<table>
				<tr>
					<td class="leftLabel">Name : </td>
					<td class="rightFields"><input type="text" name="name" id="name" ></td>
				</tr>
				<tr>
					<td class="leftLabel" colspan="2" id="logoRow"><a href="#" id="logo" class="attach" >Attach Logo</a></td>
				</tr>
				<tr>
					<td class="leftLabel">Description : </td>
					<td class="rightFields"><input type="text" name="desc" id="desc"  ></td>
				</tr>
				<tr>
					<td class="leftLabel">Long Description : </td>
					<td class="rightFields"><textarea rows="5" cols="30" Ê  style="resize:none;" name="longDesc" id="longDesc"  ></textarea></td>
				</tr>
				<tr>
					<td class="leftLabel" colspan="2" id="attachImgRow">
						<a href="#" id="attachImg" class="attach" >Attach Image</a>
					</td>
				</tr>
				<tr>
					<td class="leftLabel">Business Address : </td>
					<td class="rightFields"><input type="text" name="businessAdd" id="businessAdd" ></td>
				</tr>
				<tr>
					<td class="leftLabel">Worksite Address : </td>
					<td class="rightFields"><input type="text" name="worksiteAdd" id="worksiteAdd" ></td>
				</tr>
				<tr>
					<td class="leftLabel">Contact No 1 : </td>
					<td class="rightFields"> <input type="text" name="contactNo1" id="contactNo1" ></td>
				</tr>
				<tr>
					<td class="leftLabel">Contact No 2 : </td>
					<td class="rightFields"><input type="text" name="contactNo2" id="contactNo2" ></td>
				</tr>
				<tr>
					<td class="leftLabel" colspan="2" id="advertisementRow">
					<a href="#" name="advertisement" id="advertisement" class="attach">Attach Advertisement Image</a></td>
				</tr>
				<tr>
					<td class="leftLabel">Rank : </td>
					<td class="leftLabel">
						<select name="rank" id="rank">
							<?php 
								for($i=1;$i<=20;$i++){
									echo "<option>";
									echo $i."</option>";
								}
									 
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="rightFields"><a href="#" id="btnSave">Save</a> </td>
					<td class="centerLabel"><a href="#" id="btnCancel">Cancel</a> </td>
				</tr>
			</table>
		</div>
		<div class="main">
			<?php 
					ConnectionUtil::beginTransaction();
//					$companies=ConnectionUtil::findAllWithLimit('SMECompany',array(),20,1);
					$companies=ConnectionUtil::findAll('SMECompany');
					ConnectionUtil::commit();
			?>
			<table id="data">
				<tr>
					<th>Name</th>
<!--					<th>Logo</th>-->
					<th>Description</th>
<!--					<th>Long Description</th>-->
<!--					<th>Image1</th>-->
<!--					<th>Image2</th>-->
<!--					<th>Image3</th>-->
<!--					<th>Image4</th>-->
<!--					<th>Image5</th>-->
<!--					<th>Image6</th>-->
					<th>Business Address</th>
					<th>Worksite Address</th>
					<th>Contact No1</th>
					<th>Contact No2</th>
<!--					<th>Advertisement</th>-->
					<th>Rank</th>
					<th><div id="add" style="cursor:pointer;">+</div></th>
				</tr>
				<?php 
					$table="";
					foreach($companies as $company){
						$table.="<tr>";
						$table.="<td>".$company->getName()."</td>";
//						 $table.="<td>".$company->getLogo()."</td>";
						 $table.="<td>".$company->getDescription()."</td>";
//						 $table.="<td>".$company->getLongDesc()."</td>";
//						 $table.="<td>".$company-> getImage1()."</td>";
//						 $table.="<td>".$company-> getImage2()."</td>";
//						 $table.="<td>".$company-> getImage3()."</td>";
//						 $table.="<td>".$company-> getImage4()."</td>";
//						 $table.="<td>".$company-> getImage5()."</td>";
//						 $table.="<td>".$company-> getImage6()."</td>";
						 $table.="<td>".$company-> getBusinessAddress()."</td>";
						 $table.="<td>".$company-> getWorksiteAddress()."</td>";
						 $table.="<td>".$company->getContactNo1()."</td>";
						 $table.="<td>".$company->getContactNo2()."</td>";
//						 $table.="<td>".$company->getAd()."</td>";
						 $table.="<td>".$company->getRank()."</td>";
						 $table.="<td><div id='remove' ><a href='#'>delete</a></div><input type='hidden' value='".$company->getId()."'>";
						 $table.="<div id='longDesc' style='display:none;'>".$company->getLongDesc()."</div>";
						 $table.="<div id='logo' style='display:none;'>".$company->getLogo()."</div>";
						 $table.="<div id='image1' style='display:none;'>".$company->getImage1()."</div>";
						 $table.="<div id='image2' style='display:none;'>".$company->getImage2()."</div>";
						 $table.="<div id='image3' style='display:none;'>".$company->getImage3()."</div>";
						 $table.="<div id='image4' style='display:none;'>".$company->getImage4()."</div>";
						 $table.="<div id='image5' style='display:none;'>".$company->getImage5()."</div>";
						 $table.="<div id='image6' style='display:none;'>".$company->getImage6()."</div>";
						 $table.="<div id='advertisement' style='display:none;'>".$company->getAd()."</div>";
						 
						 $table.="</td>";
						 
						 $table.="</tr>";
					}
					echo $table;
				 ?>
			</table>
		</div>
		
				<input type="file" name="file" id="file" style="display:none;"   /> 
				<input type="hidden" name="fieldId" id="fieldId"  style="display: none"/>
<!--		<iframe name="hiddenFrame" id="hiddenFrame" >-->
<!--			<form action="company_service.php" method="post" target="hiddenFrame" enctype="application/x-www-form-urlencoded">-->
<!--				<input type="file" name="file" id="file" /> -->
<!--			</form>-->
<!--		</iframe>-->
	</body>
</html>
