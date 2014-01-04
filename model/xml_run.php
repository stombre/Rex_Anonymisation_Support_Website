<?php
	$xml_name = $_FILES['xml']['tmp_name'];
	$db_url = $_POST['db_url'];
	$db_name = $_POST['db_name'];
	$db_username = $_POST['db_id'];
	$db_password = $_POST['db_pass'];
	
	$xml = simplexml_load_file($xml_name);
	$PDO = new PDO('mysql:host='.$db_url.';dbname='.$db_name, $db_username, $db_password);
	$PDO -> query($xml->bdd);
	foreach ($xml->rules->children() as $rule)
	{
		switch($rule->getName())
		{
				
		}
	}
?>