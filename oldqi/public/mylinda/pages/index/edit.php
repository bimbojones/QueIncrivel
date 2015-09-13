<?php 

require_once realpath(dirname(__FILE__)) . '/includes/base.php';
require_once LIBRARY_PATH . 'Image.php';

$success = false;
$id = (isset($_GET['id']) && intval($_GET['id']) > 0)?intval($_GET['id']):null;
$id = (isset($_POST['id']) && intval($_POST['id']) > 0)?intval($_POST['id']):$id;

$errors = array();
$values = array();

$item = null;

if ($id != null) {
	$item = DB::queryFirstRow(" SELECT * FROM " . $table . " WHERE id = %i " , $id);
} else {
	$item = array(
		'id' => '',
		'slug' => '',
		'type' => '1',
		'social_id' => '4',
		'url' => '',
		'image' => '',
		'name' => '',
		'email' => '',
		'phone' => '',
		'card_id' => '',
		'app_user_id' => '',
		'app_user_name' => '',
		'status' => 0,
		'authorize_email' => ''
	);
	
	$item['create_date'] = date("Y-m-d H:i:s");
	DB::insert($table, $item);
	$id = DB::insertId();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	if (!isset($_POST['name']) || strlen($_POST['name']) == 0) {
		$errors['name'] = true;
	} else {
		$item['name'] = $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
	}
		
	if (!isset($_POST['status']) || strlen($_POST['status']) == 0) {
		$item['status'] = $status = 0;
	} else {
		$status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8');
		$item['status'] = $status = ($status == 'on')?1:0;
	}
	
	if (count($errors) == 0) {
		
		if ($id != null) DB::update($table, $item, " id = %i ", $id);		
		$success = true;
		unset($_POST);
	}
}

?>
<form role="form" method="post" enctype="multipart/form-data">
<div class="row">
	<div class="col-md-12">		
		<input type="hidden" id="id" name="id" value="<?= $id ?>" />
		<div class="row">
			<div class="form-group col-md-3 <?= isset($errors['name'])&&$errors['name']?"has-error":"" ?>">
				<label class="control-label" for="name">Título</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Insira o título" value="<?= $item['name'] ?>">
			</div>
			<div class="form-group col-md-3">
				<label class="control-label" for="status">Ativo</label>
				<input id="status" name="status" type="checkbox" <?= ($item['status'] == 1)?'checked="checked"':'' ?> class="form-control">
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-10"></div>
			<div class="col-md-1">
				<a href="<?= $path ?>/<?= $controller ?>"class="pull-right btn btn-primary">Voltar</a>					
			</div>
			<div class="col-md-1">
				<button type="submit" class="pull-right btn btn-primary">Gravar</button>
			</div>				
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php if ($success) { ?>
					<br/><span class="pull-right badge btn-success">Alteração efetuada com sucesso</span>
				<?php } else { ?>
				
				<?php } ?>
			</div>
		</div>
	</div>	
</div>

<script type="text/javascript">

initFuncs.push(function() {
	
});

</script>