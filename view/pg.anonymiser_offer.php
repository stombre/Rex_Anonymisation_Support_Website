<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body" id="modal_content">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary">Confirmer</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
		<div id="rules_list" class="panel-body">
			<h1>Rules</h1>
		</div>
	</div>
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
<script type="text/javascript">
var local_storage = new Array();
function anonymisation(table, column, type)
{
	if(typeof local_storage[table] == 'undefined'){
		$("#rules_list").append('<div class="panel panel-default"><div class="panel-body" id="table_'+table+'"><h3>'+table+'</h3></div></div>');
		local_storage[table] = new Array();
	}
	if(typeof local_storage[table][column] == 'undefined'){
		$("#table_"+table).append('<div class="panel panel-default"><div class="panel-body"><h4>'+column+'</h4><ul id="column_'+column+'"></ul></div></div>');
		local_storage[table][column] = new Array();
	}
	$("#column_"+column).append('<li>'+type+'</li>');
	$("#myModalLabel").html(table + ' - ' + column);
	$('#myModal').modal();
}
</script>