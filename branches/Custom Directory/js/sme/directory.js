function get_public(val)	// get public or private on directory setup
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
		//$.cookies.set("new_directory", tag_result.directoryid);
		//goto(navigation.comUpload);
		goto(navigation.dashboard);
	}
}

function update_directory()
{
	var directoryid = $('#hiddirectoryid').val();
	var companyid = $('#hidcompanyid').val();
	var name = $('#txtdirectoryname').val();
	var description = $('#txtdirectorydesc').val();
	var colorcode = $('#txtcolor').val();
	var is_public = $('#txtpublic').val();
	var tags = $('#txtdirectorytag').val();
	var rating = '1';
	req_params = "directoryid=" + directoryid + "&name=" + name + "&colorcode=#" + colorcode + 
				"&description=" + description + "&tags=" + tags + 
				"&is_public=" + is_public + "&smeuseremail=" + auth.email + 
				"&rating=" + rating;

	directoryValidation();
	tag_result = loadJSON(navigation.directory_exec,req_params);
	if(tag_result.success)
	{
		$.cookies.set("edit_directory", directoryid);
		$.cookies.set("edit_company", companyid);
		//goto(navigation.comEdit);
		goto(navigation.dashboard);
	}
}

function directoryValidation()
{
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