<?php
if(isset($_GET['p'])){
	$module = $_GET['p'];
}else{
	$module = 'index';
}
switch($module)
{
	case 'result':
		include('./core/bdd_analyser.php');
		include('./core/column_analyser.php');
		include('./model/result.php');
		$page = 'pg.anonymiser_offer.php';
		break;
	case 'proposition':
		include('./core/bdd_analyser.php');
		include('./core/column_analyser.php');
		include('./model/analyse_proposition.php');
		$page = 'pg.bdd_content.php';
		break;
	default:
		$page = 'pg.bdd_log_in.php';
		break;
}

include('./view/tpl.header.php');
include('./view/'.$page);
include('./view/tpl.footer.php');
?>
