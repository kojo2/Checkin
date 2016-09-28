<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if (IE 9)]><html class="no-js ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--> <html lang="en-US"> <!--<![endif]-->
<head>

<!-- Meta Tags -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Rocx | Admin</title>   

<meta name="description" content="Insert Your Site Description" /> 

<!-- Mobile Specifics -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="HandheldFriendly" content="true"/>
<meta name="MobileOptimized" content="320"/>   

<!-- Mobile Internet Explorer ClearType Technology -->
<!--[if IEMobile]>  <meta http-equiv="cleartype" content="on">  <![endif]-->

<!-- Bootstrap -->
<link href="/static/_include/css/bootstrap.min.css" rel="stylesheet">
<!-- Main Style -->
<link href="/static/_include/css/main.css" rel="stylesheet">

<!-- Custom Style -->
<link href="/static/customStyle.css" rel="stylesheet">

<!-- Supersized -->
<link href="/static/_include/css/supersized.css" rel="stylesheet">
<link href="/static/_include/css/supersized.shutter.css" rel="stylesheet">

<!-- FancyBox -->
<link href="/static/_include/css/fancybox/jquery.fancybox.css" rel="stylesheet">

<!-- Font Icons -->
<link href="/static/_include/css/fonts.css" rel="stylesheet">

<!-- Shortcodes -->
<link href="/static/_include/css/shortcodes.css" rel="stylesheet">

<!-- Responsive -->
<link href="/static/_include/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="/static/_include/css/responsive.css" rel="stylesheet">

<!-- Supersized -->
<link href="/static/_include/css/supersized.css" rel="stylesheet">
<link href="/static/_include/css/supersized.shutter.css" rel="stylesheet">

<!-- Google Font -->
<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900' rel='stylesheet' type='text/css'>

<!-- Fav Icon -->
<link rel="shortcut icon" href="#">

<link rel="apple-touch-icon" href="#">
<link rel="apple-touch-icon" sizes="114x114" href="#">
<link rel="apple-touch-icon" sizes="72x72" href="#">
<link rel="apple-touch-icon" sizes="144x144" href="#">

<!-- Modernizr -->
<script src="/static/_include/js/modernizr.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<!-- links for jqueryUI datepicker-->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
</head>


<body>
<div id="backButton"><a href="javascript:window.history.go(-1);">Back</a></div>
<ul id="menu">
	<a href="<?php echo base_url();?>"><li id="HomeButton" class="menuButton">Home</li></a>
	<a href="<?php echo base_url('index.php/adminEditUsers');?>"><li id="UsersButton" class="menuButton">Users</li></a>
	<a href="<?php echo base_url('index.php/adminViewReports');?>"><li id="ReportsButton" class="menuButton">Reports</li></a>
	<a href="<?php echo base_url('index.php/logout');?>"><li id="LogOutButton" class="menuButton">Log Out</li></a>
</ul>