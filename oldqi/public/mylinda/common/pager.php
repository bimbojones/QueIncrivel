<?php

function pagerLink($p, $page) {
	if ($p < 1) return;
	?>
	<li <?= (($page == $p)?'class="active"':'') ?>><a onclick="javascript:changePage(<?= $p ?>);"><?= $p ?></a></li>
	<?php 
}

if ($total > 1) {
?><div class="row">
	<ul class="pagination pull-right" style="margin-right:15px;">
		<?php if ($page > 1) { ?><li><a onclick="javascript:changePage(<?= ($page - 1) ?>);">&laquo;</a></li><?php }
		
		if ($page - 3 > 1) {
			pagerLink(1, $page);
			?><li><a href="#">...</a></li><?php 
		}
		
		for($i = $page - 3; $i <= $total && $i <= $page + 3; $i++) 
			pagerLink($i, $page);
		
		if ($page + 3 < $total) {
			?><li><a href="#">...</a></li><?php
			pagerLink($total, $page);
		}
			
		if ($page <= $total-1) { ?><li><a onclick="javascript:changePage(<?= ($page + 1) ?>);">&raquo;</a></li><?php } ?>
	</ul>
</div>
<?php } ?>