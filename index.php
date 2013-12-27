<?php
try{
	if(isset($_GET['p'])){
		$module = $_GET['p'];
	}else{
		$module = 'index';
	}
	switch($module)
	{
		case 'result':
			$page = 'pg.bdd_content.php';
			include('./core/bdd_analyser.php');
			include('./core/column_analyser.php');
			include('./model/result.php');
			break;
		case 'proposition':
			$page = 'pg.anonymiser_offer.php';
			include('./core/bdd_analyser.php');
			include('./core/column_analyser.php');
			include('./model/analyse_proposition.php');
			break;
		case 'about':
			$page = 'pg.about.php';
			break;
		default:
			$page = 'pg.bdd_log_in.php';
			break;
	}
}
catch(Exception $e)
{
	$page = 'pg.error.php';
	$ERROR = $e->getMessage();
}
include('./view/tpl.header.php');
include('./view/'.$page);
include('./view/tpl.footer.php');
?>
