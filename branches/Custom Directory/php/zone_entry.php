<?php require_once 'include/connection_util.php';
 ?>

<!--?php require_once 'zone.php' ?-->

<html>
<head>
	<title>zone entry</title>
	<?php require_once 'include/include.php'; ?>
	<link href="../style/zone_entry.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../js/zone_entry.js" ></script>
</head>
	<body>
		<div id="overlay" class="overlay"></div>
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
					<td class="leftLabel">Latitude : </td>
					<td class="rightFields"><input type="text" name="latitude" id="latitude" ></td>
				</tr>
				<tr>
					<td class="leftLabel">Longitude : </td>
					<td class="rightFields"><input type="text" name="longitude" id="longitude" ></td>
				</tr>
				<tr>
					<td class="leftLabel">Address : </td>
					<td class="rightFields"><input type="text" name="address" id="address" ></td>
				</tr>
				<tr>
					<td class="leftLabel">Contact No : </td>
					<td class="rightFields"><input type="text" name="contactNo" id="contactNo" ></td>
				</tr>
				<tr>
					<td class="leftLabel">Contact No 2 : </td>
					<td class="rightFields"><input type="text" name="contactNo2" id="contactNo2" ></td>
				</tr>
				<tr>
					<td class="leftLabel">Contact No 3 : </td>
					<td class="rightFields"><input type="text" name="contactNo3" id="contactNo3" ></td>
				</tr>
				<tr>
					<td class="leftLabel">Area : </td>
					<td class="rightFields"> <input type="text" name="area" id="area" ></td>
				</tr>
				<tr>
					<td class="leftLabel">State Division : </td>
					<td class="rightFields"><input type="text" name="stateDivision" id="stateDivision" ></td>
				</tr>
				<tr>
					<td class="leftLabel">Midc Zone : </td>
					<td class="rightFields"><input type="text" name="midcZone" id="midcZone"></td>
				</tr>
				<tr>
					<td class="leftLabel">Establishment Year : </td>
					<td class="leftLabel">
						<select name="estYear" id="estYear">
							<?php 
								$cDate=date("Y");
								for($i=-5;$i<6;$i++){
									if($cDate==($cDate+$i))
										echo "<option selected=true>";
									else
										echo "<option>";
									echo ($cDate+$i)."</option>";
								}
									 
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="leftLabel">Industry Country : </td>
					<td class="rightFields"><input type="text" name="industrialCountry" id="industrialCountry"></td>
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
//					$users=ConnectionUtil::findAllWithLimit('IndustrialZone',array(),20,1);
					$users=ConnectionUtil::findAll('IndustrialZone');
					ConnectionUtil::commit();
			?>
			<table id="data">
				<tr>
					<th>Name</th>
					<th>latitude</th>
					<th>longitude</th>
					<th>Address</th>
					<th>Contact No</th>
					<th>Contact No2</th>
					<th>Contact No3</th>
					<th>Area</th>
					<th>State Division</th>
					<th>Midc Zone</th>
					<th>Establishment Year</th>
					<th>Industrial Country</th>
					<th><div id="add" style="cursor:pointer;" >+</div></th>
				</tr>
				<?php 
					$table="";
					foreach($users as $user){
						$table.="<tr>";
						$table.="<td>".$user->getName()."</td>";
						 $table.="<td>".$user->getLat()."</td>";
						 $table.="<td>".$user->getLng()."</td>";
						 $table.="<td>".$user->getAddress()."</td>";
						 $table.="<td>".$user->getContactNo()."</td>";
						 $table.="<td>".$user->getContactNo2()."</td>";
						 $table.="<td>".$user->getContactNo3()."</td>";
						 $table.="<td>".$user->getArea()."</td>";
						 $table.="<td>".$user->getStateDvision()."</td>";
						 $table.="<td>".$user->getMidcZone()."</td>";
						 $table.="<td>".$user->getEstablishmentYear()."</td>";
						 $table.="<td>".$user->getIndustryCount()."</td>";
						 $table.="<td><div id='remove' ><a href='#'>delete</a></div><input type='hidden' value='".$user->getId()."'></td>";
						 $table.="</tr>";
					}
					echo $table;
				 ?>
			</table>
		</div>
	</body>
</html>
