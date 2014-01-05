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
Voici les r&#232;gles que l'on vous propose pour anonymiser les colonnes que vous
voulez dans votre base de donn&#234;es.<br/>
Vous pouvez choisir autant de r&#232;gles que vous le d&#233;sirez pour une m&#234;me colonne.
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
var list_index = 0

//On modal confirmation :
function modal_click()
{
	if(modal_fct != 0){
		modal_fct();
	}
}

function form_add_rule(column, txt)
{
	var nav = '<a id="rule_n'+list_index+'_down"><i class="glyphicon glyphicon-circle-arrow-down"></i> Descendre</a>';
	nav += ' <i class="glyphicon glyphicon-minus"></i>';
	nav += ' <a id="rule_n'+list_index+'_up"><i class="glyphicon glyphicon-circle-arrow-up"></i> Monter</a>';
	nav += ' <i class="glyphicon glyphicon-minus"></i>';
	nav += ' <a id="rule_n'+list_index+'_remove"><i class="glyphicon glyphicon-remove"></i> Supprimer</a>';
	$("#column_"+column).append('<li id="rule_n'+list_index+'">' + txt + ' ' + nav + '</li>');
	$('#rule_n'+list_index+'_up').click(function(){
		$(this).parent().prev().before($(this).parent());
	});
	$('#rule_n'+list_index+'_down').click(function(){
		$(this).parent().next().after($(this).parent());
	});
	$('#rule_n'+list_index+'_remove').click(function(){
		$(this).parent().remove();
	});
	list_index += 1;
}

function modal_shuffle(table, column, type)
{
	modal_fct = function(){
		var value = table + ";;" + column + ";;" + type;
		form_add_rule(column, '<input type="hidden" name="rule_'+list_index+'" value="'+value+'"/>' + type);
	}
	var txt = "<b>Voulez-vous appliquez un shuffle sur cette colonne ?</b><br/><br/>";
	txt += "<p class='alert alert-info'><b>Shuffle</b><br/>Le shuffle m&#233;lange al&#233;atoirement les valeurs de la colonne.</p>";
	$("#modal_content").html(txt);
}

function modal_hash(table, column, type)
{
	modal_fct = function(){
		var value = table + ";;" + column + ";;" + type;
		form_add_rule(column, '<input type="hidden" name="rule_'+list_index+'" value="'+value+'"/>' + type);
	}
	var txt = "<b>Voulez-vous appliquez un hash sur cette colonne ?</b><br/><br/>";
	txt += "<p class='alert alert-info'><b>Hash</b><br/>La fonction de hash applique un SHA1 sur chacune des valeurs de la colonne.</p>";
	$("#modal_content").html(txt);
}

function modal_sql(table, column, type)
{
	modal_fct = function(){
		var sql = $("#modal_sql").val();
		var value = table + ";;" + column + ";;" + type + ";;" + sql;
		form_add_rule(column, '<input type="hidden" name="rule_'+list_index+'" value="'+value+'"/>' + type + ' : '+sql);
	}
	var txt = "<b>Voulez-vous appliquez une commande SQL sur cette colonne ?</b><br/><br/>";
	txt += "<input type='text' id='modal_sql'/><br/><br/>";
	txt += "<p class='alert alert-info'><b>CommandeSQL</b><br/>";
	txt += "Ecrivez une commande SQL, tel que SHA1(nom_table.nom_colonne)</p>";
	$("#modal_content").html(txt);
}

function modal_sub_string(table, column, type)
{
	modal_fct = function(){
		var dic = $("#modal_substring").val();
		var value = table + ";;" + column + ";;substitution_string;;"+dic;
		form_add_rule(column, '<input type="hidden" name="rule_'+list_index+'" value="'+value+'"/>' + type + ' ('+dic+')' );
	}
	var txt = "<b>Voulez-vous appliquez une substitution de string sur la colonne ? Choix du dictionnaire :</b><br/><br/>";
	txt += "<select id='modal_substring'>";
	txt += "<option value='french_name'>Nom fran&#231;ais</option>";
	txt += "<option value='french_firstname_boy'>prenom fran&#231;ais masculin</option>";
	txt += "<option value='french_firstname_girl'>prenom fran&#231;ais feminin</option>";
	txt += "<option value='french_city'>Ville fran&#231;aise</option>";
	txt += "</select><br/><br/>";
	txt += "<p class='alert alert-info'><b>Substitution string</b><br/>";
	txt += "Va remplacer votre mot par un autre choisi al&#233;atoirement dans le dictionnaire.</p>";
	$("#modal_content").html(txt);
}

