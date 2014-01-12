<?php
	$xml_name = $_FILES['xml']['tmp_name'];
	$db_url = $_POST['db_url'];
	$db_name = $_POST['db_name'];
	$db_username = $_POST['db_id'];
	$db_password = $_POST['db_pass'];
	
	$xml = simplexml_load_file($xml_name);
	$PDO = new PDO('mysql:host='.$db_url.';dbname='.$db_name, $db_username, $db_password);

	$PDO -> query($xml->bdd);
	$q = $PDO -> query('SHOW TABLES;');
	while($d = $q -> fetch())
	{
		$table = new Table($PDO, $d[0]);
		$select = $PDO -> query('SELECT * FROM '.$table->getName());
		$insert_str = '';
		for($i = 0; $i < $table->getNbColumn(); $i++)
		{
			if($i!=0){$insert_str.=',';}
			$insert_str .= '?';
		}
		$insert = $PDO -> prepare('INSERT INTO REX_'.$table->getName().' VALUES('.$insert_str.')');
		while($select_result = $select -> fetch())
		{
			$insert_data = array();
			for($i = 0; $i < $table->getNbColumn(); $i++){
				$insert_data[$i] = $select_result[$i];
			}
			$insert -> execute($insert_data);
		}
		$select->closeCursor();
	}
	$q->closeCursor();
	$anonymisation = new Anonymisation($PDO);
	$table_rapport = array();
	foreach ($xml->rules->children() as $rule)
	{
		$column = $rule['target_column'];
		$table = $rule['target_table'];
		switch($rule->getName())
		{
			case 'rule_variance_int':
				$anonymisation -> add_rule(new RuleVarianceInt($table, $column, $rule->min, $rule->max));
				if(in_array($table, $table_rapport) != true){$table_rapport[$table] = 0;}
				$table_rapport[$table]++;
				break;
			case 'rule_hash':
				$anonymisation -> add_rule(new RuleHash($table, $column));
				if(in_array($table, $table_rapport) != true){$table_rapport[$table] = 0;}
				$table_rapport[$table]++;
				break;
			case 'rule_shuffle':
				$anonymisation -> add_rule(new RuleShuffle($table, $column));
				if(in_array($table, $table_rapport) != true){$table_rapport[$table] = 0;}
				$table_rapport[$table]++;
				break;
			case 'rule_substitution_int':
				$anonymisation -> add_rule(new RuleSubstitutionInt($table, $column, $rule->min, $rule->max));
				if(in_array($table, $table_rapport) != true){$table_rapport[$table] = 0;}
				$table_rapport[$table]++;
				break;
			case 'rule_commandSQL':
				$anonymisation -> add_rule(new RuleCommand($table, $column, $rule));
				if(in_array($table, $table_rapport) != true){$table_rapport[$table] = 0;}
				$table_rapport[$table]++;
				break;
			case 'rule_concatenation':
				$cols_p = array();
				foreach($rule->children() as $cols){
					array_push($cols_p, $cols);
				}
				$anonymisation -> add_rule(new RuleConcatenation($table, $column, $cols_p));
				if(in_array($table, $table_rapport) != true){$table_rapport[$table] = 0;}
				$table_rapport[$table]++;
				break;
			case 'rule_masking':
				$anonymisation -> add_rule(new RuleMasking($table, $column, $rule->displayed_length, $rule->covered));
				if(in_array($table, $table_rapport) != true){$table_rapport[$table] = 0;}
				$table_rapport[$table]++;
				break;
			case 'rule_masking_mail':
				$anonymisation -> add_rule(new RuleMaskingMail($table, $column, $rule->displayed_length_before, $rule->displayed_length_after));
				if(in_array($table, $table_rapport) != true){$table_rapport[$table] = 0;}
				$table_rapport[$table]++;
				break;
			case 'rule_substitution_date':
				$anonymisation -> add_rule(new RuleSubstitutionDate($table, $column, $rule->mask, new DateTime($rule->min), new DateTime($rule->max)));
				if(in_array($table, $table_rapport) != true){$table_rapport[$table] = 0;}
				$table_rapport[$table]++;
				break;
			case 'rule_substitution_string':
				$param = array('');
				switch($rule->dictionnaryID)
				{
					case 'french_name':
						$param = RuleSubstitutionString::$FRENCH_NAME;
						break;
					case 'french_firstname_boy':
						$param = RuleSubstitutionString::$FRENCH_BOYFIRSTNAME;
						break;
					case 'french_firstname_girl':
						$param = RuleSubstitutionString::$FRENCH_GIRLFIRSTNAME;
						break;
					case 'french_city':
						$param = RuleSubstitutionString::$FRENCH_CITIES;
						break;
				}
				$anonymisation -> add_rule(new RuleSubstitutionString($table, $column, $param));
				if(in_array($table, $table_rapport) != true){$table_rapport[$table] = 0;}
				$table_rapport[$table]++;
				break;
		}
	}
	$anonymisation -> run();
?>