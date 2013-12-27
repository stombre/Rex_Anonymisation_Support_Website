<div class="alert alert-info"><h3>Contenus de votre base</h3>
Voici le contenus de votre base de donn&#233;es.<br/>
Veuillez selectionner les champs que vous d&#233;sirez anonymiser.
</div>
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