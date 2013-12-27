
<?php
$columns = array();
foreach($_POST as $k => $p)
{
	if(substr($k, 0, 2) != 'dt')
	{
		array_push($columns, json_decode($_POST['dt_'.$k]));
	}
}
$html = '';
foreach($columns as $obj)
{
	$html .= '<div class="panel panel-default"><div class="panel-body">';
	$html .= '<h2>' . $obj->table . '.' . $obj->column_name . '</h2>';
	$analyse = new column_analyser($obj->column_name, $obj->column_type, $obj->column_key);
	$html .= $analyse->getResult();
	$html .= '</div></div>';
}

?>
