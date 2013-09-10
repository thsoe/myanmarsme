	$('.colorpicker').css('display', 'none');
	if(auth.result != 0 )
		$("#divdashboard").load(navigation.user_dashboard);
	else
		$("#divdashboard").load(navigation.guest_dashboard);