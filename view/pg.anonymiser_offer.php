<div class="row">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked">
					<?php echo $list_html; ?>
				</ul>
			</div>
		</div>
	</div>
	<form method="post" action="?p=proposition">
		<div class="col-md-9">
			<?php echo $content_html; ?>
		</div>
		<button type="submit" class="btn btn-default">Confirm targets</button>
	</form>
</div>