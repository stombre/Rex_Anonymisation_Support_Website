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
			include('./model/step1_show_database.php');
			break;
		case 'proposition':
			$page = 'pg.anonymiser_offer.php';
			include('./core/bdd_analyser.php');
			include('./core/column_analyser.php');
			include('./model/step2_show_offer.php');
			break;
		case 'xml_upload':
			$page = 'pg.xml_upload.php';
			break;
		case 'put_xml':
			$page = 'pg.xml_result.php';
			include('./model/xml_run.php');
			break;
		case 'xml':
			$page = '';
			include('./model/step3_generate_XML.php');
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
if($page != ''){
	include('./view/tpl.header.php');
	include('./view/'.$page);
	include('./view/tpl.footer.php');
}
?>
