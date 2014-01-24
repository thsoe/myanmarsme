<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Myanmar SME, Your One Stop Portal</title>
<meta NAME="KEYWORDS" CONTENT="" />
<meta NAME="TITLE" CONTENT="" />
<meta NAME="DESCRIPTION" CONTENT="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta http-equiv="content-style-type" content="text/css" />
<meta name="robots" content="index,follow" />
<meta name="viewport" content="width=1024" />
<link rel="shortcut icon" href="/images/xxx.ico" type="/image/vnd.microsoft.icon"/>
<link rel="icon" type="image/png" href="/images/xxx.png" />
<link href="/" rel="home" />
<link href="/style/import.css" rel="stylesheet" type="text/css" media="screen,tv" charset="utf-8" />
<script type="text/javascript" src="/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="/js/jquery.ba-hashchange.js"></script>
<script type="text/javascript" src="/js/jqNews.js"></script>
<script type="text/javascript" src="/js/jquery.cookies.2.2.0.js"></script>
<script type="text/javascript" src="/js/jquery.tinycarousel.min.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
<!--
var auth =$.cookies.get("session");//JSON.parse($.cookies.get("session"));//getCookie("session");
if (auth ==null || auth ==""){
auth ={
"username" : "Guest",
"result" : 0
};

};
//-->
</script>

<script type="text/javascript">
<!--temp script-->
loadNavigation();
links = swapJsonKeyValues(navigation);
loadlables();
var loggedIn = 0;

</script>

<script type="text/javascript" src="/js/sme/directory_list.js"></script>
<script type="text/javascript">
</script>
</head>

<body>
<div id="main">
<div id="header">
<?php require_once("../html/header.html"); ?>
</div>
<div id="content">
	<div id="md_content2">
		<div id="md_content3">
			<div id="maincontent">
<div class="content_top">
<div class="cor_lf_t"></div>
<div class="cor_rt_t"></div>
</div>
<p><!--do not touch this, this is for image--></p>
<div id="divdashboard" class="container">
<form id="frmdirectlist_guest" name="frmdirectlist_guest">
	
</form>
<br />
<br />
<br />
<div style="width:100%">
<div class="text-block-1" style="float:left;">
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	
	<?php $href="http://localhost/php/guest_directorylist.php?id=" . $_GET['id'];?>
	
	<iframe src="//www.facebook.com/plugins/like.php?locale=en_US&amp;href=<?php echo urlencode ("https://www.facebook.com/MyanmarSME");?>&amp; show_faces=false&amp;colorscheme=light&amp;width=450&amp;action=like&amp;layout=standard&amp;send=true" scrolling="no" frameborder="0" allowTransparency="true" style="float:left; border:none; overflow:hidden; width:370px; height:24px;" class="fb-like"></iframe>
	<br><br><br>	
	<div class="fbook_comment">
		<div id="fb-root"></div>
		<div id="app_fb_comment">
			<div class="fb-comments" data-href="<?php echo $href; ?>"  data-width="450" data-num-posts="5"></div>
		</div>
	</div>
</div>
<!-- twitter -->
<a class="twitter-timeline" href="https://twitter.com/Myanmar_SME" data-widget-id="393402326766985217">Tweets by @Myanmar_SME</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+":-//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>
</div>
</div>
<p><!--container--></p>
<div class="content_btm">
<div class="cor_lf_b"></div>
<div class="cor_rt_b"></div>
</div>
<p><!--do not touch this, this is for image--> <!--md_content--> <!--content--></p>
</div>
		</div><!--do not touch this, this is for image-->
	</div><!--md_content-->
	<div id="footer">
<?php require_once("../html/footer.html"); ?>
</div>
</div>
<p><!--main--></p>
</div>
</body>
</html>