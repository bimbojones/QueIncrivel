<?php

$username = null;
$password = null;

/* VERIFICA SE A */
$count_admin = DB::queryFirstRow("SELECT count(*) as total FROM admin");
if ($count_admin == null || $count_admin['total'] == 0) {
	create_admins();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$errors = array();
	
	if (!isset($_POST['username']) || strlen($_POST['username']) == 0) {
		$errors['username'] = true;
	} else {
		$username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
	}
	
	if (!isset($_POST['password']) || strlen($_POST['password']) == 0) {
		$errors['password'] = true;
	} else {
		$password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
	}
	
	if (count($errors) == 0) {
		
		$login_attemps = DB::queryFirstRow(" SELECT count(*) as total from admin_login WHERE username = %s_username AND status = 0 ", array('username' => $username));

		if (intval($login_attemps['total']) > 2 && (empty($_SESSION['captcha']) || empty($_POST['captcha']) || trim(strtolower($_POST['captcha'])) != $_SESSION['captcha'])) {
			$errors['show_captcha'] = true;
		} else {
						
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			
			DB::insert('admin_login', array(
				'username' => $username,
				'status' => 0,
				'ip' => ip2long($ip),
				'create_date' => date('Y-m-d H:i:s')
			));		
						
			$admin = DB::queryFirstRow(" SELECT id, username from admin WHERE status = 1 AND username = %s_username AND password = MD5(CONCAT(%s_password, salt)) ", 
				array(
					'username' => $username, 
					'password' => $password)
			);
			
			if ($admin != null) {
				$_SESSION[$mysession]['id'] = $admin['id'];
				$_SESSION[$mysession]['username'] = $admin['username'];
				
				DB::update('admin_login', array('status' => 1), 'username = %s', $username);
	
				header('Location: '. $path);
				return;
			} else {				
				$errors['not_found'] = true;
			}
		}
	}
	
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
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
<body style="padding-top:60px;">
<script src="<?= $path ?>/js/vendor/jquery-1.10.2.min.js"></script>
<script>var initFuncs = [];</script>
<header class="navbar navbar-inverse navbar-fixed-top" role="banner">
	<div class="container">
		<div class="navbar-header">			
		    <a class="navbar-brand" href="#"><?= $site_title ?></a>
		</div>
	</div>
</header>	
<div class="container">
	<div class="jumbotron">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<form class="form-vertical" role="form" method="POST" onsubmit="javascript:$('#password').val(hex_md5_not_empty($('#password').val()));">
					<div class="form-group <?= (isset($errors['username']))?"has-error":""; ?>">
						<label class="control-label" for="username">Username</label>
						<input type="text" class="form-control" id="username" name="username" placeholder="Utilizador" value="<?= ($username != null)?$username:""; ?>" />
						<?= (isset($errors['username']))?"<span class='help-block'>Tem de preencher o nome de utilizador</span>":""; ?>
					</div>
					<div class="form-group <?= (isset($errors['password']))?"has-error":""; ?>">
						<label class="control-label" for="password">Password</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Password" />
						<?= (isset($errors['password']))?"<span class='help-block'>Tem de preencher a password</span>":""; ?>
					</div>
					<?php if (isset($errors['show_captcha'])) { 
						$captcha_error = (isset($_POST['captcha']) && (trim(strtolower($_POST['captcha'])) != $_SESSION['captcha']));
						?>
						<div class="form-group <?= ($captcha_error)?"has-error":""; ?>">
							<div class="row">
								<div class="col-md-4"><img src="library/captcha.php" id="captcha" /><br/></div>
								<div class="col-md-8"></div>					
							</div>
							<div class="row">
								<div class="col-md-4"><input class="form-control" type="text" name="captcha" id="captcha-form" autocomplete="off" placeholder="Captcha" /><br/></div>
								
								<div class="col-md-4"><a href="#" style="margin-left: -20px; margin-top: 7px;" onclick="document.getElementById('captcha').src='library/captcha.php?'+Math.random();document.getElementById('captcha-form').focus();" id="change-image" class="glyphicon glyphicon-refresh"></span></a></div>
								<div class="col-md-4"></div>
							</div>			
							<?= ($captcha_error)?"<span class='help-block'>Captcha errado</span>":""; ?>
						</div>
					<?php } ?>
													
					<button type="submit" class="pull-right btn btn-primary">Entrar</button>
					<?= (isset($errors['not_found']))?"<span class='help-block' style='color:#a94442;'>Combinação Username/Password inválido</span>":""; ?>
				</form>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?= $path ?>/js/vendor/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="<?= $path ?>/js/vendor/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="<?= $path ?>/js/vendor/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= $path ?>/js/utils.js"></script>

<iframe id="iframe-ajax" name="iframe-ajax"  style="display:none;"></iframe>
<script type="text/javascript">
	$(document).ready(function() {
		$('button[data-loading-text]').click(function () {
		    $(this).button('loading');
		});
		
		for (var f in initFuncs) initFuncs[f]();
	});
</script>
</body>
</html>		