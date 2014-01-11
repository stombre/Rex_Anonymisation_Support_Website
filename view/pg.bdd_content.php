<div class="alert alert-info"><h3>Contenu de votre base de donn&#233;es</h3>
Voici le contenu de votre base de donn&#233;es.<br/>
Veuillez selectionner les champs que vous d&#233;sirez anonymiser.
</div>
<div class="alert alert-warning">
Les cl&#233;s primaires ne pouvant &#234;tre anonymisées, veuillez ne pas selectionner des cl&#233;s &#233;trang&#232;res.<br/>
Sous risque de corrompre la base de donn&#233;es
</div>
<form method="post" action="?p=proposition">
	<?php echo $POST_DATA;?>
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
			<div class="col-md-9">
				<?php echo $content_html; ?>
			</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-body text-center ">
			<div class="alert alert-warning">
				Confirmer votre choix de colonne &#224; anonymiser ?
			</div>
			<button type="submit" class="btn btn-default btn-lg">Confirm targets</button>
		</div>
	</div>
</form>
