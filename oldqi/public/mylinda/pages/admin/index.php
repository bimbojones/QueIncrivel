<?php

require_once realpath(dirname(__FILE__)) . '/includes/base.php';

$page = (isset($_GET['p']) && intval($_GET['p']) > 0)?intval($_GET['p']):1;
$name = get('n');

$field = get('field');
$order = get('order');

$order_by = "";

if ($field == 'name') $order_by = 'p.name';
else $order_by = 'create_date';

if ($order == null) $order_by .= ' desc'; 
else {
	if ($order == 'asc') $order_by .= ' asc';
	else $order_by .= ' desc';
}

$sql = " WHERE 1 = 1 ";
$data = array('p' => ($page-1) * $limit, 'limit' => $limit);

if ($name != null) {
	$sql .= " AND p.name LIKE %s_name";
	$data['name'] = "%".$name."%";
}
	
$total = DB::queryFirstRow("SELECT COUNT(*) as total FROM " . $table . " p " . $sql, $data);
$count = $total['total'];

$results = DB::query(" SELECT p.*, p.name FROM " . $table . " p " . $sql . " ORDER BY $order_by LIMIT %i_p,%i_limit ", $data);

?>

<div class="row">
	<div class="form-group col-md-8">
		<label class="control-label">Nome: </label>
        <input id='name' name='name' placeholder="Nome" type='text' class="form-control typeahead" value="<?= $name ?>" />
    </div>
    <div class="form-group col-md-4">
        <label class="control-label">&nbsp;</label><br/>
        <div class="btn-group  pull-right">
        	<a class="btn btn-default" href="<?= $path ?>/<?= $controller ?>">Reset</a>
 			<button type="button" class="btn btn-default" onclick="javascript:Search();">Pesquisar</button>       		
       	</div>
	</div>
</div>

<table class="table table-striped table-bordered table-hover table-condensed">
	<thead>
		<tr>
			<th onclick="javascript:sort('name');">Nome<span
				class="<?= sort_class('name', $field, $order); ?> pull-right"></span></th>
			<th onclick="javascript:sort('create_date');">Data de criação<span
				class="<?= sort_class('create_date', $field, $order); ?> pull-right"></span></th>
			<th>Opções</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($results != null)
				foreach ( $results as $item ) { ?>
			<tr id="item-<?= $item['id'] ?>">
			<td><?= $item['name'] ?></td>
			<td><?= $item['create_date'] ?></td>
			<td>
				<a class="btn btn-default" href="<?= $path ?>/<?= $controller ?>/edit?id=<?= $item['id'] ?>">Editar</a>
					<?php if ($item['status']) { ?>
						<button class="status btn btn-success"
					onclick="javascript:Status('<?= $item['id'] ?>');">Ativo</button>
					<?php } else { ?>
						<button class="status btn btn-default"
					onclick="javascript:Status('<?= $item['id'] ?>');">Inativo</button>
					<?php } ?>
			</tr>
		<?php } ?>
	</tbody>
</table>
<?php 

	$total = floor($count / $limit) + (($count % $limit == 0)?0:1);
	include 'common/pager.php';?>

<script>
var currentPage = <?= $page ?>;
var currentName = "<?= $name ?>";
var currentField = "<?= $field ?>";
var currentOrder = "<?= $order ?>";

var changePage = function(p, n, min, max, o, field, order, type) {
	var q = "?p=" + ((p == null)?currentPage:p);
	
	q += "&n=" + ((n == null)?currentName:n);
	q += "&field=" + ((field == null)?currentField:field);
	q += "&order=" + ((order == null)?currentOrder:order);
	
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
	changePage(
		1,
		($('#name').val() && $('#name').val().length > 0)?$('#name').val():""
	);
};

$(document).ready(function() {
	$( ".typeahead" ).autocomplete({
		source: '<?= $path ?>/<?= $controller ?>/names',
		minLength: 1
   	});
   	
	$('#name').on('keyup', function(e) {
	    if (e.which == 13) {
	        e.preventDefault();
	        Search();
	    }
	});
});

</script>
