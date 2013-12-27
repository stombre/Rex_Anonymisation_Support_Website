<div class="alert alert-info"><h3>Proposition d'anonymisation</h3>
Voici les r&#232;gles qu'on vous propose pour anonymiser les colonnes que vous
voulez anonymiser dans votre base de donn&#234;es.<br/>
Vous pouvez choisir autant de r&#232;gles que vous le d&#233;sirer pour une m&#234;me colonne.
</div>
<form method="post" action="?p=xml">
<?php
	echo $html;
?>
	<div class="panel panel-default">
		<div class="panel-body text-center ">
			<div class="alert alert-info">
				Cette &#233tape va permettre de g&#233;n&#233;rer un fichier XML exploitable par REX XML execution.<br/>
				Pour enregistrer facilement le r&#233;sultat, faites un clic droit sur le bouton &#231;i dessous, puis s&#233;l&#233;ctionner enregistrez sous.
			</div>
			<button type="submit" class="btn btn-default btn-lg">T&#234;l&#234;charger le fichier XML</button>
		</div>
	</div>
</form>