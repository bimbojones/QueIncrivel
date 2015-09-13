<?php
/*
require_once realpath(dirname(__FILE__)) . '/includes/base.php';

$page = (isset($_GET['p']) && intval($_GET['p']) > 0)?intval($_GET['p']):1;
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
$data = array('p' => ($page-1) * $limit, 'limit' => $limit);

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

$total = DB::queryFirstRow("SELECT COUNT(*) as total FROM " . $table . " p " . $sql, $data);
$count = $total['total'];

$results = DB::query("
		SELECT 
			p.*, 
			(SELECT COUNT(*) FROM game_vote WHERE p.id = game_id) as votes, p.name,
			case when exists (select * from user u where p.social_id = 3 AND u.instagram_id = p.app_user_id ) then 1 else 0 end as instagram 
		FROM " . $table . " p 
			" . $sql . "
		ORDER BY $order_by LIMIT %i_p,%i_limit ",
	$data
);
*/
$results = null;
?>

<div class="row">
	<div class="form-group col-md-4">
		<label class="control-label">Nome: </label>
        <input id='name' name='name' placeholder="Nome" type='text' class="form-control typeahead" value="<?= $name ?>" />
    </div>
    <div class="form-group col-md-4">
    	<label class="control-label">A partir de: </label>
        <div class='input-group date' id='datepicker-min'>
        	<input id='min' name='min' placeholder="Insira a data de inicio" value="<?= $minDate ?>" type='text' class="form-control" data-date-format="YYYY-MM-DD HH:mm" />
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    </div>
    <div class="form-group col-md-4">
    	<label class="control-label">Até: </label>
        <div class='input-group date' id='datepicker-max'>
        	<input id='max' name='max' placeholder="Insira a data de fim" value="<?= $maxDate ?>" type='text' class="form-control" data-date-format="YYYY-MM-DD HH:mm" />
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
        </div>
    </div>
