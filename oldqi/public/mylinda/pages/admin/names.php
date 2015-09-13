<?php

require_once realpath(dirname(__FILE__)) . '/includes/base.php';

$showLayout = false;

try {
	
	$name = (isset($_POST['term']))?$_POST['term']:null;
	$name = (isset($_GET['term']))?get('term'):$name;
	$field = (isset($_GET['field']))?get('field'):'name';	
	
	$items = DB::query(" 
			SELECT id, " . $field . " as value 
			FROM " . $table . " 
			WHERE " . $field . " LIKE %s 
			GROUP BY " . $field . " ", 
			"%" . $name ."%");
	
	echo json_encode($items);
	
} catch (Exception $e) {
	echo json_encode();
}


?>