<?php

/*
	Fichier de génération de fichier XML
*/

header ("Content-Type:text/xml");//On precise au navigateur que c'est un fichier XML et non une page

//On récupère les informations de la base de données :
$bdd_url = $_POST['dburl'];
$bdd_name = $_POST['dbname'];
$bdd_username = $_POST['dbusername'];
$bdd_password = $_POST['dbpassword'];

//On récupère le schéma de la base de données, et on le sauvegarde :
$PDO = new PDO('mysql:host='.$bdd_url.';dbname='.$bdd_name, $bdd_username, $bdd_password);
$query = $PDO -> query('SHOW TABLES;');
$create_tables = '';
while($data = $query -> fetch()){
	$table_name = $data[0];
	$sb_query = $PDO -> query('SHOW CREATE TABLE `'.$table_name.'`;');
	$data = $sb_query->fetch();
	$txt = str_replace('`'.$table_name.'`', '`REX_'.$table_name.'`', $data[1]);
	$create_tables .= $txt . ';';
	$sb_query -> closeCursor();
}
$query -> closeCursor();

//Creation du XML :
$dom = new DOMDocument('1.0', 'iso-8859-1');

$root = $dom->createElement('anonymisation');//Noeud ROOT
$BDD = $dom->createElement('bdd', $create_tables);//Contient une requête SQL pour générer la base de données
$rules = $dom->createElement('rules');//Contient les règles

foreach($_POST as $key => $val)//Traitement une à une, des règles saisies par l'utilisateur :
{
	if(substr($key, 0, 4) == 'rule')
	{
		$data = explode(';;', $val);
		$rule = $dom->createElement('rule_' . $data[2]);
		$rule -> setAttribute('target_table', $data[0]);
		$rule -> setAttribute('target_column', $data[1]);
		switch($data[2])
		{
			case 'variance_int':
			case 'substitution_int':
				$min = $dom->createElement('min', $data[3]);
				$max = $dom->createElement('max', $data[4]);
				$rule -> appendChild($min);
				$rule -> appendChild($max);
				break;
			case 'commandSQL':
				$rule = $dom->createElement('rule_' . $data[2], $data[3]);
				$rule -> setAttribute('target_table', $data[0]);
				$rule -> setAttribute('target_column', $data[1]);
				break;
			case 'concatenation':
				$concat = explode(',', $data[3]);
				foreach($concat as $c)
				{
					$element = $dom->createElement('column', $c);
					$rule -> appendChild($element);
				}
				break;
			case 'masking':
				$length_no_cover = $dom->createElement('displayed_length', $data[3]);
				$cover = $dom->createElement('covered', $data[4]);
				$rule -> appendChild($length_no_cover);
				$rule -> appendChild($cover);
				break;
			case 'masking_mail':
				$length_before = $dom->createElement('displayed_length_before', $data[3]);
				$length_after = $dom->createElement('displayed_length_after', $data[4]);
				$rule -> appendChild($length_before);
				$rule -> appendChild($length_after);
				break;
			case 'substitution_date':
				$mask = $dom->createElement('mask', $data[3]);
				$min = $dom->createElement('min', $data[4]);
				$max = $dom->createElement('max', $data[5]);
				$rule -> appendChild($mask);
				$rule -> appendChild($min);
				$rule -> appendChild($max);
				break;
			case 'substitution_string':
				$dico = $dom->createElement('dictionnaryID', $data[3]);
				$rule -> appendChild($dico);
				break;
		}
		$rules->appendChild($rule);
	}
}
$root->appendChild($BDD);
$root->appendChild($rules);
$dom->appendChild($root);

echo $dom->saveXML();//Affichage du XML
?>