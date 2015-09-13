<?php include_once "/../configuration.php"?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title></title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="apple-touch-icon" href="apple-touch-icon.png">
<link rel="stylesheet" href="<?=$path ?>css/styles.css">
<script src="<?=$path ?>js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>
<body>
	<!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
	<div class="container">
		<a href="<?= $path ?>"><img id="logo"
			src="<?=$path ?>images/balao.png" /></a>
		<div id="navbar" data-spy="affix" data-offset-top="200">
			<nav class="navbar navbar-default">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed"
							data-toggle="collapse" data-target="#navbar-collapse">
							<span class="sr-only">Navegação</span> <span class="icon-bar"></span>
							<span class="icon-bar"></span> <span class="icon-bar"></span>
						</button>
					</div>
					<div class="collapse navbar-collapse" id="navbar-collapse">
						<ul class="nav navbar-nav">
							<li class="dropdown"><a href="#" class="dropdown-toggle"
								data-toggle="dropdown" role="button" aria-haspopup="true"
								aria-expanded="false">Filtrar <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="#">Mais lidos</a></li>
									<li><a href="#">Recentes</a></li>
									<li><a href="#">Vídeos</a></li>
								</ul></li>
							<li class="dropdown"><a href="#" class="dropdown-toggle"
								data-toggle="dropdown" role="button" aria-haspopup="true"
								aria-expanded="false">Categorias <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="#">História</a></li>
									<li><a href="#">Viagens</a></li>
									<li><a href="#">Vida</a></li>
								</ul></li>
							<li><a href="#">Contato</a></li>
							<li><a href="#">Sobre</a></li>
							<li><a href="#">Políticas</a></li>
						</ul>
						<div class="nav navbar-nav navbar-right">
						<form class="navbar-form " role="search">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Pesquisar">
							</div>
							<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
						</form>
					</div>
				</div>
			</nav>
		</div>
	</div>