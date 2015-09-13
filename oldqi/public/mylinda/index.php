<?php

require_once 'configuration.php';
require_once LIBRARY_PATH . 'utils.php';

//$smarty->force_compile = true;

$server_query_string = $_SERVER['QUERY_STRING'];
$server_path = rtrim(str_replace($path, '', strtolower(strtok($_SERVER["REQUEST_URI"],'?'))), '/');
$controller = 'index';
$action = 'index';
$current_option = 'index';


if (strlen($server_path) > 0) {
	$server_commands = explode('/', $server_path);
	$controller = (count($server_commands) > 1 && strlen($server_commands[1]) > 0)?$server_commands[1]:'index';
	$action = (count($server_commands) > 2 && strlen($server_commands[2]) > 0)?$server_commands[2]:'index';
}

if (!hasValidSession()) {
	
	require_once "pages/login/index.php";
	
} else if ($controller == 'login' && $action == 'index') {
	
	redirect();
	return;
	
} else if (file_exists("pages/{$controller}/{$action}.php")){
	
	$current_option = $controller;
	
	$showLayout = true;
	ob_start();
	include "pages/{$controller}/{$action}.php";
	$html = ob_get_clean();
	
	if ($showLayout) require_once "layout/header.php";
	echo $html;
	if ($showLayout) require_once "layout/footer.php";
	
	
} else {
	
	require_once "layout/header.php";
	
	echo "PAGE NOT FOUND";
	
	require_once "layout/footer.php";
	
}
