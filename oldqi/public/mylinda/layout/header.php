<?php

?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $site_title ?> - BackOffice</title>
	
	<link href="<?= $path ?>/css/vendor/bootstrap.min.css" rel="stylesheet">
	<link href="<?= $path ?>/css/vendor/bootstrap-datetimepicker.min.css" rel="stylesheet">
	<link href="<?= $path ?>/css/vendor/ui-darkness/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">
	
	<link href="<?= $path ?>/css/vendor/ripples.min.css" rel="stylesheet">
    <link href="<?= $path ?>/css/vendor/material-wfont.min.css" rel="stylesheet">
</head>
<body style="padding-top:80px;">
<script src="<?= $path ?>/js/vendor/jquery-1.10.2.min.js"></script>
<script>var initFuncs = [];</script>
<header class="navbar navbar-fixed-top" role="banner">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
		    	<span class="sr-only">Navegação</span>
		      	<span class="icon-bar"></span>
		      	<span class="icon-bar"></span>
		      	<span class="icon-bar"></span>
		    </button>
		    <a class="navbar-brand" href="#"><?= $site_title ?></a>
		</div>
		
		<div class="collapse navbar-collapse" id="navbar-collapse-1">
    		<ul class="nav navbar-nav">
				<li <?= ('index' == $current_option)?"class='active'":"" ?>>
					<a href="<?= $path ?>/">Posts</a>
				</li>	
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown"><a href="#" class="dropdown-toggle"
					data-toggle="dropdown"><?= $_SESSION[$mysession]['username'] ?><b class="caret"></b>
				</a>
					<ul class="dropdown-menu">
						<li><a href="<?= $path ?>/admin">Administradores</a></li>
						<li><a href="<?= $path ?>/login/logout">Logout</a></li>
					</ul>
				</li>
				<li></li>
			</ul>
		</div>		
	</div>
</header>
<div class="row">
	<div class="col-lg-12">
		<div class="container">
			<div class="jumbotron">
		