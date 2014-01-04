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
foreach($_POST as $key => $val)
{
	if(substr($key, 0, 4) == 'rule')
	{
		$data = explode(';;', $val);
		$rule = $dom->createElement('rule_' . $data[2]);
		$rule -> setAttribute('target_table', $data[0]);
		$rule -> setAttribute('target_column', $data[1]);
		switch($data[2])
		{
			case 'variance_int', 'substitution_int':
				$min = $dom->createElement('min', $data[3]);
				$max = $dom->createElement('max', $data[4]);
				$rule -> appendChild($min);
				$rule -> appendChild($max);
				break;
			case '':
			
				break;
			case '':
			
				break;
		}
		$rules->appendChild($rule);
	}
}
$root->appendChild($BDD);
$root->appendChild($rules);
$dom->appendChild($root);

echo $dom->saveXML();
?>