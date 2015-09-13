<?php

require_once LIBRARY_PATH . 'PHPExcel.php';

$showLayout = false;

try {
	if ($_SERVER['REQUEST_METHOD'] != 'POST') throw new Exception("Pedido inválido");
	
	if (!isset($_POST['password']) || strlen($_POST['password']) == 0) 
		throw new Exception('Tem de preencher a password');
	
	$password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
	$admin = DB::queryFirstRow(" SELECT id, username from admin WHERE id = %i_id AND password = MD5(CONCAT(%s_password, salt)) ", 
		array(
			'id' => $_SESSION[$mysession]['id'], 
			'password' => $password)
	);
	
	if ($admin == null) 
		throw new Exception("Password inválida");
	
	$letters = range('A', 'Z');
	
	$name = get('n');
	$origin = get('o');
	$minDate = get('min');
	$maxDate = get('max');
	$slug = get('slug');
	$type = get('t');
	
	if (strtotime($minDate) === FALSE) $minDate = null;
	if (strtotime($maxDate) === FALSE) $maxDate = null;
	
	$field = get('field');
	$order = get('order');
	
	$order_by = "";
	
	if ($field == null) $order_by = 'create_date';
	else {
		if ($field == 'name') $order_by = 'p.name';
		else if ($field == 'social_id') $order_by = 'p.social_id';
		else if ($field == 'votes') $order_by = 'votes';
		else $order_by = 'create_date';
	}
	if ($order == null) $order_by .= ' desc';
	else {
		if ($order == 'asc') $order_by .= ' asc';
		else $order_by .= ' desc';
	}
	
	$sql = " WHERE 1 = 1 ";
	$data = array();
	
	if ($slug != null) {
	
		$sql .= " AND p.slug = %s_slug";
	
		if (strpos($slug, '/') !== FALSE) $slug = substr(strrchr($slug, '/'), 1);
		$data['slug'] = $slug;
	
		$name = $origin = $minDate = $maxDate = null;
	
	} else {
		if ($name != null) {
			$sql .= " AND p.name LIKE %s_name";
			$data['name'] = "%".$name."%";
		}
	
		if ($type != null && intval($type) > 0) {
			$sql .= " AND p.type = %i_type";
			$data['type'] = $type;
		}
	
		if ($origin != null && intval($origin) > 0) {
			$sql .= " AND p.social_id = %i_social_id";
			$data['social_id'] = $origin;
		}
	
		if ($minDate != null) {
			$sql .= " AND p.create_date > %s_min_date";
			$data['min_date'] = $minDate;
		}
	
		if ($maxDate != null) {
			$sql .= " AND p.create_date < %s_max_date";
			$data['max_date'] = $maxDate;
		}
	}
	
	$total = DB::queryFirstRow("SELECT COUNT(*) as total FROM game p " . $sql, $data);
	$count = $total['total'];
	
	$results = DB::query("
		SELECT
			p.*,
			(SELECT COUNT(*) FROM game_vote WHERE p.id = game_id) as votes, p.name
		FROM game p
			" . $sql . "
			ORDER BY $order_by ",
			$data
	);
	
	$instausers = DB::query("SELECT * FROM user WHERE instagram_id IS NOT NULL");
	$data = array();
	foreach($results as $result) {
		if (intval($result['social_id']) == 3) 
			foreach($instausers as $user) 
				if ($result['app_user_id'] == $user['instagram_id']) {
					$result['name'] = $user['name'];
					$result['email'] = $user['email'];
					$result['phone'] = $user['phone'];
					$result['card_id'] = $user['card_id'];
					$result['authorize_data'] = $user['authorize_data'];
					$result['authorize_email'] = $user['authorize_email'];
				}
		$data[] = $result;
	}
	$results = $data;
	
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("Backoffice " . $site_title)
								 ->setLastModifiedBy("Backoffice " . $site_title)
								 ->setTitle("Listagem de utilizadores")
								 ->setSubject("Listagem de utilizadores")
								 ->setDescription("Listagem de utilizadores");
								 
	$objPHPExcel->getActiveSheet()->setTitle('Simple');
	
	$line = 1;
	$letter = 0;
	
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue($letters[$letter++].$line, 'link')
				->setCellValue($letters[$letter++].$line, 'tipo')
				->setCellValue($letters[$letter++].$line, 'tipo social')
				->setCellValue($letters[$letter++].$line, 'votos')
				->setCellValue($letters[$letter++].$line, 'nome')
				->setCellValue($letters[$letter++].$line, 'email')
				->setCellValue($letters[$letter++].$line, 'telefone')
				->setCellValue($letters[$letter++].$line, 'cartão continente')
				->setCellValue($letters[$letter++].$line, 'autorizou dados')
				->setCellValue($letters[$letter++].$line, 'autorizou envio de email')
				->setCellValue($letters[$letter++].$line, 'estado')
				->setCellValue($letters[$letter++].$line, 'data de criação');
	
	if ($results != null) 
		foreach ($results as $row) {
			$letter = 0;
			$line++;
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue($letters[$letter++].$line, "http://" . $_SERVER['SERVER_NAME'] . str_replace('/backoffice', '', $path) . '/#galeria/' . $row['slug'])
				->setCellValue($letters[$letter++].$line, itemType($row['type']))
				->setCellValue($letters[$letter++].$line, type($row['social_id']))				
				->setCellValue($letters[$letter++].$line, $row['votes'])
				->setCellValue($letters[$letter++].$line, $row['name'])
				->setCellValue($letters[$letter++].$line, $row['email'])
				->setCellValue($letters[$letter++].$line, $row['phone'])
				->setCellValue($letters[$letter++].$line, $row['card_id'])
				->setCellValue($letters[$letter++].$line, (intval($row['authorize_data'])?"Sim":"Não"))
				->setCellValue($letters[$letter++].$line, (intval($row['authorize_email'])?"Sim":"Não"))
				->setCellValue($letters[$letter++].$line, (intval($row['status'])?"Ativo":"Inativo"))
				->setCellValue($letters[$letter++].$line, $row['create_date']);
		}
		
	// Redirect output to a client’s web browser (Excel5)		
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'. date('Y-m-d H:i') . '_continentetv.xls"');
	header('Cache-Control: max-age=1');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	
} catch (Exception $e) {
	echo $e->getMessage();	
}

?>
