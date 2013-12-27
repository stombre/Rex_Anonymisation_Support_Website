<?php
	$bdd_url = $_POST['bdd_address'];
	$bdd_name = $_POST['bdd_name'];
	$bdd_username = $_POST['bdd_username'];
	$bdd_password = $_POST['bdd_password'];

	if($bdd_name == ''){
		throw new ErrorException('Undefined database name.');
	}
	$PDO = new PDO('mysql:host='.$bdd_url.';dbname='.$bdd_name, $bdd_username, $bdd_password);
	$q = $PDO -> query('SHOW TABLES;');
	$tables = array();
	while($d = $q -> fetch())
	{
		array_push($tables, new table_analyser($PDO, $d[0]));
	}
	$q->closeCursor();
	$content_html = '';
	$list_html = '';
	$id_form = 0;
	
	$POST_DATA = '<input type="hidden" name="dburl" value="'.$bdd_url.'"/>';
	$POST_DATA .= '<input type="hidden" name="dbname" value="'.$bdd_name.'"/>';
	$POST_DATA .= '<input type="hidden" name="dbusername" value="'.$bdd_username.'"/>';
	$POST_DATA .= '<input type="hidden" name="dbpassword" value="'.$bdd_password.'"/>';
	foreach($tables as $t)
	{
		$num = $t->getNbColumn();
		$list_html .= '<li><a href="#'.$t->getName().'"><span class="badge pull-right">'.$num.'</span>'.$t->getName().'</a></li>';
		$content_html .= '<div id="'.$t->getName().'" class="panel panel-default"><div class="panel-body"><h2>'.$t->getName().'</h2><div class="list-group">';
		for($i = 0; $i < $num; $i++){
			if($t->getColumKey($i) == 'PRI'){$prim = ' <span style="color:red;">(PRIMARY KEY)</span>';$check = '';}
			else
			{
				if($t->getColumKey($i)!=''){
					$prim = '<span style="color:blue;">('.$t->getColumKey($i).')</span>';
				}
				else{
					$prim = '';
				}
				$check = '<input type="checkbox" name="'.$id_form.'"> Anonymiser<br/>';
				$data = array('table' => $t->getName(), 'column_name' => $t->getColumName($i), 'column_type'=> $t->getColumType($i), 'column_key'=> $t->getColumKey($i));
				$content_html .= '<input type="hidden" name = "dt_'.$id_form.'" value=\''.json_encode($data).'\'/>';
			}
			$content_html .= '<a class="list-group-item"><h4 class="list-group-item-heading">'.$t->getColumName($i).$prim.'</h4>';
			$content_html .= '<p class="list-group-item-text"><b>'.$t->getColumType($i).'</b><br/>'.$check.'</p></a>';
			$id_form++;
		}
		$content_html .= '</div></div></div>';
	}
?>