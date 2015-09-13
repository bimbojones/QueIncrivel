<?php 

function type($type) {
	switch ($type) {
		case 1: return 'Facebook'; break;
		case 2: return 'Twitter'; break;
		case 3: return 'Instagram'; break;
		case 4: return 'Upload'; break;
		case 5: return 'Backoffice'; break;
		case 6: return 'Youtube'; break;
		case null: return 'Todos'; break;
		default: return 'Todos'; break;
	}
}

function itemType($type) {
	switch ($type) {
		case 1: return 'Imagem'; break;
		case 2: return 'Video'; break;
		case null: return 'Todos'; break;
		default: return 'Todos'; break;
	}
}

function hasValidSession() {
	/* BO USER */
	$mysession = 'mylinda_bo_session';
	
	session_start();
		
	if (!isset($_SESSION[$mysession]) 
			|| !isset($_SESSION[$mysession]['id']) 
			|| $_SESSION[$mysession]['id'] == null) {
		return false;
	}
	return true;
}

function redirect($page = "") {
	header("Location: {$path}/$page");
	exit(0);
}

function is_url_exist($url){
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_exec($ch);
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	if($code == 200) $status = true;
	else $status = false;
	
	curl_close($ch);
	return $status;
}

/* DB ADMIN */

function create_admins() {
	require_once ROOT_PATH . '/configuration.php';

	$tables = array();

	$tables['admin'] = "CREATE TABLE IF NOT EXISTS `admin` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `name` varchar(256) NOT NULL,
	  `email` varchar(64) NOT NULL,
	  `username` varchar(64) NOT NULL,
	  `password` varchar(128) NOT NULL,
	  `salt` varchar(32) DEFAULT NULL,
	  `gender` int(11) DEFAULT NULL,
	  `age` int(11) DEFAULT NULL,
	  `fbid` bigint(20) NOT NULL,
	  `level` int(11) NOT NULL DEFAULT '10',
	  `lang` int(11) NOT NULL DEFAULT '0',
	  `status` int(11) NOT NULL DEFAULT '0',
	  `create_date` datetime NOT NULL,
	  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

	$tables['admin_login'] = "CREATE TABLE IF NOT EXISTS `admin_login` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `username` varchar(45) DEFAULT NULL,
	  `ip` int(10) unsigned DEFAULT NULL,
	  `status` tinyint(1) DEFAULT NULL,
	  `create_date` datetime DEFAULT NULL,
	  `last_update` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  PRIMARY KEY (`id`),
	  KEY `UNAME` (`username`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;";


	foreach($tables as $name => $table) {
		DB::query($table);
	}

	$admin = DB::queryFirstRow("SELECT * FROM admin WHERE name='admin' ");
	if ($admin == null) {
		$salt = md5(time() . rand(1, 100));
		DB::insert('admin', array(
		'name' => 'admin',
		'email' => 'bimbojones25@gmail.com',
		'username' => 'admin',
		'salt' => $salt,
		'password' => md5(md5('2!NovO6') . $salt),
		'status' => 1,
		'create_date' => date('Y-m-d H:i')
		));
	}
	
	$admin = DB::queryFirstRow("SELECT * FROM admin WHERE username='suzana' ");
	if ($admin == null) {
		$salt = md5(time() . rand(1, 100));
		DB::insert('admin', array(
		'name' => 'Suzana Saboya',
		'email' => 'suzanasaboya@yahoo.com.br ',
		'username' => 'suzana',
		'salt' => $salt,
		'password' => md5(md5('princesa') . $salt),
		'status' => 1,
		'create_date' => date('Y-m-d H:i')
		));
	}

	$fuel = DB::queryFirstRow("SELECT * FROM admin WHERE name='fuel' ");
	if ($admin == null) {
		$salt = md5(time() . rand(1, 100));
		DB::insert('admin', array(
		'name' => 'fuel',
		'email' => 'fueluser@fuel.com',
		'username' => 'fuel',
		'salt' => $salt,
		'password' => md5(md5('pass#2014') . $salt),
		'status' => 1,
		'create_date' => date('Y-m-d H:i')
		));
	}
}

function get($val) {
	return (isset($_GET[$val]) && strlen($_GET[$val]) > 0)?htmlspecialchars($_GET[$val], ENT_QUOTES, 'UTF-8'):null;
}

function sort_class($current_field, $field, $order) {
	return ($current_field == $field)?(($order == 'asc')?"glyphicon glyphicon-sort-by-attributes":"glyphicon glyphicon-sort-by-attributes-alt"):"glyphicon glyphicon-sort";
}

?>