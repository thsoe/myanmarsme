jQuery(document).ready(function(){
		get_dashboard('guest');		// Discover Directories
		if(auth.result != 0 )
		{
			jQuery('#divuser').css('display','block');
			jQuery('#divguesttext').css('display','none');
			jQuery('#divnewdirectory').css('display','inline');
			get_dashboard('user');		// Your Directories
		}
		else
		{
			jQuery('#divuser').css('display','none');
			jQuery('#divguesttext').css('display','inline');
			jQuery('#divnewdirectory').css('display','none');
		}
	});
	function get_dashboard(type, tag)	// display directory
	{
		jQuery('#divdirectorydetail').html('');
		email = '';
		if(auth.result != 0)
			email = auth.email;		
		req_params = 'email=' + email + '&type=' + type;
		//alert(req_params);
		if(tag == undefined)
			req_params += '&tagid=0';
		else
			req_params += '&tagid=' + tag.value;
		tag_result = loadJSON(navigation.dashboard_exec,req_params);
		//alert(tag_result.guest_str);
		if(tag_result.success)
		{
			if(type == 'guest')
				jQuery('#tblguestdashboard').html(tag_result.guest_str);
			else
				jQuery('#tbluserdashboard').html(tag_result.guest_str);
		}
	}
	
	function display_directory(directoryid, type, is_private)	// display detail when click on directory
	{
		if(type == 1)
		{
			req_params = 'directoryid=' + directoryid + '&is_private=' + is_private;
			tag_result = loadJSON(navigation.dashboard_exec,req_params);
			jQuery('#divdirectorydetail').html(tag_result.guest_str);
		}
		else
			jQuery('#divdirectorydetail').html('');
	}
	
	function display_list(directoryid, type)	// display list when click on directory
	{
		$.cookies.set("listdirectoryid", directoryid);
		$.cookies.set("listtype", type);
		if(auth.result != 0)
			goto(navigation.user_directorylist);
		else
			goto(navigation.guest_directorylist);
	}
	
	/* function display_detail(directoryid)
	{
		req_params = 'directoryid=' + directoryid;
		tag_result = loadJSON(navigation.dashboard_exec,req_params);
		jQuery('#divdirectorydetail').html(tag_result.guest_str);
	} */
	
	function edit_directory(directoryid, companyid)		// when click on edit button
	{
		$.cookies.set("editdirectoryid", directoryid);
		$.cookies.set("editcompanyid", companyid);
		goto(navigation.editdirectory);
	}