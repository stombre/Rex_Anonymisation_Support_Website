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
        <button type="button" class="btn btn-primary" data-dismiss="modal" onClick = "modal_click();">Confirmer</button>
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
//Global variable :
var local_storage = new Array();
var modal_fct = 0;

//On modal confirmation :
function modal_click()
{
	if(modal_fct != 0){
		modal_fct();
	}
}

//Function used for changed the type of modal :
function modal_shuffle(type)
{
	modal_fct = function(){
		$("#column_"+column).append('<li>'+type+'</li>');
	}
	var txt = "<b>Voulez-vous appliquez un shuffle sur cette colonne ?</b><br/><br/>";
	txt += "<p class='alert alert-info'><b>Shuffle</b><br/>Le shuffle m&#233;lange al&#233;atoirement les valeurs de la colonne.</p>";
	$("#modal_content").html(txt);
}

function modal_sql(column, type)
{
	modal_fct = function(){
		var sql = $("#modal_sql").val();
		$("#column_"+column).append('<li>'+type+' -> '+sql+'</li>');
	}
	var txt = "<b>Voulez-vous appliquez une commande SQL sur cette colonne ?</b><br/><br/>";
	txt += "<input type='text' id='modal_sql'/><br/><br/>";
	txt += "<p class='alert alert-info'><b>CommandeSQL</b><br/>";
	txt += "Ecrivez une commande SQL, tel que SHA1(nom_table.nom_colonne)</p>";
	$("#modal_content").html(txt);
}

//Function called when the user click on one of the rule :
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

	$("#myModalLabel").html(table + ' - ' + column);
	switch(type)
	{
		case 'shuffle':
			modal_shuffle(type);
			break;
		case 'commandSQL':
			modal_sql(column, type);
			break;
		default:
			alert(type);
	}
	$('#myModal').modal();
}
</script>