function modal_sub_int(table, column, type)
{
	modal_fct = function(){
		var min = $("#int_min").val();
		var max = $("#int_max").val();
		var value = table + ";;" + column + ";;substitution_int;;" + min + ';;' + max;
		form_add_rule(column,'<input type="hidden" name="rule_'+list_index+'" value="'+ value +'"/>' + type +' -> [' +min + " ; " + max + ']');
	}
	var txt = "<b>Voulez-vous appliquez une substitution d'entier sur la colonne ?</b><br/><br/>";
	txt += "Intervale : [ <input type='text' id='int_min' value='0'/> ; <input type='text' id='int_max' value='5'/> ]<br/><br/>";
	txt += "<p class='alert alert-info'><b>Substitution entier</b><br/>";
	txt += "Va remplacer votre nombre entier par un autre choisi al&#233;atoirement dans l'intervale de valeur fournis.</p>";
	$("#modal_content").html(txt);
	$('#int_min').change(function(){
		var min = parseInt($('#int_min').val());
		var max = parseInt($('#int_max').val());
		if(min >= max){
			$('#int_max').val(min + 1);
		}
	});
	$('#int_max').change(function(){
		var min = parseInt($('#int_min').val());
		var max = parseInt($('#int_max').val());
		if(min >= max){
			$('#int_min').val(max - 1);
		}
	});
}

function modal_sub_date(table, column, type)
{
	modal_fct = function(){
		var min = $("#date_min").val();
		var max = $("#date_max").val();
		var mask = $("#date_mask").val();
		var value = table + ";;" + column + ";;substitution_date;;" + mask + ';;' + min + ';;' + max;
		form_add_rule(column,'<input type="hidden" name="rule_'+list_index+'" value="'+value+'"/>' + type+' -> [' +min + " ; " + max + ']('+mask+')');
	}
	var txt = "<b>Voulez-vous appliquez une substitution de date sur la colonne ?</b><br/><br/>";
	txt += "Mask : <input type='text' id='date_mask' value='Y-m-d H:i:s'/><br/>";
	txt += "Intervale d&#233;but : <input type='text' id='date_min' value='1946-02-02 22:14:35'/> <br/>";
	txt += "Intervale fin : <input type='text' id='date_max' value='1994-12-31 23:55:55'/> ]<br/><br/>";
	txt += "<p class='alert alert-info'><b>Substitution date</b><br/>";
	txt += "Va remplacer votre date par une autre choisi al&#233;atoirement dans l'intervale de date fournis.<br/>";
	txt += "Pour le 'mask' : <br/>Le champ datetime de MySQL correspond &#224; Y-m-d H:i:s<br/>";
	txt += "Le champ time de mysql correspond &#224; H:i:s<br/>Le champ date de mysql correspond &#224; Y-m-d</p>";
	$("#modal_content").html(txt);
}

function modal_mask_str(table, column, type)
{
	modal_fct = function(){
		var mask_lg = $("#mask_lg").val();
		var mask_val = $("#mask_val").val();
		var value = table + ";;" + column + ";;masking;;" + mask_lg + ';;' + mask_val;
		form_add_rule(column,'<input type="hidden" name="rule_'+list_index+'" value="'+value+'"/>' + type+' -> {'+mask_lg+'}'+ mask_val );
	}
	var txt = "<b>Voulez-vous appliquez un maskage de string sur la colonne ?</b><br/><br/>";
	txt += "<b>Longueur non mask&#233; :</b><br/>";
	txt += "<input type='text' id='mask_lg' value='3'/><br/>";
	txt += "<b>Valeur utilis&#233; pour masker :</b><br/>";
	txt += "<input type='text' id='mask_val' value='XXXX'/><br/><br/>";
	txt += "<p class='alert alert-info'><b>Maskage string</b><br/>";
	txt += "Va couvrir une partie de votre chaine par un mask d&#233;finis.<br/>";
	txt += "Ce qui donne pour la chaine 'petit test' => <span id='mask_test'>petXXXX</span></p>";
	$("#modal_content").html(txt);
	$('#mask_lg').change(function(){
		var text = "petit test";
		$('#mask_test').html(text.substr(0, $('#mask_lg').val()) + $('#mask_val').val());
	});
	$('#mask_val').change(function(){
		var text = "petit test";
		$('#mask_test').html(text.substr(0, $('#mask_lg').val()) + $('#mask_val').val());
	});
}

