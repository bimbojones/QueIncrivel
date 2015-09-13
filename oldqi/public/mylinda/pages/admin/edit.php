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
					'name' => '',
					'username' => '',
					'email' => '',
					'password' => '',
					'level' => '10',
					'lang' => '0',
					'status' => 1
			);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	if (!isset($_POST['name']) || strlen($_POST['name']) == 0) {
		$errors['name'] = true;
	} else {
		$item['name'] = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
	}
	
	if (!isset($_POST['username']) || strlen($_POST['username']) == 0) {
		$errors['username'] = true;
	} else {
		$item['username'] = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
	}
	
	if (!isset($_POST['email']) || strlen($_POST['email']) == 0) {
		$errors['email'] = true;
	} else {
		$item['email'] = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
	}
	
	if (!isset($_POST['password']) || strlen($_POST['password']) == 0) {
		$errors['password'] = true;
	} else {
		$item['password'] = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
	}
		
	if (!isset($_POST['status']) || strlen($_POST['status']) == 0) {
		$item['status'] = 0;
	} else {
		$status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8');
		$item['status'] = ($status == 'on')?1:0;
	}
	
	if (count($errors) == 0) {
		
		$item['salt'] = md5(time() . rand(1, 100));
		$item['password'] = md5($item['password'] . $item['salt']);		
		
		if ($id != null) {
			DB::update($table, $item, " id = %i ", $id);		
		} else {			
			$item['create_date'] = date("Y-m-d H:i:s");
			DB::insert($table, $item);
			$id = DB::insertId();
		}
		$success = true;
		unset($_POST);
	}
}

?>
<form role="form" method="post" enctype="multipart/form-data" onsubmit="javascript:$('#password').val(hex_md5_not_empty($('#password').val()));">
<div class="row">
	<div class="col-md-12">
		<input type="hidden" id="id" name="id" value="<?= $id ?>" />
		<div class="row">
			<div class="form-group col-md-3 <?= isset($errors['name'])&&$errors['name']?"has-error":"" ?>">
				<label class="control-label" for="name">Nome</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Insira o nome" value="<?= $item['name'] ?>">
			</div>
			<div class="form-group col-md-3 <?= isset($errors['username'])&&$errors['username']?"has-error":"" ?>">
				<label class="control-label" for="username">Username</label>
				<input type="text" class="form-control" id="username" name="username" placeholder="Insira o username" value="<?= $item['username'] ?>">
			</div>
			<div class="form-group col-md-3 <?= isset($errors['email'])&&$errors['email']?"has-error":"" ?>">
				<label class="control-label" for="email">Email</label>
				<input type="text" class="form-control" id="email" name="email" placeholder="Insira o email" value="<?= $item['email'] ?>">
			</div>
			<div class="form-group col-md-3 <?= isset($errors['password'])&&$errors['password']?"has-error":"" ?>">
				<label class="control-label" for="name">Password</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Insira a password" value="">
			</div>			
		</div>
				
		<div class="row">
			<div class="col-md-10">
				<div class="form-group col-md-3">
					<label class="control-label" for="status">Ativo</label>
					<input id="status" name="status" type="checkbox" <?= ($item['status'] == 1)?'checked="checked"':'' ?> class="form-control">
				</div>
			</div>
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