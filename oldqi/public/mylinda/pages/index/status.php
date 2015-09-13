<?php

require_once realpath(dirname(__FILE__)) . '/includes/base.php';

$showLayout = false;

try {
	
	$id = (isset($_POST['id']) && intval($_POST['id']) > 0)?intval($_POST['id']):null;

	if ($id == null) throw new Exception("Elemento não encontrado");
	
	$item = DB::queryFirstRow("SELECT status FROM " . $table . " WHERE id = %s ", $id);
	$status = ($item['status'])?0:1;
	
	DB::update($table, array('status' => $status), "id=%s", $id);
	
	echo json_encode(array('status' => 1));
	
} catch (Exception $e) {
	echo json_encode(array(
		'status' => 0,
		'message' => $e->getMessage()
	));
}


?>