function modal_mask_mail(table, column, type)
{
	modal_fct = function(){
		var mask_before = $("#mask_lg_bef").val();
		var mask_after = $("#mask_lg_aft").val();
		var value = table + ";;" + column + ";;masking_mail;;" + mask_before + ';;' +mask_after;
		form_add_rule(column,'<input type="hidden" name="rule_'+list_index+'" value="'+value+'"/>' + type+' -> {'+mask_before+'}&#64;{'+mask_after+'}');
	}
	var txt = "<b>Voulez-vous appliquez un maskage de mail sur la colonne ?</b><br/><br/>";
	txt += "<b>Longueur non mask&#233; avant &#64; :</b><br/>";
	txt += "<input type='text' id='mask_lg_bef' value='3'/><br/>";
	txt += "<b>Longueur non mask&#233; apr&#232;s &#64; :</b><br/>";
	txt += "<input type='text' id='mask_lg_aft' value='3'/><br/><br/>";
	txt += "<p class='alert alert-info'><b>Maskage mail</b><br/>";
	txt += "Va couvrir une partie de l'adresse email.<br/>";
	txt += "Ce qui donne pour la chaine 'james.bond&#64;gmail.com' => <span id='mask_test'>jam...&#64;gma...</span></p>";
	$("#modal_content").html(txt);
	$('#mask_lg_bef').change(function(){
		var text = "james.bond"+String.fromCharCode(64)+"gmail.com";
		var lg_before = $('#mask_lg_bef').val();
		var lg_after = parseInt($('#mask_lg_aft').val()) + 1;
		$('#mask_test').html(text.substr(0, lg_before) + "..." + text.substr(text.indexOf(String.fromCharCode(64)), lg_after) + "...");
	});
	$('#mask_lg_aft').change(function(){
		var text = "james.bond"+String.fromCharCode(64)+"gmail.com";
		var lg_before = $('#mask_lg_bef').val();
		var lg_after = parseInt($('#mask_lg_aft').val()) + 1;
		$('#mask_test').html(text.substr(0, lg_before) + "..." + text.substr(text.indexOf(String.fromCharCode(64)), lg_after) + "...");
	});
}

function modal_concatenation(table, column, type)
{
	modal_fct = function(){
		var dic = $("#concat").val();
		var value = table + ";;" + column + ";;" + type + ';;' + dic;
		form_add_rule(column,'<input type="hidden" name="rule_'+list_index+'" value="'+value+'"/>' + type+' -> ('+dic+')');
	}
	var txt = "<b>Voulez-vous appliquez une concat&#233;nation de colonne ? Choix des colonnes &#224; concatener (s&#233;par&#233; par des ,) :</b><br/><br/>";
	txt += "<input type='text' id='concat'/><br/><br/>";
	txt += "<p class='alert alert-info'><b>Concat&#233;nation de colonne</b><br/>";
	txt += "Va placer les valeurs des colonnes pr&#233;&#231;iser en param&#232;tre &#224; la place de la valeur.</p>";
	$("#modal_content").html(txt);
}

function modal_var_int(table, column, type)
{
	modal_fct = function(){
		var min = $("#int_min").val();
		var max = $("#int_max").val();
		var value = table + ";;" + column + ";;variance_int;;" + min + ';;' + max;
		form_add_rule(column,'<input type="hidden" name="rule_'+list_index+'" value="' + value + '"/>' + type + ' -> [' + min + " ; " + max + ']');
	}
	var txt = "<b>Voulez-vous appliquez une variance d'entier sur la colonne ?</b><br/><br/>";
	txt += "Intervale : [ <input type='text' id='int_min' value='-2'/> ; <input type='text' id='int_max' value='2'/> ]<br/><br/>";
	txt += "<p class='alert alert-info'><b>Variance d'entier</b><br/>";
	txt += "Va additionn&#233; votre nombre par un nombre choisi al&#233;atoirement dans l'intervale.</p>";
	$("#modal_content").html(txt);
	$('#int_min').change(function(){
		var min = parseInt($('#int_min').val());
		var max = parseInt($('#int_max').val());
		if(min >= max){
			$('#int_max').val(min + 1);
		}
	});
	$('#int_max').change(function(){
		var min = parseInt($('#int_min').val());
		var max = parseInt($('#int_max').val());
		if(min >= max){
			$('#int_min').val(max - 1);
		}
	});
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
			modal_shuffle(table, column, type);
			break;
		case 'commandSQL':
			modal_sql(table, column, type);
			break;
		case 'sub_string':
			modal_sub_string(table, column, type);
			break;
		case 'sub_date':
			modal_sub_date(table, column, type);
			break;
		case 'sub_int':
			modal_sub_int(table, column, type);
			break;
		case 'hash':
			modal_hash(table, column, type);
			break;
		case 'var_int':
			modal_var_int(table, column, type);
			break;
		case 'mask_str':
			modal_mask_str(table, column, type);
			break;
		case 'mask_mail':
			modal_mask_mail(table, column, type);
			break;
		case 'concatenation':
			modal_concatenation(table, column, type);
			break;
		default:
			alert(type);
	}
	$('#myModal').modal();
}
</script>