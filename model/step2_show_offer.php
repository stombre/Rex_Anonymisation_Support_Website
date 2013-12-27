
<?php
$columns = array();
foreach($_POST as $k => $p)
{
	if(substr($k, 0, 2) != 'dt'&&substr($k, 0, 2) != 'db')
	{
		array_push($columns, json_decode($_POST['dt_'.$k]));
	}
}

$html = '<input type="hidden" name="dburl" value="'.$_POST['dburl'].'"/>';
$html .= '<input type="hidden" name="dbname" value="'.$_POST['dbname'].'"/>';
$html .= '<input type="hidden" name="dbusername" value="'.$_POST['dbusername'].'"/>';
$html .= '<input type="hidden" name="dbpassword" value="'.$_POST['dbpassword'].'"/>';
foreach($columns as $obj)
{
	$html .= '<div class="panel panel-default"><div class="panel-body">';
	$html .= '<h2>' . $obj->table . '.' . $obj->column_name . '</h2>';
	$analyse = new column_analyser($obj->column_name, $obj->column_type, $obj->column_key);
	$html .= $analyse->getResult();
	$html .= '</div></div>';
}

?>
