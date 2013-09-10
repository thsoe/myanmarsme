jQuery(document).ready(function(){
		get_directorylist('guest');		// Discover Directories
		if(auth.result != 0 )
		{
			/* jQuery('#divuser').css('display','block');
			jQuery('#divguesttext').css('display','none');
			jQuery('#divnewdirectory').css('display','inline'); */
			get_directorylist('user');		// Your Directories
		}
		/* else
		{
			jQuery('#divuser').css('display','none');
			jQuery('#divguesttext').css('display','inline');
			jQuery('#divnewdirectory').css('display','none');
		} */
	});
	function get_directorylist(type)	// display directory
	{
		jQuery('#divdirectorylistdetail').html('');
		/* email = '';
		if(auth.result != 0)
			email = auth.email;		
		req_params = 'email=' + email + '&type=' + type;
		
		if(tag == undefined)
			req_params += '&tagid=0';
		else
			req_params += '&tagid=' + tag.value; */
		var usertype = $.cookies.get("listtype");
		email = '';
		if(auth.result != 0)
			email = auth.email;		
		req_params = 'email=' + email + '&type=' + usertype;
		//alert(req_params);
		var directory_id = $.cookies.get("listdirectoryid");
		req_params += '&directorylist=' + directory_id;
		tag_result = loadJSON(navigation.directorylist_exec,req_params);
		//alert(tag_result.guest_str);
		if(tag_result.success)
		{
			if(type == 'guest')
				jQuery('#frmdirectlist_guest').html(tag_result.guest_str);
			else
				jQuery('#frmdirectlist_user').html(tag_result.guest_str);
		}
	}
	
	function display_list(directoryid, companyid, type, is_private, usertype)	// display detail when click on directory
	{
		if(type == 1)
		{
			req_params = 'directoryid=' + directoryid + '&companyid=' + companyid + '&is_private=' + is_private + '&usertype=' + usertype;
			//alert(req_params);
			tag_result = loadJSON(navigation.directorylist_exec,req_params);
			jQuery('#divdirectorylistdetail').html(tag_result.guest_str);
		}
		else
			jQuery('#divdirectorylistdetail').html('');
	}
	
	function create_company(directoryid)
	{
		$.cookies.set("new_directory", directoryid);
		goto(navigation.comUpload);
	}
	
	function upload_company()
	{
		companyValidation();
		var directoryid =$.cookies.get("new_directory");
		$.cookies.del("new_directory");
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

	function edit_company(directoryid, companyid)		// when click on edit button
	{
		$.cookies.set("edit_directory", directoryid);
		$.cookies.set("edit_company", companyid);
		goto(navigation.comEdit);
	}
	
	function update_company()
	{
		//companyValidation();
		$.cookies.del("edit_directory");
		$.cookies.del("edit_company");
		
		$("#frmeditcompany").attr("action",'/php/company_exec.php');
		jQuery('#frmeditcompany').submit();
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

	function display_file(div, type)	// show and hide image and change button
	{
		if(type == 1)	// display image
		{
			jQuery('#div' + div).css('display','block');
			jQuery('#divchange' + div).css('display','none');
		}
		else	// display change button
		{
			jQuery('#div' + div).css('display','none');
			jQuery('#divchange' + div).css('display','block');
		}
	}