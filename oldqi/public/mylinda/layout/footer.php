			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?= $path ?>/js/vendor/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="<?= $path ?>/js/vendor/jquery.ui.touch-punch.min.js"></script>
<script type="text/javascript" src="<?= $path ?>/js/vendor/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= $path ?>/js/vendor/moment.js"></script>
<script type="text/javascript" src="<?= $path ?>/js/vendor/bootstrap-deatetimepicker.js"></script>

<script type="text/javascript" src="<?= $path ?>/js/vendor/material.min.js"></script>
<script type="text/javascript" src="<?= $path ?>/js/vendor/ripples.min.js"></script>

<script type="text/javascript" src="<?= $path ?>/js/utils.js"></script>

<iframe id="iframe-ajax" name="iframe-ajax"  style="display:none;"></iframe>
<script type="text/javascript">
	$(document).ready(function() {
		$('button[data-loading-text]').click(function () {
		    $(this).button('loading');
		});

		$.material.init();
		
		for (var f in initFuncs) initFuncs[f]();
	});
</script>
</body>
</html>
