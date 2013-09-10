function get_public(val)
{
	if(val == 1)
	{
		jQuery('#imgpublic').css('border','1px solid black');
		jQuery('#imgprivate').css('border','');
	}
	else
	{
		jQuery('#imgpublic').css('border','');
		jQuery('#imgprivate').css('border','1px solid black');
	}
	jQuery('#txtpublic').val(val);
}

function create_directory()
{
	var name = $('#txtdirectoryname').val();
	var description = $('#txtdirectorydesc').val();
	var colorcode = $('#txtcolor').val();
	var is_public = $('#txtpublic').val();
	var tags = $('#txtdirectorytag').val();
	var rating = '1';
	req_params = "name=" + name + "&colorcode=#" + colorcode + 
				"&description=" + description + "&tags=" + tags + 
				"&is_public=" + is_public + "&smeuseremail=" + auth.email + 
				"&rating=" + rating;
	//alert(req_params);//return false;
	directoryValidation();
	tag_result = loadJSON(navigation.directory_exec,req_params);
	if(tag_result.success)
	{
		//goto(navigation.dashboard);
		$.cookies.set("new_directory", tag_result.directoryid);
		goto(navigation.comUpload);
	}
}

function directoryValidation()
{
	//alert('aaa');
	jQuery("#frmnewdirectory").validate({
			'rules':{
				'txtdirectoryname':{'required':true},
				'txtcolor':{'required':true},
				'txtpublic':{'required':true},
				'txtdirectorydesc':{'required':true},
				'txtdirectorytag':{'required':true}
			},
			'messages': {
				'txtdirectoryname':{'required':'Please enter directory name.'},
				'txtcolor':{'required':'Please select color code file.'},
				'txtpublic':{'required':'Please select public/private.'},
				'txtdirectorydesc':{'required':'Please enter directory description.'},
				'txtdirectorytag':{'required':'Please enter directory tag.'}
			}
		});
}

function upload_company()
{
	companyValidation();
	var directoryid =$.cookies.get("new_directory");
	jQuery('#directoryid').val(directoryid);
	$("#frmcompany").attr("action",'/php/company_exec.php');
	jQuery('#frmcompany').submit();
	/* var name = $('#txtcompname').val();
	var logo = $('#filelogo').val();
	var ad = $('#filead').val();
	var description = $('#txtdescription').val();
	var businessAddress = $('#txtbusinessaddress').val();
	var worksiteAddress = $('#txtworksiteaddress').val();
	var contactNo1 = $('#txtcontact1').val();
	var contactNo2 = $('#txtcontact2').val();
	var rank = '1';
	req_params = "name=" + name + "&logo=" + logo + "&ad=" + ad + 
				"&description=" + description + "&businessAddress=" + businessAddress + 
				"&worksiteAddress=" + worksiteAddress + "&smeuseremail=" + auth.email + 
				"&contactNo1=" + contactNo1 + "&contactNo2=" + contactNo2 + 
				"&rank=" + rank + "&directoryid=" + directoryid;
	//alert(req_params);//return false;
	tag_result = loadJSON(navigation.company_exec,req_params);
	if(tag_result.success)
	{
		//goto(navigation.dashboard);
		goto(navigation.dashboard);
	} */
}

function companyValidation()
{
	jQuery("#frmcompany").validate({
			'rules':{
				'name':{'required':true},
				'logo':{'required':true,'accept':'gif|jpeg|jpg|png'},
				'description':{'required':true},
				'businessAddress':{'required':true},
				'worksiteAddress':{'required':true},
				'contactNo1':{'required':true},
				'contactNo2':{'required':true},
				'name':{'required':true},
				'ad':{'required':true,'accept':'gif|jpeg|jpg|png'}
			},
			'messages': {
				'name':{'required':'Please enter company name.'},
				'logo':{'required':'Please select logo image file.','accept':'Please select (gif , jpeg , jpg , png ) extension only.'},
				'description':{'required':'Please enter description.'},
				'businessAddress':{'required':'Please enter Business Address.'},
				'worksiteAddress':{'required':'Please enter Worksite Address.'},
				'contactNo1':{'required':'Please enter Contact No1.'},
				'contactNo2':{'required':'Please enter Contact No2.'},
				'ad':{'required':'Please select advertising image file.','accept':'Please select (gif , jpeg , jpg , png ) extension only.'}
			}				
		});
}