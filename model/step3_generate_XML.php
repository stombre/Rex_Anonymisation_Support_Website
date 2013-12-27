<?php
header ("Content-Type:text/xml");



$bdd_url = $_POST['dburl'];
$bdd_name = $_POST['dbname'];
$bdd_username = $_POST['dbusername'];
$bdd_password = $_POST['dbpassword'];
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


$dom = new DOMDocument('1.0', 'iso-8859-1');

$root = $dom->createElement('anonymisation');
$BDD = $dom->createElement('bdd', $create_tables);
$rules = $dom->createElement('rules');
$root->appendChild($BDD);
$root->appendChild($rules);
$dom->appendChild($root);

echo $dom->saveXML();
?>