</div>
<div class="row">
	<div class="form-group col-md-2">
		<label class="control-label">Tipo: </label>
		<div class="dropdown">
			<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"><?= itemType($type) ?><span class="caret"></span></button>
			<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
				<li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="javascript:changePage(1, null, null, null, null, null, null, 0);"><?= itemType(0) ?></a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="javascript:changePage(1, null, null, null, null, null, null, 1);"><?= itemType(1) ?></a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="javascript:changePage(1, null, null, null, null, null, null, 2);"><?= itemType(2) ?></a></li>
			</ul>
		</div>
	</div>
	<div class="form-group col-md-2">
			<label class="control-label">Origem: </label>
			<div class="dropdown">
				<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"><?= type($origin) ?><span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
					<li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="javascript:changePage(1, null, null, null, 0);"><?= type(null) ?></a></li>
					<li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="javascript:changePage(1, null, null, null, 1);">Facebook</a></li>
					<li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="javascript:changePage(1, null, null, null, 3);">Instagram</a></li>
					<li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="javascript:changePage(1, null, null, null, 6);">Youtube</a></li>
					<li role="presentation"><a role="menuitem" tabindex="-1" href="#" onclick="javascript:changePage(1, null, null, null, 4);">Upload</a></li>
				</ul>
			</div>
		</div>
		<div class="form-group col-md-4">
			<label class="control-label">Link: </label>
	        <input id='slug' name='slug' placeholder="Url da galeria" type='text' class="form-control" />
	    </div>
	    <div class="form-group col-md-4">
	        <label class="control-label">&nbsp;</label><br/>
	        <a class="btn btn-default btn-raised" href="<?= $path ?>/<?= $controller ?>">Reset</a>
	 		<button type="button" class="btn btn-default btn-raised" onclick="javascript:Search();">Pesquisar</button>
	 		<button type="button" class="btn btn-default btn-raised" href="#list-modal" data-toggle="modal">Download de participações</button>
		</div>
	</div>
    <table class="table table-striped table-bordered table-hover table-condensed">
		<thead>
			<tr>
				<th>Imagem</th>
				<th onclick="javascript:sort('name');">Nome<span
					class="<?= sort_class('name', $field, $order); ?> pull-right"></span></th>
				<th onclick="javascript:sort('social_id');">Origem<span
					class="<?= sort_class('social_id', $field, $order); ?> pull-right"></span></th>
				<th onclick="javascript:sort('votes');">Votos<span
					class="<?= sort_class('votes', $field, $order); ?> pull-right"></span></th>
				<th onclick="javascript:sort('create_date');">Data de criação<span
					class="<?= sort_class('create_date', $field, $order); ?> pull-right"></span></th>
				<th>Opções</th>
			</tr>
		</thead>
		<tbody>
			<?php if ($results != null)
					foreach ( $results as $item ) { ?>
				<tr id="item-<?= $item['id'] ?>">
				<td><img width="150" src="<?= $item['image'] ?>"
					class="img-thumbnail" /></td>
				<td><?= $item['name'] ?></td>
				<td><?= type($item['social_id']) ?> <?= ($item['social_id']==3)?(($item['instagram']==1)?"<span class='label label-success'>Utilizador validado</span>":"<span class='label label-danger'>Utilizador não validado</span>"):"" ?></td>
				<td><?= $item['votes'] ?></td>
				<td><?= $item['create_date'] ?></td>
				<td><a class="btn btn-primary"
					href="<?= str_replace('/backoffice', '', $path) ?>/#galeria/<?= $item['slug'] ?>"
					target="_blank">Ver</a> <a class="btn btn-default"
					href="<?= $path ?>/<?= $controller ?>/edit?id=<?= $item['id'] ?>">Editar</a>
						<?php if ($item['status']) { ?>
							<button class="status btn btn-success"
						onclick="javascript:Status('<?= $item['id'] ?>');">Ativo</button>
						<?php } else { ?>
							<button class="status btn btn-default"
						onclick="javascript:Status('<?= $item['id'] ?>');">Inativo</button>
						<?php } ?>
						<a class="btn btn-danger"
					onclick="javascript:Remove('<?= $item['id'] ?>');">Remover</a></td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
	
	<?php 
		$total = floor($count / $limit) + (($count % $limit == 0)?0:1);
		include 'common/pager.php';
	?>






	
<div id="list-modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">&times;</button>
				<h4 class="modal-title">Download de participações</h4>
			</div>
			<div class="modal-body">
				<form id="list-form" target="_blank" class="form-vertical" role="form" method="post" action="<?= $path ?>/index/list?<?= $_SERVER['QUERY_STRING'] ?>" 
					onsubmit="javascript:$('#list-modal #password').val(hex_md5_not_empty($('#list-modal #proxy_password').val()));$('#list-modal #proxy_password').val('');">
					<input type="hidden" id="password" name="password" />
				</form>
				<div class="form-group <?= (isset($errors['username']))?"has-error":""; ?>">
					<label class="control-label" for="password">Password de utilizador: </label>
					<input class="form-control" id="proxy_password" name="proxy_password" type="password" placeholder="Password" value="" />
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
				<button id="ok-button" class="btn btn-primary"
					onclick="javascript:$('#list-form').submit();$('#list-modal').modal('hide');">Download</button>
			</div>
		</div>
	</div>
</div>

<script>
var currentPage = <?= $page ?>;
var currentName = "<?= $name ?>";
var currentOrigin = "<?= $origin ?>";
var currentMinDate = "<?= $minDate ?>";
var currentMaxDate = "<?= $maxDate ?>";
var currentField = "<?= $field ?>";
var currentOrder = "<?= $order ?>";
var currentType = "<?= $type ?>";
var changePage = function(p, n, min, max, o, field, order, type) {
	var q = "?p=" + ((p == null)?currentPage:p);
	
	q += "&n=" + ((n == null)?currentName:n);
	q += "&o=" + ((o == null)?currentOrigin:o);
	q += "&min=" + ((min == null)?currentMinDate:min);
	q += "&max=" + ((max == null)?currentMaxDate:max);
	q += "&field=" + ((field == null)?currentField:field);
	q += "&order=" + ((order == null)?currentOrder:order);
	q += "&t=" + ((type == null)?currentType:type);
	
	window.location = "<?= $path ?>/<?= $controller ?>" + q;
};
var sort = function(field) {
	changePage(1, null, null, null, null, field, (currentField != field || currentOrder == 'asc')?'desc':'asc');
}

var Status = function(id) {
	$.ajax({
		url: '<?= $path ?>/<?= $controller ?>/status',
		type : 'post',
		dataType : 'json',
		data: {'id': id},
		success : function(response) {
			if (response.status == 1) {
				var item = $('#item-' + id + ' .status');
				if (item.hasClass('btn-success'))
					item.removeClass('btn-success').addClass('btn-default').html('Inativo');
				else
					item.removeClass('btn-default').addClass('btn-success').html('Ativo');
			} else {
				Alert(response.message);
			}
		},
		error : function(response) {
			Alert("Erro a alterar estado");
		}
	});
};

var Remove = function(id) {
	$.ajax({
		url: '<?= $path ?>/<?= $controller ?>/remove',
		type : 'post',
		dataType : 'json',
		data: {'id': id},
		success : function(response) {
			window.location.reload();
		},
		error : function(response) {
			Alert("Erro a remover");
		}
	});	
};

var Search = function() {
	if ($('#slug').val() && $('#slug').val().length > 0) {
		window.location = "<?= $path ?>/?slug=" + encodeURIComponent($('#slug').val()); 
	} else {
		changePage(
				1,
				($('#name').val() && $('#name').val().length > 0)?$('#name').val():"",
				($('#min').val() && $('#min').val().length > 0)?$('#min').val():"",
				($('#max').val() && $('#max').val().length > 0)?$('#max').val():""
			);
	}
};

$(document).ready(function() {
	$( ".typeahead" ).autocomplete({
		source: '<?= $path ?>/<?= $controller ?>/names',
		minLength: 1
   	});
   	
	$('#datepicker-min, #datepicker-max').datetimepicker({
		minuteStepping: 5,  
		sideBySide: true
	});

	$('#name, #slug, #datepicker-min, #datepicker-max').on('keyup', function(e) {
	    if (e.which == 13) {
	        e.preventDefault();
	        Search();
	    }
	});
});

</script>
